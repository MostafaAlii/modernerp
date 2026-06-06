<?php
namespace App\Models;

use App\Enums\Product\{ProductStatus,ProductVariantType};
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Concerns\UploadMedia;
class Product extends BaseModel implements TranslatableContract {
    use Translatable, UploadMedia;
    protected $table = 'products';
    protected $fillable = [
        'uuid',
        'category_id',
        'brand_id',
        'variant_type',
        'has_barcode',
        'has_qr',
        'status',
        'company_id',
        'created_by',
        'updated_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | Translations
    |--------------------------------------------------------------------------
    */
    public $translatedAttributes = [
        'name',
        'description',
    ];

    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'variant_type' => ProductVariantType::class,
        'status'       => ProductStatus::class,
        'has_barcode'  => 'boolean',
        'has_qr'       => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scopes
    | فلاتر جاهزة للاستخدام في الـ queries
    |--------------------------------------------------------------------------
    */

    // Product::active()->get() → جيب المنتجات النشطة بس
    public function scopeActive($query)
    {
        return $query->where('status', ProductStatus::ACTIVE);
    }

    // Product::inactive()->get() → جيب المنتجات الغير نشطة
    public function scopeInactive($query)
    {
        return $query->where('status', ProductStatus::INACTIVE);
    }

    // Product::simple()->get() → جيب المنتجات البسيطة بس
    public function scopeSimple($query)
    {
        return $query->where('variant_type', ProductVariantType::SIMPLE);
    }

    // Product::variable()->get() → جيب المنتجات اللي عندها variants
    public function scopeVariable($query)
    {
        return $query->whereIn('variant_type', [
            ProductVariantType::COLOR,
            ProductVariantType::SIZE,
            ProductVariantType::COLOR_SIZE,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */

    // المنتج بيتبع قسم واحد
    // $product->category
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    // المنتج بيتبع براند واحد (اختياري)
    // $product->brand
    public function brand(): BelongsTo {
        return $this->belongsTo(Brand::class);
    }

    // المنتج عنده كتير variants (كل لون/مقاس = variant)
    // $product->variants
    public function variants(): HasMany {
        return $this->hasMany(ProductVariant::class);
    }

    // جيب الـ variants النشطة بس
    // $product->activeVariants
    public function activeVariants(): HasMany {
        return $this->hasMany(ProductVariant::class)->where('status', 1);
    }

    // المنتج بيتبع شركة
    // $product->company
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // مين اللي أنشأ المنتج
    // $product->createdBy
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }

    // مين اللي عدّل المنتج
    // $product->updatedBy
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    | دوال مساعدة بتسهل التعامل مع المنتج
    |--------------------------------------------------------------------------
    */

    // هل المنتج بيستخدم ألوان؟
    // if ($product->hasColors()) { ... }
    public function hasColors(): bool
    {
        return $this->variant_type->hasColor();
    }

    // هل المنتج بيستخدم مقاسات؟
    // if ($product->hasSizes()) { ... }
    public function hasSizes(): bool
    {
        return $this->variant_type->hasSize();
    }

    // هل المنتج بسيط؟
    // if ($product->isSimple()) { ... }
    public function isSimple(): bool
    {
        return $this->variant_type->isSimple();
    }

    // إجمالي الكمية في المخزون (كل الـ variants مع بعض)
    // $product->totalStock() → 50
    public function totalStock(): int
    {
        return $this->variants()->sum('quantity');
    }

    // هل المنتج في المخزون؟
    // if ($product->inStock()) { ... }
    public function inStock(): bool
    {
        return $this->totalStock() > 0;
    }

    // الصورة الرئيسية للمنتج
    // $product->media
    public function media()
    {
        return $this->morphMany(\App\Models\Media::class, 'mediable');
    }

    // جيب الصورة الرئيسية بس
    // $product->mainImage
    public function mainImage()
    {
        return $this->morphOne(\App\Models\Media::class, 'mediable')
            ->where('collection_name', 'main')
            ->where('type', 'main');
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