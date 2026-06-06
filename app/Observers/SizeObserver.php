<?php

namespace App\Observers;

use App\Models\Size;

class SizeObserver
{
    public function creating(Size $size): void
    {
        $user = get_user_data();
        $size->company_id = $size->company_id ?? $user?->company_id;
        $size->created_by = $user?->id;
    }

    public function updating(Size $size): void
    {
        $size->updated_by = get_user_data()?->id;
    }
}