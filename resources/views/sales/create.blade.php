@extends('layouts.app')

@section('title', 'New Transaction - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">New Transaction</h2>
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Select Items</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-4"><input type="text" id="search-item" class="form-control shadow-sm"
                                placeholder="Search by item code..."></div>
                        <div id="items-list">
                            @foreach($items as $category => $categoryItems)
                                <h6 class="text-uppercase text-muted fw-bold border-bottom pb-2 mb-3">{{ $category }}</h6>
                                <div class="row g-3 mb-4">
                                    @foreach($categoryItems as $item)
                                        <div class="col-md-4">
                                            <div class="card item-card border shadow-sm rounded-3 p-3"
                                                data-item-id="{{ $item->id }}" data-item-price="{{ $item->price }}"
                                                data-item-code="{{ $item->item_code }}" style="cursor: pointer;">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <strong>{{ $item->item_code }}</strong><span
                                                        class="badge bg-success bg-opacity-10 text-success border border-success">Available</span>
                                                </div>
                                                <small class="text-muted d-block mb-2 line-clamp-1">{{ $item->description }}</small>
                                                <div class="text-primary fw-bold">₱{{ number_format($item->price, 2) }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 sticky-top" style="top: 2rem;">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Cart</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('sales.store') }}" id="sales-form">
                            @csrf
                            <div id="cart-items" class="mb-4 overflow-auto" style="max-height: 40vh;">
                                <p class="text-muted text-center py-4">No items selected</p>
                            </div>
                            <div class="border-top pt-3 mb-4 d-flex justify-content-between"><span
                                    class="text-muted fw-bold">TOTAL</span><span class="fw-bold fs-4"
                                    id="cart-subtotal">₱0.00</span></div>
                            <div class="mb-3"><label class="form-label fw-bold">Payment</label><select name="method_id"
                                    class="form-select" required>
                                    <option value="">Select...</option>@foreach($paymentMethods as $m)<option
                                    value="{{ $m->id }}">{{ $m->method_name }}</option>@endforeach
                                </select></div>
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" id="complete-btn"
                                disabled>Complete Sale</button>
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
                card.addEventListener('click', function () {
                    const id = this.dataset.itemId;
                    if (cart.find(c => c.itemId === id)) return;
                    cart.push({ itemId: id, itemCode: this.dataset.itemCode, price: parseFloat(this.dataset.itemPrice) });
                    this.classList.add('border-primary', 'opacity-50');
                    this.style.pointerEvents = 'none';
                    updateCart();
                });
            });

            function updateCart() {
                const container = document.getElementById('cart-items');
                let total = 0;
                if (cart.length === 0) {
                    container.innerHTML = '<p class="text-muted text-center py-4">No items selected</p>';
                    document.getElementById('complete-btn').disabled = true;
                } else {
                    container.innerHTML = '';
                    cart.forEach((item, i) => {
                        total += item.price;
                        container.innerHTML += `<div class="d-flex justify-content-between bg-light p-2 rounded mb-2 border"><div><strong>${item.itemCode}</strong><br><small>₱${item.price.toFixed(2)}</small></div><button type="button" class="btn btn-sm text-danger" onclick="removeFromCart('${item.itemId}', ${i})"><i class="bi bi-trash"></i></button><input type="hidden" name="items[${i}][item_id]" value="${item.itemId}"></div>`;
                    });
                    document.getElementById('complete-btn').disabled = false;
                }
                document.getElementById('cart-subtotal').textContent = '₱' + total.toFixed(2);
            }

            function removeFromCart(id, i) {
                cart.splice(i, 1);
                const card = document.querySelector(`.item-card[data-item-id="${id}"]`);
                if (card) { card.classList.remove('border-primary', 'opacity-50'); card.style.pointerEvents = 'auto'; }
                updateCart();
            }
        </script>
    @endpush
@endsection