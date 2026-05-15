<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Store;
use App\Enums\Store\StoreStatus;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class StoreDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Store);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))
            ->addColumn('action', function (Store $store) {
                return view('dashboard.admin.stores.btn.actions', compact('store'));
            })
            ->editColumn('name', function (Store $store) {
                return $store->translate(app()->getLocale())?->name ?? $store->translate('ar')?->name ?? '-';
            })
            ->editColumn('phone', function (Store $store) {
                return $store->phone ?? '-';
            })
            ->editColumn('address', function (Store $store) {
                return $store->address ?? '-';
            })
            ->editColumn('is_active', function (Store $store) {
                return '
                    <div class="gap-1 d-flex flex-column align-items-center">
                        <span class="badge-status">' . $store->is_active->badge() . '</span>
                        <div class="form-check form-switch">
                            <input type="checkbox"
                                class="form-check-input toggle-status"
                                data-route="' . route('admin.stores.toggleStatus', $store->id) . '"
                                ' . ($store->is_active === StoreStatus::ACTIVE ? 'checked' : '') . '>
                        </div>
                    </div>
                ';
            });
        if (EnsureOwner::check()) {
            $dataTable->editColumn('company', function (Store $store) {
                return $store->company?->name ?? '-';
            });
        }

        $dataTable->editColumn('created_at', function (Store $store) {
            return $this->formatTranslatedDate($store->created_at);
        })
            ->editColumn('updated_at', function (Store $store) {
                return $this->formatTranslatedDate($store->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'is_active', 'created_at', 'updated_at']);

        return $dataTable;
    }

    public function query(): QueryBuilder
    {
        $query = Store::query()
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
            ['name' => 'DT_RowIndex', 'data' => 'DT_RowIndex', 'title' => '#', 'className' => 'text-center', 'orderable' => false],
            ['name' => 'name',        'data' => 'name',        'title' => trans('dashboard/store.name'),        'className' => 'text-center', 'searchable' => false],
            ['name' => 'phone',       'data' => 'phone',       'title' => trans('dashboard/store.phone'),       'className' => 'text-center'],
            ['name' => 'address',     'data' => 'address',     'title' => trans('dashboard/store.address'),     'className' => 'text-center'],
            ['name' => 'is_active',   'data' => 'is_active',   'title' => trans('dashboard/store.is_active'),   'className' => 'text-center', 'orderable' => false, 'searchable' => false],
        ];
        if (EnsureOwner::check()) {
            $columns[] = ['name' => 'company', 'data' => 'company', 'title' => trans('dashboard/store.company'), 'className' => 'text-center', 'orderable' => false, 'searchable' => false];
        }

        $columns[] = ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'className' => 'text-center'];
        $columns[] = ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'className' => 'text-center'];
        $columns[] = ['name' => 'action',     'data' => 'action',     'title' => trans('dashboard/general.actions'),  'className' => 'text-center', 'orderable' => false, 'searchable' => false];

        return $columns;
    }
}