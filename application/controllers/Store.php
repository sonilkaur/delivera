<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Store_model', 'store');
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        // Your own constructor code
    }

    public function index() {
        $data['data'] = $this->store->get_stores();
        $this->load->view('common/header');
        $this->load->view('store/store_listing', $data);
        $this->load->view('common/footer');
    }

    public function add() {
        $data['store_cat'] = $this->store->getAllStoreCategories();
        $this->load->view('common/header');
        $this->load->view('store/add_store', $data);
        $this->load->view('common/footer');
    }

    public function add_process() {
//       echo '<pre>';
//       print_r($_POST);die;
        $data1=[];
        if(!empty($_POST)){
        $data1 = array('name' => isset($_POST['name'])?$_POST['name']:"", 'address' => isset($_POST['address'])?$_POST['address']:"", 'latitude' => isset($_POST['latitude'])?$_POST['latitude']:"", 'longitude' => isset($_POST['longitude'])?$_POST['longitude']:"", 'email' => isset($_POST['email'])?$_POST['email']:"", 'description' => isset($_POST['description'])?$_POST['description']:"",'contactNumber' => isset($_POST['contactNumber'])?$_POST['contactNumber']:"", 'contactNumberOthers' => isset($_POST['contactNumberOthers'])?$_POST['contactNumberOthers']:"", 'contactEmail' => $_POST['contactEmail'], 'deliveryTime' => $_POST['deliveryTime'], 'minimumOrder' => $_POST['minOrder'], 'commission_type' => isset($_POST['commission_type'])?$_POST['commission_type']:"", 'commission' => $_POST['commission']);
        $data1['store_category']=$_POST['store_category'];
        $data1['sub_category']=$_POST['sub_category'];
        
        }
        
        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'numeric|min_length[4]');
        $this->form_validation->set_rules('commission_type', 'Commission type', 'required');
        $this->form_validation->set_rules('contactNumberOthers', 'Contact Number Others', 'numeric|min_length[4]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            //$this->add();
            $this->session->set_flashdata('error', validation_errors());
            $data1['store_cat'] = $this->store->getAllStoreCategories();
            $this->load->view('common/header');
            $this->load->view('store/add_store', $data1);
            $this->load->view('common/footer');
            // redirect('store/add');
            // $this->load->view('myform');
        } else {
            $data = $this->store->add_store();
        // print_r($data);die;
            if (!$data) {
                $this->session->set_flashdata('error', 'Email already exist');
               // print_r($data);die;
                $data1['store_cat'] = $this->store->getAllStoreCategories();
                $this->load->view('common/header');
                $this->load->view('store/add_store', $data1); 
                $this->load->view('common/footer');
                // redirect('store/add');
            }
            else{
            $this->session->set_flashdata('success', 'Store Added Successfully');
            redirect('store/add');
            }
        }
        
    }

    public function edit($id) {
        $data['info'] = $this->store->getStoreById($id);
        $data['store_cat'] = $this->store->getAllStoreCategories();
        //echo "<pre>"; print_r($data['info']);die;
        $this->load->view('common/header');
        $this->load->view('store/edit_store', $data);
        $this->load->view('common/footer');
    }

    public function edit_process($id) {

        $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
        if ($_POST['new_password']) {
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|min_length[6]');
        }
        //$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('contactNumber', 'Contact Number', 'numeric|min_length[4]');
        $this->form_validation->set_rules('contactNumberOthers', 'Contact Number Others', 'numeric|min_length[4]');
        if ($this->form_validation->run() == FALSE) {
            //$this->add();
            $this->session->set_flashdata('error', validation_errors());
            redirect('store/edit/' . $id);
            // $this->load->view('myform');
        } else {
            $result = $this->store->edit_process($id);
            $this->session->set_flashdata('success', 'Store Edit Successfully');
            redirect('store/edit/' . $id);
        }
       
    }

    public function delete() {
        $id = $this->input->post('id');
        $this->db->where('storeId', $id);
        $this->db->delete('store');

        $this->db->where('storeId', $id);
        $this->db->delete('store_category_relation');
        echo json_encode("success");
    }

    public function category() {
        $data['data'] = $this->store->getAllStoreCategories();
        $this->load->view('common/header');
        $this->load->view('store/category_listing', $data);
        $this->load->view('common/footer');
    }

    public function add_store_category() {

        $this->load->view('common/header');
        $this->load->view('store/add_category');
        $this->load->view('common/footer');
    }

    public function add_category_process() {
        $cat_name = $this->input->post('cat_name');
        $this->db->query("INSERT INTO `store_category` (`categoryName`) VALUES ('$cat_name')");

        $this->session->set_flashdata('success', 'Store Category Created Successfully');
        redirect('store/add_store_category/');
    }

    public function edit_store_category($id) {

        if ($id == "") {
            $this->session->set_flashdata('error', 'Id is missing');
            redirect('store/category_listing/');
        } else {
            $data['result'] = $this->db->query("select * from  store_category where storeCatId='$id'")->row();
            //print_r($this->db->last_query());die;
            $this->load->view('common/header');
            $this->load->view('store/edit_store_category', $data);
            $this->load->view('common/footer');
        }
    }

    public function edit_category_process($id) {
        $category_name = $this->input->post('cat_name');
        $this->db->query("update store_category set categoryName='$category_name' where storeCatId='$id'");
        $this->session->set_flashdata('success', 'Category Modified Successfully');
        redirect('store/edit_store_category/' . $id);
    }

    public function delete_store_category() {
        $id = $this->input->post('id');
        $this->db->where('storeCatId', $id);
        $this->db->delete('store_category');
        echo json_encode("success");
    }

}
