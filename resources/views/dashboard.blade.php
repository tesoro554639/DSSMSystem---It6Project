@extends('layouts.app')

@section('title', 'Dashboard - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Dashboard</h2>

        <!-- Top Stat Cards -->
        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-primary border-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Today's
                                    Sales</h6>
                                <h3 class="mb-0 fw-bold text-dark">₱{{ number_format($dailySales, 2) }}</h3>
                            </div>
                            <div class="fs-1 text-primary opacity-75">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-success border-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">
                                    Transactions</h6>
                                <h3 class="mb-0 fw-bold text-dark">{{ $dailyTransactions }}</h3>
                            </div>
                            <div class="fs-1 text-success opacity-75">
                                <i class="bi bi-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-info border-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Items Sold
                                    Today</h6>
                                <h3 class="mb-0 fw-bold text-dark">{{ $itemsSoldToday }}</h3>
                            </div>
                            <div class="fs-1 text-info opacity-75">
                                <i class="bi bi-bag-check"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-warning border-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Available
                                    Items</h6>
                                <h3 class="mb-0 fw-bold text-dark">{{ $availableItems }}</h3>
                            </div>
                            <div class="fs-1 text-warning opacity-75">
                                <i class="bi bi-box"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Inventory Sections -->
        <div class="row mb-4 g-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Inventory by Category</h5>
                    </div>
                    <div class="card-body p-0 d-flex flex-column">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Category</th>
                                    <th class="text-uppercase text-muted small fw-semibold py-3">Total Items</th>
                                    <th class="text-uppercase text-muted small fw-semibold py-3">Available</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @forelse($categoryInventory as $cat)
                                    <tr>
                                        <td class="ps-4 py-3 fw-bold text-dark">{{ $cat->category }}</td>
                                        <td class="py-3 text-secondary">{{ $cat->count }}</td>
                                        <td class="py-3 text-success fw-semibold">{{ $cat->available }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
                                            <i class="bi bi-inbox fs-4 d-block mb-2 opacity-50"></i>
                                            No inventory data
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Inventory Overview</h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-center">
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary fw-semibold">Total Items</span>
                                <span class="fw-bold text-dark">{{ $totalInventory }}</span>
                            </div>
                            <div class="progress rounded-pill shadow-sm" style="height: 10px;">
                                <div class="progress-bar bg-primary" style="width: 100%"></div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary fw-semibold">Available</span>
                                <span class="fw-bold text-success">{{ $availableItems }}</span>
                            </div>
                            <div class="progress rounded-pill shadow-sm" style="height: 10px;">
                                <div class="progress-bar bg-success"
                                    style="width: {{ $totalInventory > 0 ? ($availableItems / $totalInventory * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="mb-0">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary fw-semibold">Sold</span>
                                <span class="fw-bold text-danger">{{ $soldItems }}</span>
                            </div>
                            <div class="progress rounded-pill shadow-sm" style="height: 10px;">
                                <div class="progress-bar bg-danger"
                                    style="width: {{ $totalInventory > 0 ? ($soldItems / $totalInventory * 100) : 0 }}%">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Recent Transactions</h5>
                        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-light border shadow-sm">View All</a>
                    </div>
                    <div class="card-body p-0 flex-grow-1">
                        <table class="table table-hover align-middle mb-0">
                            <tbody class="border-top-0">
                                @forelse($recentTransactions as $txn)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <a href="{{ route('sales.show', $txn->id) }}"
                                                class="text-decoration-none fw-bold text-primary">
                                                {{ $txn->transaction_number }}
                                            </a>
                                        </td>
                                        <td class="py-3 text-secondary">{{ $txn->user->name }}</td>
                                        <td class="py-3 fw-semibold text-success">₱{{ number_format($txn->total_amount, 2) }}
                                        </td>
                                        <td class="pe-4 py-3 text-end text-muted small">
                                            {{ $txn->created_at->format('M d, h:i A') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="bi bi-receipt fs-4 d-block mb-2 opacity-50"></i>
                                            No recent transactions
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Recent Bales</h5>
                        <a href="{{ route('stock-in.index') }}" class="btn btn-sm btn-light border shadow-sm">View All</a>
                    </div>
                    <div class="card-body p-0 flex-grow-1">
                        <table class="table table-hover align-middle mb-0">
                            <tbody class="border-top-0">
                                @forelse($recentBales as $bale)
                                    <tr>
                                        <td class="ps-4 py-3">
                                            <a href="{{ route('stock-in.show', $bale->id) }}"
                                                class="text-decoration-none fw-bold text-primary">
                                                {{ $bale->bale_number }}
                                            </a>
                                        </td>
                                        <td class="py-3 text-secondary">{{ $bale->supplier->name }}</td>
                                        <td class="py-3 text-secondary"><span
                                                class="badge bg-light text-dark border">{{ $bale->total_items }} items</span>
                                        </td>
                                        <td class="pe-4 py-3 text-end fw-semibold text-dark">
                                            ₱{{ number_format($bale->purchase_price, 2) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">
                                            <i class="bi bi-box-seam fs-4 d-block mb-2 opacity-50"></i>
                                            No recent bales
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection