<?php
namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\Treasury\TreasuryStatus;
class Treasury extends BaseModel implements TranslatableContract {
    use SoftDeletes, Translatable;
    protected $table = 'treasuries';
    protected $fillable = ['uuid', 'is_master',
        'last_exchange_receipt',
        'last_collect_receipt',
        'date',
        'is_active',
        'company_id',
        'created_by',
        'updated_by',
    ];
    public $translatedAttributes = ['name'];
    protected $casts = [
        'is_master' => 'boolean',
        'date'      => 'date',
        'is_active' => TreasuryStatus::class,
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', TreasuryStatus::ACTIVE);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', TreasuryStatus::INACTIVE);
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

    protected static function booted(): void
    {
        static::addGlobalScope(new Scopes\CompanyScope());
    }
}
