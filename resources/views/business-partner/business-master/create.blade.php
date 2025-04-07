@extends('layouts.admin', [
    'title' => 'Create Bussines Partners Master',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">Create Bussines Master</h6>
            <a href="{{ route('business-master.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('business-master.store') }}" method="post" enctype="multipart/form-data"
                id="businessMasterForm">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="CardType">Card Type</label>
                                    <select name="CardType" id="CardType" class="form-control">
                                        <option value="C">Customer</option>
                                        <option value="S">Supplier</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="CardGroup">Card Group</label>
                                    <select name="CardGroup" id="CardGroup" class="form-control">
                                        <option value="" disabled selected>Choose Card Group</option>
                                        @foreach ($BusinessPartnerGroups as $BusinessPartnerGroup)
                                            <option value="{{ $BusinessPartnerGroup['Code'] }}">
                                                {{ $BusinessPartnerGroup['Name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CardName">Card Name</label>
                            <input type="text" class="form-control" name="CardName" id="CardName"
                                placeholder="Card Name">
                        </div>
                        <div class="form-group">
                            <label for="FederalTaxID">Federall Tax ID</label>
                            <input type="number" class="form-control" name="FederalTaxID" id="FederalTaxID"
                                placeholder="Federall Tax ID">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="SalesPersonCode">Sales</label>
                            <select name="SalesPersonCode" id="SalesPersonCode" class="form-control">
                                <option value="" disabled selected>Choose Sales</option>
                            </select>
                        </div>
                        <p class="">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Quidem voluptatem perspiciatis fuga
                            magnam temporibus! Modi ea quos unde sed maxime, fugit, blanditiis accusantium vitae nam
                            distinctio mollitia, corrupti expedita reprehenderit.
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <ul class="nav nav-tabs" id="businessPartnerTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general"
                                    role="tab">General</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact"
                                    role="tab">Contacts Persons</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="businessPartnerTabContent">

                            <!-- General -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel">
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="confirmAddBusinessMaster()">
                    <i class="fas fa-save"></i>
                    Save Bussines Master
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmAddBusinessMaster() {
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
