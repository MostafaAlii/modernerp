<?php

namespace App\Repositories\Eloquents;

use App\DataTables\Dashboard\Admin\StoreDataTable;
use App\Repositories\Contracts\StoreRepositoryInterface;
use App\Models\Store;
use App\Http\Requests\Dashboard\Store\StoreStoreRequest;
use App\Enums\Store\StoreStatus;
use Illuminate\Support\Facades\DB;

class StoreRepository implements StoreRepositoryInterface
{
    public function index(StoreDataTable $storeDataTable)
    {
        return $storeDataTable->render('dashboard.admin.stores.index', [
            'title' => trans('dashboard/store.stores'),
        ]);
    }

    public function store(StoreStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $store = Store::create([
                'is_active' => $request->boolean('is_active'),
                'date' => $request->date,
                'phone' => $request->phone,
                'address' => $request->address,
                'company_id' => $request->company_id,
            ]);

            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $store->translateOrNew($locale)->name = $value;
                }
            }
            $store->save();

            DB::commit();

            return redirect()->route('admin.stores.index')->with('success', trans('dashboard/store.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.stores.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(Store $store, array $data)
    {
        try {
            DB::beginTransaction();

            // update main table
            $store->update([
                'is_active' => $data['is_active'] ?? $store->is_active,
                'date' => $data['date'] ?? $store->date,
                'phone' => $data['phone'] ?? $store->phone,
                'address' => $data['address'] ?? $store->address,
                'company_id' => $data['company_id'] ?? $store->company_id,
            ]);

            // update translations
            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    if (filled($name)) {
                        $store->translateOrNew($locale)->name = $name;
                    }
                }
            }
            $store->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('dashboard/store.updated_successfully'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function toggleStatus(Store $store)
    {
        try {
            $store->update([
                'is_active' => $store->is_active === StoreStatus::ACTIVE
                    ? StoreStatus::INACTIVE
                    : StoreStatus::ACTIVE,
            ]);

            return response()->json([
                'success' => true,
                'badge'   => $store->is_active->badge(),
                'message' => trans('dashboard/store.status_updated'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function destroy(Store $store)
    {
        try {
            $store->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => trans('dashboard/store.deleted_successfully')
                ]);
            }

            return redirect()->route('admin.stores.index')->with('success', trans('dashboard/store.deleted_successfully'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => trans('dashboard/general.error_occurred')
                ], 500);
            }

            return redirect()->route('admin.stores.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }
}