@extends('dashboard.layouts.master')
@section('title') {{ $title }} @endsection
@section('content')
<div class="page-content">
    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/suppliers.suppliers') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ trans('dashboard/suppliers.suppliers') }}</li>
        </ul>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="nav-icon"><i class="ti ti-truck"></i></span>
                        {{ trans('dashboard/suppliers.suppliers') }}
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#createSupplierModal">
                        <i class="fa fa-plus me-1"></i>
                        {{ trans('dashboard/suppliers.create') }}
                    </button>
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
    @php
    $locales = array_keys(config('laravellocalization.supportedLocales'));
    $currentLocale = app()->getLocale();
    @endphp
    @include('dashboard.admin.suppliers.btn.create')
</div>
@endsection
@push('js')
{!! $dataTable->scripts() !!}
<script src="{{ asset('dashboard/assets/js/custom/utils/alert.js') }}"></script>
@endpush
