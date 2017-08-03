@extends('admin/layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <h3>Order Details :-</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="order-table">
                <thead>
                    <tr>
                        <!--<th>Id</th>-->
                        <th>Product Name</th>
                        <th>Sku Number</th>
                        <th>Quantity</th>
                        <th>Item Price</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(function () {
//        $orderId
        $('#order-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ $ajaxURL }}",
//            order: [[ 10, "desc" ]],
            columns: [
//                {data: 'order_id', name: 'order_id'},
                {data: 'product_name', name: 'product_name'},
                {data: 'sku_number', name: 'sku_number'},
                {data: 'quantity', name: 'quantity'},
                {data: 'item_price',orderable: false, searchable: false,  render: function (data, type, row) {
                        return (row.total_price/row.quantity).toFixed(2);
                    }
                },
                {data: 'discount', name: 'discount'},
                {data: 'total_price',orderable: false, searchable: false,  render: function (data, type, row) {
                        actual_price = row.total_price;
                        discount = row.discount;
                        total_price = actual_price-(actual_price*discount/100);
                        return total_price.toFixed(2);
                    }
                }
            ]
        });
        
        
    });
</script>
@endpush
@endsection
