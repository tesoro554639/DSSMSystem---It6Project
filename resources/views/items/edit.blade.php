@extends('layouts.app')

@section('title', 'Edit Item - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Edit Item: {{ $item->item_code }}</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('items.update', $item->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="item_code" class="form-label">Item Code</label>
                                    <input type="text" name="item_code" id="item_code"
                                        class="form-control @error('item_code') is-invalid @enderror"
                                        value="{{ old('item_code', $item->item_code) }}" required>
                                    @error('item_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="status_id" class="form-label">Status</label>
                                    <select name="status_id" id="status_id"
                                        class="form-select @error('status_id') is-invalid @enderror" required>
                                        <option value="">Select Status</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ old('status_id', $item->status_id) == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="price" class="form-label">Price (₱)</label>
                                    <input type="number" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $item->price) }}" step="0.01" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" name="quantity" id="quantity"
                                        class="form-control @error('quantity') is-invalid @enderror"
                                        value="{{ old('quantity', $item->quantity) }}" min="1" required>
                                    @error('quantity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <input type="text" name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        value="{{ old('description', $item->description) }}"
                                        placeholder="Optional details about this item">
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">Update Item</button>
                                <a href="{{ route('stock-in.show', $item->bale_id) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-warning text-dark border-0">
                    <div class="card-body">
                        <h5><i class="bi bi-exclamation-triangle-fill me-2"></i>Editing Mode</h5>
                        <p class="mb-0 small">If this item has already been sold, changing its price here will not alter
                            past sales records. However, changing its category or status will update your current inventory
                            metrics immediately.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection