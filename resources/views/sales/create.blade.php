@extends('layouts.app')

@section('title', 'New Transaction - DSSM')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">New Transaction</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Select Items</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <input type="text" id="search-item" class="form-control" placeholder="Search items by code...">
                    </div>
                    <div id="items-list" class="row">
                        @forelse($items as $category => $categoryItems)
                        <div class="col-12 mb-3">
                            <h6 class="text-muted border-bottom pb-2">{{ $category }}</h6>
                            <div class="row">
                                @foreach($categoryItems as $item)
                                <div class="col-md-4 mb-2">
                                    <div class="card item-card border" data-item-id="{{ $item->id }}" data-item-price="{{ $item->price }}" data-item-code="{{ $item->item_code }}" style="cursor: pointer;">
                                        <div class="card-body p-2">
                                            <div class="fw-bold">{{ $item->item_code }}</div>
                                            <small class="text-muted">{{ $item->description ?? 'No description' }}</small>
                                            <div class="text-primary fw-bold">₱{{ number_format($item->price, 2) }}</div>
                                            <small class="badge bg-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }}">
                                                {{ $item->status->name }}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <div class="col-12 text-center text-muted py-4">
                            <p>No available items for sale</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Cart</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('sales.store') }}" id="sales-form">
                        @csrf
                        <div id="cart-items" class="mb-3">
                            <p class="text-muted text-center">No items selected</p>
                        </div>

                        <div class="border-top pt-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span class="fw-bold" id="cart-subtotal">₱0.00</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select" required>
                                <option value="cash">Cash</option>
                                <option value="gcash">GCash</option>
                                <option value="card">Card</option>
                                <option value="mixed">Mixed</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes (optional)</label>
                            <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100" id="complete-btn" disabled>
                            Complete Transaction
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let cart = [];

    document.querySelectorAll('.item-card').forEach(card => {
        card.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const itemPrice = parseFloat(this.dataset.itemPrice);
            const itemCode = this.dataset.itemCode;

            const existing = cart.find(c => c.itemId === itemId);
            if (existing) {
                existing.quantity++;
            } else {
                cart.push({
                    itemId: itemId,
                    itemCode: itemCode,
                    price: itemPrice,
                    quantity: 1
                });
            }
            updateCart();
            this.classList.add('border-primary');
        });
    });

    function updateCart() {
        const container = document.getElementById('cart-items');
        let subtotal = 0;

        if (cart.length === 0) {
            container.innerHTML = '<p class="text-muted text-center">No items selected</p>';
            document.getElementById('complete-btn').disabled = true;
        } else {
            container.innerHTML = '';
            cart.forEach((item, index) => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;

                container.innerHTML += `
                    <div class="d-flex justify-content-between align-items-center mb-2 border-bottom pb-2">
                        <div>
                            <strong>${item.itemCode}</strong><br>
                            <small>₱${item.price.toFixed(2)} x ${item.quantity}</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="me-3">₱${itemTotal.toFixed(2)}</span>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeFromCart(${index})">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <input type="hidden" name="items[${index}][item_id]" value="${item.itemId}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    </div>
                `;
            });
            document.getElementById('complete-btn').disabled = false;
        }

        document.getElementById('cart-subtotal').textContent = '₱' + subtotal.toFixed(2);
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCart();
    }

    document.getElementById('search-item').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.item-card').forEach(card => {
            const code = card.dataset.itemCode.toLowerCase();
            card.style.display = code.includes(query) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection