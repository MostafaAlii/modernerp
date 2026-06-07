<?php

namespace App\Repositories\Contracts;

use App\Models\Purchase;
use App\DataTables\Dashboard\Admin\PurchaseDataTable;
use App\Http\Requests\Dashboard\Purchase\StorePurchaseRequest;
use App\Http\Requests\Dashboard\Purchase\UpdatePurchaseRequest;

interface PurchaseRepositoryInterface
{
    public function index(PurchaseDataTable $dataTable);
    public function create();
    public function store(StorePurchaseRequest $request);
    public function edit(Purchase $purchase);
    public function update(UpdatePurchaseRequest $request, Purchase $purchase);
    public function show(Purchase $purchase);
    public function confirm(Purchase $purchase): array;
    public function cancel(Purchase $purchase): array;
    public function destroy(Purchase $purchase): array;
}
