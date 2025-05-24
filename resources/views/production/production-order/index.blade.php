@extends('layouts.admin', [
    'title' => 'Production Order',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">List Production Order</h6>
            <a href="{{ route('production-order.create') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-cart-plus"></i>
                Add Production Order
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
                                <th>Document Date</th>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Lenght</th>
                                <th>Warehouse</th>
                                <th>Status</th>
                                <th width="10%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($productionOrders as $productionOrder)
                                @php
                                    $warehouseName =
                                        collect($warehouses)->firstWhere(
                                            fn($g) => isset($g['WarehouseCode']) &&
                                                (string) $g['WarehouseCode'] === (string) $productionOrder['Warehouse'],
                                        )['WarehouseName'] ?? 'Unknown';
                                @endphp
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $productionOrder['DocumentNumber'] }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($productionOrder['PostingDate'])->translatedFormat('d F Y') }}
                                    </td>
                                    <td>{{ $productionOrder['ItemNo'] }}</td>
                                    <td>{{ $productionOrder['ProductDescription'] }}</td>
                                    <td class="text-center">{{ number_format($productionOrder['PlannedQuantity'], 2) }}</td>
                                    <td class="text-center">{{ number_format($productionOrder['U_IT_Panjang'], 2) }}</td>
                                    <td>{{ $warehouseName }}</td>
                                    <td class="text-center">
                                        @if ($productionOrder['ProductionOrderStatus'] === 'boposReleased')
                                            <span class="badge badge-success">Released</span>
                                        @elseif ($productionOrder['ProductionOrderStatus'] === 'boposPlanned')
                                            <span class="badge badge-warning">Planned</span>
                                        @elseif ($productionOrder['ProductionOrderStatus'] === 'boposClosed')
                                            <span class="badge badge-primary">Closed</span>
                                        @else
                                            <span class="badge badge-secondary">Unknown</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <a href="{{ route('production-order.show', $productionOrder['AbsoluteEntry']) }}"
                                                class="btn btn-info btn-circle btn-sm mr-1">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('production-order.edit', $productionOrder['AbsoluteEntry']) }}"
                                                class="btn btn-warning btn-circle btn-sm mr-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="" method="post">
                                                @csrf
                                                <button type="button" class="btn btn-danger btn-circle btn-sm">
                                                    <i class="fas fa-times"></i>
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
