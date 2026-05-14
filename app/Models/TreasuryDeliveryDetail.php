<?php
namespace App\Models;
class TreasuryDeliveryDetail extends BaseModel {
    protected $table = 'treasury_delivery_details';
    protected $fillable = [
        'uuid',
        'treasury_id',
        'treasury_can_delivery_id',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public function treasury() {
        return $this->belongsTo(Treasury::class, 'treasury_id');
    }

    public function deliveryTreasury() {
        return $this->belongsTo(Treasury::class, 'treasury_can_delivery_id');
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function createdBy() {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy() {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}