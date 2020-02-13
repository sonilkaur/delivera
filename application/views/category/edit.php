
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
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>category/"> categories</a></li>
                     <li class="breadcrumb-item"><a href="#">Edit Category</a></li>

                  </ol>
               </div>
               <h4 class="page-title">Edit Category</h4>
            </div>
         </div>
      </div>
      </div>

      <!-- end page title end breadcrumb -->
      <div class="row">
         <div class="col-12">
            <div class="card m-b-30">
               <div class="card-body">
                  <h4 class="mt-0 header-title">Edit Details</h4>
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
                  <form action="<?php echo base_url();?>category/edit_process/<?php echo $info[0]->categoryId;?>" method="post" enctype="multipart/form-data">
                  <div class="form-group row">
                     <label for="example-text-input" class="col-sm-2 col-form-label">Category Name</label>
                     <div class="col-sm-10"><input name="name" value="<?php echo $info[0]->name;?>"class="form-control" required placeholder="Category Name" type="text"  id="example-text-input"></div>
                  </div>

                  <div class="form-group row">
                     <label for="example-email-input" class="col-sm-2 col-form-label">Parent Category</label>
                     <div class="col-sm-10">
                         <select name="parentId" class="form-control">
                              <option >Select Parent Category</option>
                             <?php if($category){?>
                             <?php foreach($category as $cat){
                                // print_r($key);

                                 ?>

                             <option value="<?php echo $cat->categoryId;?>" <?php if($info[0]->parentId==$cat->categoryId){echo "selected";}?>><?php echo $cat->name;?></option>
                             <?php }

                             }else{?>
                             <option value="0"></option>
                             <?php }?>

                         </select>
                     </div>
                  </div>


                  <div class="form-group row">
                     <label for="example-password-input" class="col-sm-2 col-form-label">Image</label>
                     <div class="col-sm-10">
                         <input type="file" accept="image/x-png, image/jpeg"  class="form-control" name="image"/>

                         </div>
                  </div>
                  <div class="form-group row">
                       <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url();?>category"> <button type="button" class="btn btn-secondary ">Cancel</button></a>
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
