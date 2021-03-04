<?php

namespace App\Http\Controllers;

use App\Traits\CustomerTrait;
use App\Traits\VoucherTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class PhotoController extends Controller
{
    use CustomerTrait, VoucherTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function validatePhotoSubmission(Request $request)
    {
        $api = new ApiController();
        $now = Carbon::now();
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'photo'      => 'required|image|mimes:jpeg,png,jpg|max:10000000',
                'customerId' => 'required|integer',
            ],
        );

        if ($validator->fails())
            throw new Exception(ucwords(implode(' | ', $validator->errors()->all())));

        $dataCustomer = $this->detailCustomer($params['customerId'], ["id"]);
        if (!$dataCustomer)
            throw new Exception("Data Customer Not Found");

        $hasBeenSubmit = $this->detailHasSubmitVoucher($params['customerId'], ['*']);
        if ($hasBeenSubmit)
            return response()->json([
                'status'  => "success",
                "message" => "Photo has been submitted and voucher has been generated.",
                "data"    => [
                    "voucherCode" => $hasBeenSubmit['code']
                ]
            ]);

        $dataVoucher = $this->detailVoucher($params['customerId'], ['*']);
        if (!$dataVoucher)
            throw new Exception("Voucher for this customer not found");

        $lockdownTime    = Carbon::parse($dataVoucher['lockdown_time']);
        $submissionTime  = Carbon::parse($dataVoucher['submission_time']);
        //  If the image recognition result return is true and the submission within 10 minutes, allocate the locked voucher to the customer and return the voucher code. 

        $withinRange     = $submissionTime->diffInMinutes($now);
        //API for image recognition
        $imageRecognition = $api->imageRecognition($params);

        if (!$imageRecognition || ($now > $lockdownTime)) {
            $this->setFreeVoucher($dataVoucher);
        }

        if ($imageRecognition & ($withinRange < env("LOCKDOWN_MINUTES")))
            $this->activateVoucher($dataVoucher);
        return response()->json([
            'status'  => "success",
            "message" => "Voucher has been generated.",
            "data"    => [
                "voucherCode" => $dataVoucher['code']
            ]
        ]);
    }
}
