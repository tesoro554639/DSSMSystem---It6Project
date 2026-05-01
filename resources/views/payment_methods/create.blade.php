@extends('layouts.app')

@section('title', 'New Payment Method - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Add New Payment Method</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('payment_methods.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="method_name" class="form-label fw-semibold text-secondary">Payment Method
                                        Name</label>
                                    <input type="text" name="method_name" id="method_name"
                                        class="form-control @error('method_name') is-invalid @enderror"
                                        value="{{ old('method_name') }}" placeholder="New payment method" required>
                                    @error('method_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="description" class="form-label fw-semibold text-secondary">Description
                                        (Optional)</label>
                                    <textarea name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror" rows="3"
                                        placeholder="Add any specific instructions or notes for cashiers using this method...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-2 border-top">
                                <button type="submit" class="btn btn-primary shadow-sm rounded-3 px-4 mt-3">Save Payment
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
                    class="card border-0 shadow-sm rounded-3 bg-primary bg-opacity-10 border-start border-primary border-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-info-circle-fill me-2"></i>Instructions</h5>
                        <ul class="list-unstyled text-dark mb-0 space-y-2">
                            <li class="mb-2"><strong>1.</strong> Enter a clear, recognizable name for the payment method
                                (e.g., "Cash", "GCash").</li>
                            <li class="mb-2"><strong>2.</strong> Use the description to add internal notes, like "Ask for
                                reference number" for e-wallets.</li>
                            <li class="mb-2"><strong>3.</strong> Ensure the name is unique to avoid confusing cashiers at
                                checkout.</li>
                            <li><strong>4.</strong> Once saved, this method will instantly be available in the Sales
                                Checkout screen.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection