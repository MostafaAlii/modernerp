<?php

namespace App\Http\Requests\Dashboard\Purchase;

class UpdatePurchaseRequest extends StorePurchaseRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
