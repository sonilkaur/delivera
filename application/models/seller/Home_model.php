<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

    public function authentication() {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $data = $this->db->query("select * from store where email='$email' and password='$password'")->result();
        // print_r($this->db->last_query());die;
        //print_r($data);die;
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function getSellerById($id) {
        //return  $this->db->query("select * from store where storeId='$id'")->result();

        $data = $this->db->query("select * from store where storeId='$id'")->result();
        //echo "<pre>";print_r($data);die;
        $data[0]->store_category=$this->db->query("select categoryId,name from category as c left join store_category_relation as scr on scr.storeCategoryId=c.categoryId where scr.storeId='$id' ")->result();
        $data[0]->businessHours = $this->db->query("select * from business_hrs where storeId='$id'")->result();
        // echo "<pre>"; print_r($data);die;
        return $data;
    }

    public function edit_settings($id) {
        //echo"<pre>";
        // print_r($_POST);die;
//      
        if (!empty($_POST['old_password'])) {
            $old_pass = md5($_POST['old_password']);
            $data = $this->db->query("select * from store where storeId='$id' and password='$old_pass'")->result();
            //print_r($data);die;
            if (!empty($data)) {
                if (!empty($_POST['new_password'])) {
                    $new_pass = md5($_POST['new_password']);
                    $this->db->query('update store set password="' . $new_pass . '" where storeId="' . $id . '"');
                } else {
                    $this->session->set_flashdata('error', 'Please Enter new password');
                    redirect('seller/home/settings');
                }
            } else {
                $this->session->set_flashdata('error', 'Old Password doesnot Correct');
                redirect('seller/home/settings');
            }
        }


        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $this->load->library('upload', $config);
        $image_name = '';

        if (!$this->upload->do_upload('image')) {
            $error['info'] = array('error' => $this->upload->display_errors());
        } else {
            $data['info'] = array('upload_data' => $this->upload->data());
            $image_name = "uploads/" . $data['info']['upload_data']['file_name'];
            $this->db->query("update store set logo='$image_name' where storeId='$id'");
            // $this->load->view('add_restaurant', $data);
        }
        $data = array('name' => $this->input->post('store_name'),
            'description' => $this->input->post('description'),
            'address' => $this->input->post('address'),
            'serviceTax' => $this->input->post('service_tax'),
            'latitude' => $this->input->post('latitude'),
            'longitude' => $this->input->post('longitude'),
            'contactNumber' => $this->input->post('contactNumber'),
            'contactNumberOthers' => $this->input->post('others'),
            'contactEmail' => $this->input->post('contactEmail'),
            'deliveryTime' => $this->input->post('deliveryTime'),
           
            'minimumOrder' => $this->input->post('minimumOrder')
        );
        //print_r($data);die;
        $this->db->where('storeId', $id);
        $this->db->update('store', $data);

        $businessHours = array(
            'Monday' => array('storeId' => $id,
                'status' => $this->input->post('d1_status'),
                'DoW' => 'Monday',
                'start_time' => ($_POST['d1_OH'])? date("H:i", strtotime($this->input->post('d1_OH'))):"",
                'end_time' => ($_POST['d1_CH'])? date("H:i", strtotime($this->input->post('d1_CH'))):""
            ),
            'Tuesday' => array('storeId' => $id,
                'status' => $this->input->post('d2_status'),
                'DoW' => 'Tuesday',
                'start_time' =>  ($_POST['d2_OH'])? date("H:i", strtotime($this->input->post('d2_OH'))):"",
                'end_time' =>   ($_POST['d2_CH'])? date("H:i", strtotime($this->input->post('d2_CH'))):""
            ),
            'Wednesday' => array('storeId' => $id,
                'status' => $this->input->post('d3_status'),
                'DoW' => 'Wednesday',
                'start_time' => ($_POST['d3_OH'])? date("H:i", strtotime($this->input->post('d3_OH'))):"",
                'end_time' => ($_POST['d3_CH'])?  date("H:i", strtotime($this->input->post('d3_CH'))):""
            ),
            'Thursday' => array('storeId' => $id,
                'status' => $this->input->post('d4_status'),
                'DoW' => 'Thursday',
                'start_time' =>($_POST['d4_OH'])?  date("H:i", strtotime ($this->input->post('d4_OH'))):"",
                'end_time' =>($_POST['d4_CH'])?  date("H:i", strtotime($this->input->post('d4_CH'))):""
            ),
            'Friday' => array('storeId' => $id,
                'status' => $this->input->post('d5_status'),
                'DoW' => 'Friday',
                'start_time' => ($_POST['d5_OH'])? date("H:i", strtotime($this->input->post('d5_OH'))):"",
                'end_time' => ($_POST['d5_CH'])? date("H:i", strtotime($this->input->post('d5_CH'))):""
            ),
            'Saturday' => array('storeId' => $id,
                'status' => $this->input->post('d6_status'),
                'DoW' => 'Saturday',
                'start_time' => ($_POST['d6_OH'])? date("H:i", strtotime ($this->input->post('d6_OH'))):"",
                'end_time' => ($_POST['d6_CH'])? date("H:i", strtotime ($this->input->post('d6_CH'))):""
            ),
            'Sunday' => array('storeId' => $id,
                'status' => $this->input->post('d7_status'),
                'DoW' => 'Sunday',
                'start_time' => ($_POST['d7_OH'])? date("H:i", strtotime($this->input->post('d7_OH'))):"",
                'end_time' =>($_POST['d7_CH'])? date("H:i", strtotime ($this->input->post('d7_CH'))):""
            )
        );
        $b_hrs_exist = $this->db->query("select * from business_hrs where storeId='$id'")->result();
        if (!empty($b_hrs_exist)) {
            //update
            foreach ($businessHours as $row) {
                $where = array('storeId' => $id, 'DoW' => $row['DoW']);
                $this->db->where($where);
                $this->db->update('business_hrs', $row);
            }
        } else {
            //insert
            foreach ($businessHours as $row) {
                $this->db->insert('business_hrs', $row);
            }
        }
        // echo"<pre>"; print_r(json_encode($businessHours));die;
    }
    public function get_users()
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->limit(6);
        $this->db->order_by('createdOn','desc');
        return $this->db->get()->result();
    }
  public function get_custome_orders($days,$sellerId)
    {
      //get categories assigned to store 
      
     $category= $this->db->query("select category.name,category.categoryId from category join  store_category_relation on category.categoryId=store_category_relation.storeCategoryId where store_category_relation.storeId=$sellerId")->result();
     $cat_name=[];
     foreach ($category as $key=>$cat)
     {
         $cat_name[]=$cat->name;
         
     }
     foreach ($days as $row){
           $data[$row]=[];
         foreach($category as $key=> $cat){
               $cat_id=$cat->categoryId;
               //print_r($cat_id);die;
               $result=$this->db->query(" select count(orders.orderId) as sale,$cat_id from orders join order_items on orders.orderId=order_items.orderId  join items on items.itemId=order_items.itemId  where items.categoryId=$cat_id and CAST(orders.createdOn AS DATE)='$row' and orders.storeId=$sellerId")->row();
               array_push($data[$row],$result);
         }
     }
//     foreach ($category as $key=> $cat)
//     {
//         $cat_id=$cat->categoryId;
//         $data[$key]=[];
//         foreach ($days as $row)
//         {
//             $data[$row]=$this->db->query(" select count(orders.orderId) as sale from orders join order_items on orders.orderId=order_items.orderId join items on items.itemId=order_items.itemId  where items.categoryId=$cat_id and CAST(orders.createdOn AS DATE)='$row' and orders.storeId=$sellerId")->row();
//         }
//         
//     }
     return array('cat'=>$cat_name,'data'=>$data);
    // return $cat_name;
//        foreach ($days as $row) {
//            $data[$row] = $this->db->query("select count(orders.orderId)as sales,category.name from orders join order_items on order_items.orderId=orders.orderId join items on order_items.itemId=items.itemId left join category on category.categoryId=items.categoryId where CAST(orders.createdOn AS DATE)='$row' and orders.storeId='$sellerId' GROUP BY category.categoryId")->result();
//            //print_r($data);
//            //return "select count(orderId),storeId from orders where CAST(createdOn AS DATE)='$row' GROUP BY storeId";      
//        }
      //  print_r($data);
       // die;
      // return $data;
    }
    public function send_otp_password()
    {
        $email=$_POST['email'];
       $data= $this->db->query("select * from store where email='$email'")->row();
       if($data)
       {
           $password= uniqid();
           $new_password=md5($password);
             $digits = 4;
                //echo 'hee';die;
                $activation_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                
                $this->db->query("update store set password='$new_password' where email='$email'");
                $email = $data->email;
               // $activation_code = $data->activation_code;
                $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                $headers .= "From: " . WEBNAME . "<" . ADMINEMAIL . ">\r\n";
                $headers .= "Reply-To:" . ADMINEMAIL . "\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $to = $email;
                $subject = WEBNAME . " Store - Forgot Password";
                ob_start();
                ?>
                <table style="border:1px solid #d7d7d7;" width="600" border="0" align="center" cellpadding="0" cellspacing="0">

                    <tr>
                        <td height="25" valign="top"
                            style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; padding-left:5px;">
                            <table width="600" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td>&nbsp;</td>
                                    <td valign="top">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="400">
                                        <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td height="25"
                                                    style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; padding-left:5px;">
                                                    Hi ,Please Do not Reply to this mail
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:12px; font-family:Arial, Helvetica, sans-serif; color:#000000; font-weight:bold;padding-left:5px;">
                                               You Have made request for reset password.So,Here is your New Password :
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table width="400" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>

                                                            <td width="556" valign="top"><h3><?php echo $password; ?></h3></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="font-size:12px; font-family:Arial, Helvetica, sans-serif; padding-left:5px; line-height:25px; color:#000000">
                                                    The <?= WEBNAME ?> Team
                                                </td>
                                            </tr>

                                        </table>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="25" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; color:#000000; padding-left:5px;">&nbsp;</td>
                    </tr>
                </table>


                <?php
                $body = ob_get_contents();
                // print_r($body);die;
                ob_end_clean();
                // print_r(mail($to, $subject, $body, $headers));die;

                if (mail($to, $subject, $body, $headers)) {
                   return $data;
                } else {
                   $this->session->set_flashdata('error', 'Something went wrong.Email not sent.');
                    redirect('seller/home/forgot_password');
                }
            } else {
                 $this->session->set_flashdata('error', 'Email is not associated with any account');
             redirect('seller/home/forgot_password');
               //return false;
            }
       }
    public function get_dashboard_stats($sellerId)
    {
        $new_orders=$this->db->query("select count(orderId) as new_orders from orders where storeId='$sellerId' and status='0'")->row();
        $complete_orders=$this->db->query("select count(orderId) as complete_orders from orders where storeId='$sellerId' and status='1'")->row();
        $rejected_orders=$this->db->query("select count(orderId) as rejected_orders from orders where storeId='$sellerId' and status='6'")->row();
        $total_sales=$this->db->query("select sum(store_earning) as total_sales from orders where storeId='$sellerId' and status='1'")->row();
        return array('new_orders'=>$new_orders->new_orders,'complete_orders'=>$complete_orders->complete_orders,'total_sales'=>$total_sales->total_sales,'rejected_orders'=>$rejected_orders->rejected_orders);
    }
}
