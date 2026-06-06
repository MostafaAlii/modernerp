<div class="d-flex align-items-center gap-2">
    <button type="button"
        class="btn btn-sm btn-light-primary"
        data-bs-toggle="modal"
        data-bs-target="#editSizeModal-{{ $size->id }}">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button"
        class="btn btn-sm btn-light-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteSizeModal-{{ $size->id }}">
        <i class="fa fa-trash"></i>
    </button>
</div>
@include('dashboard.admin.sizes.btn.edit',   ['size' => $size])
@include('dashboard.admin.sizes.btn.delete', ['size' => $size])