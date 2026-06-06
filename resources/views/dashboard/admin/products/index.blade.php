@extends('dashboard.layouts.master')

@section('title')
    {{ $title }}
@endsection

@section('content')
<div class="page-content">

    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/products.products') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item active">
                {{ trans('dashboard/products.products') }}
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="nav-icon"><i class="ti ti-shirt"></i></span>
                        <span>{{ trans('dashboard/products.products') }}</span>
                    </div>
                    <a href="{{ route('admin.products.create') }}"
                        class="btn btn-sm btn-primary">
                        <i class="fa fa-plus me-1"></i>
                        {{ trans('dashboard/products.create') }}
                    </a>
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