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
            <form action="{{ route('business-master.update', $BusinessPartners['CardCode']) }}" method="post"
                enctype="multipart/form-data" id="businessMasterForm">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="CardType">Choose Type</label>
                                    <select name="CardType" id="CardType" class="form-control">
                                        <option value="" disabled
                                            {{ empty($BusinessPartners['CardType']) ? 'selected' : '' }}>Choose Type
                                        </option>
                                        <option value="cCustomer"
                                            {{ $BusinessPartners['CardType'] == 'cCustomer' ? 'selected' : '' }}>Customer
                                        </option>
                                        <option value="cSupplier"
                                            {{ $BusinessPartners['CardType'] == 'cSupplier' ? 'selected' : '' }}>Vendor
                                        </option>
                                        <option value="cLead"
                                            {{ $BusinessPartners['CardType'] == 'cLead' ? 'selected' : '' }}>Lead</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="GroupCode">Card Group</label>
                                    <select name="GroupCode" id="GroupCode" class="form-control">
                                        <option value="" disabled
                                            {{ empty($BusinessPartners['GroupCode']) ? 'selected' : '' }}>Choose Group
                                        </option>
                                        @foreach ($BusinessPartnerGroups as $BusinessPartnerGroup)
                                            <option value="{{ $BusinessPartnerGroup['Code'] }}"
                                                {{ $BusinessPartners['GroupCode'] == $BusinessPartnerGroup['Code'] ? 'selected' : '' }}>
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
                                placeholder="Card Name" value="{{ $BusinessPartners['CardName'] ?? '' }}">
                        </div>
                        <div class="form-group">
                            <label for="Cellular">Mobile Phone</label>
                            <input type="number" class="form-control" name="Cellular" id="Cellular"
                                placeholder="Mobile Phone" value="{{ $BusinessPartners['Cellular'] ?? '' }}">
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="AffiliateToggle" name="Affiliate"
                                        value="{{ $BusinessPartners['Affiliate'] }}"
                                        {{ $BusinessPartners['Affiliate'] == 'tYes' ? 'checked' : '' }}">
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
                                        <option value="" disabled
                                            {{ empty($BusinessPartners['PayTermsGrpCode']) ? 'selected' : '' }}>
                                            Choose Payment Terms
                                        </option>
                                        @foreach ($PaymentTermsTypes as $PaymentTerm)
                                            <option value="{{ $PaymentTerm['GroupNumber'] }}"
                                                {{ $BusinessPartners['PayTermsGrpCode'] == $PaymentTerm['GroupNumber'] ? 'selected' : '' }}>
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
                                            placeholder="Credit Limit"
                                            value="{{ $BusinessPartners['CreditLimit'] ?? '' }}">
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
                                    placeholder="Federall Tax ID" value="{{ $BusinessPartners['FederalTaxID'] ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="SalesPersonCode">Sales</label>
                                <select name="SalesPersonCode" id="SalesPersonCode" class="form-control"
                                    {{ !auth()->user()->hasRole('Superadmin') ? 'disabled' : '' }}>
                                    @if (auth()->user()->hasRole('Superadmin'))
                                        <option value="" disabled
                                            {{ empty($BusinessPartners['SalesPersonCode']) ? 'selected' : '' }}>
                                            Choose Sales
                                        </option>
                                        @foreach ($SalesPersons as $sales)
                                            <option value="{{ $sales['SalesEmployeeCode'] }}"
                                                {{ $BusinessPartners['SalesPersonCode'] == $sales['SalesEmployeeCode'] ? 'selected' : '' }}>
                                                {{ $sales['SalesEmployeeName'] }}
                                            </option>
                                        @endforeach
                                    @else
                                        <option value="{{ $BusinessPartners['SalesPersonCode'] ?? '' }}" selected>
                                            {{ $BusinessPartners['SalesPersonName'] ?? 'Example Sales' }}
                                        </option>
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
                                        placeholder="Address">{{ $BusinessPartners['BPAddresses'][0]['Street'] ?? '' }}</textarea>
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
                                        placeholder="Address">{{ $BusinessPartners['BPAddresses'][1]['Street'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="Notes">Notes</label>
                            <textarea name="Notes" id="Notes" cols="30" rows="4" class="form-control" placeholder="Notes">
                                {{ $BusinessPartners['Notes'] ?? '' }}
                            </textarea>
                        </div>
                        <div class="form-group">
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
