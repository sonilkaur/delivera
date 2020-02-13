<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">? 2019 <b>Delivera</b><span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by Intellisense Technology.</span>
            </div>
        </div>
    </div>
</footer>

<script>


    function remove(id, link) {

        swal({
            title: "Are you sure?",
            //text: "Are you sure want to delete?",
            type: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, Delete it!",
            cancelButtonText: "No!",
            confirmButtonClass: "btn btn-success",
            cancelButtonClass: "btn btn-danger m-l-10",
            buttonsStyling: !1
        }).then(function () {
            var requesturl = "<?= base_url(); ?>" + link;
            $.ajax({
                url: requesturl,
                data: {id: id},
                datatype: "json",
                type: "POST",
                success: function (data) {
                    /* alert(data); */
                    if (data)
                    { //swal("Deleted!", "Your record has been deleted.", "success"
                        swal({title: "Deleted", text: "Your record has been deleted", type: "success"})
                                .then(function () {
                                    location.reload();
                                });
//                                    
                    }
                    else
                    {
                        swal({title: "Oops", text: "Error updating", type: "success"})
                                .then(function () {
                                    location.reload();
                                });

                    }


                }
            });

        }, function () {
            "cancel" === t && swal({title: "Cancelled", text: "You Record is safe!", type: "success"})

        });
    }


</script>
<!-- End Footer -->


<script src="<?php echo base_url(); ?>assets/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/detect.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
<!--        <script src="<?php echo base_url(); ?>assets/plugins/datatables/jszip.min.js"></script>-->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/buttons.colVis.min.js"></script>
<!-- Responsive examples -->
<script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/datatables/responsive.bootstrap4.min.js"></script>
<!-- Datatable init js -->
<script src="<?php echo base_url(); ?>assets/pages/datatables.init.js"></script>
<!-- skycons -->

<script src="<?php echo base_url(); ?>assets/plugins/skycons/skycons.min.js"></script>
<!-- skycons -->
<script src="<?php echo base_url(); ?>assets/plugins/peity/jquery.peity.min.js"></script>
<!--Morris Chart
<script src="<?php echo base_url(); ?>assets/plugins/morris/morris.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/raphael/raphael-min.js"></script>
<!-- dashboard 
<script src="<?php echo base_url(); ?>assets/pages/dashboard.js"></script>-->
<!-- Dropzone js -->
<script src="<?php echo base_url(); ?>assets/plugins/dropzone/dist/dropzone.js"></script>
<script src="<?php echo base_url(); ?>assets/js/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/js/waves.js"></script>
<!-- Sweet-Alert  -->
<script src="<?php echo base_url(); ?>assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/pages/sweet-alert.init.js"></script>
<!-- Magnific popup --><script src="<?php echo base_url(); ?>assets/plugins/magnific-popup/jquery.magnific-popup.min.js"></script><script src="<?php echo base_url(); ?>assets/pages/lightbox.js"></script>
<!-- App js -->
<script src="<?php echo base_url(); ?>assets/js/app.js"></script>
<script>
$(document).ready(function () {

$('#parent').trigger("change");

});
$(document).ready(function () {


var max_fields = 10; //maximum input boxes allowed
var wrapper = $(".variations"); //Fields wrapper
var add_button = $(".add_field_button"); //Add button ID

var x = 1; //initlal text box count
$(add_button).click(function (e) {

    //on add input button click
    e.preventDefault();
    if (x < max_fields) { //max input box allowed
        x++; //text box increment
        $(wrapper).append('<div class="abc"><div class="row"><div class="col-md-3"><div class="form-group"><label>Options</label><input type="text" name="options[]"  class="form-control"> <input type="hidden" value="1" name="count[]" ></div></div><div class="col-md-3"><div class="form-group"><label>Regular Price</label><input type="number" name="reg_price[]" class="form-control"> </div></div><div class="col-md-3"><div class="form-group"><label>Sale Price</label><input type="number"  name="off_price[]" class="form-control"></div></div><div class="col-md-3"><div class="form-group actions"><button type="button" class="btn btn-danger waves-effect waves-light"><a href="#" class="remove_field"><i class="fa fa-close"></i>Remove</a></div></div></div></div></div>'); //add input box
    }
});

$(wrapper).on("click", ".remove_field", function (e) { //user click on remove text
    e.preventDefault();
    $(this).parents('div.abc').remove();
    x--;
})
var max_fields1 = 10; //maximum input boxes allowed
var wrapper1 = $(".more_items"); //Fields wrapper
var add_button1 = $(".add_item_btn"); //Add button ID

var x = 1; //initlal text box count
$(add_button1).click(function (e) {

    //on add input button click
    e.preventDefault();
    if (x < max_fields1) { //max input box allowed
        x++; //text box increment
        $(wrapper1).append('<div class="abc"><div class="row"><div class="col-md-4"><div class="form-group"><label>Item name</label><input type="text" name="item[]"  class="form-control"> <input type="hidden" value="1" name="item_count[]" ></div></div><div class="col-md-4"><div class="form-group"><label>Regular Price</label><input type="number" name="price[]" class="form-control"> </div></div><div class="col-md-4"><div class="form-group actions"><button type="button" class="btn btn-danger waves-effect waves-light"><a href="#" class="remove_item"><i class="fa fa-close"></i>Remove</a></div></div></div></div></div>'); //add input box
    }
});

$(wrapper1).on("click", ".remove_item", function (e) { //user click on remove text
    e.preventDefault();
    $(this).parents('div.abc').remove();
    x--;
})
});
$('.collapse').on('shown.bs.collapse', function () {
$(this).parent().find(".ion-plus-circled").removeClass("ion-plus-circled").addClass("ion-minus-circled");
}).on('hidden.bs.collapse', function () {
$(this).parent().find(".ion-minus-circled").removeClass("ion-minus-circled").addClass("ion-plus-circled");
});

