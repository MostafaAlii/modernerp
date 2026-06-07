<?php

namespace App\Observers;

use App\Models\SalesUnit;

class SalesUnitObserver
{
    public function creating(SalesUnit $salesUnit): void
    {
        $user = get_user_data();
        $salesUnit->company_id = $salesUnit->company_id ?? $user?->company_id;
        $salesUnit->created_by = $user?->id;
    }

    public function updating(SalesUnit $salesUnit): void
    {
        $salesUnit->updated_by = get_user_data()?->id;
    }
}
