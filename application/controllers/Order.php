<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require(APPPATH."helpers\phpToPDF.php");
class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Pdf');
        $this->load->model('Order_model', 'om');
          $this->load->library('form_validation');
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        // Your own constructor code
    }

    public function index() {
        $data['result'] = $this->om->getAllOrders();
        // echo "<pre>";print_r($data);die;
        $this->load->view('common/header');
        $this->load->view('order_listing', $data);
        $this->load->view('common/footer');
    }

    public function view_order($orderId) {
        if ($orderId) {
            $data['result'] = $this->om->getOrderById($orderId);
            $data['delivery_boy'] = $this->om->getAllDeliveryBoys($orderId);
            $this->load->view('common/header');
            $this->load->view('view_order', $data);
            $this->load->view('common/footer');
        } else {
            redirect("order/");
        }
    }

    public function updateOrderStatus() {
        $orderId = $_POST['orders_id'];
        $order_status = $_POST['order_status'];
        if($order_status=='refund')
        {
           $cancelled_order=$this->db->query("select * from orders where orderId='$orderId' and (status='3' or status='6') and payment_method='online'")->row();
           if($cancelled_order)
           {
                $this->db->query("update orders set payment_status='2' where orderId='$orderId'");
                $status = "Refund";
           }
           else{
             //  echo json_decode("Order Should be canceled first");
               exit("Order Should be canceled or rejected first and payment method should be online");
           }
        }
        else{
        $this->db->query("update orders set status='$order_status' where orderId='$orderId'");
        }

        $res = $this->db->query("select users.fcm_id,store.name from orders join store on store.storeId=orders.storeId join users on users.userId=orders.userId where orders.orderId='$orderId'")->row();

        $fcm_id = $res->fcm_id;
        $store_name = $res->name;

        // print_r($fcm_id);die;
        if ($order_status == '1') {
            $status = "Completed";
        }
        if ($order_status == '0') {
            $status = "Pending";
        }
        if ($order_status == '2') {
            $status = "Processing";
        }
        if ($order_status == '3') {
            $status = "Cancelled";
        }
        if ($order_status == '4') {
            $status = "Ready";
        }
        if ($order_status == '5') {
            $status = "Accepted";
        }
        if ($order_status == '6') {
            $status = "Rejected";
        }
        if ($order_status == '7') {
            $status = "Picked Up";
        }
        $message = array("message" => " $store_name has $status your order. ", "title" => "Order Status", "Order Id" => $orderId, "type" => "1");
        //  print_r($message);die;
        $res = Globals::send_fcm_notification($fcm_id, $message);

        echo "status updated successfully";
    }

    public function delete() {
        $id = $_POST['id'];
        $this->db->where("orderId", $id);
        $this->db->delete("orders");
        $this->db->where("orderId", $id);
        $this->db->delete("order_items");
        $this->db->where("orderId", $id);
        $this->db->delete("order_items_extra");
        echo json_encode("success");
    }

    public function assign_delivery_boy() {
        $orderId = $_POST['orders_id'];
        $boyid = $_POST['boyid'];
        $data = $this->db->query("select * from orders where orderId='$orderId'")->row();
       if( $data->driver_status=='1'|| $data->driver_status=='3'||$data->driver_status=='4')
        {
              echo json_encode('This Order already accepted by delivery boy');
        }
        else {
            $this->db->query("update orders set deliveryBoyId='$boyid' where orderId='$orderId'");
           $db= $this->db->query("select * from deliveryboy where boyId=$boyid")->row();
           $fcm_id=$db->fcm_id;
             $message = array("message" => " New Order Assigned To You. ", "title" => "Order Assign", "Order Id" => $orderId, "type" => "1");
        //  print_r($message);die;
        $res = Globals::send_fcm_notification($fcm_id, $message);
            echo json_encode("Delivery Boy Assigned successfully");
        }
    }

    public function invoice($orderId) {
        // Include active language
        $data = $this->om->getOrderById($orderId);
        // echo'<pre>'; print_r($data);die;

        ob_start();
        ?>

        <!--        <page backcolor="" backleft="10mm" backright="10mm"  backtop="10mm" backbottom="10mm">-->
        <table align="center" style="margin:auto;max-width:600px;margin:0px auto 10px;background-color:#fff;padding:5px;
               -webkit-border-radius:3px;
               -moz-border-radius:3px;
               border-radius:3px; border-top: solid 100px #ff5622;">
            <thead>
                <tr>
                    <th style="text-align:left;"><img style="width: 70px;"
                                                      src="<?= base_url(); ?>assets/images/logo.png" alt="Delivera ">
                    </th>

                    <th style="text-align:right;font-weight:bold;"><?= date('d F Y', strtotime($data->createdOn)) ?></th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2" style="border: solid 4px #ddd;text-align:left">
                        <p style="margin:0 0 0px 0;"><span
                                style="font-weight:bold;display:inline-block;min-width:146px">Invoice No. :
                            </span><?= $data->orderId ?></p>
                        <p style="margin:0 0 6px 0;"><span
                                style="font-weight:bold;display:inline-block;min-width:250px;float:left;">Order Status : </span><b style="color:green;margin:-105px">Success</b>
                        </p>

                        <p style="margin:0 0 0 0;"><span
                                style="font-weight:bold;display:inline-block;min-width:146px">Order Amount: </span> 
        <?= Globals::getCurrency().$data->totalPrice ?></p>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td style="width:50%;padding:20px;vertical-align:top;text-align:left">
                        <p style="margin:0 0 10px 0;padding:0;"><span style=";display:block;font-weight:bold;">Name:</span>
        <?= $data->user_name ?></p>
                        <p style="margin:0 0 10px 0;padding:0;"><span
                                style="display:block;font-weight:bold;">Email : </span> <?= $data->user_email ?></p>
                        <p style="margin:0 0 10px 0;padding:0;"><span
                                style="display:block;font-weight:bold;">Phone : </span> <?= $data->phone ?></p>
                        <p style="margin:0 0 10px 0;padding:0; ">
                            <span style="display:block;font-weight:bold; ">Address : </span> <?= $data->address ?>   </p>

                    </td>
                    <td style="width:50%;padding:20px;vertical-align:top;text-align:left">
                        <p style="margin:0 0 10px 0;padding:0;"><span style="display:block;font-weight:bold;">Date &
                                Time: </span><?= $data->createdOn ?> </p>
                        <p style="margin:0 0 10px 0;padding:0;"><span
                                style="display:block;font-weight:bold;">Orders : </span> <?= $data->totalCount ?>
                            Items - <?= Globals::getCurrency(). $data->totalPrice ?></p>
                        <p style="margin:0 0 10px 0;padding:0;"><span style="display:block;font-weight:bold;">Delivery Cost</span>
                             <?= Globals::getCurrency().$data->delivery_fee ?></p>
                        <p style="margin:0 0 10px 0;padding:0;"><span
                                style="display:block;font-weight:bold;">Payment Method: </span> <?= $data->payment_method; ?></p>
                    </td>
                </tr>

            </tbody>
        </table>
        <p style="margin:0 0 10px 0;padding:0;font-size:14px;"><span style="display:block;font-weight:bold;">Orders</span></p>

        <table cellpadding="5" class="table" style="margin-bottom: 10px;width: 100%;margin-bottom: 1rem;border-collapse: collapse;">
            <thead>
                <tr>
                    <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><strong>Item</strong></td>
                    <td class="text-center" style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><strong>Price</strong></td>
                    <td class="text-center" style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><strong>Quantity</strong></td>
                  
                    <td class="text-right" style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><strong>Totals</strong></td>
                </tr>
            </thead>
            <tbody>
        <?php
        $order_items = $this->db->query("select items.itemId,order_items.price,order_items.offerPrice,items.name as item_name,order_items.notes as notes,order_items.quantity,order_items.tax,order_items.variation from order_items join items on items.itemId=order_items.itemId where order_items.orderId=$orderId")->result();
        $totaltax=0;
        $subTotal=0;
        foreach ($order_items as $row) {
            $total = 0;
            $total+=(($row->offerPrice) * ($row->quantity));
            $totaltax+=(($row->tax) * ($row->quantity));
            $subTotal+=(($row->offerPrice) * ($row->quantity));
            ?>
                    <tr>
                        <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><?= $row->item_name ?></td>
                        <td class="text-center" style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><?= Globals::getCurrency().$row->offerPrice ?></td>
                        <td class="text-center" style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><?= $row->quantity ?></td>
                       
                        <td class="text-right" style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center;"><?= Globals::getCurrency().$total ?></td>
                    </tr>
                    <?php
                    $item_id = $row->itemId;
                    $extra_items = $this->db->query("select *,order_items_extra.tax as extra_tax from order_items_extra join moreitems on moreitems.mItemId=order_items_extra.mItemId where order_items_extra.orderId='$orderId' and order_items_extra.itemId='$item_id'")->result();
                    if (!empty($extra_items)) {
                        ?>
                        <tr>
                            <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><b>Extra Items</b></td>
                            <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"></td>
                            <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"></td>
                            <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"></td>
                            <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"></td> </tr>
                        <?php
                        foreach ($extra_items as $extra) {
                            $total1 = (($extra->price) * ($row->quantity)) ;
                            $totaltax+=(($extra->extra_tax) * ($row->quantity));
                            $subTotal+=(($extra->price) * ($row->quantity));
                            ?>

                            <tr>
                                <td style="text-align:right"><?= $extra->name ?></td>
                                <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><?= Globals::getCurrency().$extra->price ?></td>
                                <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center">-</td>
                               
                                <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><?= Globals::getCurrency().$total1 ?></td>
                            </tr>

                        <?php }
                    }
                } ?>

                <tr>
                    <td class="thick-line" style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"></td>
                    <td class="thick-line" style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"></td>
                   
                    <td class="thick-line text-center" style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"><strong>Subtotal</strong></td>
                    <td class="thick-line text-right"  style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"><?= Globals::getCurrency().$subTotal; ?></td>
                </tr>
                  <?php if($data->promo_code):
                    ?>
                 <?php
                 $promo_value=0;
                 if($data->promo_code){
                     if($data->promo_code_type=='1'){
                       $promo_value+=   $subTotal*($data->promo_code_value/100);
                           $subTotal-=$promo_value;
                     }
                    else {
                      $promo_value+=$data->promo_code_value;
                         $subTotal-=$promo_value;
                    }
                 }
                    ?>
                 <tr>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    
                    <td class="no-line text-center" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center"><strong>Promo Code</strong></td>
                    <td class="no-line text-right" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center"><?= $data->promo_code; ?></td>
                     
                   
                </tr>
                <tr>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    <td class="no-line text-center" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center"><strong>Promo Code Value</strong></td>
                    <td class="no-line text-right" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center">- <?= Globals::getCurrency().$promo_value;?></td>
                     
                   
                </tr>
                <?php endif;?>
                 <tr>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    
                    <td class="no-line text-center" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center"><strong>Tax</strong></td>
                    <td class="no-line text-right" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center">+ <?= Globals::getCurrency().$totaltax; ?></td>
                   
                </tr>
                <tr>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    <td class="no-line text-center" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center"><strong>Shipping</strong></td>
                    <td class="no-line text-right" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center">+ <?= Globals::getCurrency().$data->delivery_fee;?></td>
                </tr>
                <tr>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    <td class="no-line" style="padding: 15px 12px;vertical-align: middle;border-top: none;"></td>
                    
                    <td class="no-line text-center" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center"><strong>Total</strong></td>
                    <td class="no-line text-right" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center;font-weight: bold"><?= Globals::getCurrency().($subTotal+$totaltax+($data->delivery_fee)) ?></td>
                </tr>

            </tbody>
        </table>
        <!--        </page>
                <page_footer>-->
        <table width='750px;'>
            <tr>
                <td style="width:33%;padding:20px;vertical-align:top;">
                    <p style="margin:0 0 7px 0;padding:0;"><span style="display:block;font-weight:bold;font-size:13px;text-align:left;">Company Name :</span></p>
                    <p style="margin:0 0 7px 0;padding:0;"><span
                            style="display:block;"><?= WEBNAME ?> </span></p>

                </td>
                <td></td>
                <td style="width:33%;padding:15px;vertical-align:top;">
                    <p style="margin:0 0 0px 0;padding:0;"><span style="display:block;font-weight:bold;font-size:13px;text-align:left;">Store Information :</span></p>
                    <p style="margin:0 0 0px 0;padding:0;"><span
                            style="display:block;font-weight:bold;">Name: </span>
                        <span><?= $data->store_name ?></span>      
                    </p>
                    <p style="margin:0 0 0px 0;padding:0;"><span
                            style="display:block;font-weight:bold;">Address: </span>
                        <span><?= $data->store_address ?></span>      
                    </p>

                    <p style="margin:0 0 0px 0;padding:0;"><span
                            style="display:block;font-weight:bold;">Phone: </span>
                        <span><?= $data->contactNumber ?></span>
                    </p>


                </td>

            </tr>
        </table>


        <!--        </page_footer>                  -->
        <?php
        $content = ob_get_clean();

        $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $obj_pdf->SetCreator(PDF_CREATOR);
//$title = "PDF Report";
//$obj_pdf->SetTitle($title);
//$obj_pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $title, PDF_HEADER_STRING);
//$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
//$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//$obj_pdf->SetDefaultMonospacedFont('helvetica');
        $obj_pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '20', PDF_MARGIN_RIGHT);
        $obj_pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $obj_pdf->SetFont('helvetica', '', 10);
