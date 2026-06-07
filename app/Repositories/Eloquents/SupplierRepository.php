<?php

namespace App\Repositories\Eloquents;

use App\Models\Supplier;
use App\DataTables\Dashboard\Admin\SupplierDataTable;
use App\Repositories\Contracts\SupplierRepositoryInterface;
use App\Http\Requests\Dashboard\Supplier\StoreSupplierRequest;
use App\Http\Requests\Dashboard\Supplier\UpdateSupplierRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function index(SupplierDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.suppliers.index', [
            'title' => trans('dashboard/suppliers.suppliers'),
        ]);
    }

    public function store(StoreSupplierRequest $request)
    {
        try {
            DB::beginTransaction();

            Supplier::create([
                'uuid'    => Str::uuid(),
                'name'    => $request->name,
                'phone'   => $request->phone,
                'email'   => $request->email,
                'address' => $request->address,
                'notes'   => $request->notes,
                'status'  => $request->boolean('status'),
            ]);

            DB::commit();
            return redirect()->route('admin.suppliers.index')
                ->with('success', trans('dashboard/suppliers.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.suppliers.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        try {
            DB::beginTransaction();

            $supplier->update([
                'name'    => $request->name,
                'phone'   => $request->phone,
                'email'   => $request->email,
                'address' => $request->address,
                'notes'   => $request->notes,
                'status'  => $request->boolean('status'),
            ]);

            DB::commit();
            return redirect()->route('admin.suppliers.index')
                ->with('success', trans('dashboard/suppliers.updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.suppliers.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function delete(Supplier $supplier): array
    {
        try {
            DB::beginTransaction();
            $supplier->delete();
            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => 'ERROR'];
        }
    }
}
