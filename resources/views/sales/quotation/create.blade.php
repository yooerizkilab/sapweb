@extends('layouts.admin', [
    'title' => 'Create Sales Quotation'
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
        <form action="{{ route('sales-quotation.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="CardCode">Customers Code</label>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Customer Code" name="CardCode" id="CardCode" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customerModal">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="CardName">Customer Name</label>
                        <input type="text" class="form-control" name="CardName" id="CardName" placeholder="Customer Name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="NumAtCard">Customers Ref. No.</label>
                        <input type="text" class="form-control" name="NumAtCard" id="NumAtCard" placeholder="Customers Ref. No.">
                    </div>
                </div>                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" class="form-control" name="DocDate" id="DocDate" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="date">Doc Due Date</label>
                        <input type="date" class="form-control" name="DocDate" id="DocDueDate" value="{{ date('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="SalesPersonCode">Sales Person</label>
                        <input type="text" class="form-control" name="SalesPersonCode" id="SalesPersonCode" value="{{ Auth::user()->full_name }}" readonly>
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
                                <input type="file" class="custom-file-input" id="Attachment" name="Attachment" accept="application/pdf">
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
                    <a class="nav-link" id="services-tab" data-toggle="tab" href="#services" role="tab">Services</a>
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
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="text-right">
                                    <th colspan="5" class="text-right">Total</th>
                                    <th>
                                        <input type="text" class="form-control text-right" name="total" id="total" readonly>
                                    </th>
                                </tr>
                                <tr class="text-right">
                                    <th colspan="4" class="text-right">Discount %</th>
                                    <th class="text-right" width="10%">
                                        <input type="number" class="form-control text-right" name="discount" id="discount">
                                    </th>
                                    <th>
                                        <input type="text" class="form-control text-right" name="discount_amount" id="discount_amount" readonly>
                                    </th>
                                </tr>
                                <tr class="text-right">
                                    <th colspan="5" class="text-right">Grand Total</th>
                                    <th>
                                        <input type="text" class="form-control text-right" name="grand_total" id="grand_total" readonly>
                                    </th>
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
                            <tbody>
                            </tbody>
                            <tfoot>
                                <tr class="text-right">
                                    <th colspan="8" class="text-right">Total</th>
                                    <th>
                                        <input type="text" class="form-control text-right" name="total" id="total" readonly>
                                    </th>
                                </tr>
                                <tr class="text-right">
                                    <th colspan="7" class="text-right">Discount %</th>
                                    <th class="text-right" width="10%">
                                        <input type="number" class="form-control text-right" name="discount" id="discount">
                                    </th>
                                    <th>
                                        <input type="text" class="form-control text-right" name="discount_amount" id="discount_amount" readonly>
                                    </th>
                                </tr>
                                <tr class="text-right">
                                    <th colspan="8" class="text-right">Grand Total</th>
                                    <th>
                                        <input type="text" class="form-control text-right" name="grand_total" id="grand_total" readonly>
                                    </th>
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
            <button type="button" class="btn btn-primary">
                <i class="fas fa-save"></i>
                Save
            </button>
        </div>
    </div>
</div>

<!-- Modal Customer -->
<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="selectCustomer('{{ $businessPartner['CardCode'] }}', '{{ $businessPartner['CardName'] }}')">
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
<div class="modal fade" id="itemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item['ItemCode'] }}</td>
                                    <td>{{ $item['ItemName'] }}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex">
                                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="selectItem('{{ $item['ItemCode'] }}', '{{ $item['ItemName'] }}')">
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

<!-- Modal Warehouse -->
<div class="modal fade" id="warehouseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="selectWarehouse('{{ $warehouse['WarehouseCode'] }}', '{{ $warehouse['WarehouseName'] }}')">
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
<div class="modal fade" id="glaccountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="selectGLAccount('{{ $chartOfAccount['Code'] }}', '{{ $chartOfAccount['Name'] }}')">
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
<div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                            <button type="button" class="btn btn-primary btn-circle btn-sm" onclick="selectProject('{{ $project['Code'] }}', '{{ $project['Name'] }}')">
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

        // Inisialisasi DataTable untuk semua tabel
        $('#customerTable, #itemTable, #warehouseTable, #glaccountTable, #projectTable').DataTable();

        // Fix width DataTable di modal
        $('#customerModal').on('shown.bs.modal', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('#itemModal').on('shown.bs.modal', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('#warehouseModal').on('shown.bs.modal', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('#glaccountModal').on('shown.bs.modal', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        $('#projectModal').on('shown.bs.modal', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

        function selectCustomer(code, name) {
            $('#CustomerCode').val(code);
            $('#CustomerName').val(name);
            $('#customerModal').modal('hide');

            // Masukkan ke inputan Card Code dan Card Name
            $('#CardCode').val(code);
            $('#CardName').val(name);
        }

        // Event listener untuk tombol "Add Item"
        $('#items .btn-primary').click(function() {
            var countRows = $('#itemsTable tbody tr').length;
            $('#itemsTable tbody').append(`
                <tr>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" id="ItemCode" name="DocumentLines[${countRows}][ItemCode]" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#itemModal">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td><input type="text" class="form-control" id="ItemName" name="DocumentLines[${countRows}][ItemName]" readonly></td>
                    <td><input type="number" class="form-control" name="DocumentLines[${countRows}][Quantity]"></td>
                    <td><input type="number" class="form-control" id="UnitPrice" name="DocumentLines[${countRows}][UnitPrice]"></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" id="warehouse" name="DocumentLines[${countRows}][WarehouseCode]" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#warehouseModal">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td class="text-right total-price" id="TotalPrice" name="DocumentLines[${countRows}][TotalPrice]">0</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-circle remove-item">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });

        // Event listener untuk tombol "Add Services"
        $('#services .btn-primary').click(function() {
            var countRows = $('#servicesTable tbody tr').length;
            $('#servicesTable tbody').append(`
                <tr>
                    <td><input type="text" class="form-control" name="DocumentLines[${countRows}][Description]" id="Description"></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" name="DocumentLines[${countRows}][GLAccountCode]" id="GLAccountCode" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#glaccountModal">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td><input type="text" class="form-control" id="GLAccountName" name="DocumentLines[${countRows}][GLAccountName]" readonly></td>
                    <td>
                        <div class="input-group">
                            <input type="text" class="form-control" name="DocumentLines[${countRows}][WarehouseCode]" id="warehouse" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#warehouseModal">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </td>
                    <td><input type="number" class="form-control" name="DocumentLines[${countRows}][Quantity]" id="Quantity"></td>
                    <td>
                        <select class="form-control" name="DocumentLines[${countRows}][Unit]" id="Unit">
                            <option value="" disabled selected>Choose Unit</option>
                            @foreach ($unitOfMeasures as $unitOfMeasure)
                                <option value="{{ $unitOfMeasure['Code'] }}">{{ $unitOfMeasure['Name'] }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" class="form-control" name="DocumentLines[${countRows}][UnitPrice]" id="UnitPrice"></td>
                    <td><input type="number" class="form-control" name="DocumentLines[${countRows}][SetPrice]" id="SetPrice"></td>
                    <td class="text-right total-price-service" name="DocumentLines[${countRows}][TotalPrice]" id="TotalPriceService">0</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-circle remove-service">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `);
        });

        // Event listener untuk menghitung total harga setiap kali quantity atau price diubah (Items)
        $('#itemsTable tbody').on('input', '.quantity, .price', function() {
            updateTotalPrice('#itemsTable', '.quantity', '.price', '.total-price', '#total', '#discount', '#discount_amount', '#grand_total');
        });

        // Event listener untuk menghitung total harga setiap kali quantity atau price diubah (Services)
        $('#servicesTable tbody').on('input', '.quantity-service, .price-service', function() {
            updateTotalPrice('#servicesTable', '.quantity-service', '.price-service', '.total-price-service', '#total', '#discount', '#discount_amount', '#grand_total');
        });

        // Event listener untuk menghapus baris item
        $('#itemsTable tbody').on('click', '.remove-item', function() {
            $(this).closest('tr').remove();
            updateTotalPrice('#itemsTable', '.quantity', '.price', '.total-price', '#total', '#discount', '#discount_amount', '#grand_total');
        });

        // Event listener untuk menghapus baris service
        $('#servicesTable tbody').on('click', '.remove-service', function() {
            $(this).closest('tr').remove();
            updateTotalPrice('#servicesTable', '.quantity-service', '.price-service', '.total-price-service', '#total', '#discount', '#discount_amount', '#grand_total');
        });

        // Event listener untuk perhitungan diskon
        $('#discount').on('input', function() {
            updateTotalPrice('#itemsTable', '.quantity', '.price', '.total-price', '#total', '#discount', '#discount_amount', '#grand_total');
            updateTotalPrice('#servicesTable', '.quantity-service', '.price-service', '.total-price-service', '#total', '#discount', '#discount_amount', '#grand_total');
        });

        // Fungsi untuk menghitung total harga dan diskon
        function updateTotalPrice(tableId, qtyClass, priceClass, totalClass, totalInput, discountInput, discountAmountInput, grandTotalInput) {
            var totalPrice = 0;

            $(`${tableId} tbody tr`).each(function() {
                var quantity = parseFloat($(this).find(qtyClass).val()) || 0;
                var price = parseFloat($(this).find(priceClass).val()) || 0;
                var rowTotal = quantity * price;

                $(this).find(totalClass).text(rowTotal.toFixed(2));
                totalPrice += rowTotal;
            });

            $(totalInput).val(totalPrice.toFixed(2));

            var discount = parseFloat($(discountInput).val()) || 0;
            var discountAmount = (totalPrice * discount) / 100;
            $(discountAmountInput).val(discountAmount.toFixed(2));

            var grandTotal = totalPrice - discountAmount;
            $(grandTotalInput).val(grandTotal.toFixed(2));
        }
    });

</script>

@endpush