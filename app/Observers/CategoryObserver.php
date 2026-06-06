<?php

namespace App\Observers;

use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category): void
    {
        $user = get_user_data();
        $category->company_id = $category->company_id ?? $user?->company_id;
        $category->created_by = $user?->id;
    }

    public function updating(Category $category): void
    {
        $category->updated_by = get_user_data()?->id;
    }
}