<?php
namespace App\Http\Requests\Dashboard\Color;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'hex_code' => ['required', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'name'     => ['required', 'array'],
            'name.*'   => ['nullable', 'string', 'max:255'],
            'status'   => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        $messages = [
            'hex_code.required' => trans('dashboard/colors.validation.hex_code_required'),
            'hex_code.regex'    => trans('dashboard/colors.validation.hex_code_invalid'),
        ];

        foreach (array_keys(config('laravellocalization.supportedLocales')) as $locale) {
            $messages["name.{$locale}.string"] = trans('dashboard/colors.validation.name_string', ['locale' => strtoupper($locale)]);
            $messages["name.{$locale}.max"]    = trans('dashboard/colors.validation.name_max',    ['locale' => strtoupper($locale), 'max' => 255]);
        }

        return $messages;
    }
}