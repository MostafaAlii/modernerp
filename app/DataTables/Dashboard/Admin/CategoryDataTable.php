<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Category;
use App\Enums\Category\CategoryStatus;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class CategoryDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Category);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))

            // ACTIONS
            ->addColumn('action', function (Category $category) {
                return view('dashboard.admin.categories.btn.actions', compact('category'));
            })

            // NAME (translations)
            ->editColumn('name', function (Category $category) {
                return $category->translate(app()->getLocale())?->name
                    ?? $category->translate('ar')?->name
                    ?? '-';
            })

            // PARENT / TYPE (MAIN or SUB)
            ->editColumn('parent', function (Category $category) {
                $badge =  $category->getTypeBadge();
                return $badge . '<br>' .$category->parent?->translate(app()->getLocale())?->name
                    ?? $category->parent?->translate('ar')?->name
                    ?? '-';
            })

            // STATUS
            ->editColumn('status', function (Category $category) {
                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-status">' . $category->status->badge() . '</span>
                    </div>
                ';
            });

        // COMPANY (OWNER ONLY)
        if (EnsureOwner::check()) {
            $dataTable->editColumn('company', function (Category $category) {
                return $category->company?->name ?? '-';
            });
        }

        $dataTable
            ->editColumn('created_at', function (Category $category) {
                return $this->formatTranslatedDate($category->created_at);
            })
            ->editColumn('updated_at', function (Category $category) {
                return $this->formatTranslatedDate($category->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'parent', 'created_at', 'updated_at']);

        return $dataTable;
    }

    public function query(): QueryBuilder
    {
        $query = Category::query()
            ->with(['translations', 'parent'])
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
                'name' => 'DT_RowIndex',
                'data' => 'DT_RowIndex',
                'title' => '#',
                'className' => 'text-center',
                'orderable' => false
            ],

            [
                'name' => 'name',
                'data' => 'name',
                'title' => trans('dashboard/categories.name'),
                'className' => 'text-center',
                'searchable' => false
            ],

            [
                'name' => 'parent',
                'data' => 'parent',
                'title' => trans('dashboard/categories.parent'),
                'className' => 'text-center',
                'orderable' => false,
                'searchable' => false
            ],

            [
                'name' => 'status',
                'data' => 'status',
                'title' => trans('dashboard/categories.is_active'),
                'className' => 'text-center',
                'orderable' => false,
                'searchable' => false
            ],
        ];

        /*if (EnsureOwner::check()) {
            $columns[] = [
                'name' => 'company',
                'data' => 'company',
                'title' => trans('dashboard/categories.company'),
                'className' => 'text-center',
                'orderable' => false,
                'searchable' => false
            ];
        }*/

        $columns[] = [
            'name' => 'created_at',
            'data' => 'created_at',
            'title' => trans('dashboard/general.created_at'),
            'className' => 'text-center'
        ];

        $columns[] = [
            'name' => 'updated_at',
            'data' => 'updated_at',
            'title' => trans('dashboard/general.updated_at'),
            'className' => 'text-center'
        ];

        $columns[] = [
            'name' => 'action',
            'data' => 'action',
            'title' => trans('dashboard/general.actions'),
            'className' => 'text-center',
            'orderable' => false,
            'searchable' => false
        ];

        return $columns;
    }
}