
      <div class="wrapper">
         <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
               <div class="col-sm-12">
                  <div class="page-title-box">
                     <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Dashboard</a></li>
                          
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/view_notifications">Notifications</a></li>
                           <li class="breadcrumb-item"><a href="#">Send Notifications</a></li>
                           
                        </ol>
                     </div>
                     <h4 class="page-title">Send Push Notification</h4>
                  </div>
               </div>
            </div>
          
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                      
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
                        <form action="<?php echo base_url();?>admin/send_notification" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Title</label>
                           <div class="col-sm-10"><input name="title"class="form-control" required placeholder="Title" type="text"  id="example-text-input"></div>
                        </div>
                        
                        <div class="form-group row">
                           <label for="example-email-input" class="col-sm-2 col-form-label">Message</label>
                           <div class="col-sm-10">
                               <textarea name="message" required="" placeholder="Message Body" class="form-control"></textarea>       
                           </div>
                        </div>
                       
                        <div class="form-group row">
                             <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                              <div class="col-sm-10">
                                  <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button> <button type="reset" class="btn btn-secondary waves-effect ">Cancel</button>
                              </div>
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
 