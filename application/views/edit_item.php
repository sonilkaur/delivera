
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
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>item/">Items</a></li>
                           <li class="breadcrumb-item"><a href="#">Edit Item</a></li>
                          
                        </ol>
                     </div>
                     <h4 class="page-title">Edit Item</h4>
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
                                  <form action="<?php echo base_url();?>item/edit_process/<?php echo $result[0]->itemId;?>" method="post" enctype="multipart/form-data">
                                     
                                    <div class="form-group"><label>Category</label> 
                                        <input type="hidden" name="storeId" value="<?php //echo $_SESSION['sellerid'];?>">
                                        <select required onchange="getchild(this.value,<?php echo $result[0]->subCatId?>)" id="parent" name="categoryId" class="form-control">                    <option value="" selected disabled="disabled">
                                                select category
                                            </option>
                                            <?php foreach($cat as $parentcat){?>
                                            <option <?php  if($result[0]->categoryId==$parentcat->categoryId){echo "selected";} ?> value="<?php echo $parentcat->categoryId;?>"><?php echo $parentcat->name;?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="form-group"><label>Sub Category</label> 
                                        <select id="sub_cat" name="sub_cat" class="form-control">
                                        </select>
                                    </div>
                                     
                                    <div class="form-group"><label>Item Name</label> 
                                        <input type="text" placeholder="Item Name" value="<?php echo $result[0]->name;?>"required name="name"class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label> 
                                        <textarea name="description"  class="form-control"><?php echo $result[0]->description;?></textarea>
                                       
                                    </div>
                                    <div class="form-group"><label>Regular Price</label>
                                        <input type="number" value="<?php echo $result[0]->regularPrice;?>" required placeholder="Regular Price" name="regularPrice" class="form-control" min="1"> </div>
                                    <div class="form-group"><label>Offer Price</label>
                                        <input type="number" placeholder="Offer Price" value="<?php echo $result[0]->offerPrice;?>" name="offerPrice" class="form-control" min="1"> 
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
                                    <div class="form-group"><label>Featured Image</label>
                                        
                                       <p> <input type="file" accept="image/x-png, image/jpeg" name="image" class="form-control"> </p>
                                      <?php if($result[0]->featuredImage){ ?>
                                        <img src="<?php echo base_url().$result[0]->featuredImage;?>" width="150px" height="120px" />
                                      <?php } else{?>
                                        <img src="<?php echo base_url(); ?>assets/images/dummy.jpg" height="100px" width="100px">
                                      <?php }?>
                                    </div>
                                    <div class="form-group"><label>Gallery Image</label>
                                        <input type="file" id="gallery" name="files[]" multiple="">
                      </div>
                                      <div class="form-group row">
                                       <?php
                                        if (isset($result[0]->gallery)) {
                                            foreach($result[0]->gallery as $gallery){
                                            ?>
                                            <div class="col-md-3">
                                                <div class="thumbnail popup-gallery">
                                                    <a href="<?php echo base_url(). $gallery->image;?>">
                                                        <img src="<?php echo base_url(). $gallery->image;?>" alt="Nature" style="width:100%">
                                                    </a>
                                                   
                                                </div>
                                                 <a class="remove-image" onclick="remove(<?php echo $gallery->imageId;?>,'item/delete_image')"title="delete" href="#" style="display: inline;">&#215;</a>
                                            </div>
                                        <?php } } ?>
                                      </div>
                                    
                                      <div class="form-group">
                                         <button class="btn btn-primary btn_add" name="add_more_items" type="button" data-toggle="collapse" data-target="#add_more_items" aria-expanded="false" aria-controls="collapseExample">
                   <i class="ion-plus-circled"></i>  Add Extra Items
                                         </button>
                                        
                                          <div class="collapse" id="add_more_items">
                                            <div class="card card-body">
                                                 <div class="add_variation pull-right">
                                                    <button class="btn btn-primary add_item_btn"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                 </div>
                                              <div class="more_items">
                                                   <?php 
                                                 // print_r($result[0]->variations);
                                                  if($result[0]->more_items){
                                                    
                                                      ?>
                                                  
                                                  <?php foreach($result[0]->more_items as $moreitems){
                                                     // print_r($result[0]->variations);
                                                 
                                                      ?>
                                                 <div class="row">
                                                 
                                                    <div class="col-md-4">
                                                        <div class="form-group"><label>Item name</label>
                                                                            <input type="text" name="item[]" value="<?php echo $moreitems->name; ?>" class="form-control"> 
                                                                             <input type="hidden" name="item_id[]" value="<?php echo $moreitems->name; ?>">
                                                                            <input type="hidden" value="1" name="item_count[]" class="form-control"> 
                                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group"><label>Regular Price</label>
                                                            <input type="number" min="1" value="<?php echo $moreitems->price;?>" name="price[]" class="form-control"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                      
                                                                            <div class="form-group actions">

                                                                                <button type="button" class="btn btn-danger waves-effect waves-light"><a onclick="remove(<?php echo $moreitems->mItemId; ?>, 'item/delete_more_item/')" href="#" class=""><i class="fa fa-close"></i>Remove</a></button>
                                                                               <!-- <a onclick="remove(<?php echo $variation->variationId; ?>,'seller/item/delete_item_variation/')" href="#" class=""><i class="fa fa-close"></i>Remove</a>-->

                                                                            </div>
                                                                       
                                                    </div>
                                                  </div>
                                                  <?php }}?>
                                                </div>
                                            
                                            </div>
                                        </div>
                                        
                                    </div>
                                      
                                      
                                    <div class="form-group">
                                 
                    <button class="btn btn-primary btn_add" name="add_variation" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                   <i class="ion-plus-circled"></i>  Add Variations
                   </button>
                                            
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body">
                                                 <div class="add_variation pull-right">
                                                    <button class="btn btn-primary add_field_button"> <i class="fa fa-plus" aria-hidden="true"></i></button>
                                                 </div>
                                              <div class="variations">
                                                  <?php 
                                                 // print_r($result[0]->variations);
                                                  if($result[0]->variations){
                                                    
                                                      ?>
                                                  
                                                  <?php foreach($result[0]->variations as $variation){
                                                     // print_r($result[0]->variations);
                                                 
                                                      ?>
                                                 <div id="vari">
                                                <div class="row">
                                                 
                                                    <div class="col-md-3">
                                                        <div class="form-group"><label>Options</label>
                                                            <input type="text" value="<?php echo $variation->options;?>" name="options[]" class="form-control"> 
                                                            <input type="hidden" name="var_id[]" value="<?php echo $variation->variationId;?>">
                                                            <input type="hidden" name="count[]" value="1">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group"><label>Regular Price</label>
                                                             <input type="text" value="<?php echo $variation->regularPrice;?>" name="reg_price[]" class="form-control"> 
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group"><label>Sale Price</label>
                                                             <input type="number" value="<?php echo $variation->offerPrice;?>" name="off_price[]" class="form-control">                                                         </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                      <div class="form-group actions">
                                                         
                                                    <button type="button" class="btn btn-danger waves-effect waves-light"><a onclick="remove(<?php echo $variation->variationId;?>,'item/delete_item_variation/')" href="#" class=""><i class="fa fa-close"></i>Remove</a></button>
                                                   <!-- <a onclick="remove(<?php echo $variation->variationId;?>,'seller/item/delete_item_variation/')" href="#" class=""><i class="fa fa-close"></i>Remove</a>-->
                                                   
                                                    </div>
                                                    </div>
                                                  
                                                  </div>
                                                 </div>
                                                  <?php }?>
                                                  <?php }?>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>
                                      <div class="form-group row">
                                          <div class="col-md-12">
                                          <h4>Seller Information</h4>
                                          <p><b>Name</b> : <?php echo $result[0]->storename;?></p>
                                          <p><b>Contact Email</b> : <?php echo $result[0]->contactEmail;?></p>
                                          <p><b>Contact Number</b> : <?php echo $result[0]->contactNumber;?></p>
                                          </div>
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
      