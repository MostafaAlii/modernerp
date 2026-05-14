<?php
namespace App\Repositories\Contracts;
use App\DataTables\Dashboard\Admin\SalesMatrialTypeDataTable;
use App\Models\{SalesMatrialType};
use App\Http\Requests\Dashboard\SalesMatrialType\{StoreSalesMatrialTypeRequest,UpdateTreasuryRequest};
interface SalesMatrialTypeRepositoryInterface {
    public function index(SalesMatrialTypeDataTable $salesMatrialTypeDataTable);
    public function store(StoreSalesMatrialTypeRequest $request);
    public function toggleStatus(SalesMatrialType $salesMatrialType);
    public function destroy(SalesMatrialType $salesMatrialType);
    public function update(SalesMatrialType $salesMatrialType, array $data);
}