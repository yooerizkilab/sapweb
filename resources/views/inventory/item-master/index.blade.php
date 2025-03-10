@extends('layouts.admin', [
    'title' => 'Item Master Data'
])

@push('css')

@endpush

@section('main-content')

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center flex-wrap">
        <h6 class="m-0 font-weight-bold text-primary">List Items Master</h6>
        <a href="{{ route('item-master-data.create') }}" class="btn btn-primary btn-md mr-2">
            <i class="fas fa-cart-plus"></i> 
            Add Items Master
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th width="5%">No</th>
                        <th>Item Code</th>
                        <th>Foreign Name</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th width="10%">Group</th>
                        <th width="15%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    @php
                        $groupName = collect($groups)->firstWhere(fn($g) => isset($g['Number']) && (string) $g['Number'] === (string) $item['ItemsGroupCode'])['GroupName'] ?? 'Unknown';
                    @endphp
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $item['ItemCode'] }}</td>
                            <td class="text-center">{{ $item['ForeignName'] }}</td>
                            <td>{{ $item['ItemName'] }}</td>
                            <td class="text-center">{!! $item['ItemType'] == 'itItems' ? '<span class="badge badge-primary">Item</span>' : '<span class="badge badge-secondary">Jasa</span>' !!}</td>
                            <td>{{ $groupName }}</td>
                            <td class="text-center">
                                <div class="d-inline-flex">
                                    <a href="{{ route('item-master-data.show', $item['ItemCode']) }}" class="btn btn-info btn-circle btn-sm mr-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('item-master-data.edit', $item['ItemCode']) }}" class="btn btn-warning btn-circle btn-sm mr-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
    $(document).ready(function () {
        $('#dataTable').DataTable();
    });
</script>

@endpush