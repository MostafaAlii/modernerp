<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\SalesUnitDataTable;
use App\Repositories\Contracts\SalesUnitRepositoryInterface;
use App\Models\SalesUnit;
use App\Http\Requests\Dashboard\SalesUnit\StoreSalesUnitRequest;
use Illuminate\Http\Request;

class SalesUnitController extends Controller
{
    public function __construct(
        protected SalesUnitDataTable $salesUnitDataTable,
        protected SalesUnitRepositoryInterface $salesUnitInterface
    ) {}

    public function index()
    {
        return $this->salesUnitInterface->index($this->salesUnitDataTable);
    }

    public function store(StoreSalesUnitRequest $request)
    {
        return $this->salesUnitInterface->store($request);
    }

    public function update(Request $request, SalesUnit $salesUnit)
    {
        try {
            $this->salesUnitInterface->update($salesUnit, $request->all());

            return redirect()->route('admin.sales_units.index')
                ->with('success', trans('dashboard/sales_units.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('admin.sales_units.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function destroy(SalesUnit $salesUnit)
    {
        $result = $this->salesUnitInterface->delete($salesUnit);

        if ($result['status']) {
            return redirect()->route('admin.sales_units.index')
                ->with('success', trans('dashboard/sales_units.deleted_successfully'));
        }

        return redirect()->route('admin.sales_units.index')
            ->with('error', trans('dashboard/general.error_occurred'));
    }
}