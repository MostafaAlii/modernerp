<?php
namespace App\Http\Requests\Dashboard\Size;

use Illuminate\Foundation\Http\FormRequest;

class StoreSizeRequest extends FormRequest
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
            $messages["name.{$locale}.string"] = trans('dashboard/sizes.validation.name_string', ['locale' => strtoupper($locale)]);
            $messages["name.{$locale}.max"]    = trans('dashboard/sizes.validation.name_max',    ['locale' => strtoupper($locale), 'max' => 255]);
        }

        return $messages;
    }
}