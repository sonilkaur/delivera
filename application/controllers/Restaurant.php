<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant extends CI_Controller {

    
     public function __construct()
        {
                parent::__construct();
                $this->load->model('Restaurant_model','restaurant');
                // Your own constructor code
        }
        public function index()
        {
           $data['data']= $this->restaurant->get_restaurants();
            $this->load->view('common/header');
            $this->load->view('restaurant_listing',$data);
            $this->load->view('common/footer');
        }
        public function add()
        {
            $this->load->view('common/header');
            $this->load->view('add_restaurant');
            $this->load->view('common/footer');
        }
        public function add_process()
        {
            $data=$this->restaurant->add_restaurant();
            if($data==true)
            {
                $this->session->set_flashdata('success','Record Added Successfully');
                redirect('restaurant/add');
            }
            else{
                $this->session->set_flashdata('error','Something went wrong');
                redirect('restaurant/add');
            }
        }
        public function edit($id)
        {
            $data['info']= $this->restaurant->edit_restaurant($id);
            $this->load->view('common/header');
            $this->load->view('add_restaurant');
            $this->load->view('common/footer');
        }
        public function delete()
        {
            $id=$this->input->post('id');
            $this->db->where('id',$id);
            $this->db->delete('users');
            $this->db->where('user_id',$id);
            $this->db->delete('restaurant');
            echo json_encode("success");
        }
}