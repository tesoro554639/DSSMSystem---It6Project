@extends('layouts.app')

@section('title', 'Daily Sales - DSSM')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Daily Sales Report</h2>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" class="row g-3 align-items-center">
                        <div class="col-auto">
                            <label for="date" class="form-label">Select Date</label>
                        </div>
                        <div class="col-auto">
                            <input type="date" name="date" id="date" class="form-control" value="{{ $date }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">View Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted">Total Sales</h6>
                    <h3 class="mb-0">₱{{ number_format($totalSales, 2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted">Transactions</h6>
                    <h3 class="mb-0">{{ $totalTransactions }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body">
                    <h6 class="text-muted">Items Sold</h6>
                    <h3 class="mb-0">{{ $totalItemsSold }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Avg. per Transaction</h6>
                    <h3 class="mb-0">₱{{ $totalTransactions > 0 ? number_format($totalSales / $totalTransactions, 2) : '0.00' }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Payment Method Breakdown</h5>
                </div>
                <div class="card-body">
                    @if($paymentBreakdown->count() > 0)
                    <table class="table">
                        <tr>
                            <th>Method</th>
                            <th class="text-end">Amount</th>
                        </tr>
                        @foreach($paymentBreakdown as $method => $amount)
                        <tr>
                            <td>{{ ucfirst($method) }}</td>
                            <td class="text-end">₱{{ number_format($amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </table>
                    @else
                    <p class="text-muted text-center">No transactions for this date</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Links</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('reports.inventory-status') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-clipboard-data me-2"></i>Inventory Status
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Transactions</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Transaction #</th>
                        <th>Time</th>
                        <th>Cashier</th>
                        <th>Items</th>
                        <th>Payment</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                    <tr>
                        <td>{{ $txn->transaction_number }}</td>
                        <td>{{ $txn->created_at->format('h:i A') }}</td>
                        <td>{{ $txn->user->name }}</td>
                        <td>{{ $txn->items->count() }}</td>
                        <td>
                            <span class="badge bg-{{ $txn->payment_method == 'cash' ? 'success' : ($txn->payment_method == 'gcash' ? 'info' : 'warning') }}">
                                {{ ucfirst($txn->payment_method) }}
                            </span>
                        </td>
                        <td class="fw-bold">₱{{ number_format($txn->total_amount, 2) }}</td>
                        <td>
                            <a href="{{ route('sales.show', $txn->id) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No transactions for this date</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection