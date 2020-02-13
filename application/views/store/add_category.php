
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>store/category">Stores Categories</a></li>
                            <li class="breadcrumb-item"><a href="#">Add Store Category</a></li>

                        </ol>
                    </div>
                    <h4 class="page-title">Add Store Category</h4>
                </div>
            </div>
        </div>

        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Add Details</h4>
                        <?php if ($this->session->userdata('error')) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $this->session->userdata('error'); ?>
                            </div>
                        <?php } ?>
                        <?php if ($this->session->userdata('success')) { ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $this->session->userdata('success'); ?>
                            </div>
                        <?php } ?>
                        <form action="<?php echo base_url(); ?>store/add_category_process" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10"><input name="cat_name"class="form-control" required placeholder="Store Category Name" type="text"  id="example-text-input"></div>
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
