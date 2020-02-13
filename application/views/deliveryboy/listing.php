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
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="#">Delivera Rider</a></li>
                          
                        </ol>
                        
                     </div>
                     <h4 class="page-title">Delivera Rider</h4>
                      <a href="<?php echo base_url();?>deliveryBoy/add/">
                          <button type="button" class="btn btn-primary waves-effect waves-light ">Add</button>
                      </a>
                       
                  </div>
               </div>
            </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <?php if($info){?>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <?php //echo"<pre>"; print_r($data);?>
                           <thead>
                              <tr>
<!--                                 <th>Id</th>-->
                                 <th>Sr.No.</th>
                                 <th>Name</th>
                                 <th>Email</th>
<!--                                 <th>Address</th>-->
                                 <th>Phone</th>
                                 <th>Created On</th>
                                 
                                 <th class="no-sort">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                            
                               <?php $i=1; foreach($info as $db){ ?>
                              <tr>
<!--                                  <td><?php echo $db->boyId;?></td>-->
                                 <td><?php echo $i;$i++;?></td>
                                 <td><?php echo $db->fullName;?></td>
                                 <td><?php echo $db->email;?></td>
<!--                                 <td><?php //echo $string = substr($db->address,0,50);echo $db->address;?>...</td>-->
                                 <td><?php echo $db->phone;?></td>
                                 <td><?php echo date('D d M ,Y',strtotime($db->createdOn));?></td>
                                 <td>
                                     <span class="action">
                                     <a href="<?php echo base_url()?>deliveryBoy/edit/<?php echo $db->boyId;?>">
                                         <i class="fa fa-pencil-square-o" title="edit" aria-hidden="true"></i>
                                     </a>
                                      </span>|
                                     <span  class="action">
                                     <a href="#" id="delete" onclick="del_dboy(<?php echo $db->boyId;?>)">
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
     