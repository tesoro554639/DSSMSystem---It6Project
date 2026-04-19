<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $transaction->transaction_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            body { margin: 0; padding: 0; }
            .card { border: none; }
        }
        .receipt {
            max-width: 300px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="no-print text-end p-3">
        <button class="btn btn-primary" onclick="window.print()">
            <i class="bi bi-printer me-2"></i>Print
        </button>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Close</a>
    </div>

    <div class="container receipt">
        <div class="text-center border p-4">
            <h4 class="fw-bold">DSSM</h4>
            <p class="text-muted">Daily Sales and Stock-In Management</p>

            <div class="border-top border-bottom my-3 py-3">
                <p class="mb-1"><strong>Receipt: {{ $transaction->transaction_number }}</strong></p>
                <p class="mb-0 text-muted">{{ $transaction->created_at->format('M d, Y h:i A') }}</p>
                <p class="mb-0 text-muted">Cashier: {{ $transaction->user->name }}</p>
            </div>

            <table class="table table-sm">
                @foreach($transaction->items as $item)
                <tr>
                    <td>
                        {{ $item->item_code }}<br>
                        <small class="text-muted">{{ $item->pivot->quantity }} x ₱{{ number_format($item->pivot->unit_price, 2) }}</small>
                    </td>
                    <td class="text-end">₱{{ number_format($item->pivot->subtotal, 2) }}</td>
                </tr>
                @endforeach
            </table>

            <div class="border-top border-bottom my-3 py-3">
                <div class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span>₱{{ number_format($transaction->subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                    <span>TOTAL:</span>
                    <span>₱{{ number_format($transaction->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="text-center">
                <p class="mb-1">Payment: {{ ucfirst($transaction->payment_method) }}</p>
                <p class="mb-0 text-muted">Thank you for your purchase!</p>
            </div>
        </div>
    </div>
</body>
</html>