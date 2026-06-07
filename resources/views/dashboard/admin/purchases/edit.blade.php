@extends('dashboard.layouts.master')

@section('title') {{ trans('dashboard/purchases.edit') }} @endsection

@section('content')
<div class="page-content">

    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/purchases.edit') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.purchases.index') }}">{{ trans('dashboard/purchases.purchases') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ trans('dashboard/purchases.edit') }}</li>
        </ul>
    </div>

    @php
    $currentLocale = app()->getLocale();

    $existingItems = $purchase->items->map(function($item) {
    return [
    'product_variant_id' => $item->product_variant_id,
    'sales_unit_id' => $item->sales_unit_id,
    'quantity' => $item->quantity,
    'unit_price' => $item->unit_price,
    'total_price' => $item->total_price,
    ];
    })->toArray();
    @endphp

    <form action="{{ route('admin.purchases.update', $purchase->id) }}" method="POST" id="purchaseForm">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-9">
                @include('dashboard.admin.purchases.partials._info')
                @include('dashboard.admin.purchases.partials._items')
            </div>
            <div class="col-lg-3">
                <div class="card mb-3">
                    <div class="card-body">
                        {{-- STATUS BADGE --}}
                        <div class="mb-3 text-center">
                            {!! $purchase->status->badge() !!}
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fa fa-save me-1"></i>
                            {{ trans('dashboard/general.save') }}
                        </button>
                        <a href="{{ route('admin.purchases.index') }}" class="btn btn-secondary w-100">
                            {{ trans('dashboard/general.cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </form>

</div>
@endsection

@push('js')
@include('dashboard.admin.purchases.partials._js')
<script>
    // املى الـ items الموجودة
    const existingItems = @json($existingItems);

    if (existingItems.length > 0) {
        existingItems.forEach(item => addItem(item));
    } else {
        addItem();
    }
</script>
@endpush
