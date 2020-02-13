<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from themesdesign.in/drixo/horizontal/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Nov 2018 09:34:00 GMT -->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
	<title>Admin-Delivera</title>
	<meta content="Admin Dashboard" name="description">
	<meta content="ThemeDesign" name="author">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="shortcut icon" href="<?php echo base_url();?>assets/images/logo.png">
        
	<!--Morris Chart CSS -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/morris/morris.css">
        <!-- C3 charts css --><link href="<?php echo base_url();?>assets/plugins/c3/c3.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css">
	<link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet" type="text/css">
         <!-- DataTables -->
      <link href="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
<!--      <link href="<?php echo base_url();?>assets/plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
       <link href="<?php echo base_url();?>assets/plugins/dropzone/dist/dropzone.css" rel="stylesheet" type="text/css">-->
       
       <link href="<?php echo base_url();?>assets/plugins/magnific-popup/magnific-popup.css" rel="stylesheet" type="text/css">
      <!-- Responsive datatable examples -->
      <link href="<?php echo base_url();?>assets/plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
       <link href="<?php echo base_url();?>assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url()?>assets/plugins/file_uploader/jquery.fileuploader.min.css" media="all" rel="stylesheet">
   
   

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/css/ion.rangeSlider.min.css"/>
      <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

     
      <!-- jQuery  -->
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
        
     <script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.0/js/ion.rangeSlider.min.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
  

</head>

<body>
	<!-- Loader 
	<div id="preloader">
		<div id="status">
			<div class="spinner"></div>
		</div>
	</div>-->
	<!-- Navigation Bar-->
	<header id="topnav">
		<div class="topbar-main">
			<div class="container-fluid">
				<!-- Logo container-->
				<div class="logo">
					<!-- Image Logo -->
					<a href="<?php echo base_url();?>admin/dashboard/" class="logo">
                                            <?php //$this->db->get('admin')?>
						<img src="<?php echo base_url();?>assets/images/logo.png" alt="" height="32" class="logo-small">
						<img src="<?php echo base_url();?>assets/images/logo.png" alt=""  class="logo-large">
					</a>
				</div>
				<!-- End Logo container-->
				<div class="menu-extras topbar-custom">
					<ul class="list-inline float-right mb-0">
						
						<!-- User-->
                                                <li class="list-inline-item dropdown notification-list"><a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false"><i class="mdi mdi-bell-outline noti-icon"></i> <span id="count" class="badge badge-success badge-pill noti-icon-badge"></span></a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg">
                                <!-- item-->
                                <div class="dropdown-item noti-title">
                                    <h5>Notification</h5></div>
                                <div class="slimscroll" id="noti" style="max-height: 230px;">
                                    <!-- item-->
                                   
                                </div>
                                <!-- All--><a href="<?php echo base_url();?>order" class="dropdown-item notify-all">View All</a></div>
                        </li>
						<li class="list-inline-item dropdown notification-list">
							<a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false">
                                                            <?php
                                                            if(empty($_SESSION['id']))
                                                            {
                                                                redirect(base_url().'admin/');
                                                            }
                                                            $id=$_SESSION['id'];
                                                               $res=$this->db->query("select * from admin where adminid='$id'")->row();
                                                            $img=$res->photo;
                                                            ?>
								<img src="<?php echo base_url().$img;?>" alt="user" class="rounded-circle">
							</a>
                                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown"><a class="dropdown-item" href="<?php echo base_url();?>admin/profile"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>   <a class="dropdown-item" href="<?php echo base_url();?>admin/logout/"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
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
                                            <li class="has-submenu"><a href="<?php echo base_url();?>admin/dashboard/"><i class="dripicons-meter"></i>Dashboard</a>
						</li>
						<li class="has-submenu"><a href="#"><i class="dripicons-user"></i>Users</a>
							<ul class="submenu megamenu">
								<li>
									<ul>
                                                                            <li><a href="<?php echo base_url();?>store/">Store</a>
										</li>
										<li><a href="<?php echo base_url();?>deliveryBoy/">Delivera Rider</a>
										</li>
                                                                                <li><a href="<?php echo base_url();?>user/">Users</a>
										</li>
										
									</ul>
								</li>
							</ul>
						</li>
						<li class="has-submenu"><a href="#"><i class="dripicons-view-list"></i>Items</a>
							<ul class="submenu">
                                                            <li><a href="<?php echo base_url();?>item/">All Items</a>
								</li>
                                                               
							</ul>
						</li>
						<li class="has-submenu"><a href="#"><i class="dripicons-tags"></i>Category</a>
							<ul class="submenu">
                                                            <li><a href="<?php echo base_url();?>category">All Categories</a>
								</li>
                                                               <!-- <li><a href="<?php echo base_url();?>store/category/">Store Categories</a>-->
								</li>
								
								
							</ul>
						</li>
						<li class="has-submenu"><a href="<?php echo base_url();?>order/"><i class="dripicons-cart"></i>Orders</a></li>
						<li class="has-submenu"><a href="#"><i class="dripicons-wallet"></i>Payments</a>
                                                <ul class="submenu">
                                                            <li>
                                                                <a href="<?php echo base_url();?>order/payments"></i>Store Payments</a>
								</li>
                                                              <li>
                                                                  <a href="<?php echo base_url();?>order/driver_payments">Delivera Rider's Payments</a>
								</li>
                                                </ul>
                                                </li>
						<li class="has-submenu"><a href="<?php echo base_url();?>order/earnings"><i class="ion-social-usd"></i>Earnings</a></li>
<!--                                                <li class="has-submenu"><a href="<?php echo base_url();?>admin/view_notifications"><i class="dripicons-broadcast"></i>Notifications</a></li>-->
                                                <li class="has-submenu"><a href="#"><i class="dripicons-gear"></i>Settings</a>
							<ul class="submenu">
                                                            <li><a href="<?php echo base_url();?>admin/profile">Edit Profile</a>
								</li>
                                                              <li><a href="<?php echo base_url();?>admin/promo_code/">Promo Code</a>
								</li>
                                                              <li><a href="<?php echo base_url();?>admin/delivery_charges/">Delivery Charges</a>
								</li>
                                                              <li><a href="<?php echo base_url();?>admin/driver_commission/">Delivera Rider's Commission</a>
								</li>
                                                              <li><a href="<?php echo base_url();?>admin/view_notifications/">Send Notifications</a>
								</li>
								 <li><a href="<?php echo base_url();?>order/reviews/">Manage Reviews</a> 
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