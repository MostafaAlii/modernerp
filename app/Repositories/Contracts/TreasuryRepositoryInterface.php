<?php
namespace App\Repositories\Contracts;
use App\DataTables\Dashboard\Admin\TreasuryDataTable;
use App\Models\Treasury;
use App\Http\Requests\Dashboard\Treasury\StoreTreasuryRequest;
interface TreasuryRepositoryInterface {
    public function index(TreasuryDataTable $treasuryDataTable);
    public function store(StoreTreasuryRequest $request);
    public function destroy(Treasury $treasury);
}