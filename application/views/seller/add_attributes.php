
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
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/item/">Items</a></li>
                            <li class="breadcrumb-item"><a href="#">Add Attributes</a></li>

                        </ol>
                    </div>
                    <h4 class="page-title">Add Attributes</h4>
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
                                    <form action="<?php echo base_url(); ?>seller/item/add_process" method="post" enctype="multipart/form-data">

                                       
                                      
                                        <div class="form-group"><label>Item Name</label> 
                                            <input type="text" placeholder="Item Name" required name="name" class="form-control">
                                        </div>
                                      
                                       
                                       
                                        
                                       
                                        <div class="form-group1 ">
                                         <label>Status</label>
                              </div>
                                    <div class="btn-group btn-group-toggle form-group" data-toggle="buttons">
                                        <label class="btn btn-secondary active focus">
                                            <input type="radio" name="status" value="1" checked="" > Active
                                        </label>

                                        <label class="btn btn-secondary ">
                                            <input type="radio" name="status" value="0"> Inactive
                                        </label>
                                    </div>  
                                        <div class="form-group"><label>Featured Image</label>
                                            <input type="file" name="image" class="form-control"> 
                                        </div>
                                        <div class="form-group"><label>Gallery Image</label>
                                        <input type="file" id="gallery" name="files[]" multiple="">
                      </div>
                                        <?php
                                       // $categoryId = $_SESSION['category'];
                                        //if ($categoryId == 5) {
                                            ?>
                                            <div class="form-group">
                                                <button class="btn btn-primary btn_add" name="add_more_items"type="button" data-toggle="collapse" data-target="#add_more_items" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="ion-plus-circled"></i>  Add More Items
                                                </button>

                                                <div class="collapse" id="add_more_items">
                                                    <div class="card card-body">
                                                        <div class="add_variation pull-right">
                                                            <button class="btn btn-primary add_item_btn"> <i class="fa fa-plus" aria-hidden="true"></i></button>
                                                        </div>
                                                        <div class="more_items">
                                                           
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            <?php
                                       // } else {
//$_SESSION['category'];
                                            ?>
                                            <div class="form-group">

                                                <button class="btn btn-primary btn_add" name="add_variation"type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                                    <i class="ion-plus-circled"></i>  Add Variations
                                                </button>

                                                <div class="collapse" id="collapseExample">
                                                    <div class="card card-body">
                                                        <div class="add_variation pull-right">
                                                            <button class="btn btn-primary add_field_button"> <i class="fa fa-plus" aria-hidden="true"></i></button>
                                                            <a href="<?php echo base_url();?>seller/item/add_attributes"> <button class="btn btn-primary"> Add Attributes</button></a>
                                                        </div>
                                                        <div class="variations" id="refresh">
                                                          
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        <?php //} ?>
                                        <div class="form-group row">

                                            <div class="col-sm-12">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url();?>seller/item/"> <button type="button" class="btn btn-secondary">Cancel</button></a>
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
     $('.nos').hide();
      $( "#manage_stock" ).change(function() {            
    if($(this).val()=='1'){
        $('.nos').show();
         $('#stock').attr('required',true);
    }
    else{
       
           $('.nos').hide();
            $('#stock').attr('required',false);
    }
});
</script>
