<div class="modal fade" id="cancelPurchaseModal-{{ $purchase->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-warning">
                    {{ trans('dashboard/purchases.cancel') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.purchases.cancel', $purchase->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>
                        {{ trans('dashboard/purchases.cancel_message', [
                        'number' => $purchase->invoice_number ?? '#' . $purchase->id
                        ]) }}
                    </p>
                    @if($purchase->status->isConfirmed())
                    <div class="alert alert-danger">
                        <i class="ti ti-alert-triangle me-1"></i>
                        {{ trans('dashboard/purchases.cancel_confirmed_warning') }}
                    </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ trans('dashboard/general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-warning">
                        <i class="ti ti-ban me-1"></i>
                        {{ trans('dashboard/purchases.cancel') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
