@extends('layouts.admin', [
    'title' => 'Business Partners Master',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">List Business Partners</h6>
            <a href="{{ route('business-master.create') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-user-tie"></i>
                Add Business Partner
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
                @if (count($businessPartners) > 0)
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
                                @foreach ($businessPartners as $businessPartner)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $businessPartner['CardCode'] }}</td>
                                        <td>{{ $businessPartner['CardName'] }}</td>
                                        <td class="text-center">
                                            {{ $businessPartner['CardType'] == 'cCustomer' ? 'Customer' : 'Supplier' }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <a href="{{ route('business-master.show', $businessPartner['CardCode']) }}"
                                                    class="btn btn-info btn-circle btn-sm mr-1" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('business-master.edit', $businessPartner['CardCode']) }}"
                                                    class="btn btn-warning btn-circle btn-sm mr-1" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form
                                                    action="{{ route('business-master.destroy', $businessPartner['CardCode']) }}"
                                                    method="post" id="deleteForm-{{ $businessPartner['CardCode'] }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-circle btn-sm"
                                                        onclick="confirmDelete('{{ $businessPartner['CardCode'] }}')"
                                                        title="Delete">
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
                @else
                    <div class="alert alert-info">
                        No business partners found. Please add new business partners.
                    </div>
                @endif
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

        function confirmDelete(CardCode) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('deleteForm-' + CardCode).submit();
                }
            });
        }
    </script>
@endpush
