@extends('layouts.app')

@section('title', 'Categories - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Item Category Management</h2>
            <a href="{{ route('categories.create') }}" class="btn btn-primary shadow-sm rounded-3 px-3">
                <i class="bi bi-plus-lg me-2"></i>New Category
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Category Name</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Description</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($categories as $category)
                            <tr>
                                <td class="ps-4 py-3">
                                    <a href="{{ route('categories.show', $category->id) }}"
                                        class="text-decoration-none text-dark fw-bold">
                                        {{ $category->name }}
                                    </a>
                                </td>
                                <td class="py-3 text-secondary text-truncate" style="max-width: 400px;"
                                    title="{{ $category->description }}">
                                    {{ $category->description ?? 'No description provided' }}
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group btn-group-sm shadow-sm" role="group">
                                        <a href="{{ route('categories.show', $category->id) }}" class="btn btn-light border"
                                            title="View Details">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>

                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-light border"
                                            title="Edit">
                                            <i class="bi bi-pencil text-success"></i>
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                            onsubmit="return confirm('WARNING: Deleting this category will fail if it has active items. Are you sure?')"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light border" title="Delete"
                                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                <i class="bi bi-trash text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-tag fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No categories found</span>
                                        <small>Click "New Category" to organize your inventory.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection