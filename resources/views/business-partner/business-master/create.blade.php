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
                                    <label for="CardType">Choose Type</label>
                                    <select name="CardType" id="CardType" class="form-control">
                                        <option value="" disabled selected>Choose Type</option>
                                        <option value="cCustomer">Customer</option>
                                        <option value="cSupplier">Vendor</option>
                                        <option value="cLid">Lead</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="GroupCode">Card Group</label>
                                    <select name="GroupCode" id="GroupCode" class="form-control">
                                        <option value="" disabled selected>Choose Group</option>
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
                            <label for="Cellular">Mobile Phone</label>
                            <input type="number" class="form-control" name="Cellular" id="Cellular"
                                placeholder="Mobile Phone">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="AffiliateToggle" name="Affiliate"
                                        value="tYES">
                                    <label class="form-check-label" for="AffiliateToggle">Affiliate</label>
                                </div>
                            </div>

                            <div class="col-8">
                                <div class="form-group" id="affiliateForGroup" style="display: none;">
                                    <label for="AffiliateFor">Affiliate For</label>
                                    <select name="AffiliateFor" id="AffiliateFor" class="form-control">
                                        <option value="" disabled selected>Choose Affiliate</option>
                                        <option value="">SIMULASI 1</option>
                                        <option value="">SIMULASI 2</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="PayTermsGrpCode">Payment Terms</label>
                                    <select name="PayTermsGrpCode" class="form-control" id="PayTermsGrpCode">
                                        <option value="" disabled selected>Choose Payment Terms</option>
                                        @foreach ($PaymentTermsTypes as $PaymentTerm)
                                            <option value="{{ $PaymentTerm['GroupNumber'] }}">
                                                {{ $PaymentTerm['PaymentTermsGroupName'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="CreditLimit">Credit Limit</label>
                                    @if (auth()->user()->hasRole('Superadmin'))
                                        <input type="number" class="form-control" name="CreditLimit" id="CreditLimit"
                                            placeholder="Credit Limit">
                                    @else
                                        <input type="number" class="form-control" name="CreditLimit" id="CreditLimit"
                                            placeholder="Credit Limit" readonly>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <label for="FederalTaxID">Federall Tax ID</label>
                                <input type="number" class="form-control" name="FederalTaxID" id="FederalTaxID"
                                    placeholder="Federall Tax ID">
                            </div>
                            <div class="form-group">
                                <label for="SalesPersonCode">Sales</label>
                                <select name="SalesPersonCode" id="SalesPersonCode" class="form-control"
                                    @if (!auth()->user()->hasRole('Superadmin')) readonly @endif>
                                    @if (auth()->user()->hasRole('Superadmin'))
                                        <option value="" disabled selected>Choose Sales</option>
                                        @foreach ($SalesPersons as $sales)
                                            <option value="{{ $sales['SalesEmployeeCode'] }}">
                                                {{ $sales['SalesEmployeeName'] }}
                                            </option>
                                        @endforeach
                                    @else
                                        {{-- <option value="{{ session('SalesPersonCode') }}" selected>
                                            {{ session('SalesPersonName') }}
                                        </option> --}}
                                        <option value="" selected>Example Sales</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="text-center">
                            <i class="fas fa-arrow-right text-primary fa-3x mt-3"></i>
                        </div>
                        <div class="row">
                            <!-- Bill To -->
                            <div class="col-6">
                                <h5 class="font-weight-bold text-primary text-center">Bill To</h5>
                                <div class="form-group">
                                    <label for="StateBill">State</label>
                                    <select name="StateBill" id="StateBill" class="form-control">
                                        <option value="" disabled selected>Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="CityBill">City</label>
                                    <select name="CityBill" id="CityBill" class="form-control">
                                        <option value="" disabled selected>Choose City</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="CountyBill">County</label>
                                    <select name="CountyBill" id="CountyBill" class="form-control">
                                        <option value="" disabled selected>Choose County</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="StreetBill">Address</label>
                                    <textarea name="StreetBill" id="StreetBill" cols="30" rows="4" class="form-control"
                                        placeholder="Address"></textarea>
                                </div>
                            </div>

                            <!-- Ship To -->
                            <div class="col-6">
                                <h5 class="font-weight-bold text-primary text-center">Ship To</h5>
                                <div class="form-group">
                                    <label for="StateShip">State</label>
                                    <select name="StateShip" id="StateShip" class="form-control">
                                        <option value="" disabled selected>Choose State</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="CityShip">City</label>
                                    <select name="CityShip" id="CityShip" class="form-control">
                                        <option value="" disabled selected>Choose City</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="CountyShip">County</label>
                                    <select name="CountyShip" id="CountyShip" class="form-control">
                                        <option value="" disabled selected>Choose County</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="StreetShip">Address</label>
                                    <textarea name="StreetShip" id="StreetShip" cols="30" rows="4" class="form-control"
                                        placeholder="Address"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Notes">Notes</label>
                            <textarea name="Notes" id="Notes" cols="30" rows="4" class="form-control" placeholder="Notes"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="attachment">Attachment</label>
                            <div class="input-group">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="Attachment" name="Attachment"
                                        accept="application/pdf">
                                    <label class="custom-file-label" for="Attachment">Choose file</label>
                                </div>
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
        document.addEventListener('DOMContentLoaded', function() {

            // Toggle Affiliate
            const affiliateToggle = document.getElementById('AffiliateToggle');
            const affiliateForGroup = document.getElementById('affiliateForGroup');

            affiliateToggle.addEventListener('change', function() {
                affiliateForGroup.style.display = this.checked ? 'block' : 'none';
            });

            // Load State awal (Provinsi)
            $.getJSON('https://yooerizkilab.github.io/api-wilayah-indonesia/api/provinces.json', function(data) {
                let options = '<option value="" disabled selected>Choose State</option>';
                data.forEach(function(item) {
                    options += `<option value="${item.id}">${item.name}</option>`;
                });
                $('#StateBill, #StateShip').html(options);
            });

            // Saat StateBill dipilih, ambil CityBill
            $('#StateBill').on('change', function() {
                let provinceId = $(this).val();
                $('#CityBill').html('<option disabled selected>Loading...</option>');
                $.getJSON(
                    `https://yooerizkilab.github.io/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                    function(data) {
                        let options = '<option value="" disabled selected>Choose City</option>';
                        data.forEach(function(item) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });
                        $('#CityBill').html(options);
                        $('#CountyBill').html(
                            '<option value="" disabled selected>Choose County</option>');
                    });
            });

            // Saat CityBill dipilih, ambil CountyBill
            $('#CityBill').on('change', function() {
                let regencyId = $(this).val();
                $('#CountyBill').html('<option disabled selected>Loading...</option>');
                $.getJSON(
                    `https://yooerizkilab.github.io/api-wilayah-indonesia/api/districts/${regencyId}.json`,
                    function(data) {
                        let options = '<option value="" disabled selected>Choose County</option>';
                        data.forEach(function(item) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });
                        $('#CountyBill').html(options);
                    });
            });

            // Versi untuk StateShip → CityShip → CountyShip
            $('#StateShip').on('change', function() {
                let provinceId = $(this).val();
                $('#CityShip').html('<option disabled selected>Loading...</option>');
                $.getJSON(
                    `https://yooerizkilab.github.io/api-wilayah-indonesia/api/regencies/${provinceId}.json`,
                    function(data) {
                        let options = '<option value="" disabled selected>Choose City</option>';
                        data.forEach(function(item) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });
                        $('#CityShip').html(options);
                        $('#CountyShip').html(
                            '<option value="" disabled selected>Choose County</option>');
                    });
            });

            $('#CityShip').on('change', function() {
                let regencyId = $(this).val();
                $('#CountyShip').html('<option disabled selected>Loading...</option>');
                $.getJSON(
                    `https://yooerizkilab.github.io/api-wilayah-indonesia/api/districts/${regencyId}.json`,
                    function(data) {
                        let options = '<option value="" disabled selected>Choose County</option>';
                        data.forEach(function(item) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });
                        $('#CountyShip').html(options);
                    });
            });
        });
    </script>
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
