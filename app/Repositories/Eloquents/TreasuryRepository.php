<?php
namespace App\Repositories\Eloquents;
use App\DataTables\Dashboard\Admin\TreasuryDataTable;
use App\Repositories\Contracts\TreasuryRepositoryInterface;
use App\Models\Treasury;
use App\Http\Requests\Dashboard\Treasury\StoreTreasuryRequest;
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

    public function destroy(Treasury $treasury) {
        $treasury->delete();
        return redirect()->route('admin.treasuries.index')->with('success', trans('dashboard/treasury.deleted_successfully'));
    }
}