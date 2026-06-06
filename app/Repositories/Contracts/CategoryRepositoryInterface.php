<?php

namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\CategoryDataTable;
use App\Models\Category;
use App\Http\Requests\Dashboard\Category\StoreCategoryRequest;

interface CategoryRepositoryInterface
{
    public function index(CategoryDataTable $categoryDataTable);
    /*public function store(StoreCategoryRequest $request);
    public function toggleStatus(Category $category);
    public function toggleMaster(Category $category);
    public function destroy(Category $category);
    public function update(Category $category, array $data);*/
}