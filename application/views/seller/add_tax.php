
<!-- End Navigation Bar-->
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
         <div class="header_title">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/home/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/item/tax">Tax</a></li>
                            <li class="breadcrumb-item"><a href="#">Add Tax</a></li>

                        </ol>
                    </div>
                    <h4 class="page-title">Add Tax</h4>
                </div>
            </div>
        </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-12 col-md-offset-6">
                                <div class="p-20">
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
                                    <form action="<?php echo base_url(); ?>seller/item/add_tax_process" method="post" enctype="multipart/form-data">

                                       

                                        <div class="form-group"><label>Tax Name</label> 
                                            <input type="text" placeholder="Tax Name" required name="name"class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Rate(%)</label> 
                                            <input type="number" min="1" required="" placeholder="Rate" name="rate"  class="form-control"> 
                                        </div>
                                       
                                       
                                        <div class="form-group row">

                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url();?>seller/item/tax"> <button type="button" class="btn btn-secondary">Cancel</button></a>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- end col -->
                        </div>
                        <!-- end row -->
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



    function getchild(id) {
//alert(id);
        if (id) {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>seller/item/getChildCat',
                data: {catid: id},
                //datatype:'json',
                success: function (htmlresponse) {
                    // alert(htmlresponse);
                    $('#sub_cat').html(htmlresponse);
                    // alert(htmlresponse);
                }, error: function (e) {
                    alert("error");
                }
            });

        }
    }
</script>
