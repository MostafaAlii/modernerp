<div class="d-flex align-items-center gap-2">
    <button type="button"
        class="btn btn-sm btn-light-primary"
        data-bs-toggle="modal"
        data-bs-target="#editColorModal-{{ $color->id }}">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button"
        class="btn btn-sm btn-light-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteColorModal-{{ $color->id }}">
        <i class="fa fa-trash"></i>
    </button>
</div>
@include('dashboard.admin.colors.btn.edit',   ['color' => $color])
@include('dashboard.admin.colors.btn.delete', ['color' => $color])