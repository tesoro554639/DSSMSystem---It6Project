@extends('layouts.app')

@section('title', 'Sales - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Sales Management</h2>
            <a href="{{ route('sales.create') }}" class="btn btn-primary shadow-sm rounded-3 px-3">
                <i class="bi bi-plus-lg me-2"></i>New Transaction
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Transaction #</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Date</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Cashier</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Items</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Payment</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Total</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($transactions as $txn)
                            <tr>
                                <td class="ps-4 py-3">
                                    <a href="{{ route('sales.show', $txn->id) }}"
                                        class="text-decoration-none fw-bold text-primary">
                                        {{ $txn->transaction_number }}
                                    </a>
                                </td>
                                <td class="py-3 text-secondary">{{ $txn->created_at->format('M d, Y h:i A') }}</td>
                                <td class="py-3 text-dark fw-medium">{{ $txn->user->name }}</td>
                                <td class="py-3 text-secondary">{{ $txn->items_count ?? $txn->items->count() }}</td>
                                <td class="py-3">
                                    @php
                                        $methodName = strtolower($txn->paymentMethod->method_name);
                                        // Case-insensitive check for common payment types in Davao
                                        $badgeColor = $methodName == 'cash' ? 'success' : (str_contains($methodName, 'gcash') ? 'info' : 'warning');
                                    @endphp
                                    <span
                                        class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} border border-{{ $badgeColor }}">
                                        {{ $txn->paymentMethod->method_name }}
                                    </span>
                                </td>
                                <td class="py-3 fw-bold text-dark">₱{{ number_format($txn->total_amount, 2) }}</td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group btn-group-sm shadow-sm" role="group">
                                        <a href="{{ route('sales.show', $txn->id) }}" class="btn btn-light border"
                                            title="View Details">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>
                                        <a href="{{ route('sales.receipt', $txn->id) }}" class="btn btn-light border"
                                            target="_blank" title="Print Receipt">
                                            <i class="bi bi-printer text-secondary"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-receipt fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No transactions found</span>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($transactions->hasPages())
                <div class="card-footer bg-white border-top p-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection