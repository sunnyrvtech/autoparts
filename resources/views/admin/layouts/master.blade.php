<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token()}}">

        <title>{{ $title}}</title>

        <!-- Bootstrap Core CSS -->
        <link href="{{ URL::asset('/css/app.css') }}" rel="stylesheet">
        <!-- Custom CSS -->
        <link href="{{ URL::asset('/css/sb-admin.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">   
        <!-- Custom Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css">
        <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css">-->
        <link href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css" rel="stylesheet">   
        <link href="https://cdn.datatables.net/1.10.13/css/dataTables.semanticui.min.css" rel="stylesheet">   
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
                    <a class="navbar-brand" href="{{ url('/')}}">AutoLight Admin</a>
                </div>
                <!-- Top Menu Items -->
                <ul class="nav navbar-right top-nav">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ Auth::user()->first_name }}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="javascript:void(0);"><i class="fa fa-fw fa-gear"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ url('/logout')}}"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active">
                            <a href="{{ url('admin')}}"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="{{ route('customers.index')}}"><i class="fa fa-fw fa-user "></i> Customers</a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index')}}"><i class="fa fa-fw fa-tags"></i> Categories</a>
                        </li>
                        <li>
                            <a href="{{ route('brands.index')}}"><i class="fa fa-fw fa-dribbble"></i> Brands</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-toggle="collapse" data-target="#vehicle-menu"><i class="fa fa-fw fa-car"></i> Vehicles<i class="fa fa-fw fa-caret-down"></i></a>
                            <ul id="vehicle-menu" class="collapse">
                                <li>
                                    <a href="javascript:void(0);">Vehicle Models</a>
                                </li>
                                <li>
                                    <a href="{{ route('vehicle.index')}}">Vehicle Companies</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="{{ route('products.index')}}"><i class="fa fa-fw fa-tag"></i> Products</a>
                        </li>
                        <!--
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
                @if(Session::has('success-message') || Session::has('error-message'))
                <div id="redirect_alert" class="alert @if(Session::has('success-message')) alert-success @elseif(Session::has('error-message')) alert-danger @endif fade in alert-dismissable">
                    <a href="javascript:void(0);" onclick="$(this).parent().remove();" class="close" title="close">×</a>
                    <strong>@if(Session::has('success-message')) Success! @elseif(Session::has('error-message')) Error! @endif </strong>@if(Session::has('success-message')) {{ Session::pull('success-message') }} @elseif(Session::has('error-message')) {{ Session::pull('error-message') }} @endif
                </div>
                @endif
                @yield('content')
            </div>
            <!-- /#page-wrapper -->
        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->
        <script src="{{ URL::asset('/js/app.js') }}"></script>
        <script src="{{ url('/vendor/unisharp/laravel-ckeditor/ckeditor.js')}}"></script>
        <script src="{{ url('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js')}}"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.13/js/dataTables.semanticui.min.js"></script>
        <!--<script src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js "></script>-->
        <script src="{{ URL::asset('/js/bootstrap-datetimepicker.js') }}"></script> 
        <script type="text/javascript">
                        $(document).ready(function () {

                            if ($("li").hasClass("categoryExist")) {/// this code is used to check if list contain one value then display block ul list -->
                               $(".categoryExist").parent().show();
                               $(".categoryExist").parent().parent().parent().show(); 
                            }
                            $("body").tooltip({selector: '[data-toggle=tooltip]', trigger: 'hover'});
                            //initialize ckeditor        
                            $('textarea').ckeditor();
                            //initialize datepicker
                            $('.datepicker').datetimepicker({
                                format: "yyyy",
                                startView: 'decade',
                                minView: 'decade',
                                viewSelect: 'decade',
                                autoclose: true,

                            });
                            $(document).on('click', '.browse', function () {
                                var file = $(this).parent().parent().parent().find('.file');
                                file.trigger('click');
                            });
                            $(document).on('change', '.file', function (e) {
                                $(".renderPreviewImage").html('');
                                $.each(e.originalEvent.target.files, function (i, file) {
//                                    var img = document.createElement("img");
//                                    img.id = "image" + (i + 1);
                                    var reader = new FileReader();
                                    reader.onloadend = function () {
                                        var HTML = '<div class="col-md-2">';
                                        HTML += '<img width="100px" src="' + reader.result + '">';
                                        HTML += '</div>';
                                        $(".renderPreviewImage").append(HTML);
                                    }
                                    reader.readAsDataURL(file);
                                });
                            });

                            $(document).on('click', '.removePreviewImage', function () {
                                var ele = document.getElementById('product_images');
                                ele.value = "";
                                $(".renderPreviewImage").html('');
//                                var result = ele.files;
//                              console.log(result);

//                                $.each(result, function (i, file) {
//                                    console.log(file.name);
//                                     //delete files(2)
//                                });

                            });
                            $(document).on('change', '.preview-image', function (e) {
                                if (this.files && this.files[0]) {
                                    var img = document.createElement("img");
                                    var reader = new FileReader();

                                    reader.onload = function (e) {
                                        img.src = e.target.result;
                                        img.width = 200;
                                        $('#image_prev').html(img);
                                    };
                                    reader.readAsDataURL(this.files[0]);
                                }
                            });

                            $(document).on('click', '.toggleCategory', function () {
                                $(this).next().slideToggle();
                            });

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $(document).on('click', '.deleteRow', function (e) {
                                e.preventDefault(); // does not go through with the link.

                                var $this = $(this);

                                $.post({
                                    type: $this.data('method'),
                                    url: $this.attr('href')
                                }).done(function (data) {
                                    window.location.reload();
                                });
                            });
                        });
        </script>
        <!-- App scripts -->
        @stack('scripts')
    </body>
</html>
