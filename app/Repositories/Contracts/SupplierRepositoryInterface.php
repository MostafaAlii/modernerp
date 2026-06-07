<?php

namespace App\Repositories\Contracts;

use App\Models\Supplier;
use App\DataTables\Dashboard\Admin\SupplierDataTable;
use App\Http\Requests\Dashboard\Supplier\StoreSupplierRequest;
use App\Http\Requests\Dashboard\Supplier\UpdateSupplierRequest;

interface SupplierRepositoryInterface
{
    public function index(SupplierDataTable $dataTable);
    public function store(StoreSupplierRequest $request);
    public function update(UpdateSupplierRequest $request, Supplier $supplier);
    public function delete(Supplier $supplier): array;
}
