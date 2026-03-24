<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Treasury;
use App\Enums\Treasury\TreasuryStatus;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class TreasuryDataTable extends BaseDataTable {
    public function __construct(DataTableRequest $request) {
        parent::__construct(new Treasury);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable {
        return (new EloquentDataTable($query))
            ->addColumn('action', function (Treasury $treasury) {
                return view('dashboard.admin.treasuries.btn.actions', compact('treasury'));
            })
            ->editColumn('name', function (Treasury $treasury) {
                return $treasury->translate(app()->getLocale())?->name
                    ?? $treasury->translate('ar')?->name
                    ?? '-';
            })
            ->editColumn('is_active', function (Treasury $treasury) {
                return TreasuryStatus::from($treasury->is_active->value)->badge();
            })
            ->editColumn('is_master', function (Treasury $treasury) {
                return $treasury->is_master
                    ? '<span class="badge bg-primary">'  . trans('dashboard/treasury.master') . '</span>'
                    : '<span class="badge bg-secondary">' . trans('dashboard/treasury.sub')   . '</span>';
            })
            ->editColumn('company', function (Treasury $treasury) {
                return $treasury->company?->name ?? '-';
            })
            ->addColumn('receipts', function (Treasury $treasury) {
                $collect = $treasury->last_collect_receipt
                    ? '<span class="text-success fw-bold">' . $treasury->last_collect_receipt . ' <i class="ti ti-arrow-down-circle"></i></span>'
                    : '<span class="text-muted">' . trans('dashboard/treasury.no_receipt') . '</span>';

                $exchange = $treasury->last_exchange_receipt
                    ? '<span class="text-danger fw-bold">' . $treasury->last_exchange_receipt . ' <i class="ti ti-arrow-up-circle"></i></span>'
                    : '<span class="text-muted">' . trans('dashboard/treasury.no_receipt') . '</span>';

                return '
                    <div class="text-center">
                        <div class="mb-1">
                            <span class="badge bg-success">' . trans('dashboard/treasury.last_collect_receipt') . '</span>
                            ' . $collect . '
                        </div>
                        <div>
                            <span class="badge bg-danger">' . trans('dashboard/treasury.last_exchange_receipt') . '</span>
                            ' . $exchange . '
                        </div>
                    </div>
                ';
            })
            ->editColumn('created_at', function (Treasury $treasury) {
                return $this->formatTranslatedDate($treasury->created_at);
            })
            ->editColumn('updated_at', function (Treasury $treasury) {
                return $this->formatTranslatedDate($treasury->updated_at);
            })
            ->rawColumns(['action', 'is_active', 'receipts', 'is_master', 'created_at', 'updated_at']);
    }

    public function query(): QueryBuilder {
        return Treasury::query()
        ->with(['translations', 'company'])
        ->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'id',         'data' => 'id',         'title' => '#',                                          'className' => 'text-center'],
            ['name' => 'name',       'data' => 'name',       'title' => trans('dashboard/treasury.name'),             'className' => 'text-center'],
            ['name' => 'is_master',  'data' => 'is_master',  'title' => trans('dashboard/treasury.is_master'),        'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'is_active',  'data' => 'is_active',  'title' => trans('dashboard/treasury.is_active'),        'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'company',    'data' => 'company',    'title' => trans('dashboard/treasury.company'),          'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'receipts', 'data' => 'receipts', 'title' => trans('dashboard/treasury.receipts'), 'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => trans('dashboard/general.created_at'),        'className' => 'text-center'],
            ['name' => 'updated_at', 'data' => 'updated_at', 'title' => trans('dashboard/general.updated_at'),        'className' => 'text-center'],
            ['name' => 'action',     'data' => 'action',     'title' => trans('dashboard/general.actions'),           'className' => 'text-center', 'orderable' => false, 'searchable' => false],
        ];
    }
}