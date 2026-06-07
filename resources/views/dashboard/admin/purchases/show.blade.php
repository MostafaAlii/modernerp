@extends('dashboard.layouts.master')

@section('title')
{{ trans('dashboard/purchases.purchase') }} #{{ $purchase->invoice_number }}
@endsection

@section('content')
<div class="page-content">

    <div class="content-header">
        <h1 class="mb-0">
            {{ trans('dashboard/purchases.purchase') }}
            <span class="text-muted fs-5">#{{ $purchase->invoice_number }}</span>
        </h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.purchases.index') }}">{{ trans('dashboard/purchases.purchases') }}</a>
            </li>
            <li class="breadcrumb-item active">#{{ $purchase->invoice_number }}</li>
        </ul>
    </div>

    <div class="row">

        {{-- MAIN CONTENT --}}
        <div class="col-lg-8">

            {{-- ITEMS TABLE --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="ti ti-list me-2"></i>
                    {{ trans('dashboard/purchases.items') }}
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>{{ trans('dashboard/purchases.product') }}</th>
                                    <th class="text-center">{{ trans('dashboard/purchases.sales_unit') }}</th>
                                    <th class="text-center">{{ trans('dashboard/purchases.quantity') }}</th>
                                    <th class="text-center">{{ trans('dashboard/purchases.unit_price') }}</th>
                                    <th class="text-center">{{ trans('dashboard/purchases.total_price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchase->items as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        {{-- اسم المنتج --}}
                                        <div class="fw-bold">
                                            {{ $item->variant?->product?->translate(app()->getLocale())?->name
                                            ?? $item->variant?->product?->translate('ar')?->name
                                            ?? '-' }}
                                        </div>
                                        {{-- اللون والمقاس --}}
                                        <div class="d-flex gap-2 mt-1">
                                            @if($item->variant?->color)
                                            <span class="badge"
                                                style="background-color: {{ $item->variant->color->hex_code }}; color: #fff;">
                                                {{ $item->variant->color->translate(app()->getLocale())?->name }}
                                            </span>
                                            @endif
                                            @if($item->variant?->size)
                                            <span class="badge bg-secondary">
                                                {{ $item->variant->size->translate(app()->getLocale())?->name }}
                                            </span>
                                            @endif
                                        </div>
                                        {{-- SKU --}}
                                        @if($item->variant?->sku)
                                        <small class="text-muted">
                                            SKU: {{ $item->variant->sku }}
                                        </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $item->salesUnit?->translate(app()->getLocale())?->name ?? '-' }}
                                    </td>
                                    <td class="text-center fw-bold">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="text-center">
                                        {{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="text-center fw-bold text-primary">
                                        {{ number_format($item->total_price, 2) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">
                                        {{ trans('dashboard/purchases.total_amount') }}
                                    </td>
                                    <td class="text-center fw-bold">
                                        {{ number_format($purchase->total_amount, 2) }}
                                    </td>
                                </tr>
                                @if($purchase->discount > 0)
                                <tr>
                                    <td colspan="5" class="text-end text-danger">
                                        {{ trans('dashboard/purchases.discount') }}
                                    </td>
                                    <td class="text-center text-danger">
                                        - {{ number_format($purchase->discount, 2) }}
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="5" class="text-end fw-bold">
                                        {{ trans('dashboard/purchases.net_amount') }}
                                    </td>
                                    <td class="text-center fw-bold text-success">
                                        {{ number_format($purchase->net_amount, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        {{-- SIDEBAR INFO --}}
        <div class="col-lg-4">

            {{-- STATUS --}}
            <div class="card mb-3">
                <div class="card-body text-center">
                    <div class="mb-2">
                        <small class="text-muted d-block mb-1">{{ trans('dashboard/purchases.status') }}</small>
                        {!! $purchase->status->badge() !!}
                    </div>

                    {{-- ACTIONS --}}
                    <div class="d-flex gap-2 justify-content-center mt-3">
                        @if($purchase->status->isDraft())
                        <a href="{{ route('admin.purchases.edit', $purchase->id) }}"
                            class="btn btn-sm btn-light-primary">
                            <i class="fa fa-edit me-1"></i>
                            {{ trans('dashboard/purchases.edit') }}
                        </a>

                        <form action="{{ route('admin.purchases.confirm', $purchase->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="ti ti-check me-1"></i>
                                {{ trans('dashboard/purchases.confirm') }}
                            </button>
                        </form>
                        @endif

                        @if(!$purchase->status->isCancelled())
                        <form action="{{ route('admin.purchases.cancel', $purchase->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-warning">
                                <i class="ti ti-ban me-1"></i>
                                {{ trans('dashboard/purchases.cancel') }}
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            {{-- INVOICE INFO --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="ti ti-info-circle me-2"></i>
                    {{ trans('dashboard/purchases.invoice_info') }}
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/purchases.invoice_number') }}</td>
                            <td class="fw-bold">{{ $purchase->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/purchases.invoice_date') }}</td>
                            <td>{{ $purchase->invoice_date?->format('Y-m-d') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/purchases.supplier') }}</td>
                            <td>{{ $purchase->supplier?->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/purchases.store') }}</td>
                            <td>
                                {{ $purchase->store?->translate(app()->getLocale())?->name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/general.created_at') }}</td>
                            <td>{{ $purchase->created_at?->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/general.created_by') }}</td>
                            <td>{{ $purchase->createdBy?->name ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- PAYMENT INFO --}}
            <div class="card mb-3">
                <div class="card-header">
                    <i class="ti ti-cash me-2"></i>
                    {{ trans('dashboard/purchases.payment_info') }}
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless mb-0">
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/purchases.total_amount') }}</td>
                            <td class="fw-bold">{{ number_format($purchase->total_amount, 2) }}</td>
                        </tr>
                        @if($purchase->discount > 0)
                        <tr>
                            <td class="text-muted text-danger">{{ trans('dashboard/purchases.discount') }}</td>
                            <td class="text-danger">- {{ number_format($purchase->discount, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/purchases.net_amount') }}</td>
                            <td class="fw-bold text-success">{{ number_format($purchase->net_amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">{{ trans('dashboard/purchases.paid_amount') }}</td>
                            <td class="text-primary">{{ number_format($purchase->paid_amount, 2) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="text-muted fw-bold">{{ trans('dashboard/purchases.remaining_amount') }}</td>
                            <td class="fw-bold {{ $purchase->remaining_amount > 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($purchase->remaining_amount, 2) }}
                            </td>
                        </tr>
                    </table>

                    {{-- PAYMENT PROGRESS BAR --}}
                    @if($purchase->net_amount > 0)
                    @php
                    $percentage = min(100, ($purchase->paid_amount / $purchase->net_amount) * 100);
                    @endphp
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="text-muted">{{ trans('dashboard/purchases.payment_progress') }}</small>
                            <small class="fw-bold">{{ number_format($percentage, 0) }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar {{ $percentage >= 100 ? 'bg-success' : 'bg-primary' }}"
                                style="width: {{ $percentage }}%">
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- NOTES --}}
            @if($purchase->notes)
            <div class="card mb-3">
                <div class="card-header">
                    <i class="ti ti-notes me-2"></i>
                    {{ trans('dashboard/purchases.notes') }}
                </div>
                <div class="card-body">
                    <p class="mb-0 text-muted">{{ $purchase->notes }}</p>
                </div>
            </div>
            @endif

            {{-- BACK BUTTON --}}
            <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary w-100">
                <i class="ti ti-arrow-left me-1"></i>
                {{ trans('dashboard/general.back') }}
            </a>

        </div>
    </div>

</div>
@endsection
