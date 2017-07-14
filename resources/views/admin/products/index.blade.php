@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <div class="col-md-4">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="col-md-8">
                <div class="text-right">
                    <a class="browse btn btn-primary" type="button"><i class="glyphicon glyphicon-import"></i>Import Product</a>
                    <input style="display: none;" id="file_type" name="csvFile" class="uploadCsv" type="file">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="brand-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>
                        <!--<th>Product Description</th>-->
                        <th>Sku</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
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
<script type="text/javascript">
    $(function () {
        $('#brand-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('products.index') }}",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'product_name', name: 'product_name'},
              //  {data: 'product_long_description', name: 'product_long_description'},
                {data: 'sku', name: 'sku'},
                {data: 'price', name: 'price'},
                {data: 'quantity', name: 'quantity'},
                {data: 'status', render: function (data, type, row) {
                        if (data == 1) {
                            return 'Enabled';
                        }
                        return 'Disabled';
                    }

                },
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'Action', orderable: false, searchable: false, render: function (data, type, row) {
                        //console.log(row.id);
                        return row.action;
                    }

                }
            ]
        });
        $(document).on('change', '.uploadCsv', function (e) {
            $("#loaderOverlay").show();
            var formData = new FormData();
            formData.append('csvFile', $('input[type=file]')[0].files[0]);
            $.ajax({
                url: "{{ route('import.csv') }}",
                type: 'POST',
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#loaderOverlay").hide();
                    window.location.reload();
                    //alert("Process completed.Please shut down system now");
                },
                error: function (error) {
                   alert('Something went wrong,please try again later!');
                 }
                
            });
            return false;
        });
    });
</script>
@endpush
@endsection
