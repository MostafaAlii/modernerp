<div class="modal fade" id="editBrandModal-{{ $brand->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('dashboard/brands.edit') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.brands.update', $brand->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @php
                        $locales       = array_keys(config('laravellocalization.supportedLocales'));
                        $currentLocale = app()->getLocale();
                    @endphp
                    <ul class="mb-3 nav nav-tabs">
                        @foreach($locales as $locale)
                            <li class="nav-item">
                                <button type="button"
                                    class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#edit-brand-tab-{{ $brand->id }}-{{ $locale }}">
                                    {{ strtoupper($locale) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mb-3">
                        @foreach($locales as $locale)
                            <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                id="edit-brand-tab-{{ $brand->id }}-{{ $locale }}">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/brands.name') }} ({{ strtoupper($locale) }})
                                    </label>
                                    <input type="text"
                                        name="name[{{ $locale }}]"
                                        class="form-control"
                                        value="{{ $brand->translate($locale)?->name }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="mb-0 form-label">{{ trans('dashboard/brands.is_active') }}</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input"
                                type="checkbox"
                                name="status"
                                value="1"
                                id="editBrandStatusSwitch-{{ $brand->id }}"
                                @checked($brand->status->value == 1)>
                            <label class="form-check-label" for="editBrandStatusSwitch-{{ $brand->id }}">
                                <span id="editBrandStatusLabel-{{ $brand->id }}">
                                    {{ $brand->status->value == 1
                                        ? trans('dashboard/general.active')
                                        : trans('dashboard/general.in_active') }}
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
document.getElementById('editBrandStatusSwitch-{{ $brand->id }}')?.addEventListener('change', function () {
    document.getElementById('editBrandStatusLabel-{{ $brand->id }}').textContent = this.checked
        ? '{{ trans("dashboard/general.active") }}'
        : '{{ trans("dashboard/general.in_active") }}';
});
</script>