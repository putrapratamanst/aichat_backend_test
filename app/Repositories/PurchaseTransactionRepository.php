<?php

namespace App\Repositories;

use App\Models\PurchaseTransaction;
use Illuminate\Support\Carbon;

class PurchaseTransactionRepository
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

    public function listWithinLastMonth()
    {
        return PurchaseTransaction::select($this->selectedField)
            ->where('customer_id', $this->customerId)
            ->whereDate('transaction_at', '>', Carbon::now()->subDays(30))
            ->get();
    }
}
