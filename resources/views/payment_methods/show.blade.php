@extends('layouts.app')

@section('title', 'Payment Method Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Payment Method: {{ $paymentMethod->method_name }}</h2>
                <a href="{{ route('payment_methods.index') }}" class="text-decoration-none text-secondary hover-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Payment Methods
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card h-100 d-flex flex-column border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Method Information</h5>
                    </div>
                    <div class="card-body flex-grow-1 p-4">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0 py-2">Method Name</td>
                                <td class="fw-bold text-end pe-0 py-2">{{ $paymentMethod->method_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Description</td>
                                <td class="text-end pe-0 py-2">
                                    {{ $paymentMethod->description ?? 'No description provided' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Added On</td>
                                <td class="text-end pe-0 py-2">
                                    {{ $paymentMethod->created_at ? $paymentMethod->created_at->format('M d, Y') : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Total Transactions</td>
                                <td class="text-end pe-0 py-2 fw-bold text-primary">
                                    {{ $paymentMethod->transactions->count() }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card h-100 d-flex flex-column border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Recent Transactions using {{ $paymentMethod->method_name }}</h5>
                    </div>
                    <div class="card-body p-0 flex-grow-1 overflow-auto">
                        @if($paymentMethod->transactions->count() > 0)
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Transaction #</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Date & Time</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Cashier</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Amount</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    {{-- Order by newest first --}}
                                    @foreach($paymentMethod->transactions->sortByDesc('created_at') as $txn)
                                        <tr>
                                            <td class="fw-bold ps-4 py-3">{{ $txn->transaction_number }}</td>
                                            <td class="py-3 text-secondary">{{ $txn->created_at->format('M d, Y h:i A') }}</td>
                                            <td class="py-3 text-secondary">{{ $txn->user->name ?? 'Unknown' }}</td>
                                            <td class="py-3 fw-bold text-success">₱{{ number_format($txn->total_amount, 2) }}</td>
                                            <td class="pe-4 py-3 text-end">
                                                <a href="{{ route('sales.show', $txn->id) }}"
                                                    class="btn btn-sm btn-light border shadow-sm text-primary">
                                                    View Receipt
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center">
                                    <i class="bi bi-receipt fs-1 mb-2 opacity-50"></i>
                                    <span class="fw-medium">No transactions recorded yet</span>
                                    <small>Sales processed with this payment method will appear here.</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection