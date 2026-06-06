@extends('dashboard.layouts.master')

@section('css')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
<div class="page-content">

    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/sales_units.sales_units') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.sales_units.index') }}">{{ trans('dashboard/sales_units.sales_units') }}</a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <span class="nav-icon">
                        <i class="ti ti-ruler-measure"></i>
                    </span>
                    {{ trans('dashboard/sales_units.sales_units') }}
                    <button data-pc-animate="3d-sign"
                        type="button"
                        class="btn btn-sm btn-light btn-active-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#createSalesUnitModal">
                        <i class="fa fa-plus"></i>
                        {{ trans('dashboard/sales_units.create') }}
                    </button>

                    @php
                        $locales        = array_keys(config('laravellocalization.supportedLocales'));
                        $currentLocale  = app()->getLocale();
                    @endphp

                    @include('dashboard.admin.sales_units.btn.create', compact('locales', 'currentLocale'))
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-row-bordered gy-5 gs-7">
                            {!! $dataTable->table() !!}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('js')
    {!! $dataTable->scripts() !!}
    <script src="{{ asset('dashboard/assets/js/custom/utils/alert.js') }}"></script>
@endpush