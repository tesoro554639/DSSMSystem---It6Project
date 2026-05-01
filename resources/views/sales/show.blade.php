@extends('layouts.app')

@section('title', 'Transaction Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Transaction: {{ $transaction->transaction_number }}</h2>
                <a href="{{ route('sales.index') }}" class="text-decoration-none text-secondary hover-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Sales
                </a>
            </div>
            <a href="{{ route('sales.receipt', ['transaction' => $transaction->id]) }}" class="btn btn-primary shadow-sm rounded-3 px-3" target="_blank">
                <i class="bi bi-printer me-2"></i>Print Receipt
            </a>
        </div>

        <div class="row mb-4 g-4">
            <!-- Details Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Transaction Details</h5>
                    </div>
                    <div class="card-body p-4 flex-grow-1">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0 py-2">Transaction Number</td>
                                <td class="fw-bold text-end pe-0 py-2 text-dark">{{ $transaction->transaction_number }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Date</td>
                                <td class="text-end pe-0 py-2 text-secondary">
                                    {{ $transaction->created_at ? $transaction->created_at->format('M d, Y h:i A') : 'N/A' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Cashier</td>
                                <td class="text-end pe-0 py-2 text-dark fw-medium">{{ $transaction->user->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Payment Method</td>
                                <td class="text-end pe-0 py-2">
                                    @php
                                        $methodName = strtolower($transaction->paymentMethod->method_name);
                                        $badgeColor = $methodName == 'cash' ? 'success' : ($methodName == 'gcash' ? 'info' : 'warning');
                                    @endphp
                                    <span class="badge bg-{{ $badgeColor }} bg-opacity-10 text-{{ $badgeColor }} border border-{{ $badgeColor }}">
                                        {{ ucfirst($transaction->paymentMethod->method_name) }}
                                    </span>
                                </td>
                            </tr>
                            @if($transaction->notes)
                                <tr>
                                    <td class="text-muted ps-0 py-2">Notes</td>
                                    <td class="text-end pe-0 py-2 text-secondary fst-italic">{{ $transaction->notes }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>

            <!-- Payment Summary Card -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Payment Summary</h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column justify-content-center flex-grow-1">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-secondary fw-medium ps-0 py-3 fs-5">Subtotal</td>
                                <td class="text-end pe-0 py-3 text-dark fs-5">₱{{ number_format($transaction->subtotal, 2) }}</td>
                            </tr>
                            <tr class="border-top">
                                <td class="fw-bold text-dark ps-0 py-3 fs-4">Total</td>
                                <td class="fw-bold text-primary text-end pe-0 py-3 fs-3">₱{{ number_format($transaction->total_amount, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">Items Sold</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Item Code</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Category</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Status</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-end">Unit Price</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 text-center">Qty</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @foreach($transaction->items as $item)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-dark">{{ $item->item_code }}</td>
                                <td class="py-3 text-secondary">{{ $item->category->name }}</td>
                                <td class="py-3">
                                    <span class="badge bg-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }} border border-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }}">
                                        {{ $item->status->name }}
                                    </span>
                                </td>
                                <td class="py-3 text-secondary text-end">₱{{ number_format($item->pivot->unit_price, 2) }}</td>
                                <td class="py-3 text-secondary text-center">{{ $item->pivot->quantity }}</td>
                                <td class="pe-4 py-3 fw-bold text-dark text-end">₱{{ number_format($item->pivot->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-light border-top">
                        <tr>
                            <td colspan="5" class="text-end fw-bold text-uppercase text-secondary py-3">Grand Total:</td>
                            <td class="fw-bold text-primary fs-5 text-end pe-4 py-3">₱{{ number_format($transaction->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection