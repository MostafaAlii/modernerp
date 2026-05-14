<?php

namespace App\Http\Requests\Dashboard\Treasury;

use Illuminate\Foundation\Http\FormRequest;
class StoreTreasuryRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $rules = [
            'is_master' => ['boolean'],
            'is_active' => ['boolean'],
            'last_exchange_receipt' => ['nullable', 'integer', 'min:0'],
            'last_collect_receipt'  => ['nullable', 'integer', 'min:0'],
        ];
        foreach ($locales as $locale) {
            $rules["name.$locale"] = $locale === 'ar'
                ? ['required', 'string', 'max:255']
                : ['nullable', 'string', 'max:255'];
        }
        return $rules;
    }

    public function messages(): array {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $messages = [
            'last_exchange_receipt.integer' => trans('dashboard/treasury.validation.receipt_integer'),
            'last_exchange_receipt.min'     => trans('dashboard/treasury.validation.receipt_min'),
            'last_collect_receipt.integer'  => trans('dashboard/treasury.validation.receipt_integer'),
            'last_collect_receipt.min'      => trans('dashboard/treasury.validation.receipt_min'),
        ];
        foreach ($locales as $locale) {
            $localeName = config('laravellocalization.supportedLocales.' . $locale . '.native');
            $messages["name.$locale.required"] = trans('dashboard/treasury.validation.name_required', ['locale' => $localeName]);
            $messages["name.$locale.string"]   = trans('dashboard/treasury.validation.name_string',   ['locale' => $localeName]);
            $messages["name.$locale.max"]      = trans('dashboard/treasury.validation.name_max',      ['locale' => $localeName]);
        }
        return $messages;
    }

    public function attributes(): array {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $attributes = [
            'last_exchange_receipt' => trans('dashboard/treasury.last_exchange_receipt'),
            'last_collect_receipt'  => trans('dashboard/treasury.last_collect_receipt'),
        ];
        foreach ($locales as $locale) {
            $localeName = config('laravellocalization.supportedLocales.' . $locale . '.native');
            $attributes["name.$locale"] = trans('dashboard/treasury.name') . ' (' . $localeName . ')';
        }
        return $attributes;
    }
}