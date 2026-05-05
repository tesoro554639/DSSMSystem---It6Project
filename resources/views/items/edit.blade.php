@extends('layouts.app')

@section('title', 'Edit Item - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Edit Item: {{ $item->item_code }}</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('items.update', $item->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Item Code</label>
                                    <input type="text" class="form-control bg-light border-0 fw-bold"
                                        value="{{ $item->item_code }}" readonly>
                                    <div class="form-text text-info">Managed automatically by the system.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="category_id"
                                        class="form-label text-muted small fw-bold text-uppercase">Category</label>
                                    <select name="category_id" id="category_id"
                                        class="form-select @error('category_id') is-invalid @enderror" required>
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
                                <div class="col-md-6">
                                    <label for="price" class="form-label text-muted small fw-bold text-uppercase">Price
                                        (₱)</label>
                                    <input type="number" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $item->price) }}" step="0.01" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold text-uppercase">Current Status</label>
                                    <div class="mt-1">
                                        @if($item->is_sold)
                                            <span
                                                class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary rounded-pill px-3 py-2">
                                                <i class="bi bi-cart-check-fill me-1"></i> Sold
                                            </span>
                                        @else
                                            <span
                                                class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2">
                                                <i class="bi bi-check-circle-fill me-1"></i> Available
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="description"
                                        class="form-label text-muted small fw-bold text-uppercase">Description</label>
                                    <input type="text" name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        value="{{ old('description', $item->description) }}"
                                        placeholder="Add details about this item...">
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 border-top pt-4">
                                <button type="submit" class="btn btn-primary px-4 shadow-sm fw-bold">Update Item</button>
                                <a href="{{ route('stock-in.show', $item->bale_id) }}"
                                    class="btn btn-light border px-4">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-info bg-opacity-10 border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-info text-uppercase mb-3"><i class="bi bi-shield-lock-fill me-2"></i>Data
                            Integrity</h6>
                        <p class="small text-secondary mb-0">
                            Status management is automated. To make a <strong>Sold</strong> item available again, the
                            associated transaction must be voided. This prevents discrepancies in your financial reports.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection