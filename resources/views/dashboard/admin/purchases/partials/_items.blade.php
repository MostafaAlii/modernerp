<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between">
        <div>
            <i class="ti ti-list me-2"></i>
            {{ trans('dashboard/purchases.items') }}
        </div>
        <button type="button" class="btn btn-sm btn-primary" id="addItemBtn">
            <i class="fa fa-plus me-1"></i>
            {{ trans('dashboard/purchases.add_item') }}
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="itemsTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>{{ trans('dashboard/purchases.product') }}</th>
                        <th>{{ trans('dashboard/purchases.sales_unit') }}</th>
                        <th>{{ trans('dashboard/purchases.quantity') }}</th>
                        <th>{{ trans('dashboard/purchases.unit_price') }}</th>
                        <th>{{ trans('dashboard/purchases.total_price') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="itemsContainer">
                    {{-- هيتملى بالـ JS --}}
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="text-end fw-bold">
                            {{ trans('dashboard/purchases.total_amount') }}
                        </td>
                        <td class="fw-bold" id="totalAmount">0.00</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

{{-- TOTALS CARD --}}
<div class="card mb-4">
    <div class="card-header">
        <i class="ti ti-calculator me-2"></i>
        {{ trans('dashboard/purchases.totals') }}
    </div>
    <div class="card-body">
        <div class="row">

            {{-- DISCOUNT --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ trans('dashboard/purchases.discount') }}</label>
                <input type="number" name="discount" id="discountInput" class="form-control"
                    value="{{ old('discount', $purchase->discount ?? 0) }}" min="0" step="0.01" oninput="calcTotals()">
            </div>

            {{-- NET AMOUNT --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ trans('dashboard/purchases.net_amount') }}</label>
                <input type="text" id="netAmountDisplay" class="form-control bg-light"
                    value="{{ old('net_amount', $purchase->net_amount ?? 0) }}" readonly>
            </div>

            {{-- PAID AMOUNT --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ trans('dashboard/purchases.paid_amount') }}</label>
                <input type="number" name="paid_amount" id="paidAmountInput" class="form-control"
                    value="{{ old('paid_amount', $purchase->paid_amount ?? 0) }}" min="0" step="0.01"
                    oninput="calcTotals()">
            </div>

            {{-- REMAINING --}}
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ trans('dashboard/purchases.remaining_amount') }}</label>
                <input type="text" id="remainingDisplay" class="form-control bg-light" readonly>
            </div>

        </div>
    </div>
</div>

{{-- ITEM ROW TEMPLATE --}}
<template id="itemTemplate">
    <tr class="item-row" data-index="__INDEX__">
        <td class="item-number text-center">1</td>

        {{-- PRODUCT SELECT --}}
        <td>
            <select name="items[__INDEX__][product_variant_id]" class="form-control form-control-sm variant-select"
                style="min-width: 200px;">
                <option value="">-- {{ trans('dashboard/purchases.select_product') }} --</option>
                @foreach($variants as $variant)
                <option value="{{ $variant->id }}"
                    data-prices="{{ json_encode($variant->prices->pluck('price', 'sales_unit_id')) }}">
                    {{ $variant->displayName() }}
                </option>
                @endforeach
            </select>
        </td>

        {{-- SALES UNIT --}}
        <td>
            <select name="items[__INDEX__][sales_unit_id]" class="form-control form-control-sm unit-select"
                style="min-width: 130px;" onchange="autoFillPrice(this)">
                <option value="">--</option>
                @foreach($salesUnits as $unit)
                <option value="{{ $unit->id }}">
                    {{ $unit->translate(app()->getLocale())?->name ?? $unit->translate('ar')?->name }}
                </option>
                @endforeach
            </select>
        </td>

        {{-- QUANTITY --}}
        <td>
            <input type="number" name="items[__INDEX__][quantity]" class="form-control form-control-sm item-qty"
                style="width: 80px;" value="1" min="1" oninput="calcRowTotal(this)">
        </td>

        {{-- UNIT PRICE --}}
        <td>
            <input type="number" name="items[__INDEX__][unit_price]" class="form-control form-control-sm item-price"
                style="width: 100px;" value="0" min="0" step="0.01" oninput="calcRowTotal(this)">
        </td>

        {{-- TOTAL --}}
        <td class="item-total text-center fw-bold">0.00</td>

        {{-- REMOVE --}}
        <td class="text-center">
            <button type="button" class="btn btn-sm btn-light-danger remove-item-btn">
                <i class="fa fa-trash"></i>
            </button>
        </td>
    </tr>
</template>
