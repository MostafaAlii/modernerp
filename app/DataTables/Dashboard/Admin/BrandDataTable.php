<?php
namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Brand;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class BrandDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Brand);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))

            ->addColumn('action', function (Brand $brand) {
                return view('dashboard.admin.brands.btn.actions', compact('brand'));
            })

            ->editColumn('name', function (Brand $brand) {
                return $brand->translate(app()->getLocale())?->name
                    ?? $brand->translate('ar')?->name
                    ?? '-';
            })

            ->editColumn('status', function (Brand $brand) {
                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-status">' . $brand->status->badge() . '</span>
                    </div>
                ';
            });

        if (EnsureOwner::check()) {
            $dataTable->editColumn('company', function (Brand $brand) {
                return $brand->company?->name ?? '-';
            });
        }

        $dataTable
            ->editColumn('created_at', function (Brand $brand) {
                return $this->formatTranslatedDate($brand->created_at);
            })
            ->editColumn('updated_at', function (Brand $brand) {
                return $this->formatTranslatedDate($brand->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'created_at', 'updated_at']);

        return $dataTable;
    }

    public function query(): QueryBuilder
    {
        $query = Brand::query()
            ->with(['translations'])
            ->latest();

        if (EnsureOwner::check()) {
            $query->with(['company']);
        }

        return $query;
    }

    public function getColumns(): array
    {
        $columns = [
            [
                'name'      => 'DT_RowIndex',
                'data'      => 'DT_RowIndex',
                'title'     => '#',
                'className' => 'text-center',
                'orderable' => false,
            ],
            [
                'name'       => 'name',
                'data'       => 'name',
                'title'      => trans('dashboard/brands.name'),
                'className'  => 'text-center',
                'searchable' => false,
            ],
            [
                'name'       => 'status',
                'data'       => 'status',
                'title'      => trans('dashboard/brands.is_active'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
        ];

        /*if (EnsureOwner::check()) {
            $columns[] = [
                'name'       => 'company',
                'data'       => 'company',
                'title'      => trans('dashboard/brands.company'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ];
        }*/

        $columns[] = [
            'name'      => 'created_at',
            'data'      => 'created_at',
            'title'     => trans('dashboard/general.created_at'),
            'className' => 'text-center',
        ];

        $columns[] = [
            'name'      => 'updated_at',
            'data'      => 'updated_at',
            'title'     => trans('dashboard/general.updated_at'),
            'className' => 'text-center',
        ];

        $columns[] = [
            'name'       => 'action',
            'data'       => 'action',
            'title'      => trans('dashboard/general.actions'),
            'className'  => 'text-center',
            'orderable'  => false,
            'searchable' => false,
        ];

        return $columns;
    }
}