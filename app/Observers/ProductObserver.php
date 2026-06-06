<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{
    public function creating(Product $product): void
    {
        $user = get_user_data();
        $product->company_id = $product->company_id ?? $user?->company_id;
        $product->created_by = $user?->id;
    }

    public function updating(Product $product): void
    {
        $product->updated_by = get_user_data()?->id;
    }
}