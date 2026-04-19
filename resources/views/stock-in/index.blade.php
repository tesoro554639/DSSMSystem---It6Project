@extends('layouts.app')

@section('title', 'Stock-In - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Stock-In Management</h2>
            <a href="{{ route('stock-in.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-2"></i>New Bale
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
                            <th>Bale Number</th>
                            <th>Supplier</th>
                            <th>Purchase Date</th>
                            <th>Items</th>
                            <th>Purchase Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bales as $bale)
                            <tr>
                                <td>
                                    <a href="{{ route('stock-in.show', $bale->id) }}">{{ $bale->bale_number }}</a>
                                </td>
                                <td>{{ $bale->supplier->name }}</td>
                                <td>{{ $bale->purchase_date->format('M d, Y') }}</td>
                                <td>{{ $bale->items_count ?? $bale->items->count() }}</td>
                                <td>₱{{ number_format($bale->purchase_price, 2) }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('stock-in.show', $bale->id) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <form action="{{ route('stock-in.destroy', $bale->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">No bales found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $bales->links() }}
            </div>
        </div>
    </div>
@endsection