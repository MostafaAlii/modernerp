<div class="d-flex align-items-center justify-content-center gap-2">
    <button type="button" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
        data-bs-target="#editSupplierModal-{{ $supplier->id }}">
        <i class="fa fa-edit"></i>
    </button>
    <button type="button" class="btn btn-sm btn-light-danger" data-bs-toggle="modal"
        data-bs-target="#deleteSupplierModal-{{ $supplier->id }}">
        <i class="fa fa-trash"></i>
    </button>
</div>
@include('dashboard.admin.suppliers.btn.edit', ['supplier' => $supplier])
@include('dashboard.admin.suppliers.btn.delete', ['supplier' => $supplier])
