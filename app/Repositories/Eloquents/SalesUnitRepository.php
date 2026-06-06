<?php
namespace App\Repositories\Eloquents;

use App\DataTables\Dashboard\Admin\SalesUnitDataTable;
use App\Repositories\Contracts\SalesUnitRepositoryInterface;
use App\Models\{SalesUnit, Company};
use App\Http\Requests\Dashboard\SalesUnit\StoreSalesUnitRequest;
use Illuminate\Support\Facades\DB;

class SalesUnitRepository implements SalesUnitRepositoryInterface
{
    public function index(SalesUnitDataTable $salesUnitDataTable)
    {
        $companies = Company::whereStatus('active')->get(['id', 'name']);
        return $salesUnitDataTable->render('dashboard.admin.sales_units.index', [
            'title'     => trans('dashboard/sales_units.sales_units'),
            'companies' => $companies,
        ]);
    }

    public function store(StoreSalesUnitRequest $request)
    {
        try {
            DB::beginTransaction();

            $salesUnit = SalesUnit::create([
                'status' => $request->boolean('status'),
            ]);

            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $salesUnit->translateOrNew($locale)->name = $value;
                }
            }

            $salesUnit->save();

            DB::commit();
            return redirect()->route('admin.sales_units.index')
                ->with('success', trans('dashboard/sales_units.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.sales_units.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(SalesUnit $salesUnit, array $data): SalesUnit
    {
        try {
            DB::beginTransaction();

            $salesUnit->update([
                'status' => $data['status'] ?? $salesUnit->status,
            ]);

            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    if (filled($name)) {
                        $salesUnit->translateOrNew($locale)->name = $name;
                    }
                }
            }

            $salesUnit->save();

            DB::commit();
            return $salesUnit;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(SalesUnit $salesUnit): array
    {
        try {
            DB::beginTransaction();
            $salesUnit->delete();
            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'status'  => false,
                'message' => 'ERROR',
            ];
        }
    }
}