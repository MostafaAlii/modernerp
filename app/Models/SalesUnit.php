<?php
namespace App\Models;
use App\Enums\SalesUnit\SalesUnitStatus;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class SalesUnit extends BaseModel implements TranslatableContract {
    use Translatable;
    protected $table = 'sales_units';
    protected $fillable = [
        'uuid',
        'status',
        'company_id',
        'created_by',
        'updated_by',
    ];
    public $translatedAttributes = [
        'name',
    ];

    protected $casts = [
        'status' => SalesUnitStatus::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('status', SalesUnitStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', SalesUnitStatus::INACTIVE);
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