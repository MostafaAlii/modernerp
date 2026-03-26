{{-- Basic Info --}}
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ trans('dashboard/general.basic_info') }}
                            </h6>

                            <div class="row g-3">

                                <div class="col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            {{ trans('dashboard/treasury.name') }}
                                        </small>
                                        <span class="fw-bold">
                                            {{ $treasury->name }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            {{ trans('dashboard/treasury.is_master') }}
                                        </small>
                                        @if($treasury->is_master)
                                            <span class="badge bg-success">
                                                {{ trans('dashboard/treasury.master') }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                {{ trans('dashboard/treasury.sub') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            {{ trans('dashboard/treasury.is_active') }}
                                        </small>
                                        @if($treasury->is_active->value)
                                            <span class="badge bg-success">
                                                {{ trans('dashboard/general.active') }}
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                {{ trans('dashboard/general.in_active') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Financial Info --}}
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <h6 class="text-muted mb-3">
                                <i class="fas fa-coins me-1"></i>
                                {{ trans('dashboard/treasury.receipts') }}
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            {{ trans('dashboard/treasury.last_exchange_receipt') }}
                                        </small>
                                        <span class="fw-bold">
                                            {{ $treasury->last_exchange_receipt ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            {{ trans('dashboard/treasury.last_collect_receipt') }}
                                        </small>
                                        <span class="fw-bold">
                                            {{ $treasury->last_collect_receipt ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- System Info --}}
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">{{ trans('dashboard/general.company') }}</small>
                                        <span class="fw-bold">
                                            {{ $treasury->company?->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            {{ trans('dashboard/treasury.created_by') }}
                                        </small>
                                        <span class="fw-bold">
                                            {{ $treasury->createdby?->name ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="border rounded p-2">
                                        <small class="text-muted d-block">
                                            {{ trans('dashboard/general.date') }}
                                        </small>
                                        <span class="fw-bold">
                                            {{ $treasury->date?->format('Y-m-d') ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>