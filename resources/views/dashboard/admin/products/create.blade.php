@extends('dashboard.layouts.master')

@section('title')
    {{ trans('dashboard/products.create') }}
@endsection

@section('content')
<div class="page-content">

    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/products.create') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}">{{ trans('dashboard/products.products') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ trans('dashboard/products.create') }}</li>
        </ul>
    </div>
    <br>

    <form action="{{ route('admin.products.store') }}" method="POST" id="productForm" enctype="multipart/form-data">
        @csrf
        @php
            $locales       = array_keys(config('laravellocalization.supportedLocales'));
            $currentLocale = app()->getLocale();
            $product       = new \App\Models\Product();
        @endphp

        <div class="row">
            <div class="col-lg-12">
                @include('dashboard.admin.products.partials._basic_info')
                @include('dashboard.admin.products.partials._variants')
            </div>

            <div class="col-lg-12">
                {{-- SUBMIT CARD --}}
                <div class="card mb-12">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100 mb-2">
                            <i class="fa fa-save me-1"></i>
                            {{ trans('dashboard/general.save') }}
                        </button>
                        <a href="{{ route('admin.products.index') }}"
                            class="btn btn-secondary w-100">
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
    <script>
        // بيانات الـ variant types من PHP للـ JS
        const VARIANT_TYPES = {
            SIMPLE:     0,
            COLOR:      1,
            SIZE:       2,
            COLOR_SIZE: 3,
        };

        let variantIndex = 0;

        // لما يتغير نوع المنتج
        document.getElementById('variantTypeSelect').addEventListener('change', function () {
            updateVariantFields();
        });

        // إضافة variant جديد
        document.getElementById('addVariantBtn').addEventListener('click', function () {
            addVariant();
        });

        function addVariant() {
            const template  = document.getElementById('variantTemplate').innerHTML;
            const html      = template.replaceAll('__INDEX__', variantIndex);
            const container = document.getElementById('variantsContainer');

            container.insertAdjacentHTML('beforeend', html);

            // اعمل update للـ fields بناءً على النوع الحالي
            updateVariantFields();

            // رقم الـ variant في العنوان
            updateVariantNumbers();

            // زرار الحذف
            const items = container.querySelectorAll('.variant-item');
            const lastItem = items[items.length - 1];
            lastItem.querySelector('.remove-variant-btn').addEventListener('click', function () {
                lastItem.remove();
                updateVariantNumbers();
            });

            variantIndex++;
        }

        function updateVariantFields() {
            const type  = parseInt(document.getElementById('variantTypeSelect').value);
            const items = document.querySelectorAll('.variant-item');

            items.forEach(item => {
                const colorField = item.querySelector('.field-color');
                const sizeField  = item.querySelector('.field-size');

                // إظهار/إخفاء حقل اللون
                if (type === VARIANT_TYPES.COLOR || type === VARIANT_TYPES.COLOR_SIZE) {
                    colorField.classList.remove('d-none');
                } else {
                    colorField.classList.add('d-none');
                }

                // إظهار/إخفاء حقل المقاس
                if (type === VARIANT_TYPES.SIZE || type === VARIANT_TYPES.COLOR_SIZE) {
                    sizeField.classList.remove('d-none');
                } else {
                    sizeField.classList.add('d-none');
                }
            });
        }

        function updateVariantNumbers() {
            document.querySelectorAll('.variant-item').forEach((item, index) => {
                item.querySelector('.variant-number').textContent = index + 1;
            });
        }

        // Status switch label
        document.getElementById('productStatusSwitch').addEventListener('change', function () {
            document.getElementById('productStatusLabel').textContent = this.checked
                ? '{{ trans("dashboard/general.active") }}'
                : '{{ trans("dashboard/general.in_active") }}';
        });

        // إضافة variant أول تلقائياً عند فتح الصفحة
        addVariant();

        // IMAGE PREVIEW
        document.getElementById('imageInput')?.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function (e) {
                const preview     = document.getElementById('imagePreview');
                const placeholder = document.getElementById('imagePlaceholder');

                preview.src = e.target.result;
                preview.classList.remove('d-none');

                if (placeholder) placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        });

        // REMOVE IMAGE (edit only)
        document.getElementById('removeImageBtn')?.addEventListener('click', function () {
            document.getElementById('removeImageInput').value = '1';
            document.getElementById('imagePreview').src       = '';
            document.getElementById('imagePreview').classList.add('d-none');

            // أعد الـ placeholder
            const placeholder = document.getElementById('imagePlaceholder');
            if (placeholder) placeholder.classList.remove('d-none');

            this.classList.add('d-none');
        });
    </script>
@endpush