<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <a href="<?php echo e(route('brands.create')); ?>" class="btn btn-primary">Add New</a>
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


<?php $__env->startPush('scripts'); ?>
<script>
    $(function () {
        $('#brand-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(route('brands.index')); ?>",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: "brand_image", render: function (data, type, row) {
                        if (data != null) {
                            return '<img src="' + "<?php echo e(URL::asset('/brands')); ?>" + "/" + data + '" />';
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>