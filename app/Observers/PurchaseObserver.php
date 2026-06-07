<?php

namespace App\Observers;

use App\Models\Purchase;

class PurchaseObserver
{
    public function creating(Purchase $purchase): void
    {
        $user = get_user_data();
        $purchase->company_id = $purchase->company_id ?? $user?->company_id;
        $purchase->created_by = $user?->id;
    }

    public function updating(Purchase $purchase): void
    {
        $purchase->updated_by = get_user_data()?->id;
    }
}
