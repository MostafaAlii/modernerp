<?php

namespace App\Observers;

use App\Models\Brand;

class BrandObserver
{
    public function creating(Brand $brand): void
    {
        $user = get_user_data();
        $brand->company_id = $brand->company_id ?? $user?->company_id;
        $brand->created_by = $user?->id;
    }

    public function updating(Brand $brand): void
    {
        $brand->updated_by = get_user_data()?->id;
    }
}