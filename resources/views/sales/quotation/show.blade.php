@extends('layouts.admin', [
    'title' => 'Show Sales Quotation'
])

@push('css')

@endpush

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">Detail Sales Quotation</h6>
        <a href="{{ route('sales-quotation.index') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-reply"></i> 
            Back
        </a>
    </div>
    <div class="card-body">

    </div>      
</div>

@endsection

@push('scripts')

@endpush