<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <a href="<?php echo e(route('shipping_rates.create')); ?>" class="btn btn-primary">Add New</a>
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

<?php $__env->startPush('scripts'); ?>
<script>
    $(function () {
        $('#shipping-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(url('admin/shipping_rates')); ?>",
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>