@extends('layouts.admin', [
    'title' => 'Goods Receipt'
])

@push('css')

@endpush

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">List Goods Receipt</h6>
        <a href="{{ route('goods-receipt.create') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-truck-loading"></i> 
            Add Goods Receipt
        </a>
    </div>
    <div class="card-body">
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
                    @foreach($goodsReceipts as $goodsReceipt)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $goodsReceipt['DocNum'] }}</td>
                            <td class="text-center">{!! $goodsReceipt['DocType'] == 'dDocument_Service' ? '<span class="badge badge-primary">Service</span>' : '<span class="badge badge-secondary">Item</span>' !!}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($goodsReceipt['DocDate'])->translatedFormat('d F Y'); }}</td>
                            <td class="text-right">Rp {{ number_format($goodsReceipt['DocTotal'], 2) }}</td>
                            <td class="text-center">{!! $goodsReceipt['DocumentStatus'] == 'bost_Open' ? '<span class="badge badge-warning">Open</span>' : '<span class="badge badge-success">Close</span>' !!}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="" class="btn btn-primary btn-circle btn-sm mr-1">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    <a href="{{ route('goods-receipt.show', $goodsReceipt['DocEntry']) }}" class="btn btn-info btn-circle btn-sm mr-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @if($goodsReceipt['DocumentStatus'] == 'bost_Open')
                                    <a href="{{ route('goods-receipt.edit', $goodsReceipt['DocEntry']) }}" class="btn btn-warning btn-circle btn-sm mr-1">
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

@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>

@endpush