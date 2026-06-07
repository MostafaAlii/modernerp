@extends('dashboard.layouts.master')

@section('title') {{ trans('dashboard/purchases.create') }} @endsection

@section('content')
<div class="page-content">
    <br>
    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/purchases.create') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.purchases.index') }}">{{ trans('dashboard/purchases.purchases') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ trans('dashboard/purchases.create') }}</li>
        </ul>
    </div>
    <br>

    @php
    $purchase = new \App\Models\Purchase();
    $currentLocale = app()->getLocale();
    @endphp

    <form action="{{ route('admin.purchases.store') }}" method="POST" id="purchaseForm">
        @csrf
        <div class="row">
            <div class="col-lg-12">
                @include('dashboard.admin.purchases.partials._info')
                @include('dashboard.admin.purchases.partials._items')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
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
    // إضافة row أول تلقائياً
    addItem();
</script>
@endpush
