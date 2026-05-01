@extends('layouts.app')

@section('title', 'Edit Payment Method - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Edit Payment Method: <span
                class="text-primary">{{ $paymentMethod->method_name }}</span></h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('payment_methods.update', $paymentMethod->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="method_name" class="form-label fw-semibold text-secondary">Payment Method
                                        Name</label>
                                    <input type="text" name="method_name" id="method_name"
                                        class="form-control @error('method_name') is-invalid @enderror"
                                        value="{{ old('method_name', $paymentMethod->method_name) }}" required>
                                    @error('method_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="description"
                                        class="form-label fw-semibold text-secondary">Description</label>
                                    <textarea name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="3">{{ old('description', $paymentMethod->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-2 border-top">
                                <button type="submit" class="btn btn-success shadow-sm rounded-3 px-4 mt-3">Update Payment
                                    Method</button>
                                <a href="{{ route('payment_methods.index') }}"
                                    class="btn btn-light border shadow-sm rounded-3 px-4 mt-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div
                    class="card border-0 shadow-sm rounded-3 bg-warning bg-opacity-10 border-start border-warning border-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3"><i
                                class="bi bi-exclamation-triangle-fill text-warning me-2"></i>Editing Mode</h5>
                        <p class="mb-0 text-dark">Updating the payment method's name here will automatically reflect
                            globally across all past receipts and historical sales reports associated with it.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection