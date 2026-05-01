@extends('layouts.app')

@section('title', 'Inventory - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Inventory Management</h2>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-success bg-opacity-10 border-start border-success border-4 h-100">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-success fw-bold mb-1 text-uppercase" style="font-size: 0.8rem;">Available Items</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $availableCount }}</h3>
                        </div>
                        <i class="bi bi-box-seam fs-1 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-danger bg-opacity-10 border-start border-danger border-4 h-100">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-danger fw-bold mb-1 text-uppercase" style="font-size: 0.8rem;">Sold Items</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $soldCount }}</h3>
                        </div>
                        <i class="bi bi-cart-check fs-1 text-danger opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-primary bg-opacity-10 border-start border-primary border-4 h-100">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-primary fw-bold mb-1 text-uppercase" style="font-size: 0.8rem;">Total Items</h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalCount }}</h3>
                        </div>
                        <i class="bi bi-boxes fs-1 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Error Message Alert -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" id="inventory-table">
            <div class="card-header bg-white border-bottom p-4">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <select name="category" class="form-select shadow-sm border-0 bg-light">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select shadow-sm border-0 bg-light">
                            <option value="">All Statuses</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary shadow-sm w-100">
                            <i class="bi bi-funnel me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Item Code</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Category</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Status</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Price</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Qty</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Bale</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($items as $item)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-dark">{{ $item->item_code }}</td>
                                <td class="py-3 text-secondary">{{ $item->category->name }}</td>
                                <td class="py-3">
                                    @if(!$item->is_sold)
                                        @if($item->status_id == 1)
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success">{{ $item->status->name }}</span>
                                        @elseif($item->status_id == 2)
                                            <span class="badge bg-info bg-opacity-10 text-info border border-info">{{ $item->status->name }}</span>
                                        @elseif($item->status_id == 3)
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">{{ $item->status->name }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">{{ $item->is_sold ? 'Sold' : '' }}</span>
                                    @endif
                                </td>
                                <td class="py-3 fw-semibold text-dark">₱{{ number_format($item->price, 2) }}</td>
                                <td class="py-3 text-secondary">{{ $item->quantity }}</td>
                                <td class="py-3 text-secondary">{{ $item->bale->bale_number ?? 'N/A' }}</td>
                                <td class="pe-4 py-3 text-end">
                                    <!-- Grouped Actions -->
                                    <div class="btn-group btn-group-sm shadow-sm" role="group">
                                        <a href="{{ route('inventory.show', $item->id) }}" class="btn btn-light border" title="View Details">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-search fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No items found</span>
                                        <small>Adjust your filters or add new stock.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($items->hasPages())
                <div class="card-footer bg-white border-top p-3">
                    {{ $items->withQueryString()->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection