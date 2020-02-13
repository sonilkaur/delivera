<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {
    public function get_categories()
    {
       //return $this->db->query('select * from Category ')->result();
       $q= "select * from category order by categoryId desc";
      $data['cat']= $this->db->query($q)->result();
      foreach($data['cat'] as $key=>$res)
      {
         
          $parentId=$res->parentId;
         // print_r($parentId);
          $parentdata=$this->db->query("select * from category where categoryId='$parentId'")->result();
          $data['cat'][$key]->parent=$parentdata;
           //array_push($data['cat'],$parentdata);
            //array_push($data,$parentdata);
          //$data['cat']['parent']=$parentdata;
          //$data[$res]->parent=$parentdata;
      }
     // print"<pre>";
      //print_r($data);die;
      return $data;
    }
    public function get_category()
    {
      $q=  "select * from category where parentId=0 order by categoryId desc";
      return $this->db->query($q)->result();
      
    }
    public function add_category()
    {
         /*upload file if exist*/
      $config['upload_path']          = './uploads/';
      $config['allowed_types']        = 'gif|jpg|png|jpeg';

      $this->load->library('upload', $config);
      $image_name='';

      if ( ! $this->upload->do_upload('image'))
      {
              $error['info'] = array('error' => $this->upload->display_errors());
            
      }
      else
      {
              $data['info'] = array('upload_data' => $this->upload->data());
              $image_name="uploads/".$data['info']['upload_data']['file_name'];

             // $this->load->view('add_restaurant', $data);
      }
       $data=array('name'=>$this->input->post('name'),
		'parentId'=>$this->input->post('sub_cat'),
		'photo'=>$image_name
		
		);
		$this->db->insert('category',$data);
		return true;
    }
    public function get_catById($id)
    {
        return $this->db->query("select * from category where categoryId='$id'")->result();
    }
    public function edit_process($id)
    {
          $config['upload_path']          = './uploads/';
      $config['allowed_types']        = 'gif|jpg|png';

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
				$this->db->query("update category set photo='$image_name' where categoryId='$id'");
             // $this->load->view('add_restaurant', $data);
      }
	  $user_data=array('name'=>$_POST['name'],'parentId'=>$_POST['parentId']);
         // print_r($user_data);die;
	  $this->db->where('categoryId',$id);
	  $this->db->update('category',$user_data);
	  return true;
    }
}
