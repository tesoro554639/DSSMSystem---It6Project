@extends('layouts.app')

@section('title', 'Supplier Details - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1">Supplier: {{ $supplier->name }}</h2>
                <a href="{{ route('suppliers.index') }}" class="text-decoration-none text-secondary hover-primary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Suppliers
                </a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card h-100 d-flex flex-column border-0 shadow-sm rounded-3">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="mb-0 fw-bold text-dark">Supplier Information</h5>
                    </div>
                    <div class="card-body flex-grow-1 p-4">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <td class="text-muted ps-0 py-2">Company Name</td>
                                <td class="fw-bold text-end pe-0 py-2">{{ $supplier->name }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Contact Person</td>
                                <td class="text-end pe-0 py-2">{{ $supplier->contact_person ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Phone Number</td>
                                <td class="text-end pe-0 py-2">{{ $supplier->phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Address</td>
                                <td class="text-end pe-0 py-2">{{ $supplier->address ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Registered On</td>
                                <td class="text-end pe-0 py-2">
                                    {{ $supplier->created_at ? $supplier->created_at->format('M d, Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted ps-0 py-2">Total Bales</td>
                                <td class="text-end pe-0 py-2 fw-bold text-primary">{{ $supplier->bales->count() }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card h-100 d-flex flex-column border-0 shadow-sm rounded-3 overflow-hidden">
                    <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">Bales from this Supplier</h5>
                    </div>
                    <div class="card-body p-0 flex-grow-1 overflow-auto">
                        @if($supplier->bales->count() > 0)
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 ps-4">Bale Number</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Purchase Date</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Total Items</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3">Purchase Price</th>
                                        <th class="text-uppercase text-muted small fw-semibold py-3 pe-4 text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="border-top-0">
                                    @foreach($supplier->bales as $bale)
                                        <tr>
                                            <td class="fw-bold ps-4 py-3">{{ $bale->bale_number }}</td>
                                            <td class="py-3 text-secondary">{{ $bale->purchase_date->format('M d, Y') }}</td>
                                            <td class="py-3 text-secondary">{{ $bale->total_items }}</td>
                                            <td class="py-3 text-secondary">₱{{ number_format($bale->purchase_price, 2) }}</td>
                                            <td class="pe-4 py-3 text-end">
                                                <a href="{{ route('stock-in.show', $bale->id) }}"
                                                    class="btn btn-sm btn-light border shadow-sm text-primary">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="text-center py-5">
                                <div class="text-muted d-flex flex-column align-items-center">
                                    <i class="bi bi-box-seam fs-1 mb-2 opacity-50"></i>
                                    <span class="fw-medium">No bales recorded yet</span>
                                    <small>Bales associated with this supplier will appear here.</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="card border-0 shadow-sm rounded-3">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">Quick Record Bales for {{ $supplier->name }}</h5>
            </div>
            <div class="card-body p-4">
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
                    <div class="d-flex gap-2 pt-3 border-top mt-4">
                        <button type="submit" class="btn btn-primary shadow-sm rounded-3 px-4">Save Bales</button>
                        <button type="button" class="btn btn-light border shadow-sm rounded-3 px-4" id="add-bale-btn">Add
                            Another Bale</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>

    @push('scripts')
        <script>
            let baleCount = 1;
            document.getElementById('add-bale-btn')?.addEventListener('click', function () {
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
                                                <button type="button" class="btn btn-outline-danger btn-sm ms-2 rounded-3 shadow-sm" onclick="this.closest('.bale-row').remove()">
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