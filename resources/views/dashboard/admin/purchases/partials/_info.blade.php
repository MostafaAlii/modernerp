<div class="card mb-4">
    <div class="card-header">
        <i class="ti ti-info-circle me-2"></i>
        {{ trans('dashboard/purchases.invoice_info') }}
    </div>
    <div class="card-body">
        <div class="row">
            {{-- SUPPLIER --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ trans('dashboard/purchases.supplier') }}</label>
                <select name="supplier_id" class="form-control">
                    <option value="">-- {{ trans('dashboard/purchases.select_supplier') }} --</option>
                    @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id', $purchase->supplier_id ?? '') ==
                        $supplier->id ? 'selected' : '' }}>
                        {{ $supplier->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            {{-- STORE --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    {{ trans('dashboard/purchases.store') }}
                    <span class="text-danger">*</span>
                </label>
                <select name="store_id" class="form-control @error('store_id') is-invalid @enderror">
                    <option value="">-- {{ trans('dashboard/purchases.select_store') }} --</option>
                    @foreach($stores as $store)
                    <option value="{{ $store->id }}" {{ old('store_id', $purchase->store_id ?? '') == $store->id ?
                        'selected' : '' }}>
                        {{ $store->translate(app()->getLocale())?->name ?? $store->translate('ar')?->name }}
                    </option>
                    @endforeach
                </select>
                @error('store_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- INVOICE DATE --}}
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ trans('dashboard/purchases.invoice_date') }}</label>
                <input type="date" name="invoice_date" class="form-control"
                    value="{{ old('invoice_date', $purchase->invoice_date?->format('Y-m-d') ?? date('Y-m-d')) }}">
            </div>

            {{-- NOTES --}}
            <div class="col-12 mb-3">
                <label class="form-label">{{ trans('dashboard/purchases.notes') }}</label>
                <textarea name="notes" class="form-control"
                    rows="2">{{ old('notes', $purchase->notes ?? '') }}</textarea>
            </div>

        </div>
    </div>
</div>
