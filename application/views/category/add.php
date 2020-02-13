
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="header_title">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>category/"> categories</a></li>
                                <li class="breadcrumb-item"><a href="#">Add New Category</a></li>

                            </ol>
                        </div>
                        <h4 class="page-title">Add New Category</h4>
                    </div>
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
                        <form action="<?php echo base_url(); ?>category/add_process" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Category Name</label>
                                <div class="col-sm-10">
                                    <input name="name" class="form-control"  placeholder="Category Name" value="<?php if (isset($name)) echo $name; ?>" type="text"  id="example-text-input" required="">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Parent Category</label>
                                <div class="col-sm-10">
                                    <select name="sub_cat" class="form-control" required="">
                                        <option >Select Parent Category</option>
                                        <?php if ($info) { ?>
                                            <?php
                                            foreach ($info as $cat) {
                                                // print_r($key);
                                                ?>

                                                <option value="<?php echo $cat->categoryId; ?>" <?php if (isset($sub_cat)) if ($sub_cat = $cat->categoryId) echo 'selected' ?>><?php echo $cat->name; ?></option>
                                            <?php }
                                        }else {
                                            ?>
                                            <option value="0"></option>
                                        <?php } ?>

                                    </select>
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" accept="image/x-png, image/jpeg" class="form-control" name="image"/>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url(); ?>category"><button type="button" class="btn btn-secondary">Cancel</button></a>
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
