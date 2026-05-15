<?php

namespace App\Http\Requests\Dashboard\InvUom;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvUomRequest extends FormRequest
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
            'is_master' => 'boolean',
            'date' => 'nullable|date',
        ];

        foreach ($locales as $locale) {
            $rules["name.{$locale}"] = 'required|string|max:255';
        }

        return $rules;
    }

    public function attributes(): array
    {
        $locales = array_keys(config('laravellocalization.supportedLocales'));
        $attributes = [];

        foreach ($locales as $locale) {
            $attributes["name.{$locale}"] = trans('dashboard/inv_uom.name') . ' (' . strtoupper($locale) . ')';
        }

        $attributes['is_active'] = trans('dashboard/inv_uom.is_active');
        $attributes['is_master'] = trans('dashboard/inv_uom.is_master');
        $attributes['date'] = trans('dashboard/general.date');

        return $attributes;
    }
}