<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="brand-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Product Name</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Transaction Id</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Discount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    $(function () {
        $('#brand-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('orders.index')); ?>",
            order: [[ 9, "desc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'product_name',orderable: false, searchable: false, render: function (data, type, row) {
                        return row.get_product.product_name;
                    }
                },
                {data: 'name',orderable: false, searchable: false,  render: function (data, type, row) {
                        return row.get_customer.first_name+' '+row.get_customer.last_name;
                    }
                },
                {data: 'email',orderable: false, searchable: false, render: function (data, type, row) {
                        return row.get_customer.email;
                    }
                },
                {data: 'transaction_id', name: 'transaction_id'},
                {data: 'quantity', name: 'quantity'},
                {data: 'total_price', name: 'total_price'},
                {data: 'discount', name: 'discount'},
                {data: 'order_status', name: 'order_status'},
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'}
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>