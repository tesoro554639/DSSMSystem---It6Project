@extends('layouts.app')

@section('title', 'Daily Sales - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Daily Sales Report</h2>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="GET" class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="date" class="form-label fw-semibold text-secondary mb-0">Select Date:</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" name="date" id="date" class="form-control shadow-sm border-0 bg-light"
                                    value="{{ $date }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary shadow-sm px-4">
                                    <i class="bi bi-calendar-check me-2"></i>View Report
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-primary border-4 h-100">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Total Sales
                            </h6>
                            <h3 class="mb-0 fw-bold text-dark">₱{{ number_format($totalSales, 2) }}</h3>
                        </div>
                        <i class="bi bi-cash-coin fs-1 text-primary opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-success border-4 h-100">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Transactions
                            </h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalTransactions }}</h3>
                        </div>
                        <i class="bi bi-receipt fs-1 text-success opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-info border-4 h-100">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Items Sold
                            </h6>
                            <h3 class="mb-0 fw-bold text-dark">{{ $totalItemsSold }}</h3>
                        </div>
                        <i class="bi bi-bag-check fs-1 text-info opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm rounded-3 border-start border-warning border-4 h-100">
                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted fw-semibold mb-2 text-uppercase" style="font-size: 0.8rem;">Avg. Sale</h6>
                            <h3 class="mb-0 fw-bold text-dark">
                                ₱{{ $totalTransactions > 0 ? number_format($totalSales / $totalTransactions, 2) : '0.00' }}
                            </h3>
                        </div>
                        <i class="bi bi-calculator fs-1 text-warning opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4 g-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Payment Method Breakdown</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($paymentBreakdown->count() > 0)
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Method</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach($paymentBreakdown as $method => $amount)
                                        <tr>
                                            <td class="ps-4 py-3 fw-medium text-dark">{{ ucfirst($method) }}</td>
                                            <td class="pe-4 py-3 text-end fw-bold text-success">₱{{ number_format($amount, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-wallet2 fs-1 d-block mb-2 opacity-50"></i>
                                <p class="text-muted mb-0">No transaction data available</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Views</h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column gap-2 justify-content-center">
                        <a href="{{ route('reports.inventory-status') }}"
                            class="btn btn-light border shadow-sm py-3 fw-semibold">
                            <i class="bi bi-clipboard-data text-primary me-2"></i>Inventory Status
                        </a>
                        {{-- <a href="{{ route('sales.index') }}" class="btn btn-light border shadow-sm py-3 fw-semibold">
                            <i class="bi bi-receipt-cutoff text-success me-2"></i>All Transactions
                        </a> --}}
                        <a href="{{ route('reports.revenue') }}" class="btn btn-light border shadow-sm py-3 fw-semibold">
                            <i class="bi bi-graph-up-arrow text-info me-2"></i>Revenue Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">Transactions ({{ \Carbon\Carbon::parse($date)->format('M d, Y') }})</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Transaction #</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Time</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Cashier</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Items</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Payment</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Total</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($transactions as $txn)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-primary">{{ $txn->transaction_number }}</td>
                                <td class="py-3 text-secondary">{{ $txn->created_at->format('h:i A') }}</td>
                                <td class="py-3 text-dark fw-medium">{{ $txn->user->name }}</td>
                                <td class="py-3 text-secondary text-center">{{ $txn->items->count() }}</td>
                                <td class="py-3">
                                    @php
                                        $method = strtolower($txn->paymentMethod->method_name ?? '');
                                        $badgeColor = match ($method) {
                                            'cash' => 'success',
                                            'gcash' => 'info',
                                            'maya', 'paymaya' => 'primary',
                                            default => 'warning',
                                        };
                                    @endphp
                                    <span
                                        class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} border border-{{ $badgeColor }} rounded-pill px-3">
                                        {{ ucfirst($txn->paymentMethod->method_name ?? 'Unknown') }}
                                    </span>
                                </td>
                                <td class="py-3 fw-bold text-dark text-end pe-4">₱{{ number_format($txn->total_amount, 2) }}
                                </td>
                                <td class="py-3 text-center">
                                    <a href="{{ route('sales.show', $txn->id) }}" class="btn btn-sm btn-light border shadow-sm"
                                        title="View Details">
                                        <i class="bi bi-eye text-primary"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-receipt fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No transactions for this date</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection