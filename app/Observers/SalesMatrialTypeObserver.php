<?php

namespace App\Observers;

use App\Models\SalesMatrialType;

class SalesMatrialTypeObserver
{
    public function creating(SalesMatrialType $salesMaterialType): void
    {
        $user = get_user_data();
        $salesMaterialType->company_id = $salesMaterialType->company_id ?? $user?->company_id;
        $salesMaterialType->created_by = $user?->id;
    }

    public function updating(SalesMatrialType $salesMatrialType): void
    {
        $salesMatrialType->updated_by = get_user_data()?->id;
    }
}