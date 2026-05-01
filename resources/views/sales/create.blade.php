@extends('layouts.app')

@section('title', 'New Transaction - DSSM')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert">
            <div class="d-flex align-items-center mb-2">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>
                <strong class="mb-0">Please fix the following errors:</strong>
            </div>
            <ul class="mb-0 text-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">New Transaction</h2>
        </div>

        <div class="row g-4">
            <!-- Items Selection Column -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-grid me-2 text-primary"></i>Select Items</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <div class="input-group shadow-sm rounded-3">
                                <span class="input-group-text bg-white border-end-0 text-muted">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" id="search-item" class="form-control border-start-0 ps-0" placeholder="Search items by code...">
                            </div>
                        </div>
                        <div id="items-list" class="row g-3">
                            @forelse($items as $category => $categoryItems)
                                <div class="col-12 mb-2">
                                    <h6 class="text-uppercase text-muted fw-bold border-bottom pb-2 mb-3" style="font-size: 0.85rem;">{{ $category }}</h6>
                                    <div class="row g-3">
                                        @foreach($categoryItems as $item)
                                            <div class="col-md-4">
                                                <div class="card item-card h-100 border shadow-sm rounded-3" data-item-id="{{ $item->id }}"
                                                    data-item-price="{{ $item->price }}" data-item-code="{{ $item->item_code }}"
                                                    style="cursor: pointer; transition: transform 0.2s, border-color 0.2s;">
                                                    <div class="card-body p-3 d-flex flex-column">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div class="fw-bold text-dark">{{ $item->item_code }}</div>
                                                            <small class="badge bg-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }} bg-opacity-10 text-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }} border border-{{ $item->status->name == 'Available' ? 'success' : 'secondary' }}">
                                                                {{ $item->status->name }}
                                                            </small>
                                                        </div>
                                                        <small class="text-secondary flex-grow-1 mb-2 line-clamp-2" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                            {{ $item->description ?? 'No description' }}
                                                        </small>
                                                        <div class="text-primary fw-bold fs-5">₱{{ number_format($item->price, 2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-3 opacity-50"></i>
                                    <p class="fw-medium">No available items for sale</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart Column -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 h-100 d-flex flex-column sticky-top" style="top: 2rem; z-index: 10;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-cart me-2 text-primary"></i>Cart</h5>
                    </div>
                    <div class="card-body p-4 d-flex flex-column flex-grow-1">
                        <form method="POST" action="{{ route('sales.store') }}" id="sales-form" class="d-flex flex-column h-100">
                            @csrf
                            
                            <!-- Cart Items Area -->
                            <div id="cart-items" class="mb-4 flex-grow-1 overflow-auto" style="max-height: 40vh;">
                                <div class="text-center py-5">
                                    <i class="bi bi-cart-x fs-1 text-muted opacity-50 mb-2"></i>
                                    <p class="text-muted mb-0">No items selected</p>
                                </div>
                            </div>

                            <!-- Footer/Checkout Area -->
                            <div class="mt-auto">
                                <div class="border-top pt-3 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-secondary fw-semibold text-uppercase" style="font-size: 0.9rem;">Subtotal</span>
                                        <span class="fw-bold fs-4 text-dark" id="cart-subtotal">₱0.00</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="method_id" class="form-label fw-semibold text-secondary">Payment Method</label>
                                    <select name="method_id" id="method_id" class="form-select shadow-sm" required>
                                        <option value="">Select Payment Method...</option>
                                        @foreach($paymentMethods as $method)
                                            <option value="{{ $method->id }}">{{ $method->method_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="notes" class="form-label fw-semibold text-secondary">Notes <span class="fw-normal text-muted">(Optional)</span></label>
                                    <textarea name="notes" id="notes" class="form-control shadow-sm" rows="2" placeholder="Add transaction notes here..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 shadow-sm py-2 fw-bold" id="complete-btn" disabled>
                                    <i class="bi bi-check-circle me-2"></i>Complete Transaction
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .item-card:hover {
                transform: translateY(-2px);
                border-color: var(--bs-primary) !important;
            }
            .item-card.border-primary {
                background-color: rgba(13, 110, 253, 0.03);
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            let cart = [];

            document.querySelectorAll('.item-card').forEach(card => {
                card.addEventListener('click', function () {
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
                    container.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x fs-1 text-muted opacity-50 mb-2"></i>
                            <p class="text-muted mb-0">No items selected</p>
                        </div>`;
                    document.getElementById('complete-btn').disabled = true;
                } else {
                    container.innerHTML = '';
                    cart.forEach((item, index) => {
                        const itemTotal = item.price * item.quantity;
                        subtotal += itemTotal;

                        container.innerHTML += `
                            <div class="d-flex justify-content-between align-items-center mb-2 bg-light p-2 rounded-3 border">
                                <div>
                                    <strong class="text-dark d-block">${item.itemCode}</strong>
                                    <small class="text-secondary">₱${item.price.toFixed(2)} <span class="text-muted">x</span> ${item.quantity}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="me-3 fw-bold text-dark">₱${itemTotal.toFixed(2)}</span>
                                    <button type="button" class="btn btn-outline-danger btn-sm shadow-sm" onclick="removeFromCart(${index})" title="Remove item">
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

            document.getElementById('search-item').addEventListener('input', function () {
                const query = this.value.toLowerCase();
                document.querySelectorAll('.item-card').forEach(card => {
                    const code = card.dataset.itemCode.toLowerCase();
                    card.style.display = code.includes(query) ? '' : 'none';
                });
            });
        </script>
    @endpush
@endsection