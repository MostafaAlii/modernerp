<div class="card mb-4" id="variantsCard">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <i class="ti ti-versions me-2"></i>
            {{ trans('dashboard/products.variants') }}
        </div>
        <button type="button" class="btn btn-sm btn-primary" id="addVariantBtn">
            <i class="fa fa-plus me-1"></i>
            {{ trans('dashboard/products.add_variant') }}
        </button>
    </div>
    <div class="card-body">
        <div id="variantsContainer">
            {{-- هيتملى ديناميكياً بالـ JavaScript --}}
        </div>
    </div>
</div>

{{-- TEMPLATE مخفي هيتنسخ بالـ JS عند إضافة variant جديد --}}
<template id="variantTemplate">
    <div class="variant-item border rounded p-3 mb-3" data-index="__INDEX__">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0 variant-title">
                {{ trans('dashboard/products.variant') }} #<span class="variant-number">1</span>
            </h6>
            <button type="button" class="btn btn-sm btn-light-danger remove-variant-btn">
                <i class="fa fa-trash"></i>
            </button>
        </div>

        <div class="row">

            {{-- COLOR (يظهر لو variant_type = 1 أو 3) --}}
            <div class="col-md-6 mb-3 field-color d-none">
                <label class="form-label">{{ trans('dashboard/products.color') }}</label>
                <select name="variants[__INDEX__][color_id]" class="form-control">
                    <option value="">-- {{ trans('dashboard/products.select_color') }} --</option>
                    @foreach($colors as $color)
                        <option value="{{ $color->id }}"
                            style="background-color: {{ $color->hex_code }}">
                            {{ $color->translate($currentLocale)?->name ?? $color->translate('ar')?->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SIZE (يظهر لو variant_type = 2 أو 3) --}}
            <div class="col-md-6 mb-3 field-size d-none">
                <label class="form-label">{{ trans('dashboard/products.size') }}</label>
                <select name="variants[__INDEX__][size_id]" class="form-control">
                    <option value="">-- {{ trans('dashboard/products.select_size') }} --</option>
                    @foreach($sizes as $size)
                        <option value="{{ $size->id }}">
                            {{ $size->translate($currentLocale)?->name ?? $size->translate('ar')?->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- SKU
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ trans('dashboard/products.sku') }}</label>
                <input type="text"
                    name="variants[__INDEX__][sku]"
                    class="form-control"
                    placeholder="AUTO">
            </div>--}}

            {{-- BARCODE 
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ trans('dashboard/products.barcode') }}</label>
                <input type="text"
                    name="variants[__INDEX__][barcode]"
                    class="form-control">
            </div>--}}

            {{-- QUANTITY --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    {{ trans('dashboard/products.quantity') }}
                    <span class="text-danger">*</span>
                </label>
                <input type="number"
                    name="variants[__INDEX__][quantity]"
                    class="form-control"
                    value="0"
                    min="0">
            </div>

            {{-- MIN STOCK ALERT --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ trans('dashboard/products.min_stock_alert') }}</label>
                <input type="number"
                    name="variants[__INDEX__][min_stock_alert]"
                    class="form-control"
                    value="0"
                    min="0">
            </div>

        </div>

        {{-- PRICES per Sales Unit --}}
        <div class="mt-3">
            <h6 class="mb-3 border-bottom pb-2">
                <i class="ti ti-tag me-1"></i>
                {{ trans('dashboard/products.prices') }}
            </h6>
            <div class="row">
                @foreach($salesUnits as $unit)
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            {{ $unit->translate($currentLocale)?->name ?? $unit->translate('ar')?->name }}
                        </label>
                        <div class="input-group">
                            <input type="number"
                                name="variants[__INDEX__][prices][{{ $unit->id }}][price]"
                                class="form-control"
                                placeholder="{{ trans('dashboard/products.price') }}"
                                min="0"
                                step="0.01">
                            <input type="number"
                                name="variants[__INDEX__][prices][{{ $unit->id }}][cost_price]"
                                class="form-control"
                                placeholder="{{ trans('dashboard/products.cost_price') }}"
                                min="0"
                                step="0.01">
                        </div>
                        <small class="text-muted">
                            {{ trans('dashboard/products.price') }} /
                            {{ trans('dashboard/products.cost_price') }}
                        </small>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</template>