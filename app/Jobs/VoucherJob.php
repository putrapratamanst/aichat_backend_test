<?php

namespace App\Jobs;

use App\Http\Helpers\Constant;
use App\Traits\VoucherTrait;
use Illuminate\Support\Carbon;

class VoucherJob extends Job
{
    use VoucherTrait;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 3;
    public $timeout = 0;

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->usedVoucher(["*"]);
        if(count($data) > 0) {
            foreach ($data as $key => $value) {
                $now = Carbon::now();
                $lockdownTime = Carbon::parse($value->lockdown_time);
                // $totalDuration = $now->diffInMinutes($lockdownTime);
                if($now > $lockdownTime) {
                    $exception = json_decode($value->exception);
                    array_push($exception, $value->customer_id);
                    $value->exception       = json_encode($exception); 
                    $value->customer_id     = NULL;
                    $value->submission_time = NULL;
                    $value->lockdown_time   = NULL;
                    $value->is_locked       = Constant::VOUCHER_GENERATED;
                    $value->save();
                }
            }
        }

        return "Success";
    }
}
