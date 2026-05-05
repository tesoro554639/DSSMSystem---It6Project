@extends('layouts.app')

@section('title', 'Revenue Analytics - DSSM')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark mb-0">Financial Analytics</h2>
            <a href="{{ route('reports.daily-sales') }}" class="btn btn-outline-secondary shadow-sm px-3">
                <i class="bi bi-arrow-left me-2"></i>Back to Daily Sales
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-header bg-white border-bottom py-3">
                <h5 class="mb-0 fw-bold text-dark">
                    <i class="bi bi-graph-up text-primary me-2"></i>Daily Revenue Summary
                </h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase text-muted small fw-semibold">Sales Date</th>
                            <th class="py-3 text-uppercase text-muted small fw-semibold text-center">Transactions</th>
                            <th class="pe-4 py-3 text-uppercase text-muted small fw-semibold text-end">Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($revenueData as $report)
                            <tr>
                                <td class="ps-4 py-3 fw-bold text-dark">
                                    {{ \Carbon\Carbon::parse($report->sales_date)->format('F d, Y') }}
                                </td>
                                <td class="py-3 text-center">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary rounded-pill px-3">
                                        {{ $report->total_transactions }} txns
                                    </span>
                                </td>
                                <td class="pe-4 py-3 text-end fw-bold text-success fs-5">
                                    ₱{{ number_format($report->daily_revenue, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    No revenue data generated yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection