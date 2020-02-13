<!-- Load c3.css -->
<link href="<?php echo base_url(); ?>assets/pages/c3.css" rel="stylesheet">

<!-- Load d3.js and c3.js -->
<script src="<?php echo base_url(); ?>assets/pages/d3-5.8.2.min.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/pages/c3.min.js"></script>


<script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/morris/morris.min.js"></script>
<div class="wrapper">
  
		<div class="container-fluid">
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<div class="page-title-box">
						<div class="btn-group float-right">
							<ol class="breadcrumb hide-phone p-0 m-0">
								<li class="breadcrumb-item"><a href="#">Delivera</a>
								</li>
								<li class="breadcrumb-item active">Dashboard</li>
							</ol>
						</div>
						<h4 class="page-title">Dashboard</h4>
					</div>
				</div>
			</div>
			<!-- end page title end breadcrumb -->
			<div class="row">
				<div class="col-xl-3 col-md-6">
					<div class="card mini-stat m-b-30">
						<div class="p-3 bg-primary text-white">
							<div class="mini-stat-icon"><i class="mdi mdi-cube-outline float-right mb-0"></i>
							</div>
							<h6 class="text-uppercase mb-0">New Orders</h6>
						</div>
						<div class="card-body">
							
							<div class="mt-4 text-muted">
								<div class="float-right">
									
								</div>
								<h5 class="m-0"><?php echo $stats['new_orders'];?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card mini-stat m-b-30">
						<div class="p-3 bg-primary text-white">
							<div class="mini-stat-icon"><i class="mdi mdi-account-network float-right mb-0"></i>
							</div>
							<h6 class="text-uppercase mb-0">Completed Orders</h6>
						</div>
						<div class="card-body">
							
							<div class="mt-4 text-muted">
								<div class="float-right">
								
								</div>
								<h5 class="m-0"><?php echo $stats['complete_orders'];?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card mini-stat m-b-30">
						<div class="p-3 bg-primary text-white">
							<div class="mini-stat-icon"><i class="mdi mdi-tag-text-outline float-right mb-0"></i>
							</div>
							<h6 class="text-uppercase mb-0">Rejected Orders</h6>
						</div>
						<div class="card-body">
							
							<div class="mt-4 text-muted">
								<div class="float-right">
									
								</div>
								<h5 class="m-0"><?php echo $stats['rejected_orders'];?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card mini-stat m-b-30">
						<div class="p-3 bg-primary text-white">
							<div class="mini-stat-icon"><i class="mdi mdi-cart-outline float-right mb-0"></i>
							</div>
							<h6 class="text-uppercase mb-0">Total Earnings</h6>
						</div>
						<div class="card-body">
							
							<div class="mt-4 text-muted">
								<div class="float-right">
									
								</div>
                                                                <h5 class="m-0">$ <?php if($stats['total_sales']) {echo $stats['total_sales'];}else{ echo 0;}?></h5>
							</div>
						</div>
					</div>
				</div>
                             <div class="col-xl-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Daily Orders</h4>
                       <div id="area-chart" ></div>
                    </div>
                </div>
            </div>
			</div>
			<!-- end row -->
			<!-- end row -->
			
			<div class="row">
				<div class="col-xl-12">
					<div class="card m-b-30">
						<div class="card-body">
							<h4 class="mt-0 header-title mb-4">Recent Users</h4>
                                                        <?php if($result){?>
							<div class="table-responsive">
								<table class="table table-hover mb-0">
									<thead>
										<tr>
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Created On</th>
											
										</tr>
									</thead>
									<tbody>
                                                                            <?php foreach($result as $row){?>
										<tr>
											<td><?php echo $row->fullName;?></td>
											<td><?php echo $row->email;?></td>
											<td><?php echo $row->phone;?></td>
											<td><?php echo $row->createdOn;?></td>
											
										</tr>
                                                        <?php }?>
										
									</tbody>
								</table>
							</div>
                                                        <?php }?>
						</div>
					</div>
				</div>
			</div>
			<!-- end row -->
		</div>
		<!-- end container -->
	</div>
	<!-- end wrapper -->
        
        <script>
            var date = new Date();
    var days = [];
    var i = 0;
   //var today = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
    var today =  date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
    days.push(today);
    for (i = 0; i < 6; i++)
    {
        date.setDate(date.getDate() - 1);
        var dow = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        days.push(dow);
    }
  //  console.log(days);
     $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>seller/home/get_list',
        dataType: 'json',
        data: {days:days},
        
        success: function (data1) { 
              //console.log(data1.cat);
              var d1=[];
             $.each(data1.data, function(key,val) { 
                 //console.log(key);
                // console.log(val);
                // var element={};
               //  element=[val.name,val.total];
                 d1.push({y:key,Cloth:(!val[0]) ? "0":  val[0].sale,Electronic:(!val[1]) ? "0":  val[1].sale,Food:(!val[2]) ? "0":  val[2].sale});
              // d1.push({y:key,a:val[0].sales});
        });
      //  console.log(d1);
          
var data = d1,/*[
      { y: days[0], a: 50, b: 90,c:10},
      { y: days[1], a: 65,  b: 75,c:11},
      { y: days[2], a: 50,  b: 50,c:15},
      { y: days[3], a: 75,  b: 60,c:20},
      { y: days[4], a: 80,  b: 65,c:20},
      { y: days[5], a: 90,  b: 70,c:10}
      
    ],*/
    config = {
      element:'chart',
      data: data,
      xkey: 'y',
      ykeys: data1.cat,
      labels: data1.cat,
      fillOpacity: 0.6,
      hideHover: 'auto',
      behaveLikeLine: true,
      resize: true,
      pointFillColors:['#ffffff'],
      pointStrokeColors: ['#707070'],
      lineColors:['#f7d692','#f99ea4','#8db1ec'],
       xLabels: 'day'
 // xLabelAngle: 45
  };
config.element = 'area-chart';
Morris.Area(config);
},
        error: function (response) {
            alert('');
        }
    });
</script>