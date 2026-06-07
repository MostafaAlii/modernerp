<div class="modal fade" id="createSupplierModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('dashboard/suppliers.create') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.suppliers.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">

                        {{-- NAME --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                {{ trans('dashboard/suppliers.name') }}
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        {{-- PHONE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ trans('dashboard/suppliers.phone') }}</label>
                            <input type="text" name="phone" class="form-control">
                        </div>

                        {{-- EMAIL --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ trans('dashboard/suppliers.email') }}</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        {{-- ADDRESS --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ trans('dashboard/suppliers.address') }}</label>
                            <input type="text" name="address" class="form-control">
                        </div>

                        {{-- NOTES --}}
                        <div class="col-12 mb-3">
                            <label class="form-label">{{ trans('dashboard/suppliers.notes') }}</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>

                        {{-- STATUS --}}
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="mb-0 form-label">{{ trans('dashboard/suppliers.is_active') }}</label>
                                <div class="form-check form-switch">
                                    <input type="hidden" name="status" value="0">
                                    <input class="form-check-input" type="checkbox" name="status" value="1"
                                        id="createSupplierStatus" checked>
                                    <label class="form-check-label" for="createSupplierStatus">
                                        <span id="createSupplierStatusLabel">
                                            {{ trans('dashboard/general.active') }}
                                        </span>
                                    </label>
                                </div>
                            </div>
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
    document.getElementById('createSupplierStatus')?.addEventListener('change', function () {
    document.getElementById('createSupplierStatusLabel').textContent = this.checked
        ? '{{ trans("dashboard/general.active") }}'
        : '{{ trans("dashboard/general.in_active") }}';
});
</script>
