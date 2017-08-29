@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <a href="{{ route('tax_rates.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="tax-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Country</th>
                        <th>States</th>
                        <th>Price</th>
                        <th>Created At</th>
                        <th>Updated At</th>
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
        $('#tax-table').DataTable({
            processing: true,
            serverSide: true,
//            order: [[2, "desc"]],
            ajax: "{{ route('tax_rates.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'country_name', name: 'country_name'},
                {data: 'state_name', orderable: false, searchable: false, render: function (data, type, row) {
                        //console.log(row.id);
                        return row.state_name;
                    }

                },
                {data: 'price', name: 'price'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
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
