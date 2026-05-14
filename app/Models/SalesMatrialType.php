<?php
namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use App\Enums\SalesMatrialType\SalesMatrialTypeStatus;
class SalesMatrialType extends BaseModel implements TranslatableContract {
    use Translatable;
    protected $table = 'sales_matrial_types';
    protected $fillable = [
        'uuid',
        'is_active',
        'company_id',
        'created_by',
        'updated_by',
        'date',
    ];
    public $translatedAttributes = ['name'];
    protected $casts = [
        'date'      => 'date',
        'is_active' => SalesMatrialTypeStatus::class,
    ];
    public function scopeActive($query)
    {
        return $query->where('is_active', SalesMatrialTypeStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', SalesMatrialTypeStatus::INACTIVE);
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

    protected static function booted(): void {
        static::addGlobalScope(new Scopes\CompanyScope());
    }
}
