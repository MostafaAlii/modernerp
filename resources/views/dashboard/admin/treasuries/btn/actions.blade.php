<div class="d-flex justify-content-center">
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
        data-bs-target="#editModal{{ $treasury->id }}">
        <i class="fas fa-edit"></i>
    </button>
    
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal{{ $treasury->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('dashboard/treasury.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.treasuries.update', $treasury->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="modal_source" value="edit_{{ $treasury->id }}">
                        @php
                            $locales     = array_keys(config('laravellocalization.supportedLocales'));
                            $currentLocale = app()->getLocale();
                        @endphp

                        <ul class="nav nav-tabs mb-3">
                            @foreach($locales as $locale)
                                <li class="nav-item">
                                    <button type="button"
                                        class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                        data-bs-toggle="tab"
                                        data-bs-target="#edit-tab-{{ $locale }}-{{ $treasury->id }}">
                                        {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <div class="tab-content mb-3">
                            @foreach($locales as $locale)
                                <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                    id="edit-tab-{{ $locale }}-{{ $treasury->id }}">
                                    <div class="mb-3">
                                        <label class="form-label">
                                            {{ trans('dashboard/treasury.name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text"
                                            name="name[{{ $locale }}]"
                                            class="form-control {{ $errors->has('name.' . $locale) ? 'is-invalid' : '' }}"
                                            value="{{ old('name.' . $locale, $treasury->translate($locale)?->name) }}"
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ trans('dashboard/treasury.last_exchange_receipt_number') }}</label>
                                    <input type="number"
                                        name="last_exchange_receipt"
                                        class="form-control {{ $errors->has('last_exchange_receipt') ? 'is-invalid' : '' }}"
                                        value="{{ old('last_exchange_receipt', $treasury->last_exchange_receipt) }}"
                                        min="0">
                                    @if($errors->has('last_exchange_receipt'))
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('last_exchange_receipt') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">{{ trans('dashboard/treasury.last_collect_receipt_number') }}</label>
                                    <input type="number"
                                        name="last_collect_receipt"
                                        class="form-control {{ $errors->has('last_collect_receipt') ? 'is-invalid' : '' }}"
                                        value="{{ old('last_collect_receipt', $treasury->last_collect_receipt) }}"
                                        min="0">
                                    @if($errors->has('last_collect_receipt'))
                                        <div class="invalid-feedback d-block">
                                            {{ $errors->first('last_collect_receipt') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- is_master --}}
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <label class="form-label mb-0">{{ trans('dashboard/treasury.is_master') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_master" value="0">
                                <input class="form-check-input" type="checkbox"
                                    name="is_master" value="1"
                                    id="isMasterSwitch{{ $treasury->id }}"
                                    {{ $treasury->is_master ? 'checked' : '' }}>
                                <label class="form-check-label" for="isMasterSwitch{{ $treasury->id }}">
                                    <span id="isMasterLabel{{ $treasury->id }}">
                                        {{ $treasury->is_master ? trans('dashboard/treasury.master') : trans('dashboard/treasury.sub') }}
                                    </span>
                                </label>
                            </div>
                        </div>

                        {{-- is_active --}}
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <label class="form-label mb-0">{{ trans('dashboard/treasury.is_active') }}</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox"
                                    name="is_active" value="1"
                                    id="isActiveSwitch{{ $treasury->id }}"
                                    {{ $treasury->is_active->value ? 'checked' : '' }}>
                                <label class="form-check-label" for="isActiveSwitch{{ $treasury->id }}">
                                    <span id="isActiveLabel{{ $treasury->id }}">
                                        {{ $treasury->is_active->value ? trans('dashboard/general.active') : trans('dashboard/general.in_active') }}
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