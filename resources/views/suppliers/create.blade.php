@extends('layouts.app')

@section('title', 'New Supplier - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="mb-4">Add New Supplier</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('suppliers.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label">Company / Supplier Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="contact_person" class="form-label">Contact Person</label>
                                    <input type="text" name="contact_person" id="contact_person"
                                        class="form-control @error('contact_person') is-invalid @enderror"
                                        value="{{ old('contact_person') }}">
                                    @error('contact_person')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror"
                                        rows="3">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Save Supplier</button>
                                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h5><i class="bi bi-info-circle me-2"></i>Instructions</h5>
                        <p class="mb-0">1. Enter the official company or supplier name</p>
                        <p class="mb-0">2. Provide a specific contact person</p>
                        <p class="mb-0">3. Include accurate phone and address details</p>
                        <p class="mb-0">4. Saved suppliers will be available when recording new bales</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection