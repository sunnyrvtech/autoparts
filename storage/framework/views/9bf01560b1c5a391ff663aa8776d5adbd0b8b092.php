<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <a href="<?php echo e(route('subcategories.create')); ?>" class="btn btn-primary">Add New</a>
    </div>
    <div class="row">
        <table class="ui celled table" id="subcategory-table">
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
        $('#subcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(url('admin/subcategories')); ?>"+"?category_id="+<?= $category_id ?>,
            columns: [
                {data: 'id', name: 'id'},
                {data: 'category_name', name: 'category_name',orderable: false},
                {data: 'name', name: 'name'},
                {data: "category_image", render: function (data, type, row) {
                        if (data != null) {
                            return '<img width="100px" src="' + "<?= url('/category') ?>" + "/" + data + '" />';
                        }
                        return '';
                    }
                },
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>