@extends('layouts.admin', [
    'title' => 'Update Bussines Partners Master',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">Update Bussines Master</h6>
            <a href="{{ route('business-master.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('business-master.update', $businessPartners['CardCode']) }}" method="post"
                enctype="multipart/form-data" id="businessMasterForm">
                @csrf
                @method('PUT')
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="confirmUpdateBusinessMaster()">
                    <i class="fas fa-save"></i>
                    Update Bussines Master
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmUpdateBusinessMaster() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#businessMasterForm').submit();
                }
            });
        }
    </script>
@endpush
