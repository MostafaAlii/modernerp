<?php
namespace App\Models;

use App\Enums\Color\ColorStatus;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;

class Color extends BaseModel implements TranslatableContract
{
    use Translatable;

    protected $table = 'colors';

    protected $fillable = [
        'uuid',
        'hex_code',
        'status',
        'company_id',
        'created_by',
        'updated_by',
    ];

    public $translatedAttributes = [
        'name',
    ];

    protected $casts = [
        'status' => ColorStatus::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive($query)
    {
        return $query->where('status', ColorStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', ColorStatus::INACTIVE);
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