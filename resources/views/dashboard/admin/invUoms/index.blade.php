@extends('dashboard.layouts.master')
@section('css')
@endsection

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="page-content">
    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/inv_uom.inv_uoms') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.invUoms.index') }}">{{ trans('dashboard/inv_uom.inv_uoms') }}</a>
            </li>
        </ul>
    </div>
    <!-- Start Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <span class="nav-icon">
                        <i class="ti ti-ruler-measure"></i>
                    </span>
                    {{ trans('dashboard/inv_uom.inv_uoms') }}
                    <button data-pc-animate="3d-sign" type="button" class="btn btn-sm btn-light btn-active-primary"
                        data-bs-toggle="modal" data-bs-target="#createInvUomModal">
                        <i class="fa fa-plus"></i>
                        {{ trans('dashboard/inv_uom.create') }}
                    </button>

                    @php
                    $locales = array_keys(config('laravellocalization.supportedLocales'));
                    $currentLocale = app()->getLocale();
                    @endphp
                    @include('dashboard.admin.invUoms.btn.create', compact('locales', 'currentLocale'))
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
    <!-- End Content -->
</div>
@endsection

@push('js')
{!! $dataTable->scripts() !!}
<script>
    window.translations = {
        error:    "{{ trans('dashboard/general.error_occurred') }}",
        active:   "{{ trans('dashboard/general.active') }}",
        inactive: "{{ trans('dashboard/general.in_active') }}",
    };
    window.locales = @json(array_keys(config('laravellocalization.supportedLocales')));
    window.routes = {
        update: "{{ route('admin.invUoms.update', ['invUom' => '__ID__']) }}",
        edit: "{{ route('admin.invUoms.edit', ['invUom' => '__ID__']) }}",
        destroy: "{{ route('admin.invUoms.destroy', ['invUom' => '__ID__']) }}",
    };
</script>
<script src="{{ asset('dashboard/assets/js/custom/utils/alert.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/custom/admin/invUoms/index.js') }}"></script>
@endpush