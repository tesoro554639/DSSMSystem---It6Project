@extends('layouts.app')

@section('title', 'New Bale - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Record New Bale</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('stock-in.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="bale_number" class="form-label fw-semibold text-secondary">Bale
                                        Number</label>
                                    <input type="text" name="bale_number" id="bale_number"
                                        class="form-control @error('bale_number') is-invalid @enderror"
                                        value="{{ old('bale_number') }}" required>
                                    @error('bale_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="supplier_id" class="form-label fw-semibold text-secondary">Supplier</label>
                                    <select name="supplier_id" id="supplier_id"
                                        class="form-select @error('supplier_id') is-invalid @enderror" required>
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                                {{ $supplier->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('supplier_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="purchase_price" class="form-label fw-semibold text-secondary">Purchase Price
                                        (₱)</label>
                                    <input type="number" name="purchase_price" id="purchase_price"
                                        class="form-control @error('purchase_price') is-invalid @enderror"
                                        value="{{ old('purchase_price') }}" step="0.01" min="0" required>
                                    @error('purchase_price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="total_items" class="form-label fw-semibold text-secondary">Total
                                        Items</label>
                                    <input type="number" name="total_items" id="total_items"
                                        class="form-control @error('total_items') is-invalid @enderror"
                                        value="{{ old('total_items') }}" min="1" required>
                                    @error('total_items')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="purchase_date" class="form-label fw-semibold text-secondary">Purchase
                                        Date</label>
                                    <input type="date" name="purchase_date" id="purchase_date"
                                        class="form-control @error('purchase_date') is-invalid @enderror"
                                        value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                    @error('purchase_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="notes" class="form-label fw-semibold text-secondary">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control"
                                        rows="3">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-2 border-top">
                                <button type="submit" class="btn btn-primary shadow-sm rounded-3 px-4 mt-3">Record
                                    Bale</button>
                                <a href="{{ route('stock-in.index') }}"
                                    class="btn btn-light border shadow-sm rounded-3 px-4 mt-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-info bg-opacity-10 border-start border-info border-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-info mb-3"><i class="bi bi-info-circle-fill me-2"></i>Instructions</h5>
                        <ul class="list-unstyled text-dark mb-0 space-y-2">
                            <li class="mb-2"><strong>1.</strong> Enter the bale number from the supplier</li>
                            <li class="mb-2"><strong>2.</strong> Select or add a new supplier</li>
                            <li class="mb-2"><strong>3.</strong> Enter the purchase price and total item count</li>
                            <li><strong>4.</strong> After saving, you can add individual items to this bale</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection