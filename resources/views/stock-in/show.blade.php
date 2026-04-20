@extends('layouts.app')

@section('title', 'Bale Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Bale: {{ $bale->bale_number }}</h2>
                <a href="{{ route('stock-in.index') }}" class="text-decoration-none">&larr; Back to Stock-In</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card h-100 d-flex flex-column">
                    <div class="card-header">
                        <h5 class="mb-0">Bale Information</h5>
                    </div>
                    <div class="card-body flex-grow-1">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Bale Number</td>
                                <td class="fw-bold">{{ $bale->bale_number }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Supplier</td>
                                <td>{{ $bale->supplier_id }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Purchase Date</td>
                                <td>{{ $bale->purchase_date->format('M d, Y') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Purchase Price</td>
                                <td>₱{{ number_format($bale->purchase_price, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Total Items</td>
                                <td>{{ $bale->items->count() }} / {{ $bale->total_items }}</td>
                            </tr>
                            @if($bale->notes)
                                <tr>
                                    <td class="text-muted">Notes</td>
                                    <td>{{ $bale->notes }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Items in this Bale</h5>
                    </div>
                    <div class="card-body p-0">
                        @if($bale->items->count() > 0)
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bale->items as $item)
                                        <tr>
                                            <td>{{ $item->item_code }}</td>
                                            <td>{{ $item->category->name }}</td>
                                            <td>
                                                @if(!$item->is_sold)
                                                    @if($item->status_id == 1)
                                                        <span class="badge bg-success">
                                                            {{ $item->status->name }}
                                                        </span>
                                                    @elseif($item->status_id == 2)
                                                        <span class="badge bg-info">
                                                            {{ $item->status->name }}
                                                        </span>
                                                    @elseif($item->status_id == 3)
                                                        <span class="badge bg-warning">
                                                            {{ $item->status->name }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">
                                                        {{ $item->is_sold ? 'Sold' : '' }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>₱{{ number_format($item->price, 2) }}</td>
                                            <td>{{ $item->quantity }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center text-muted py-4">
                                <p class="mb-0">No items added yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($bale->items->count() < $bale->total_items)
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Add Items to Bale</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('stock-in.add-items', $bale->id) }}">
                        @csrf
                        <div id="items-container">
                            <div class="row item-row mb-3">
                                <div class="col-md-2">
                                    <input type="text" name="items[0][item_code]" class="form-control" placeholder="Item Code"
                                        required>
                                </div>
                                <div class="col-md-2">
                                    <select name="items[0][category_id]" class="form-select" required>
                                        <option value="">Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select name="items[0][status_id]" class="form-select" required>
                                        <option value="">Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="items[0][price]" class="form-control" placeholder="Price"
                                        step="0.01" min="0" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" name="items[0][quantity]" class="form-control" placeholder="Qty"
                                        min="1" value="1" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" name="items[0][description]" class="form-control"
                                        placeholder="Description (optional)">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Add Items</button>
                            <button type="button" class="btn btn-outline-secondary" id="add-item-btn">Add More Items</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            let itemCount = 1;
            document.getElementById('add-item-btn').addEventListener('click', function () {
                const container = document.getElementById('items-container');
                const row = document.createElement('div');
                row.className = 'row item-row mb-3';
                row.innerHTML = `
                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-2">
                                                                                                                                                                                                                                                                                                                                                                                                <input type="text" name="items[${itemCount}][item_code]" class="form-control" placeholder="Item Code" required>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-2">
                                                                                                                                                                                                                                                                                                                                                                                                <select name="items[${itemCount}][category_id]" class="form-select" required>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="">Category</option>
                                                                                                                                                                                                                                                                                                                                                                                                    @foreach($categories as $cat)
                                                                                                                                                                                                                                                                                                                                                                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                                                                                                                                                                                                                                                                                                                                                                    @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-2">
                                                                                                                                                                                                                                                                                                                                                                                                <select name="items[${itemCount}][status_id]" class="form-select" required>
                                                                                                                                                                                                                                                                                                                                                                                                    <option value="">Status</option>
                                                                                                                                                                                                                                                                                                                                                                                                    @foreach($statuses as $status)
                                                                                                                                                                                                                                                                                                                                                                                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                                                                                                                                                                                                                                                                                                                                                                    @endforeach
                                                                                                                                                                                                                                                                                                                                                                                                </select>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-2">
                                                                                                                                                                                                                                                                                                                                                                                                <input type="number" name="items[${itemCount}][price]" class="form-control" placeholder="Price" step="0.01" min="0" required>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-2">
                                                                                                                                                                                                                                                                                                                                                                                                <input type="number" name="items[${itemCount}][quantity]" class="form-control" placeholder="Qty" min="1" value="1" required>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                            <div class="col-md-2 d-flex align-items-center">
                                                                                                                                                                                                                                                                                                                                                                                                <input type="text" name="items[${itemCount}][description]" class="form-control" placeholder="Description (optional)">
                                                                                                                                                                                                                                                                                                                                                                                                <button type="button" class="btn btn-outline-danger btn-sm ms-2" onclick="this.closest('.item-row').remove()">
                                                                                                                                                                                                                                                                                                                                                                                                    <i class="bi bi-x"></i>
                                                                                                                                                                                                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                                                                                                                                                                                            </div>
                                                                                                                                                                                                                                                                                                                                                                                        `;
                container.appendChild(row);
                itemCount++;
            });
        </script>
    @endpush
@endsection