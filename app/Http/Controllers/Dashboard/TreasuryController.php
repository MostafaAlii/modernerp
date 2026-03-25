<?php
namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\TreasuryDataTable;
use App\Repositories\Contracts\TreasuryRepositoryInterface;
use App\Models\Treasury;
use App\Http\Requests\Dashboard\Treasury\{StoreTreasuryRequest,UpdateTreasuryRequest};
class TreasuryController extends Controller {
    public function __construct(
        protected TreasuryDataTable $treasuryDataTable,
        protected TreasuryRepositoryInterface $treasuryInterface
    ) {}

    public function index() {
        return $this->treasuryInterface->index($this->treasuryDataTable);
    }

    public function store(StoreTreasuryRequest $request) {
        return $this->treasuryInterface->store($request);
    }

    public function update(UpdateTreasuryRequest $request, Treasury $treasury) {
        return $this->treasuryInterface->update($request, $treasury);
    }

    public function toggleStatus(Treasury $treasury) {
        return $this->treasuryInterface->toggleStatus($treasury);
    }

    public function toggleMaster(Treasury $treasury) {
        return $this->treasuryInterface->toggleMaster($treasury);
    }

    public function destroy(Treasury $treasury) {
        return $this->treasuryInterface->destroy($treasury);
    }
}