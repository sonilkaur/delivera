<!-- Load c3.css -->
<link href="<?php echo base_url(); ?>assets/pages/c3.css" rel="stylesheet">

<!-- Load d3.js and c3.js -->
<script src="<?php echo base_url(); ?>assets/pages/d3-5.8.2.min.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>assets/pages/c3.min.js"></script>
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
								<h5 class="m-0"><?php echo $stats['new_orders']->orders ; ?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card mini-stat m-b-30">
						<div class="p-3 bg-primary text-white">
							<div class="mini-stat-icon"><i class="mdi mdi-account-network float-right mb-0"></i>
							</div>
							<h6 class="text-uppercase mb-0">Total Users</h6> 
						</div>
						<div class="card-body">
							
							<div class="mt-4 text-muted">
								<div class="float-right">
									<p class="m-0"></p>
								</div>
								<h5 class="m-0"><?php echo ($stats['total_users']->users) ;?></h5>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-md-6">
					<div class="card mini-stat m-b-30">
						<div class="p-3 bg-primary text-white">
							<div class="mini-stat-icon"><i class="mdi mdi-tag-text-outline float-right mb-0"></i>
							</div>
							<h6 class="text-uppercase mb-0">Completed orders</h6>
						</div>
						<div class="card-body">
							
							<div class="mt-4 text-muted">
								<div class="float-right">
									<p class="m-0"></p>
								</div>
								<h5 class="m-0"><?php echo ($stats['complete_orders']->complete_orders) ;?></h5>
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
									<p class="m-0"></p>
								</div>
								<h5 class="m-0"><?php echo Globals::getCurrency() .($stats['earnings']->admin_earnings) ;?></h5>
							</div>
						</div>
					</div>
				</div>
                           <div class="col-xl-8">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Daily Order Summary</h4>
                        <div id="chart1"></div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Stores Ratio</h4>
                        <div id="chart2"></div>
                    </div>
                </div>
            </div>
			</div>
			<!-- end row -->
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
   // var today = date.getDate() + '/' + (date.getMonth() + 1) + '/' + date.getFullYear();
    var today =  date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
    days.push(today);
    for (i = 0; i < 6; i++)
    {
        date.setDate(date.getDate() - 1);
        var dow = date.getFullYear() + '-' + (date.getMonth() + 1) + '-' + date.getDate();
        days.push(dow);
//    
    }
  //  var ctx = document.getElementById("chart").getContext("2d"); 


    //days.push
   // var hello = "abc";
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>admin/get_list',
        dataType: 'json',
        data: {'days': days, 'table_name': 'orders'},
        success: function (data) {
           // console.log(days[0][1]);
           // console.log(data.result);
            //console.log(data.result[days[0]].length);
            var chart = c3.generate({
               
                data: {
                    x: 'x',
                    xFormat: '%Y-%m-%d', // 'xFormat' can be used as custom format of 'x'
                    columns: [
                        ['x', days[0], days[1], days[2], days[3], days[4], days[5]],
//            ['x', '20130101', '20130102', '20130103', '20130104', '20130105', '20130106'],

                        ['Cloth',
                            (data.result[days[0]].length == '0') ? "0":  data.result[days[0]][0].sale,
                            (data.result[days[1]].length == '0') ? "0":  data.result[days[1]][0].sale,
                            (data.result[days[2]].length == '0') ? "0":  data.result[days[2]][0].sale,
                            (data.result[days[3]].length == '0') ? "0":  data.result[days[3]][0].sale,
                            (data.result[days[4]].length == '0') ? "0":  data.result[days[4]][0].sale,
                            (data.result[days[5]].length == '0') ? "0":  data.result[days[5]][0].sale
   
                            ],
                        ['Electronics',
                             (!data.result[days[0]][1]) ? "0":  data.result[days[0]][1].sale,
                             (!data.result[days[1]][1]) ? "0":  data.result[days[1]][1].sale,
                             (!data.result[days[2]][1]) ? "0":  data.result[days[2]][1].sale,
                             (!data.result[days[3]][1]) ? "0":  data.result[days[3]][1].sale,
                             (!data.result[days[4]][1]) ? "0":  data.result[days[4]][1].sale,
                             (!data.result[days[5]][1]) ? "0":  data.result[days[5]][1].sale
                         
                       ],
                         ['Food',
                             (!data.result[days[0]][2]) ? "0":  data.result[days[0]][2].sale,
                             (!data.result[days[1]][2]) ? "0":  data.result[days[1]][2].sale,
                             (!data.result[days[2]][2]) ? "0":  data.result[days[2]][2].sale,
                             (!data.result[days[3]][2]) ? "0":  data.result[days[3]][2].sale,
                             (!data.result[days[4]][2]) ? "0":  data.result[days[4]][2].sale,
                             (!data.result[days[5]][2]) ? "0":  data.result[days[5]][2].sale
//                           
                        ]
                    ]
                },
                 bindto: '#chart1',
                axis: {
                    x: {
                        type: 'timeseries',
                        tick: {
                            format: '%Y-%m-%d'
                        }
                    }
                }
            });

            setTimeout(function () {
                chart.load({
                    columns: [
                       
                    ]
                });
            }, 1000);


        },
        error: function (response) {
            alert('');
        }
    });
    
   $.ajax({
        type: 'POST',
        url: '<?php echo base_url(); ?>admin/get_custome_store',
        dataType: 'json',
        data: {},
        success: function (data) {
            console.log(data);
            var d1=[];
             $.each(data, function(key,val) { 
                 var element={};
                 element=[val.name,val.total];
                 d1.push(element);
               
        }); 
        
           // console.log(d1);
var chart2 = c3.generate({
    data: {
        // iris data from R
        columns:d1,
        type : 'pie',
        onclick: function (d, i) { console.log("onclick", d, i); },
        onmouseover: function (d, i) { console.log("onmouseover", d, i); },
        onmouseout: function (d, i) { console.log("onmouseout", d, i); }
    },
     bindto: '#chart2'
});

setTimeout(function () {
    chart2.load({
        columns: d1
    });
}, 1500);

setTimeout(function () {
    chart2.unload({
        ids: 'data1'
    });
    chart2.unload({
        ids: 'data2'
    });
}, 2500);
        },
        error: function (response) {
            alert('');
        }
    });

</script>