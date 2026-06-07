<div class="d-flex align-items-center justify-content-center gap-2">
    {{-- SHOW --}}
    <a href="{{ route('admin.purchases.show', $purchase->id) }}" class="btn btn-sm btn-light-info">
        <i class="ti ti-eye"></i>
    </a>
    {{-- EDIT - بس لو Draft --}}
    @if($purchase->status->isDraft())
    <a href="{{ route('admin.purchases.edit', $purchase->id) }}" class="btn btn-sm btn-light-primary">
        <i class="fa fa-edit"></i>
    </a>
    @endif

    {{-- CONFIRM - بس لو Draft --}}
    @if($purchase->status->isDraft())
    <button type="button" class="btn btn-sm btn-light-success" data-bs-toggle="modal"
        data-bs-target="#confirmPurchaseModal-{{ $purchase->id }}">
        <i class="ti ti-check"></i>
    </button>
    @endif

    {{-- CANCEL - لو Draft أو Confirmed --}}
    @if(!$purchase->status->isCancelled())
    <button type="button" class="btn btn-sm btn-light-warning" data-bs-toggle="modal"
        data-bs-target="#cancelPurchaseModal-{{ $purchase->id }}">
        <i class="ti ti-ban"></i>
    </button>
    @endif

    {{-- DELETE - بس لو Draft --}}
    @if($purchase->status->isDraft())
    <button type="button" class="btn btn-sm btn-light-danger" data-bs-toggle="modal"
        data-bs-target="#deletePurchaseModal-{{ $purchase->id }}">
        <i class="fa fa-trash"></i>
    </button>
    @endif

</div>

@include('dashboard.admin.purchases.btn.confirm', ['purchase' => $purchase])
@include('dashboard.admin.purchases.btn.cancel', ['purchase' => $purchase])
@include('dashboard.admin.purchases.btn.delete', ['purchase' => $purchase])
