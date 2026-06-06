<?php
namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Product;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class ProductDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Product);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))

            ->addColumn('action', function (Product $product) {
                return view('dashboard.admin.products.btn.actions', compact('product'));
            })

            ->addColumn('image', function (Product $product) {
                $imageUrl = $product->getMediaUrl(
                    'products',
                    $product,
                    relation: 'media',
                    collectionName: 'product'
                );
                if ($imageUrl) {
                    return '
                        <img src="'.$imageUrl.'"
                            class="img-thumbnail"
                            style="width:50px;height:50px;object-fit:cover;border-radius:8px;">
                    ';
                }
                return '
                    <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                        style="width:50px;height:50px;">
                        <i class="ti ti-photo text-muted"></i>
                    </div>
                ';
            })

            // اسم المنتج بالترجمة
            ->editColumn('name', function (Product $product) {
                return $product->translate(app()->getLocale())?->name
                    ?? $product->translate('ar')?->name
                    ?? '-';
            })

            // القسم
            ->editColumn('category', function (Product $product) {
                return $product->category?->translate(app()->getLocale())?->name
                    ?? $product->category?->translate('ar')?->name
                    ?? '-';
            })

            // الماركة
            ->editColumn('brand', function (Product $product) {
                return $product->brand?->translate(app()->getLocale())?->name
                    ?? $product->brand?->translate('ar')?->name
                    ?? '-';
            })

            // نوع الـ variant مع badge
            ->editColumn('variant_type', function (Product $product) {
                return $product->variant_type->badge();
            })

            // إجمالي المخزون
            ->addColumn('stock', function (Product $product) {
                $total = $product->totalStock();
                $color = $total <= 0 ? 'danger' : ($product->variants()->lowStock()->exists() ? 'warning' : 'success');
                return '<span class="badge bg-' . $color . '">' . $total . '</span>';
            })

            // الحالة
            ->editColumn('status', function (Product $product) {
                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-status">' . $product->status->badge() . '</span>
                    </div>
                ';
            })

            ->editColumn('created_at', function (Product $product) {
                return $this->formatTranslatedDate($product->created_at);
            })
            ->editColumn('updated_at', function (Product $product) {
                return $this->formatTranslatedDate($product->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'variant_type', 'stock', 'created_at', 'updated_at', 'image']);

        return $dataTable;
    }

    public function query(): QueryBuilder
    {
        return Product::query()
            ->with(['translations', 'category.translations', 'brand.translations', 'variants', 'media'])
            ->latest();
    }

    public function getColumns(): array
    {
        return [
            [
                'name'      => 'DT_RowIndex',
                'data'      => 'DT_RowIndex',
                'title'     => '#',
                'className' => 'text-center',
                'orderable' => false,
            ],
            [
                'name'  => 'image',
                'data'  => 'image',
                'title' => trans('dashboard/products.image'),
                'className' => 'text-center',
                'orderable' => false,
                'searchable' => false,
            ],
            [
                'name'       => 'name',
                'data'       => 'name',
                'title'      => trans('dashboard/products.name'),
                'className'  => 'text-center',
                'searchable' => false,
            ],
            [
                'name'       => 'category',
                'data'       => 'category',
                'title'      => trans('dashboard/products.category'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'       => 'brand',
                'data'       => 'brand',
                'title'      => trans('dashboard/products.brand'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'       => 'variant_type',
                'data'       => 'variant_type',
                'title'      => trans('dashboard/products.variant_type'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'       => 'stock',
                'data'       => 'stock',
                'title'      => trans('dashboard/products.stock'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'       => 'status',
                'data'       => 'status',
                'title'      => trans('dashboard/products.is_active'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'      => 'created_at',
                'data'      => 'created_at',
                'title'     => trans('dashboard/general.created_at'),
                'className' => 'text-center',
            ],
            [
                'name'       => 'action',
                'data'       => 'action',
                'title'      => trans('dashboard/general.actions'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
        ];
    }
}