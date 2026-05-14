<?php
namespace App\Repositories\Eloquents;
use App\DataTables\Dashboard\Admin\SalesMatrialTypeDataTable;
use App\Repositories\Contracts\SalesMatrialTypeRepositoryInterface;
use App\Models\{SalesMatrialType};
use App\Http\Requests\Dashboard\SalesMatrialType\{StoreSalesMatrialTypeRequest,UpdateTreasuryRequest};
use App\Enums\SalesMatrialType\SalesMatrialTypeStatus;
use App\Http\Middleware\EnsureOwner;
use Illuminate\Support\Facades\DB;
class SalesMatrialTypeRepository implements SalesMatrialTypeRepositoryInterface {
    public function index(SalesMatrialTypeDataTable $salesMatrialTypeDataTable) {
        return $salesMatrialTypeDataTable->render('dashboard.admin.salesMatrialTypes.index', [
            'title' => trans('dashboard/sales_matrial_type.sales_matrial_types'),
        ]);
    }

    public function store(StoreSalesMatrialTypeRequest $request) {
        try {
            $salesMatrialType = SalesMatrialType::create([
                'is_active'             => $request->boolean('is_active'),
            ]);
            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $salesMatrialType->translateOrNew($locale)->name = $value;
                }
            }
            $salesMatrialType->save();
            return redirect()->route('admin.salesMatrialTypes.index')->with('success', trans('dashboard/sales_matrial_type.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('admin.salesMatrialTypes.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(SalesMatrialType $salesMatrialType, array $data) {
        try {
            DB::beginTransaction();
            // update main table
            $salesMatrialType->update([
                'is_active' => $data['is_active'] ?? $salesMatrialType->is_active,
            ]);
            // update translations
            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    $salesMatrialType->translateOrNew($locale)->name = $name;
                }
            }
            $salesMatrialType->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => trans('dashboard/sales_matrial_type.updated_successfully'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function toggleStatus(SalesMatrialType $salesMatrialType) {
        try {
            $salesMatrialType->update([
                'is_active' => $salesMatrialType->is_active === SalesMatrialTypeStatus::ACTIVE
                    ? SalesMatrialTypeStatus::INACTIVE
                    : SalesMatrialTypeStatus::ACTIVE,
            ]);

            return response()->json([
                'success' => true,
                'badge'   => $salesMatrialType->is_active->badge(),
                'message' => trans('dashboard/sales_matrial_type.status_updated'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function destroy(SalesMatrialType $salesMatrialType) {
        try {
            $salesMatrialType->delete();
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => trans('dashboard/sales_matrial_type.deleted_successfully')
                ]);
            }
            return redirect()->route('admin.salesMatrialTypes.index')->with('success', trans('dashboard/sales_matrial_type.deleted_successfully'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => trans('dashboard/general.error_occurred')
                ], 500);
            }
            return redirect()->route('admin.salesMatrialTypes.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }
}