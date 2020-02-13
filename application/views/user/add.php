
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
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>user/"> Users</a></li>
                                <li class="breadcrumb-item"><a href="#">Add User</a></li>

                            </ol>
                        </div>
                        <h4 class="page-title">Add User</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- end page title end breadcrumb -->
        <div class="row">
            <div class="col-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <h4 class="mt-0 header-title">Add Details</h4>
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
                        <form action="<?php echo base_url(); ?>user/add_process" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10"><input name="name" value="<?php if (isset($name)) echo $name; ?>"class="form-control" required placeholder="Full Name" type="text"  id="example-text-input"></div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10"><input name="email" value="<?php if (isset($email)) echo $email ?>" class="form-control" required placeholder=" Email" type="email"  id="example-email-input"></div>
                            </div>
                            <div class="form-group row">
                                <label for="example-url-input" class="col-sm-2 col-form-label">Password</label>
                                <div class="col-sm-10"><input name="password" class="form-control" required placeholder="Password" type="password"  id="example-url-input"></div>
                            </div>
                            <div class="form-group row">
                                <label for="example-tel-input" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-2">
                                    <select  class="form-control" id="select" name="dial_code" required="">
<?php $res=$this->db->query("select * from country")->result();?>
                                        <option disabled="" selected="" value=""></option>
                                        <?php foreach($res as $row):?>
                                        <option value="<?= $row->dial_code;?>"><?= $row->dial_code;?></option>
                                        <?php endforeach;?>
                                    </select></div>
                                <div class="col-sm-8"><input name="phone" value="<?php if (isset($phone)) echo $phone ?>"  class="form-control" required placeholder="Phone" type="tel"  id="noZero"></div>
                            </div>

                            <!-- <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label">Image</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="image"/>
                                   
                                    </div>
                             </div>-->
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url(); ?>user/"><button type="button" class="btn btn-secondary">Cancel</button></a>
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
$("#select").select2( {
 placeholder: "Select Country code"
 //allowClear: true
 } );
   document.getElementById('noZero').addEventListener('blur', checkZero)
    
    function checkZero(){
        var val = this.value;
        if(val.charAt(0) === '0')
            this.value = val.slice(1), checkZero.call(this);
    }
</script>