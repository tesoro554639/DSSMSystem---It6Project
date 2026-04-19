@extends('layouts.app')

@section('title', 'New Bale - DSSM')

@section('content')
<div class="container-fluid">
    <h2 class="mb-4">Record New Bale</h2>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('stock-in.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bale_number" class="form-label">Bale Number</label>
                                <input type="text" name="bale_number" id="bale_number" class="form-control @error('bale_number') is-invalid @enderror" value="{{ old('bale_number') }}" required>
                                @error('bale_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="supplier_id" class="form-label">Supplier</label>
                                <select name="supplier_id" id="supplier_id" class="form-select @error('supplier_id') is-invalid @enderror" required>
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
                                <label for="purchase_price" class="form-label">Purchase Price (₱)</label>
                                <input type="number" name="purchase_price" id="purchase_price" class="form-control @error('purchase_price') is-invalid @enderror" value="{{ old('purchase_price') }}" step="0.01" min="0" required>
                                @error('purchase_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="total_items" class="form-label">Total Items</label>
                                <input type="number" name="total_items" id="total_items" class="form-control @error('total_items') is-invalid @enderror" value="{{ old('total_items') }}" min="1" required>
                                @error('total_items')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="purchase_date" class="form-label">Purchase Date</label>
                                <input type="date" name="purchase_date" id="purchase_date" class="form-control @error('purchase_date') is-invalid @enderror" value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="notes" class="form-label">Notes</label>
                                <textarea name="notes" id="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Record Bale</button>
                            <a href="{{ route('stock-in.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5><i class="bi bi-info-circle me-2"></i>Instructions</h5>
                    <p class="mb-0">1. Enter the bale number from the supplier</p>
                    <p class="mb-0">2. Select or add a new supplier</p>
                    <p class="mb-0">3. Enter the purchase price and total item count</p>
                    <p class="mb-0">4. After saving, you can add individual items to this bale</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection