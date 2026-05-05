<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $transaction->transaction_number }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print {
                display: none;
            }

            body {
                margin: 0;
                padding: 0;
            }

            .card {
                border: none;
            }
        }

        .receipt {
            max-width: 350px;
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
            <p class="text-muted small">Daily Sales and Stock-In Management</p>

            <div class="border-top border-bottom my-3 py-3 text-start">
                <p class="mb-1"><strong>Receipt:</strong> {{ $transaction->transaction_number }}</p>
                <p class="mb-1 text-muted small"><strong>Date:</strong>
                    {{ $transaction->created_at->format('M d, Y h:i A') }}</p>
                <p class="mb-0 text-muted small"><strong>Cashier:</strong> {{ $transaction->user->name }}</p>
            </div>

            <table class="table table-sm table-borderless">
                <thead>
                    <tr class="border-bottom">
                        <th class="text-start small">Item</th>
                        <th class="text-end small">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($receiptItems as $item)
                        <tr>
                            <td class="text-start">
                                <span class="fw-bold">{{ $item->item_code }}</span><br>
                                <small class="text-muted">
                                    {{ $item->qty_sold }} x ₱{{ number_format($item->unit_price, 2) }}
                                </small>
                            </td>
                            <td class="text-end align-middle">
                                ₱{{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="border-top border-bottom my-3 py-2">
                <div class="d-flex justify-content-between fw-bold fs-5">
                    <span>TOTAL:</span>
                    <span>₱{{ number_format($transaction->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="text-center mt-3">
                <p class="mb-1 small">Payment:
                    <strong>{{ ucfirst($transaction->paymentMethod->method_name ?? 'Cash') }}</strong>
                </p>
                <p class="mb-0 text-muted small">Thank you for your purchase!</p>
                <p class="small text-muted mt-2" style="font-size: 0.7rem;">Built by Ambos, Joshua</p>
            </div>
        </div>
    </div>
</body>


</html>