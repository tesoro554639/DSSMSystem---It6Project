@extends('layouts.app')

@section('title', 'Category Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Category: {{ $category->name }}</h2>
                <a href="{{ route('categories.index') }}" class="text-decoration-none text-secondary hover-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Categories
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">General Information</h5>
                    </div>
                    <div class="card-body p-4">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0 py-2">Name</td>
                                <td class="fw-bold text-end pe-0 py-2">{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Description</td>
                                <td class="text-end pe-0 py-2 text-wrap" style="max-width: 150px;">
                                    {{ $category->description ?? 'No description provided' }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Total Items</td>
                                <td class="text-end pe-0 py-2 fw-bold text-primary">
                                    {{ $category->items->count() }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Stock-In Items: {{ $category->name }}</h5>
                    </div>
                    <div class="card-body p-0 overflow-auto" style="max-height: 400px;">
                        @if($category->items->count() > 0)
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light sticky-top">
                                    <tr>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Item Code</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Price</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Status</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach($category->items->sortByDesc('created_at') as $item)
                                        <tr>
                                            <td class="fw-bold ps-4 py-3">{{ $item->item_code }}</td>
                                            <td class="py-3 fw-medium">₱{{ number_format($item->price, 2) }}</td>
                                            <td class="py-3">
                                                <span
                                                    class="badge bg-{{ $item->is_sold ? 'secondary' : 'success' }} bg-opacity-10 text-{{ $item->is_sold ? 'secondary' : 'success' }} border border-{{ $item->is_sold ? 'secondary' : 'success' }} rounded-pill">
                                                    {{ $item->is_sold ? 'Sold' : 'Available' }}
                                                </span>
                                            </td>
                                            <td class="pe-4 py-3 text-end">
                                                <a href="{{ route('inventory.show', $item->id) }}"
                                                    class="btn btn-sm btn-light border shadow-sm text-primary">
                                                    View Item
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center">
                                    <i class="bi bi-box-seam fs-1 mb-2 opacity-50"></i>
                                    <span class="fw-medium">No items assigned to this category</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection