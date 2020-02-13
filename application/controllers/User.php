<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
 public function __construct()
 {
      parent::__construct();
	  $this->load->model('User_model','user');
           $this->load->helper(array('form', 'url'));

        $this->load->library('form_validation');
            if (!isset($_SESSION['email'])) {
            redirect('admin');
        }
                
 }
 public function index()
 {
     $data['info']=$this->user->get_users();
     //echo"<pre>";
    // print_r($data);die;
     $this->load->view('common/header');
     $this->load->view('user/listing',$data);
     $this->load->view('common/footer');
 }
 public function add()
 {
     $this->load->view('common/header');
     $this->load->view('user/add');
     $this->load->view('common/footer');
 }
 public function add_process()
 {
     $data1=[];
        if(!empty($_POST)){
        $data1 = array('name' => isset($_POST['name'])?$_POST['name']:"", 'email' => isset($_POST['email'])?$_POST['email']:"",'phone' => isset($_POST['phone'])?$_POST['phone']:"");
        
        }
        
      $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('dial_code', 'Dial Code', 'required');

        if ($this->form_validation->run() == FALSE) {
            //$this->add();
               $this->session->set_flashdata('error', validation_errors());
               $this->load->view('common/header');
                $this->load->view('user/add',$data1);
                 $this->load->view('common/footer');
          // redirect('user/add');
        } else {
          $data= $this->user->add_user();
          if(!$data){
              $this->load->view('common/header');
                $this->load->view('user/add',$data1);
                 $this->load->view('common/footer');
          }
          else{
           $this->session->set_flashdata('success','User Added Successfully');
		redirect('user/add');
          }
        }

 }
 public function edit($userId)
 {
     $data['info']=$this->user->get_userById($userId);
	 $this->load->view('common/header');
	 $this->load->view('user/edit',$data);
	 $this->load->view('common/footer');
 }
 public function edit_process($userId)
 {
     
       $this->form_validation->set_rules('name', 'Name', 'trim|required|max_length[50]');
       if($_POST['new_password'])
           {
             $this->form_validation->set_rules('new_password', 'New Password', 'trim|min_length[8]');
             $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');
       
           }
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('dial_code', 'Dial code', 'required');

        if ($this->form_validation->run() == FALSE) {
            //$this->add();
               $this->session->set_flashdata('error', validation_errors());
           redirect('user/edit/'.$userId);
        } else {
            $result= $this->user->edit_process($userId);
          $this->session->set_flashdata('success','User Edit Successfully');
	 redirect('user/edit/'.$userId);
        }
//	$result= $this->user->edit_process($userId);
//	 if($result=true)
//	 {
//		 $this->session->set_flashdata('success','User Edit Successfully');
//	 redirect('user/edit/'.$userId);
//	 }
	 
 }
 public function delete()
 {
     $id=$_POST['id'];
	 $this->db->where('userId',$id);
	 $this->db->delete('users');
	 echo "success";
 }
}

    