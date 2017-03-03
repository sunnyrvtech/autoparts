<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title><?php echo e($title); ?></title>

        <!-- Bootstrap Core CSS -->
        <link href="<?php echo e(URL::asset('/css/app.css')); ?>" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="<?php echo e(URL::asset('/css/sb-admin.css')); ?>" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">AutoLight Admin</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo e(Auth::user()->first_name); ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0);"><i class="fa fa-fw fa-gear"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="<?php echo e(url('admin')); ?>"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('categories.index')); ?>"><i class="fa fa-fw fa-tags"></i>Categories</a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('brands.index')); ?>"><i class="fa fa-fw fa-dribbble"></i>Brands</a>
                        </li>
                        <!--
                        <li>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-edit"></i> Forms</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
                        </li>-->
                        <!--                        <li>
                                                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#demo"><i class="fa fa-fw fa-arrows-v"></i> Dropdown <i class="fa fa-fw fa-caret-down"></i></a>
                                                    <ul id="demo" class="collapse">
                                                        <li>
                                                            <a href="javascript:void(0);">Dropdown Item</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript:void(0);">Dropdown Item</a>
                                                        </li>
                                                    </ul>
                                                </li>-->
                        <!--                        <li>
                                                    <a href="javascript:void(0);"><i class="fa fa-fw fa-file"></i> Blank Page</a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0);"><i class="fa fa-fw fa-dashboard"></i> RTL Dashboard</a>
                                                </li>-->
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </nav>
            <div id="page-wrapper">
                <?php if(Session::has('success-message')): ?>
                <div class="alert alert-success fade in alert-dismissable">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Success! </strong><?php echo e(Session::pull('success-message')); ?>

                </div>
                <?php elseif(Session::has('error-message')): ?>
                <div class="alert alert-danger fade in alert-dismissable">
                    <a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <strong>Error! </strong><?php echo e(Session::pull('error-message')); ?>

                </div>
                <?php endif; ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="<?php echo e(URL::asset('/js/app.js')); ?>"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $("body").tooltip({ selector: '[data-toggle=tooltip]',trigger: 'hover' });
            });
        </script>
        <!-- App scripts -->
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
