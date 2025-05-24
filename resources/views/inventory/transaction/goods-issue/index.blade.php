@extends('layouts.admin', [
    'title' => 'Goods Issue',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">List Goods Issue</h6>
            <a href="{{ route('goods-issue.create') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-truck-fast"></i>
                Add Goods Issue
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
                                <th width="10%">Document No</th>
                                <th width="10%">Type</th>
                                <th width="15%">Document Date</th>
                                <th>Grand Total</th>
                                <th width="10%">Status</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goodsIssues as $goodsIssue)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $goodsIssue['DocNum'] }}</td>
                                    <td class="text-center">{!! $goodsIssue['DocType'] == 'dDocument_Service'
                                        ? '<span class="badge badge-primary">Service</span>'
                                        : '<span class="badge badge-secondary">Item</span>' !!}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($goodsIssue['DocDate'])->translatedFormat('d F Y') }}</td>
                                    <td class="text-right">Rp {{ number_format($goodsIssue['DocTotal'], 2) }}</td>
                                    <td class="text-center">{!! $goodsIssue['DocumentStatus'] == 'bost_Open'
                                        ? '<span class="badge badge-warning">Open</span>'
                                        : '<span class="badge badge-success">Close</span>' !!}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <a href="" class="btn btn-primary btn-circle btn-sm mr-1">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="{{ route('goods-issue.show', $goodsIssue['DocEntry']) }}"
                                                class="btn btn-info btn-circle btn-sm mr-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if ($goodsIssue['DocumentStatus'] == 'bost_Open')
                                                <a href="{{ route('goods-issue.edit', $goodsIssue['DocEntry']) }}"
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
