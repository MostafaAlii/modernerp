<?php

namespace App\Http\Requests\Dashboard\SalesUnit;

use Illuminate\Foundation\Http\FormRequest;

class StoreSalesUnitRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // status (0 or 1)
            'status' => ['required', 'boolean'],
            // translations
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => trans('dashboard/sales_units.validation.is_active_boolean'),
            'status.boolean' => trans('dashboard/sales_units.validation.is_active_boolean'),
            'name.required' => trans('dashboard/sales_units.validation.name_required'),
            'name.*.required' => trans('dashboard/sales_units.validation.name_required'),
            'name.*.string' => trans('dashboard/sales_units.validation.name_string'),
            'name.*.max' => trans('dashboard/sales_units.validation.name_max'),
        ];
    }
}