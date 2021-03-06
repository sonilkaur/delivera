<!DOCTYPE html>
<html lang="en">
    <!-- Mirrored from themesdesign.in/drixo/horizontal/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Nov 2018 09:35:27 GMT -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
        <title>Delivera- Admin</title>
        <meta content="Admin Dashboard" name="description">
        <meta content="ThemeDesign" name="author">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="assets/images/logo.png">
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css">
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v6.0&appId=571381896922903&autoLogAppEvents=1"></script>
    </head>
    <body class="pb-0">
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner"></div>
            </div>
        </div>
        <!-- Begin page -->
        <div class="accountbg">
            <div class="content-center">
                <div class="content-desc-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-center mt-0 m-b-15"><a href="<?php echo base_url(); ?>admin" class="logo logo-admin"><img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo"></a></h3>
                                        <h4 class="text-muted text-center font-18"><b>Sign In</b></h4>
                                        <div class="p-2">
                                            <?php if ($this->session->userdata('error')) { ?>
                                                <div class="alert alert-info" role="alert">
                                                    <?php echo $this->session->userdata('error'); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal m-t-20" action="<?php echo base_url(); ?>admin/login_auth" method="post">
                                                <div class="form-group row">
                                                    <div class="col-12"><input class="form-control" name="email" type="text" required="" placeholder="Email"></div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12"><input class="form-control" name="password" type="password" required="" placeholder="Password"></div>
                                                </div>

                                                <div class="form-group text-center row m-t-20">
                                                    <div class="col-12"><button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button></div>
                                                </div>


                                                <div class="fb-login-button form-group text-center row m-t-20 col-12" data-width="" data-size="large" data-button-type="continue_with" data-auto-logout-link="false" data-use-continue-as="false"></div>
                                                <div class="form-group m-t-10 mb-0 row text-center">
                                                    <div class="col-sm-12 m-t-20"><a href="<?php echo base_url(); ?>admin/forgot_password/" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a></div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>
        <!-- jQuery  --><script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script><script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script><script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script><script src="<?php echo base_url(); ?>assets/js/detect.js"></script><script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script><script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script><script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script><script src="<?php echo base_url(); ?>assets/js/waves.js"></script><!-- App js --><script src="<?php echo base_url(); ?>assets/js/app.js"></script>
    </body>
    <!-- Mirrored from themesdesign.in/drixo/horizontal/pages-login.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Nov 2018 09:35:27 GMT -->
</html>