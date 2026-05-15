<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use App\Enums\InvUom\UomStatus;
use App\Enums\InvUom\UomMaster;
use App\Models\Scopes;

class InvUom extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'inv_uoms';

    protected $fillable = [
        'uuid',
        'is_active',
        'is_master',
        'company_id',
        'created_by',
        'updated_by',
        'date',
    ];

    public $translatedAttributes = ['name'];

    protected $casts = [
        'date'      => 'date',
        'is_active' => UomStatus::class,
        'is_master' => UomMaster::class,
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', UomStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', UomStatus::INACTIVE);
    }

    public function scopeMaster($query)
    {
        return $query->where('is_master', UomMaster::MASTER);
    }

    public function scopeSub($query)
    {
        return $query->where('is_master', UomMaster::SUB);
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