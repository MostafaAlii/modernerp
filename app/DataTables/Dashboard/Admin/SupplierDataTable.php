<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Supplier;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SupplierDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Supplier);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))

            ->addColumn('action', function (Supplier $supplier) {
                return view('dashboard.admin.suppliers.btn.actions', compact('supplier'));
            })

            ->editColumn('name', function (Supplier $supplier) {
                return $supplier->name ?? '-';
            })

            ->editColumn('phone', function (Supplier $supplier) {
                return $supplier->phone
                    ? '<a href="tel:' . $supplier->phone . '">' . $supplier->phone . '</a>'
                    : '-';
            })

            ->editColumn('email', function (Supplier $supplier) {
                return $supplier->email
                    ? '<a href="mailto:' . $supplier->email . '">' . $supplier->email . '</a>'
                    : '-';
            })

            ->editColumn('status', function (Supplier $supplier) {
                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-status">' . $supplier->status->badge() . '</span>
                    </div>
                ';
            });

        if (EnsureOwner::check()) {
            $dataTable->editColumn('company', function (Supplier $supplier) {
                return $supplier->company?->name ?? '-';
            });
        }

        $dataTable
            ->editColumn('created_at', function (Supplier $supplier) {
                return $this->formatTranslatedDate($supplier->created_at);
            })
            ->editColumn('updated_at', function (Supplier $supplier) {
                return $this->formatTranslatedDate($supplier->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'phone', 'email', 'created_at', 'updated_at']);

        return $dataTable;
    }

    public function query(): QueryBuilder
    {
        $query = Supplier::query()->latest();

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
                'name'      => 'name',
                'data'      => 'name',
                'title'     => trans('dashboard/suppliers.name'),
                'className' => 'text-center',
            ],
            [
                'name'       => 'phone',
                'data'       => 'phone',
                'title'      => trans('dashboard/suppliers.phone'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'       => 'email',
                'data'       => 'email',
                'title'      => trans('dashboard/suppliers.email'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
            [
                'name'       => 'status',
                'data'       => 'status',
                'title'      => trans('dashboard/suppliers.is_active'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ],
        ];

        if (EnsureOwner::check()) {
            $columns[] = [
                'name'       => 'company',
                'data'       => 'company',
                'title'      => trans('dashboard/suppliers.company'),
                'className'  => 'text-center',
                'orderable'  => false,
                'searchable' => false,
            ];
        }

        $columns[] = [
            'name'      => 'created_at',
            'data'      => 'created_at',
            'title'     => trans('dashboard/general.created_at'),
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
