<?php

namespace App\Repositories\Eloquents;

use App\Models\{Purchase, PurchaseItem, ProductVariant, StockMovement, Store, Supplier, SalesUnit};
use App\DataTables\Dashboard\Admin\PurchaseDataTable;
use App\Repositories\Contracts\PurchaseRepositoryInterface;
use App\Http\Requests\Dashboard\Purchase\StorePurchaseRequest;
use App\Http\Requests\Dashboard\Purchase\UpdatePurchaseRequest;
use App\Enums\Purchase\PurchaseStatus;
use App\Enums\Stock\StockMovementType;
use Illuminate\Support\Facades\DB;

class PurchaseRepository implements PurchaseRepositoryInterface
{
    public function index(PurchaseDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.purchases.index', [
            'title' => trans('dashboard/purchases.purchases'),
        ]);
    }

    public function create()
    {
        $suppliers  = Supplier::active()->get(['id', 'name']);
        $stores     = Store::active()->with('translations')->get();
        $salesUnits = SalesUnit::active()->with('translations')->get();
        $variants   = ProductVariant::active()
            ->with(['product.translations', 'color.translations', 'size.translations', 'prices.salesUnit'])
            ->get();

        return view('dashboard.admin.purchases.create', compact(
            'suppliers',
            'stores',
            'salesUnits',
            'variants',
        ));
    }

    public function store(StorePurchaseRequest $request)
    {
        try {
            DB::beginTransaction();

            // 1. حساب الإجماليات
            $totalAmount = collect($request->items)->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });
            $discount        = $request->discount ?? 0;
            $netAmount       = $totalAmount - $discount;
            $paidAmount      = $request->paid_amount ?? 0;
            $remainingAmount = $netAmount - $paidAmount;

            // 2. إنشاء الفاتورة
            $purchase = Purchase::create([
                'supplier_id'      => $request->supplier_id,
                'store_id'         => $request->store_id,
                'invoice_date'     => $request->invoice_date,
                'total_amount'     => $totalAmount,
                'discount'         => $discount,
                'net_amount'       => $netAmount,
                'paid_amount'      => $paidAmount,
                'remaining_amount' => $remainingAmount,
                'status'           => PurchaseStatus::DRAFT,
                'notes'            => $request->notes,
            ]);

            // 3. إضافة الـ items
            foreach ($request->items as $item) {
                $purchase->items()->create([
                    'product_variant_id' => $item['product_variant_id'],
                    'sales_unit_id'      => $item['sales_unit_id'],
                    'quantity'           => $item['quantity'],
                    'unit_price'         => $item['unit_price'],
                    'total_price'        => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.purchases.index')
                ->with('success', trans('dashboard/purchases.created_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', trans('dashboard/general.error_occurred'))
                ->withInput();
        }
    }

    public function show(Purchase $purchase)
    {
        $purchase->load([
            'items.variant.product.translations',
            'items.variant.color.translations',
            'items.variant.size.translations',
            'items.salesUnit.translations',
            'supplier',
            'store.translations',
            'createdBy',
        ]);

        return view('dashboard.admin.purchases.show', compact('purchase'));
    }

    public function edit(Purchase $purchase)
    {
        // مينفعش تعدل فاتورة confirmed أو cancelled
        if (!$purchase->status->isDraft()) {
            return redirect()->route('admin.purchases.index')
                ->with('error', trans('dashboard/purchases.cannot_edit_confirmed'));
        }

        $purchase->load(['items.variant.product.translations', 'items.variant.color.translations', 'items.variant.size.translations', 'items.salesUnit']);

        $suppliers  = Supplier::active()->get(['id', 'name']);
        $stores     = Store::active()->with('translations')->get();
        $salesUnits = SalesUnit::active()->with('translations')->get();
        $variants   = ProductVariant::active()
            ->with(['product.translations', 'color.translations', 'size.translations', 'prices.salesUnit'])
            ->get();

        return view('dashboard.admin.purchases.edit', compact(
            'purchase',
            'suppliers',
            'stores',
            'salesUnits',
            'variants',
        ));
    }

    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        try {
            DB::beginTransaction();

            $totalAmount     = collect($request->items)->sum(fn($i) => $i['quantity'] * $i['unit_price']);
            $discount        = $request->discount ?? 0;
            $netAmount       = $totalAmount - $discount;
            $paidAmount      = $request->paid_amount ?? 0;
            $remainingAmount = $netAmount - $paidAmount;

            $purchase->update([
                'supplier_id'      => $request->supplier_id,
                'store_id'         => $request->store_id,
                'invoice_number'   => $request->invoice_number,
                'invoice_date'     => $request->invoice_date,
                'total_amount'     => $totalAmount,
                'discount'         => $discount,
                'net_amount'       => $netAmount,
                'paid_amount'      => $paidAmount,
                'remaining_amount' => $remainingAmount,
                'notes'            => $request->notes,
            ]);

            // امسح القديم وحط الجديد
            $purchase->items()->delete();

            foreach ($request->items as $item) {
                $purchase->items()->create([
                    'product_variant_id' => $item['product_variant_id'],
                    'sales_unit_id'      => $item['sales_unit_id'],
                    'quantity'           => $item['quantity'],
                    'unit_price'         => $item['unit_price'],
                    'total_price'        => $item['quantity'] * $item['unit_price'],
                ]);
            }

            DB::commit();
            return redirect()->route('admin.purchases.index')
                ->with('success', trans('dashboard/purchases.updated_successfully'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', trans('dashboard/general.error_occurred'))
                ->withInput();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Confirm — ده اللي بيأثر على المخزون فعلاً
    | لما الفاتورة بتتأكد:
    | 1. كمية كل variant بتزيد
    | 2. stock_movement بيتسجل
    |--------------------------------------------------------------------------
    */
    public function confirm(Purchase $purchase): array
    {
        try {
            DB::beginTransaction();

            if (!$purchase->status->isDraft()) {
                return ['status' => false, 'message' => 'NOT_DRAFT'];
            }

            foreach ($purchase->items as $item) {
                $variant = $item->variant;

                $quantityBefore = $variant->quantity;
                $quantityAfter  = $quantityBefore + $item->quantity;

                // زود الكمية في المخزون
                $variant->increment('quantity', $item->quantity);

                // سجل حركة المخزون
                StockMovement::create([
                    'product_variant_id' => $variant->id,
                    'store_id'           => $purchase->store_id,
                    'type'               => StockMovementType::PURCHASE,
                    'quantity'           => $item->quantity,
                    'quantity_before'    => $quantityBefore,
                    'quantity_after'     => $quantityAfter,
                    'unit_price'         => $item->unit_price,
                    'notes'              => 'فاتورة شراء رقم: ' . $purchase->invoice_number,
                    'reference_type'     => Purchase::class,
                    'reference_id'       => $purchase->id,
                    'created_by'         => auth()->id(),
                ]);
            }

            // غير حالة الفاتورة
            $purchase->update(['status' => PurchaseStatus::CONFIRMED]);

            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => 'ERROR'];
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Cancel — إلغاء الفاتورة
    | لو كانت confirmed → نرجع الكمية
    | لو كانت draft → نلغيها بس
    |--------------------------------------------------------------------------
    */
    public function cancel(Purchase $purchase): array
    {
        try {
            DB::beginTransaction();

            if ($purchase->status->isCancelled()) {
                return ['status' => false, 'message' => 'ALREADY_CANCELLED'];
            }

            // لو confirmed → رجع الكمية
            if ($purchase->status->isConfirmed()) {
                foreach ($purchase->items as $item) {
                    $variant        = $item->variant;
                    $quantityBefore = $variant->quantity;
                    $quantityAfter  = $quantityBefore - $item->quantity;

                    $variant->decrement('quantity', $item->quantity);

                    StockMovement::create([
                        'product_variant_id' => $variant->id,
                        'store_id'           => $purchase->store_id,
                        'type'               => StockMovementType::ADJUSTMENT,
                        'quantity'           => -$item->quantity,
                        'quantity_before'    => $quantityBefore,
                        'quantity_after'     => $quantityAfter,
                        'unit_price'         => $item->unit_price,
                        'notes'              => 'إلغاء فاتورة شراء رقم: ' . $purchase->invoice_number,
                        'reference_type'     => Purchase::class,
                        'reference_id'       => $purchase->id,
                        'created_by'         => auth()->id(),
                    ]);
                }
            }

            $purchase->update(['status' => PurchaseStatus::CANCELLED]);

            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => 'ERROR'];
        }
    }

    public function destroy(Purchase $purchase): array
    {
        try {
            DB::beginTransaction();

            // مينفعش تحذف فاتورة confirmed
            if ($purchase->status->isConfirmed()) {
                return ['status' => false, 'message' => 'CONFIRMED'];
            }

            $purchase->delete();

            DB::commit();
            return ['status' => true];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false, 'message' => 'ERROR'];
        }
    }
}