//$obj_pdf->setFontSubsetting(false);
        $obj_pdf->AddPage();
        $obj_pdf->writeHTML($content);
        $obj_pdf->Output($orderId . '-invoice.pdf', 'D');
    }

    public function create_report() {
        
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="orders.csv"');

// do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');

// create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

// send the column headers
        fputcsv($file, array('Order Id', 'User', 'Store Name','Total Count',  'Total Price','Promo Code','status','Payment status','Payment Method', 'Created On'));
        $sql=$_SESSION['export_query'];
        $data=  $this->db->query($sql)->result_array();
        //print_r($data);die;
//        $data = $this->db->query("select orders.orderId,store.name as store_name,orders.totalCount,users.fullName as user_name,CASE WHEN orders.status = 0 THEN 'Pending'
//WHEN orders.status = 1 THEN 'Complete'
//WHEN orders.status = 2 THEN 'Processing'
//WHEN orders.status = 3 THEN 'Cancelled'
//WHEN orders.status = 4 THEN 'Ready'
//WHEN orders.status = 5 THEN 'Accept'
//WHEN orders.status = 6 THEN 'Reject'
//WHEN orders.status = 7 THEN 'Pickup'
//ELSE ''
//END AS status,orders.totalPrice,orders.delivery_fee,orders.promo_code,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId order by orders.orderId desc")->result_array();
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
    }

    public function create_earnings_report() {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="earnings.csv"');

        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');

        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        // send the column headers
        fputcsv($file, array('Order Id', 'Total Amount', 'Delivery Charges','Commission Type', 'Commission Rate','Admin Commission','Seller Earning', 'Your Earning'));
 $sql=$_SESSION['export_query'];
        $data = $this->db->query($sql)->result_array();
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
    }
    public function create_payment_report()
    {
        header('Content-type: text/csv');
        header('Content-Disposition: attachment; filename="payment.csv"');

        // do not cache the file
        header('Pragma: no-cache');
        header('Expires: 0');

        // create a file pointer connected to the output stream
        $file = fopen('php://output', 'w');

        // send the column headers
        fputcsv($file, array('Order Id', 'Total Amount', 'Payment', 'Store name', 'Payment Status'));

        $data = $this->db->query("select orders.orderId,orders.totalPrice,orders.store_earning,store.name,CASE
    WHEN admin_payment_status = 0 THEN 'Pending'
    ELSE 'Completed' 
    END AS admin_payment_status from orders left join store on orders.storeId=store.storeId order by orderId desc")->result_array();
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
    }
    public function payments() {
        $data['stats']    = $this->om->get_payments_stats();
        $data['payments'] = $this->om->get_payments();
        $this->load->view("common/header");
        $this->load->view("payment", $data);
        $this->load->view("common/footer");
    }
    public function driver_payments() {
        $data['stats']    = $this->om->get_driver_payments_stats();
        $data['payments'] = $this->om->get_driver_payments();
        $this->load->view("common/header");
        $this->load->view("driver_payments", $data);
        $this->load->view("common/footer");
    }

    public function earnings() {
        $data['stats'] = $this->om->get_earning_stats();
        $data['earnings'] = $this->om->get_earnings();
        $this->load->view("common/header");
        $this->load->view("earnings", $data);
        $this->load->view("common/footer");
    }
public function edit_payment_status($id)
{
        $data['payment'] = $this->om->get_payment_by_id($id);
        //echo"<pre>";print_r($data);die;
        $this->load->view("common/header");
        $this->load->view("edit_payment_status", $data);
        $this->load->view("common/footer");
}
public function edit_driver_payment_status($id)
{
        $data['payment'] = $this->om->get_driver_payment_by_id($id);
        //echo"<pre>";print_r($data);die;
        $this->load->view("common/header");
        $this->load->view("edit_driver_payment_status", $data);
        $this->load->view("common/footer");
}
    public function update_payment_status($id) {
        
      //  print_r($_POST);die;
        $orderId = $id;
        $status = $_POST['status'];
       
       // print_r($_POST);die;
        $this->db->query("update orders set admin_payment_status=$status where orderId=$orderId");
        $this->session->set_flashdata('success', ' Payment status updated Successfully');
        redirect('order/edit_payment_status/'.$id);
        //echo json_encode("success");
        //print_r($_POST);
    }
    public function update_driver_payment_status($id)
    {
         $orderId = $id;
        $status = $_POST['status'];
       
       // print_r($_POST);die;
        $this->db->query("update orders set driver_payment_status=$status where orderId=$orderId");
        $this->session->set_flashdata('success', ' Driver Payment status updated Successfully');
        redirect('order/edit_driver_payment_status/'.$id);
    }
    public function get_rejected_orders()
    {
        $query1=  $this->db->query("select orders.orderId,orders.driver_status,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=2");
        $reject=$query1->num_rows();
       // print_r($reject);die;
        $query2=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=1");
        $accept=$query2->num_rows();
      // print_r($accept);die;
        $query3=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=3");
        $picked=$query3->num_rows();
       
        $query4=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=4");
        $delivered=$query4->num_rows();
          //print_r($delivered);die;
        $query5=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=0");
        $new_orders=$query5->num_rows();
       // print_r($new_orders);die;
        $query6=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=1");
        $completed=$query6->num_rows();
        //print_r($completed);die;
        $query7=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=3");
        $cancelled=$query7->num_rows();
        //print_r($cancelled);die;
        $query8=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=4");
        $ready=$query8->num_rows();
        //print_r($ready);die;
        $total=$reject+$accept+$picked+$delivered+$new_orders+$cancelled+$ready;
        echo json_encode(array('reject'=>$reject,'accept'=>$accept,'picked'=>$picked,'delivered'=>$delivered,'new_order'=>$new_orders,'completed'=>$completed,'cancelled'=>$cancelled,'ready'=>$ready,'total'=>$total));
    }
     public function reviews() {
        $data['result']=$this->om->get_reviews();
        $this->load->view("common/header");
        $this->load->view("all_reviews", $data);
        $this->load->view("common/footer");
    }
    public function order_reviews($oid)
    {
        $data['result']=$this->om->get_order_reviews($oid);
        // echo "<pre>";print_r($data);echo "</pre>";die();
        $this->load->view('common/header');
        $this->load->view('order_reviews',$data);
        $this->load->view('common/footer');
        
    }
    public function edit_review($id)
    {
        $data['result']=$this->om->getReviewByID($id);
     //  echo"<pre>"; print_r($data);die;
      
       //echo"<pre>"; print_r($data);die;
        $this->load->view('common/header');
        $this->load->view('edit_review',$data);
        $this->load->view('common/footer');
        
    }
    public function edit_review_process($id)
    {
        //  $this->form_validation->set_rules('name', 'Item Name', 'required');
      $this->form_validation->set_rules('rating', 'Rating', 'required|numeric');
      $this->form_validation->set_rules('review', 'Review', 'required');
     
    if ($this->form_validation->run() == FALSE) {
       
        $this->session->set_flashdata('error', validation_errors());
       redirect('order/edit_review/'.$id);
        // $this->load->view('myform');
    } else {
        $rating=$_POST['rating'];
        $review=$_POST['review'];
        $this->om->edit_review($id);
        $this->session->set_flashdata("success",'Review Update Successfully!!!');
        redirect('order/edit_review/'.$id);
    }
          
    }
    


}
