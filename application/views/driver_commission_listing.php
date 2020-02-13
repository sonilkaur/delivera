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
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin/">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#">Delivera Rider Commission</a></li>

                            </ol>

                        </div>
                        <h4 class="page-title">Delivera Rider Commission</h4>
                        <a href="<?php echo base_url(); ?>admin/add_driver_commission/"> <button type="button" class="btn btn-primary waves-effect waves-light ">Add</button></a>

                    </div>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <?php if (isset($driver_commission)) { ?>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <?php //echo"<pre>"; print_r($data);?>
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>From(KM)</th>
                                        <th>To(KM)</th>
                                        <th>Rate</th>

                                        <th class="no-sort">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1;
                                    foreach ($driver_commission as $ch) { ?>
        <?php //print_r($restaurant->id) ?>
                                        <tr>
                                            <td><?php echo $i;
        $i++; ?></td>
                                            <td><?php echo $ch->start; ?></td>
                                            <td><?php echo $ch->end; ?></td>
                                            <td><?php echo Globals::getCurrency() . $ch->rate; ?></td>
                                            <td>

                                                <span  class="action">
                                                    <a href="<?= base_url() ?>admin/edit_driver_commission/<?= $ch->driver_commission_id ?>"  >
                                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                                    </a>|
                                                    <a href="#" id="delete" onclick="remove(<?php echo $ch->driver_commission_id; ?>, 'admin/delete_driver_commission')">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>

                                                </span>
                                            </td>
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
