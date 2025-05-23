@extends('layouts.admin', [
    'title' => 'Purchases Quotation'
])

@push('css')

@endpush

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">List Purchases Quotation</h6>
        <a href="{{ route('purchases-quotation.create') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-cart-plus"></i> 
            Add Purchases Quotation
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Document No</th>
                        <th>Type</th>
                        <th width="15%">Document Date</th>
                        <th>Requested By</th>
                        <th>Status</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @foreach($purchasesQuotations as $purchasesQuotation)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $purchasesQuotation['DocNum'] }}</td>
                        <td class="text-center">{!! $purchasesQuotation['DocType'] == 'dDocument_Service' ? '<span class="badge badge-primary">Service</span>' : '<span class="badge badge-secondary">Item</span>' !!}</td>
                        <td>{{ \Carbon\Carbon::parse($purchasesQuotation['DocDate'])->translatedFormat('d F Y'); }}</td>
                        <td>{{ $purchasesQuotation['Requester'] }} - {{ $purchasesQuotation['RequesterName'] }}</td>
                        <td class="text-center">{!! $purchasesQuotation['DocumentStatus'] == 'bost_Open' ? '<span class="badge badge-warning">Open</span>' : '<span class="badge badge-success">Close</span' !!}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <a href="{{ route('purchases-quotation.show', $purchasesQuotation['DocEntry']) }}" class="btn btn-info btn-circle btn-sm mr-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('purchases-quotation.edit', $purchasesQuotation['DocEntry']) }}" class="btn btn-warning btn-circle btn-sm mr-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach --}}
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