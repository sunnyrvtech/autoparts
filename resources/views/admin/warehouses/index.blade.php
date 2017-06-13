@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <a href="{{ route('warehouses.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="warehouse-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Store Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Zip</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        $('#warehouse-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/warehouses') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'store_name', name: 'store_name'},
                {data: 'email', name: 'email'},
                {data: 'address', name: 'address'},
                {data: 'country', name: 'country'},
                {data: 'state', name: 'state'},
                {data: 'city', name: 'city'},
                {data: 'zip', name: 'zip'},
                {data: 'status', render: function (data, type, row) {
                        if (data == 1) {
                            return 'Active';
                        }
                        return 'Not Active';
                    }

                },
                {data: 'created_at', name: 'created_at'},
                {data: 'Action', orderable: false, searchable: false, render: function (data, type, row) {
                        //console.log(row.id);
                        return row.action;
                    }

                }
            ]
        });
    });
</script>
@endpush
@endsection
