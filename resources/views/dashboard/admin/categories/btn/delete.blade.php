<div class="modal fade" id="deleteCategoryModal-{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">
                    {{ trans('dashboard/categories.delete') }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST">
                @csrf
                @method('DELETE')
                @php
                $locales = array_keys(config('laravellocalization.supportedLocales'));
                $currentLocale = app()->getLocale();
                $parentCategory = \App\Models\Category::active()->get();
                @endphp

                <div class="modal-body">
                    <p>
                        {!! trans('dashboard/categories.delete_confirm', [
                            'name' => $category->translate($currentLocale)?->name
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