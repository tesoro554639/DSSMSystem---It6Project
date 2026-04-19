@extends('layouts.app')

@section('title', 'Sales - DSSM')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sales Management</h2>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>New Transaction
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Transaction #</th>
                        <th>Date</th>
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
                        <td>
                            <a href="{{ route('sales.show', $txn->id) }}">{{ $txn->transaction_number }}</a>
                        </td>
                        <td>{{ $txn->created_at->format('M d, Y h:i A') }}</td>
                        <td>{{ $txn->user->name }}</td>
                        <td>{{ $txn->items_count ?? $txn->items->count() }}</td>
                        <td>
                            <span class="badge bg-{{ $txn->payment_method == 'cash' ? 'success' : ($txn->payment_method == 'gcash' ? 'info' : 'warning') }}">
                                {{ ucfirst($txn->payment_method) }}
                            </span>
                        </td>
                        <td class="fw-bold">₱{{ number_format($txn->total_amount, 2) }}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('sales.show', $txn->id) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('sales.receipt', $txn->id) }}" class="btn btn-outline-secondary" target="_blank">
                                    <i class="bi bi-printer"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">No transactions found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $transactions->links() }}
        </div>
    </div>
</div>
@endsection