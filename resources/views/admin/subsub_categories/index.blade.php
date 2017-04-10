@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <a href="{{ route('subsubcategories.create') }}" class="btn btn-primary">Add New</a>
    </div>
    <div class="row">
        <table class="ui celled table" id="subsubcategory-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Sub Category Name</th>
                    <th>Sub Sub Category Name</th>
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
        $('#subsubcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('admin/subsubcategories') }}"+"?subcategory_id="+<?= $subcategory_id ?>,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'category_name', name: 'category_name'},
                {data: 'sub_category_name', name: 'sub_category_name'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'Action',orderable: false,searchable: false, render: function (data, type, row) {
                        return row.action; 
                    }

                }
            ]
        });
    });
</script>
@endpush
@endsection
