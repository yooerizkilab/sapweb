@extends('layouts.admin', [
    'title' => 'Bill of Material',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">List Bill of Material</h6>
            <a href="{{ route('goods-receipt.create') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-dolly-flatbed"></i>
                Add Bill of Material
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
                                <th>Code</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Warehouse</th>
                                <th width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($billOfMaterials as $billOfMaterial)
                                @php
                                    $warehouseName =
                                        collect($warehouses)->firstWhere(
                                            fn($g) => isset($g['WarehouseCode']) &&
                                                (string) $g['WarehouseCode'] === (string) $billOfMaterial['Warehouse'],
                                        )['WarehouseName'] ?? 'Unknown';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $billOfMaterial['TreeCode'] }}</td>
                                    <td>{{ $billOfMaterial['ProductDescription'] }}</td>
                                    <td class="text-center">{!! $billOfMaterial['TreeType'] == 'iProductionTree'
                                        ? '<span class="badge badge-primary">Production</span>'
                                        : '<span class="badge badge-secondary">Other</span>' !!}</td>
                                    <td class="text-center">{{ $billOfMaterial['Quantity'] }}</td>
                                    <td>{{ $warehouseName }}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <a href="" class="btn btn-primary btn-circle btn-sm mr-1">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <a href="{{ route('bill-of-material.show', $billOfMaterial['TreeCode']) }}"
                                                class="btn btn-info btn-circle btn-sm mr-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('bill-of-material.edit', $billOfMaterial['TreeCode']) }}"
                                                class="btn btn-warning btn-circle btn-sm mr-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form
                                                action="{{ route('bill-of-material.destroy', $billOfMaterial['TreeCode']) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
