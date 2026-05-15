<?php

namespace App\Observers;

use App\Models\InvUom;

class InvUomObserver
{
    public function creating(InvUom $invUom): void
    {
        $user = get_user_data();
        $invUom->company_id = $invUom->company_id ?? $user?->company_id;
        $invUom->created_by = $user?->id;
    }

    public function updating(InvUom $invUom): void
    {
        $invUom->updated_by = get_user_data()?->id;
    }
}