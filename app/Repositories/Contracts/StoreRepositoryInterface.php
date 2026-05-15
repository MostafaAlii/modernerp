<?php

namespace App\Repositories\Contracts;

use App\DataTables\Dashboard\Admin\StoreDataTable;
use App\Models\Store;
use App\Http\Requests\Dashboard\Store\StoreStoreRequest;

interface StoreRepositoryInterface
{
    public function index(StoreDataTable $storeDataTable);
    public function store(StoreStoreRequest $request);
    public function toggleStatus(Store $store);
    public function destroy(Store $store);
    public function update(Store $store, array $data);
}