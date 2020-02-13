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
                           <li class="breadcrumb-item"><a href="#">Categories</a></li>
                          
                        </ol>
                        
                     </div>
                     <h4 class="page-title">Categories</h4>
                      <a href="<?php echo base_url();?>category/add/">
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
                                 <th>Sr.No.</th>
                                 <th class="no-sort">Image</th>
                                
                                 <th>Name</th>
                                 <th>Parent Category</th>
                                
                                 <th class="no-sort">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                            <?php //echo "<pre>";print_r($info);?>
                               <?php $i=1; foreach($info['cat'] as $cat){ ?>
                              <tr>
                                  <td><?php echo $i;$i++;?></td>
                                  <td>
                                      <?php if($cat->photo){?>
                                      <img src="<?php echo base_url();?><?php echo $cat->photo;?>" height="100px" width="100px">
                                     <?php }else{?>
                                      <img src="<?php echo base_url();?>assets/images/dummy.jpg" height="100px" width="100px">
                                     <?php }?>
                                  </td>
                              
                                 <td><?php echo $cat->name;?></td>
                                 <td><?php if($cat->parent){echo $cat->parent[0]->name; }else{echo "-";}?></td>
                               
                                 <td>
                                     <span class="action">
                                     <a href="<?php echo base_url();?>category/edit/<?php echo $cat->categoryId;?>">
                                         <i class="fa fa-pencil-square-o" title="edit" aria-hidden="true"></i>
                                     </a>
                                      </span>|
                                     <span  class="action">
                                     <a href="#" id="delete" onclick="del_cat(<?php echo $cat->categoryId;?>,'category')">
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
     