
<div class="wrapper">
    <div class="container-fluid">
        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/home/">Dashboard</a></li>

                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>seller/order/promo_code">Promo codes</a></li>
                            <li class="breadcrumb-item"><a href="#">Edit Promo Code</a></li>

                        </ol>
                    </div>
                    <h4 class="page-title">Edit Promo Code</h4>
                </div>
            </div>
        </div>

        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12 ">
                <div class="card m-b-30">
                    <div class="card-body">

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
                        <form action="<?php echo base_url(); ?>seller/order/edit_promo_process/<?= $promo->codeId?>" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Code Type</label>
                                <div class="col-sm-10">
                                    <select name="type" class="form-control">
                                        <option value="">Select Code type</option>
                                        <option value="2" <?php if($promo->type=='2'){echo 'selected';}?>>Flat Rate</option>
                                        <option value="1" <?php if($promo->type=='1'){echo 'selected';}?>>Percentage Rate(%)</option>
                                    </select>
                                    <input type="hidden" name="created_by" value="seller">
                                        <input type="hidden" name="sellerId" value="<?= $_SESSION['sellerid']?>">
                                </div>
                            </div>
  <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Promo Code Amount</label>
                                <div class="col-sm-10">
                                    <input type="number" min="1" name="code_amount" value="<?=  $promo->code_amount;?>"required="" placeholder="Code Amount" class="form-control">       
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Minimum Order Amount</label>
                                <div class="col-sm-10">
                                    <input type="number" min="1" name="min_order_ammount"  value="<?=  $promo->minOrderAmount;?>" required="" placeholder="Minimum Order Amount" class="form-control">       
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Code</label>
                                <div class="col-sm-10">
                                    <label>
                                        <input type="radio" name="options" onClick="generateRandomString()" id="Auto"> Auto
                                    </label>
                                    <label>
                                        <input type="radio" name="options" id="custom"> Custom
                                    </label>
                                    <input type="text" value="<?=  $promo->code;?>"name="code" required="" id="promo" placeholder="Promo Code" class="form-control">       
                                </div>
                            </div>
                        <div class="form-group row">
                           <label for="example-email-input" class="col-sm-2 col-form-label">Start Date</label>
                           <div class="col-sm-10">
                               <input type="date" name="start_date" id="start_date" value="<?=  $promo->start_date;?>" required="" id="start_date" class="form-control">       
                           </div>
                        </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Expiry Code</label>
                                <div class="col-sm-10">
                                    <input type="date" value="<?=  $promo->expiryDate;?>" id="end_date" name="expiry_date" required=""  class="form-control">       
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Total Used</label>
                                <div class="col-sm-10">
                                    <input type="number" value="<?=  $promo->total_used;?>" name="total_used" required=""  class="form-control">       
                                </div>
                            </div>
                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Per User Used</label>
                                <div class="col-sm-10">
                                    <input type="number" value="<?=  $promo->user_used;?>" name="user_used" required=""  class="form-control">       
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                        <label class="btn btn-secondary <?php if($promo->status=='1'){echo 'focus active';}?>">
                                            <input type="radio" name="status" value="1" id="option1" <?php if($promo->status=='1'){echo 'checked';}?>> Active
                                        </label>

                                        <label class="btn btn-secondary <?php if($promo->status=='0'){echo 'focus active';}?>">
                                            <input type="radio" name="status" value="0" id="option3" <?php if($promo->status=='0'){echo 'checked';}?>> Inactive
                                        </label>
                                    </div>    
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Send</button> <button type="reset" class="btn btn-secondary waves-effect ">Cancel</button>
                                </div>
                            </div>
                        </form>
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
    function generateRandomString() {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789@#&";

        for (var i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        $("#promo").val(text);
        $("#promo").attr("readonly", true);
        //return text;
    }

    $("#custom").click(function () {
        $("#promo").val("");
        $("#promo").attr("readonly", false);
    });
$("#end_date").change(function () {
    var startDate = document.getElementById("start_date").value;
    var endDate = document.getElementById("end_date").value;

    if ((Date.parse(startDate) > Date.parse(endDate))) {
        alert("End date should be greater than Start date");
        document.getElementById("end_date").value = ""; 
    }
});

</script>