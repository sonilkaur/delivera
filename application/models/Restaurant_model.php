<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Restaurant_model extends CI_Model {
    public function get_restaurants()
    {
       return $this->db->query('select * ,restaurant.id as restaurant_id from users left join restaurant on users.id=restaurant.user_id')->result();
    }

    public function add_restaurant()
    {
        /* check if email already  exist*/
      $email= $this->input->post('email');
      
      $data= $this->db->query("select * from users where email='$email'")->result();
      if($data)
      {
          $this->session->set_flashdata('error','Email Already exists');
          redirect('restaurant/add');
          //return false;
      }
     
/*upload file if exist*/
      $config['upload_path']          = './uploads/';
      $config['allowed_types']        = 'gif|jpg|png';

      $this->load->library('upload', $config);
      $image_name='';

      if ( ! $this->upload->do_upload('image'))
      {
              $error['info'] = array('error' => $this->upload->display_errors());
              $this->load->view('add_restaurant', $error);
      }
      else
      {
              $data['info'] = array('upload_data' => $this->upload->data());
              $image_name="uploads/".$data['info']['upload_data']['file_name'];

             // $this->load->view('add_restaurant', $data);
      }
      $data=array('email'=>$email,'password'=>md5($this->input->post('password')),'role_id'=>1,'image'=>$image_name);
      $this->db->insert('users',$data);
      $user_id=$this->db->insert_id();
      $restaurant_data=array('name'=>$this->input->post('name'),'address'=>$this->input->post('address'),'phone'=>$this->input->post('phone') ,'user_id'=>$user_id);
     
      $this->db->insert('restaurant',$restaurant_data);
      return true;
      
      
    }
 }