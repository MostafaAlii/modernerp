<div class="modal fade" id="deleteBrandModal-{{ $brand->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">{{ trans('dashboard/brands.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.brands.destroy', $brand->id) }}" method="POST">
                @csrf
                @method('DELETE')
                @php $currentLocale = app()->getLocale(); @endphp
                <div class="modal-body">
                    <p>
                        {!! trans('dashboard/brands.delete_confirm', [
                            'name' => $brand->translate($currentLocale)?->name
                                   ?? $brand->translate('ar')?->name
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