<?php //echo "<pre>";print_r($info);?>

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
                           <li class="breadcrumb-item"><a href="<?php echo base_url();?>store">Stores</a></li>
                           <li class="breadcrumb-item"><a href="#">Edit Store</a></li>
                           
                        </ol>
                     </div>
                     <h4 class="page-title">Edit Store</h4>
                  </div>
               </div>
            </div>
            </div>
          
            <!-- end page title end breadcrumb -->
            <div class="row">
               <div class="col-12">
                  <div class="card m-b-30">
                     <div class="card-body">
                        <h4 class="mt-0 header-title">Edit Details</h4>
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
                        <form action="<?php echo base_url();?>store/edit_process/<?php echo $info[0]->storeId;?>" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->name;?>" name="name"class="form-control" required placeholder="Store Name" type="text"  id="example-text-input"></div>
                        </div>
                      
                       <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Store category</label>
                                <div class="col-sm-10">
                                      <ul class="store_cat">
                                       <?php foreach ($store_cat as $cat) { ?>
                                   <li class=" custom-control custom-checkbox options">
                                        <input type="checkbox" class="custom-control-input store_cat" id="customCheck<?php echo $cat->categoryId ?>" name="store_category[]"  value="<?php echo $cat->categoryId ?>" data-parsley-multiple="groups" data-parsley-mincheck="2" required="" <?php 
                                        
                                       foreach($info[0]->category as $scat)
                                       {
                                         //  print_r($scat);
                                           if($scat->storeCategoryId==$cat->categoryId)
                                           {
                                               echo"checked";
                                           }
                                       }
                                            
                                            ?>> 
                                   
                                        <label class="custom-control-label" for="customCheck<?php echo $cat->categoryId ?>"><?php echo $cat->name ?></label>
                                         <?php if($cat->sub_categories) { 
                                             ?>
                                           <ul>
                                                 <?php $i=0;foreach($cat->sub_categories as $row){?>
                                        <li class="">
                                              <input type="checkbox" class="custom-control-input store_cat" id="customCheck<?php echo $row->categoryId ?>" name="sub_category[]"  value="<?php echo $row->categoryId ?>" data-parsley-multiple="groups" data-parsley-mincheck="2"
                                                 <?php 
                                        
                                       foreach($info[0]->category as $subcat)
                                       {
                                           foreach($subcat->subcategory as $row1)
                                           {
                                         //  print_r($scat);
                                           if($row1->sub_category_id==$row->categoryId)
                                           {
                                               echo"checked";
                                           }
                                           }
                                       }
                                            
                                            ?>
                                                     >
                                              
                                              
                                             <label class="custom-control-label" for="customCheck<?php echo $row->categoryId ?>"><?php echo $row->name;?></label>
                                        </li>
                                        <?php }?>
                                            </ul>
                                            <?php }?>
                                        </li>
                                    
                                       <?php } ?>
                                  </ul>
                                </div>
                            </div>
                            
                             <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10"><input name="description" value="<?php echo $info[0]->description;?>"class="form-control"  placeholder=" Description" type="text"  id="example-email-input"></div>
                            </div>
                        <div class="form-group row">
                           <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->email;?>" name="email" class="form-control" required placeholder=" Email" type="email"  id="example-email-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-url-input" class="col-sm-2 col-form-label">Old Password</label>
                           <div class="col-sm-10"><input name="old_password" class="form-control"  placeholder="Password"type="password"  id="example-url-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-url-input" class="col-sm-2 col-form-label">New Password</label>
                           <div class="col-sm-10"><input name="new_password" class="form-control"  placeholder="Password"type="password"  id="example-url-input"></div>
                        </div>
                        
<!--                        <div class="form-group row">
                           <label for="example-password-input"  class="col-sm-2 col-form-label">Address</label>
                           <div class="col-sm-10">
                               <textarea class="form-control" name="address"><?php echo $info[0]->address;?></textarea>
                               </div>
                        </div>-->
<div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Address</label>
                           <div class="col-sm-10">
                               <input type="text" id="search-input" value="<?php echo $info[0]->address;?>"required="" name="address" placeholder="Enter a location">
                               <input type="hidden" value="<?php echo $info[0]->latitude;?>" id="latitude"  name="latitude" >
                               <input type="hidden" value="<?php echo $info[0]->longitude;?>" id="longitude" name="longitude">
                    
                                <div id="map_canvas" class="mapping"></div>
                           </div>
                        </div>
                        <div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Contact Number</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->contactNumber;?>" name="contactNumber"class="form-control" required placeholder="Contact Number" type="text" min="0" id="example-tel-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Contact Number Others</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->contactNumberOthers;?>" name="contactNumberOthers"class="form-control" min="0" placeholder="Contact Number Others" type="text" id="example-tel-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Contact Email</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->contactEmail;?>" name="contactEmail"class="form-control"  placeholder="Contact Email" type="email" id="example-tel-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Delivery Time (In minutes.)</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->deliveryTime;?>" name="deliveryTime"class="form-control" required placeholder="Delivery Time" type="number" min="1" id="example-tel-input"></div>
                        </div>
<!--                        <div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Delivery Fee</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->deliveryFee;?>" name="deliveryFee" class="form-control" required placeholder="delivery Fees" type="number" min="0" id="example-tel-input"></div>
                        </div>-->
 <div class="form-group row">
                                <label for="example-tel-input" class="col-sm-2 col-form-label">Commission Type</label>
                                <div class="col-sm-10"><select class="form-control" name="commission_type" required>
                                        <option disabled="" selected="">Select option</option>
                                        <option value="1" <?php if($info[0]->commission_type=='1'){
                                                                        echo 'selected';}?>>Per order (Flat)</option>
                                        <option value="2" <?php if($info[0]->commission_type=='2'){
                                                                        echo 'selected';}?>>Per order (%) </option>
                                        <option value="3" <?php if($info[0]->commission_type=='3'){
                                                                        echo 'selected';}?>>Per order items(Flat)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="example-tel-input" class="col-sm-2 col-form-label">Commission</label>
                                <div class="col-sm-10"><input name="commission" class="form-control" required placeholder="Commission" value="<?php echo $info[0]->commission;?>" type="number" min ="0" max="100" id="example-tel-input"></div>
                            </div>
                        <div class="form-group row">
                           <label for="example-tel-input" class="col-sm-2 col-form-label">Minimum Order</label>
                           <div class="col-sm-10"><input value="<?php echo $info[0]->minimumOrder;?>" name="minOrder"class="form-control" required placeholder="Minimum Order" type="number" min="1" id="example-tel-input"></div>
                        </div>
                        <div class="form-group row">
                           <label for="example-password-input" class="col-sm-2 col-form-label">Image</label>
                           <div class="col-sm-10">
                               <input type="file" accept="image/x-png, image/jpeg" class="form-control" name="image"/>
                               </div>
                        </div>
                        <div class="form-group row">
                           <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                           <div class="col-sm-10">
                               <?php if($info[0]->logo){?>
                               <img src="<?php echo base_url().$info[0]->logo;?>" height="100px" width="150px">
                                <?php }else{?>
                                      <img src="<?php echo base_url();?>assets/images/dummy.jpg" height="100px" width="100px">
                                     <?php }?>
                            </div>
                        </div>
                        <div class="form-group row">
                             <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                              <div class="col-sm-10">
                                  <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url();?>store"><button type="button" class="btn btn-secondary  ">Cancel</button></a>
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
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDt2DIpXtcPzp-dVRW5JQflJB6dnEWmZvs&libraries=places"></script>
 <script>
function initialize() {
 center_position = new google.maps.LatLng(<?php echo $info[0]->latitude;?>,<?php echo $info[0]->longitude;?>);//India
   
        //console.log(center_position);
    var map;
    var markerArray = [];
    var bounds = new google.maps.LatLngBounds();
    //var icon = new google.maps.MarkerImage('images/map-marker-black-1.png');
    var  markerImgUrl = "<?php echo base_url(); ?>assets/images/icons-marker.png";
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
            draggable:true,
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
            if (places.length == 0) { return; }
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
                        updateLocation(user_marker,results[0],latField,lngField);
                        
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
                    updateLocation(user_marker,results[0],e.latLng.lat(),e.latLng.lng());
                   // $('.modal').modal('hide');
                }
            }
        });
     });
     
    // marker drag event //
    
     google.maps.event.addListener(user_marker, 'dragend', function(){
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
google.maps.event.addListener(user_marker, 'dragend', function() {

geocoder.geocode({'latLng': user_marker.getPosition()}, function(results, status) {
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
     function geocodePosition(pos){
        geocoder = new google.maps.Geocoder();
        geocoder.geocode({latLng: pos},function(results, status){
                if (status == google.maps.GeocoderStatus.OK){
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
       function updateLocation(user_marker,result,latField,lngField)
       {
               if(latField!=null && lngField!=null)
               {
                 var latlong = new google.maps.LatLng(latField,lngField);
                 user_marker.setPosition(latlong);
               }
               else
               {
                 latField  = user_marker.getPosition().lat();
                 lngField  = user_marker.getPosition().lng();
               }
                 latitude  = latField;
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
window.onload = function() {
    $('#map_canvas').css('height',$( window ).height()-100);
    if (!navigator.geolocation){
        console.log("Geolocation is not supported by your browser");
        return;
    }
    navigator.geolocation.getCurrentPosition(success, error);
};
function success(position) {
        var latitude  = position.coords.latitude;
        var longitude = position.coords.longitude;
        center = {lat:latitude,lng:longitude};
       
         console.log(center);
         initialize();
         console.log("Your Location Retrieve Successfully");
    };
    function error() {
        initialize();
        console.log("Unable to retrieve your location");
    };
    
    $(window).resize(function() {
            $('#map_canvas').css('height',$( window ).height()-100);
    });
    $("input[type=checkbox]").click(function() {
    if(this.checked){
        $(this).parents('li').children('input[type=checkbox]').prop('checked',true);
    }
    else{
         $(this).parent().find('input[type=checkbox]').prop('checked',false);
    }
  });
</script>