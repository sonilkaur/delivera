<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	
	public function add_user()
	{
		$phone=$_POST['phone'];
		$this->db->where('phone',$phone);
		$emailex=$this->db->get('users')->result();
		  if($emailex)
      {
          $this->session->set_flashdata('error','Phone Already exists');
          return 0;
          //redirect('user/add');
          //return false;
      }
	 /*upload file if exist*/
      $config['upload_path']          = './uploads/';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';

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
		$data=array('fullName'=>$this->input->post('name'),
		'email'=>$this->input->post('email'),
		'password'=>md5($this->input->post('password')),
		'phone'=>$this->input->post('phone'),
		'dial_code'=>$this->input->post('dial_code'),
		'photo'=>$image_name
		
		);
		$this->db->insert('users',$data);
		return true;
	}
	public function get_users()
	{
          //  $data=$this->db->query("select * from users orderby userId desc")->result();
                 $this->db->order_by('userId','DESC');
		return $this->db->get('users')->result();
          //  return $data;
	}
	public function get_userById($userId)
	{
		$this->db->where('userId',$userId);
		return $this->db->get('users')->row();
	}
	public function edit_process($userId)
	{
		
		
		 /*upload file if exist*/
      $config['upload_path']          = './uploads/';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';

      $this->load->library('upload', $config);
      $image_name='';

      if ( ! $this->upload->do_upload('image'))
      {
              $error = array('error' => $this->upload->display_errors());
			 // $this->session->set_flashdata('error',$this->upload->display_errors());
             //redirect('user/edit/'.$userId);
      }
      else
      {
              $data['info'] = array('upload_data' => $this->upload->data());
              $image_name="uploads/".$data['info']['upload_data']['file_name'];
				$this->db->query("update users set photo='$image_name' where userId='$userId'");
             // $this->load->view('add_restaurant', $data);
      }
	  $user_data=array('fullName'=>$_POST['name'],'email'=>$_POST['email'],'dial_code'=>$_POST['dial_code'],'phone'=>$_POST['phone']);
	  $this->db->where('userId',$userId);
	  $this->db->update('users',$user_data);
	  return true;
	}
	
}