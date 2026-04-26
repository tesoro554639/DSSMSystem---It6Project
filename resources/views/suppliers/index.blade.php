@extends('layouts.app')

@section('title', 'Suppliers - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Supplier Management</h2>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>New Supplier
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Company Name</th>
                            <th>Contact Person</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suppliers as $supplier)
                            <tr>
                                <td>
                                    <a href="{{ route('suppliers.show', $supplier->id) }}"
                                        class="text-decoration-none text-dark">
                                        {{ $supplier->name }}
                                    </a>
                                </td>
                                <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                                <td>{{ $supplier->phone ?? 'N/A' }}</td>
                                <td class="text-truncate" style="max-width: 250px;" title="{{ $supplier->address }}">
                                    {{ $supplier->address ?? 'N/A' }}
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('suppliers.show', $supplier->id) }}" class="btn btn-outline-primary"
                                            title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('suppliers.edit', $supplier->id) }}" class="btn btn-outline-success"
                                            title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST"
                                            onsubmit="return confirm('WARNING: Are you sure you want to delete this supplier? Because of database constraints, this will also delete ALL bales and items purchased from them!')"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete"
                                                style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No suppliers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- @if($suppliers->hasPages())
            <div class="card-footer border-top-0 bg-white">
                {{ $suppliers->links() }}
            </div>
            @endif --}}
        </div>
    </div>
@endsection