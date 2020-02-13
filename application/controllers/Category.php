<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Category_model', 'category');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        // Your own constructor code
    }

    public function index() {
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        $data['info'] = $this->category->get_categories();
        $this->load->view('common/header');
        $this->load->view('category/listing', $data);
        $this->load->view('common/footer');
    }

    public function add() {
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        $data['info'] = $this->category->get_category();
        $this->load->view('common/header');
        $this->load->view('category/add', $data);
        $this->load->view('common/footer');
    }

    public function add_process() {
 $data1=[];
        if(!empty($_POST)){
        $data1 = array('name' => isset($_POST['name'])?$_POST['name']:"", 'sub_cat' => isset($_POST['sub_cat'])?$_POST['sub_cat']:"");
        
        }
        $this->form_validation->set_rules('name', 'Category name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['info'] = $this->category->get_category();
            //$this->add();
            $this->session->set_flashdata('error', validation_errors());
             $data1['info'] = $this->category->get_category();
        $this->load->view('common/header');
        $this->load->view('category/add', $data1);
        $this->load->view('common/footer');
           // redirect('category/add');
            // $this->load->view('myform');
        } else {
            $data = $this->category->add_category();
            if ($data = true) {
                $this->session->set_flashdata('success', 'Category Added Successfully');
                redirect('category/add');
            }
        }
//         $data= $this->category->add_category();
//	 if($data=true)
//	 {
//            $this->session->set_flashdata('success','Category Added Successfully');
//            redirect('category/add');
//	 }
    }

    public function edit($id) {
        if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
        $data['info'] = $this->category->get_catById($id);
        $data['category'] = $this->category->get_category();
        $this->load->view('common/header');
        $this->load->view('category/edit', $data);
        $this->load->view('common/footer');
    }

    public function edit_process($id) {
        // print_r($_POST);die;
        $this->form_validation->set_rules('name', 'Category name', 'required');

        if ($this->form_validation->run() == FALSE) {
            $data['info'] = $this->category->get_category();
            //$this->add();
            $this->session->set_flashdata('error', validation_errors());
            redirect('category/edit/' . $id);
            // $this->load->view('myform');
        } else {
            $result = $this->category->edit_process($id);
            if ($result = true) {
                $this->session->set_flashdata('success', 'category Edit Successfully');
                redirect('category/edit/' . $id);
            }
        }
//         $result= $this->category->edit_process($id);
//	 if($result=true)
//	 {
//            $this->session->set_flashdata('success','category Edit Successfully');
//            redirect('category/edit/'.$id);
//	 }
    }

    public function delete() {
        $id = $_POST['id'];
        $table = $_POST['table'];
        $this->db->where('categoryId', $id);
        $this->db->delete($table);
        echo json_encode('success');
    }

}
