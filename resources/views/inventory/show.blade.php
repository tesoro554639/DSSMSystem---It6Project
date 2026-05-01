@extends('layouts.app')

@section('title', 'Item Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Item: {{ $item->item_code }}</h2>
                <a href="{{ route('inventory.index') }}" class="text-decoration-none text-secondary hover-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Inventory
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 d-flex flex-column border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Item Information</h5>
                    </div>
                    <div class="card-body flex-grow-1 p-4">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0 py-2">Item Code</td>
                                <td class="fw-bold text-end pe-0 py-2 text-dark">{{ $item->item_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Category</td>
                                <td class="text-end pe-0 py-2 text-secondary">{{ $item->category->name ?? 'None'}}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Status</td>
                                <td class="text-end pe-0 py-2">
                                    <span class="badge bg-{{ $item->is_sold ? 'secondary' : 'success' }} bg-opacity-10 text-{{ $item->is_sold ? 'secondary' : 'success' }} border border-{{ $item->is_sold ? 'secondary' : 'success' }}">
                                        {{ $item->is_sold ? 'Sold' : 'Available' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Price</td>
                                <td class="fw-bold text-success text-end pe-0 py-2">₱{{ number_format($item->price, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Quantity</td>
                                <td class="text-end pe-0 py-2 text-secondary">{{ $item->quantity }}</td>
                            </tr>
                            @if($item->description)
                                <tr>
                                    <td class="text-muted ps-0 py-2">Description</td>
                                    <td class="text-end pe-0 py-2 text-secondary">{{ $item->description }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 d-flex flex-column border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Bale Origin Information</h5>
                    </div>
                    <div class="card-body flex-grow-1 p-4">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0 py-2">Bale Number</td>
                                <td class="fw-bold text-primary text-end pe-0 py-2">
                                    @if($item->bale)
                                        <a href="{{ route('stock-in.show', $item->bale->id) }}" class="text-decoration-none">{{ $item->bale->bale_number }}</a>
                                    @else
                                        <span class="text-secondary fw-normal">N/A</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Supplier</td>
                                <td class="text-end pe-0 py-2 text-secondary">{{ $item->bale->supplier->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Purchase Date</td>
                                <td class="text-end pe-0 py-2 text-secondary">{{ $item->bale->purchase_date?->format('M d, Y') ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection