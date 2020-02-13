
      <div class="wrapper">
         <div class="container-fluid">
            <!-- Page-Title -->
             <div class="header_title">
            <div class="row">
               <div class="col-sm-12">
                  <div class="page-title-box">
                     <div class="btn-group float-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin">Dashboard</a></li>
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>DeliveryBoy/"> Delivera Rider Rider</a></li>
                           <li class="breadcrumb-item"><a href="#">Add Delivera Rider Rider</a></li>
                           
                        </ol>
                     </div>
                     <h4 class="page-title">Add Delivera Rider Rider</h4> 
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
                        <?php if($this->session->userdata('error')){?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->userdata('error');?>
                        </div>
                        <?php }?>
                        <?php if($this->session->userdata('success')){?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->userdata('success');?>
                        </div>
                        <?php }?>
                        <form action="<?php echo base_url();?>DeliveryBoy/add_process" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                           <div class="col-sm-10"><input name="name" value="<?php if(isset($name)) echo $name;?>" class="form-control" required placeholder="Full Name" type="text"  id="example-text-input"></div>
                        </div>
                        
                        <div class="form-group row">
                           <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                           <div class="col-sm-10"><input name="email"  value="<?php if(isset($email)) echo $email;?>" class="form-control" required placeholder=" Email" type="email"  id="example-email-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-url-input" class="col-sm-2 col-form-label">Password</label>
                           <div class="col-sm-10"><input name="password" class="form-control" required placeholder="Password"type="password"  id="example-url-input"></div>
                        </div>
                        <!--<div class="form-group row">
                           <label for="example-url-input" class="col-sm-2 col-form-label">Address</label>
                           <div class="col-sm-10">
                               <textarea name="address" class="form-control" type="text"  id="example-url-input">
                                   
                               </textarea>
                           </div>
                        </div>-->
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
                           <div class="col-sm-8"><input name="phone"  value="<?php if(isset($phone)) echo $phone;?>"class="form-control" required placeholder="Phone" type="number" min="1" id="noZero"></div>
                        </div>
                         <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Brand Name</label>
                           <div class="col-sm-10"><input name="vehicle_brand" value="<?php if(isset($vehicleBrandName)) echo $vehicleBrandName;?>" class="form-control" required placeholder="Vehicle Brand Name" type="text"  id="example-text-input"></div>
                        </div>
                         <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Model Number</label>
                           <div class="col-sm-10"><input name="model_number" value="<?php if(isset($modelNumber)) echo $modelNumber;?>" class="form-control" required placeholder="Model Number" type="text"  id="example-text-input"></div>
                        </div>
                         <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Purchase Date</label>
                           <div class="col-sm-10"><input name="purchase_date" value="<?php if(isset($purchaseDate)) echo $purchaseDate;?>" class="form-control" required placeholder="" type="date"  id="example-text-input"></div>
                        </div>
                         <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Driving License</label>
                           <div class="col-sm-10"><input name="license" value="<?php if(isset($drivingLicense)) echo $drivingLicense;?>" class="form-control" required placeholder="Driving License" type="text"  id="example-text-input"></div>
                        </div>
                       
                        <div class="form-group row">
                             <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                              <div class="col-sm-10">
                                  <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url();?>deliveryBoy"><button type="button" class="btn btn-secondary">Cancel</button>
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