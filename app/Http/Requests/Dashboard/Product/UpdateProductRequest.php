<?php
namespace App\Http\Requests\Dashboard\Product;

class UpdateProductRequest extends StoreProductRequest
{
    public function authorize(): bool
    {
        return true;
    }
}