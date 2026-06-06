{{-- Modal عرض تفاصيل المنتج --}}
<div class="modal fade" id="showProductModal-{{ $product->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light-info">
                <h5 class="modal-title">
                    <i class="fa fa-eye me-2"></i>
                    {{ trans('dashboard/products.product_details') }}: {{ $product->name }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body">
                {{-- معلومات المنتج الأساسية --}}
                <div class="card mb-3">
                    <div class="card-header bg-light">
                        <strong>{{ trans('dashboard/products.basic_info') }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <small class="text-muted">{{ trans('dashboard/products.category') }}:</small>
                                <p class="mb-2">{{ $product->category?->name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">{{ trans('dashboard/products.brand') }}:</small>
                                <p class="mb-2">{{ $product->brand?->name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">{{ trans('dashboard/products.variant_type') }}:</small>
                                <p class="mb-2">{{ $product->variant_type->label() }}</p>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">{{ trans('dashboard/products.status') }}:</small>
                                <p class="mb-2">
                                    @if($product->status == 1)
                                        <span class="badge bg-success">{{ trans('dashboard/general.active') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ trans('dashboard/general.in_active') }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- جدول الـ Variants مع SKU و Barcode --}}
                <div class="card">
                    <div class="card-header bg-light">
                        <strong>{{ trans('dashboard/products.variants') }}</strong>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        @if($product->variant_type->hasColor())
                                            <th>{{ trans('dashboard/products.color') }}</th>
                                        @endif
                                        @if($product->variant_type->hasSize())
                                            <th>{{ trans('dashboard/products.size') }}</th>
                                        @endif
                                        <th>{{ trans('dashboard/products.sku') }}</th>
                                        <th>{{ trans('dashboard/products.barcode') }}</th>
                                        <th>{{ trans('dashboard/products.quantity') }}</th>
                                        @if($product->has_qr)
                                            <th>{{ trans('dashboard/products.qr_code') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->variants as $index => $variant)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            @if($product->variant_type->hasColor())
                                                <td>
                                                    @if($variant->color)
                                                        <span style="background-color: {{ $variant->color->hex_code }}; padding: 2px 8px; border-radius: 4px;">
                                                            {{ $variant->color->name }}
                                                        </span>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endif
                                            @if($product->variant_type->hasSize())
                                                <td>{{ $variant->size?->name ?? '-' }}</td>
                                            @endif
                                            <td>
                                                <code class="bg-light p-1 rounded">{{ $variant->sku }}</code>
                                                <button type="button" 
                                                    class="btn btn-sm btn-outline-secondary copy-btn" 
                                                    data-copy="{{ $variant->sku }}"
                                                    title="{{ trans('dashboard/products.copy_sku') }}">
                                                    <i class="fa fa-copy"></i>
                                                </button>
                                            </td>
                                            <td>
                                                @if($variant->barcode)
                                                    <code class="bg-light p-1 rounded">{{ $variant->barcode }}</code>
                                                    <button type="button" 
                                                        class="btn btn-sm btn-outline-secondary copy-btn" 
                                                        data-copy="{{ $variant->barcode }}"
                                                        title="{{ trans('dashboard/products.copy_barcode') }}">
                                                        <i class="fa fa-copy"></i>
                                                    </button>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $variant->quantity }}</td>
                                            @if($product->has_qr)
                                                <td>
                                                    @if($variant->qr_code)
                                                        <button type="button" 
                                                            class="btn btn-sm btn-primary show-qr-btn"
                                                            data-qr="{{ asset('storage/' . $variant->qr_code) }}">
                                                            <i class="fa fa-qrcode"></i>
                                                        </button>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center">
                                                {{ trans('dashboard/products.no_variants') }}
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ trans('dashboard/general.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal صغير لعرض الـ QR Code --}}
<div class="modal fade" id="qrCodeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-light-primary">
                <h5 class="modal-title">{{ trans('dashboard/products.qr_code') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="qrCodeImage" src="" alt="QR Code" class="img-fluid" style="max-width: 200px;">
                <p class="mt-3 mb-0">
                    <small class="text-muted">{{ trans('dashboard/products.scan_qr_to_view') }}</small>
                </p>
            </div>
            <div class="modal-footer">
                <a href="#" id="downloadQrBtn" class="btn btn-sm btn-primary" download>
                    <i class="fa fa-download"></i> {{ trans('dashboard/products.download_qr') }}
                </a>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    {{ trans('dashboard/general.close') }}
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    // Copy functionality
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const textToCopy = this.dataset.copy;
            navigator.clipboard.writeText(textToCopy).then(() => {
                // Optional: Show tooltip or alert
                const originalIcon = this.innerHTML;
                this.innerHTML = '<i class="fa fa-check"></i>';
                setTimeout(() => {
                    this.innerHTML = originalIcon;
                }, 1000);
            });
        });
    });
    
    // Show QR Code Modal
    document.querySelectorAll('.show-qr-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const qrUrl = this.dataset.qr;
            const qrImage = document.getElementById('qrCodeImage');
            const downloadBtn = document.getElementById('downloadQrBtn');
            
            qrImage.src = qrUrl;
            downloadBtn.href = qrUrl;
            
            new bootstrap.Modal(document.getElementById('qrCodeModal')).show();
        });
    });
</script>
@endpush