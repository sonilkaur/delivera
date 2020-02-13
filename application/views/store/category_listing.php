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
            <div class="row">
               <div class="col-sm-12">
                  <div class="page-title-box">
                     <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="#">Store Category</a></li>
                          
                        </ol>
                        
                     </div>
                     <h4 class="page-title">Store Categories</h4>
                      <a href="<?php echo base_url();?>store/add_store_category/"> <button type="button" class="btn btn-primary waves-effect waves-light ">Add Category</button></a>
                       
                  </div>
               </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <?php if(isset($data)){?>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <?php //echo"<pre>"; print_r($data);?>
                           <thead>
                              <tr>
                                 <th>Id</th>
                                 <th>Name</th>
                                 <th>created on</th>
                                 <th>updated At</th>
                              
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                               <?php foreach($data as $category){?>
                               <?php //print_r($restaurant->id)?>
                              <tr>
                                  
                                 <td><?php echo $category->storeCatId;?></td>
                                 <td><?php echo $category->categoryName;?></td>
                                
                                 <td><?php 
                                 echo date_format (new DateTime($category->createdOn), 'd F Y, h:i:s A');
                                // echo $category->createdOn;?></td>
                                 <td><?php
                                 
//                                 $myDateTime = DateTime::createFromFormat('Y-m-d', $weddingdate);
//$formattedweddingdate = $myDateTime->format('d-m-Y');
//                                 
                                echo date_format (new DateTime($category->updatedAt), 'd F Y, h:i:s A');
                                 // echo date_format( $category->updatedAt, 'd F Y, h:i:s A');
                                 //echo $category->updatedAt;?></td>
                               
                                 <td>
                                     <span class="action">
                                     <a href="<?php echo base_url()?>store/edit_store_category/<?php echo $category->storeCatId;?>">
                                         <i class="fa fa-pencil-square-o" title="edit" aria-hidden="true"></i>
                                     </a>
                                      </span>|
                                     <span  class="action">
                                     <a href="#" id="delete" onclick="remove(<?php echo $category->storeCatId;?>,'store/delete_store_category')">
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
     