<div class="d-flex align-items-center justify-content-center gap-2">

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