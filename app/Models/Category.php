<?php

namespace App\Models;

use App\Enums\Category\CategoryStatus;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Category extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'categories';

    protected $fillable = [
        'uuid',
        'parent_id',
        'status',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public $translatedAttributes = [
        'name',
        'short_description',
        'description',
    ];

    protected $casts = [
        'status' => CategoryStatus::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', CategoryStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', CategoryStatus::INACTIVE);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

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
    | Global Scope (Company)
    |--------------------------------------------------------------------------
    */
    public function getTypeBadge(): string {
        if (!$this->parent_id) {
            return '<span class="badge bg-primary">' . trans('dashboard/categories.type_main') . '</span>';
        }

        return '<span class="badge bg-secondary">' . trans('dashboard/categories.type_sub') . '</span>';
    }

    protected static function booted(): void
    {
        static::addGlobalScope(new Scopes\CompanyScope());
    }
}