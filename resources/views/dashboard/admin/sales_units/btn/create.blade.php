<div class="modal fade" id="createSalesUnitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">
                    {{ trans('dashboard/sales_units.create') }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.sales_units.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    {{-- LANGUAGES TABS --}}
                    <ul class="mb-3 nav nav-tabs">
                        @foreach($locales as $locale)
                            <li class="nav-item">
                                <button type="button"
                                    class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#create-su-tab-{{ $locale }}">
                                    {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mb-3">
                        @foreach($locales as $locale)
                            <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                id="create-su-tab-{{ $locale }}">

                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/sales_units.name') }} ({{ strtoupper($locale) }})
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        name="name[{{ $locale }}]"
                                        class="form-control"
                                        required>
                                </div>

                            </div>
                        @endforeach
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="mb-0 form-label">
                            {{ trans('dashboard/sales_units.is_active') }}
                        </label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="status" value="0">
                            <input class="form-check-input"
                                type="checkbox"
                                name="status"
                                value="1"
                                id="salesUnitStatusSwitch"
                                checked>
                            <label class="form-check-label" for="salesUnitStatusSwitch">
                                <span id="salesUnitStatusLabel">
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
document.getElementById('salesUnitStatusSwitch')?.addEventListener('change', function () {
    document.getElementById('salesUnitStatusLabel').textContent = this.checked
        ? '{{ trans("dashboard/general.active") }}'
        : '{{ trans("dashboard/general.in_active") }}';
});
</script>