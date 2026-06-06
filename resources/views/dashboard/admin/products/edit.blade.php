@extends('dashboard.layouts.master')

@section('title')
    {{ trans('dashboard/products.edit') }}
@endsection

@section('content')
<div class="page-content">

    <div class="content-header">
        <h1 class="mb-0">{{ trans('dashboard/products.edit') }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('admin.dashboard') }}">{{ trans('dashboard/header.main_dashboard') }}</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('admin.products.index') }}">{{ trans('dashboard/products.products') }}</a>
            </li>
            <li class="breadcrumb-item active">{{ trans('dashboard/products.edit') }}</li>
        </ul>
    </div>

    @php
        $locales       = array_keys(config('laravellocalization.supportedLocales'));
        $currentLocale = app()->getLocale();

        // احسب البيانات هنا بعيداً عن الـ JS
        $existingVariantsData = $product->variants->map(function($v) {
            return [
                'color_id'        => $v->color_id,
                'size_id'         => $v->size_id,
                'sku'             => $v->sku,
                'barcode'         => $v->barcode,
                'quantity'        => $v->quantity,
                'min_stock_alert' => $v->min_stock_alert,
                'prices'          => $v->prices->map(function($p) {
                    return [
                        'sales_unit_id' => $p->sales_unit_id,
                        'price'         => $p->price,
                        'cost_price'    => $p->cost_price,
                    ];
                })->toArray(),
            ];
        })->toArray();
    @endphp

    <form action="{{ route('admin.products.update', $product->id) }}"
        method="POST"
        id="productForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-12">
                @include('dashboard.admin.products.partials._basic_info')
                @include('dashboard.admin.products.partials._variants')
            </div>

            <div class="col-lg-12">
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
    const VARIANT_TYPES = {
        SIMPLE:     0,
        COLOR:      1,
        SIZE:       2,
        COLOR_SIZE: 3,
    };

    let variantIndex = 0;

    document.getElementById('variantTypeSelect').addEventListener('change', function () {
        updateVariantFields();
    });

    document.getElementById('addVariantBtn').addEventListener('click', function () {
        addVariant();
    });

    function addVariant(existingData = null) {
        const template  = document.getElementById('variantTemplate').innerHTML;
        const html      = template.replaceAll('__INDEX__', variantIndex);
        const container = document.getElementById('variantsContainer');

        container.insertAdjacentHTML('beforeend', html);

        const items   = container.querySelectorAll('.variant-item');
        const newItem = items[items.length - 1];

        if (existingData) {
            if (existingData.color_id) {
                newItem.querySelector(`select[name*="color_id"]`).value = existingData.color_id;
            }
            if (existingData.size_id) {
                newItem.querySelector(`select[name*="size_id"]`).value = existingData.size_id;
            }
            newItem.querySelector(`input[name*="[quantity]"]`).value        = existingData.quantity ?? 0;
            newItem.querySelector(`input[name*="[min_stock_alert]"]`).value = existingData.min_stock_alert ?? 0;
            if (existingData.prices) {
                existingData.prices.forEach(price => {
                    const priceInput = newItem.querySelector(
                        `input[name*="[prices][${price.sales_unit_id}][price]"]`
                    );
                    const costInput = newItem.querySelector(
                        `input[name*="[prices][${price.sales_unit_id}][cost_price]"]`
                    );
                    if (priceInput) priceInput.value = price.price;
                    if (costInput)  costInput.value  = price.cost_price;
                });
            }
        }

        updateVariantFields();
        updateVariantNumbers();

        newItem.querySelector('.remove-variant-btn').addEventListener('click', function () {
            newItem.remove();
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

            type === VARIANT_TYPES.COLOR || type === VARIANT_TYPES.COLOR_SIZE
                ? colorField.classList.remove('d-none')
                : colorField.classList.add('d-none');

            type === VARIANT_TYPES.SIZE || type === VARIANT_TYPES.COLOR_SIZE
                ? sizeField.classList.remove('d-none')
                : sizeField.classList.add('d-none');
        });
    }

    function updateVariantNumbers() {
        document.querySelectorAll('.variant-item').forEach((item, index) => {
            item.querySelector('.variant-number').textContent = index + 1;
        });
    }

    document.getElementById('productStatusSwitch').addEventListener('change', function () {
        document.getElementById('productStatusLabel').textContent = this.checked
            ? '{{ trans("dashboard/general.active") }}'
            : '{{ trans("dashboard/general.in_active") }}';
    });

    // ✅ الحل - البيانات اتحسبت في PHP مسبقاً
    const existingVariants = @json($existingVariantsData);

    if (existingVariants.length > 0) {
        existingVariants.forEach(variant => addVariant(variant));
    } else {
        addVariant();
    }
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