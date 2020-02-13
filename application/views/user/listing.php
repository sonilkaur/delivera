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
                           <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="#">Users</a></li>
                          
                        </ol>
                        
                     </div>
                     <h4 class="page-title">Users</h4>
                      <a href="<?php echo base_url();?>user/add/"> <button type="button" class="btn btn-primary waves-effect waves-light ">Add</button></a>
                       
                  </div>
               </div>
            </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <?php //if(isset($data)){?>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <?php //echo"<pre>"; print_r($data);?>
                           <thead>
                              <tr>
                                 <!--<th>User Id</th>-->
                                 <th>Sr.No.</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Phone</th>
                                 <th>Created On</th>
                                 
                                 <th class="no-sort">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                             <?php if($info){
								 //print_r($info);
								 ?>
							 
                             <?php $i=1; foreach($info as $user){?>
                              <tr>
                                  <td><?php echo $i;$i++;;?></td>
<!--                                  <td><?php echo $user->userId;?></td>-->
                                 <td><?php echo $user->fullName;?></td>
                                 <td><?php echo $user->email;?></td>
                                 
                                 <td><?php echo $user->phone;?></td>
                               <td><?php echo date('D d M,Y',strtotime($user->createdOn));?></td>
                                 <td>
                                     <span class="action">
                                     <a href="<?php echo base_url()?>user/edit/<?php echo $user->userId;?>">
                                         <i class="fa fa-pencil-square-o" title="edit" aria-hidden="true"></i>
                                     </a>
                                      </span>|
                                     <span  class="action">
                                     <a href="#" id="delete" onclick="del_user(<?php echo $user->userId;?>)">
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
     