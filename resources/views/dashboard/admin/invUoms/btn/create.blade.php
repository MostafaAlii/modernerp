<div class="modal fade" id="createInvUomModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('dashboard/inv_uom.create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.invUoms.store') }}" method="POST" id="createForm">
                @csrf
                <div class="modal-body">
                    <ul class="mb-3 nav nav-tabs">
                        @foreach($locales as $locale)
                        <li class="nav-item">
                            <button type="button" class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                data-bs-toggle="tab" data-bs-target="#create-tab-{{ $locale }}">
                                {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                            </button>
                        </li>
                        @endforeach
                    </ul>

                    <div class="mb-3 tab-content">
                        @foreach($locales as $locale)
                        <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                            id="create-tab-{{ $locale }}">
                            <div class="mb-3">
                                <label class="form-label">{{ trans('dashboard/inv_uom.name') }} ({{ strtoupper($locale)
                                    }}) <span class="text-danger">*</span></label>
                                <input type="text" name="name[{{ $locale }}]" class="form-control" required>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ trans('dashboard/general.date') }}</label>
                                <input type="date" name="date" class="form-control">
                            </div>
                        </div>
                        @ownerOnly
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ trans('dashboard/inv_uom.company') }}</label>
                                <select name="company_id" class="form-select">
                                    <option value="">{{ trans('dashboard/inv_uom.select_company') }}</option>
                                    @foreach($companies ?? [] as $company)
                                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @endOwnerOnly
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="mb-0 form-label">{{ trans('dashboard/inv_uom.is_master') }}</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_master" value="0">
                            <input class="form-check-input" type="checkbox" name="is_master" value="1"
                                id="isMasterSwitch">
                            <label class="form-check-label" for="isMasterSwitch">
                                <span id="isMasterLabel">{{ trans('dashboard/inv_uom.sub') }}</span>
                            </label>
                        </div>
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="mb-0 form-label">{{ trans('dashboard/inv_uom.is_active') }}</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="isActiveSwitch" checked>
                            <label class="form-check-label" for="isActiveSwitch">
                                <span id="isActiveLabel">{{ trans('dashboard/general.active') }}</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{
                        trans('dashboard/general.cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ trans('dashboard/general.save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // is_master label
    document.getElementById('isMasterSwitch')?.addEventListener('change', function() {
        document.getElementById('isMasterLabel').textContent = this.checked 
            ? '{{ trans("dashboard/inv_uom.master") }}' 
            : '{{ trans("dashboard/inv_uom.sub") }}';
    });

    // is_active label
    document.getElementById('isActiveSwitch')?.addEventListener('change', function() {
        document.getElementById('isActiveLabel').textContent = this.checked 
            ? '{{ trans("dashboard/general.active") }}' 
            : '{{ trans("dashboard/general.in_active") }}';
    });
</script>