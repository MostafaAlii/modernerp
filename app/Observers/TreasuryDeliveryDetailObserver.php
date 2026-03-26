<?php
namespace App\Observers;
use App\Models\TreasuryDeliveryDetail;
class TreasuryDeliveryDetailObserver {
    public function creating(TreasuryDeliveryDetail $detail): void {
        $user = get_user_data();
        $detail->company_id = $detail->company_id ?? $user?->company_id;
        $detail->created_by = $user?->id;
    }

    public function updating(TreasuryDeliveryDetail $detail): void {
        $detail->updated_by = get_user_data()?->id;
    }
}