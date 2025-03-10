@extends('layouts.admin', [
    'title' => 'Bussines Partners Master'
])

@push('css')
    
@endpush

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">List Bussines Master</h6>
        <a href="{{ route('business-master.create') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-user-tie"></i> 
            Add Bussines Master
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Card Code</th>
                        <th>Card Name</th>
                        <th>Type</th>
                        <th width="10%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($businessPartners as $businessPartner)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $businessPartner['CardCode'] }}</td>
                        <td>{{ $businessPartner['CardName'] }}</td>
                        <td class="text-center">{{ $businessPartner['CardType'] == 'cCustomer' ? 'Customer' : 'Supplier' }}</td>
                        <td class="text-center">
                            <div class="d-inline-flex">
                                <a href="{{ route('business-master.show', $businessPartner['CardCode']) }}" class="btn btn-info btn-circle btn-sm mr-1">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('business-master.edit', $businessPartner['CardCode']) }}" class="btn btn-warning btn-circle btn-sm mr-1">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('business-master.destroy', $businessPartner['CardCode']) }}" method="post" id="deleteForm-{{ $businessPartner['CardCode'] }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-circle btn-sm" onclick="confirmDelete">
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

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>
@endpush