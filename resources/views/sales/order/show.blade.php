@extends('layouts.admin', [
    'title' => 'Show Sales Order',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">Detail Sales Order</h6>
            <a href="{{ route('sales-quotation.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <td class="font-weight-bold">Customer</td>
                            <td>: {{ $orders['CardCode'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Name</td>
                            <td>: {{ $orders['CardName'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Contact Persons</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Contact Ref. No.</td>
                            <td>: {{ $orders['NumAtCard'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Sales Persons</td>
                            <td>: {{ $salesPersons['SalesEmployeeName'] }}</td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-4 d-flex align-items-center">
                            <span class="font-weight-bold ml-2">Period No</span>
                            <span class="font-weight-bold ml-5">: {{ $orders['PeriodIndicator'] }}</span>
                        </div>
                        <div class="col-md-8">
                            <span class="font-weight-bold ml-2">Reference No.</span>
                            <span class="font-weight-bold ml-4">: {{ $orders['DocNum'] }}</span>
                        </div>
                    </div>
                    <table class="table table-borderless">
                        <tr>
                            <td class="font-weight-bold">Posting Date</td>
                            <td>: {{ $orders['DocDate'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Due Date</td>
                            <td>: {{ $orders['DocDueDate'] }}</td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Document Status</td>
                            <td>
                                : <span
                                    class="badge {{ $orders['DocumentStatus'] == 'bost_Open' ? 'bg-warning text-white' : 'bg-success text-white' }}">
                                    {{ $orders['DocumentStatus'] == 'bost_Open' ? 'Open' : 'Close' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="font-weight-bold">Document Type</td>
                            <td>
                                : <span
                                    class="badge {{ $orders['DocType'] == 'dDocument_Items' ? 'bg-secondary text-white' : 'bg-primary text-white' }}">
                                    {{ $orders['DocType'] == 'dDocument_Items' ? 'Item' : 'Service' }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-12">
                    <div class="form-group mb-3">
                        <label for="Remarks" class="font-weight-bold">Remarks</label>
                        <p>{{ $orders['Comments'] }}</p>
                    </div>
                    <div class="form-group">
                        <label for="Attachment" class="font-weight-bold">Attachment</label>
                    </div>
                </div>
            </div>

            <hr>

            <div class="row">
                <div class="col-md-12">
                    @if ($orders['DocType'] == 'dDocument_Items')
                        <h5 class="font-weight-bold text-primary text-center">Items</h5>
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered table-hover table-sm" id="itemsTable" width="100%"
                                cellspacing="0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>Item Code</th>
                                        <th>Item Name</th>
                                        <th width="5%">Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Gross Price</th>
                                        <th>Warehouse</th>
                                        <th>Total (LC)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders['DocumentLines'] as $item)
                                        <tr>
                                            <td>{{ $item['ItemCode'] }}</td>
                                            <td>{{ $item['ItemDescription'] }}</td>
                                            <td class="text-center">{{ $item['Quantity'] }}</td>
                                            <td>Rp {{ number_format($item['UnitPrice'], 2) }}</td>
                                            <td>Rp {{ number_format($item['GrossPrice'], 2) }}</td>
                                            <td>{{ $item['WarehouseCode'] }}</td>
                                            <td>Rp {{ number_format($item['LineTotal'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-right">
                                        <td colspan="6"><b>Sub Total</b></td>
                                        <td><b id="SubTotal">Rp
                                                {{ number_format(array_sum(array_column($orders['DocumentLines'], 'LineTotal')), 2) }}</b>
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="6"><b>Tax</b></td>
                                        <td><b id="Tax">Rp {{ number_format($orders['VatSum'], 2) }}</b></td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="6"><b>Grand Total</b></td>
                                        <td><b id="GrandTotal">Rp {{ number_format($orders['DocTotal'], 2) }}</b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                    @if ($orders['DocType'] == 'dDocument_Service')
                        <h5 class="font-weight-bold text-primary text-center">Services</h5>
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table class="table table-bordered table-hover table-sm" id="servicesTable" width="100%"
                                cellspacing="0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>Description</th>
                                        <th>G/L Account</th>
                                        <th>G/L Account Name</th>
                                        <th>Project</th>
                                        <th width="5%">Qty Services</th>
                                        <th width="5%">UoM Services</th>
                                        <th>Unit Price</th>
                                        <th>Set Price</th>
                                        <th>Total (LC)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders['DocumentLines'] as $service)
                                        <tr>
                                            <td>{{ $service['ItemDescription'] }}</td>
                                            <td>{{ $chartOfAccounts[0]['Code'] }}</td>
                                            <td>{{ $chartOfAccounts[0]['Name'] }}</td>
                                            <td>{{ $service['ProjectCode'] }}</td>
                                            <td class="text-center">{{ $service['U_HR_QtyFisik'] }}</td>
                                            <td class="text-center">{{ $service['U_HR_UoMSvc'] }}</td>
                                            <td>Rp {{ number_format($service['U_HR_HrgSat'], 2) }}</td>
                                            <td>Rp {{ number_format($service['U_HR_HrgPsg'], 2) }}</td>
                                            <td>Rp {{ number_format($service['LineTotal'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="text-right">
                                        <td colspan="8"><b>Sub Total</b></td>
                                        <td><b id="SubTotal">Rp
                                                {{ number_format(array_sum(array_column($orders['DocumentLines'], 'LineTotal')), 2) }}</b>
                                        </td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="8"><b>Tax</b></td>
                                        <td><b id="Tax">Rp {{ number_format($orders['VatSum'], 2) }}</b></td>
                                    </tr>
                                    <tr class="text-right">
                                        <td colspan="8"><b>Grand Total</b></td>
                                        <td><b id="GrandTotal">Rp {{ number_format($orders['DocTotal'], 2) }}</b></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
