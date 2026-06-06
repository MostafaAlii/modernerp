<?php
namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\BrandDataTable;
use App\Models\Brand;
use App\Http\Requests\Dashboard\Brand\StoreBrandRequest;

interface BrandRepositoryInterface
{
    public function index(BrandDataTable $brandDataTable);
    public function store(StoreBrandRequest $request);
    public function update(Brand $brand, array $data): Brand;
    public function delete(Brand $brand): array;
}