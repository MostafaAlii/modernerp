<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\SupplierDataTable;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Models\Supplier;
use App\Http\Requests\Dashboard\Supplier\StoreSupplierRequest;
use App\Http\Requests\Dashboard\Supplier\UpdateSupplierRequest;

class SupplierController extends Controller
{
    public function __construct(
        protected SupplierDataTable $supplierDataTable,
        protected SupplierRepositoryInterface $supplierInterface
    ) {}

    public function index()
    {
        return $this->supplierInterface->index($this->supplierDataTable);
    }

    public function store(StoreSupplierRequest $request)
    {
        return $this->supplierInterface->store($request);
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        return $this->supplierInterface->update($request, $supplier);
    }

    public function destroy(Supplier $supplier)
    {
        $result = $this->supplierInterface->delete($supplier);

        if ($result['status']) {
            return redirect()->route('admin.suppliers.index')
                ->with('success', trans('dashboard/suppliers.deleted_successfully'));
        }

        return redirect()->route('admin.suppliers.index')
            ->with('error', trans('dashboard/general.error_occurred'));
    }
}
