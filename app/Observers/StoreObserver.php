<?php

namespace App\Observers;

use App\Models\Store;

class StoreObserver
{
    public function creating(Store $store): void
    {
        $user = get_user_data();
        $store->company_id = $store->company_id ?? $user?->company_id;
        $store->created_by = $user?->id;
    }

    public function updating(Store $store): void
    {
        $store->updated_by = get_user_data()?->id;
    }
}