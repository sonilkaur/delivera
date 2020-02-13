<?php //echo"<pre>";print_r($result);  ?>

<link rel="stylesheet" type="text/css" media="screen"
      href="https://www.jqueryscript.net/demo/Bootstrap-4-Date-Time-Picker/build/css/tempusdominus-bootstrap-4.css"> 
<style> 

    #map_canvas {
        height: 270px !important;
        width: 60%;
        margin-bottom: 20px;
        // margin-left: 20%;
    }

    input#search-input {
        background-color: #f5f5f5 !important;
        border: 1px solid #ccc !important;
        padding: 10px 30px !important;
        border-radius: 50px !important;
        width: 50% !important;
        font-size: 15px !important;
        color: #8492af !important;
        margin-top: 5px !important;
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
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/home/">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Settings</a></li>

                            </ol>
                        </div>
                        <h4 class="page-title">Settings</h4>
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
                            <div class="col-lg-12 col-md-offset-6">
                                <div class="p-20">
                                    <?php if ($this->session->userdata('error')) { ?>
                                        <div class="alert alert-danger" role="alert">
                                            <?php echo $this->session->userdata('error'); ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($this->session->userdata('success')) { ?>
                                        <div class="alert alert-success" role="alert">
                                            <?php echo $this->session->userdata('success'); ?>
                                        </div>
                                    <?php } ?>
                                    <form action="<?php echo base_url(); ?>seller/home/setting_process" method="post" enctype="multipart/form-data">
                                        <div class="form-group"><label><h4> Store Type(Category)</label> :-
                                            <label>
                                                <?php
                                                ob_start();
                                                foreach ($result[0]->store_category as $sc) {
                                                    echo $sc->name . ",";
                                                }
                                                $output = ob_get_clean();

                                                echo rtrim($output, ',');
                                                ?>

                                                </h4>
                                            </label>

                                        </div>
                                        <div class="form-group"><label> Store Name</label> 
                                            <input type="text" placeholder="Store Name" value="<?php echo $result[0]->name; ?>" required name="store_name" class="form-control">
                                        </div>
                                        <div class="form-group"><label> Description</label> 
                                            <input type="text" placeholder="Description" value="<?php echo $result[0]->description; ?>" required name="description"class="form-control">
                                        </div>
                                        <!--                                    <div class="form-group">
                                                                                <label>Address</label> 
                                                                                <textarea name="address" class="form-control"><?php echo $result[0]->address; ?></textarea>
                                                                            </div>-->
                                        <div class="form-group row">
                                            <label for="example-tel-input" class="col-sm-2 col-form-label">Address</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="search-input" required="" name="address" placeholder="Enter a location">
                                                <input type="hidden"  id="latitude"  name="latitude" >
                                                <input type="hidden" id="longitude" name="longitude">

                                                <div id="map_canvas" class="mapping"></div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Old Password</label>
                                                    <input type="password"   placeholder="Old Password" name="old_password" class="form-control"> </div></div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label>New Password</label>
                                                    <input type="password" placeholder="New password"  name="new_password" class="form-control"> <span id="indicator"></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Contact number</label>
                                                    <input type="text" value="<?php echo $result[0]->contactNumber; ?>"  placeholder="Contact Number" name="contactNumber" class="form-control"> </div></div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Contact Number Other</label>
                                                    <input type="text" value="<?php echo $result[0]->contactNumberOthers; ?>" placeholder="Contact Number Others" name="others" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Contact Email</label>
                                                    <input type="email" value="<?php echo $result[0]->contactEmail; ?>" placeholder="Contact Email" name="contactEmail" class="form-control"> </div></div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Photo</label>
                                                    <p><input type="file" name="image" class="form-control"> </p>
                                                    <?php if ($result[0]->logo) { ?>
                                                        <img src="<?php echo base_url() . $result[0]->logo; ?>" width="100px" height="80px">
                                                    <?php } else { ?>
                                                        <img src="<?php echo base_url() ?>assets/images/dummy.jpg" width="100px" height="80px">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Delivery Time (In minutes.)</label>
                                                    <input type="number"  min="1"value="<?php echo $result[0]->deliveryTime; ?>" placeholder=" Delivery Time" name="deliveryTime" class="form-control"> </div></div>
                                            <div class="col-md-6">
                                                <div class="form-group"><label>Delivery Fee</label>
                                                    <input type="number" min="0" value="<?php echo $result[0]->deliveryFee; ?>" placeholder="Delivery Fee" name="deliveryFee" class="form-control"> 
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group"><label>Minimum Order</label>
                                                    <input type="number" min="1" value="<?php echo $result[0]->minimumOrder; ?>" placeholder="Minimum Order" name="minimumOrder" class="form-control"> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12"><label>Business Hours</label></div>
                                            <?php //echo"<pre>";print_r($result[0]->businessHours); ?>
                                            <?php
                                            if ($result[0]->businessHours) {
                                                $i = 1;
                                                ?>
                                                <?php foreach ($result[0]->businessHours as $row) { ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group row"><label class="col-sm-6 col-form-label"><?php echo $row->DoW; ?></label>
                                                            <div class="col-sm-6">
                                                                <select name="d<?php echo $i; ?>_status" class="form-control">
                                                                    <option value="0" <?php
                                                                    if ($row->status == "Closed") {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Closed</option>
                                                                    <option value="1" <?php
                                                                    if ($row->status == "Open") {
                                                                        echo "selected";
                                                                    }
                                                                    ?>>Open</option>
                                                                </select>
                                                            </div></div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker<?php echo $i; ?>" data-target-input="nearest">
                                                                        <input type="text" name="d<?php echo $i; ?>_OH" value="<?php echo $row->start_time; ?>" class="form-control datetimepicker-input" data-target="#datetimepicker<?php echo $i; ?>"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker<?php echo $i; ?>" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                                <input class="form-control" type="time" name="d<?php echo $i; ?>_OH" value="<?php echo $row->start_time; ?>" id="example-time-input">-->
                                                            </div></div>

                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch<?php echo $i; ?>" data-target-input="nearest">
                                                                        <input type="text"   name="d<?php echo $i; ?>_CH" value="<?php echo $row->end_time; ?>" class="form-control datetimepicker-input" data-target="#datetimepicker_ch<?php echo $i; ?>"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch<?php echo $i; ?>" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                              <input class="form-control" name="d<?php echo $i; ?>_CH" type="time" value="<?php echo $row->end_time; ?>" id="example-time-input">-->
                                                            </div></div>
                                                    </div>
        <?php
        $i++;
    }
} else {
    ?>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Monday</label>
                                                        <div class="col-sm-6">
                                                            <select name="d1_status" class="form-control">
                                                                <option value="0">Closed</option>
                                                                <option value="1">Open</option>
                                                            </select>
                                                        </div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker1" data-target-input="nearest">
                                                                        <input type="text" name="d1_OH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker1"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" type="time" name="d1_OH" value="" id="example-time-input">-->
                                                        </div></div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch1" data-target-input="nearest">
                                                                        <input type="text"   name="d1_CH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_ch1"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch1" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d1_CH" type="time" value="" id="example-time-input">-->
                                                        </div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Tuesday</label>
                                                        <div class="col-sm-6"><select name="d2_status" class="form-control">
                                                                <option value="0">Closed</option>
                                                                <option value="1">Open</option>
                                                            </select></div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker2" data-target-input="nearest">
                                                                        <input type="text" name="d2_OH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker2"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker2" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d2_OH" type="time" value="" id="example-time-input">-->
                                                        </div></div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch2" data-target-input="nearest">
                                                                        <input type="text"   name="d2_CH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_ch2"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch2" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d2_CH" type="time" value="" id="example-time-input">-->
                                                        </div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Wednesday</label>
                                                        <div class="col-sm-6">
                                                            <select name="d3_status" class="form-control">
                                                                <option value="0">Closed</option>
                                                                <option value="1">Open</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker3" data-target-input="nearest">
                                                                        <input type="text" name="d3_OH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker3"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker3" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d3_OH" type="time" value="" id="example-time-input">-->
                                                        </div></div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch3" data-target-input="nearest">
                                                                        <input type="text"   name="d3_CH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_ch3"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch3" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d3_CH" type="time" value="" id="example-time-input">-->
                                                        </div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Thursday</label>
                                                        <div class="col-sm-6"><select  name="d4_status" class="form-control">
                                                                <option value="0">Closed</option>
                                                                <option value="1">Open</option>
                                                            </select></div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker4" data-target-input="nearest">
                                                                        <input type="text" name="d4_OH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker4"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker4" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d4_OH" type="time" value="" id="example-time-input">-->
                                                        </div></div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch4" data-target-input="nearest">
                                                                        <input type="text"   name="d4_CH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_ch4"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch4" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d4_CH" type="time" value="" id="example-time-input">-->
                                                        </div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Friday</label>
                                                        <div class="col-sm-6"><select name="d5_status" class="form-control">
                                                                <option value="0">Closed</option>
                                                                <option value="1">Open</option>
                                                            </select></div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker5" data-target-input="nearest">
                                                                        <input type="text" name="d5_OH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker5"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker5" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d5_OH" type="time" value="" id="example-time-input">-->
                                                        </div></div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch5" data-target-input="nearest">
                                                                        <input type="text"   name="d5_CH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_ch5"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch5" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d5_CH" type="time" value="" id="example-time-input">-->
                                                        </div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Saturday</label>
                                                        <div class="col-sm-6"><select name="d6_status" class="form-control">
                                                                <option value="0">Closed</option>
                                                                <option value="1">Open</option>
                                                            </select></div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker6" data-target-input="nearest">
                                                                        <input type="text" name="d6_OH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker6"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker6" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d6_OH" type="time" value="" id="example-time-input">-->
                                                        </div></div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch6" data-target-input="nearest">
                                                                        <input type="text"   name="d6_CH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_ch6"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch6" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d6_CH" type="time" value="" id="example-time-input">-->
                                                        </div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Sunday</label>
                                                        <div class="col-sm-6"><select name="d7_status" class="form-control">
                                                                <option value="0">Closed</option>
                                                                <option value="1">Open</option>
                                                            </select></div></div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Start Time</label>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker7" data-target-input="nearest">
                                                                        <input type="text" name="d7_OH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker7"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
<!--                                                            <input class="form-control" name="d7_OH" type="time" value="" id="example-time-input">-->
                                                        </div></div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group row"><label class="col-sm-6 col-form-label">Closing Time</label>
                                                        <div class="col-sm-6">
                                                             <div class="form-group">
                                                                    <div class="input-group date " id="datetimepicker_ch7" data-target-input="nearest">
                                                                        <input type="text"   name="d7_CH" value="" class="form-control datetimepicker-input" data-target="#datetimepicker_ch7"/>
                                                                        <div class="input-group-append" data-target="#datetimepicker_ch7" data-toggle="datetimepicker">
                                                                            <div class="input-group-text"><i class="fa fa-clock-o"></i></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
<!--                                                            <input class="form-control" name="d7_CH" type="time" value="" id="example-time-input">-->
                                                        </div></div>
                                                </div>
<?php } ?>
                                        </div>




                                        <div class="form-group row">

                                            <div class="col-sm-12">
                                                <button id="btn-edit" type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url(); ?>seller/home/"><button type="button" class="btn btn-secondary">Cancel</button></a>
                                            </div>

                                        </div>
                                    </form>

                                </div>

                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDt2DIpXtcPzp-dVRW5JQflJB6dnEWmZvs&libraries=places"></script>
    <script>
        function initialize() {
            center_position = new google.maps.LatLng(<?php echo $result[0]->latitude; ?>,<?php echo $result[0]->longitude; ?>);//India

            //console.log(center_position);
            var map;
            var markerArray = [];
            var bounds = new google.maps.LatLngBounds();
            //var icon = new google.maps.MarkerImage('images/map-marker-black-1.png');
            var markerImgUrl = "<?php echo base_url(); ?>assets/images/icons-marker.png";
            // var icon = {
            //     url: markerImgUrl, // url
            //     scaledSize: new google.maps.Size(50, 50), // scaled size
            //     origin: new google.maps.Point(0,0), // origin
            //     anchor: new google.maps.Point(0, 0) // anchor
            // };


            map = new google.maps.Map(document.getElementById('map_canvas'), {
                zoom: 10,
                center: center_position,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            var position = center_position;
            var user_marker = new google.maps.Marker({
                position: center_position,
                map: map,
                draggable: true,
                // title: 'user marker',
                // icon:icon,
            });

            // bounds.extend(position);

            geocodePosition(user_marker.getPosition());
            updateLocation(user_marker);
            //  search Box start // 

            input = (document.getElementById('search-input'));

            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
            //    map.setZoom(5);
            var searchBox = new google.maps.places.SearchBox(input);

            //var searchBox = new google.maps.places.SearchBox((input),{bounds: position});
            google.maps.event.addListener(searchBox, 'places_changed', function () {
                var places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }
                for (var i = 0, place; place = places[i]; i++) {
                    var image = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };
                    bounds.extend(place.geometry.location);
                    latField = place.geometry.location.lat();
                    lngField = place.geometry.location.lng();
                }
                //map.fitBounds(bounds);
                var latlng = new google.maps.LatLng(latField, lngField);
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            updateLocation(user_marker, results[0], latField, lngField);

                            // map.setCenter({lat:latField, lng:lngField});

                            map.fitBounds(bounds);
                        }
                    }
                });
            });

            //  search Box End // 

            // map click event //

            google.maps.event.addListener(map, 'click', function (e) {
                var latlng = new google.maps.LatLng(e.latLng.lat(), e.latLng.lng());
                var geocoder = geocoder = new google.maps.Geocoder();
                geocoder.geocode({'latLng': latlng}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {

                            //map.setCenter(latlng);
                            $('#search-input').val(results[0].formatted_address);
                            updateLocation(user_marker, results[0], e.latLng.lat(), e.latLng.lng());
                            // $('.modal').modal('hide');
                        }
                    }
                });
            });

            // marker drag event //

            google.maps.event.addListener(user_marker, 'dragend', function () {
                geocodePosition(user_marker.getPosition());
                updateLocation(user_marker);
            });

            // functions //
            var circle = new google.maps.Circle({
                map: map,
                // /radius: ,    
                fillColor: '#027702'
            });

            circle.bindTo('center', user_marker, 'position');
            google.maps.event.addListener(user_marker, 'dragend', function () {

                geocoder.geocode({'latLng': user_marker.getPosition()}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            $('#address').val(results[0].formatted_address);
                            $('#latitude').val(user_marker.getPosition().lat());
                            $('#longitude').val(user_marker.getPosition().lng());
                            infowindow.setContent(results[0].formatted_address);
                            infowindow.open(map, user_marker);
                        }
                    }
                });
            });
            function geocodePosition(pos) {
                geocoder = new google.maps.Geocoder();
                geocoder.geocode({latLng: pos}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[0]) {
                            //updateLocation(user_marker,results[0])
                            address = results[0].formatted_address;
                            $('#search-input').val(address);
                            // infowindow.setContent(results[0].formatted_address);
                        }
                    }
                }
                );
            }
            function updateLocation(user_marker, result, latField, lngField)
            {
                if (latField != null && lngField != null)
                {
                    var latlong = new google.maps.LatLng(latField, lngField);
                    user_marker.setPosition(latlong);
                }
                else
                {
                    latField = user_marker.getPosition().lat();
                    lngField = user_marker.getPosition().lng();
                }
                latitude = latField;
                longitude = lngField;

                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
            }


            // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    //    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
    //        this.setZoom(5);
    //        google.maps.event.removeListener(boundsListener);
    //    });

        }

    </script>
    <script>
        var center;
        window.onload = function () {
            $('#map_canvas').css('height', $(window).height() - 100);
            if (!navigator.geolocation) {
                console.log("Geolocation is not supported by your browser");
                return;
            }
            navigator.geolocation.getCurrentPosition(success, error);
        };
        function success(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            center = {lat: latitude, lng: longitude};

            console.log(center);
            initialize();
            console.log("Your Location Retrieve Successfully");
        }
        ;
        function error() {
            initialize();
            console.log("Unable to retrieve your location");
        }
        ;

        $(window).resize(function () {
            $('#map_canvas').css('height', $(window).height() - 100);
        });
    </script>