<?php
namespace App\Http\Requests\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Product\ProductVariantType;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // بيانات أساسية
            'category_id'  => ['required', 'exists:categories,id'],
            'brand_id'     => ['nullable', 'exists:brands,id'],
            'variant_type' => ['required', 'integer', 'in:0,1,2,3'],
            'has_barcode'  => ['nullable', 'boolean'],
            'has_qr'       => ['nullable', 'boolean'],
            'status'       => ['nullable', 'boolean'],

            // الترجمات
            'name'         => ['required', 'array'],
            'name.*'       => ['nullable', 'string', 'max:255'],
            'description'  => ['nullable', 'array'],
            'description.*'=> ['nullable', 'string'],

            // الـ variants
            'variants'                        => ['required', 'array', 'min:1'],
            'variants.*.color_id'             => ['nullable', 'exists:colors,id'],
            'variants.*.size_id'              => ['nullable', 'exists:sizes,id'],
            'variants.*.sku'                  => ['nullable', 'string', 'max:100'],
            'variants.*.barcode'              => ['nullable', 'string', 'max:100'],
            'variants.*.quantity'             => ['required', 'integer', 'min:0'],
            'variants.*.min_stock_alert'      => ['nullable', 'integer', 'min:0'],

            // الأسعار
            'variants.*.prices'               => ['required', 'array'],
            'variants.*.prices.*.price'       => ['nullable', 'numeric', 'min:0'],
            'variants.*.prices.*.cost_price'  => ['nullable', 'numeric', 'min:0'],
        ];
    }
}