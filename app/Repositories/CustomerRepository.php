<?php

namespace App\Repositories;

use App\Models\Customer;

class CustomerRepository
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

    public function detail()
    {
        return Customer::select($this->selectedField)
            ->where('id', $this->customerId)
            ->first();
    }
}
