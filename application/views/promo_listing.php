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
                           <li class="breadcrumb-item"><a href="#">Promo Codes</a></li>
                          
                        </ol>
                        
                     </div>
                     <h4 class="page-title">Promo Codes</h4>
                      <a href="<?php echo base_url();?>admin/add_promo/"> <button type="button" class="btn btn-primary waves-effect waves-light ">Add</button></a>
                       
                  </div>
               </div>
            </div>
            </div>
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <?php if(isset($promo)){?>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <?php //echo"<pre>"; print_r($data);?>
                           <thead>
                              <tr>
                                 <th>Sr.No.</th>
                                 <th>Promo Code</th>
                                 <th>Code Type</th>
                                 <th>Code Amount</th>
                                 <th>Start Date</th>
                                 <th>Expiry Date</th>
                                 <th>Created by</th>
                                
                                 <th class="no-sort">Action</th>
                              </tr>
                           </thead>
                           <tbody>
                               <?php $i=1; foreach($promo as $code){?>
                               <?php //print_r($restaurant->id)?>
                              <tr>
                                  <td><?php echo $i; $i++;?></td>
                                 <td><?php echo $code->code;?></td>
                                 <td><?php if($code->type=='1'){echo 'Percentage';}else{echo 'Flat Rate';};?></td>
                                   <td><?php echo $code->code_amount;?></td>
                                 <td><?php $date= strtotime($code->start_date); echo date('F j, Y',$date);?></td>
                                 <td><?php $date1= strtotime($code->expiryDate); echo date('F j, Y',$date1);?></td>
                                 <td><?= $code->createdBy;?> <?php if($code->createdBy=='seller'){echo "(".$code->name.")";}?></td>
                                 <td>
                                   
                                     <span  class="action">
                                         <a href="<?= base_url()?>admin/edit_promo/<?= $code->codeId?>"  >
                                         <i class="fa fa-edit" aria-hidden="true"></i>
                                     </a>|
                                     <a href="#" id="delete" onclick="remove(<?php echo $code->codeId;?>,'admin/delete_promo')">
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
     