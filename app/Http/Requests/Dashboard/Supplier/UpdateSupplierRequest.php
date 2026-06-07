<?php

namespace App\Http\Requests\Dashboard\Supplier;

class UpdateSupplierRequest extends StoreSupplierRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
