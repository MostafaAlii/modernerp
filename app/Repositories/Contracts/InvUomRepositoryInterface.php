<?php

namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\InvUomDataTable;
use App\Models\InvUom;
use App\Http\Requests\Dashboard\InvUom\StoreInvUomRequest;

interface InvUomRepositoryInterface
{
    public function index(InvUomDataTable $invUomDataTable);
    public function store(StoreInvUomRequest $request);
    public function toggleStatus(InvUom $invUom);
    public function toggleMaster(InvUom $invUom);
    public function destroy(InvUom $invUom);
    public function update(InvUom $invUom, array $data);
}