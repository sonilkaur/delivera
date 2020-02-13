<div class="wrapper">
         <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
               <div class="col-sm-12">
                  <div class="page-title-box">
                     <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="#">Edit Driver's Payment</a></li>
                          
                        </ol>
                     </div>
                     <h4 class="page-title">Edit Driver's Payment</h4>
                  </div>
               </div>
            </div>
          
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-lg-12 col-offset-3">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <h4 class="mt-0 header-title">Payment Information</h4>
                        <?php if($this->session->userdata('error')){?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->userdata('error');?>
                        </div>
                        <?php }?>
                        <?php if($this->session->userdata('success')){?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->userdata('success');?>
                        </div>
                        <?php }?>
                        <form method="post" action="<?php echo base_url();?>order/update_driver_payment_status/<?php echo $payment->orderId;?>" enctype="multipart/form-data">
                           <div class="form-group">
                               <label>Order Id</label> 
                               <input type="text" name="orderId" value="<?php echo $payment->orderId;?>" class="form-control" readonly="" required placeholder="">
                           </div>
                           <div class="form-group">
                               <label>Driver Name</label> 
                               <input type="text" name="email" value="<?php echo $payment->fullName;?>" class="form-control" required placeholder="" readonly="">
                           </div>
                           <div class="form-group">
                              <label>Total amount</label>
                              <div><input type="text" name="old_password"  class="form-control"  value="<?php echo Globals::getCurrency() .$payment->totalPrice;?>" readonly=""></div>
                           </div>
                           <div class="form-group">
                              <label>Payment</label>
                              <div class="m-t-10"><input type="text" class="form-control" value="<?php echo Globals::getCurrency() .$payment->driver_commission;?>" readonly=""></div>
                           </div>
                           <div class="form-group">
                              <label>Status</label>
                              <div class="m-t-10">
                                  <select class="form-control" name="status">
                                      <option selected disabled value="">Select Option</option>
                                      <option value="0" <?php if($payment->driver_payment_status=='Pending'){echo 'selected';}?>>Pending</option>
                                      <option value="1" <?php if($payment->driver_payment_status=='Completed'){echo 'selected';}?>>Complete</option>
                                  </select></div>
                           </div>
                        
                           
                           <div class="form-group">
                              <div><button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <button type="reset" class="btn btn-secondary waves-effect m-l-5">Cancel</button></div>
                           </div>
                        </form>
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