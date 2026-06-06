{{-- LANGUAGES TABS --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="ti ti-language me-2"></i>
        {{ trans('dashboard/general.translations') }}
    </div>
    <div class="card-body">
        <ul class="mb-3 nav nav-tabs">
            @foreach($locales as $locale)
                <li class="nav-item">
                    <button type="button"
                        class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                        data-bs-toggle="tab"
                        data-bs-target="#product-tab-{{ $locale }}">
                        {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                    </button>
                </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($locales as $locale)
                <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                    id="product-tab-{{ $locale }}">

                    <div class="mb-3">
                        <label class="form-label">
                            {{ trans('dashboard/products.name') }} ({{ strtoupper($locale) }})
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            name="name[{{ $locale }}]"
                            class="form-control @error('name.' . $locale) is-invalid @enderror"
                            value="{{ old('name.' . $locale, $product->translate($locale)?->name ?? '') }}">
                        @error('name.' . $locale)
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            {{ trans('dashboard/products.description') }} ({{ strtoupper($locale) }})
                        </label>
                        <textarea name="description[{{ $locale }}]"
                            class="form-control"
                            rows="3">{{ old('description.' . $locale, $product->translate($locale)?->description ?? '') }}</textarea>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- BASIC INFO --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="ti ti-info-circle me-2"></i>
        {{ trans('dashboard/products.basic_info') }}
    </div>
    <div class="card-body">
        <div class="row">

            {{-- CATEGORY --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    {{ trans('dashboard/products.category') }}
                    <span class="text-danger">*</span>
                </label>
                <select name="category_id"
                    class="form-control @error('category_id') is-invalid @enderror">
                    <option value="">-- {{ trans('dashboard/products.select_category') }} --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                            {{ $category->translate($currentLocale)?->name ?? $category->translate('ar')?->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- BRAND --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ trans('dashboard/products.brand') }}</label>
                <select name="brand_id" class="form-control">
                    <option value="">-- {{ trans('dashboard/products.select_brand') }} --</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}"
                            {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                            {{ $brand->translate($currentLocale)?->name ?? $brand->translate('ar')?->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- VARIANT TYPE --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    {{ trans('dashboard/products.variant_type') }}
                    <span class="text-danger">*</span>
                </label>
                <select name="variant_type"
                    id="variantTypeSelect"
                    class="form-control @error('variant_type') is-invalid @enderror">
                    @foreach($variantTypes as $type)
                        <option value="{{ $type->value }}"
                            {{ old('variant_type', $product->variant_type->value ?? 0) == $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STATUS --}}
            <div class="col-md-6 mb-3">
                <label class="form-label d-block">{{ trans('dashboard/products.is_active') }}</label>
                <div class="form-check form-switch mt-2">
                    <input type="hidden" name="status" value="0">
                    <input class="form-check-input"
                        type="checkbox"
                        name="status"
                        value="1"
                        id="productStatusSwitch"
                        {{ old('status', $product->status->value ?? 1) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="productStatusSwitch">
                        <span id="productStatusLabel">
                            {{ old('status', $product->status->value ?? 1) == 1
                                ? trans('dashboard/general.active')
                                : trans('dashboard/general.in_active') }}
                        </span>
                    </label>
                </div>
            </div>

            {{-- HAS BARCODE --}}
            <div class="col-md-6 mb-3">
                <label class="form-label d-block">{{ trans('dashboard/products.has_barcode') }}</label>
                <div class="form-check form-switch mt-2">
                    <input type="hidden" name="has_barcode" value="0">
                    <input class="form-check-input"
                        type="checkbox"
                        name="has_barcode"
                        value="1"
                        id="hasBarcodeSwitch"
                        {{ old('has_barcode', $product->has_barcode ?? true) ? 'checked' : '' }}>
                    <label class="form-check-label" for="hasBarcodeSwitch">
                        {{ trans('dashboard/products.has_barcode') }}
                    </label>
                </div>
            </div>

            {{-- HAS QR --}}
            <div class="col-md-6 mb-3">
                <label class="form-label d-block">{{ trans('dashboard/products.has_qr') }}</label>
                <div class="form-check form-switch mt-2">
                    <input type="hidden" name="has_qr" value="0">
                    <input class="form-check-input"
                        type="checkbox"
                        name="has_qr"
                        value="1"
                        id="hasQrSwitch"
                        {{ old('has_qr', $product->has_qr ?? false) ? 'checked' : '' }}>
                    <label class="form-check-label" for="hasQrSwitch">
                        {{ trans('dashboard/products.has_qr') }}
                    </label>
                </div>
            </div>

            {{-- PRODUCT IMAGE --}}
            <div class="card mb-4">
                <div class="card-header">
                    <i class="ti ti-photo me-2"></i>
                    {{ trans('dashboard/products.image') }}
                </div>
                <div class="card-body">
                    <div class="row align-items-center">

                        {{-- PREVIEW --}}
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div id="imagePreviewWrapper">
                                @php
                                    $imageUrl = isset($product) && $product->exists
                                        ? $product->getMediaUrl('products', $product, relation: 'media', collectionName: 'product')
                                        : null;
                                @endphp

                                @if($imageUrl)
                                    <img id="imagePreview"
                                        src="{{ $imageUrl }}"
                                        alt="product"
                                        class="img-thumbnail"
                                        style="width:120px; height:120px; object-fit:cover;">
                                @else
                                    <div id="imagePlaceholder"
                                        class="border rounded d-flex align-items-center justify-content-center bg-light"
                                        style="width:120px; height:120px; margin:auto;">
                                        <i class="ti ti-photo text-muted" style="font-size:2rem;"></i>
                                    </div>
                                    <img id="imagePreview"
                                        src=""
                                        alt="preview"
                                        class="img-thumbnail d-none"
                                        style="width:120px; height:120px; object-fit:cover;">
                                @endif
                            </div>
                        </div>

                        {{-- INPUT --}}
                        <div class="col-md-9">
                            <label class="form-label">
                                {{ trans('dashboard/products.image') }}
                            </label>
                            <input type="file"
                                name="image"
                                id="imageInput"
                                class="form-control @error('image') is-invalid @enderror"
                                accept="image/jpeg,image/png,image/webp">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1">
                                {{ trans('dashboard/products.image_hint') }}
                            </small>

                            {{-- زرار حذف الصورة لو موجودة في الـ edit --}}
                            @if(isset($product) && $product->exists && $imageUrl)
                                <button type="button"
                                    class="btn btn-sm btn-light-danger mt-2"
                                    id="removeImageBtn">
                                    <i class="fa fa-trash me-1"></i>
                                    {{ trans('dashboard/products.remove_image') }}
                                </button>
                                <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>