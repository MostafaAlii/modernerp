
    <button type="button" class="btn btn-sm btn-primary btn-edit-sales-matrial-type" data-bs-toggle="modal" data-bs-target="#editSalesMatrialTypeModal"
        data-id="{{ $salesMatrialType->id }}">
        <i class="fa fa-edit"></i>
    </button>
    <div class="modal fade" id="editSalesMatrialTypeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('dashboard/sales_matrial_type.edit') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="editForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <div class="modal-body">

                        @php
                            $locales = array_keys(config('laravellocalization.supportedLocales'));
                            $currentLocale = app()->getLocale();
                        @endphp

                        <!-- التابات -->
                        <ul class="mb-3 nav nav-tabs">
                            @foreach($locales as $locale)
                                <li class="nav-item">
                                    <button type="button"
                                        class="nav-link {{ $locale === $currentLocale ? 'active' : '' }}"
                                        data-bs-toggle="tab"
                                        data-bs-target="#edit-tab-{{ $locale }}">
                                        {{ config('laravellocalization.supportedLocales.' . $locale . '.native') }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>

                        <!-- محتوى التابات -->
                        <div class="mb-3 tab-content">
                            @foreach($locales as $locale)
                                <div class="tab-pane fade {{ $locale === $currentLocale ? 'show active' : '' }}"
                                    id="edit-tab-{{ $locale }}">

                                    <div class="mb-3">
                                        <label class="form-label">
                                            {{ trans('dashboard/sales_matrial_type.name') }}
                                        </label>

                                        <input type="text"
                                            name="name[{{ $locale }}]"
                                            class="form-control"
                                            id="edit_name_{{ $locale }}"
                                            placeholder="{{ trans('dashboard/sales_matrial_type.name') }}"
                                            required>
                                    </div>

                                </div>
                            @endforeach
                        </div>

                        <!-- حالة التفعيل -->
                        <div class="mb-3 d-flex align-items-center justify-content-between">
                            <label class="mb-0 form-label">
                                {{ trans('dashboard/sales_matrial_type.is_active') }}
                            </label>

                            <div class="form-check form-switch">
                                <input type="hidden" name="is_active" value="0">

                                <input class="form-check-input"
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    id="editIsActiveSwitch">

                                <label class="form-check-label" for="editIsActiveSwitch">
                                    <span id="editIsActiveLabel">Inactive</span>
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
    <button type="button" class="mx-1 btn btn-danger btn-sm btn-delete-sales-matrial-type"
        data-id="{{ $salesMatrialType->id }}" data-name="{{ $salesMatrialType->name }}">
        <i class="fas fa-trash"></i>
    </button>

    <div class="modal fade" id="deleteSalesMatrialTypeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('dashboard/sales_matrial_type.delete') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="text-center modal-body">
                    <p id="deleteMessage">{{ trans('dashboard/sales_matrial_type.delete_confirm', ['name' => '']) }}</p>
                    <p class="text-danger">{{ trans('dashboard/general.action_irreversible') }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        {{ trans('dashboard/general.cancel') }}
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">
                        {{ trans('dashboard/general.confirm_delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
