<?php

namespace App\Models;

use App\Enums\Purchase\PurchaseStatus;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends BaseModel
{
    protected $table = 'purchases';

    protected $fillable = [
        'uuid',
        'supplier_id',
        'store_id',
        'invoice_number',
        'invoice_date',
        'total_amount',
        'discount',
        'net_amount',
        'paid_amount',
        'remaining_amount',
        'status',
        'notes',
        'company_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status'           => PurchaseStatus::class,
        'invoice_date'     => 'date',
        'total_amount'     => 'decimal:2',
        'discount'         => 'decimal:2',
        'net_amount'       => 'decimal:2',
        'paid_amount'      => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeDraft($query)
    {
        return $query->where('status', PurchaseStatus::DRAFT);
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', PurchaseStatus::CONFIRMED);
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', PurchaseStatus::CANCELLED);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // الفاتورة عندها كتير items
    // $purchase->items
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    // الفاتورة بتتبع مورد
    // $purchase->supplier
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // الفاتورة بتتبع فرع/مخزن
    // $purchase->store
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // حساب المتبقي تلقائياً
    // $purchase->calcRemaining()
    public function calcRemaining(): float
    {
        return $this->net_amount - $this->paid_amount;
    }

    // هل الفاتورة مدفوعة بالكامل؟
    public function isFullyPaid(): bool
    {
        return $this->remaining_amount <= 0;
    }

    /*
    |--------------------------------------------------------------------------
    | Boot
    |--------------------------------------------------------------------------
    */
    protected static function booted(): void
    {
        static::addGlobalScope(new Scopes\CompanyScope());
        static::creating(function (Purchase $purchase) {
            $purchase->invoice_number = self::generateInvoiceNumber();
        });
    }

    private static function generateInvoiceNumber(): string
    {
        $year  = date('Y');
        $prefix = 'PUR-' . $year . '-';

        // جيب آخر فاتورة في نفس السنة
        $last = static::withoutGlobalScopes()
            ->where('invoice_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = $last
            ? (int) substr($last->invoice_number, strlen($prefix)) + 1
            : 1;

        return $prefix . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
        // PUR-2026-000001
        // PUR-2026-000002
    }
}
