<div class="modal fade" id="editCategoryModal-{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    {{ trans('dashboard/categories.edit') }}
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    {{-- LANGS --}}
                    <ul class="mb-3 nav nav-tabs">
                        @php
                        $locales = array_keys(config('laravellocalization.supportedLocales'));
                        $currentLocale = app()->getLocale();
                        $parentCategory = \App\Models\Category::active()->get();
                        @endphp
                        @foreach($locales as $locale)
                            <li class="nav-item">
                                <button type="button"
                                    class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#edit-tab-{{ $category->id }}-{{ $locale }}">
                                    {{ strtoupper($locale) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach($locales as $locale)
                            <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                id="edit-tab-{{ $category->id }}-{{ $locale }}">

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/categories.name') }}
                                    </label>

                                    <input type="text"
                                        name="name[{{ $locale }}]"
                                        class="form-control"
                                        value="{{ $category->translate($locale)?->name }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/categories.short_description') }}
                                    </label>

                                    <input type="text"
                                        name="short_description[{{ $locale }}]"
                                        class="form-control"
                                        value="{{ $category->translate($locale)?->short_description }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/categories.description') }}
                                    </label>

                                    <textarea name="description[{{ $locale }}]"
                                        class="form-control"
                                        rows="3">{{ $category->translate($locale)?->description }}</textarea>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- PARENT --}}
                    <div class="mb-3">
                        <label class="form-label">{{ trans('dashboard/categories.parent') }}</label>

                        <select name="parent_id" class="form-control">
                            <option value="">{{ trans('dashboard/categories.type_main') }}</option>

                            @foreach($parentCategory as $parent)
                                <option value="{{ $parent->id }}"
                                    @selected($category->parent_id == $parent->id)>
                                    {{ $parent->translate($currentLocale)?->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div class="form-check form-switch">
                        <input type="hidden" name="status" value="0">

                        <input class="form-check-input"
                            type="checkbox"
                            name="status"
                            value="1"
                            @checked($category->status->value == 1)>

                        <label class="form-label">
                            {{ trans('dashboard/categories.is_active') }}
                        </label>
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