<div class="d-flex align-items-center gap-2">

    {{-- EDIT --}}
    <button type="button"
        class="btn btn-sm btn-light-primary"
        data-bs-toggle="modal"
        data-bs-target="#editSalesUnitModal-{{ $salesUnit->id }}">
        <i class="fa fa-edit"></i>
    </button>

    {{-- DELETE --}}
    <button type="button"
        class="btn btn-sm btn-light-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteSalesUnitModal-{{ $salesUnit->id }}">
        <i class="fa fa-trash"></i>
    </button>

</div>

{{-- MODALS --}}
@include('dashboard.admin.sales_units.btn.edit',   ['salesUnit' => $salesUnit])
@include('dashboard.admin.sales_units.btn.delete', ['salesUnit' => $salesUnit])