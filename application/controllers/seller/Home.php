<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();

        //if(!isset($_SESSION['selleremail'])){redirect('seller/home/');}
        $this->load->model('seller/Home_model', 'home');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        // Your own constructor code
    }

    public function index() {
        if (isset($_SESSION['selleremail'])) {
            redirect('seller/home/dashboard/');
        }
        $this->load->view('seller/login');
    }

    public function login_auth() {
        //if(!isset($_SESSION['email'])){redirect('admin');}
        $result = $this->home->authentication();
        // echo'<pre>'; print_r($result);die;
        if ($result) {
            $email = $this->input->post('email');
            $id = $result[0]->storeId;
            $category = ''; //$result[0]->storeCategoryId;
            $this->session->set_userdata('sellerid', $id);
            $this->session->set_userdata('selleremail', $email);
            $this->session->set_userdata('category', $category);
            $this->session->set_userdata('logged_in', TRUE);
            // print_r($_SESSION);die;
            redirect('seller/home/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid details');
            redirect('seller/home');
        }
    }

    public function dashboard() {

        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home');
        } 
        $sellerId = $_SESSION['sellerid'];
        $data['result'] = $this->home->get_users();
        $data['stats']=$this->home->get_dashboard_stats($sellerId);
       // echo '<pre>';
       // print_r($data);die;
        $this->load->view('seller/header');
        $this->load->view('seller/dashboard', $data);
        $this->load->view('seller/footer');
    }

    public function logout() {
        session_destroy();
        redirect('seller/home/');
    }

    public function get_list() {
        $sellerId = $_SESSION['sellerid'];
        $days = $_POST['days'];
        // print_r($days);die;
        $res = $this->home->get_custome_orders($days, $sellerId);
        echo json_encode($res);
    }

    public function settings() {
       // echo"<pre>";print_r($_POST);die;
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home');
        }
        $id = $_SESSION['sellerid'];
        $data['result'] = $this->home->getSellerById($id);
       //echo"<pre>";print_r($data);die;
        $this->load->view('seller/header');
        $this->load->view('seller/setting', $data);
        $this->load->view('seller/footer');
    }

    public function setting_process() {
     //  echo '<pre>';
       //  print_r($_POST); die;
        //if(!isset($_SESSION['selleremail'])){redirect('seller/home');}

        $this->form_validation->set_rules('store_name', 'Store Name', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|min_length[6]');
        $this->form_validation->set_rules('contactNumber', 'Contact number', 'min_length[4]|numeric');
        $this->form_validation->set_rules('contactOther', 'Contact number others', 'min_length[4]|numeric');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('seller/home/settings/');
        } else {
            $id = $_SESSION['sellerid'];
            $this->home->edit_settings($id);
            $this->session->set_flashdata('success', 'Profile Updated successfully');

            redirect('seller/home/settings/');
        }

//        $id = $_SESSION['sellerid'];
//        $this->home->edit_settings($id);
//        $this->session->set_flashdata('success', 'Profile Updated successfully');
//
//        redirect('seller/home/settings/');
    }

    public function forgot_password() {
        $this->load->view('seller/forgot_password');
    }

    public function forget_password_process() {
        if (isset($_POST['email'])) {
            $data['result'] = $this->home->send_otp_password();
            $this->session->set_flashdata('success', 'Check Your Email for instructions');
            redirect('seller/home/forgot_password');
        }
        // print_r($data);die;
    }

}
