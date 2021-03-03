<?php

namespace App\Http\Controllers;

use App\Jobs\VoucherJob;
use App\Traits\CustomerTrait;
use App\Traits\PurchaseTransactionTrait;
use App\Traits\VoucherTrait;
use Exception;

class CustomerController extends Controller
{
    use CustomerTrait, PurchaseTransactionTrait, VoucherTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function customerEligibleCheck($customerId)
    {
        $dataCustomer = $this->detailCustomer($customerId, ["id"]);
        if(!$dataCustomer)
            throw new Exception("Data Customer Not Found");

        $purchaseTransaction = $this->listWithinMonthByCustomer($customerId, ['*']);
        if(count($purchaseTransaction) < 3)
            throw new Exception("Must be complete 3 purchase transactions within the last 30 days.");

        $collectTransaction = collect($purchaseTransaction);
        $dataTransaction    = $collectTransaction->countBy("total_spent")->all();
        $totalTransaction   = array_sum(array_keys($dataTransaction));
        if($totalTransaction < 100)
            throw new Exception("Total transactions must be equal or more than $100");
    
        $checkVoucher = $this->listVoucherByCustomer($customerId, ['*']);
        if(count($checkVoucher) > 0)
            throw new Exception("Each customer is allowed to redeem 1 cash voucher only");
        
        //lock voucher for this customer
        $availableVoucher = $this->availableVoucher($customerId, ['*']);
        if(!$availableVoucher)
            throw new Exception("Voucher has been empty");

        $this->lockVoucher($customerId, $availableVoucher);
        return response()->json([
            'status'  => "success",
            "message" => "Voucher has been locked down a voucher for 10 minutes to this customer.",
        ]);
    }
}
