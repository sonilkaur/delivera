<style>
    span.action{
        padding: 11px;
        font-size: 20px;
    }
    .font-large-2{
        font-size: 2rem;
    }
    .action_btn{
        padding-top: 28px;
    }
   
</style>
 
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
                                <li class="breadcrumb-item"><a href="#">Earnings</a></li>

                            </ol>

                        </div>
                        <h4 class="page-title">Earnings</h4>

                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="stats" style="padding-bottom:20px;">
        <div class="row">
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body">
                                    
                                    <h3><?php echo Globals::getCurrency() .$stats[2]->daily_earning;?></h3>
                                  <span class="text-muted"><b><?php echo date('j-M-Y'); ?></b></span><br>
                                    <span class="text-muted">Daily Earning</span>
                                </div>
                                <div class="align-self-center">
                                    <div id="sp-bar-total-cost"><i class="fa fa-line-chart font-large-2" aria-hidden="true"></i></div>
                                       
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <?php //print_r($stats);?>
            <div class="col-xl-4 col-lg-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body">
<!--                                    <h3><?php// echo Globals::getCurrency() .$stats[0]->total_earning;?></h3>
                                    <span class="text-muted"><b>Till Now</b></span><br>
                                    <span class="text-muted">Total Earnings</span>-->
                                     <h3><?php echo Globals::getCurrency() .$stats[3]->weekly_earning;?></h3>
                                     <span class="text-muted"><b><? echo date('j-M-Y', strtotime('today - 7 days'));?></b></span> To
                                    <span class="text-muted"><b><? echo date('j-M-Y', strtotime('today - 1 days'));?></b></span><br>
                                    <span class="text-muted">Weekly  Earnings</span>
                                </div>
                                <div class="align-self-center">
                                    <div id="sp-bar-total-revenue"><div class="align-self-center">
                                <i class="dripicons-wallet font-large-2 blue-grey lighten-3"></i>
                            </div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
 <div class="col-xl-4 col-lg-6 col-12">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="media d-flex">
                                <div class="media-body">
                                    <h3><?php echo Globals::getCurrency() .$stats[1]->monthly_earning;?></h3>
                                    <span class="text-muted"><b><? echo date('j-M-Y', strtotime('today - 30 days'));?></b></span> To
                                    <span class="text-muted"><b><? echo date('j-M-Y', strtotime('today - 1 days'));?></b></span><br>
                                    <span class="text-muted">Monthly Earnings</span>
                                </div>
                                <div class="align-self-center">
                                    <div id="sp-bar-total-sales"><i class="fa fa-bar-chart-o font-large-2"></i></div>
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
                         <div class="row">
                            <form action="<?php echo base_url();?>order/earnings/" method="get" class="filter_form col-md-12">Filter:
                            <div class="row">
                              <div class="col-md-4"> 
                                   <label>Date</label>
                                  <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
    <i class="fa fa-calendar"></i>&nbsp;
    <span></span> <i class="fa fa-caret-down"></i>
     <input class="form-control" id="from" value="<?php if(isset($_GET['from'])){ echo $_GET['from'] ;}?>" type="hidden" name="from"/>
     <input class="form-control" id="to" value="<?php if(isset($_GET['to'])){ echo $_GET['to'] ;}?>" type="hidden" name="to"/>
</div>
                                  </div>
                                  <div class="col-md-4"> 
                                      <label>Commission Type</label>
                                      <select class="form-control" name="commission_type">
                                          <option disabled="" selected="">Select Option</option>
                                          <option value="1" <?php if(isset($_GET['commission_type']) && $_GET['commission_type']=='1'){ echo "selected" ;}?>>Per Order Flat</option>
                                          <option value="2" <?php if(isset($_GET['commission_type']) && $_GET['commission_type']=='2'){ echo "selected" ;}?>>Per Order %</option>
                                          <option value="3" <?php if(isset($_GET['commission_type']) && $_GET['commission_type']=='3'){ echo "selected" ;}?>>Per Item Flat</option>>
                                      </select>
                                      </div>
 <div class="col-md-1 action_btn">        
                                        <input type="submit" class="form-control btn-primary btn_sub" value="Search">                           
                                </div>
 

                            </div>
                       
                        </form>
                            </div>
                        <?php if ($earnings) { ?>
                        <div class="float-right" style="margin-right:20px">
                            <a href="<?= base_url();?>order/create_earnings_report/" title="download report"> <img src="<?= base_url();?>assets/images/csv.png" height="38px"></a>
                            </div>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                               
                                <?php //echo"<pre>"; print_r($data);?>
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Order Id</th>
                                        <th>Total Amount</th>
                                        <th>Delivery Charges</th>
                                        <th>Commission Type</th>
                                        <th>Commission Rate</th>
                                        <th>Admin Commission</th>
                                        <th>Seller Earning</th><!--(Total Amount-Delivery Charges-Admin Commission)-->
                                        <th>Your Earning<!--(Delivery Charges+Admin Commission)--></th>

                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $i = 1;
                                    foreach ($earnings as $earn) { ?>
                                        <tr>
                                            <td><?php echo $i;
                                        $i++; ?></td>

                                            <td><?php echo $earn->orderId; ?></td>
                                            <td><?php echo Globals::getCurrency() . $earn->totalPrice; ?></td>
                                            <td><?php echo Globals::getCurrency() . $earn->delivery_fee; ?></td>
                                            <td><?php echo  $earn->commission_type; ?></td>
                                            <td><?php if($earn->commission_type=='Per Order %'){echo $earn->commission_rate ." %" ;}else{echo Globals::getCurrency() . $earn->commission_rate;} ?></td>
                                            <td><?php echo Globals::getCurrency() . $earn->admin_commission; ?></td>
                                            <td><?php echo Globals::getCurrency() . $earn->store_earning; ?></td>
                                            <td><?php echo Globals::getCurrency() . $earn->admin_earning; ?></td>
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