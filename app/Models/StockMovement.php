<?php
namespace App\Models;

use App\Enums\Stock\StockMovementType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class StockMovement extends BaseModel
{
    protected $table = 'stock_movements';

    protected $fillable = [
        'uuid',
        'product_variant_id',
        'store_id',
        'type',
        'quantity',
        'quantity_before',
        'quantity_after',
        'unit_price',
        'notes',
        'reference_type',
        'reference_id',
        'created_by',
    ];

    protected $casts = [
        'type'            => StockMovementType::class,
        'quantity'        => 'integer',
        'quantity_before' => 'integer',
        'quantity_after'  => 'integer',
        'unit_price'      => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // الحركة دى خاصة بـ variant معين
    // $movement->variant->displayName()
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // الحركة دى في فرع/مخزن معين
    // $movement->store->name
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    // مين اللي عمل الحركة دى
    // $movement->createdBy->name
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Polymorphic Relation
    | الـ reference بيتغير حسب نوع الحركة:
    | - لو purchase  → reference بيبقى Purchase model
    | - لو sale      → reference بيبقى Sale model
    | - لو return    → reference بيبقى Return model
    | - لو adjustment→ reference بيبقى null
    |--------------------------------------------------------------------------
    */

    // $movement->reference → بيرجع الـ model المرتبط (Sale/Purchase/Return)
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // هل الحركة دى إضافة للمخزون؟
    // purchase أو return = إضافة
    // $movement->isIn() → true/false
    public function isIn(): bool
    {
        return $this->type->isIn();
    }

    // هل الحركة دى خصم من المخزون؟
    // sale = خصم
    // $movement->isOut() → true/false
    public function isOut(): bool
    {
        return $this->type->isOut();
    }

    // إجمالي قيمة الحركة
    // $movement->totalValue() → 300.00
    public function totalValue(): float
    {
        return abs($this->quantity) * $this->unit_price;
    }
}
