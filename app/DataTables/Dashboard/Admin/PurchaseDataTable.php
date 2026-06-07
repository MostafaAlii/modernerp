<?php

namespace App\DataTables\Dashboard\Admin;

use App\DataTables\Base\BaseDataTable;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Utilities\Request as DataTableRequest;

class PurchaseDataTable extends BaseDataTable
{
    public function __construct(DataTableRequest $request)
    {
        parent::__construct(new Purchase);
        $this->request = $request;
    }

    public function dataTable($query): EloquentDataTable
    {
        return (new EloquentDataTable($query))

            ->addColumn('action', function (Purchase $purchase) {
                return view('dashboard.admin.purchases.btn.actions', compact('purchase'));
            })

            ->editColumn('supplier', function (Purchase $purchase) {
                return $purchase->supplier?->name ?? '-';
            })

            ->editColumn('store', function (Purchase $purchase) {
                return $purchase->store?->translate(app()->getLocale())?->name ?? '-';
            })

            ->editColumn('invoice_number', function (Purchase $purchase) {
                return $purchase->invoice_number ?? '-';
            })

            ->editColumn('invoice_date', function (Purchase $purchase) {
                return $purchase->invoice_date?->format('Y-m-d') ?? '-';
            })

            ->editColumn('net_amount', function (Purchase $purchase) {
                return number_format($purchase->net_amount, 2);
            })

            ->editColumn('paid_amount', function (Purchase $purchase) {
                return number_format($purchase->paid_amount, 2);
            })

            ->editColumn('remaining_amount', function (Purchase $purchase) {
                $color = $purchase->remaining_amount > 0 ? 'danger' : 'success';
                return '<span class="badge bg-' . $color . '">'
                    . number_format($purchase->remaining_amount, 2)
                    . '</span>';
            })

            ->editColumn('status', function (Purchase $purchase) {
                return '<div class="d-flex justify-content-center">'
                    . $purchase->status->badge()
                    . '</div>';
            })

            ->editColumn('created_at', function (Purchase $purchase) {
                return $this->formatTranslatedDate($purchase->created_at);
            })

            ->addIndexColumn()
            ->rawColumns(['action', 'status', 'remaining_amount', 'created_at']);
    }

    public function query(): QueryBuilder
    {
        return Purchase::query()
            ->with(['supplier', 'store.translations'])
            ->latest();
    }

    public function getColumns(): array
    {
        return [
            ['name' => 'DT_RowIndex',        'data' => 'DT_RowIndex',        'title' => '#',                                              'className' => 'text-center', 'orderable' => false],
            ['name' => 'invoice_number',      'data' => 'invoice_number',      'title' => trans('dashboard/purchases.invoice_number'),      'className' => 'text-center'],
            ['name' => 'supplier',            'data' => 'supplier',            'title' => trans('dashboard/purchases.supplier'),            'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'store',               'data' => 'store',               'title' => trans('dashboard/purchases.store'),               'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'invoice_date',        'data' => 'invoice_date',        'title' => trans('dashboard/purchases.invoice_date'),        'className' => 'text-center'],
            ['name' => 'net_amount',          'data' => 'net_amount',          'title' => trans('dashboard/purchases.net_amount'),          'className' => 'text-center'],
            ['name' => 'paid_amount',         'data' => 'paid_amount',         'title' => trans('dashboard/purchases.paid_amount'),         'className' => 'text-center'],
            ['name' => 'remaining_amount',    'data' => 'remaining_amount',    'title' => trans('dashboard/purchases.remaining_amount'),    'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'status',              'data' => 'status',              'title' => trans('dashboard/purchases.status'),              'className' => 'text-center', 'orderable' => false, 'searchable' => false],
            ['name' => 'created_at',          'data' => 'created_at',          'title' => trans('dashboard/general.created_at'),            'className' => 'text-center'],
            ['name' => 'action',              'data' => 'action',              'title' => trans('dashboard/general.actions'),               'className' => 'text-center', 'orderable' => false, 'searchable' => false],
        ];
    }
}
