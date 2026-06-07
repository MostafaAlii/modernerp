<?php

namespace App\Models;

use App\Enums\Supplier\SupplierStatus;

class Supplier extends BaseModel
{
    protected $table = 'suppliers';

    protected $fillable = [
        'uuid',
        'name',
        'phone',
        'email',
        'address',
        'notes',
        'status',
        'company_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => SupplierStatus::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', SupplierStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', SupplierStatus::INACTIVE);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */
    protected static function booted(): void
    {
        static::addGlobalScope(new Scopes\CompanyScope());
    }
}
