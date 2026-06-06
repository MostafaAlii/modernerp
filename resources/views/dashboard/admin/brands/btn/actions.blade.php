<div class="d-flex align-items-center gap-2">
    <button type="button"
        class="btn btn-sm btn-light-primary"
        data-bs-toggle="modal"
        data-bs-target="#editBrandModal-{{ $brand->id }}">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button"
        class="btn btn-sm btn-light-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteBrandModal-{{ $brand->id }}">
        <i class="fa fa-trash"></i>
    </button>
</div>
@include('dashboard.admin.brands.btn.edit',   ['brand' => $brand])
@include('dashboard.admin.brands.btn.delete', ['brand' => $brand])