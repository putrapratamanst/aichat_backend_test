<?php

namespace App\Traits;

use App\Repositories\PurchaseTransactionRepository;

trait PurchaseTransactionTrait
{
    public static function listWithinMonthByCustomer($customerId, array $selectedField)
    {
        $repo = new PurchaseTransactionRepository();
        $repo->setCustomerId($customerId);
        $repo->setSelectedField($selectedField);
        return $repo->listWithinLastMonth();
    }
}
