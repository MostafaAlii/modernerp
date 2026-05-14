<?php

namespace App\Http\Requests\Dashboard\SalesMatrialType;

use Illuminate\Foundation\Http\FormRequest;
class StoreSalesMatrialTypeRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $rules = [
            'is_active' => ['boolean'],
        ];
        foreach ($locales as $locale) {
            $rules["name.$locale"] = $locale === 'ar' ? ['required', 'string', 'max:255'] : ['nullable', 'string', 'max:255'];
        }
        return $rules;
    }

    public function messages(): array {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $messages = [];
        foreach ($locales as $locale) {
            $localeName = config('laravellocalization.supportedLocales.' . $locale . '.native');
            $messages["name.$locale.required"] = trans('dashboard/sales_matrial_type.validation.name_required', ['locale' => $localeName]);
            $messages["name.$locale.string"]   = trans('dashboard/sales_matrial_type.validation.name_string',   ['locale' => $localeName]);
            $messages["name.$locale.max"]      = trans('dashboard/sales_matrial_type.validation.name_max',      ['locale' => $localeName]);
        }
        return $messages;
    }

    public function attributes(): array {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        foreach ($locales as $locale) {
            $localeName = config('laravellocalization.supportedLocales.' . $locale . '.native');
            $attributes["name.$locale"] = trans('dashboard/sales_matrial_type.name') . ' (' . $localeName . ')';
        }
        return $attributes;
    }
}