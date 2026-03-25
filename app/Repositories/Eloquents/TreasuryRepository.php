<?php
namespace App\Repositories\Eloquents;
use App\DataTables\Dashboard\Admin\TreasuryDataTable;
use App\Repositories\Contracts\TreasuryRepositoryInterface;
use App\Models\Treasury;
use App\Http\Requests\Dashboard\Treasury\{StoreTreasuryRequest,UpdateTreasuryRequest};
use App\Enums\Treasury\TreasuryStatus;
class TreasuryRepository implements TreasuryRepositoryInterface {
    public function index(TreasuryDataTable $treasuryDataTable) {
        return $treasuryDataTable->render('dashboard.admin.treasuries.index', [
            'title' => trans('dashboard/treasury.treasuries'),
        ]);
    }

    public function store(StoreTreasuryRequest $request) {
        try {
            $treasury = Treasury::create([
                'is_master' => $request->boolean('is_master'),
                'is_active' => $request->boolean('is_active'),
                'last_exchange_receipt' => $request->input('last_exchange_receipt', 0),
                'last_collect_receipt'  => $request->input('last_collect_receipt', 0),
                'date'      => now(),
            ]);
            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $treasury->translateOrNew($locale)->name = $value;
                }
            }
            $treasury->save();
            return redirect()->route('admin.treasuries.index')->with('success', trans('dashboard/treasury.created_successfully'));
        } catch (\Exception $e) {
            return redirect()->route('admin.treasuries.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function update(UpdateTreasuryRequest $request, Treasury $treasury) {
        try {
            $treasury->update([
                'is_master' => $request->boolean('is_master'),
                'is_active' => $request->boolean('is_active'),
                'last_exchange_receipt' => $request->input('last_exchange_receipt', 0),
            'last_collect_receipt'  => $request->input('last_collect_receipt', 0),
            ]);
            foreach ($request->name as $locale => $value) {
                if (filled($value)) {
                    $treasury->translateOrNew($locale)->name = $value;
                }
            }
            $treasury->save();
            return redirect()->route('admin.treasuries.index')->with('success', trans('dashboard/treasury.updated_successfully'));

        } catch (\Exception $e) {
            return redirect()->route('admin.treasuries.index')->with('error', trans('dashboard/general.error_occurred'));
        }
    }

    public function toggleStatus(Treasury $treasury) {
        try {
            $treasury->update([
                'is_active' => $treasury->is_active === TreasuryStatus::ACTIVE
                    ? TreasuryStatus::INACTIVE
                    : TreasuryStatus::ACTIVE,
            ]);

            return response()->json([
                'success' => true,
                'badge'   => $treasury->is_active->badge(),
                'message' => trans('dashboard/treasury.status_updated'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function toggleMaster(Treasury $treasury) {
        try {
            $treasury->update([
                'is_master' => ! $treasury->is_master,
            ]);

            $badge = $treasury->is_master
                ? '<span class="badge bg-primary">'   . trans('dashboard/treasury.master') . '</span>'
                : '<span class="badge bg-secondary">' . trans('dashboard/treasury.sub')    . '</span>';

            return response()->json([
                'success' => true,
                'badge'   => $badge,
                'message' => trans('dashboard/treasury.type_updated'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function destroy(Treasury $treasury) {
        $treasury->delete();
        return redirect()->route('admin.treasuries.index')->with('success', trans('dashboard/treasury.deleted_successfully'));
    }
}