$('#datatable').DataTable({
"order": [],
"columnDefs": [{
        "targets": 'no-sort',
        "orderable": false,
    }]
});
</script>
<script>
    $(document).ready(function () {
        var group = 0;
       var group_item=0;
        $(".add_extra_btn").click(function (e) {
            group++;
            //console.log(group);
            //on add input button click
            e.preventDefault();
                $(".extra_items").append('<div class="abc"><div class="row"><div class="col-md-3"><div class="form-group"><label>Item Group Name</label><input type="text" name="group_name['+group+'][name]"  class="form-control"><input type="hidden" name="group_name['+group+'][itemId]" value=""> </div></div><div class="col-md-3"><div class="form-group"><label>Max items select</label><input type="number" min="1" value="1" name="group_name['+group+'][limit]"  class="form-control"></div></div><div class="col-md-3"><div class="form-group actions"><button type="button" class="btn btn-danger waves-effect waves-light"><a href="#" class="remove_extra_field"><i class="fa fa-close"></i>Remove</a></button>  <button type="button" class="btn btn-success add_extra_field"><a href="#" class=""><i class="fa fa-plus"></i>Add Extra item</a></button></div></div></div></div></div>'); //add input box
            //group++;
        });
       
        $(".extra_items").on("click",".remove_extra_field", function(e){ //user click on remove text
		e.preventDefault();
                $(this).parents('div.abc').remove(); group--;
	});
        
        //add grouped item
        
         $(".extra_items").on("click",".add_extra_field", function(e){
			 group_item++;
            // alert('hii');
            //console.log(group);
            //on add input button click
            e.preventDefault();
            var threshold  =  $(this).parents('.abc').find('input').attr("name");
            var parent_array= threshold.substr(0, threshold.indexOf('[name]')); 
           // console.log(threshold);
          //  console.log(parent_array);
            $(this).parents('.abc').append('<div class="grouped_items"><div class="row"><div class="col-md-3"><div class="form-group"><label>Item Name</label><input type="text" name="'+parent_array+'['+group_item+'][item_name]"  class="form-control"></div></div><div class="col-md-3"><div class="form-group"><label>Item Price</label><input type="number" name="'+parent_array+'['+group_item+'][item_price]" min="0" value="0" class="form-control"> </div></div><div class="col-md-3"><div class="form-group actions"><button type="button" class="btn btn-danger waves-effect waves-light"><a href="#" class="remove_extra_item"><i class="fa fa-close"></i>Remove</a></button> </div></div></div></div></div></div>'); //add input box
			// group_item++;
            
        });
        // delete grouped item
         $(".extra_items").on("click",".remove_extra_item", function(e){ //user click on remove text
		e.preventDefault();
                $(this).parents('div.abc .grouped_items').remove();group_item--;
	});
    });
