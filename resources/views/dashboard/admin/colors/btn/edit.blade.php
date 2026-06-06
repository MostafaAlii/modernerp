<div class="modal fade" id="editColorModal-{{ $color->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('dashboard/colors.edit') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.colors.update', $color->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    @php
                        $locales       = array_keys(config('laravellocalization.supportedLocales'));
                        $currentLocale = app()->getLocale();
                    @endphp

                    {{-- LANGUAGES TABS --}}
                    <ul class="mb-3 nav nav-tabs">
                        @foreach($locales as $locale)
                            <li class="nav-item">
                                <button type="button"
                                    class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#edit-color-tab-{{ $color->id }}-{{ $locale }}">
                                    {{ strtoupper($locale) }}
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content mb-3">
                        @foreach($locales as $locale)
                            <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                id="edit-color-tab-{{ $color->id }}-{{ $locale }}">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/colors.name') }} ({{ strtoupper($locale) }})
                                    </label>
                                    <input type="text"
                                        name="name[{{ $locale }}]"
                                        class="form-control"
                                        value="{{ $color->translate($locale)?->name }}">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- COLOR PICKER --}}
                    <div class="mb-3">
                        <label class="form-label">{{ trans('dashboard/colors.hex_code') }}</label>
                        <div class="d-flex align-items-center gap-3">
                            <input type="color"
                                id="editColorPicker-{{ $color->id }}"
                                value="{{ $color->hex_code }}"
                                class="form-control form-control-color"
                                style="width:60px; height:40px; padding:2px; cursor:pointer;"
                                oninput="document.getElementById('editHexInput-{{ $color->id }}').value = this.value">
                            <input type="text"
                                id="editHexInput-{{ $color->id }}"
                                name="hex_code"
                                value="{{ $color->hex_code }}"
                                class="form-control"
                                placeholder="#000000"
                                maxlength="7"
                                oninput="syncColorPicker(this, 'editColorPicker-{{ $color->id }}')">
                        </div>
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="mb-0 form-label">{{ trans('dashboard/colors.is_active') }}</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input"
                                type="checkbox"
                                name="status"
                                value="1"
                                id="editColorStatusSwitch-{{ $color->id }}"
                                @checked($color->status->value == 1)>
                            <label class="form-check-label" for="editColorStatusSwitch-{{ $color->id }}">
                                <span id="editColorStatusLabel-{{ $color->id }}">
                                    {{ $color->status->value == 1
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
document.getElementById('editColorStatusSwitch-{{ $color->id }}')?.addEventListener('change', function () {
    document.getElementById('editColorStatusLabel-{{ $color->id }}').textContent = this.checked
        ? '{{ trans("dashboard/general.active") }}'
        : '{{ trans("dashboard/general.in_active") }}';
});
</script>