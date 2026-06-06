<div class="d-flex align-items-center gap-2">

    {{-- EDIT --}}
    <button type="button"
        class="btn btn-sm btn-light-primary"
        data-bs-toggle="modal"
        data-bs-target="#editCategoryModal-{{ $category->id }}">
        <i class="fa fa-edit"></i>
    </button>

    {{-- DELETE --}}
    <button type="button"
        class="btn btn-sm btn-light-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteCategoryModal-{{ $category->id }}">
        <i class="fa fa-trash"></i>
    </button>

</div>

{{-- INCLUDE MODALS --}}
@include('dashboard.admin.categories.btn.edit', ['category' => $category])
@include('dashboard.admin.categories.btn.delete', ['category' => $category])