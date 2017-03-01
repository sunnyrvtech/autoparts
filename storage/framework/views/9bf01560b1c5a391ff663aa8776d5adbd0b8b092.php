<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <a href="<?php echo e(route('subcategories.create')); ?>" class="btn btn-primary">Add New</a>
    </div>
    <div class="row">
        <table class="table table-bordered" id="category-table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Category Image</th>
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
        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(url('admin/subcategories')); ?>"+"?category_id="+<?= $category_id ?>,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'category_name', name: 'category_name',orderable: false},
                {data: 'name', name: 'name'},
                {data: "category_image", render: function (data, type, row) {
                        if (data != null) {
                            return '<img src="' + "<?= url('/category') ?>" + "/" + data + '" />';
                        }
                        return '';
                    }
                },
                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'Action',orderable: false, render: function (data, type, row) {
                        return '<a href="javascript:void(0);" data-toggle="tooltip" title="View Sub Sub Category" class=" glyphicon glyphicon-eye-open"></a>&nbsp;<a href="javascript:void(0);" data-toggle="tooltip" title="update" class="glyphicon glyphicon-edit"></a>'; 
                    }

                }
            ]
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>