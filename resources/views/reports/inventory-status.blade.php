@extends('layouts.app')

@section('title', 'Inventory Status - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Inventory Status Report</h2>

        <!-- Stat Cards (Now powered by View Aggregates) -->
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-primary border-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Total Items</h6>
                        <h3 class="mb-0 fw-bold text-dark">{{ number_format($overallStats['total']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-success border-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Available</h6>
                        <h3 class="mb-0 fw-bold text-success">{{ number_format($overallStats['available']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-danger border-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Sold</h6>
                        <h3 class="mb-0 fw-bold text-danger">{{ number_format($overallStats['sold']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-warning border-4 h-100">
                    <div class="card-body p-4">
                        <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Stock Value</h6>
                        <h3 class="mb-0 fw-bold text-dark">₱{{ number_format($overallStats['total_value'], 2) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Category Summary (Using CategoryInventory View Model) -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Category Summary</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Category</th>
                                    <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Total Items</th>
                                    <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Available</th>
                                    <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Sold</th>
                                    <th class="text-uppercase text-muted small fw-semibold py-3 text-end">Stock Value</th>
                                    <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-center">Availability</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @forelse($categorySummary as $cat)
                                    <tr>
                                        <td class="ps-4 py-3 fw-bold text-dark">{{ $cat->category_name }}</td>
                                        <td class="py-3 text-center text-secondary">{{ $cat->total_items }}</td>
                                        <td class="py-3 text-center fw-medium text-success">{{ $cat->available }}</td>
                                        <td class="py-3 text-center fw-medium text-danger">{{ $cat->sold }}</td>
                                        <td class="py-3 text-end fw-semibold text-dark">₱{{ number_format($cat->potential_revenue, 2) }}</td>
                                        <td class="pe-4 py-3">
                                            @php $pct = $cat->total_items > 0 ? ($cat->available / $cat->total_items * 100) : 0 @endphp
                                            <div class="progress rounded-pill shadow-sm" style="height: 18px; width: 120px; margin: 0 auto;">
                                                <div class="progress-bar bg-{{ $pct < 20 ? 'danger' : ($pct < 50 ? 'warning' : 'success') }}" style="width: {{ $pct }}%">
                                                    <span style="font-size: 0.7rem; font-weight: bold;">{{ number_format($pct, 0) }}%</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x fs-1 d-block mb-2 opacity-50"></i>
                                            No category data available
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Item Details Table -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden" id="status-table">
            <div class="card-header bg-white border-bottom py-3 p-4 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark">Item Details</h5>
                <form method="GET" class="row g-2">
                    <div class="col-auto">
                        <select name="category" class="form-select shadow-sm border-0 bg-light">
                            <option value="">All Categories</option>
                            @foreach($categorySummary as $cat)
                                <option value="{{ $cat->category_id }}" {{ request('category') == $cat->category_id ? 'selected' : '' }}>
                                    {{ $cat->category_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary shadow-sm px-3">
                            <i class="bi bi-funnel me-1"></i>Filter
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
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Status</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Price</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Bale #</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 pe-4">Supplier</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($items as $item)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-primary">{{ $item->item_code }}</td>
                                <td class="py-3 text-secondary">{{ $item->category->name }}</td>
                                <td class="py-3 text-center">
                                    <span class="badge bg-{{ $item->is_sold ? 'secondary' : 'success' }} bg-opacity-10 text-{{ $item->is_sold ? 'secondary' : 'success' }} border border-{{ $item->is_sold ? 'secondary' : 'success' }} rounded-pill px-3">
                                        {{ $item->is_sold ? 'Sold' : 'Available' }}
                                    </span>
                                </td>
                                <td class="py-3 fw-semibold text-dark">₱{{ number_format($item->price, 2) }}</td>
                                <td class="py-3 text-secondary">{{ $item->bale->bale_number ?? 'N/A' }}</td>
                                <td class="pe-4 py-3 text-secondary">{{ $item->bale->supplier->name ?? 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-search fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No items found</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($items->hasPages())
                <div class="card-footer bg-white border-top p-3">
                    {{ $items->appends(request()->query())->fragment('status-table')->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection