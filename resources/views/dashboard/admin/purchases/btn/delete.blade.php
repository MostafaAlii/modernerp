<div class="modal fade" id="deletePurchaseModal-{{ $purchase->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">{{ trans('dashboard/purchases.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>
                        {!! trans('dashboard/purchases.delete_confirm', [
                        'number' => $purchase->invoice_number ?? '#' . $purchase->id
                        ]) !!}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ trans('dashboard/general.cancel') }}
                    </button>
                    <button type="submit" class="btn btn-danger">
                        {{ trans('dashboard/general.delete') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
