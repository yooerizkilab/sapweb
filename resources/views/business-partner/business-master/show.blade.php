@extends('layouts.admin', [
    'title' => 'Bussines Partners Master'
])

@push('css')
    
@endpush

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="m-0 font-weight-bold text-primary">Detail Bussines Master</h4>
        <a href="{{ route('business-master.create') }}" class="btn btn-primary btn-md mr-2">
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
                        <td>: {{ $businessGroups['Name'] }}</td>
                    </tr>
                    <tr>
                        <td>Curency</td>
                        <td>: {{ $businessPartners['Currency'] }}</td>
                    </tr>
                    <tr>
                        <td>Federal Tax ID</td>
                        <td>: {{ $businessPartners['FederalTaxID'] }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h5 class="font-weight-bold text-primary">Accounting Informastion</h5>
                <table class="table table-borderless">
                    <tr>
                        <td>Account Balance</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Deliveries</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Orders</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Opportunities</td>
                        <td>: </td>
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
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="row">
                            <h5 class="font-weight-bold text-primary">General Informastion</h5>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel">
                        
                    </div>
                    <div class="tab-pane fade" id="addresess" role="tabpanel">
                        
                    </div>
                    <div class="tab-pane fade" id="payment" role="tabpanel">
                        
                    </div>
                    <div class="tab-pane fade" id="payment-run" role="tabpanel">
                        
                    </div>
                    <div class="tab-pane fade" id="accounting" role="tabpanel">
                        
                    </div>
                    <div class="tab-pane fade" id="propertiess" role="tabpanel">
                        
                    </div>
                    <div class="tab-pane fade" id="remarks" role="tabpanel">
                        
                    </div>
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