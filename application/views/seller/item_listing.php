<style>
    span.action{
            padding: 11px;
    font-size: 20px;
    }
    
</style>
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
                           <li class="breadcrumb-item"><a href="#">Items</a></li>
                          
                        </ol>
                        
                     </div>
                     <h4 class="page-title">Items</h4>
                      <a href="<?php echo base_url();?>seller/item/addItem/"> <button type="button" class="btn btn-primary waves-effect waves-light ">Add</button></a>
                       
                  </div>
               </div>
            </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <?php if(isset($result)){?>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <?php //echo"<pre>"; print_r($data);?>
                           <thead>
                              <tr>
<!--                                  <th>Id</th>-->
                                 <th>Sr.No.</th>
                                 <th class="no-sort">Image</th>
                                 <th>Item Name</th>
                                 <th>Category</th>
                                 <th>Regular Price</th>
                                 <th>Offer Price</th>
                                 
                                 <th class="no-sort">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                               <?php $i=1;foreach($result as $item){?>
                            
                              <tr>
                                  <td><?php echo $i;$i++;?></td>
<!--                                  <td><?php// echo $item->itemId;?></td>-->
                                  <td>
                                      <div class="popup-gallery">
                                          <a class="" href="<?php echo base_url();?><?php echo $item->featuredImage;?>" title="<?php echo $item->name;?>">
                                              <?php if($item->featuredImage){?>
                                              <img height="50px" width="100px" src="<?php echo base_url();?><?php echo $item->featuredImage;?>" alt="" width="275" class="img-fluid">
                                              <?php }else {?>
                                              <img height="50px" width="100px" src="<?php echo base_url();?>assets/images/dummy.jpg" alt="" width="275" class="img-fluid">
                                              <?php }?>
                                          </a>
                                      </div> 
                                  </td>
                                 <td><?php echo $item->name;?></td>
                                 
                                 <td><?php echo $item->categoryName;?></td>
                                 <td><?php echo $item->regularPrice;//echo $restaurant->address;?></td>
                                 <td><?php echo $item->offerPrice;?></td>
                                 <td>
                                     <span class="action">
                                     <a href="<?php echo base_url()?>seller/item/edit/<?php echo $item->itemId;?>">
                                         <i class="fa fa-pencil-square-o" title="edit" aria-hidden="true"></i>
                                     </a>
                                      </span>|
                                     <span  class="action">
                                     <a href="#" id="delete" onclick="remove(<?php echo $item->itemId;?>,'seller/item/delete')">
                                         <i class="fa fa-trash" aria-hidden="true"></i>
                                     </a>
                                     </span>
                                 </td>
                              </tr>
                               <?php }?>
                             
                            
                           </tbody>
                        </table>
                        <?php } else{?>
                         <div class="">No Record Found</div>
                        <?php }?>
                     </div>
                  </div>
               </div>
               <!-- end col -->
            </div>
          
                         
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
      