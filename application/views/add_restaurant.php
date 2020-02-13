
      <div class="wrapper">
         <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
               <div class="col-sm-12">
                  <div class="page-title-box">
                     <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>restaurant">Restaurant</a></li>
                           <li class="breadcrumb-item"><a href="#">Add Restaurant</a></li>
                           
                        </ol>
                     </div>
                     <h4 class="page-title">Add Restaurant</h4>
                  </div>
               </div>
            </div>
          
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <h4 class="mt-0 header-title">Add Details</h4>
                        <?php if($this->session->userdata('error')){?>
                        <div class="alert alert-info" role="alert">
                            <?php echo $this->session->userdata('error');?>
                        </div>
                        <?php }?>
                        <?php if($this->session->userdata('success')){?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->userdata('success');?>
                        </div>
                        <?php }?>
                        <form action="<?php echo base_url();?>restaurant/add_process" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                           <div class="col-sm-10"><input name="name"class="form-control" required placeholder="Restaurant Name" type="text"  id="example-text-input"></div>
                        </div>
                        
                        <div class="form-group row">
                           <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                           <div class="col-sm-10"><input name="email" class="form-control" required placeholder="Restaurant Email" type="email"  id="example-email-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-url-input" class="col-sm-2 col-form-label">Password</label>
                           <div class="col-sm-10"><input name="password" class="form-control" required placeholder="Password"type="password"  id="example-url-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Phone</label>
                           <div class="col-sm-10"><input name="phone"class="form-control" required placeholder="Phone" type="tel" id="example-tel-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-password-input"  class="col-sm-2 col-form-label">Address</label>
                           <div class="col-sm-10">
                               <textarea class="form-control" name="address"></textarea>
                               </div>
                        </div>
                        <div class="form-group row">
                           <label for="example-password-input" class="col-sm-2 col-form-label">Image</label>
                           <div class="col-sm-10">
                               <input type="file" class="form-control" name="image"/>
                              
                               </div>
                        </div>
                        <div class="form-group row">
                             <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                              <div class="col-sm-10">
                                  <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <button type="reset" class="btn btn-secondary waves-effect ">Cancel</button>
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
 