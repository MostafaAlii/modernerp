<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\SalesUnit;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SalesUnitDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new SalesUnit);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))

            // ACTIONS
            ->addColumn('action', function (SalesUnit $salesUnit) {
                return view('dashboard.admin.sales_units.btn.actions', compact('salesUnit'));
            })

            // NAME (translations)
            ->editColumn('name', function (SalesUnit $salesUnit) {
                return $salesUnit->translate(app()->getLocale())?->name
                    ?? $salesUnit->translate('ar')?->name
                    ?? '-';
            })

            // STATUS
            ->editColumn('status', function (SalesUnit $salesUnit) {
                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-status">' . $salesUnit->status->badge() . '</span>
                    </div>
                ';
            });

        // COMPANY (OWNER ONLY)
        if (EnsureOwner::check()) {
            $dataTable->editColumn('company', function (SalesUnit $salesUnit) {
                return $salesUnit->company?->name ?? '-';
            });
        }

        $dataTable
            ->editColumn('created_at', function (SalesUnit $salesUnit) {
                return $this->formatTranslatedDate($salesUnit->created_at);
            })
            ->editColumn('updated_at', function (SalesUnit $salesUnit) {
                return $this->formatTranslatedDate($salesUnit->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'created_at', 'updated_at']);

        return $dataTable;
    }

    public function query(): QueryBuilder
    {
        $query = SalesUnit::query()
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
                'orderable' => false
            ],
            [
                'name'       => 'name',
                'data'       => 'name',
                'title'      => trans('dashboard/sales_units.name'),
                'className'  => 'text-center',
                'searchable' => false
            ],
            [
                'name'       => 'status',
                'data'       => 'status',
                'title'      => trans('dashboard/sales_units.is_active'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false
            ],
        ];

        /*if (EnsureOwner::check()) {
            $columns[] = [
                'name'       => 'company',
                'data'       => 'company',
                'title'      => trans('dashboard/sales_units.company'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false
            ];
        }*/

        $columns[] = [
            'name'      => 'created_at',
            'data'      => 'created_at',
            'title'     => trans('dashboard/general.created_at'),
            'className' => 'text-center'
        ];

        $columns[] = [
            'name'      => 'updated_at',
            'data'      => 'updated_at',
            'title'     => trans('dashboard/general.updated_at'),
            'className' => 'text-center'
        ];

        $columns[] = [
            'name'       => 'action',
            'data'       => 'action',
            'title'      => trans('dashboard/general.actions'),
            'className'  => 'text-center',
            'orderable'  => false,
            'searchable' => false
        ];

        return $columns;
    }
}