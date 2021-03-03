<?php

namespace App\Traits;

use App\Repositories\VoucherRepository;

trait VoucherTrait
{
    public static function detailVoucher($customerId, array $selectedField)
    {
        $repo = new VoucherRepository();
        $repo->setCustomerId($customerId);
        $repo->setSelectedField($selectedField);
        return $repo->detail();
    }
}
