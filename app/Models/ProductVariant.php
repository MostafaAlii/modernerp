<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends BaseModel
{
    protected $table = 'product_variants';

    protected $fillable = [
        'uuid',
        'product_id',
        'color_id',
        'size_id',
        'store_id',
        'sku',
        'barcode',
        'quantity',
        'min_stock_alert',
        'status',
    ];

    protected $casts = [
        'quantity'        => 'integer',
        'min_stock_alert' => 'integer',
        'status'          => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    // ProductVariant::active()->get()
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    // جيب الـ variants اللي مخزونها وصل للحد الأدنى
    // ProductVariant::lowStock()->get()
    public function scopeLowStock($query)
    {
        return $query->whereColumn('quantity', '<=', 'min_stock_alert')
            ->where('min_stock_alert', '>', 0);
    }

    // جيب الـ variants اللي مخزونها خلص
    // ProductVariant::outOfStock()->get()
    public function scopeOutOfStock($query)
    {
        return $query->where('quantity', '<=', 0);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // الـ variant بيتبع منتج
    // $variant->product
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // الـ variant عنده لون (ممكن يكون null)
    // $variant->color?->translate('ar')->name
    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class);
    }

    // الـ variant عنده مقاس (ممكن يكون null)
    // $variant->size?->translate('ar')->name
    public function size(): BelongsTo
    {
        return $this->belongsTo(Size::class);
    }

    // الـ variant موجود في فرع/مخزن معين
    // $variant->store
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    // الـ variant عنده كتير أسعار (قطعة / جملة / نص جملة)
    // $variant->prices
    public function prices(): HasMany
    {
        return $this->hasMany(ProductVariantPrice::class);
    }

    // جيب سعر معين بناءً على وحدة البيع
    // $variant->priceFor($salesUnitId)
    public function priceFor(int $salesUnitId): ?ProductVariantPrice
    {
        return $this->prices()
            ->where('sales_unit_id', $salesUnitId)
            ->first();
    }

    // كل حركات المخزون الخاصة بالـ variant ده
    // $variant->stockMovements
    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // هل المخزون وصل للحد الأدنى؟
    // if ($variant->isLowStock()) { show alert }
    public function isLowStock(): bool
    {
        return $this->min_stock_alert > 0
            && $this->quantity <= $this->min_stock_alert;
    }

    // هل المخزون خلص؟
    // if ($variant->isOutOfStock()) { ... }
    public function isOutOfStock(): bool
    {
        return $this->quantity <= 0;
    }

    // اسم الـ variant كامل للعرض
    // $variant->displayName() → "قميص رجالي - أبيض - Large"
    public function displayName(): string
    {
        $locale = app()->getLocale();

        $parts = [
            $this->product?->translate($locale)?->name,
            $this->color?->translate($locale)?->name,
            $this->size?->translate($locale)?->name,
        ];

        return implode(' - ', array_filter($parts));
    }
}