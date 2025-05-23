@extends('layouts.admin', [
    'title' => 'Bussines Partners Master'
])

@push('css')
    
@endpush

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">Detail Bussines Master</h6>
        <a href="{{ route('business-master.index') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-reply"></i> 
            Back
        </a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="font-weight-bold text-primary">Customers Informastion</h5>
                <table class="table table-borderless">
                    <tr>
                        <td>Code</td>
                        <td>: {{ $businessPartners['CardCode'] }}</td>
                    </tr>
                    <tr>
                        <td>Name</td>
                        <td>: {{ $businessPartners['CardName'] }}</td>
                    </tr>
                    <tr>
                        <td>Foreign Name</td>
                        <td>: {{ $businessPartners['CardForeignName'] ?? ' ' }}</td>
                    </tr>
                    <tr>
                        <td>Group</td>
                        <td>: {{ $businessGroups['Name'] ?? ' ' }}</td>
                    </tr>
                    <tr>
                        <td>Curency</td>
                        <td>: {{ $businessPartners['Currency'] ?? ' ' }}</td>
                    </tr>
                    <tr>
                        <td>Federal Tax ID</td>
                        <td>: {{ $businessPartners['FederalTaxID'] ?? ' ' }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5 class="font-weight-bold text-primary">Accounting Informastion</h5>
                <table class="table table-borderless">
                    <tr>
                        <td>Account Balance</td>
                        <td>: Rp {{ number_format($businessPartners['CurrentAccountBalance'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Deliveries</td>
                        <td>: Rp {{ number_format($businessPartners['OpenDeliveryNotesBalance'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Orders</td>
                        <td>: Rp {{ number_format($businessPartners['OpenOrdersBalance'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Opportunities</td>
                        <td>: {{ $businessPartners['OpenOpportunities'] ?? ' ' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs" id="businessPartnerTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab">Contacts Persons</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="addresess-tab" data-toggle="tab" href="#addresess" role="tab">Addresess</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab">Payment Terms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="payment-run-tab" data-toggle="tab" href="#payment-run" role="tab">Payment Run</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="accounting-tab" data-toggle="tab" href="#accounting" role="tab">Accounting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="propertiess-tab" data-toggle="tab" href="#propertiess" role="tab">Propertiess</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="remarks-tab" data-toggle="tab" href="#remarks" role="tab">Remarks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="attachments-tab" data-toggle="tab" href="#attachments" role="tab">Attachments</a>
                    </li>
                </ul>
                <div class="tab-content" id="businessPartnerTabContent">
                    
                    <!-- General -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5 class="font-weight-bold text-primary text-center">General Information</h5>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Tel 1</td>
                                        <td>: {{ $businessPartners['Phone1'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tel 2</td>
                                        <td>: {{ $businessPartners['Phone2'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Mobile Phone</td>
                                        <td>: {{ $businessPartners['Cellular'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Fax</td>
                                        <td>: {{ $businessPartners['Fax'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>E-Mail</td>
                                        <td>: {{ $businessPartners['E_Mail'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Website</td>
                                        <td>: {{ $businessPartners['WebSite'] ?? ' ' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Contact Person</td>
                                        <td>: {{ $businessPartners['ContactPerson'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Unifiled Tax ID</td>
                                        <td>: {{ $businessPartners['UnifiedFederalTaxID'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Remarks</td>
                                        <td>: {{ $businessPartners['Notes'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sales Employee</td>
                                        <td>: {{ $businessSales['SalesEmployeeName'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Sales Phone</td>
                                        <td>: {{ $businessSales['Telephone'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>: {!! isset($businessPartners['ContactEmployees'][0]['Active']) && $businessPartners['ContactEmployees'][0]['Active'] == 'tYES' 
                                            ? '<span class="badge badge-success">Active</span>' 
                                            : '<span class="badge badge-danger">Inactive</span>' !!}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5 class="font-weight-bold text-primary text-center">Contact Information</h5>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Contact ID</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>First Name</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Middle Name</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Job Title</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Address</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>City</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>State</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Country</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Postal Code</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>MobilePhone</td>
                                        <td>: </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Addresses -->
                    <div class="tab-pane fade" id="addresess" role="tabpanel">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5 class="font-weight-bold text-primary text-center">Addresses Information</h5>
                            </div>

                            @foreach ($businessPartners['BPAddresses'] ?? [] as $index => $address)
                                <div class="col-md-5">
                                    <h5 class="font-weight-bold text-primary text-center">{{ $address['AddressName'] }}</h5>
                                    <table class="table table-borderless">
                                        <tr>
                                            <td>Country</td>
                                            <td>: {{ $countries['Name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>State</td>
                                            <td>: {{ $states['Name'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>: {{ $address['City'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>County</td>
                                            <td>: {{ $address['County'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Street</td>
                                            <td>: {{ $address['Street'] }}</td>
                                        </tr>
                                    </table>
                                </div>

                                @if ($index == 0 && count($businessPartners['BPAddresses'] ?? []) > 1)
                                    <div class="col-md-2 text-center">
                                        <i class="fas fa-arrow-right text-primary fa-3x"></i>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    <!-- Payment Terms -->
                    <div class="tab-pane fade" id="payment" role="tabpanel">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5 class="font-weight-bold text-primary text-center">Payment Terms Information</h5>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Payment Terms</td>
                                        <td>: {{ $businessPaymentTermsTypes['PaymentTermsGroupName'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Price Mode</td>
                                        <td>: {{ $businessPartners['PriceMode'] == 'pmNet' ? 'Net' : 'Gross' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Price List</td>
                                        <td>: {{ $businessPartners['PriceListNum'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Total Discount%</td>
                                        <td>: {{ $businessPartners['DiscountPercent'] ?? ' ' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Credit Limit</td>
                                        <td>: Rp {{ number_format($businessPartners['CreditLimit'], 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Commitment Limit</td>
                                        <td>: Rp {{ number_format($businessPartners['MaxCommitment'], 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Credit Card Type</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Credit Card No</td>
                                        <td>: </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Run -->
                    <div class="tab-pane fade" id="payment-run" role="tabpanel">
                        
                    </div>

                    <!-- Accounting -->
                    <div class="tab-pane fade" id="accounting" role="tabpanel">
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5 class="font-weight-bold text-primary text-center">Accounting Information</h5>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Payment Consolidation</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Account Receivable</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Down Payment Clearing Account</td>
                                        <td>: </td>
                                    </tr>
                                    <tr>
                                        <td>Afiliate</td>
                                        <td>: </td>
                                    </tr>
                                </table>
                            </div>
                        </div>  
                    </div>

                    <!-- Properties -->
                    <div class="tab-pane fade" id="propertiess" role="tabpanel">
                        
                    </div>

                    <!-- Remarks -->
                    <div class="tab-pane fade" id="remarks" role="tabpanel">
                        
                    </div>

                    <!-- Attachments -->
                    <div class="tab-pane fade" id="attachments" role="tabpanel">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    
@endpush