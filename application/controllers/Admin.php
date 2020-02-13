<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {

        parent::__construct();
        //print_r('hello');die;
        $this->load->model('Admin_model', 'admin');
        $this->load->library('form_validation');
        $this->session->keep_flashdata('error');
        $this->session->keep_flashdata('success');//demo string 
       
        // Your own constructor code
    }

    public function index() {
        if (isset($_SESSION['email'])) {
            redirect('admin/dashboard');
        }
        $this->load->view('login');
    }

    public function login_auth() {
        //if(!isset($_SESSION['email'])){redirect('admin');}
        $result = $this->admin->authentication();
        //print_r($result);die;
        if ($result != false) {
            $email = $this->input->post('email');
            $id = $result[0]->adminId;
            $this->session->set_userdata('id', $id);
            $this->session->set_userdata('email', $email);
            $this->session->set_userdata('logged_in', TRUE);
            // print_r($_SESSION);die;
            redirect('admin/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Invalid details');
            redirect('admin');
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        $data['result'] = $this->admin->get_users();
        $data['stats'] = $this->admin->getdashboardstats();
        $this->load->view('common/header');
        $this->load->view('index', $data);
        $this->load->view('common/footer');
    }

    public function get_list() {
        $days = $_POST['days'];
        $table_name = $_POST['table_name'];
        $res['result'] = $this->admin->get_custome_list($days, $table_name);
        //  $end_date=$_POST['end_date'];
        //$start_date=$_POST['table_name'];
        //print_r(json_encode($res));
        echo json_encode($res);
    }

    public function get_custome_store() {
        $data = $this->db->query("select category.name,count(store_category_relation.storeCatRelationId) as total from store_category_relation join category on category.categoryId=store_category_relation.storeCategoryId group by store_category_relation.storeCategoryId")->result();

        echo json_encode($data);
    }

    public function profile() {
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        $data['res'] = $this->admin->profile_info();
        $this->load->view('common/header');
        $this->load->view('profile', $data);
        $this->load->view('common/footer');
    }

    public function edit_profile($id) {
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        // print_r($_POST);die;
        $result = $this->admin->edit_process($id);
        if ($result = true) {
            $this->session->set_flashdata('success', ' Edit Successfully');
            redirect('admin/profile/');
        }
    }

    public function logout() {
        session_destroy();
        redirect('admin');
    }

    public function forgot_password() {
        $this->load->view('forgot_password');
    }

    public function notifications() {
        $this->load->view('common/header');
        $this->load->view('notification');
        $this->load->view('common/footer');
    }

    public function send_notification() {
        $title = $_POST['title'];
        $message1 = $_POST['message'];

        $res = $this->db->query("select distinct fcm_id from users where fcm_id!=''")->result();
        $myAssociativeArray = json_decode(json_encode($res), true);
        // echo '<pre>';
        //  print_r($myAssociativeArray);die;
        $fcmids = array();
        foreach ($myAssociativeArray as $key => $row) {
            $fcmids[$key] = $row['fcm_id'];
            // print_r($row['fcm_id']);
        }
        //print_r($fcmids);
        // die;
        // print_r(array_chunk($fcmids, 1000));die;
        $message = array("message" => $message1, "title" => $title, "type" => "0");
        //  print_r($message);die;
        $fcm_id = array_chunk($fcmids, 3);
        //print_r($fcm_id);die;
        foreach ($fcm_id as $row) {
            // print_r($row);die;
            $res = Globals::send_fcm_notification($row, $message);
        }
        $data = array("message" => $message1, "title" => $title,);
        $this->db->insert('push_notifications', $data);
        $this->session->set_flashdata('success', 'Notification sent successfully');
        redirect('admin/notifications');
    }

    public function view_notifications() {
        $data['data'] = $this->admin->get_Allnotifications();
        $this->load->view('common/header');
        $this->load->view('notification_listing', $data);
        $this->load->view('common/footer');
    }

    public function delete_notifications() {
        $id = $_POST['id'];
        $this->db->where('notification_id', $id);
        $this->db->delete('push_notifications');
        echo json_encode("success");
    }

    public function promo_code() {
        $data['promo'] = $this->admin->get_promo();
        $this->load->view("common/header");
        $this->load->view("promo_listing", $data);
        $this->load->view("common/footer");
    }

    public function add_promo() {
        $this->load->view("common/header");
        $this->load->view("add_promo");
        $this->load->view("common/footer");
    }

    public function add_promo_process() {


        $data1 = [];
        $error = 0;
        if (!empty($_POST)) {
            $data1 = array('type' => $_POST['type'], 'createdBy' => $_POST['created_by'], 'minOrderAmount' => $_POST['min_order_ammount'], 'code' => $_POST['code'], 'code_amount' => $_POST['code_amount'], 'expiryDate' => $_POST['expiry_date'], 'start_date' => $_POST['start_date'], 'user_used' => $_POST['user_used'], 'status' => $_POST['status'], 'applied_to' => $_POST['applyTo'], 'total_used' => $_POST['total_used']);
        }
        $this->form_validation->set_rules('type', 'Promo Code Type', 'required');
        $this->form_validation->set_rules('min_order_ammount', 'Minimum Order', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('code_amount', 'Promo Code Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('code', 'Promo Code', 'required');
        $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
        $this->form_validation->set_rules('user_used', 'Per User Used', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('total_used', 'Total Used', 'required|numeric|greater_than[0]');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            $error = 1;
        } else {

            $minimum_amount = $_POST['min_order_ammount'];
            $code_amount = $_POST['code_amount'];
            $type = $_POST['type'];
            if ($type == '1') {

                $percentage_value = ($minimum_amount) * ($code_amount / 100);
                //print_r($percentage_value);
                if ($minimum_amount < $percentage_value) {
                    // echo 'hii';die;
                    $this->session->set_flashdata('error', 'Percentage Code Amount should be less than minimum amount');
                    $error = 1;
                }
            }
            if ($type == '2') {
                if ($minimum_amount < $code_amount) {
                    $this->session->set_flashdata('error', 'Promo Code Amount should be less than minimum amount');
                    $error = 1;
                }
            }
           
            $user_used = $_POST['user_used'];
            $total_used = $_POST['total_used'];
            if ($total_used < $user_used) {
                $this->session->set_flashdata('error', 'Total Used should be Greater  than User used');

                $error = 1;
            }
            // print_r($error);die;
            if ($error == '0') {
              // print_r($error);
                $data = $this->admin->add_promo();
               // print_r($data);die;
                if (!$data) {
                    // $this->session->set_flashdata('error', 'Code already exist');
                    $error = 1;
                }
            }

            if ($error == '1') {
                $this->load->view("common/header");
                $this->load->view("add_promo", $data1);
                $this->load->view("common/footer");
            } else {
                $this->session->set_flashdata('success', 'Promo Code Added successfully');
                redirect('admin/add_promo');
            }
        }
    }

    public function edit_promo($id) {
        $data['promo'] = $this->admin->get_codeById($id);
        // echo '<pre>';
        // print_r($data);die;
        $this->load->view("common/header");
        $this->load->view("edit_promo", $data);
        $this->load->view("common/footer");
    }

    public function edit_promo_process($id) {
        $this->form_validation->set_rules('type', 'Promo Code Type', 'required');
        $this->form_validation->set_rules('min_order_ammount', 'Minimum Order', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('code', 'Promo Code', 'required');
        $this->form_validation->set_rules('code_amount', 'Promo Code Amount', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('user_used', 'Per User Used', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('applyTo', 'Applied For', 'required');
        $this->form_validation->set_rules('expiry_date', 'Expiry Date', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('total_used', 'Total Used', 'required|numeric|greater_than[0]');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/edit_promo/' . $id);
            // $this->load->view('myform');
        } else {
            $minimum_amount = $_POST['min_order_ammount'];
            $code_amount = $_POST['code_amount'];
            $type = $_POST['type'];
            if ($type == '1') {

                $percentage_value = ($minimum_amount) * ($code_amount / 100);
                //print_r($percentage_value);
                if ($minimum_amount < $percentage_value) {
                    // echo 'hii';die;
                    $this->session->set_flashdata('error', 'Percentage Code Amount should be less than minimum amount');
                    //print_r($this->session->userdata('error1'));die;
                    redirect('admin/edit_promo/' . $id);
                }
            }
            if ($type == '2') {
                if ($minimum_amount < $code_amount) {
                    $this->session->set_flashdata('error', 'Promo Code Amount should be less than minimum amount');
                    redirect('admin/edit_promo/' . $id);
                }
            }
            $user_used = $_POST['user_used'];
            $total_used = $_POST['total_used'];
            if ($total_used < $user_used) {
                $this->session->set_flashdata('error', 'Total Used should be Greater  than User used');
                redirect('admin/edit_promo/' . $id);
            }
            $data = $this->admin->edit_promo($id);
            $this->session->set_flashdata('success', 'Promo Code Edit successfully');
            redirect('admin/edit_promo/' . $id);
        }
    }

    public function delete_promo() {
        $id = $_POST['id'];
        $this->db->where('codeId', $id);
        $this->db->delete('promo_code');
        $this->db->where('codeId', $id);
        $this->db->delete('promo_code_store');
        echo json_encode("success");
    }

    public function delivery_charges() {
        $data['charges'] = $this->admin->get_del_charges();
        $this->load->view("common/header");
        $this->load->view("delivery_charges_listing", $data);
        $this->load->view("common/footer");
    }

    public function add_delivery_charges() {
        $this->load->view("common/header");
        $this->load->view("add_delivery_charges");
        $this->load->view("common/footer");
    }

    public function add_delivery_process() {
        $this->form_validation->set_rules('rate', ' Delivery Charges', 'required');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/add_delivery_charges');
            // $this->load->view('myform');
        } else {
            $data = $this->admin->add_del_charge();
            $this->session->set_flashdata('success', 'Delivery Charge Added successfully');

            redirect('admin/add_delivery_charges');
        }
        // print_r($_POST);
    }

    public function edit_delivery_charge($id) {
        $data['charges'] = $this->admin->get_charge_by_id($id);
        $this->load->view("common/header");
        $this->load->view("edit_delivery_charges", $data);
        $this->load->view("common/footer");
    }

    public function delete_delivery_charge() {
        $id = $_POST['id'];
        $this->db->where('delivery_charge_id', $id);
        $this->db->delete('delivery_charges');

        echo json_encode("success");
    }

    public function delete_driver_commission() {
        $id = $_POST['id'];
        $this->db->where('driver_commission_id', $id);
        $this->db->delete('driver_commission');

        echo json_encode("success");
    }

    public function edit_delivery_process($id) {
        $this->form_validation->set_rules('rate', ' Delivery Charges', 'required');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/edit_delivery_charge/' . $id);
            // $this->load->view('myform');
        } else {
            $data = $this->admin->edit_del_charge($id);
            $this->session->set_flashdata('success', 'Delivery Charge Edit successfully');
            redirect('admin/edit_delivery_charge/' . $id);
        }
    }

    public function driver_commission() {
        $data['driver_commission'] = $this->admin->get_driver_commission();
        $this->load->view("common/header");
        $this->load->view("driver_commission_listing", $data);
        $this->load->view("common/footer");
    }

    public function add_driver_commission() {
        $this->load->view("common/header");
        $this->load->view("add_driver_commission");
        $this->load->view("common/footer");
    }

    public function add_driver_commission_process() {
        $this->form_validation->set_rules('rate', ' Driver Commission', 'required');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/add_driver_commission');
            // $this->load->view('myform');
        } else {
            $data = $this->admin->add_driver_charge();
            $this->session->set_flashdata('success', 'Driver Commission Added successfully');
            // print_r($this->session->flashdata('success'));die;
            redirect('admin/add_driver_commission', 'refresh');
        }
    }

    public function edit_driver_commission($id) {
        $data['charges'] = $this->admin->get_driver_com_by_id($id);
        $this->load->view("common/header");
        $this->load->view("edit_driver_commission", $data);
        $this->load->view("common/footer");
    }

    public function edit_driver_comm_process($id) {
        $this->form_validation->set_rules('rate', ' Driver Commission', 'required');
        if ($this->form_validation->run() == FALSE) {

            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/edit_driver_commission/' . $id);
            // $this->load->view('myform');
        } else {
            $data = $this->admin->edit_driver_com($id);
            $this->session->set_flashdata('success', 'Delivery Charge Edit successfully');
            redirect('admin/edit_driver_commission/' . $id);
        }
    }

}
