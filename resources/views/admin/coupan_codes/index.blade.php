@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <a href="{{ route('coupan_code.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="coupan-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Coupan Type</th>
                        <th>Code</th>
                        <th>Usage</th>
                        <th>Expiration Date</th>
                        <th>Status</th>
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
        $('#coupan-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[5, "desc"]],
            ajax: "{{ url('admin/coupan_code') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'coupan_type', name: 'coupan_type'},
                {data: 'code', name: 'code'},
                {data: 'usage', name: 'usage'},
                {data: 'expiration_date', name: 'expiration_date'},
                {data: 'status', render: function (data, type, row) {
                        if (data == 1) {
                            return 'Active';
                        }
                        return 'Not Active';
                    }

                },
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
