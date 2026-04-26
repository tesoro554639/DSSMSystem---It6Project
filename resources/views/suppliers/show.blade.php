@extends('layouts.app')

@section('title', 'Supplier Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-1">Supplier: {{ $supplier->name }}</h2>
                <a href="{{ route('suppliers.index') }}" class="text-decoration-none">&larr; Back to Suppliers</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card h-100 d-flex flex-column">
                    <div class="card-header">
                        <h5 class="mb-0">Supplier Information</h5>
                    </div>
                    <div class="card-body flex-grow-1">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted">Company Name</td>
                                <td class="fw-bold">{{ $supplier->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Contact Person</td>
                                <td>{{ $supplier->contact_person ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Phone Number</td>
                                <td>{{ $supplier->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Address</td>
                                <td>{{ $supplier->address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Registered On</td>
                                <td>{{ $supplier->created_at ? $supplier->created_at->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Total Bales Provided</td>
                                <td>{{ $supplier->bales->count() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card h-100 d-flex flex-column">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Bales from this Supplier</h5>
                    </div>
                    <div class="card-body p-0 flex-grow-1 overflow-auto">
                        @if($supplier->bales->count() > 0)
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bale Number</th>
                                        <th>Purchase Date</th>
                                        <th>Total Items</th>
                                        <th>Purchase Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($supplier->bales as $bale)
                                        <tr>
                                            <td class="fw-bold">{{ $bale->bale_number }}</td>
                                            <td>{{ $bale->purchase_date->format('M d, Y') }}</td>
                                            <td>{{ $bale->total_items }}</td>
                                            <td>₱{{ number_format($bale->purchase_price, 2) }}</td>
                                            <td>
                                                <a href="{{ route('stock-in.show', $bale->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center text-muted py-5">
                                <p class="mb-0">No bales recorded from this supplier yet</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Quick Record Bales for {{ $supplier->name }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('suppliers.add-bales', $supplier->id) }}">
                    @csrf
                    <div id="bales-container">
                        <div class="row bale-row mb-3">
                            <div class="col-md-2">
                                <input type="text" name="bales[0][bale_number]" class="form-control"
                                    placeholder="Bale Number" required>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="bales[0][purchase_date]" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="bales[0][purchase_price]" class="form-control"
                                    placeholder="Price (₱)" step="0.01" min="0" required>
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="bales[0][total_items]" class="form-control"
                                    placeholder="Total Items" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="bales[0][notes]" class="form-control"
                                    placeholder="Notes (optional)">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save Bales</button>
                        <button type="button" class="btn btn-outline-secondary" id="add-bale-btn">Add Another Bale</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>

    @push('scripts')
        <script>
            let baleCount = 1;
            document.getElementById('add-bale-btn').addEventListener('click', function () {
                const container = document.getElementById('bales-container');
                const row = document.createElement('div');
                row.className = 'row bale-row mb-3';
                row.innerHTML = `
                                    <div class="col-md-2">
                                        <input type="text" name="bales[${baleCount}][bale_number]" class="form-control" placeholder="Bale Number" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="date" name="bales[${baleCount}][purchase_date]" class="form-control" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="bales[${baleCount}][purchase_price]" class="form-control" placeholder="Price (₱)" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" name="bales[${baleCount}][total_items]" class="form-control" placeholder="Total Items" min="1" required>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <input type="text" name="bales[${baleCount}][notes]" class="form-control" placeholder="Notes (optional)">
                                        <button type="button" class="btn btn-outline-danger btn-sm ms-2" onclick="this.closest('.bale-row').remove()">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                `;
                container.appendChild(row);
                baleCount++;
            });
        </script>
    @endpush
@endsection