@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <a href="{{ route('shipping_rates.create') }}" class="btn btn-primary">Add New</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="shipping-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Country</th>
                        <th>Low Weight</th>
                        <th>High Weight</th>
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
        $('#shipping-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/shipping_rates') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'country_id',orderable: false, searchable: false, render: function (data, type, row) {
                        return row.get_country.name;
                    }
                },
                {data: 'low_weight', name: 'low_weight'},
                {data: 'high_weight', name: 'high_weight'},
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
