
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>

                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/driver_commission">Delivera Rider Commission</a></li>
                            <li class="breadcrumb-item"><a href="#">Add Delivera Rider Commission</a></li>

                        </ol>
                    </div>
                    <h4 class="page-title">Add Delivera Rider Commission</h4>
                </div>
            </div>
        </div>

        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12 ">
                <div class="card m-b-30">
                    <div class="card-body">

                        <?php if ($this->session->userdata('error')) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $this->session->userdata('error'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->userdata('success')) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $this->session->userdata('success'); ?>
                            </div>
                        <?php } 
                          $this->session->unset_userdata('error');
                          $this->session->unset_userdata('success');
                        ?>
                        <form action="<?php echo base_url(); ?>admin/add_driver_commission_process" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Distance(Below) in KM</label>
                               
                                <div class="col-sm-10">
                                    <input type="text" class="js-range-slider" name="distance" value="" />
                                   
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Delivera Rider Commission</label>
                                <div class="col-sm-10">
                                   
                                    <input type="number" name="rate" class="form-control">

                                </div>
                            </div>

                         
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <button type="reset" class="btn btn-secondary waves-effect ">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end wrapper --><!-- Footer -->
<script>

$(".js-range-slider").ionRangeSlider({
    
     type: "double",
        grid: true,
        min: 0,
        max: 100,
        from: 10,
        to: 50,
        postfix: "KM",
        step:1
});
</script>