<?php

namespace App\Http\Requests\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // parent category (nullable = main category)
            'parent_id' => ['nullable', 'exists:categories,id'],
            // status (0 or 1)
            'status' => ['required', 'boolean'],
            // translations
            'name' => ['required', 'array'],
            'name.*' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'array'],
            'short_description.*' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'array'],
            'description.*' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'parent_id.exists' => trans('dashboard/categories.validation.parent_exists'),
            'status.required' => trans('dashboard/categories.validation.is_active_boolean'),
            'status.boolean' => trans('dashboard/categories.validation.is_active_boolean'),
            'name.required' => trans('dashboard/categories.validation.name_required'),
            'name.*.required' => trans('dashboard/categories.validation.name_required'),
            'name.*.string' => trans('dashboard/categories.validation.name_string'),
            'name.*.max' => trans('dashboard/categories.validation.name_max'),
            'short_description.*.max' => trans('dashboard/categories.validation.short_description_max'),
            'description.*.string' => trans('dashboard/categories.validation.description_string'),
        ];
    }
}