<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use App\Enums\Store\StoreStatus;
use App\Models\Scopes;

class Store extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'stores';

    protected $fillable = [
        'uuid',
        'is_active',
        'company_id',
        'created_by',
        'updated_by',
        'date',
        'phone',
        'address',
    ];

    public $translatedAttributes = ['name'];

    protected $casts = [
        'date'      => 'date',
        'is_active' => StoreStatus::class,
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', StoreStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', StoreStatus::INACTIVE);
    }

    // Relationships
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

    // Global Scope
    protected static function booted(): void
    {
        static::addGlobalScope(new Scopes\CompanyScope());
    }
}