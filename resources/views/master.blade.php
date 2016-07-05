<!DOCTYPE html>
    <!--
    This is a starter template page. Use this page to start your new project from
    scratch. This page gets rid of all links and provides the needed markup only.
    -->
    <html>
    <head>
        <meta charset="UTF-8">
        <title>AdminLTE 2 | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/node_modules/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset("/node_modules/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="{{ asset("/node_modules/admin-lte/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

        <!-- alerify css-->
        <!-- include the style -->
        <link rel="stylesheet" href="{{asset("/node_modules/alertifyjs/build/css/alertify.min.css")}}" />
        <!-- include a theme -->
        <link rel="stylesheet" href="{{asset("/node_modules/alertifyjs/build/css/themes/default.min.css")}}" />

        <link rel="stylesheet" href="{{ asset("/node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.css")}}">




        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->



        {{--JQuery--}}
        <script src="{{ asset("/node_modules/admin-lte/plugins/jQuery/jQuery-2.2.0.min.js")}}"></script>

        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset("/node_modules/admin-lte/plugins/select2/select2.min.css")}}">
        <!-- Select2 -->
        <script src="{{ asset("/node_modules/admin-lte/plugins/select2/select2.full.min.js")}}"></script>
        <!-- InputMask -->
        <script src="{{ asset("/node_modules/admin-lte/plugins/input-mask/jquery.inputmask.js")}}"></script>
        <script src="{{ asset("/node_modules/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js")}}"></script>
        <script src="{{ asset("/node_modules/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js")}}"></script>

        <!-- bootstrap datepicker -->
        <script src="{{ asset("/node_modules/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}"></script>
        <link rel="stylesheet" href="{{ asset("/node_modules/admin-lte/plugins/datepicker/datepicker3.css")}}">

        <!-- bootstrap daterangepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="{{ asset("/node_modules/admin-lte/plugins/daterangepicker/daterangepicker.js")}}"></script>
        <link rel="stylesheet" href="{{ asset("/node_modules/admin-lte/plugins/daterangepicker/daterangepicker-bs3.css")}}">

        <!-- ... -->
        {{--<script type="text/javascript" src="{{ asset("/bower_components/jquery/jquery.min.js")}}"></script>--}}
        <script type="text/javascript" src="{{ asset("/bower_components/moment/min/moment.min.js")}}"></script>
        <script type="text/javascript" src="{{ asset("/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js")}}"></script>
        <link rel="stylesheet" href="{{ asset("/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css")}}" />




        <!-- styles -->
        <style type="text/css">
            .row {
                margin: 2%;
               }
            .select2 {
                color: #444;
                /* line-height: 28px; */
            }
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #3c8dbc;
                border-color: #367fa9;
            }
        </style>

    </head>
    <body class="skin-blue">
    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="index2.html" class="logo"><b>Admin</b>LTE</a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        @if(Session::get('role_id')==3)
                         <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                                <ul class="dropdown-menu">
                                    <li class="header">4 New Orders</li>
                                    <li>
                                        <!-- inner menu: contains the messages -->
                                        <ul class="menu">
                                            <li><!-- start message -->
                                                <a href="#">
                                                    <div class="pull-left">
                                                        <!-- User Image -->
                                                        <img src="{{ asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image"/>
                                                    </div>
                                                    <!-- Message title and timestamp -->
                                                    <h4>
                                                        Support Team
                                                        <small onclick="seenByCashier();" style="font-size: small;"><i class="fa fa-check-circle-o"></i> mark as read</small>
                                                    </h4>
                                                    <!-- The message -->
                                                    <p>Why not buy a new awesome theme?</p>
                                                </a>
                                            </li><!-- end message -->
                                        </ul><!-- /.menu -->
                                    </li>
                                    <li class="footer"><a href="#">See All Orders</a></li>
                                </ul>

                             </li><!-- /.messages-menu -->
                        @endif
                        <!-- Notifications Menu -->
                        {{--<li class="dropdown notifications-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- Inner Menu: contains the notifications -->
                                    <ul class="menu">
                                        <li><!-- start notification -->
                                            <a href="#">
                                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                            </a>
                                        </li><!-- end notification -->
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks Menu -->
                        <li class="dropdown tasks-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-flag-o"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- Inner menu: contains the tasks -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <!-- Task title and progress text -->
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <!-- The progress bar -->
                                                <div class="progress xs">
                                                    <!-- Change the css width attribute to simulate progress -->
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>--}}
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">{{Session::get('users_name')}}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="{{ asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
                                    <p>
                                        {{Session::get('users_name')}} -  {{Session::get('role')}}
                                        <small>Member since {{ explode(" ", Session::get('user_created_at'))[0]}}</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-2 text-center">
                                    </div>
                                    <div class="col-xs-8 text-center">
                                        <a href="{{url('/resetPassword')}}" style="color:cornflowerblue;">Reset Password</a>
                                    </div>
                                    <div class="col-xs-2 text-center">
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    {{--<div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>--}}
                                    <div class="pull-right">
                                        <a href="{{url('/doLogout')}}" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>{{Session::get('users_name')}}</p>
                        <!-- Status -->
                      <!--   <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                    </div>
                </div>

                <!-- search form (Optional) -->
                <!-- <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
          <span class="input-group-btn">
            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
          </span>
                    </div>
                </form> -->
                <!-- /.search form -->

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu">

                    <!-- <li class="header">HEADER</li> -->
                    <!-- Optionally, you can add icons to the links -->
                    @if(Request::path()==='dashboard')
                        <li class="active"><a href="{{url('dashboard')}}"><span>Dashboard</span></a></li>
                    @else
                        <li ><a href="{{url('dashboard')}}"><span>Dashboard</span></a></li>
                    @endif

                    @if(Request::path()==='customers')
                        <li class="active"><a href="{{url('customers')}}"><span>Customers</span></a></li>
                    @else
                        <li><a href="{{url('customers')}}"><span>Customers</span></a></li>
                    @endif

                    @if(Request::path()==='vehicles')
                        <li class="active"><a href="{{url('vehicles')}}"><span>Vehilcles</span></a></li>
                    @else
                        <li><a href="{{url('vehicles')}}"><span>Vehilcles</span></a></li>
                    @endif
                    @if(Request::path()==='drivers')
                        <li  class="active"><a href="{{url('drivers')}}"><span>Drivers</span></a></li>
                    @else
                        <li><a href="{{url('drivers')}}"><span>Drivers</span></a></li>
                    @endif

                    @if(Request::path()=='addOrder' || Request::path()=='allOrders' || Request::path()=='deliverdOrders' || Request::path()=='notDeliveredOrders' || Request::path()=='returnedProducts')
                        <li class="treeview active">
                    @else
                        <li class="treeview">
                    @endif
                        <a ><span>Sales</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @if(Request::path()==='addOrder')
                                <li class="active"><a href="{{url('addOrder')}}">Add Order</a></li>
                            @else
                                <li><a href="{{url('addOrder')}}">Add Order</a></li>
                            @endif
                            @if(Request::path()==='allOrders')
                                <li class="active"><a href="{{url('allOrders')}}">All Order</a></li>
                            @else
                                <li><a href="{{url('allOrders')}}">All Order</a></li>
                            @endif
                            @if(Request::path()==='deliverdOrders')
                                <li class="active"><a href="{{url('deliverdOrders')}}">Delivered Orders</a></li>
                            @else
                                <li><a href="{{url('deliverdOrders')}}">Delivered Orders</a></li>
                            @endif
                            @if(Request::path()==='notDeliveredOrders')
                                <li class="active"><a href="{{url('notDeliveredOrders')}}">Orders Not Delivered</a></li>
                            @else
                                <li><a href="{{url('notDeliveredOrders')}}">Orders Not Delivered</a></li>
                            @endif
                            @if(Request::path()==='returnedProducts')
                                <li class="active"><a href="{{url('returnedProducts')}}">Returned Products</a></li>
                            @else
                                <li><a href="{{url('returnedProducts')}}">Returned Products</a></li>
                            @endif
                        </ul>
                    </li>

                    @if(Request::path()=='products' || Request::path()=='damagedProducts')
                        <li class="treeview active">
                    @else
                        <li class="treeview">
                    @endif
                        <a><span>Products</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @if(Request::path()==='products')
                                <li class="active"><a href="{{url('products')}}"><span>Products</span></a></li>
                            @else
                                <li><a href="{{url('products')}}"><span>Products</span></a></li>
                            @endif
                                @if(Request::path()==='damagedProducts')
                                    <li class="active"><a href="{{url('damagedProducts')}}"><span>Damaged Products</span></a></li>
                                @else
                                    <li><a href="{{url('damagedProducts')}}"><span>Damaged Products</span></a></li>
                                @endif
                        </ul>
                        </li>


                    @if(Request::path()==='companies')
                        <li class="active"><a href="{{url('companies')}}"><span>Companies</span></a></li>
                    @else
                        <li><a href="{{url('companies')}}"><span>Companies</span></a></li>
                    @endif

                    @if(Request::path()=='customerZones' || Request::path()=='vehicleZones')
                        <li class="treeview active">
                    @else
                        <li class="treeview">
                    @endif
                        <a><span>Zones</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            @if(Request::path()==='customerZones')
                                <li class="active"><a href="{{url('customerZones')}}">Customer Zones</a></li>
                            @else
                                <li><a href="{{url('customerZones')}}">Customer Zones</a></li>
                            @endif
                            @if(Request::path()==='vehicleZones')
                                <li class="active"><a href="{{url('vehicleZones')}}">Vehicle Zones</a></li>
                            @else
                                <li><a href="{{url('vehicleZones')}}">Vehicle Zones</a></li>
                            @endif
                        </ul>
                    </li>
                    @if(Request::path()==='register')
                        <li class="active"><a href="{{url('register')}}"><span>Register Users</span></a></li>
                    @else
                        <li><a href="{{url('register')}}"><span>Register Users</span></a></li>
                    @endif

                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
                <!-- Your Page Content Here -->
            @yield('content')

        </div><!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright © 2015 <a href="#">Company</a>.</strong> All rights reserved.
        </footer>

    </div><!-- ./wrapper -->

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.1.3 -->
    
     <!-- alertify js -->
    <!-- include the script -->

{{--
    <script src="https://code.jquery.com/jquery-2.1.3.min.js" integrity="sha256-ivk71nXhz9nsyFDoYoGf2sbjrR9ddh+XDkCcfZxjvcM=" crossorigin="anonymous"></script>
--}}


    <script src="{{asset("/node_modules/alertifyjs/build/alertify.min.js")}}"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="{{ asset ("/node_modules/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset ("/node_modules/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>

    {{--datatable--}}
    <script src="{{ asset("/node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js")}}"></script>
    <script src="{{ asset("/node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.min.js")}}"></script>




    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->
    <script type="text/javascript">
        $('.select2').select2();

        function seenByCashier(){
            console.log('read');
        }
    </script>

    </body>
</html>