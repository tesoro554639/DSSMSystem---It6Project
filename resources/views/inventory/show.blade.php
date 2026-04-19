@extends('layouts.app')

@section('title', 'Item Details - DSSM')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Item: {{ $item->item_code }}</h2>
            <a href="{{ route('inventory.index') }}" class="text-decoration-none">&larr; Back to Inventory</a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Item Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Item Code</td>
                            <td class="fw-bold">{{ $item->item_code }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Category</td>
                            <td>{{ $item->category->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>
                                <span class="badge bg-{{ $item->is_sold ? 'secondary' : 'success' }}">
                                    {{ $item->is_sold ? 'Sold' : 'Available' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Price</td>
                            <td>₱{{ number_format($item->price, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Quantity</td>
                            <td>{{ $item->quantity }}</td>
                        </tr>
                        @if($item->description)
                        <tr>
                            <td class="text-muted">Description</td>
                            <td>{{ $item->description }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Bale Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Bale Number</td>
                            <td>{{ $item->bale->bale_number ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Supplier</td>
                            <td>{{ $item->bale->supplier->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Purchase Date</td>
                            <td>{{ $item->bale->purchase_date?->format('M d, Y') ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection