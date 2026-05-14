@extends('dashboard.layouts.master')
@section('css')
@endsection

@section('title')
    {{ $title }}
@endsection

@section('content')
<div class="page-content">
    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/treasury.treasuries') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.treasuries.index') }}">{{ trans('dashboard/treasury.treasuries') }}</a>
            </li>
        </ul>
    </div>
    <!-- Start Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <span class="nav-icon">
                        <i class="ti ti-building-bank"></i>
                    </span>
                    {{ trans('dashboard/treasury.treasuries') }}
                    <button data-pc-animate="3d-sign" type="button" class="btn btn-sm btn-light btn-active-primary"
                        data-bs-toggle="modal" data-bs-target="#createTreasuryModal">
                        <i class="fa fa-plus"></i>
                        {{ trans('dashboard/treasury.create') }}
                    </button>

                    @php
                        $locales = array_keys(config('laravellocalization.supportedLocales'));
                        $currentLocale = app()->getLocale();
                    @endphp
                    @include('dashboard.admin.treasuries.btn.create', compact('locales', 'currentLocale'))
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
            master:   "{{ trans('dashboard/treasury.master') }}",
            sub:      "{{ trans('dashboard/treasury.sub') }}",
            active:   "{{ trans('dashboard/general.active') }}",
            inactive: "{{ trans('dashboard/general.in_active') }}",
        };
    </script>
    @if(session('error') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @php
                $locales     = array_keys(config('laravellocalization.supportedLocales'));
                $modalSource = old('modal_source', 'create');
            @endphp

            @if(str_starts_with(old('modal_source', 'create'), 'edit_'))
                @php $editId = str_replace('edit_', '', old('modal_source')); @endphp
                var checkExist = setInterval(function () {
                    var modalEl = document.getElementById('editModal{{ $editId }}');
                    if (modalEl) {
                        clearInterval(checkExist);
                        var modal = new bootstrap.Modal(modalEl);
                        modal.show();
                        @foreach($locales as $locale)
                            @if($errors->has('name.' . $locale))
                                setTimeout(function () {
                                    modalEl.querySelector('[data-bs-target="#edit-tab-{{ $locale }}-{{ $editId }}"]')?.click();
                                }, 300);
                            @endif
                        @endforeach
                    }
                }, 100);

            @else
                var modal = new bootstrap.Modal(document.getElementById('createTreasuryModal'));
                modal.show();
                @foreach($locales as $locale)
                    @if($errors->has('name.' . $locale))
                        document.querySelector('[data-bs-target="#tab-{{ $locale }}"]')?.click();
                    @endif
                @endforeach
            @endif
        });
    </script>
    @endif

    <script src="{{ asset('dashboard/assets/js/custom/utils/alert.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/custom/admin/treasuries/index.js') }}"></script>
@endpush
