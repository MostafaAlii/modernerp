<?php
namespace App\Http\Requests\Dashboard\Brand;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => ['required', 'array'],
            'name.*' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        $messages = [];

        foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
            $messages["name.{$locale}.string"] = trans('dashboard/brands.validation.name_string', ['locale' => strtoupper($locale)]);
            $messages["name.{$locale}.max"]    = trans('dashboard/brands.validation.name_max',    ['locale' => strtoupper($locale), 'max' => 255]);
        }

        return $messages;
    }
}