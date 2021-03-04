<?php

namespace App\Traits;

use App\Http\Helpers\Constant;
use App\Repositories\VoucherRepository;
use Illuminate\Support\Carbon;

trait VoucherTrait
{
    public static function listVoucherByCustomer($customerId, array $selectedField)
    {
        $repo = new VoucherRepository();
        $repo->setCustomerId($customerId);
        $repo->setSelectedField($selectedField);
        return $repo->listVoucher();
    }

    public static function availableVoucher($customerId, array $selectedField)
    {
        $repo = new VoucherRepository();
        $repo->setCustomerId($customerId);
        $repo->setSelectedField($selectedField);
        return $repo->available();
    }

    public static function usedVoucher(array $selectedField)
    {
        $repo = new VoucherRepository();
        $repo->setSelectedField($selectedField);
        return $repo->listUsed();
    }

    public static function detailVoucher($customerId, array $selectedField)
    {
        $repo = new VoucherRepository();
        $repo->setCustomerId($customerId);
        $repo->setSelectedField($selectedField);
        return $repo->detail();
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


    public static function activateVoucher($model)
    {
        $model->is_locked = Constant::VOUCHER_ACTIVE;
        $model->save();
    }


    public static function setFreeVoucher($model)
    {
        $exception = $model->exception;
        $exception .= $model->customer_id;
        $exception .= ",";

        $model->exception       = $exception;
        $model->customer_id     = NULL;
        $model->submission_time = NULL;
        $model->lockdown_time   = NULL;
        $model->is_locked       = Constant::VOUCHER_GENERATED;
        $model->save();

    }
}
