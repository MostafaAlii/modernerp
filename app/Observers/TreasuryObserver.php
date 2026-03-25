<?php
namespace App\Observers;
use App\Models\Treasury;
class TreasuryObserver {
    public function creating(Treasury $treasury): void {
        $user = get_user_data();
        $treasury->company_id = $treasury->company_id ?? $user?->company_id;
        $treasury->created_by = $user?->id;
    }

    public function updating(Treasury $treasury): void {
        $treasury->updated_by = get_user_data()?->id;
    }
}