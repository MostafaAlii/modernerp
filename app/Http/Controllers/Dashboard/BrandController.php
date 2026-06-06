<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\BrandDataTable;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Models\Brand;
use App\Http\Requests\Dashboard\Brand\StoreBrandRequest;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(
        protected BrandDataTable $brandDataTable,
        protected BrandRepositoryInterface $brandInterface
    ) {}

    public function index()
    {
        return $this->brandInterface->index($this->brandDataTable);
    }

    public function store(StoreBrandRequest $request)
    {
        return $this->brandInterface->store($request);
    }

    public function update(Request $request, Brand $brand)
    {
        try {
            $this->brandInterface->update($brand, $request->all());

            return redirect()->route('admin.brands.index')
                ->with('success', trans('dashboard/brands.updated_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('admin.brands.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function destroy(Brand $brand)
    {
        $result = $this->brandInterface->delete($brand);

        if ($result['status']) {
            return redirect()->route('admin.brands.index')
                ->with('success', trans('dashboard/brands.deleted_successfully'));
        }

        return redirect()->route('admin.brands.index')
            ->with('error', trans('dashboard/general.error_occurred'));
    }
}