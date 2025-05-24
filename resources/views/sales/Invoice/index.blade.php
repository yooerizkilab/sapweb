@extends('layouts.admin', [
    'title' => 'Invoice',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">List Invoice</h6>
            <a href="{{ route('sales-invoice.create') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-cart-plus"></i>
                Add Invoice
            </a>
        </div>
        <div class="card-body">
            <!-- Spinner -->
            <div id="loading-spinner" style="text-align: center; padding: 50px;">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="sr-only">Loading...</span>
                </div>
                <p>Loading data...</p>
            </div>
            <div id="main-content" style="display: none;">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-light">
                            <tr class="text-center">
                                <th width="5%">No</th>
                                <th>Document No</th>
                                <th>Type</th>
                                <th width="15%">Document Date</th>
                                <th>Customers</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $invoice['DocNum'] }}</td>
                                    <td class="text-center">{!! $invoice['DocType'] == 'dDocument_Service'
                                        ? '<span class="badge badge-primary">Service</span>'
                                        : '<span class="badge badge-secondary">Item</span>' !!}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($invoice['DocDate'])->translatedFormat('d F Y') }}</td>
                                    <td>{{ $invoice['CardCode'] }} - {{ $invoice['CardName'] }}</td>
                                    <td class="text-right">Rp {{ number_format($invoice['DocTotal'], 2) }}</td>
                                    <td class="text-center">{!! $invoice['DocumentStatus'] == 'bost_Open'
                                        ? '<span class="badge badge-warning">Open</span>'
                                        : '<span class="badge badge-success">Close</span>' !!}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <a href="" class="btn btn-primary btn-circle btn-sm mr-1">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="{{ route('sales-invoice.show', $invoice['DocEntry']) }}"
                                                class="btn btn-info btn-circle btn-sm mr-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($invoice['DocumentStatus'] == 'bost_Open')
                                                <a href="{{ route('sales-invoice.edit', $invoice['DocEntry']) }}"
                                                    class="btn btn-warning btn-circle btn-sm mr-1">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <a href="" class="btn btn-success btn-circle btn-sm mr-1">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="" class="btn btn-danger btn-circle btn-sm mr-1">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Hide spinner and show main content after page loads
            document.getElementById('loading-spinner').style.display = 'none';
            document.getElementById('main-content').style.display = 'block';

            // Initialize DataTable if table exists
            if (document.getElementById('dataTable')) {
                $('#dataTable').DataTable({
                    responsive: true
                });
            }
        });
    </script>
@endpush
