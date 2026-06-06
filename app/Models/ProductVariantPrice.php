<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariantPrice extends BaseModel
{
    protected $table = 'product_variant_prices';

    protected $fillable = [
        'uuid',
        'product_variant_id',
        'sales_unit_id',
        'price',
        'cost_price',
    ];

    protected $casts = [
        'price'      => 'decimal:2',
        'cost_price' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // السعر ده بيتبع variant معين
    // $price->variant
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // السعر ده بيتبع وحدة بيع معينة (قطعة / جملة / نص جملة)
    // $price->salesUnit->translate('ar')->name
    public function salesUnit(): BelongsTo
    {
        return $this->belongsTo(SalesUnit::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // هامش الربح بالجنيه
    // $price->profitAmount() → 50.00
    public function profitAmount(): float
    {
        return $this->price - $this->cost_price;
    }

    // هامش الربح بالنسبة المئوية
    // $price->profitPercentage() → 33.33
    public function profitPercentage(): float
    {
        if ($this->cost_price <= 0) return 0;

        return round(
            ($this->profitAmount() / $this->cost_price) * 100,
            2
        );
    }
}