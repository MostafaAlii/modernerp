<div class="modal fade" id="confirmPurchaseModal-{{ $purchase->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-success">
                    {{ trans('dashboard/purchases.confirm') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.purchases.confirm', $purchase->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p>
                        {{ trans('dashboard/purchases.confirm_message', [
                        'number' => $purchase->invoice_number ?? '#' . $purchase->id
                        ]) }}
                    </p>
                    <div class="alert alert-warning">
                        <i class="ti ti-alert-triangle me-1"></i>
                        {{ trans('dashboard/purchases.confirm_warning') }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ trans('dashboard/general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="ti ti-check me-1"></i>
                        {{ trans('dashboard/purchases.confirm') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
