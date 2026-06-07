<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseItem extends BaseModel
{
    protected $table = 'purchase_items';

    protected $fillable = [
        'uuid',
        'purchase_id',
        'product_variant_id',
        'sales_unit_id',
        'quantity',
        'unit_price',
        'total_price',
    ];

    protected $casts = [
        'quantity'    => 'integer',
        'unit_price'  => 'decimal:2',
        'total_price' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // الـ item بيتبع فاتورة
    // $item->purchase
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    // الـ item بيتبع variant معين
    // $item->variant->displayName()
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    // الـ item بيتبع وحدة بيع
    // $item->salesUnit->translate('ar')->name
    public function salesUnit(): BelongsTo
    {
        return $this->belongsTo(SalesUnit::class);
    }
}
