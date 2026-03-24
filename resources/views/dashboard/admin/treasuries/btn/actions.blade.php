<div class="d-flex justify-content-center">
    <!-- زرار تعديل -->
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
        data-bs-target="#editModal{{ $treasury->id }}">
        <i class="fas fa-edit"></i>
    </button>
    
    <!-- Modal Edit -->

    <!-- Delete Button (Optional) -->
    <button type="button" class="mx-1 btn btn-danger btn-sm" data-bs-toggle="modal"
        data-bs-target="#deleteModal{{ $treasury->id }}">
        <i class="fas fa-trash"></i>
    </button>

    <div class="modal fade" id="deleteModal{{ $treasury->id }}" tabindex="-1" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('dashboard/treasury.delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="text-center modal-body">
                    <p>{{ trans('dashboard/treasury.delete_confirm', ['name' => $treasury->name]) }}</p>
                    <p class="text-danger">{{ trans('dashboard/general.action_irreversible') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ trans('dashboard/general.cancel') }}
                    </button>
                    <form action="{{ route('admin.treasuries.destroy', $treasury->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            {{ trans('dashboard/general.confirm_delete') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>