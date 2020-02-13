<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('seller/Order_model', 'om');
        $this->load->library('form_validation');
        $this->load->library('Pdf');
        $this->session->keep_flashdata('error');
        if (!isset($_SESSION['selleremail'])) {

            redirect('seller/home/');
        }
        // Your own constructor code
    }

    public function index() {
        // print_r($_SESSION);die;
        $sellerId = $_SESSION['sellerid'];
        $data['result'] = $this->om->getOrders($sellerId);
        //echo "<pre>";print_r($data);die;
        $this->load->view('seller/header');
        $this->load->view('seller/order_listing', $data);
        $this->load->view('seller/footer');
    }

    public function view_order($orderId) {
        $sellerId = $_SESSION['sellerid'];
        if ($orderId) {
            $data['result'] = $this->om->getOrderById($orderId, $sellerId);
            // print_r($data);die;
            $this->load->view('seller/header');
            $this->load->view('seller/view_order', $data);
            $this->load->view('seller/footer');
        } else {
            redirect("seller/order/");
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
        $message = array("message" => " $store_name has $status your order. ", "title" => "Order Status","type" => "1");
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

    public function invoice($orderId) {
        $sellerId = $_SESSION['sellerid'];
        // Include active language
        $data = $this->om->getOrderById($orderId, $sellerId);
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
                            Items - <?= Globals::getCurrency().$data->totalPrice ?></p>
                        <p style="margin:0 0 10px 0;padding:0;">
                            <span style="display:block;font-weight:bold;">Delivery Cost:</span>
                             <?= Globals::getCurrency().$data->delivery_fee ?></p>
                        <p style="margin:0 0 10px 0;padding:0;"><span style="display:block;font-weight:bold;">Payment Method:</span>
                             <?= $data->payment_method ?></p>
                       
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
                $order_items = $this->db->query("select items.itemId,order_items.price,order_items.offerPrice,items.name as item_name,order_items.notes as notes,order_items.quantity,order_items.tax,order_items.variation from order_items join items on items.itemId=order_items.itemId where order_items.orderId=$orderId")->result();$gd=0;
                 $totaltax=0;
        $subTotal=0;
                foreach ($order_items as $row) {
                    $total = 0;
                    $total+=(($row->offerPrice) * ($row->quantity));
                    $gd+=$total;
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
                            $total1 = (($extra->price) * ($row->quantity));
                             $totaltax+=(($extra->extra_tax) * ($row->quantity));
                            $subTotal+=(($extra->price) * ($row->quantity));
                            $gd+=$total1;
                            ?>

                            <tr>
                                <td style="text-align:right"><?= $extra->name ?></td>
                                <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><?= Globals::getCurrency().$extra->price ?></td>
                                <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center">-</td>
                               
                                <td style="padding: 15px 12px;vertical-align: middle;border-top: 1px solid #dee2e6;text-align: center"><?= Globals::getCurrency().$total1 ?></td>
                            </tr>

                        <?php
                        }
                    }
                }
                ?>
                

                <tr>
                    <td class="thick-line" style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"></td>
                    <td class="thick-line" style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"></td>
                  
                    <td class="thick-line text-center" style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"><strong>Subtotal</strong></td>
                    <td class="thick-line text-right"  style="padding: 15px 12px;vertical-align: middle;border-top: 2px solid #dee2e6;text-align: center"><?= Globals::getCurrency().$subTotal;?></td>
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
                    <td class="no-line text-right" style="padding: 15px 12px;vertical-align: middle;border-top: none;text-align: center">+ <?= Globals::getCurrency().$data->delivery_fee; ?></td>
                   
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

    public function promo_code() {
        $sellerId = $_SESSION['sellerid'];
        $data['promo'] = $this->om->get_promo($sellerId);

        $this->load->view("seller/header");
        $this->load->view("seller/promo_listing", $data);
        $this->load->view("seller/footer");
    }

    public function add_promo() {
        $this->load->view("seller/header");
        $this->load->view("seller/add_promo");
        $this->load->view("seller/footer");
    }

    public function add_promo_process() {
        $this->form_validation->set_rules('type', 'Promo Code Type', 'required');
        $this->form_validation->set_rules('min_order_ammount', 'Minimum Order', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('code_amount', 'Promo Code Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('code', 'Promo Code', 'required');
        $this->form_validation->set_rules('total_used', 'Total Used', 'required');
         $this->form_validation->set_rules('user_used', 'Per User Used', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            redirect('seller/order/add_promo','refresh');
            // $this->load->view('myform');
        } else {
            $minimum_amount = $_POST['min_order_ammount'];
            $code_amount = $_POST['code_amount'];
            $type = $_POST['type'];
            if ($type == '1') {
                
               $percentage_value=($minimum_amount)*($code_amount/100);
               //print_r($percentage_value);
               if($minimum_amount < $percentage_value)
               {
                  // echo 'hii';die;
                    $this->session->set_flashdata('error1', 'Percentage Code Amount should be less than minimum amount');
                    //print_r($this->session->userdata('error1'));die;
                    redirect('seller/order/add_promo','refresh');
               }
               
            }
            if ($type == '2') {
                if ($minimum_amount < $code_amount) {
                    $this->session->set_flashdata('error', 'Promo Code Amount should be less than minimum amount');
                    redirect('seller/order/add_promo','refresh');
                }
            }
            $user_used=$_POST['user_used'];
            $total_used=$_POST['total_used'];
            if($total_used<$user_used)
            {
                  $this->session->set_flashdata('error', 'Total Used should be Greater  than User used');
                     redirect('seller/order/add_promo');
            }
            $data = $this->om->add_promo();
            $this->session->set_flashdata('success', 'Promo Code Added successfully');
            redirect('seller/order/add_promo');
        }
    }

    public function edit_promo($id) {

        $data['promo'] = $this->om->get_codeById($id);
        //  print_r($data);die;
        $this->load->view("seller/header");
        $this->load->view("seller/edit_promo", $data);
        $this->load->view("seller/footer");
    }

    public function edit_promo_process($id) {
         $this->form_validation->set_rules('type', 'Promo Code Type', 'required');
        $this->form_validation->set_rules('min_order_ammount', 'Minimum Order', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('code_amount', 'Promo Code Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('code', 'Promo Code', 'required');
        $this->form_validation->set_rules('total_used', 'Total Used', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
        $this->form_validation->set_rules('user_used', 'Per User Used', 'required|numeric|greater_than[0]');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            redirect('seller/order/edit_promo/' . $id);
            // $this->load->view('myform');
        } else {
            $minimum_amount = $_POST['min_order_ammount'];
            $code_amount = $_POST['code_amount'];
            $type = $_POST['type'];
            if ($type == '1') {
                
               $percentage_value=($minimum_amount)*($code_amount/100);
               //print_r($percentage_value);
               if($minimum_amount < $percentage_value)
               {
                  // echo 'hii';die;
                    $this->session->set_flashdata('error', 'Percentage Code Amount should be less than minimum amount');
                    //print_r($this->session->userdata('error1'));die;
                    redirect('seller/order/edit_promo/' . $id,'refresh');
               }
               
            }
            if ($type == '2') {
                if ($minimum_amount < $code_amount) {
                    $this->session->set_flashdata('error', 'Promo Code Amount should be less than minimum amount');
                   redirect('seller/order/edit_promo/' . $id,'refresh');
                }
            }
            $user_used=$_POST['user_used'];
            $total_used=$_POST['total_used'];
            if($total_used<$user_used)
            {
                  $this->session->set_flashdata('error', 'Total Used should be Greater  than User used');
                   redirect('seller/order/edit_promo/' . $id);
            }
            $data = $this->om->edit_promo($id);
            $this->session->set_flashdata('success', 'Promo Code Edit successfully');
            redirect('seller/order/edit_promo/' . $id);
        }
    }

    public function delete_promo() {
        $id = $_POST['id'];
        $this->db->where('codeId', $id);
        $this->db->delete('promo_code');
        echo json_encode("success");
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
        fputcsv($file, array('Order Id', 'User', 'status', 'Total Price', 'Created On'));
        $sellerId = $_SESSION['sellerid'];
        $data = $this->db->query("select orders.orderId,users.fullName as user_name,CASE WHEN orders.status = 0 THEN 'Pending'
WHEN orders.status = 1 THEN 'Complete'
WHEN orders.status = 2 THEN 'Processing'
WHEN orders.status = 3 THEN 'Cancelled'
WHEN orders.status = 4 THEN 'Ready'
WHEN orders.status = 5 THEN 'Accept'
WHEN orders.status = 6 THEN 'Reject'
WHEN orders.status = 7 THEN 'Pickup'
ELSE ''
END AS status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where store.storeId='$sellerId'")->result_array();
        /* CASE WHEN Quantity > 30 THEN "The quantity is greater than 30"
          WHEN Quantity = 30 THEN "The quantity is 30"
          ELSE "The quantity is under 30"
          END AS QuantityText */
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
    }

    public function earnings() {
        $sellerId = $_SESSION['sellerid'];
        $data['earnings'] = $this->om->get_seller_earning($sellerId);
        $data['stats'] = $this->om->get_earning_stats($sellerId);
        $this->load->view("seller/header");
        $this->load->view("seller/earnings", $data);
        $this->load->view("seller/footer");
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
        fputcsv($file, array('Order Id', 'Total Amount', 'Delivery Charges', 'Your Earning'));
        $sellerId = $_SESSION['sellerid'];
        $data = $this->db->query("select orderId,totalPrice,delivery_fee,store_earning from orders  where storeId=$sellerId order by orderId desc")->result_array();
        foreach ($data as $row) {
            fputcsv($file, $row);
        }
    }
   public function get_rejected_orders()
    {
        $sellerId = $_SESSION['sellerid'];
        $query1=  $this->db->query("select orders.orderId,orders.driver_status,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=2 and orders.storeId=$sellerId");
        $reject=$query1->num_rows();
       // print_r($reject);die;
        $query2=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=1 and orders.storeId=$sellerId");
        $accept=$query2->num_rows();
      // print_r($accept);die;
        $query3=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=3 and orders.storeId=$sellerId");
        $picked=$query3->num_rows();
       
        $query4=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.driver_status=4 and orders.storeId=$sellerId");
        $delivered=$query4->num_rows();
          //print_r($delivered);die;
        $query5=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=0 and orders.storeId=$sellerId");
        $new_orders=$query5->num_rows();
       // print_r($new_orders);die;
        $query6=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=1 and orders.storeId=$sellerId");
        $completed=$query6->num_rows();
        //print_r($completed);die;
        $query7=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=3 and orders.storeId=$sellerId");
        $cancelled=$query7->num_rows();
        //print_r($cancelled);die;
        $query8=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=4 and orders.storeId=$sellerId");
        $ready=$query8->num_rows();
        
         $query9=  $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.status=5 and deliveryBoyId!=0 and orders.storeId=$sellerId");
        $assign=$query9->num_rows();
        
        //print_r($ready);die;
        $total=$reject+$accept+$picked+$delivered+$new_orders+$cancelled+$ready;
        echo json_encode(array('reject'=>$reject,'accept'=>$accept,'picked'=>$picked,'delivered'=>$delivered,'new_order'=>$new_orders,'completed'=>$completed,'cancelled'=>$cancelled,'ready'=>$ready,'assign_boy'=>$assign,'total'=>$total));
    }

}
