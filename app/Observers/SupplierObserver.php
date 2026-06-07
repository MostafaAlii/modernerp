<?php

namespace App\Observers;

use App\Models\Supplier;

class SupplierObserver
{
    public function creating(Supplier $supplier): void
    {
        $user = get_user_data();
        $supplier->company_id = $supplier->company_id ?? $user?->company_id;
        $supplier->created_by = $user?->id;
    }

    public function updating(Supplier $supplier): void
    {
        $supplier->updated_by = get_user_data()?->id;
    }
}
