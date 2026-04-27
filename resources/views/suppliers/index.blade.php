@extends('layouts.app')

@section('title', 'Suppliers - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Supplier Management</h2>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary shadow-sm rounded-3 px-3">
                <i class="bi bi-plus-lg me-2"></i>New Supplier
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
                            <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Company Name</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Contact Person</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Phone</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3">Address</th>
                            <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="border-top-0">
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td class="ps-4 py-3">
                                    <a href="{{ route('suppliers.show', $supplier->id) }}"
                                        class="text-decoration-none text-dark fw-bold">
                                        {{ $supplier->name }}
                                    </a>
                                </td>
                                <td class="py-3 text-secondary">{{ $supplier->contact_person ?? 'N/A' }}</td>
                                <td class="py-3 text-secondary">{{ $supplier->phone ?? 'N/A' }}</td>
                                <td class="py-3 text-secondary text-truncate" style="max-width: 250px;"
                                    title="{{ $supplier->address }}">
                                    {{ $supplier->address ?? 'N/A' }}
                                </td>
                                <td class="pe-4 py-3 text-end">
                                    <div class="btn-group btn-group-sm shadow-sm" role="group">
                                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-light border"
                                            title="View">
                                            <i class="bi bi-eye text-primary"></i>
                                        </a>

                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-light border"
                                            title="Edit">
                                            <i class="bi bi-pencil text-success"></i>
                                        </a>

                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                            onsubmit="return confirm('WARNING: Are you sure you want to delete this supplier? Because of database constraints, this will also delete ALL bales and items purchased from them!')"
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
                                <td colspan="5" class="text-center py-5">
                                    <div class="text-muted d-flex flex-column align-items-center">
                                        <i class="bi bi-truck fs-1 mb-2 opacity-50"></i>
                                        <span class="fw-medium">No suppliers found</span>
                                        <small>Click "New Supplier" to get started.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- @if($suppliers->hasPages())
            <div class="card-footer border-top bg-white py-3">
                {{ $suppliers->links() }}
            </div>
            @endif --}}
        </div>
    </div>
@endsection