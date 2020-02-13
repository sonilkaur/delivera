<!DOCTYPE html>
<html lang="en">
    <!-- Mirrored from themesdesign.in/drixo/horizontal/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Nov 2018 09:34:00 GMT -->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
        <title>Delivera --Seller Panel</title>
        <meta content="Admin Dashboard" name="description">
        <meta content="ThemeDesign" name="author">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo.png">
        <!-- jQuery  -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

        <!--Morris Chart CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/morris/morris.css">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
        <!-- Magnific popup -->
        <link href="<?php echo base_url(); ?>assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
        <!-- DataTables -->
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">
        <!-- Responsive datatable examples -->
        <link href="<?php echo base_url(); ?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

        <link href="<?php echo base_url() ?>assets/plugins/file_uploader/jquery.fileuploader.min.css" media="all" rel="stylesheet">

    </head>

    <body>
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner"></div>
            </div>
        </div>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="topbar-main">
                <div class="container-fluid">
                    <!-- Logo container-->
                    <div class="logo">
                        <!-- Image Logo -->
                        <a href="<?php echo base_url(); ?>seller/home/" class="logo">
                            <?php //$this->db->get('admin')?>
                            <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="" height="32" class="logo-small">
                            <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="" height="" class="logo-large">
                        </a>
                    </div>
                    <!-- End Logo container-->
                    <div class="menu-extras topbar-custom">
                        <ul class="list-inline float-right mb-0">
                            <!-- Search -->
                            <li class="list-inline-item dropdown notification-list d-none d-sm-inline-block">
                               
                            </li>
                            <li class="list-inline-item dropdown notification-list"><a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><i class="mdi mdi-bell-outline noti-icon"></i> <span id="count" class="badge badge-success badge-pill noti-icon-badge"></span></a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg">
                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5>Notification</h5></div>
                                    <div class="slimscroll" id="noti" style="max-height: 230px;">

                                    </div>
                                    <!-- All--><a href="javascript:void(0);" class="dropdown-item notify-all">View All</a></div>
                            </li>
                            <!-- User-->
                            <li class="list-inline-item dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <?php
                                    $id = $_SESSION['sellerid'];
                                    //print_r($id);
                                    $res = $this->db->query("select * from store where storeId='$id'")->row();
                                    // print_r($this->db->last_query());
                                    $img = $res->logo;
                                    if($img){
                                    ?>
                                    <img src="<?php echo base_url() . $img; ?>" alt="user" class="rounded-circle">
                                    <?php } else{?>
                                     <img src="<?php echo base_url() ?>assets/images/dummy.jpg" alt="user" class="rounded-circle">
                                    <?php }?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown"><a class="dropdown-item" href="<?php echo base_url(); ?>seller/home/settings/"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>   <a class="dropdown-item" href="<?php echo base_url(); ?>seller/home/logout/"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                                </div>
                            </li>
                            <li class="menu-item list-inline-item">
                                <!-- Mobile menu toggle-->
                                <a class="navbar-toggle nav-link">
                                    <div class="lines"><span></span>  <span></span>  <span></span>
                                    </div>
                                </a>
                                <!-- End mobile menu toggle-->
                            </li>
                        </ul>
                    </div>
                    <!-- end menu-extras -->
                    <div class="clearfix"></div>
                </div>
                <!-- end container -->
            </div>
            <!-- end topbar-main -->
            <!-- MENU Start -->
            <div class="navbar-custom">
                <div class="container-fluid">
                    <div id="navigation">
                        <!-- Navigation Menu-->
                        <ul class="navigation-menu">
                            <li class="has-submenu"><a href="<?php echo base_url(); ?>seller/home/dashboard/"><i class="dripicons-meter"></i>Dashboard</a>
                            </li>
                            <li class="has-submenu"><a href="#"><i class="dripicons-briefcase"></i>Items</a>
                                <ul class="submenu megamenu">
                                    <li>
                                        <ul>
                                            <li><a href="<?php echo base_url(); ?>seller/item/addItem">Add Item</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>seller/item/">View Item</a>
                                            </li>


                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!--<li class="has-submenu"><a href="#"><i class="dripicons-user"></i>Users</a>-->

                            <li class="has-submenu"><a href="<?php echo base_url(); ?>seller/order/"><i class="dripicons-view-thumb"></i>Orders</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url(); ?>seller/order/">All Orders</a>
                                    </li>
                                </ul>

                            </li>
                            <li class="has-submenu"><a href="<?php echo base_url(); ?>seller/order/earnings"><i class="ion-social-usd"></i>Earnings</a>


                            </li>
                            <li class="has-submenu">
                                <a href="#"><i class="dripicons-gear"></i>Settings</a>
                                <ul class="submenu">
                                    <li><a href="<?php echo base_url(); ?>seller/home/settings">General</a>
                                    </li>
                                    <li><a href="<?php echo base_url(); ?>seller/item/tax">Tax</a>
                                    </li>
                                    <li><a href="<?php echo base_url(); ?>seller/order/promo_code">Promo Code</a>
                                    </li>
                                </ul> 

                            </li>


                        </ul>
                        <!-- End navigation menu -->
                    </div>
                    <!-- end #navigation -->
                </div>
                <!-- end container -->
            </div>
            <!-- end navbar-custom -->
        </header>