<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    {{ trans('dashboard/categories.create') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    {{-- LANGUAGES TABS --}}
                    <ul class="mb-3 nav nav-tabs">
                        @foreach($locales as $locale)
                            <li class="nav-item">
                                <button type="button"
                                    class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#create-tab-{{ $locale }}">
                                    {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mb-3">
                        @foreach($locales as $locale)
                            <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                id="create-tab-{{ $locale }}">

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/categories.name') }} ({{ strtoupper($locale) }})
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="name[{{ $locale }}]"
                                        class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/categories.short_description') }}
                                    </label>

                                    <input type="text"
                                        name="short_description[{{ $locale }}]"
                                        class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/categories.description') }}
                                    </label>

                                    <textarea name="description[{{ $locale }}]"
                                        class="form-control"
                                        rows="3"></textarea>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- PARENT CATEGORY --}}
                    <div class="mb-3">
                        <label class="form-label">
                            {{ trans('dashboard/categories.parent') }}
                        </label>

                        <select name="parent_id" class="form-control">
                            <option value="">{{ trans('dashboard/categories.type_main') }}</option>

                            @foreach($parentCategory as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->translate($currentLocale)?->name
                                        ?? $category->translate('ar')?->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="mb-0 form-label">
                            {{ trans('dashboard/categories.is_active') }}
                        </label>

                        <div class="form-check form-switch">
                            <input type="hidden" name="status" value="0">

                            <input class="form-check-input"
                                type="checkbox"
                                name="status"
                                value="1"
                                id="categoryStatusSwitch"
                                checked>

                            <label class="form-check-label" for="categoryStatusSwitch">
                                <span id="categoryStatusLabel">
                                    {{ trans('dashboard/general.active') }}
                                </span>
                            </label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ trans('dashboard/general.cancel') }}
                    </button>

                    <button type="submit" class="btn btn-primary">
                        {{ trans('dashboard/general.save') }}
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('categoryStatusSwitch')?.addEventListener('change', function () {
    document.getElementById('categoryStatusLabel').textContent = this.checked
        ? '{{ trans("dashboard/general.active") }}'
        : '{{ trans("dashboard/general.in_active") }}';
});
</script>