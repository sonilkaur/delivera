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
                           <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="#">Restaurant</a></li>
                          
                        </ol>
                        
                     </div>
                     <h4 class="page-title">Restaurants</h4>
                      <a href="<?php echo base_url();?>restaurant/add/"> <button type="button" class="btn btn-primary waves-effect waves-light ">Add</button></a>
                       
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
                                 <th>Image</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Address</th>
                                 <th>Phone</th>
                                 
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                               <?php foreach($data as $restaurant){?>
                               <?php //print_r($restaurant->id)?>
                              <tr>
                                  <td><img src="<?php echo base_url();?><?php echo $restaurant->image;?>" height="50px" width="100px"></td>
                                 <td><?php echo $restaurant->name;?></td>
                                 <td><?php echo $restaurant->email;?></td>
                                 <td><?php echo $string = substr($restaurant->address,0,50);//echo $restaurant->address;?>...</td>
                                 <td><?php echo $restaurant->phone;?></td>
                                 <td>
                                     <span class="action">
                                     <a href="<?php echo base_url()?>restaurant/edit/<?php echo $restaurant->user_id;?>">
                                         <i class="fa fa-pencil-square-o" title="edit" aria-hidden="true"></i>
                                     </a>
                                      </span>|
                                     <span  class="action">
                                     <a href="#" id="delete" onclick="update_service_status(<?php echo $restaurant->user_id;?>)">
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
     