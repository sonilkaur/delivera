<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery_model extends CI_Model {

    public function get_deliveryboys() {
        //$this->db->order_by('')
        return $this->db->query("select * from deliveryboy order by boyId desc")->result();
    }

    public function add_deliveryboy() {
        
        $phone = $this->input->post('phone');
        $email = $_POST['email'];
        $this->db->where('email', $email);

        $emailex = $this->db->get('deliveryboy')->result();

        $this->db->where('phone', $phone);
        $phone_exist = $this->db->get('deliveryboy')->result();
       
        if ($phone_exist) {
            $this->session->set_flashdata('error', 'Phone Number Already exists');
            return false;
            //redirect('deliveryBoy/add');
            //return false;
        }

        /* upload file if exist */
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';

        $this->load->library('upload', $config);
        $image_name = '';

        if (!$this->upload->do_upload('image')) {
            $error['info'] = array('error' => $this->upload->display_errors());
            //$this->load->view('add_restaurant', $error);
        } else {
            $data['info'] = array('upload_data' => $this->upload->data());
            $image_name = "uploads/" . $data['info']['upload_data']['file_name'];

            // $this->load->view('add_restaurant', $data);
        }
        $data = array('fullName' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => md5($this->input->post('password')),
            'phone' => $this->input->post('phone'),
            'dial_code' => $this->input->post('dial_code'),
            'vehicleBrandName' => $this->input->post('vehicle_brand'),
            'modelNumber' => $this->input->post('model_number'),
            'purchaseDate' => $this->input->post('purchase_date'),
            'drivingLicense' => $this->input->post('license'),
            'photo' => $image_name
        );
        $this->db->insert('deliveryboy', $data);
        return true;
    }

    public function get_dbById($id) {
        $this->db->where('boyId', $id);
        return $this->db->get('deliveryboy')->row();
    }

    public function edit_process($id) {
  

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
            $this->db->query("update deliveryboy set photo='$image_name' where boyId='$id'");
            // $this->load->view('add_restaurant', $data);
        }
        $user_data = array('fullName' => $_POST['name'], 'email' => $_POST['email'], 'phone' => $_POST['phone'],'dial_code'=>$_POST['dial_code'],'vehicleBrandName' => $this->input->post('vehicle_brand'),
            'modelNumber' => $this->input->post('model_number'),
            'purchaseDate' => $this->input->post('purchase_date'),
            'drivingLicense' => $this->input->post('license'));
        $this->db->where('boyId', $id);
        $this->db->update('deliveryboy', $user_data);
        return true;
    }

}
