@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="{{ route('vehicle.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <div class="row">
        <table class="ui celled table" id="category-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@push('scripts')
<script>
    $(function () {
        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/vehicle') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'Action',orderable: false,searchable: false, render: function (data, type, row) {
                        return '<a href="javascript:void(0);" title="update" class="glyphicon glyphicon-edit"></a>'; 
                    }

                }
            ]
        });
    });
</script>
@endpush
@endsection
