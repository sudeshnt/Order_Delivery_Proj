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
        <link href="<?php echo e(asset("/node_modules/admin-lte/bootstrap/css/bootstrap.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="<?php echo e(asset("/node_modules/admin-lte/dist/css/AdminLTE.min.css")); ?>" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="<?php echo e(asset("/node_modules/admin-lte/dist/css/skins/skin-blue.min.css")); ?>" rel="stylesheet" type="text/css" />

        <!-- alerify css-->
        <!-- include the style -->
        <link rel="stylesheet" href="<?php echo e(asset("/node_modules/alertifyjs/build/css/alertify.min.css")); ?>" />
        <!-- include a theme -->
        <link rel="stylesheet" href="<?php echo e(asset("/node_modules/alertifyjs/build/css/themes/default.min.css")); ?>" />

        <link rel="stylesheet" href="<?php echo e(asset("/node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.css")); ?>">




        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->



        <?php /*JQuery*/ ?>
        <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/jQuery/jQuery-2.2.0.min.js")); ?>"></script>

        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo e(asset("/node_modules/admin-lte/plugins/select2/select2.min.css")); ?>">
        <!-- Select2 -->
        <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/select2/select2.full.min.js")); ?>"></script>
        <!-- InputMask -->
        <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/input-mask/jquery.inputmask.js")); ?>"></script>
        <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js")); ?>"></script>
        <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/input-mask/jquery.inputmask.extensions.js")); ?>"></script>


        <!-- bootstrap datepicker -->
        <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/datepicker/bootstrap-datepicker.js")); ?>"></script>
        <link rel="stylesheet" href="<?php echo e(asset("/node_modules/admin-lte/plugins/datepicker/datepicker3.css")); ?>">

        <!-- ... -->
        <?php /*<script type="text/javascript" src="<?php echo e(asset("/bower_components/jquery/jquery.min.js")); ?>"></script>*/ ?>
        <script type="text/javascript" src="<?php echo e(asset("/bower_components/moment/min/moment.min.js")); ?>"></script>
        <script type="text/javascript" src="<?php echo e(asset("/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js")); ?>"></script>
        <link rel="stylesheet" href="<?php echo e(asset("/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css")); ?>" />

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
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <!-- Menu toggle button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li>
                                    <!-- inner menu: contains the messages -->
                                    <ul class="menu">
                                        <li><!-- start message -->
                                            <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <img src="<?php echo e(asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg")); ?>" class="img-circle" alt="User Image"/>
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <!-- The message -->
                                                <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li><!-- end message -->
                                    </ul><!-- /.menu -->
                                </li>
                                <li class="footer"><a href="#">See All Messages</a></li>
                            </ul>
                        </li><!-- /.messages-menu -->

                        <!-- Notifications Menu -->
                        <li class="dropdown notifications-menu">
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
                        </li>
                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="<?php echo e(asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg")); ?>" class="user-image" alt="User Image"/>
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">Alexander Pierce</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- The user image in the menu -->
                                <li class="user-header">
                                    <img src="<?php echo e(asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg")); ?>" class="img-circle" alt="User Image" />
                                    <p>
                                        Alexander Pierce - Web Developer
                                        <small>Member since Nov. 2012</small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo e(url('/doLogout')); ?>" class="btn btn-default btn-flat">Sign out</a>
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
                        <img src="<?php echo e(asset("/node_modules/admin-lte/dist/img/user2-160x160.jpg")); ?>" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p>Alexander Pierce</p>
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
                    <li class="active"><a href="<?php echo e(url('dashboard')); ?>"><span>Dashboard</span></a></li>
                    <li><a href="<?php echo e(url('customers')); ?>"><span>Customers</span></a></li>
                    <li><a href="<?php echo e(url('vehicles')); ?>"><span>Vehilcles</span></a></li>
                    <li><a href="<?php echo e(url('drivers')); ?>"><span>Drivers</span></a></li>
                    <li class="treeview">
                        <a ><span>Sales</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo e(url('addOrder')); ?>">Add Order</a></li>
                            <li><a href="<?php echo e(url('deliverdOrders')); ?>">Delivered Orders</a></li>
                            <li><a href="<?php echo e(url('notDeliveredOrders')); ?>">Orders Not Delivered</a></li>
                            <li><a href="<?php echo e(url('returnedProducts')); ?>">Returned Products</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo e(url('products')); ?>"><span>Products</span></a></li>
                    <li><a href="<?php echo e(url('companies')); ?>"><span>Companies</span></a></li>
                    <li class="treeview">
                        <a><span>Zones</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li><a href="<?php echo e(url('customerZones')); ?>">Customer Zones</a></li>
                            <li><a href="<?php echo e(url('vehicleZones')); ?>">Vehicle Zones</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo e(url('register')); ?>"><span>Register Users</span></a></li>
                </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
                <!-- Your Page Content Here -->
            <?php echo $__env->yieldContent('content'); ?>

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

<?php /*
    <script src="https://code.jquery.com/jquery-2.1.3.min.js" integrity="sha256-ivk71nXhz9nsyFDoYoGf2sbjrR9ddh+XDkCcfZxjvcM=" crossorigin="anonymous"></script>
*/ ?>


    <script src="<?php echo e(asset("/node_modules/alertifyjs/build/alertify.js")); ?>"></script>
    <script src="<?php echo e(asset("/node_modules/alertifyjs/build/alertify.min.js")); ?>"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo e(asset ("/node_modules/admin-lte/bootstrap/js/bootstrap.min.js")); ?>" type="text/javascript"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo e(asset ("/node_modules/admin-lte/dist/js/app.min.js")); ?>" type="text/javascript"></script>

    <?php /*datatable*/ ?>
    <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/datatables/jquery.dataTables.min.js")); ?>"></script>
    <script src="<?php echo e(asset("/node_modules/admin-lte/plugins/datatables/dataTables.bootstrap.min.js")); ?>"></script>



    <!-- Optionally, you can add Slimscroll and FastClick plugins.
          Both of these plugins are recommended to enhance the
          user experience -->
    <script type="text/javascript">
        $('.select2').select2();
    </script>

    </body>
</html>