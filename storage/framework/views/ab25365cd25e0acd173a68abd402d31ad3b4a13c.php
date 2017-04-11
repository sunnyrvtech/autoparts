<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-primary">Add New</a>
    </div>
    <div class="row">
        <table class="ui celled table" id="brand-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Product Name</th>
                    <th>Product Description</th>
                    <th>Part Number</th>
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
<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    $(function () {
        $('#brand-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('products.index')); ?>",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'product_name', name: 'product_name'},
                {data: 'product_long_description', name: 'product_long_description'},
                {data: 'part_number', name: 'part_number'},
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
                {data: 'Action',orderable: false,searchable: false, render: function (data, type, row) {
                        //console.log(row.id);
                        return row.action; 
                    }

                }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>