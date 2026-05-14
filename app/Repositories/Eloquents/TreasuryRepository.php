<?php
namespace App\Repositories\Eloquents;
use App\DataTables\Dashboard\Admin\TreasuryDataTable;
use App\Repositories\Contracts\TreasuryRepositoryInterface;
use App\Models\{Treasury,TreasuryDeliveryDetail};
use App\Http\Requests\Dashboard\Treasury\{StoreTreasuryRequest,UpdateTreasuryRequest};
use App\Enums\Treasury\TreasuryStatus;
use App\Http\Middleware\EnsureOwner;
class TreasuryRepository implements TreasuryRepositoryInterface {
    public function index(TreasuryDataTable $treasuryDataTable) {
        return $treasuryDataTable->render('dashboard.admin.treasuries.index', [
            'title' => trans('dashboard/treasury.treasuries'),
        ]);
    }

    public function store(StoreTreasuryRequest $request) {
        try {
            if ($request->boolean('is_master') && ! EnsureOwner::check()) {
                $companyId = get_user_data()?->company_id;
                $existingMaster = Treasury::where('is_master', true)->where('company_id', $companyId)->first();
                if ($existingMaster) {
                    $companyName = $existingMaster->company?->name ?? trans('dashboard/treasury.no_company');
                    return redirect()->route('admin.treasuries.index')->withInput()
                        ->with('error', trans('dashboard/treasury.master_exists', [
                            'company' => $companyName,
                        ]));
                }
            }
            $treasury = Treasury::create([
                'is_master'             => $request->boolean('is_master'),
                'is_active'             => $request->boolean('is_active'),
                'last_exchange_receipt' => $request->input('last_exchange_receipt', 0),
                'last_collect_receipt'  => $request->input('last_collect_receipt', 0),
                'date'                  => now(),
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
            if ($request->boolean('is_master') && ! EnsureOwner::check()) {
                $companyId = get_user_data()?->company_id;
                if (Treasury::hasActiveMasterForCompany($companyId, $treasury->id)) {
                    $companyName = get_user_data()->company?->name ?? trans('dashboard/treasury.no_company');
                    return redirect()->route('admin.treasuries.index')->withInput()
                        ->with('error', trans('dashboard/treasury.master_exists', [
                            'company' => $companyName,
                        ]));
                }
            }
            $treasury->update([
                'is_master'             => $request->boolean('is_master'),
                'is_active'             => $request->boolean('is_active'),
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
            if (! $treasury->is_master && ! EnsureOwner::check()) {
                $companyId = get_user_data()?->company_id;
                if (Treasury::hasActiveMasterForCompany($companyId, $treasury->id)) {
                    $companyName = get_user_data()->company?->name ?? trans('dashboard/treasury.no_company');
                    return response()->json([
                        'success' => false,
                        'message' => trans('dashboard/treasury.master_exists', [
                            'company' => $companyName,
                        ]),
                    ], 422);
                }
            }
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

    public function storeDelivery(Treasury $treasury, int $subTreasuryId) {
        try {
            $exists = TreasuryDeliveryDetail::where('treasury_id', $treasury->id)
                ->where('treasury_can_delivery_id', $subTreasuryId)
                ->exists();
            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => trans('dashboard/treasury.delivery_already_exists'),
                ], 422);
            }

            TreasuryDeliveryDetail::create([
                'treasury_id'              => $treasury->id,
                'treasury_can_delivery_id' => $subTreasuryId,
            ]);

            return response()->json([
                'success' => true,
                'message' => trans('dashboard/treasury.delivery_created_successfully'),
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }

    public function getDeliveries(Treasury $treasury) {
        $deliveries = $treasury->deliveryDetails()->with(['deliveryTreasury.translations', 'createdBy'])->latest()->get();
        return response()->json([
            'success'    => true,
            'deliveries' => $deliveries->map(fn($d) => [
                'id'       => $d->id,
                'treasury' => $d->deliveryTreasury?->name ?? '-',
                'added_by' => $d->createdBy?->name ?? '-',
                'date'     => $d->created_at?->format('Y-m-d'),
            ]),
        ]);
    }

    public function destroyDelivery(TreasuryDeliveryDetail $detail) {
        try {
            $detail->delete();
            return response()->json([
                'success' => true,
                'message' => trans('dashboard/treasury.delivery_deleted_successfully'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => trans('dashboard/general.error_occurred'),
            ], 500);
        }
    }
}