</script>

<script>

    var count_cases = -1;
    setInterval(function () {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>seller/order/get_rejected_orders",
            success: function (response) {
                $("#noti").html("");
                var count = 0;
                //console.log(response.total);

                if (response.new_order != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?status=0' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='mdi mdi-cart-outline'></i></div><p class='notify-details'> New Order has Been Recieved<span class='text-muted'>You have " + response.new_order + " new orders</span></p></a>");
                    count++;
                }
                if (response.accept != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?driver_status=1' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='mdi mdi-cart-outline'></i></div><p class='notify-details'> Order has been accepted<span class='text-muted'>You have " + response.accept + " accepted orders</span></p></a>");
                    count++;
                }
                if (response.ready != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?status=4' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='mdi mdi-cart-outline'></i></div><p class='notify-details'> Order is Ready to pick up <span class='text-muted'>You have " + response.ready + " ready orders</span></p></a>");
                    count++;
                }
                if (response.picked != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?status=7' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='fa fa-truck' aria-hidden='true'></i></div><p class='notify-details'> Order has been Picked Up<span class='text-muted'>You have " + response.picked + " Picked Up orders</span></p></a>");
                    count++;
                }
                if (response.cancelled != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?status=3' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='fa fa-times' aria-hidden='true'></i></div><p class='notify-details'> Order has been cancelled<span class='text-muted'>You have " + response.cancelled + " cancelled orders</span></p></a>");
                    count++;
                }
                if (response.reject != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?driver_status=2' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='fa fa-ban' aria-hidden='true'></i></div><p class='notify-details'> Order has been rejected<span class='text-muted'>You have " + response.reject + " rejected orders</span></p></a>");
                    count++;
                }
                if (response.delivered != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?driver_status=4' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='fa fa-ban' aria-hidden='true'></i></div><p class='notify-details'> Order has been Delivered<span class='text-muted'>You have " + response.delivered + " Delivered orders</span></p></a>");
                    count++;
                }
                if (response.assign_boy != 0)
                {
                    $("#noti").append("<a href='<?php echo base_url(); ?>seller/order?status=5&assign_boy=1' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='fa fa-user' aria-hidden='true'></i></div><p class='notify-details'> Delivery Boy assigned to your order<span class='text-muted'>You have " + response.assign_boy + " Assigned orders with driver</span></p></a>");
                    count++;
                }
                //  alert(count);
                $("#count").html(count);
                // $("#count").html(response);
                //  $("#noti").html("<a href='javascript:void(0);' class='dropdown-item notify-item'><div class='notify-icon bg-primary'><i class='mdi mdi-cart-outline'></i></div><p class='notify-details'> order has been rejected<span class='text-muted'>You have "+response+" rejected orders</span></p></a>");
            }
        });
    }, 2000);

</script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment-with-locales.min.js"></script>
<script src="https://www.jqueryscript.net/demo/Bootstrap-4-Date-Time-Picker/build/js/tempusdominus-bootstrap-4.js"></script>
<script type="text/javascript">
  $(function () {
      $('#datetimepicker1,#datetimepicker2,#datetimepicker3,#datetimepicker4,#datetimepicker5,#datetimepicker6,#datetimepicker7,#datetimepicker_ch1,#datetimepicker_ch2,#datetimepicker_ch3,#datetimepicker_ch4,#datetimepicker_ch5,#datetimepicker_ch6,#datetimepicker_ch7').datetimepicker({
          format: 'LT'
      });
  });
</script>
<script src="<?php echo base_url() ?>assets/plugins/file_uploader/jquery.fileuploader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>assets/plugins/file_uploader/custom.js" type="text/javascript"></script>

</body>
<!-- Mirrored from themesdesign.in/drixo/horizontal/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 12 Nov 2018 09:34:33 GMT -->

</html>
