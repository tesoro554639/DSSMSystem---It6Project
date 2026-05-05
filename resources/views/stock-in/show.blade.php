@extends('layouts.app')

@section('title', 'Bale Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Bale: {{ $bale->bale_number }}</h2>
                <a href="{{ route('stock-in.index') }}" class="text-decoration-none text-secondary hover-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Stock-In
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card h-100 d-flex flex-column border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Bale Information</h5>
                    </div>
                    <div class="card-body flex-grow-1 p-4">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0 py-2">Bale Number</td>
                                <td class="fw-bold text-end pe-0 py-2">{{ $bale->bale_number }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Supplier</td>
                                <td class="text-end pe-0 py-2">{{ $bale->supplier->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Purchase Date</td>
                                <td class="text-end pe-0 py-2">{{ $bale->purchase_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Purchase Price</td>
                                <td class="text-end pe-0 py-2 fw-bold text-success">₱{{ number_format($bale->purchase_price, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Total Items</td>
                                <td class="text-end pe-0 py-2">{{ $bale->items->count() }}</td>
                            </tr>
                            @if($bale->notes)
                                <tr>
                                    <td class="text-muted ps-0 py-2">Notes</td>
                                    <td class="text-end pe-0 py-2 text-secondary">{{ $bale->notes }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 d-flex flex-column">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Items in this Bale</h5>
                    </div>
                    <div class="card-body p-0 flex-grow-1 overflow-auto">
                        @if($bale->items->count() > 0)
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Item Code</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Category</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Status</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Price</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Desc</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach($bale->items as $item)
                                        <tr>
                                            <td class="ps-4 py-3 fw-bold">{{ $item->item_code }}</td>
                                            <td class="py-3 text-secondary">{{ $item->category->name }}</td>
                                            <td class="py-3">
                                                @if($item->is_sold)
                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3">Sold</span>
                                                @else
                                                    <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3">Available</span>
                                                @endif
                                            </td>
                                            <td class="py-3 text-secondary">₱{{ number_format($item->price, 2) }}</td>
                                            <td class="py-3 text-secondary text-truncate" style="max-width: 150px;" title="{{ $item->description }}">
                                                {{ $item->description ?? '-' }}
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <div class="btn-group btn-group-sm shadow-sm" role="group">
                                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-light border" title="Edit Item">
                                                        <i class="bi bi-pencil text-success"></i>
                                                    </a>
                                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure?')" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-light border" title="Remove Item">
                                                            <i class="bi bi-trash text-danger"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center">
                                    <i class="bi bi-tags fs-1 mb-2 opacity-50"></i>
                                    <span class="fw-medium">No items added yet</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3 mt-4">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">Add Items to Bale</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('stock-in.add-items', $bale->id) }}">
                    @csrf
                    <div id="items-container">
                        <div class="row item-row mb-3">
                            <div class="col-md-2">
                                <select name="items[0][category_id]" class="form-select" required>
                                    <option value="">Category</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="items[0][price]" class="form-control" placeholder="Price" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="items[0][quantity]" class="form-control" placeholder="Qty" min="1" value="1" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="items[0][description]" class="form-control" placeholder="Description (optional)">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 pt-3 border-top mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm rounded-3 px-4">Add Items</button>
                        <button type="button" class="btn btn-light border shadow-sm rounded-3 px-4" id="add-item-btn">Add More Items</button>
                    </div>
                </form>
            </div>
        </div>
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
                        <select name="items[${itemCount}][category_id]" class="form-select" required>
                            <option value="">Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="items[${itemCount}][price]" class="form-control" placeholder="Price" step="0.01" min="0" required>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="items[${itemCount}][quantity]" class="form-control" placeholder="Qty" min="1" value="1" required>
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="items[${itemCount}][description]" class="form-control" placeholder="Description (optional)">
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" class="btn btn-outline-danger border-0" onclick="this.closest('.item-row').remove()">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                `;
                container.appendChild(row);
                itemCount++;
            });
        </script>
    @endpush
@endsection