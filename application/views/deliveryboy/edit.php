<style> 

    #map_canvas {
        height: 270px !important;
        width: 60%;
        margin-bottom: 20px;
        margin-left: 20%;
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
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>admin">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>deliveryBoy/"> Delivera Rider Rider</a></li>
                                <li class="breadcrumb-item"><a href="#">Edit Delivera Rider Rider</a></li>

                            </ol>
                        </div>
                        <h4 class="page-title">Edit Delivera Rider Rider</h4>
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
                        <form action="<?php echo base_url(); ?>deliveryBoy/edit_process/<?php echo $info->boyId; ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group row">
                                <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10"><input name="name"class="form-control" value="<?php echo $info->fullName; ?>"required placeholder="Full Name" type="text"  id="example-text-input"></div>
                            </div>

                            <div class="form-group row">
                                <label for="example-email-input" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10"><input name="email" value="<?php echo $info->email; ?>" class="form-control" required placeholder=" Email" type="email"  id="example-email-input"></div>
                            </div>
                            <div class="form-group row">
                                <label for="example-url-input" class="col-sm-2 col-form-label">New Password</label>
                                <div class="col-sm-10"><input name="new_password" class="form-control" placeholder="New Password" type="password"  id="example-url-input"></div>
                            </div>
                            <div class="form-group row">
                                <label for="example-url-input" class="col-sm-2 col-form-label">Confirm Password</label>
                                <div class="col-sm-10"><input name="confirm_password" class="form-control" placeholder="Confirm Password" type="password"  id="example-url-input"></div>
                            </div>
                            <div class="form-group row">
                                <label for="example-tel-input" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-2">
                                    <select  class="form-control" id="select" name="dial_code" required="">
                                        <?php $res = $this->db->query("select * from country")->result(); ?>
                                        <option disabled="" selected="" value=""></option>
                                        <?php foreach ($res as $row): ?>
                                            <option value="<?= $row->dial_code; ?>" <?php if ($info->dial_code == $row->dial_code) {
                                            echo 'selected';
                                        } ?>><?= $row->dial_code; ?></option>
<?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-8"><input name="phone"class="form-control" value="<?php echo $info->phone; ?>" required placeholder="Phone" type="number" min="1" id="noZero"></div>
                            </div>
                             <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Vehicle Brand Name</label>
                           <div class="col-sm-10"><input name="vehicle_brand" value="<?php  echo $info->vehicleBrandName;?>" class="form-control" required placeholder="Vehicle Brand Name" type="text"  id="example-text-input"></div>
                        </div>
                         <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Model Number</label>
                           <div class="col-sm-10"><input name="model_number" value="<?php  echo $info->modelNumber;?>" class="form-control" required placeholder="Model Number" type="text"  id="example-text-input"></div>
                        </div>
                         <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Purchase Date</label>
                           <div class="col-sm-10"><input name="purchase_date" value="<?php  echo $info->purchaseDate;?>" class="form-control" required placeholder="" type="date"  id="example-text-input"></div>
                        </div>
                         <div class="form-group row">
                           <label for="example-text-input" class="col-sm-2 col-form-label">Driving License</label>
                           <div class="col-sm-10"><input name="license" value="<?php  echo $info->drivingLicense;?>" class="form-control" required placeholder="Driving License" type="text"  id="example-text-input"></div>
                        </div>
                       
                    
                            <div class="form-group row">
                                <label for="example-password-input" class="col-sm-2 col-form-label"></label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Submit</button> <a href="<?php echo base_url(); ?>deliveryBoy"><button type="button" class="btn btn-secondary">Cancel</button></a>
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
<script>
    $("#select").select2({
        placeholder: "Select Country code"
                //allowClear: true
    });
     document.getElementById('noZero').addEventListener('blur', checkZero)
    
    function checkZero(){
        var val = this.value;
        if(val.charAt(0) === '0')
            this.value = val.slice(1), checkZero.call(this);
    }
</script>
<!-- end wrapper --><!-- Footer 
AIzaSyDt2DIpXtcPzp-dVRW5JQflJB6dnEWmZvs-->
<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD09OD0pCgjHMMflz46xHOSQpLFzszIy7w&libraries=places"></script>
<script>
function initialize() {
center_position = new google.maps.LatLng(31.311445,75.607819);//India

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
</script>-->