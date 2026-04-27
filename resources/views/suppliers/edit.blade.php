@extends('layouts.app')

@section('title', 'Edit Supplier - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Edit Supplier: <span class="text-primary">{{ $supplier->name }}</span></h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('suppliers.update', $supplier->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label fw-semibold text-secondary">Company / Supplier
                                        Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $supplier->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="contact_person" class="form-label fw-semibold text-secondary">Contact
                                        Person</label>
                                    <input type="text" name="contact_person" id="contact_person"
                                        class="form-control @error('contact_person') is-invalid @enderror"
                                        value="{{ old('contact_person', $supplier->contact_person) }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold text-secondary">Phone Number</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $supplier->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="address" class="form-label fw-semibold text-secondary">Address</label>
                                    <textarea name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        rows="3">{{ old('address', $supplier->address) }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-2 border-top">
                                <button type="submit" class="btn btn-success shadow-sm rounded-3 px-4 mt-3">Update
                                    Supplier</button>
                                <a href="{{ route('suppliers.index') }}"
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
                        <p class="mb-0 text-dark">Updating the supplier's name or details here will reflect globally across
                            all
                            historical bales and stock-ins associated with them.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection