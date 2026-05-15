<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\InvUom;
use App\Enums\InvUom\UomStatus;
use App\Enums\InvUom\UomMaster;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class InvUomDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new InvUom);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        $dataTable = (new EloquentDataTable($query))
            ->addColumn('action', function (InvUom $invUom) {
                return view('dashboard.admin.invUoms.btn.actions', compact('invUom'));
            })
            ->editColumn('name', function (InvUom $invUom) {
                return $invUom->translate(app()->getLocale())?->name
                    ?? $invUom->translate('ar')?->name
                    ?? '-';
            })
            ->editColumn('is_active', function (InvUom $invUom) {
                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-status">' . $invUom->is_active->badge() . '</span>
                        <div class="form-check form-switch">
                            <input type="checkbox"
                                class="form-check-input toggle-status"
                                data-id="' . $invUom->id . '"
                                data-route="' . route('admin.invUoms.toggleStatus', $invUom->id) . '"
                                ' . ($invUom->is_active === UomStatus::ACTIVE ? 'checked' : '') . '>
                        </div>
                    </div>
                ';
            })
            ->editColumn('is_master', function (InvUom $invUom) {
                $badge = $invUom->is_master->badge();

                return '
                    <div class="d-flex flex-column align-items-center gap-1">
                        <span class="badge-master">' . $badge . '</span>
                        <div class="form-check form-switch">
                            <input type="checkbox"
                                class="form-check-input toggle-master"
                                data-route="' . route('admin.invUoms.toggleMaster', $invUom->id) . '"
                                ' . ($invUom->is_master === UomMaster::MASTER ? 'checked' : '') . '>
                        </div>
                    </div>
                ';
            });
        if (EnsureOwner::check()) {
            $dataTable->editColumn('company', function (InvUom $invUom) {
                return $invUom->company?->name ?? '-';
            });
        }
        $dataTable->editColumn('created_at', function (InvUom $invUom) {
            return $this->formatTranslatedDate($invUom->created_at);
        })
            ->editColumn('updated_at', function (InvUom $invUom) {
                return $this->formatTranslatedDate($invUom->updated_at);
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'is_active', 'is_master', 'created_at', 'updated_at']);
        return $dataTable;
    }

    public function query(): QueryBuilder {
        $query = InvUom::query()->with(['translations'])->latest();
        if (EnsureOwner::check()) {
            $query->with(['company']);
        }
        return $query;
    }
    public function getColumns(): array {
        $columns = [
            ['name' => 'DT_RowIndex', 'data' => 'DT_RowIndex', 'title' => '#', 'className' => 'text-center', 'orderable' => false],
            ['name' => 'name',       'data' => 'name',       'title' => trans('dashboard/inv_uom.name'),              'className' => 'text-center', 'searchable' => false],
            ['name' => 'is_master',  'data' => 'is_master',  'title' => trans('dashboard/inv_uom.is_master'),        'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'is_active',  'data' => 'is_active',  'title' => trans('dashboard/inv_uom.is_active'),        'className' => 'text-center', 'orderable' => false, 'searchable' => false],
        ];
        if (EnsureOwner::check()) {
            $columns[] = ['name' => 'company', 'data' => 'company', 'title' => trans('dashboard/inv_uom.company'), 'className' => 'text-center', 'orderable' => false, 'searchable' => false];
        }

        $columns[] = ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'), 'className' => 'text-center'];
        $columns[] = ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'), 'className' => 'text-center'];
        $columns[] = ['name' => 'action',     'data' => 'action',     'title' => trans('dashboard/general.actions'),  'className' => 'text-center', 'orderable' => false, 'searchable' => false];
        return $columns;
    }
}