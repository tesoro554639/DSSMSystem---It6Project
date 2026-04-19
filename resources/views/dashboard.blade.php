@extends('layouts.app')

@section('title', 'Dashboard - DSSM')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Dashboard</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Today's Sales</h6>
                            <h3 class="mb-0">₱{{ number_format($dailySales, 2) }}</h3>
                        </div>
                        <div class="fs-1 text-primary">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Transactions</h6>
                            <h3 class="mb-0">{{ $dailyTransactions }}</h3>
                        </div>
                        <div class="fs-1 text-success">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Items Sold Today</h6>
                            <h3 class="mb-0">{{ $itemsSoldToday }}</h3>
                        </div>
                        <div class="fs-1 text-info">
                            <i class="bi bi-bag-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Available Items</h6>
                            <h3 class="mb-0">{{ $availableItems }}</h3>
                        </div>
                        <div class="fs-1 text-warning">
                            <i class="bi bi-box"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Inventory by Category</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Total Items</th>
                                <th>Available</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categoryInventory as $cat)
                            <tr>
                                <td>{{ $cat->category }}</td>
                                <td>{{ $cat->count }}</td>
                                <td>{{ $cat->available }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">No inventory data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Inventory Overview</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Items</span>
                            <span class="fw-bold">{{ $totalInventory }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Available</span>
                            <span class="fw-bold text-success">{{ $availableItems }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: {{ $totalInventory > 0 ? ($availableItems / $totalInventory * 100) : 0 }}%"></div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Sold</span>
                            <span class="fw-bold text-danger">{{ $soldItems }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-danger" style="width: {{ $totalInventory > 0 ? ($soldItems / $totalInventory * 100) : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Transactions</h5>
                    <a href="{{ route('sales.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($recentTransactions as $txn)
                            <tr>
                                <td>
                                    <a href="{{ route('sales.show', $txn->id) }}">{{ $txn->transaction_number }}</a>
                                </td>
                                <td>{{ $txn->user->name }}</td>
                                <td>₱{{ number_format($txn->total_amount, 2) }}</td>
                                <td>{{ $txn->created_at->format('M d, h:i A') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No recent transactions</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bales</h5>
                    <a href="{{ route('stock-in.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <tbody>
                            @forelse($recentBales as $bale)
                            <tr>
                                <td>
                                    <a href="{{ route('stock-in.show', $bale->id) }}">{{ $bale->bale_number }}</a>
                                </td>
                                <td>{{ $bale->supplier->name }}</td>
                                <td>{{ $bale->total_items }} items</td>
                                <td>₱{{ number_format($bale->purchase_price, 2) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No recent bales</td>
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