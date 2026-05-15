<button type="button" class="mx-1 btn btn-sm btn-primary btn-edit-store" data-id="{{ $store->id }}"
    data-name="{{ $store->name }}">
    <i class="fa fa-edit"></i>
</button>

<button type="button" class="mx-1 btn btn-sm btn-danger btn-delete-store" data-id="{{ $store->id }}"
    data-name="{{ $store->name }}">
    <i class="fas fa-trash"></i>
</button>

<div class="modal fade" id="editStoreModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('dashboard/store.edit') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                <input type="hidden" name="_method" value="PUT">

                <div class="modal-body">
                    <ul class="mb-3 nav nav-tabs">
                        @php
                            $locales = array_keys(config('laravellocalization.supportedLocales'));
                            $currentLocale = app()->getLocale();
                        @endphp
                        @foreach($locales as $locale)
                        <li class="nav-item">
                            <button type="button" class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                data-bs-toggle="tab" data-bs-target="#edit-tab-{{ $locale }}">
                                {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                            </button>
                        </li>
                        @endforeach
                    </ul>

                    <div class="mb-3 tab-content">
                        @foreach($locales as $locale)
                        <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                            id="edit-tab-{{ $locale }}">
                            <div class="mb-3">
                                <label class="form-label">{{ trans('dashboard/store.name') }}</label>
                                <input type="text" name="name[{{ $locale }}]" class="form-control"
                                    id="edit_name_{{ $locale }}">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ trans('dashboard/store.phone') }}</label>
                                <input type="text" name="phone" class="form-control" id="edit_phone">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">{{ trans('dashboard/general.date') }}</label>
                                <input type="date" name="date" class="form-control" id="edit_date">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ trans('dashboard/store.address') }}</label>
                        <textarea name="address" class="form-control" rows="3" id="edit_address"></textarea>
                    </div>

                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <label class="mb-0 form-label">{{ trans('dashboard/store.is_active') }}</label>
                        <div class="form-check form-switch">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="editIsActiveSwitch">
                            <label class="form-check-label" for="editIsActiveSwitch">
                                <span id="editIsActiveLabel">{{ trans('dashboard/general.inactive') }}</span>
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






<div class="modal fade" id="deleteStoreModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('dashboard/store.delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="text-center modal-body">
                <p id="deleteMessage"></p>
                <p class="text-danger">{{ trans('dashboard/general.action_irreversible') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{
                    trans('dashboard/general.cancel') }}</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{
                    trans('dashboard/general.confirm_delete') }}</button>
            </div>
        </div>
    </div>
</div>