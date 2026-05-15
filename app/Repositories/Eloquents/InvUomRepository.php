<?php

namespace App\Repositories\Eloquents;

use App\DataTables\Dashboard\Admin\InvUomDataTable;
use App\Repositories\Contracts\InvUomRepositoryInterface;
use App\Models\{InvUom, Company};
use App\Http\Requests\Dashboard\InvUom\StoreInvUomRequest;
use App\Enums\InvUom\{UomStatus,UomMaster};
use Illuminate\Support\Facades\DB;

class InvUomRepository implements InvUomRepositoryInterface
{
    public function index(InvUomDataTable $invUomDataTable) {
        $companies = Company::whereStatus('active')->get(['id', 'name']);
        return $invUomDataTable->render('dashboard.admin.invUoms.index', [
            'title' => trans('dashboard/inv_uom.inv_uoms'),
            'companies' => $companies
        ]);
    }

    public function store(StoreInvUomRequest $request)
    {
        try {
            DB::beginTransaction();

            $invUom = InvUom::create([
                'is_active' => $request->boolean('is_active'),
                'is_master' => $request->boolean('is_master'),
                'date' => $request->date,
                'company_id' => $request->company_id,
            ]);

            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $invUom->translateOrNew($locale)->name = $value;
                }
            }
            $invUom->save();

            DB::commit();

            return redirect()->route('admin.invUoms.index')->with('success', trans('dashboard/inv_uom.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.invUoms.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(InvUom $invUom, array $data)
    {
        try {
            DB::beginTransaction();

            // update main table
            $invUom->update([
                'is_active' => $data['is_active'] ?? $invUom->is_active,
                'is_master' => $data['is_master'] ?? $invUom->is_master,
                'date' => $data['date'] ?? $invUom->date,
                'company_id' => $data['company_id'] ?? $invUom->company_id,
            ]);

            // update translations
            if (isset($data['name'])) {
                foreach ($data['name'] as $locale => $name) {
                    if (filled($name)) {
                        $invUom->translateOrNew($locale)->name = $name;
                    }
                }
            }
            $invUom->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => trans('dashboard/inv_uom.updated_successfully'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function toggleStatus(InvUom $invUom)
    {
        try {
            $invUom->update([
                'is_active' => $invUom->is_active === UomStatus::ACTIVE
                    ? UomStatus::INACTIVE
                    : UomStatus::ACTIVE,
            ]);

            return response()->json([
                'success' => true,
                'badge'   => $invUom->is_active->badge(),
                'message' => trans('dashboard/inv_uom.status_updated'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function toggleMaster(InvUom $invUom)
    {
        try {
            $invUom->update([
                'is_master' => $invUom->is_master === UomMaster::MASTER
                    ? UomMaster::SUB
                    : UomMaster::MASTER,
            ]);

            return response()->json([
                'success' => true,
                'badge'   => $invUom->is_master->badge(),
                'message' => trans('dashboard/inv_uom.master_updated'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function destroy(InvUom $invUom)
    {
        try {
            $invUom->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => trans('dashboard/inv_uom.deleted_successfully')
                ]);
            }

            return redirect()->route('admin.invUoms.index')->with('success', trans('dashboard/inv_uom.deleted_successfully'));
        } catch (\Exception $e) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => trans('dashboard/general.error_occurred')
                ], 500);
            }

            return redirect()->route('admin.invUoms.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }
}