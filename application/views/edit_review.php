
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
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>seller/home/">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?=base_url()?>order/reviews/">Order Reviews</a></li>
                           <li class="breadcrumb-item"><a href="#">Edit Review</a></li>
                          
                        </ol>
                     </div>
                     <h4 class="page-title">Edit Review</h4>
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
                                   <?php if($this->session->flashdata('error')){?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('error');?>
                        </div>
                        <?php }?>
                        <?php if($this->session->flashdata('success')){?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('success');?>
                        </div>
                        <?php }
                          $this->session->unset_userdata('error');
                        ?>
                                  <form action="<?php echo base_url();?>order/edit_review_process/<?php echo $result[0]->itemReviewId;?>" method="post" enctype="multipart/form-data">
                                     
                                    <div class="form-group"><label>Rating</label>
                                        <input type="number" value="<?php echo $result[0]->rating;?>" required placeholder="Rating" name="rating" class="form-control" min="0" max="5" step="0.01" > </div>
                                    <div class="form-group"><label>Review</label>
                                        <input type="text" placeholder="Reviews" value="<?php echo $result[0]->review;?>" name="review" class="form-control"> 
                                    </div>
                                       <div class="form-group1 ">
                                         <label>Status</label>
                              </div>
                                    <div class="btn-group btn-group-toggle form-group" data-toggle="buttons">
                                        <label class="btn btn-secondary <?php if($result[0]->is_active=='1'){echo 'active focus';}?>">
                                            <input type="radio" name="status" value="1"  <?php if($result[0]->is_active=='1'){echo 'checked';}?>> Active
                                        </label>

                                        <label class="btn btn-secondary <?php if($result[0]->is_active=='0'){echo 'active focus';}?>">
                                            <input type="radio" name="status" value="0"  <?php if($result[0]->is_active=='0'){echo 'checked';}?>> Inactive
                                        </label>
                                    </div> 
                                      
                                     <div class="form-group row">
                           
                              <div class="col-sm-12">
                                  <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <button type="reset" class="btn btn-secondary waves-effect ">Cancel</button>
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
          
        
          
  function getchild(id,subid) {
      //alert(subid);return false;
      if(id=='11')
      {
           $('#attributes').hide();
      }
      else{
          $('#attributes').show();
      }
      
    if (id ) {
         $.ajax ({
                type: 'POST',
                url: '<?php echo base_url();?>/item/getChildCat',
                data: { catid: id ,subId:subid},
                //datatype:'json',
                success : function(htmlresponse) {
                   // alert(htmlresponse);
                    $('#sub_cat').html(htmlresponse);
                   // alert(htmlresponse);
                },error:function(e){
               // alert("error");
            }
            });
       
    }
}
$("#parent").trigger("change");
      </script>
      