<?php

namespace App\Repositories;

use App\Http\Helpers\Constant;
use App\Models\Voucher;

class VoucherRepository
{
    private $customerId;
    private $selectedField;

    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
    }

    public function setSelectedField($selectedField)
    {
        $this->selectedField = $selectedField;
    }

    public function listVoucher()
    {
        return Voucher::select($this->selectedField)
            ->where('customer_id', $this->customerId)
            ->where('is_locked', Constant::VOUCHER_ACTIVE)
            ->orWhere('is_locked', Constant::VOUCHER_SUBMISSION)
            ->get();
    }

    public function available()
    {
        return Voucher::select($this->selectedField)
            ->where('is_locked', Constant::VOUCHER_GENERATED)
            ->where('customer_id', NULL)
            ->where('submission_time', NULL)
            ->where('lockdown_time', NULL)
            ->whereRaw("!FIND_IN_SET({$this->customerId},exception)")
            ->first();
    }

    public function detail()
    {
        return Voucher::select($this->selectedField)
            ->where('is_locked', Constant::VOUCHER_SUBMISSION)
            ->where('customer_id', $this->customerId)
            ->where('submission_time','!=', NULL)
            ->where('lockdown_time', '!=', NULL)
            ->whereRaw("!FIND_IN_SET({$this->customerId},exception)")
            ->first();
    }

    public function detailHasSubmit()
    {
        return Voucher::select($this->selectedField)
            ->where('is_locked', Constant::VOUCHER_ACTIVE)
            ->where('customer_id', $this->customerId)
            ->where('submission_time','!=', NULL)
            ->where('lockdown_time', '!=', NULL)
            ->first();
    }

    public function listUsed()
    {
        return Voucher::select($this->selectedField)
            ->where('is_locked', '!=', Constant::VOUCHER_GENERATED)
            ->where('customer_id', '!=', NULL)
            ->where('submission_time', '!=', NULL)
            ->where('lockdown_time', '!=', NULL)
            ->get();
    }
}
