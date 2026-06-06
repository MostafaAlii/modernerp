<?php
namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\SalesUnitDataTable;
use App\Models\SalesUnit;
use App\Http\Requests\Dashboard\SalesUnit\StoreSalesUnitRequest;

interface SalesUnitRepositoryInterface
{
    public function index(SalesUnitDataTable $salesUnitDataTable);
    public function store(StoreSalesUnitRequest $request);
    public function update(SalesUnit $salesUnit, array $data): SalesUnit;
    public function delete(SalesUnit $salesUnit): array;
}