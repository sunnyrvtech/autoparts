@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="{{ route('brands.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <div class="row">
        <table class="ui celled table" id="brand-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Brand Name</th>
                    <th>Brand Image</th>
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
        $('#brand-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('brands.index') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: "brand_image", render: function (data, type, row) {
                        if (data != null) {
                            return '<img src="' + "{{ URL::asset('/brands') }}" + "/" + data + '" />';
                        }
                        return '';
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'Action',orderable: false,searchable: false, render: function (data, type, row) {
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
