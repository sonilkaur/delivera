<style>
    span.action{
        padding: 11px;
        font-size: 20px;
    }
</style>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#">Order</a></li>

                        </ol>

                    </div>
                    <h4 class="page-title">Order</h4>

                </div>
            </div>
        </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                         <div class="row">
                            <form action="<?php echo base_url();?>order/" method="get" class="filter_form col-md-12">Filter:
                            <div class="row">
                              <div class="col-md-4"> 
                                   <label>Date</label>
                                  <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%;border-radius: 5px" >
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
     <input class="form-control" id="from" value="<?php if(isset($_GET['from'])){ echo $_GET['from'] ;}?>" type="hidden" name="from"/>
     <input class="form-control" id="to" value="<?php if(isset($_GET['to'])){ echo $_GET['to'] ;}?>" type="hidden" name="to"/>
</div>
                                  </div>
                                <div class="col-md-2">
                                    <?php $res=$this->db->query("select * from store order by name asc")->result();?> 
                                    <label>Store name</label>
                                    <select class="form-control" name="store">
                                        <option selected="" disabled="">Select option</option>
                                        <?php if($res){ foreach($res as $row){?>
                                        <option value="<?= $row->storeId;?>" <?php if(isset($_GET['store']) && ($_GET['store']==$row->storeId)){ echo "selected";}?>><?= $row->name;?></option>
                                        <?php }}?>
                                    
                                  
                                   </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option selected="" disabled="">Select option</option>
                                        <option value="1" <?php if(isset($_GET['status']) && $_GET['status']=='1'){ echo 'selected';}?>>Completed</option>
                                        <option value="0" <?php if(isset($_GET['status']) && $_GET['status']=='0'){ echo 'selected';}?>>Pending</option>
                                        <option value="2" <?php if(isset($_GET['status']) && $_GET['status']=='2'){ echo 'selected';}?>>Processing</option>
                                        <option value="7" <?php if(isset($_GET['status']) && $_GET['status']=='7'){ echo 'selected';}?>>Picked Up</option>
                                        <option value="4" <?php if(isset($_GET['status']) && $_GET['status']=='4'){ echo 'selected';}?>>Ready</option>
                                        <option value="5" <?php if(isset($_GET['status']) && $_GET['status']=='5'){ echo 'selected';}?>>Accept</option>
                                        <option value="6" <?php if(isset($_GET['status']) && $_GET['status']=='6'){ echo 'selected';}?>>rejected</option>
                                        <option value="3" <?php if(isset($_GET['status']) && $_GET['status']=='3'){ echo 'selected';}?>>Canceled</option>
                                  
                                   </select>
                                </div>
                                <div class="col-md-2">
                                   <label>Payment Method</label>  
                                   <select class="form-control" name="payment_method">
                                       <option selected="" disabled="">Select Option</option>
                                       <option value="online" <?php if(isset($_GET['payment_method']) && $_GET['payment_method']=='online'){ echo 'selected';}?>>Online</option>
                                       <option value="COD" <?php if(isset($_GET['payment_method']) && $_GET['payment_method']=='COD'){ echo 'selected';}?>>COD</option>
                                   </select>
                                </div>
 <div class="col-md-1">       <label style="padding-bottom: 15px;"></label>  
                                        <input type="submit" class="form-control btn-primary btn_sub" value="Search">                           
                                </div>
                              
                             
                            </div>
                       
                        </form>
                            </div>
                        <?php if ($result) { ?>
                          <div class="float-right" style="margin-right:20px">
                            <a href="<?= base_url();?>order/create_report/" title="download report"> <img src="<?= base_url();?>assets/images/csv.png" height="38px"></a>
                            </div>
                        <?php if(isset($_GET['driver_status'])){?>
                        <?php if($_GET['driver_status']=='2'){?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Rejected Orders!</strong> These Orders are rejected by Delivera Rider.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                        <?php } if($_GET['driver_status']=='1'){?>
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Accepted Orders!</strong> These orders are Accepted by Delivera Rider.
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
                        <?php }?>
                        <?php } ?>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <?php //echo"<pre>"; print_r($result);?>
                                <thead>
                                    <tr>

                                       
                                        <th>Sr.No.</th>
                                        <th>Order Id</th>
                                        <th>Name</th>
                                        <th>Store Name</th>
                                        <th>Total Count</th>
                                        <th>Total Price</th>
                                        <th>Promo Code</th>
                                        <th>Status</th>
                                        <th>Payment Status</th>
                                        <th>Payment Method</th>
                                        
                                        <th>Created On</th>

                                      
                                       <!-- <th>Action</th>-->
                                        <th class="no-sort">View Order</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $i=1;foreach ($result as $orders) { ?>
                                        <tr>


<!--                                       <td>#<?php //echo $orders->orderId; ?></td>-->
                                            <td><?php echo $i;$i++;?></td>
                                            <td>#<?php echo $orders->orderId; ?></td>
                                            <td><?php echo $orders->user_name; ?></td>
                                            <td><?php echo $orders->store_name; ?></td>
                                            <td><?php echo $orders->totalCount; ?></td>
                                            <td><?php echo $orders->totalPrice; ?></td>
                                            <td><?php echo $orders->promo_code; ?></td>
                                          
                                            <td><?php
                                                if ($orders->status == '1') {
                                                    echo 'Complete';
                                                } elseif ($orders->status == '2') {
                                                    echo 'Processing';
                                                } elseif ($orders->status == '3') {
                                                    echo 'Cancelled';
                                                } elseif ($orders->status == '4') {
                                                    echo 'Ready';
                                                } 
                                                 elseif ($orders->status == '5') {
                                                    echo 'Accepted';
                                                } elseif ($orders->status == '6') {
                                                    echo 'Rejected';
                                                } elseif ($orders->status == '7') {
                                                    echo 'Pickup';
                                                } else {
                                                    echo 'Pending';
                                                }

                                                // echo $orders->status;
                                                ?></td>
                                            <td>
                                                <?php
                                                if ($orders->payment_status == '1') {
                                                    echo 'Complete';
                                                } elseif ($orders->payment_status == '0') {
                                                    echo 'Pending';
                                                } elseif ($orders->payment_status == '2') {
                                                    echo 'Refunded';
                                                } else {
                                                    echo '';
                                                }

                                                // echo $orders->status;
                                                ?>
                                             
                                            <td><?= $orders->payment_method;?></td>
                                              <td><?php echo date('D d M,Y',strtotime($orders->createdOn)) ; ?></td>
                                           <!-- <td><a href="#" id="delete" onclick="remove(<?php echo $orders->orderId;?>,'order/delete')"><i class="fa fa-trash" aria-hidden="true"></i></a></td>-->
                                              <td><a href="<?php echo base_url();?>order/view_order/<?php echo $orders->orderId;?>">view order</a> / <a href="<?php echo base_url();?>order/invoice/<?php echo $orders->orderId;?>" >invoice</a></td>

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

<!-- end wrapper --><!-- Footer -->
<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();
    //console.log(start);
    //console.log(end);

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        $('#from ').val(start.format('Y-M-D'));
        $('#to ').val(end.format('Y-M-D'));
     
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
     <?php if(isset($_GET['to']) && isset($_GET['from'])){?>
                var to= "<?php if(isset($_GET['to'])){ echo $_GET['to'];}?>";
                $("#to").val(to);
      
        $('#reportrange span').html(moment('<?php echo $_GET['from']?>').format('MMMM D, YYYY') + ' - ' + moment('<?php echo $_GET['to']?>').format('MMMM D, YYYY'));
                var from="<?php if(isset($_GET['from'])){ echo $_GET['from'];}?>";
                $("#from").val(from);
      <?php }?>

});
</script>