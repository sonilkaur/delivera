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
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="#">Order Reviews</a></li>
                          
                        </ol>
                        
                     </div>
                     <!-- <h4 class="page-title">Notifications</h4>
                      <a href="<?php echo base_url();?>admin/notifications/"> <button type="button" class="btn btn-primary waves-effect waves-light ">Send Notification</button></a> -->
                       
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
                                 <th>Sr.No.</th>
                                 <th>Order ID</th>
                                 <th>UserName</th>
                                 <th>Rating</th>
                                 <!-- <th>Review</th> -->
                                 <th class="no-sort">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                               <?php 
                              $i=1; foreach($result as $reviews){?>
                               <?php //print_r($restaurant->id)?>
                              <tr>
                                  <td><?php echo $i; $i++;?></td>
                                  <td><?php echo $reviews->orderID;?></td>
                                 <td><?php echo $reviews->fullName;?></td>
                                 <td><?php echo number_format($reviews->total_rating,2);?></td>
                                 <!-- <td><?php echo $reviews->review;?></td> -->
                                 <td>
                                 <span  class="action">
                                     <a href="<?php echo base_url()?>order/order_reviews/<?php echo $reviews->orderID;?>">
                                       <button class="btn btn-info">Manage Reviews</button>
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
     