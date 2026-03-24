{{-- resources/views/dashboard/admin/treasuries/btn/create.blade.php --}}

<div class="modal fade" id="createTreasuryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('dashboard/treasury.create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="createTreasuryForm" action="{{ route('admin.treasuries.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    {{-- Tabs بتاعت اللغات --}}
                    @php
                        $locales = array_keys(config('laravellocalization.supportedLocales'));
                        $currentLocale = app()->getLocale();
                    @endphp

                    <ul class="nav nav-tabs mb-3" id="translationTabs">
                        @foreach($locales as $locale)
                            <li class="nav-item">
                                <button type="button"
                                    class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                    data-bs-toggle="tab"
                                    data-bs-target="#tab-{{ $locale }}">
                                    {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content mb-3">
                        @foreach($locales as $locale)
                            
                            <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                id="tab-{{ $locale }}">
                                <div class="mb-3">
                                    <label class="form-label">
                                        {{ trans('dashboard/treasury.name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"
                                        name="name[{{ $locale }}]"
                                        class="form-control {{ $errors->has('name.' . $locale) ? 'is-invalid' : '' }}"
                                        value="{{ old('name.' . $locale) }}"
                                        placeholder="{{ trans('dashboard/treasury.name') }}">
                                    @if($errors->has('name.' . $locale))
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('name.' . $locale) }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- is_master --}}
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="form-label mb-0">{{ trans('dashboard/treasury.is_master') }}</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_master" value="0">
                            <input class="form-check-input" type="checkbox"
                                name="is_master" value="1" id="isMasterSwitch">
                            <label class="form-check-label" for="isMasterSwitch">
                                <span id="isMasterLabel">{{ trans('dashboard/treasury.sub') }}</span>
                            </label>
                        </div>
                    </div>

                    {{-- is_active --}}
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="form-label mb-0">{{ trans('dashboard/treasury.is_active') }}</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox"
                                name="is_active" value="1" id="isActiveSwitch" checked>
                            <label class="form-check-label" for="isActiveSwitch">
                                <span id="isActiveLabel">{{ trans('dashboard/general.active') }}</span>
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