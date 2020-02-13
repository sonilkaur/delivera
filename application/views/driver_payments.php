<style>
    span.action{
        padding: 11px;
        font-size: 20px;
    }
    .font-large-2{
        font-size: 2rem;
    }
 input[type=radio]:checked  {
  color: #f00;
 
} 
</style>
 
  
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="header_title">
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right">
                            <ol class="breadcrumb hide-phone p-0 m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Delivera Rider Payments</a></li>

                            </ol>

                        </div>
                        <h4 class="page-title">Delivera Rider Payments</h4>

                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="stats" style="padding-bottom:20px;">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body">
                                    <h3><?php echo $stats[0]->pending;?></h3>
                                    <span class="text-muted">Pending Payments</span>
                                </div>
                                <div class="align-self-center">
                                    <div id="sp-bar-total-cost"><i class="fa fa-clock-o font-large-2" aria-hidden="true"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body">
                                    <h3><?php echo $stats[1]->complete;?></h3>
                                    <span class="text-muted">Completed Payments</span>
                                </div>
                                <div class="align-self-center">
                                    <div id="sp-bar-total-sales"><i class="fa fa-check font-large-2"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           



        </div> </div>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <?php if ($payments) { ?>
                          <div class="float-right" style="margin-right:20px">
                            <a href="<?= base_url();?>order/create_payment_report/" title="download report"> <img src="<?= base_url();?>assets/images/csv.png" height="38px"></a>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <?php //echo"<pre>"; print_r($data);?>
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Order Id</th>
                                        <th>Delivera Rider name</th>
                                        <th>Total Amount</th>
                                        <th>Payment</th>
                                      
                                        <th>Payment Status</th>
                                        <th>Created On</th>
                                        <th class="no-sort">Actions</th>
                                       
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $i = 1;
                                    foreach ($payments as $pay) { ?>
                                        <tr>
                                            <td><?php echo $i;
                                        $i++; ?></td>

                                            <td><?php echo $pay->orderId; ?></td>
                                            <td><?= $pay->fullName;?></td>
                                            <td><?php echo Globals::getCurrency() . $pay->totalPrice; ?></td>
                                         
                                            <td><?php echo Globals::getCurrency() . $pay->driver_commission; ?></td>
                                            <td><?php if($pay->driver_payment_status=="Pending"){$class="danger";}else{$class="success";}?><span class="badge badge-<?= $class;?>"><?php echo  $pay->driver_payment_status; ?></span></td>
                                             <td><?php echo date('D d M,Y',  strtotime($pay->order_date));?></td>
                                            <td><a href="<?= base_url();?>order/edit_driver_payment_status/<?= $pay->orderId?>"><i class="fa fa-edit"></i></a></td>

                                        </tr>
    <?php } ?>


                                </tbody>
                            </table>
                        <?php } else { ?>
                            <div class="">No Record Found</div>
<?php } ?>
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

<script>
 
     function update_status(orderId) {
       //alert(status.val());
      // console.log(status);
       var radioValue = $("input[name='status<?php echo $pay->orderId; ?>']:checked").val();
          
           // alert("Selected Text: " +  + " Value: " + radioValue);return false; 
   // var id =$(this "option:selected" ).val();
   // var selectBox = document.getElementById("payment_status");
//var selectedValue = selectBox.options[selectBox.selectedIndex].value;
//alert(selectedValue);
   // alert(id);return false;
                  swal({ 
                        title: "Are you sure?",
                        //text: "Are you sure want to delete?",
                        type: "warning",
                        showCancelButton: !0,
                        confirmButtonText: "Yes, Update it!",
                        cancelButtonText: "No!",
                        confirmButtonClass: "btn btn-success",
                        cancelButtonClass: "btn btn-danger m-l-10",
                        buttonsStyling: !1
                    }).then(function() {                
                              var requesturl = "<?= base_url(); ?>order/update_payment_status";
                              $.ajax({ 
                              url:requesturl,
                              data:{status:radioValue,orderId:orderId},
                              datatype:"json",
                              type:"POST",
                              success: function (data) {
                                  /* alert(data); */
                                  if(data)
                          { //swal("Deleted!", "Your record has been deleted.", "success"
                                      swal({title: "Updated", text: "Your status has been Updated", type: "success"})
                                              .then(function(){ 
                                          location.reload();
                                          });
//                                    
                                  }
                                  else
                                  {
                                    swal({title: "Oops", text: "Error updating", type: "success"})
                                            .then(function(){ 
                                            location.reload();
                                        });
                                                      
                                  }


                              }
                    });
                    
                    }, function() {
                          "cancel" === t &&  swal({title: "Cancelled", text: "You Record is safe!", type: "success"})
                                  
                    });
        }
   
</script>


