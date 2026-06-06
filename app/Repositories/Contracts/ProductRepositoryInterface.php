<?php
namespace App\Repositories\Contracts;

use App\Models\Product;
use App\DataTables\Dashboard\Admin\ProductDataTable;
use App\Http\Requests\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;

interface ProductRepositoryInterface
{
    public function index(ProductDataTable $dataTable);
    public function create();
    public function store(StoreProductRequest $request);
    public function edit(Product $product);
    public function update(UpdateProductRequest $request, Product $product);
    public function destroy(Product $product): array;
}