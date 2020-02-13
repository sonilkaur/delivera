<?php // print_r($result);   ?>
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/home/dashboard">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/order">Order</a></li>
                            <li class="breadcrumb-item"><a href="#">View Order</a></li>

                        </ol>

                    </div>
                    <h4 class="page-title">View Order</h4>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <?php if ($result) { ?>
                        <div class="card-body">
                            <h4 class="mt-0 header-title">Status</h4>

                            <div class=" text-muted m-b-30 font-14 funkyradio">
                                <ul>
                                    <li>
                                        <div class="funkyradio-warning">
                                            <input type="radio" name="status" value="0" id="radio1" <?php if ($result->status == '0') {
                        echo 'checked';
                    }
                    ?>>
                                            <label for="radio1">Pending</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="funkyradio-primary">
                                            <input type="radio" name="status" value="5" id="radio2"  <?php if ($result->status == '5') {
                        echo 'checked';
                    }
                    ?>>
                                            <label for="radio2">Accept</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="funkyradio-danger">
                                            <input type="radio" name="status" value="6" id="radio3"  <?php if ($result->status == '6') {
                        echo 'checked';
                    }
                    ?>>
                                            <label for="radio3">Reject</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="funkyradio-cancelled">
                                            <input type="radio" name="status" value="3" id="radio4"  <?php if ($result->status == '3') {
                        echo 'checked';
                    }
                        ?>>
                                            <label for="radio4">Cancel</label>
                                        </div>
                                    </li>
                                      <li>
                                    <div class="funkyradio-cancelled">
                                        <input type="radio" name="status" value="refund" id="radio12"  <?php
                                        if ($result->payment_status == '2') {
                                            echo 'checked';
                                        }
                                        ?>>
                                        <label for="radio12">Refund</label>
                                    </div>
                                </li>
                                    <li>
                                        <div class="funkyradio-info">
                                            <input type="radio" name="status" value="2" id="radio5"  <?php if ($result->status == '2') {
                                                   echo 'checked';
                                               }
                                               ?>>
                                            <label for="radio5">Processing</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="funkyradio-ready">
                                            <input type="radio" name="status" value="4" id="radio6"  <?php if ($result->status == '4') {
                                                   echo 'checked';
                                               }
                                               ?>>
                                            <label for="radio6">Ready</label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="funkyradio-pickup">
                                            <input type="radio" name="status" value="7" id="radio7"  <?php if ($result->status == '7') {
                                                   echo 'checked';
                                               }
                                               ?>>
                                            <label for="radio7">Pickup</label>
                                        </div>
                                    </li>

                                    <li>
                                        <div class="funkyradio-success">
                                            <input type="radio" name="status" value="1" id="radio8"  <?php if ($result->status == '1') {
                                                   echo 'checked';
                                               }
                                               ?>>
                                            <label for="radio8">Delivered</label>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-selected="false">Customer Info</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false">Order Items</a></li>
                              
                                  <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#delivery_boy" role="tab" aria-selected="false"> Delivera Rider</a></li>

                            </ul>
    <?php //echo "<pre>"; print_r($result); ?>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane p-3 active show" id="home" role="tabpanel">
                                    <p class="font-14 mb-0">
                                    <table width="100%" border="1">
                                        <tbody>

                                            <tr>
                                                <th>Name</th>
                                                <td><?php echo $result->user_name; ?></td>
                                                <td colspan="2" rowspan="4">Notes :<?php echo $result->description; ?> </td>
                                            </tr>
                                            <tr>
                                                <th>Address</th>
                                                <td><?php echo $result->address; ?></td>

                                            </tr>
                                            <tr>
                                                <th>Phone</th>
                                                <td><?php echo $result->phone; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Email</th>
                                                <td><?php echo $result->email; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Order</th>
                                                <td><?php echo $result->totalCount; ?> Items - <?php echo "$ " . $result->totalPrice; ?></td>
                                                <th>Date/Time</th>
                                                <td><?php echo $result->createdOn; ?></td>

                                            </tr>
                                            <tr>
                                                <th>Delivery Cost</th>
                                                <td colspan="3">
                                        <?php echo "$ " . $result->delivery_fee; ?>                                  </td>
                                            </tr>
                                            <tr>
                                                <th>TAX</th>
                                                <td colspan="3">
    <?php echo "$ " . $result->total_tax; ?>                                 </td>
                                            </tr>
                                            <tr>
                                                <th>Payment Method</th>
                                                <td colspan="3">
    <?php echo $result->payment_method; ?>                                 </td>
                                            </tr>

                                        </tbody>

                                    </table>

                                    </p>
                                </div>
                                <div class="tab-pane p-3" id="profile" role="tabpanel">
                                    <p class="font-14 mb-0">
                                    <ul class="list-unstyled msg_list">
    <?php $i = 1;
    foreach ($result->order_items as $item) { ?>
        <?php echo '<span class="item_heading">Item #' . $i . '</span>';
        $i++; ?>
                                            <li>
                                                <a>
                                                    <span>
                                                        <span class="op_name"><?php echo $item->item_name; ?></span>
                                                        <span class="time">
                                                            <span class="offer_price">

        <?php echo "<span>$</span>" . $item->offerPrice; ?>
                                                            </span>  

                                            <?php if ($item->offerPrice) echo '<strike>'; ?>
                                            <?php echo "<span>$</span>" . $item->price; ?>
                                            <?php if ($item->offerPrice) echo '</strike>'; ?>



                                                        </span>

        <!-- <span class="time"><span>€</span>
            2.79 + <span>€</span>
            0.21 : <span>€</span> 3.00</span> -->

                                                    </span>
                                                    <span class="message">
        <?php echo $item->notes; ?>                                           </span>
                                                </a>

                                            </li>
        <?php
        // print_r($item->);
        if ($item->extra) {
            echo '<span class="item_heading">Extra Items </span>';
            foreach ($item->extra as $extra) {

                // print_r($item->extra);
                ?>
                                                    <li class="extra">
                                                        <a>
                                                            <span>
                                                                <span class="op_name"><?php echo $extra->name; ?></span>
                                                                <span class="time"><span>$</span>
                <?php echo $extra->price; ?></span>

                <!-- <span class="time"><span>€</span>
                    2.79 + <span>€</span>
                    0.21 : <span>€</span> 3.00</span> -->

                                                            </span>

                                                        </a>
                                                    </li>
            <?php }
        } ?>
    <?php } ?>

                                    </ul>

                                    </p>
                                </div>
                               
                                  <div class="tab-pane p-3" id="delivery_boy" role="tabpanel">
                                <p class="font-14 mb-0">
                                <div class="row">
<?php //echo '<pre>';print_r($result->delivery_boy); ?>
                                    <div class="box_1">
<?php
if ($result->delivery_boy) {
    foreach ($result->delivery_boy as $row) {
        ?>
                                                <div class="big1 ">
                                                    <div class="col-lg-12" style="padding:0;">
                                                        <div class="delivery_boy_info">
                                                            <div class="delivery_boxx">
                                                                  <?php if ($row->photo) { ?>
                                                                    <img src="<?php echo ASSET_PATH . $row->photo; ?>" class="img-responsive"/>
        <?php } else { ?>
                                                                    <img src="<?php echo base_url(); ?>assets/images/delivery_boyzzz.jpeg" class="img-responsive"/>
        <?php } ?>
                                                                
                                                                <div class="info_boxx">
                                                                    <h3><?php echo $row->fullName; ?></h3>
                                                                    <p><i class="fa fa-envelope"></i><?php echo $row->email; ?></p>
                                                                    <p><i class="fa fa-mobile"></i><?php echo $row->phone; ?></p>
                                                                    <p/><i class="fa fa-map-marker"></i><?php echo $row->address; ?></p>
                                                                </div>
                                                            </div>
                                                            <div class="vehicle_details">
                                                                <h3></h3>
                                                                <ul>
                                                                    <li>
                                                                        <div class="vehcile_box">
                                                                            <p><strong>Vehicle Brand Name:</strong> <br><?php echo $row->vehicleBrandName; ?></p>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="vehcile_box">
                                                                            <p><strong>Vehicle Model Number:</strong> <br><?php echo $row->modelNumber; ?></p>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="vehcile_box">
                                                                            <p><strong>Vehicle License Number:</strong> <br><?php echo $row->drivingLicense; ?></p>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="vehcile_box">
                                                                            <p><strong>Vehicle Purchase Date:</strong> <br><?php echo $row->purchaseDate; ?></p>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input id="chb" name="delivery_id" value="<?php echo $row->boyId; ?>" type="radio" />
                                                </div>
    <?php }
} ?>

                                    </div>
                                </div>
                                </p>
                            </div>

                            </div>
                        </div>
<?php } ?>
                </div>
                <!-- end col -->
            </div>
        </div>
        <script>
            $(function () {

                $("input[name=status]").change(function () {

                    var order_status = $("input[name=status]:checked").val();
                    //alert(order_status);

                    $.ajax({
                        type: "POST",
                        dataType: "text",
                        async: false,
                        url: "<?php echo base_url(); ?>" + "seller/order/updateOrderStatus", //Relative or absolute path to response.php file
                        data: {'order_status': order_status, 'orders_id': "<?php echo $result->orderId; ?>"},
                        success: function (data) {
                            alert(data);
                            location.reload();
                        }
                    });
                });
            });
        </script>      