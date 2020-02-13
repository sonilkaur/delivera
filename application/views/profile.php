<div class="wrapper">
         <div class="container-fluid">
            <!-- Page-Title -->
            <div class="row">
               <div class="col-sm-12">
                  <div class="page-title-box">
                     <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="#">Edit Profile</a></li>
                          
                        </ol>
                     </div>
                     <h4 class="page-title">Edit Profile</h4>
                  </div>
               </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-lg-12 col-offset-3">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <h4 class="mt-0 header-title">Profile Information</h4>
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
                        <form method="post" action="<?php echo base_url();?>admin/edit_profile/<?php echo $res->adminId;?>" enctype="multipart/form-data">
                           <div class="form-group">
                               <label>Name</label> 
                               <input type="text" name="name"value="<?php echo $res->fullName;?>"class="form-control" required placeholder="Type something">
                           </div>
                           <div class="form-group">
                               <label>Email</label> 
                               <input type="text" name="email"value="<?php echo $res->email;?>"class="form-control" required placeholder="Type something">
                           </div>
                           <div class="form-group">
                              <label>Reset Password(Old Password)</label>
                              <div><input type="password" name="old_password" id="pass2" class="form-control"  placeholder="Enter Old Password"></div>
                           </div>
                           <div class="form-group">
                              <label>New Password</label>
                              <div class="m-t-10"><input type="password" class="form-control"  data-parsley-equalto="#pass2" name="new_password" placeholder="Enter new  Password"></div>
                           </div>
                        
                           <div class="form-group">
                              <label>Image</label>
                              <div><input parsley-type="url" name="image" accept="image/x-png, image/jpeg" type="file" class="form-control" ></div>
                           </div>
                           <div class="form-group">
                              <label>Phone</label>
                              <div><input data-parsley-type="digits" name="phone" value="<?php echo $res->phone;?>" type="text" class="form-control" required placeholder="Enter only digits"></div>
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