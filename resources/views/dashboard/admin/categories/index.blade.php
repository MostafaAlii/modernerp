@extends('dashboard.layouts.master')
@section('css')
@endsection

@section('title')
{{ $title }}
@endsection

@section('content')
<div class="page-content">
    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/categories.categories') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.categories.index') }}">{{ trans('dashboard/categories.categories') }}</a>
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
                    {{ trans('dashboard/categories.categories') }}
                    <button data-pc-animate="3d-sign" type="button" class="btn btn-sm btn-light btn-active-primary"
                        data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                        <i class="fa fa-plus"></i>
                        {{ trans('dashboard/categories.create') }}
                    </button>

                    @php
                    $locales = array_keys(config('laravellocalization.supportedLocales'));
                    $currentLocale = app()->getLocale();
                    $parentCategory = \App\Models\Category::active()->get();
                    @endphp
                    @include('dashboard.admin.categories.btn.create', compact('locales', 'currentLocale'))
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
<script src="{{ asset('dashboard/assets/js/custom/utils/alert.js') }}"></script>
@endpush