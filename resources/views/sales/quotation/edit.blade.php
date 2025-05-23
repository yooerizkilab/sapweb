@extends('layouts.admin', [
    'title' => 'Update Sales Quotation',
])

@push('css')
@endpush

@section('main-content')
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
            <h6 class="m-0 font-weight-bold text-primary">Update Sales Quotation</h6>
            <a href="{{ route('sales-quotation.index') }}" class="btn btn-primary btn-md mr-2">
                <i class="fas fa-reply"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            <form action="{{ route('sales-quotation.update', $quotation['DocEntry']) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

            </form>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="confirmUpdateSalesQuotation()">
                    <i class="fas fa-save"></i>
                    Save
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush
