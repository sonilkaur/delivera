<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function authentication() {
        $email = $this->input->post('email');
        $password = md5($this->input->post('password'));
        $data = $this->db->query("select * from admin where email='$email' and password='$password'")->result();
        // print_r($this->db->last_query());die;
        //print_r($data);die;
        if ($data) {
            return $data;
        } else {
            return false;
        }
    }

    public function profile_info() {
        //$this->db->
        return $this->db->get('admin')->row();
    }

    public function edit_process($id) {
        if (!empty($_POST['old_password'])) {
            $old_pass = md5($_POST['old_password']);
            $data = $this->db->query("select * from admin where adminId='$id' and password='$old_pass'")->result();
            //print_r($data);die;
            if (!empty($data)) {
                if (!empty($_POST['new_password'])) {
                    $new_pass = md5($_POST['new_password']);
                    $this->db->query('update admin set password="' . $new_pass . '" where adminId="' . $id . '"');
                } else {
                    $this->session->set_flashdata('error', 'Please Enter new password');
                    redirect('admin/profile/');
                }
            } else {
                $this->session->set_flashdata('error', 'Old Password doesnot Correct');
                redirect('admin/profile/');
            }
        }
        /* upload file if exist */
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        $image_name = '';

        if (!$this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            // $this->session->set_flashdata('error',$this->upload->display_errors());
            //redirect('user/edit/'.$userId);
        } else {
            $data['info'] = array('upload_data' => $this->upload->data());
            $image_name = "uploads/" . $data['info']['upload_data']['file_name'];
            $this->db->query("update admin set photo='$image_name' where adminId='$id'");
            // $this->load->view('add_restaurant', $data);
        }
        $user_data = array('fullName' => $_POST['name'], 'email' => $_POST['email'], 'phone' => $_POST['phone']);
        $this->db->where('adminId', $id);
        $this->db->update('admin', $user_data);
        return true;
    }

    public function get_users() {
        $this->db->select('*');
        $this->db->from('users');

        $this->db->order_by("userId", "desc");
        $this->db->limit(6, 0);
        // $this->db->order_by('userId')
        return $this->db->get()->result();
    }

    public function getdashboardstats() {
        $result['total_users'] = $this->db->query("select count(userId) as users from users")->row();
        $result['new_orders'] = $this->db->query("select count(orderId) as orders from orders  where status=0")->row();
        $result['complete_orders']=$this->db->query("select count(orderId) as complete_orders from orders where status=1")->row();
        $result['earnings']=$this->db->query("select sum(admin_earning) as admin_earnings from orders where status=1")->row();
        return $result;
    }

    public function get_custome_list($days, $table_name) {
          $category= $this->db->query("select name,categoryId from category where parentId=0")->result();
          
             foreach ($days as $row){
           $data[$row]=[];
         foreach($category as $key=> $cat){
               $cat_id=$cat->categoryId;
               //print_r($cat_id);die;
               $result=$this->db->query(" select count(orders.orderId) as sale,category.name as name from orders join order_items on orders.orderId=order_items.orderId  join items on items.itemId=order_items.itemId join category on category.categoryId=items.categoryId where items.categoryId=$cat_id and CAST(orders.createdOn AS DATE)='$row'")->row();
               array_push($data[$row],$result);
         }
     }
//        foreach ($days as $row) {
//            $data[$row] = $this->db->query("select count(orders.orderId)as sales,category.name from orders join order_items on order_items.orderId=orders.orderId join items on order_items.itemId=items.itemId left join category on category.categoryId=items.categoryId where CAST(orders.createdOn AS DATE)='$row' GROUP BY category.categoryId")->result();
//            //return "select count(orderId),storeId from orders where CAST(createdOn AS DATE)='$row' GROUP BY storeId";      
//        }
        return $data;
    }

    public function get_Allnotifications() {
        return $this->db->query("select * from push_notifications order by notification_id desc")->result();
    }

    public function get_promo() {
      $data=  $this->db->query("select * from promo_code left join store on promo_code.createdId=store.storeId order by promo_code.codeId desc")->result();
       return $data;
    }

    public function add_promo() {
        $code=$_POST['code'];
        $code_exist=$this->db->query("select * from promo_code where code='$code' and expiryDate  >= '".date("Y-m-d")."' ")->result();
        //print_r($this->db->last_query());
        //print_r($code_exist);die;
        if(!empty($code_exist))
        {
            $this->session->set_flashdata('error', 'Code already exist');
            return false;
           //redirect('admin/add_promo');
        }
        //print_r($_POST['stores']);die;
        $data = array('type' => $_POST['type'], 'createdBy' => $_POST['created_by'], 'minOrderAmount' => $_POST['min_order_ammount'], 'code' => $_POST['code'],'code_amount'=>$_POST['code_amount'], 'expiryDate' => $_POST['expiry_date'], 'start_date' => $_POST['start_date'],'user_used'=>$_POST['user_used'], 'status' => $_POST['status'], 'applied_to' => $_POST['applyTo'], 'total_used' => $_POST['total_used']);
        $this->db->insert('promo_code', $data);
        $promo_id = $this->db->insert_id();
        if ($_POST['applyTo'] == 'selected') {
            foreach ($_POST['stores'] as $row) {
                $data = array('codeId' => $promo_id, 'storeId' => $row);
                $this->db->insert("promo_code_store", $data);
              
            }
        }
          return true;
    }

    public function get_codeById($id) {
        //return  $this->db->query("select * from promo_code where codeId='$id'")->row();
        $data = $this->db->query("select * from promo_code where codeId='$id'")->row();
        if ($data->applied_to == 'selected') {
            $promo = $this->db->query("select codeId,storeId from promo_code_store where codeId='$id'")->result();

            $data->store = array();
            foreach ($promo as $row) {
                array_push($data->store, $row->storeId);
                //$data->store=$row->storeId;
            }
        }
        return $data;
    }

    public function edit_promo($id) {
         $code=$_POST['code'];
       $code_exist=$this->db->query("select * from promo_code where code='$code' and expiryDate  < '".date("Y-m-d")."' and codeId!=$id")->result();
        if(!empty($code_exist))
        {
            $this->session->set_flashdata('error', 'Code already exist');
           redirect('admin/edit_promo/'.$id);
        }
        // echo '<pre>'; print_r($_POST);die;
        $data = array('type' => $_POST['type'], 'minOrderAmount' => $_POST['min_order_ammount'], 'code' => $_POST['code'], 'expiryDate' => $_POST['expiry_date'], 'status' => $_POST['status'], 'start_date' => $_POST['start_date'], 'applied_to' => $_POST['applyTo'], 'code_amount'=>$_POST['code_amount'],'user_used'=>$_POST['user_used'], 'total_used' => $_POST['total_used']);
        $this->db->where('codeId', $id);
        $this->db->update('promo_code', $data);
        if ($_POST['applyTo'] == 'selected') {
            if ($_POST['stores']) {
                $this->db->where('codeId', $id);
                $this->db->delete('promo_code_store');
                foreach ($_POST['stores'] as $row) {

                    $data = array('codeId' => $id, 'storeId' => $row);
                    $this->db->insert("promo_code_store", $data);
                }
            }
        }
    }
    public function add_del_charge()
    {
       // print_r(explode(',',$str,-1));die;
       
        $range=explode(';',$_POST['distance']);
        $range_exist=$this->db->query("select * from delivery_charges where (start <= $range[0] and end > $range[0] ) or (start<=$range[1] and end >$range[1])")->result();
        //select * from delivery_charges where (start <= 4 and end >= 4) or (start<=10 and end >=10)
         
       //print_r($this->db->last_query());
       // print_r($range_exist);die;
         if($range_exist)
         {
            $this->session->set_flashdata('error', 'The given range is already  lies in existing range');
            redirect('admin/add_delivery_charges/');   
         }
        $data=array('start'=>$range[0],'end'=>$range[1],'rate'=>$_POST['rate']);
        $this->db->insert('delivery_charges',$data);
        return true;
    }
    public function get_del_charges()
    {
       return  $this->db->query("select * from delivery_charges order by delivery_charge_id desc")->result();
    }
    public function get_charge_by_id($id)
    {
        return $this->db->query("select * from delivery_charges where delivery_charge_id=$id")->row();
    }
    public function edit_del_charge($id)
    {
        $range=explode(';',$_POST['distance']);
        $range_exist=$this->db->query("select * from delivery_charges where delivery_charge_id!=$id and (start <= $range[0] and end > $range[0] ) or (start<$range[1] and end >$range[1])")->result();
        
      //  select * from driver_commission where driver_commission_id!=$id and (start <= $range[0] and end > $range[0] ) or (start<$range[1] and end >$range[1])
       //print_r($this->db->last_query());
        //print_r($range_exist);die;
         if($range_exist)
         {
            $this->session->set_flashdata('error', 'The given range is already  lies in existing range');
            redirect('admin/edit_delivery_charge/'.$id);
         }
        $data=array('start'=>$range[0],'end'=>$range[1],'rate'=>$_POST['rate']);
        $this->db->where('delivery_charge_id',$id);
        $this->db->update('delivery_charges',$data);
        return true;
    }
    public function get_driver_commission()
    {
          return  $this->db->query("select * from driver_commission order by driver_commission_id desc")->result();
    }
    public function add_driver_charge()
    {
           $range=explode(';',$_POST['distance']);
        $range_exist=$this->db->query("select * from driver_commission where (start <= $range[0] and end > $range[0] ) or (start<$range[1] and end >$range[1]) ")->result();
        //select * from delivery_charges where (start <= 4 and end >= 4) or (start<=10 and end >=10)
         
       //print_r($this->db->last_query());
       // print_r($range_exist);die;
         if($range_exist)
         {
            $this->session->set_flashdata('error', 'The given range is already  lies in existing range');
            redirect('admin/add_driver_commission/');   
         }
        $data=array('start'=>$range[0],'end'=>$range[1],'rate'=>$_POST['rate']);
        $this->db->insert('driver_commission',$data);
        return true;
    }
    public function get_driver_com_by_id($id)
    {
        return $this->db->query("select * from driver_commission where driver_commission_id=$id")->row();
    }
    public function edit_driver_com($id)
    {
        $range=explode(';',$_POST['distance']);
        $range_exist=$this->db->query("select * from driver_commission where driver_commission_id!=$id and (start <= $range[0] and end > $range[0] ) or (start<$range[1] and end >$range[1]) ")->result();
     //print_r($this->db->last_query());
      //  print_r($range_exist);die;
         if($range_exist)
         {
            $this->session->set_flashdata('error','The given range is already  lies in existing range');
            redirect('admin/edit_driver_commission/'.$id);
         }
        $data=array('start'=>$range[0],'end'=>$range[1],'rate'=>$_POST['rate']);
        $this->db->where('driver_commission_id',$id);
        $this->db->update('driver_commission',$data);
        return true; 
    }

}
