<?php

namespace App\Traits;

use App\Repositories\CustomerRepository;

trait CustomerTrait
{
    public static function detailCustomer($customerId, array $selectedField)
    {
        $repo = new CustomerRepository();
        $repo->setCustomerId($customerId);
        $repo->setSelectedField($selectedField);
        return $repo->detail();
    }
}
