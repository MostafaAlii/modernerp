<?php

namespace App\Http\Requests\Dashboard\Store;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locales = array_keys(config('laravellocalization.supportedLocales'));

        $rules = [
            'is_active' => 'boolean',
            'date' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
        ];

        foreach ($locales as $locale) {
            $rules["name.{$locale}"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    public function attributes(): array
    {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $attributes = [];

        foreach ($locales as $locale) {
            $attributes["name.{$locale}"] = trans('dashboard/store.name') . ' (' . strtoupper($locale) . ')';
        }

        $attributes['is_active'] = trans('dashboard/store.is_active');
        $attributes['date'] = trans('dashboard/general.date');
        $attributes['phone'] = trans('dashboard/store.phone');
        $attributes['address'] = trans('dashboard/store.address');
        $attributes['company_id'] = trans('dashboard/store.company');

        return $attributes;
    }
}