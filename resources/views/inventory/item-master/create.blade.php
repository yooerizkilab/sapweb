@extends('layouts.admin', [
    'title' => 'Create Item Master Data',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">Create Item Master</h6>
            <a href="{{ route('item-master-data.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('item-master-data.store') }}" method="post" enctype="multipart/form-data"
                id="itemMasterForm">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="InventoryItem" id="InventoryItem"
                                    value="tYes" checked>
                                <label class="form-check-label" for="InventoryItem">Inventory Item</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="SalesItem" id="SalesItem"
                                    value="tYes" checked>
                                <label class="form-check-label" for="SalesItem">Sales Item</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="PurchasingItem" id="PurchasingItem"
                                    value="tYes" checked>
                                <label class="form-check-label" for="PurchasingItem">Purchasing Item</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="ItemCode">Item Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ItemCode" id="ItemCode"
                                placeholder="Item Code">
                        </div>
                        <div class="form-group">
                            <label for="ItemName">Item Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ItemName" id="ItemName"
                                placeholder="Item Name">
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-center font-weight-bold text-primary">
                            Properties Items
                        </h4>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties1" name="Properties1"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties1">Batik</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties2" name="Properties2"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties2">Warna</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties3" name="Properties3"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties3">Radial</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties4" name="Properties4"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties4">Crimping</label>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties5" name="Properties5"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties5">Nok Crimping</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties6" name="Properties6"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties6">Up Closer</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties7" name="Properties7"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties7">End Closer</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties8" name="Properties8"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties8">End Stopper</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties9" name="Properties9"
                                        value="tYES">
                                    <label class="form-check-label" for="Properties9">PU</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties10"
                                        name="Properties10" value="tYES">
                                    <label class="form-check-label" for="Properties10">PE</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties11"
                                        name="Properties11" value="tYES">
                                    <label class="form-check-label" for="Properties11">Flashing</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties12"
                                        name="Properties12" value="tYES">
                                    <label class="form-check-label" for="Properties12">Flashing 300</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties13"
                                        name="Properties13" value="tYES">
                                    <label class="form-check-label" for="Properties13">Flashing 450</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties14"
                                        name="Properties14" value="tYES">
                                    <label class="form-check-label" for="Properties14">Flashing 600</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties15"
                                        name="Properties15" value="tYES">
                                    <label class="form-check-label" for="Properties15">Plat Roll 300</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties16"
                                        name="Properties16" value="tYES">
                                    <label class="form-check-label" for="Properties16">Plat Roll 450</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties17"
                                        name="Properties17" value="tYES">
                                    <label class="form-check-label" for="Properties17">Plat Roll 600</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Properties18"
                                        name="Properties18" value="tYES">
                                    <label class="form-check-label" for="Properties18">Flashing Custom</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="confirmAddItemMaster()">
                    <i class="fas fa-save"></i>
                    Save Item Master
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
