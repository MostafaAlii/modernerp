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

    public function scopeActive($query) {
        return $query->where('is_active', TreasuryStatus::ACTIVE);
    }

    public function scopeInactive($query) {
        return $query->where('is_active', TreasuryStatus::INACTIVE);
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

    public static function hasActiveMasterForCompany(int $companyId, ?int $excludeId = null): bool {
        return static::where('is_master', true)->where('company_id', $companyId)
            ->when(! is_null($excludeId), fn($q) => $q->where('id', '!=', $excludeId))
            ->exists();
    }

    public function isMaster(): bool {
        return $this->is_master === true;
    }

    public function deliveryDetails() {
        return $this->hasMany(TreasuryDeliveryDetail::class, 'treasury_id');
    }

    public function masterDeliveries() {
        return $this->hasMany(TreasuryDeliveryDetail::class, 'treasury_can_delivery_id');
    }

    protected static function booted(): void {
        static::addGlobalScope(new Scopes\CompanyScope());
    }
}