<?php
namespace App\Repositories\Eloquents;

use App\DataTables\Dashboard\Admin\BrandDataTable;
use App\Repositories\Contracts\BrandRepositoryInterface;
use App\Models\{Brand, Company};
use App\Http\Requests\Dashboard\Brand\StoreBrandRequest;
use Illuminate\Support\Facades\DB;

class BrandRepository implements BrandRepositoryInterface
{
    public function index(BrandDataTable $brandDataTable)
    {
        $companies = Company::whereStatus('active')->get(['id', 'name']);

        return $brandDataTable->render('dashboard.admin.brands.index', [
            'title'     => trans('dashboard/brands.brands'),
            'companies' => $companies,
        ]);
    }

    public function store(StoreBrandRequest $request)
    {
        try {
            DB::beginTransaction();

            $brand = Brand::create([
                'status' => $request->boolean('status'),
            ]);

            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $brand->translateOrNew($locale)->name = $value;
                }
            }

            $brand->save();

            DB::commit();
            return redirect()->route('admin.brands.index')
                ->with('success', trans('dashboard/brands.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.brands.index')
                ->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(Brand $brand, array $data): Brand
    {
        try {
            DB::beginTransaction();

            $brand->update([
                'status' => $data['status'] ?? $brand->status,
            ]);

            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    if (filled($name)) {
                        $brand->translateOrNew($locale)->name = $name;
                    }
                }
            }

            $brand->save();

            DB::commit();
            return $brand;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function delete(Brand $brand): array
    {
        try {
            DB::beginTransaction();
            $brand->delete();
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