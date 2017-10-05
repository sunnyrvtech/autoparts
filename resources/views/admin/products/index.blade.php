@extends('admin/layouts.master')

@section('content')
<style>
    .alert.alert-warning li {
        display: inline-block;
        width: 24%;
    }
</style>
<div class="container-fluid">
    <div class="row form-group">
        <div class="row">
            <div class="col-md-2">
                <a href="{{ route('products.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="col-md-6">
                <div class="text-right">
                    <a class="btn btn-success" onclick="$('#deleteProductModal').modal('show');" href="javascript:void(0);" type="button"><i class="glyphicon glyphicon-remove"></i>Delete All Product</a>
                    <a class="btn btn-warning" onclick="$('#exportProductModal').modal('show');" href="javascript:void(0);" type="button"><i class="glyphicon glyphicon-export"></i>Export Product</a>
                    <a class="browse btn btn-primary" type="button"><i class="glyphicon glyphicon-import"></i>Import Product</a>
                    <input style="display: none;" id="file_type" name="csvFile" class="uploadCsv" type="file">
                </div>
            </div>
            <div class="col-md-4">
                <form method="get">
                    <div class="form-group">
                        <!--                        <label class="control-label">Search:</label>-->
                        <input class="form-control" name="sku" placeholder="Enter SKU No to search">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="product-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>
                        <!--<th>Product Description</th>-->
                        <th>Sku</th>
                        <th>Price($)</th>
                        <th>Special Price($)</th>
                        <th>Discount(%)</th>
                        <th>Quantity</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $key=>$value)
                    <tr class="odd" role="row">
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->product_name }}</td>
                        <td>{{ $value->sku }}</td>
                        <td>{{ $value->price }}</td>
                        <td>{{ $value->special_price }}</td>
                        <td>{{ $value->discount }}</td>
                        <td>{{ $value->quantity }}</td>
                        <td>{{ $value->created_at }}</td>
                        <td>{{ $value->updated_at }}</td>
                        <td><a href="{{ route('products.show', $value->id) }}" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>&nbsp;&nbsp;<a href="{{ route('products.destroy', $value->id) }}" data-toggle="tooltip" title="delete" data-method="delete" class="glyphicon glyphicon-trash deleteRow"></a></td>
                    </tr>
                    @empty
                    <tr class="odd"><td colspan="6" class="dataTables_empty" valign="top">No matching records found</td></tr>
                    @endforelse
                </tbody>
                </tbody>
            </table>
        </div>
        <div class="pagination_main_wrapper">{{ $products->links() }}</div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="deleteProductModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure you want to delete product data ?</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <strong>Warning!</strong>It will delete all data related to products i.e categories, sub_categories and products.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" id="deleteProductData">Yes</button>
                    <button type="button" class="btn btn-default" onclick="$('#deleteProductModal').modal('hide');">No</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exportProductModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Please choose number below to export product details.</h4>
                </div>
                <div class="modal-body">
                    <form id="sampleForm" action="{{ route('export-sample-csv') }}" target="_blank" method="post">{{ csrf_field()}}<p>Here you can download sample file <a href="javascript:void(0);" id="sample_file">Sample File</a></p></form>
                    <div class="alert alert-warning" role="alert">
                        <strong>Note! </strong>It will export 10000 records.For example if you select 2 then it will skip first 10000 and export records from 10001 to 20000 and if you select 3 then it will skip first 20000 records and export record from 20001 to 30000 etc.
                        <ul>
                            <li><b>1:</b><spam> 1-10000</spam></li>
                            <li><b>2:</b><spam> 10001-20000</spam></li>
                            <li><b>3:</b><spam> 20001-30000</spam></li>
                            <li><b>4:</b><spam> 30001-40000</spam></li>
                            <li><b>5:</b><spam> 40001-50000</spam></li>
                            <li><b>6:</b><spam> 50001-60000</spam></li>
                            <li><b>7:</b><spam> 60001-70000</spam></li>
                            <li><b>8:</b><spam> many-more...</spam></li>
                        </ul>
                    </div>
                    <form class="form-horizontal" method="post" target="_blank" action="{{ route('export.csv') }}">
                        {{ csrf_field()}}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="col-sm-3 col-md-3 control-label" for="start"></label>
                                        <div class="col-sm-9 col-md-9">
                                            <select required="" name="export_product" id="export_product" class="form-control">
                                                <?php
                                                $total_records = (@$products->toArray()['total'] / 10000) + 1;
                                                for ($i = 1; $i <= $total_records; $i++) {
                                                    ?>
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success btn-block">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function () {
//        $('#product-table').DataTable({
//            processing: true,
//            serverSide: true,
//            ajax: "{{ route('products.index') }}",
////            order: [[ 1, "asc" ]],
//            columns: [
//                {data: 'id', name: 'id'},
//                {data: 'product_name', name: 'product_name'},
//                //  {data: 'product_long_description', name: 'product_long_description'},
//                {data: 'sku', name: 'sku'},
//                {data: 'price', name: 'price'},
//                {data: 'special_price', name: 'special_price'},
//                {data: 'discount', name: 'discount'},
//                {data: 'quantity', name: 'quantity'},
//                {data: 'status', render: function (data, type, row) {
//                        if (data == 1) {
//                            return 'Enabled';
//                        }
//                        return 'Disabled';
//                    }
//
//                },
//                {data: 'created_at', name: 'created_at'},
//                {data: 'updated_at', name: 'updated_at'},
//                {data: 'Action', orderable: false, searchable: false, render: function (data, type, row) {
//                        //console.log(row.id);
//                        return row.action;
//                    }
//
//                }
//            ]
//        });
        $(document).on('change', '.uploadCsv', function (e) {
            $("#loaderOverlay").show();
            var formData = new FormData();
            formData.append('csvFile', $('input[type=file]')[0].files[0]);
            $.ajax({
                url: "{{ route('import.csv') }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#loaderOverlay").hide();
                    //window.location.reload();
                },
                error: function (error) {
                    $("#loaderOverlay").hide();
                    alert('Something went wrong,please try again later!');
                }

            });
            return false;
        });

        $(document).on('click', '#export_product_data', function (e) {
            $("#loaderOverlay").show();
            $.ajax({
                url: "{{ route('export.csv') }}",
                type: 'POST',
                data: {export_product: $("#export_product").val()},
                success: function (response) {
                    $("#loaderOverlay").hide();
                    var a = document.createElement("a");
                    a.href = response.file;
                    a.download = response.name;
                    document.body.appendChild(a);
                    a.click();
                    a.remove();
                    $("#exportProductModal").modal('hide');
                },
                error: function (response) {
                    $("#loaderOverlay").hide();
                    alert(response.responseText);
                }
            });
        });
        
        $(document).on('click', '#sample_file', function (e) {
            document.getElementById("sampleForm").submit();
        });

        $(document).on('click', '#deleteProductData', function (e) {
            $("#loaderOverlay").show();
            $.ajax({
                url: "{{ route('import.delete_product') }}",
                type: 'POST',
                data: {'method': 'delete_product_data'},
                success: function (data) {
                    $("#loaderOverlay").hide();
                    $('#deleteProductModal').modal('hide');
                    window.location.reload();
                },
                error: function (error) {
                    $("#loaderOverlay").hide();
                    alert('Something went wrong,please try again later!');
                }
            });
        });
    });
</script>
@endpush
@endsection
