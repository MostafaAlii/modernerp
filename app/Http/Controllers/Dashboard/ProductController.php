<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\ProductDataTable;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use App\Http\Requests\Dashboard\Product\StoreProductRequest;
use App\Http\Requests\Dashboard\Product\UpdateProductRequest;

class ProductController extends Controller
{
    public function __construct(
        protected ProductDataTable $productDataTable,
        protected ProductRepositoryInterface $productInterface
    ) {}

    public function index()
    {
        return $this->productInterface->index($this->productDataTable);
    }

    public function create()
    {
        return $this->productInterface->create();
    }

    public function store(StoreProductRequest $request)
    {
        return $this->productInterface->store($request);
    }

    public function edit(Product $product)
    {
        return $this->productInterface->edit($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        return $this->productInterface->update($request, $product);
    }

    public function destroy(Product $product)
    {
        $result = $this->productInterface->destroy($product);

        if ($result['status']) {
            return redirect()->route('admin.products.index')
                ->with('success', trans('dashboard/products.deleted_successfully'));
        }

        return redirect()->route('admin.products.index')
            ->with('error', trans('dashboard/general.error_occurred'));
    }
}