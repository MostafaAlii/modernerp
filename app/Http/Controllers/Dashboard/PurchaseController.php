<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\DataTables\Dashboard\Admin\PurchaseDataTable;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use App\Models\Purchase;
use App\Http\Requests\Dashboard\Purchase\StorePurchaseRequest;
use App\Http\Requests\Dashboard\Purchase\UpdatePurchaseRequest;

class PurchaseController extends Controller
{
    public function __construct(
        protected PurchaseDataTable $purchaseDataTable,
        protected PurchaseRepositoryInterface $purchaseInterface
    ) {}

    public function index()
    {
        return $this->purchaseInterface->index($this->purchaseDataTable);
    }

    public function create()
    {
        return $this->purchaseInterface->create();
    }

    public function store(StorePurchaseRequest $request)
    {
        return $this->purchaseInterface->store($request);
    }

    public function edit(Purchase $purchase)
    {
        return $this->purchaseInterface->edit($purchase);
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        return $this->purchaseInterface->update($request, $purchase);
    }

    public function show(Purchase $purchase) {
        return $this->purchaseInterface->show($purchase);
    }

    public function confirm(Purchase $purchase)
    {
        $result = $this->purchaseInterface->confirm($purchase);

        if ($result['status']) {
            return redirect()->route('admin.purchases.index')
                ->with('success', trans('dashboard/purchases.confirmed_successfully'));
        }

        return match ($result['message'] ?? 'ERROR') {
            'NOT_DRAFT' => redirect()->back()->with('error', trans('dashboard/purchases.cannot_confirm_non_draft')),
            default     => redirect()->back()->with('error', trans('dashboard/general.error_occurred')),
        };
    }

    public function cancel(Purchase $purchase)
    {
        $result = $this->purchaseInterface->cancel($purchase);

        if ($result['status']) {
            return redirect()->route('admin.purchases.index')
                ->with('success', trans('dashboard/purchases.cancelled_successfully'));
        }

        return match ($result['message'] ?? 'ERROR') {
            'ALREADY_CANCELLED' => redirect()->back()->with('error', trans('dashboard/purchases.already_cancelled')),
            default             => redirect()->back()->with('error', trans('dashboard/general.error_occurred')),
        };
    }

    public function destroy(Purchase $purchase)
    {
        $result = $this->purchaseInterface->destroy($purchase);

        if ($result['status']) {
            return redirect()->route('admin.purchases.index')
                ->with('success', trans('dashboard/purchases.deleted_successfully'));
        }

        return match ($result['message'] ?? 'ERROR') {
            'CONFIRMED' => redirect()->back()->with('error', trans('dashboard/purchases.cannot_delete_confirmed')),
            default     => redirect()->back()->with('error', trans('dashboard/general.error_occurred')),
        };
    }
}