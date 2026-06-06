<?php

namespace App\Observers;

use App\Models\Color;

class ColorObserver
{
    public function creating(Color $color): void
    {
        $user = get_user_data();
        $color->company_id = $color->company_id ?? $user?->company_id;
        $color->created_by = $user?->id;
    }

    public function updating(Color $color): void
    {
        $color->updated_by = get_user_data()?->id;
    }
}