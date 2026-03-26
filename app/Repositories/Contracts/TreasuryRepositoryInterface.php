<?php
namespace App\Repositories\Contracts;
use App\DataTables\Dashboard\Admin\TreasuryDataTable;
use App\Models\{Treasury,TreasuryDeliveryDetail};
use App\Http\Requests\Dashboard\Treasury\{StoreTreasuryRequest,UpdateTreasuryRequest};
interface TreasuryRepositoryInterface {
    public function index(TreasuryDataTable $treasuryDataTable);
    public function store(StoreTreasuryRequest $request);
    public function update(UpdateTreasuryRequest $request, Treasury $treasury);
    public function toggleStatus(Treasury $treasury);
    public function toggleMaster(Treasury $treasury);
    public function destroy(Treasury $treasury);
    public function storeDelivery(Treasury $treasury, int $subTreasuryId);
    public function getDeliveries(Treasury $treasury);
    public function destroyDelivery(TreasuryDeliveryDetail $detail);
}