<?php

namespace App\Traits;

use App\Http\Helpers\Constant;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Carbon;

trait VoucherTrait
{
    public static function detailVoucher($customerId, array $selectedField)
    {
        $repo = new VoucherRepository();
        $repo->setCustomerId($customerId);
        $repo->setSelectedField($selectedField);
        return $repo->detail();
    }

    public static function availableVoucher(array $selectedField)
    {
        $repo = new VoucherRepository();
        $repo->setSelectedField($selectedField);
        return $repo->available();
    }

    public static function lockVoucher($customerId, $availableVoucher)
    {
        $now = Carbon::now();
        $availableVoucher->customer_id     = $customerId;
        $availableVoucher->submission_time = $now->toDateTimeString();
        $availableVoucher->lockdown_time   = $now->addMinutes(env('LOCKDOWN_MINUTES'))->toDateTimeString();
        $availableVoucher->is_locked       = Constant::VOUCHER_SUBMISSION;
        $availableVoucher->save();
    }
}
