<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryBoy extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('delivery_model', 'delivery');
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
    }

    public function index() {
        $data['info'] = $this->delivery->get_deliveryboys();
        $this->load->view('common/header');
        $this->load->view('deliveryboy/listing', $data);
        $this->load->view('common/footer');
    }

    public function add() {

        $this->load->view('common/header');
        $this->load->view('deliveryboy/add');
        $this->load->view('common/footer');
    }

    public function add_process() {
        $data1 = [];
        if (!empty($_POST)) {
            $data1 = array('name' => isset($_POST['name']) ? $_POST['name'] : "", 'email' => isset($_POST['email']) ? $_POST['email'] : "", 'phone' => isset($_POST['phone']) ? $_POST['phone'] : "",'vehicleBrandName'=>$_POST['vehicle_brand'],'modelNumber'=>$_POST['model_number'],'purchaseDate'=>$_POST['purchase_date'],'drivingLicense'=>$_POST['license']);
        }
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[4]');
         $this->form_validation->set_rules('dial_code', 'Dial code', 'required');


        if ($this->form_validation->run() == FALSE) {
            //$this->add();
            $this->session->set_flashdata('error', validation_errors());
            $this->load->view('common/header');
            $this->load->view('deliveryboy/add', $data1);
            $this->load->view('common/footer');
            //redirect('deliveryBoy/add');
            // $this->load->view('myform');
        } else {
            $data = $this->delivery->add_deliveryboy();
            //print_r($data);die;
            if (!$data) {

                $this->load->view('common/header');
                $this->load->view('deliveryboy/add', $data1);
                $this->load->view('common/footer');
            } 
            else {
                $this->session->set_flashdata('success', 'Record Added Successfully');
                redirect('deliveryBoy/add');
            }
        }
    }

    public function edit($id) {
        $data['info'] = $this->delivery->get_dbById($id);
        // print_r($data);die;
        $this->load->view('common/header');
        $this->load->view('deliveryboy/edit', $data);
        $this->load->view('common/footer');
    }

    public function edit_process($id) {

        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|min_length[6]');
        if($_POST['new_password'])
        {
         $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
        }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|min_length[4]');
         $this->form_validation->set_rules('dial_code', 'Dial code', 'required');

        if ($this->form_validation->run() == FALSE) {
            //$this->add();
            $this->session->set_flashdata('error', validation_errors());
            redirect('deliveryBoy/edit/' . $id);
            // $this->load->view('myform');
        } else {
            $result = $this->delivery->edit_process($id);
            $this->session->set_flashdata('success', ' Edit Successfully');
            redirect('deliveryBoy/edit/' . $id);
        }
//        $result = $this->delivery->edit_process($id);
//        if ($result = true) {
//            $this->session->set_flashdata('success', ' Edit Successfully');
//            redirect('deliveryBoy/edit/' . $id);
//        }
    }

    public function delete() {
        $id = $_POST['id'];
        $this->db->where('boyId', $id);
        $this->db->delete('deliveryboy');
        echo "success";
    }

}
