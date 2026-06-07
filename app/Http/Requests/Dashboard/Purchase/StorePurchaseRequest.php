<?php

namespace App\Http\Requests\Dashboard\Purchase;

use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_id'              => ['nullable', 'exists:suppliers,id'],
            'store_id'                 => ['required', 'exists:stores,id'],
            'invoice_date'             => ['nullable', 'date'],
            'discount'                 => ['nullable', 'numeric', 'min:0'],
            'paid_amount'              => ['nullable', 'numeric', 'min:0'],
            'notes'                    => ['nullable', 'string'],

            'items'                            => ['required', 'array', 'min:1'],
            'items.*.product_variant_id'       => ['required', 'exists:product_variants,id'],
            'items.*.sales_unit_id'            => ['required', 'exists:sales_units,id'],
            'items.*.quantity'                 => ['required', 'integer', 'min:1'],
            'items.*.unit_price'               => ['required', 'numeric', 'min:0'],
        ];
    }
}
