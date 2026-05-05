@extends('layouts.app')

@section('title', 'New Category - DSSM')

@section('content')
    <div class="container-fluid">
        <h2 class="fw-bold text-dark mb-4">Add New Item Category</h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('categories.store') }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="name" class="form-label fw-semibold text-secondary">Category Name</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="e.g., Tops, Bottoms, Dresses" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <label for="description" class="form-label fw-semibold text-secondary">Description (Optional)</label>
                                    <textarea name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror" rows="3"
                                        placeholder="Briefly describe what items belong in this category for better organization...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-2 pt-2 border-top">
                                <button type="submit" class="btn btn-primary shadow-sm rounded-3 px-4 mt-3">Save Category</button>
                                <a href="{{ route('categories.index') }}"
                                    class="btn btn-light border shadow-sm rounded-3 px-4 mt-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-3 bg-success bg-opacity-10 border-start border-success border-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-success mb-3"><i class="bi bi-tag-fill me-2"></i>Category Tips</h5>
                        <ul class="list-unstyled text-dark mb-0">
                            <li class="mb-2"><strong>1.</strong> Use broad names (e.g., "Outerwear" instead of just "Jackets").</li>
                            <li><strong>2.</strong> Avoid creating duplicate categories to keep stock reports clean and accurate.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection