<?php
namespace App\Repositories\Eloquents;

use App\Models\{Product, Category, Brand, Color, Size, SalesUnit};
use App\DataTables\Dashboard\Admin\ProductDataTable;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Http\Requests\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;
use App\Enums\Product\ProductVariantType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\SkuGeneratorService;

class ProductRepository implements ProductRepositoryInterface {
    protected $skuGenerator;
    public function __construct(SkuGeneratorService $skuGenerator) {
        $this->skuGenerator = $skuGenerator;
    }

    public function index(ProductDataTable $dataTable) {
        return $dataTable->render('dashboard.admin.products.index', [
            'title' => trans('dashboard/products.products'),
        ]);
    }

    public function create() {
        $categories = Category::active()->with('translations')->get();
        $brands     = Brand::active()->with('translations')->get();
        $colors     = Color::active()->with('translations')->get();
        $sizes      = Size::active()->with('translations')->get();
        $salesUnits = SalesUnit::active()->with('translations')->get();
        $variantTypes = ProductVariantType::cases();
        return view('dashboard.admin.products.create', compact(
            'categories',
            'brands',
            'colors',
            'sizes',
            'salesUnits',
            'variantTypes',
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Store - حفظ منتج جديد
    |--------------------------------------------------------------------------
    */
    public function store(StoreProductRequest $request) {
        try {
            DB::beginTransaction();
            // 1. إنشاء المنتج الأساسي
            $product = Product::create([
                'category_id'  => $request->category_id,
                'brand_id'     => $request->brand_id,
                'variant_type' => $request->variant_type,
                'has_barcode'  => $request->boolean('has_barcode'),
                'has_qr'       => $request->boolean('has_qr'),
                'status'       => $request->boolean('status'),
            ]);

            // 2. حفظ الترجمات
            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $product->translateOrNew($locale)->name = $value;
                }
                if (filled($request->description[$locale] ?? null)) {
                    $product->translateOrNew($locale)->description = $request->description[$locale];
                }
            }
            $product->save();

            if ($request->hasFile('image')) {
                $product->uploadSingleMedia(
                    baseFolder:       'products',
                    file:             $request->file('image'),
                    model:            $product,
                    relation:         'media',
                    useStorage:        true,
                    generateThumbnail: false,
                    collectionName:   'product',
                );
            }

            // 3. حفظ الـ variants والأسعار
            $this->syncVariants($product, $request);

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', trans('dashboard/products.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', trans('dashboard/general.error_occurred'))
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Edit - صفحة تعديل منتج
    |--------------------------------------------------------------------------
    */
    public function edit(Product $product)
    {
        $product->load([
            'translations',
            'variants.prices',
            'variants.color',
            'variants.size',
        ]);

        $categories   = Category::active()->with('translations')->get();
        $brands       = Brand::active()->with('translations')->get();
        $colors       = Color::active()->with('translations')->get();
        $sizes        = Size::active()->with('translations')->get();
        $salesUnits   = SalesUnit::active()->with('translations')->get();
        $variantTypes = ProductVariantType::cases();

        return view('dashboard.admin.products.edit', compact(
            'product',
            'categories',
            'brands',
            'colors',
            'sizes',
            'salesUnits',
            'variantTypes',
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | Update - تعديل منتج موجود
    |--------------------------------------------------------------------------
    */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();

            // 1. تحديث البيانات الأساسية
            $product->update([
                'category_id'  => $request->category_id,
                'brand_id'     => $request->brand_id,
                'variant_type' => $request->variant_type,
                'has_barcode'  => $request->boolean('has_barcode'),
                'has_qr'       => $request->boolean('has_qr'),
                'status'       => $request->boolean('status'),
            ]);

            // 2. تحديث الترجمات
            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $product->translateOrNew($locale)->name = $value;
                }
                if (filled($request->description[$locale] ?? null)) {
                    $product->translateOrNew($locale)->description = $request->description[$locale];
                }
            }
            $product->save();
            if ($request->input('remove_image') == '1') {
                $product->deleteExistingMedia(
                    baseFolder:     'products',
                    model:          $product,
                    column:         null,
                    relation:       'media',
                    useStorage:     true,
                    collectionName: 'product',
                );
            }
            if ($request->hasFile('image')) {
                $product->updateSingleMedia(
                    baseFolder:       'products',
                    file:             $request->file('image'),
                    model:            $product,
                    relation:         'media',
                    useStorage:        true,
                    generateThumbnail: false,
                    collectionName:   'product',
                );
            }
            // 3. تحديث الـ variants والأسعار
            $this->syncVariants($product, $request);

            DB::commit();
            return redirect()->route('admin.products.index')
                ->with('success', trans('dashboard/products.updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', trans('dashboard/general.error_occurred'))
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy - حذف منتج
    |--------------------------------------------------------------------------
    */
    public function destroy(Product $product): array
    {
        try {
            DB::beginTransaction();
            // حذف المنتج هيحذف تلقائياً:
            // - product_translations (cascadeOnDelete)
            // - product_variants (cascadeOnDelete)
            //   └── product_variant_prices (cascadeOnDelete)
            //   └── stock_movements (cascadeOnDelete)
            $product->delete();
            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => 'ERROR'];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | syncVariants (private)
    | بتتعامل مع كل سيناريوهات الـ variants
    | بتتستخدم في store و update
    |--------------------------------------------------------------------------
    */
    private function syncVariants(Product $product, $request): void
    {
        $variantType = ProductVariantType::from((int) $request->variant_type);

        // امسح الـ variants القديمة وابدأ من الأول
        $product->variants()->delete();

        $variants = $request->input('variants', []);

        foreach ($variants as $index => $variantData) {
            $sku = $this->skuGenerator->generateVariantSku($product, $variantData);
            $barcode = null;
            if ($request->boolean('has_barcode')) {
                $barcode = $this->skuGenerator->generateBarcode();
            }
            // تحديد color_id و size_id بناءً على نوع الـ variant
            $colorId = $variantType->hasColor()
                ? ($variantData['color_id'] ?? null)
                : null;

            $sizeId = $variantType->hasSize()
                ? ($variantData['size_id'] ?? null)
                : null;

            // إنشاء الـ variant
            $variant = $product->variants()->create([
                'uuid'            => Str::uuid(),
                'color_id'        => $colorId,
                'size_id'         => $sizeId,
                'sku'             => $sku,
                'barcode'         => $barcode,
                'quantity'        => $variantData['quantity'] ?? 0,
                'min_stock_alert' => $variantData['min_stock_alert'] ?? 0,
                'status'          => 1,
            ]);

            // حفظ الأسعار لكل وحدة بيع
            $prices = $variantData['prices'] ?? [];
            foreach ($prices as $salesUnitId => $priceData) {
                if (filled($priceData['price'] ?? null)) {
                    $variant->prices()->create([
                        'sales_unit_id' => $salesUnitId,
                        'price'         => $priceData['price'],
                        'cost_price'    => $priceData['cost_price'] ?? 0,
                    ]);
                }
            }
        }
    }

    public function getProductDetails(int $id): array
{
    $product = Product::with([
        'category.translations',
        'brand.translations',
        'variants.color.translations',
        'variants.size.translations',
        'variants.prices.salesUnit.translations'
    ])->findOrFail($id);
    
    return [
        'id' => $product->id,
        'name' => $product->name,
        'category' => $product->category?->name,
        'brand' => $product->brand?->name,
        'variant_type' => $product->variant_type->label(),
        'status' => $product->status,
        'has_qr' => $product->has_qr,
        'variants' => $product->variants->map(function($variant) {
            return [
                'id' => $variant->id,
                'color' => $variant->color?->name,
                'color_hex' => $variant->color?->hex_code,
                'size' => $variant->size?->name,
                'sku' => $variant->sku,
                'barcode' => $variant->barcode,
                'quantity' => $variant->quantity,
                'qr_code' => $variant->qr_code ? asset('storage/' . $variant->qr_code) : null,
            ];
        }),
    ];
}
}