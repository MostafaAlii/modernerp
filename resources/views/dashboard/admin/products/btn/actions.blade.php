<div class="d-flex align-items-center justify-content-center gap-2">
    <button type="button"
        class="btn btn-sm btn-light-info"
        data-bs-toggle="modal"
        data-bs-target="#showProductModal-{{ $product->id }}">
        <i class="fa fa-eye"></i>
    </button>
    {{-- EDIT --}}
    <a href="{{ route('admin.products.edit', $product->id) }}"
        class="btn btn-sm btn-light-primary">
        <i class="fa fa-edit"></i>
    </a>
    {{-- DELETE --}}
    <button type="button"
        class="btn btn-sm btn-light-danger"
        data-bs-toggle="modal"
        data-bs-target="#deleteProductModal-{{ $product->id }}">
        <i class="fa fa-trash"></i>
    </button>
</div>
@include('dashboard.admin.products.btn.delete', ['product' => $product])
@include('dashboard.admin.products.btn.show', ['product' => $product])