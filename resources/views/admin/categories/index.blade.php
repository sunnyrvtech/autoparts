@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <div class="row">
        <table class="table table-bordered" id="category-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Category Name</th>
                    <th>Category Image</th>
                    <th>Status</th>
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
            ajax: "{{ url('admin/categories') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: "category_image", render: function (data, type, row) {
                        if (data != null) {
                            return '<img src="' + "{{ URL::asset('/category') }}" + "/" + data + '" />';
                        }
                        return '';
                    }
                },
                {data: 'status', render: function (data, type, row) {
                        if (data == 1) {
                            return 'Active';
                        }
                        return 'Not Active';
                    }

                },
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'Action',orderable: false, render: function (data, type, row) {
                        //console.log(row.id);
                        return '<a href="'+ "<?php echo url('/') ?>"+'/admin/subcategories/'+row.id+'" data-toggle="tooltip" title="View Sub Category" class="glyphicon glyphicon-eye-open"></a>&nbsp;<a href="'+ "{{ url('/categories/sub') }}" +'" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>'; 
                    }

                }
            ]
        });
    });
</script>
@endpush
@endsection
