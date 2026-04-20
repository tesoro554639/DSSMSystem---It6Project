@extends('layouts.app')

@section('title', 'Inventory - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Inventory Management</h2>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card border-success">
                    <div class="card-body">
                        <h6 class="text-muted">Available Items</h6>
                        <h3 class="mb-0">{{ $availableCount }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-danger">
                    <div class="card-body">
                        <h6 class="text-muted">Sold Items</h6>
                        <h3 class="mb-0">{{ $soldCount }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-primary">
                    <div class="card-body">
                        <h6 class="text-muted">Total Items</h6>
                        <h3 class="mb-0">{{ $totalCount }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" id="inventory-table">
            <div class="card-header">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <select name="category" class="form-select">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>

                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}" {{ request('status') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach

                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>
                                Sold
                            </option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                    </div>
                </form>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Item Code</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Bale</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
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
                                <td>{{ $item->bale->bale_number ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('inventory.show', $item->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">No items found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $items->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection