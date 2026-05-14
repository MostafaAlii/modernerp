<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\SalesMatrialType;
use App\Enums\SalesMatrialType\SalesMatrialTypeStatus;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class SalesMatrialTypeDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new SalesMatrialType);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (SalesMatrialType $salesMatrialType) {
                return view('dashboard.admin.salesMatrialTypes.btn.actions', compact('salesMatrialType'));
            })
            ->editColumn('name', function (SalesMatrialType $salesMatrialType) {
                return $salesMatrialType->translate(app()->getLocale())?->name ?? $salesMatrialType->translate('ar')?->name ?? '-';
            })
            ->editColumn('is_active', function (SalesMatrialType $salesMatrialType) {
                return '
                    <div class="gap-1 d-flex flex-column align-items-center">
                        <span class="badge-status">' . $salesMatrialType->is_active->badge() . '</span>
                        <div class="form-check form-switch">
                            <input type="checkbox"
                                class="form-check-input toggle-status"
                                data-route="' . route('admin.salesMatrialTypes.toggleStatus', $salesMatrialType->id) . '"
                                ' . ($salesMatrialType->is_active === SalesMatrialTypeStatus::ACTIVE ? 'checked' : '') . '>
                        </div>
                    </div>
                ';
            })
            ->editColumn('company', function (SalesMatrialType $salesMatrialType) {
                return $salesMatrialType->company?->name ?? '-';
            })
            ->editColumn('created_at', function (SalesMatrialType $salesMatrialType) {
                return $this->formatTranslatedDate($salesMatrialType->created_at);
            })
            ->editColumn('updated_at', function (SalesMatrialType $salesMatrialType) {
                return $this->formatTranslatedDate($salesMatrialType->updated_at);
            })
            ->rawColumns(['action', 'is_active', 'created_at', 'updated_at']);
    }

    public function query(): QueryBuilder
    {
        return SalesMatrialType::query()
            ->with(['translations', 'company'])
            ->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id',         'data' => 'id',         'title' => '#',                                          'className' => 'text-center'],
            ['name' => 'name',       'data' => 'name',       'title' => trans('dashboard/sales_matrial_type.name'),             'className' => 'text-center', 'searchable' => false],
            ['name' => 'is_active',  'data' => 'is_active',  'title' => trans('dashboard/sales_matrial_type.is_active'),        'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'company',    'data' => 'company',    'title' => trans('dashboard/sales_matrial_type.company'),          'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'),        'className' => 'text-center'],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'),        'className' => 'text-center'],
            ['name' => 'action',     'data' => 'action',     'title' => trans('dashboard/general.actions'),           'className' => 'text-center', 'orderable' => false, 'searchable' => false],
        ];
    }
}
