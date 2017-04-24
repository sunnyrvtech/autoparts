<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row form-group">
        <div class="col-md-12">
            <a href="<?php echo e(route('categories.create')); ?>" class="btn btn-primary">Add New</a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="ui celled table" id="category-table">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
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

<?php $__env->startPush('scripts'); ?>
<script>
    $(function () {
        $('#category-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "<?php echo e(url('admin/categories')); ?>",
//            order: [[ 1, "asc" ]],
            columns: [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: "category_image", render: function (data, type, row) {
                        if (data != null) {
                            return '<img width="100px" src="' + "<?php echo e(URL::asset('/category_images')); ?>" + "/" + data + '" />';
                        }
                        return '';
                    }
                },
                {data: 'status', render: function (data, type, row) {
                        if (data == 1) {
                            return '<select name="category_status" data-id="' + row.id + '" id="category_status"><option selected value="1">Active</option><option value="0">Not Active</option></select>';
                        }
                        return '<select name="category_status" data-id="' + row.id + '" id="category_status"><option value="1">Active</option><option selected value="0">Not Active</option></select>';
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

        $(document).on('change', '#category_status', function (e) {
            e.preventDefault(); // does not go through with the link.
            $(".alert-danger").remove();
            $(".alert-success").remove();
            var $this = $(this);

            $.post({
                data: {'id': $this.data('id'), 'status': $this.val()},
                url: "<?php echo e(route('categories-status')); ?>"
            }).done(function (data) {
                var HTML = '<div class="alert alert-success fade in">';
                HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
                HTML += '<strong>Success! </strong>' + data.messages + '</div>';
                $("#page-wrapper .container-fluid").before(HTML);
                $(window).scrollTop(0);
            }).fail(function (data) {
                var HTML = '<div class="alert alert-danger fade in">';
                HTML += '<a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>';
                HTML += '<strong>Error! </strong>' + data.responseJSON.error + '</div>';
                $("#page-wrapper .container-fluid").before(HTML);
                $(window).scrollTop(0);
            });
        });




    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>