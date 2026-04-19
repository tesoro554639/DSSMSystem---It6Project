@extends('layouts.app')

@section('title', 'Inventory Status - DSSM')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Inventory Status Report</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body">
                    <h6 class="text-muted">Total Items</h6>
                    <h3 class="mb-0">{{ $overallStats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body">
                    <h6 class="text-muted">Available</h6>
                    <h3 class="mb-0 text-success">{{ $overallStats['available'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-danger">
                <div class="card-body">
                    <h6 class="text-muted">Sold</h6>
                    <h3 class="mb-0 text-danger">{{ $overallStats['sold'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body">
                    <h6 class="text-muted">Total Value</h6>
                    <h3 class="mb-0">₱{{ number_format($overallStats['total_value'], 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Category Summary</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Category</th>
                                <th>Total Items</th>
                                <th>Available</th>
                                <th>Sold</th>
                                <th>Avail %</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categorySummary as $cat)
                            <tr>
                                <td>{{ $cat->category_name }}</td>
                                <td>{{ $cat->total_items }}</td>
                                <td class="text-success">{{ $cat->available }}</td>
                                <td class="text-danger">{{ $cat->sold }}</td>
                                <td>
                                    @php $pct = $cat->total_items > 0 ? ($cat->available / $cat->total_items * 100) : 0 @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: {{ $pct }}%">{{ number_format($pct, 0) }}%</div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Item Details</h5>
            <form method="GET" class="row g-2">
                <div class="col-auto">
                    <select name="category" class="form-select form-select-sm">
                        <option value="">All Categories</option>
                        @foreach($categorySummary as $cat)
                            <option value="{{ $cat->category_name }}">{{ $cat->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-primary">Filter</button>
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
                        <th>Bale</th>
                        <th>Supplier</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                    <tr>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>
                            <span class="badge bg-{{ $item->is_sold ? 'secondary' : 'success' }}">
                                {{ $item->is_sold ? 'Sold' : 'Available' }}
                            </span>
                        </td>
                        <td>₱{{ number_format($item->price, 2) }}</td>
                        <td>{{ $item->bale->bale_number ?? 'N/A' }}</td>
                        <td>{{ $item->bale->supplier->name ?? 'N/A' }}</td>
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
            {{ $items->links() }}
        </div>
    </div>
</div>
@endsection