@extends('layouts.app')

@section('title', 'Transaction Details - DSSM')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Transaction: {{ $transaction->transaction_number }}</h2>
            <a href="{{ route('sales.index') }}" class="text-decoration-none">&larr; Back to Sales</a>
        </div>
        <a href="{{ route('sales.receipt', $transaction->id) }}" class="btn btn-primary" target="_blank">
            <i class="bi bi-printer me-2"></i>Print Receipt
        </a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Transaction Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Transaction Number</td>
                            <td class="fw-bold">{{ $transaction->transaction_number }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Date</td>
                            <td>{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Cashier</td>
                            <td>{{ $transaction->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Payment Method</td>
                            <td>
                                <span class="badge bg-{{ $transaction->payment_method == 'cash' ? 'success' : ($transaction->payment_method == 'gcash' ? 'info' : 'warning') }}">
                                    {{ ucfirst($transaction->payment_method) }}
                                </span>
                            </td>
                        </tr>
                        @if($transaction->notes)
                        <tr>
                            <td class="text-muted">Notes</td>
                            <td>{{ $transaction->notes }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Payment Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Subtotal</td>
                            <td>₱{{ number_format($transaction->subtotal, 2) }}</td>
                        </tr>
                        <tr class="border-top">
                            <td class="fw-bold">Total</td>
                            <td class="fw-bold text-primary">₱{{ number_format($transaction->total_amount, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Items Sold</h5>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Item Code</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Unit Price</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaction->items as $item)
                    <tr>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>
                            <span class="badge bg-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }}">
                                {{ $item->status->name }}
                            </span>
                        </td>
                        <td>₱{{ number_format($item->pivot->unit_price, 2) }}</td>
                        <td>{{ $item->pivot->quantity }}</td>
                        <td class="fw-bold">₱{{ number_format($item->pivot->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="5" class="text-end fw-bold">Total:</td>
                        <td class="fw-bold">₱{{ number_format($transaction->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection