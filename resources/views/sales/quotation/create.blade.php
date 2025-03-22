@extends('layouts.admin', [
    'title' => 'Create Sales Quotation',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">Add Sales Quotation</h6>
            <a href="{{ route('sales-quotation.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('sales-quotation.store') }}" method="POST" enctype="multipart/form-data"
                id="salesQuotationForm">
                @csrf
                <input type="hidden" name="DocType" id="DocType">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="CardCode">Customers Code</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Customer Code" name="CardCode"
                                    id="CardCode" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#customerModal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="CardName">Customer Name</label>
                            <input type="text" class="form-control" name="CardName" id="CardName"
                                placeholder="Customer Name" readonly>
                        </div>
                        <div class="form-group">
                            <label for="NumAtCard">Customers Ref. No.</label>
                            <input type="text" class="form-control" name="NumAtCard" id="NumAtCard"
                                placeholder="Customers Ref. No.">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" name="DocDate" id="DocDate"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="date">Doc Due Date</label>
                            <input type="date" class="form-control" name="DocDate" id="DocDueDate"
                                value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="SalesPersonCode">Sales Person</label>
                            <input type="text" class="form-control" name="SalesPersonCode" id="SalesPersonCode"
                                value="{{ Auth::user()->full_name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="Remarks">Remarks</label>
                            <textarea class="form-control" name="Remarks" id="Remarks" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="Attachment">Attachment</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="Attachment" name="Attachment"
                                        accept="application/pdf">
                                    <label class="custom-file-label" for="Attachment">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-file-upload"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <ul class="nav nav-tabs" id="quotationTabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" id="items-tab" data-toggle="tab" href="#items" role="tab">Items</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="services-tab" data-toggle="tab" href="#services"
                            role="tab">Services</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="quotationTabsContent">
                    <div class="tab-pane fade show" id="items" role="tabpanel">
                        <div class="d-flex justify-content-end align-items-center flex-wrap mb-2">
                            <button type="button" class="btn btn-primary" onclick="addItemRow()">
                                <i class="fas fa-cart-plus"></i> Add Item
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="itemsTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>Item Code</th>
                                        <th>Description</th>
                                        <th width="10%">Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Warehouse</th>
                                        <th>Total</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr class="text-right">
                                        <th colspan="5" class="text-right">Total</th>
                                        <th><span id="total_item" class="text-right"></span></th>
                                    </tr>
                                    <tr class="text-right">
                                        <th colspan="4" class="text-right">Discount %</th>
                                        <th class="text-right" width="10%"><input type="number"
                                                class="form-control text-right discount-input-item"
                                                name="DiscountPercent_Item"></th>
                                        <th><span id="discount_amount_item" class="text-right"></span></th>
                                    </tr>
                                    <tr class="text-right">
                                        <th colspan="5" class="text-right">Grand Total</th>
                                        <th><span id="grand_total_item" class="text-right"></span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="services" role="tabpanel">
                        <div class="d-flex justify-content-end align-items-center flex-wrap mb-2">
                            <button type="button" class="btn btn-primary" onclick="addServiceRow()">
                                <i class="fas fa-cart-plus"></i> Add Service
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="servicesTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th>Description</th>
                                        <th>G/L Account</th>
                                        <th>G/L Account Name</th>
                                        <th>Project</th>
                                        <th width="10%">Qty Services</th>
                                        <th width="10%">UoM Services</th>
                                        <th>Unit Price</th>
                                        <th>Set Price</th>
                                        <th>Total</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr class="text-right">
                                        <th colspan="8" class="text-right">Total</th>
                                        <th><span id="total_service" class="text-right"></span></th>
                                    </tr>
                                    <tr class="text-right">
                                        <th colspan="7" class="text-right">Discount %</th>
                                        <th class="text-right" width="10%"><input type="number"
                                                class="form-control text-right discount-input-service"
                                                name="DiscountPercent_Servis"></th>
                                        <th><span id="discount_amount_service" class="text-right"></span></th>
                                    </tr>
                                    <tr class="text-right">
                                        <th colspan="8" class="text-right">Grand Total</th>
                                        <th><span id="grand_total_service" class="text-right"></span></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="confirmAddSalesQuotation()">
                    <i class="fas fa-save"></i>
                    Save Sales Quotation
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Customer -->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Customer</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="customerTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businessPartners as $businessPartner)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $businessPartner['CardCode'] }}</td>
                                        <td>{{ $businessPartner['CardName'] }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-primary btn-circle btn-sm"
                                                    onclick="selectCustomer('{{ $businessPartner['CardCode'] }}', '{{ $businessPartner['CardName'] }}')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Item -->
    <div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Item</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Price 1</th>
                                    <th>Price 2</th>
                                    <th>Price 3</th>
                                    <th>Price HET</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($itemPrice as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item['itemCode'] }}</td>
                                        <td>{{ $item['itemName'] }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary"
                                                onclick="selectItem('{{ $item['itemCode'] }}', '{{ $item['itemName'] }}', '{{ $item['price1'] }}', '{{ $item['harga1'] }}')">
                                                {{ $item['price1'] }}
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary"
                                                onclick="selectItem('{{ $item['itemCode'] }}', '{{ $item['itemName'] }}', '{{ $item['price2'] }}', '{{ $item['harga2'] }}')">
                                                {{ $item['price2'] }}
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary"
                                                onclick="selectItem('{{ $item['itemCode'] }}', '{{ $item['itemName'] }}', '{{ $item['price3'] }}', '{{ $item['harga3'] }}')">
                                                {{ $item['price3'] }}
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-primary"
                                                onclick="selectItem('{{ $item['itemCode'] }}', '{{ $item['itemName'] }}', '{{ $item['pricehet'] }}', '{{ $item['hargahet'] }}')">
                                                {{ $item['pricehet'] }}
                                            </button>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Warehouse -->
    <div class="modal fade" id="warehouseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Warehouse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="warehouseTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="10%">Code</th>
                                    <th>Name</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($warehouses as $warehouse)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $warehouse['WarehouseCode'] }}</td>
                                        <td>{{ $warehouse['WarehouseName'] }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-primary btn-circle btn-sm"
                                                    onclick="selectWarehouse('{{ $warehouse['WarehouseCode'] }}')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal GLaccount -->
    <div class="modal fade" id="glaccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select GL Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="glaccountTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="15%">Code</th>
                                    <th>Name</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($chartOfAccounts as $chartOfAccount)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $chartOfAccount['Code'] }}</td>
                                        <td>{{ $chartOfAccount['Name'] }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-primary btn-circle btn-sm"
                                                    onclick="selectGLAccount('{{ $chartOfAccount['Code'] }}', '{{ $chartOfAccount['Name'] }}')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Project -->
    <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="projectTable" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="5%">No</th>
                                    <th width="15%">Code</th>
                                    <th>Name</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $project)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $project['Code'] }}</td>
                                        <td>{{ $project['Name'] }}</td>
                                        <td class="text-center">
                                            <div class="d-inline-flex">
                                                <button type="button" class="btn btn-primary btn-circle btn-sm"
                                                    onclick="selectProject('{{ $project['Code'] }}')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const itemsTab = document.getElementById('items-tab');
            const servicesTab = document.getElementById('services-tab');
            const inputType = document.getElementById('DocType');

            itemsTab.addEventListener('click', function() {
                inputType.value = 'dDocument_Items';
            })

            servicesTab.addEventListener('click', function() {
                inputType.value = 'dDocument_Services';
            })

            // Inisialisasi DataTable untuk semua tabel
            $('#customerTable, #itemTable, #warehouseTable, #glaccountTable, #projectTable').DataTable();

            // Fix width DataTable di modal
            $('#customerModal, #itemModal, #warehouseModal, #glaccountModal, #projectModal').on('shown.bs.modal',
                adjustDataTable);

            // Event listener untuk tombol "Add Item"
            function addItemRow() {
                var countRows = $('#itemsTable tbody tr').length;
                $('#itemsTable tbody').append(`
                    <tr>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control ItemCode" name="DocumentLines[${countRows}][ItemCode]" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#itemModal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td><input type="text" class="form-control ItemName" name="DocumentLines[${countRows}][ItemName]" readonly></td>
                        <td><input type="number" class="form-control Quantity" name="DocumentLines[${countRows}][Quantity]"></td>
                        <td><input type="number" class="form-control UnitPrice" name="DocumentLines[${countRows}][UnitPrice]"></td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control WarehouseCode" name="DocumentLines[${countRows}][WarehouseCode]" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#warehouseModal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td class="text-right total-price TotalPrice">0</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
                calculateTotals();
            }

            // Event listener untuk tombol "Add Services"
            function addServiceRow() {
                var countRows = $('#servicesTable tbody tr').length;
                $('#servicesTable tbody').append(`
                    <tr>
                        <td><input type="text" class="form-control" name="DocumentLines[${countRows}][Description]"></td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" name="DocumentLines[${countRows}][GLAccountCode]" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#glaccountModal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td><input type="text" class="form-control" name="DocumentLines[${countRows}][GLAccountName]" readonly></td>
                        <td>
                            <div class="input-group">
                                <input type="text" class="form-control" name="DocumentLines[${countRows}][ProjectCode]" readonly>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#projectModal">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        <td><input type="number" class="form-control" name="DocumentLines[${countRows}][Quantity]"></td>
                        <td>
                            <select class="form-control" name="DocumentLines[${countRows}][Unit]">
                                <option value="" disabled selected>Choose Unit</option>
                            </select>
                        </td>
                        <td><input type="number" class="form-control" name="DocumentLines[${countRows}][UnitPrice]"></td>
                        <td><input type="number" class="form-control" name="DocumentLines[${countRows}][SetPrice]"></td>
                        <td class="text-right total-price-service">0</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm remove-service">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `);
                calculateTotals();
            }

            // Event listener untuk tombol "Remove Item"
            $('#itemsTable tbody').on('click', '.remove-item', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            // Event listener untuk tombol "Remove Service"
            $('#servicesTable tbody').on('click', '.remove-service', function() {
                $(this).closest('tr').remove();
                calculateTotals();
            });

            // Fungsi untuk menghitung total harga per baris (Items)
            function calculateItemRowTotal(row) {
                var quantity = parseFloat(row.find('.Quantity').val()) || 0;
                var unitPrice = parseFloat(row.find('.UnitPrice').val()) || 0;
                var rowTotal = quantity * unitPrice;
                row.find('.TotalPrice').text(rowTotal.toFixed(2));
                return rowTotal;
            }

            // Fungsi untuk menghitung total harga per baris (Services)
            function calculateServiceRowTotal(row) {
                var quantity = parseFloat(row.find('[name$="[Quantity]"]').val()) || 0;
                var unitPrice = parseFloat(row.find('[name$="[UnitPrice]"]').val()) || 0;
                var setPrice = parseFloat(row.find('[name$="[SetPrice]"]').val()) || 0;
                var rowTotal = quantity * unitPrice + setPrice;
                row.find('.total-price-service').text(rowTotal.toFixed(2));
                return rowTotal;
            }

            // Fungsi untuk menghitung total keseluruhan, diskon, dan grand total
            function calculateTotals() {
                var itemsTotal = 0;
                var servicesTotal = 0;

                $('#itemsTable tbody tr').each(function() {
                    itemsTotal += calculateItemRowTotal($(this));
                });

                $('#servicesTable tbody tr').each(function() {
                    servicesTotal += calculateServiceRowTotal($(this));
                });

                // Hitung total item
                $('#total_item').text(itemsTotal.toFixed(2));

                // Hitung diskon item
                var discountItemPercentage = parseFloat($('.discount-input-item').val()) || 0;
                var discountItemAmount = (itemsTotal * discountItemPercentage) / 100;
                $('#discount_amount_item').text(discountItemAmount.toFixed(2));

                // Hitung grand total item
                var grandTotalItem = itemsTotal - discountItemAmount;
                $('#grand_total_item').text(grandTotalItem.toFixed(2));

                // Hitung total service
                $('#total_service').text(servicesTotal.toFixed(2));

                // Hitung diskon service
                var discountServicePercentage = parseFloat($('.discount-input-service').val()) || 0;
                var discountServiceAmount = (servicesTotal * discountServicePercentage) / 100;
                $('#discount_amount_service').text(discountServiceAmount.toFixed(2));

                // Hitung grand total service
                var grandTotalService = servicesTotal - discountServiceAmount;
                $('#grand_total_service').text(grandTotalService.toFixed(2));
            }

            // Event listener untuk perubahan kuantitas dan harga satuan (Items)
            $('#itemsTable tbody').on('input', '.Quantity, .UnitPrice', function() {
                calculateItemRowTotal($(this).closest('tr'));
                calculateTotals();
            });

            // Event listener untuk perubahan kuantitas, harga satuan, dan set price (Services)
            $('#servicesTable tbody').on('input',
                '[name$="[Quantity]"], [name$="[UnitPrice]"], [name$="[SetPrice]"]',
                function() {
                    calculateServiceRowTotal($(this).closest('tr'));
                    calculateTotals();
                });


            // Event listener untuk perubahan diskon item
            $('.discount-input-item').on('input', function() {
                calculateTotals();
            });

            // Event listener untuk perubahan diskon service
            $('.discount-input-service').on('input', function() {
                calculateTotals();
            });

            window.addItemRow = addItemRow;
            window.addServiceRow = addServiceRow;

        });

        function selectCustomer(code, name) {
            $('#customerModal').modal('hide');

            // Masukkan ke form input
            $('#CardCode').val(code);
            $('#CardName').val(name);
        }

        function selectItem(code, name) {
            $('#itemModal').modal('hide');

            // Cari input dalam baris item terakhir yang ditambahkan
            let lastRow = $('#itemsTable tbody tr:last-child');
            lastRow.find('input[id="ItemCode"]').val(code);
            lastRow.find('input[id="ItemName"]').val(name);
        }

        function selectWarehouse(code) {
            $('#warehouseModal').modal('hide');

            // Cari input dalam baris warehouse terakhir yang ditambahkan
            let lastRow = $('#itemsTable tbody tr:last-child');
            lastRow.find('input[id="WarehouseCode"]').val(code);
        }

        function selectGLAccount(code, name) {
            $('#glaccountModal').modal('hide');

            // Cari input dalam baris GL Account terakhir yang ditambahkan
            let lastRow = $('#servicesTable tbody tr:last-child');
            lastRow.find('input[id="GLAccountCode"]').val(code);
            lastRow.find('input[id="GLAccountName"]').val(name);
        }

        function selectProject(code) {
            $('#projectModal').modal('hide');

            // Cari input dalam baris project terakhir yang ditambahkan
            let lastRow = $('#servicesTable tbody tr:last-child');
            lastRow.find('input[id="ProjectCode"]').val(code);
        }

        function confirmAddSalesQuotation() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, add it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#salesQuotationForm').submit();
                }
            });
        }
    </script>
@endpush
