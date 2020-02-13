<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    
     public function __construct()
        {
                parent::__construct();
                $this->load->model('Item_model','item');
                 $this->load->library('form_validation');
                   $this->session->keep_flashdata('error');
                // Your own constructor code
                if(!isset($_SESSION['email'])){redirect('admin');}
                
        }
        public function index()
        {
           
            $data['result']=$this->item->get_items();
           // print_r($data);die;
            $this->load->view('common/header');
            $this->load->view('item_listing',$data);
            $this->load->view('common/footer');
        }
        public function edit($id)
        {
            $data['result']=$this->item->getItemById($id);
         //  echo"<pre>"; print_r($data);die;
           $sellerId=$data['result'][0]->storeId;
            $data['cat']=$this->item->getParentcat( $sellerId);
           //echo"<pre>"; print_r($data);die;
            $this->load->view('common/header');
            $this->load->view('edit_item',$data);
            $this->load->view('common/footer');
            
        }
        public function edit_process($id)
        {
           //echo'<pre>';
           // print_r($_POST);die;
             $this->form_validation->set_rules('name', 'Item Name', 'required');
          $this->form_validation->set_rules('regularPrice', 'Regular price', 'required|numeric|greater_than[0]');
          $this->form_validation->set_rules('offerPrice', 'Offer Price', 'numeric|required|greater_than[0]');
         
        if ($this->form_validation->run() == FALSE) {
           
            $this->session->set_flashdata('error', validation_errors());
           redirect('item/edit/'.$id);
            // $this->load->view('myform');
        } else {
            $regularPrice=$_POST['regularPrice'];
            $offerPrice=$_POST['offerPrice'];
            if($regularPrice < $offerPrice){
                //echo 'hii';die;
                $this->session->set_flashdata('error','Offer price should less than regular price');
               // print_r($this->session->flashdata('error'));die;
                redirect('item/edit/'.$id);
            }
            ($this->item->edit_item_process($id));
            
            $this->session->set_flashdata("success",'Item Update Successfully!!!');
            redirect('item/edit/'.$id);
        }
              
        }
        
         public function getChildCat()
        {
          $id=$_POST['catid'];
          $subId=$_POST['subId'];
          $this->db->where('parentId',$id);
          $res= $this->db->get('category')->result();
        // echo json_encode($res);
          $selected="";
          foreach($res as $cat)
          {
              if($cat->categoryId==$subId)
              {
                  $selected="selected";
              }
             echo "<option value='$cat->categoryId' $selected >".$cat->name."</option>";
             $selected="";
          }
          
        }
          public function delete_item_variation()
        {
            
            $varId=$_POST['id'];
            $where=array('variationId'=>$varId);
            $this->db->where($where);
            $this->db->delete('variations');
            echo json_encode("success");
        }
         public function delete()
        {
              
            $id=$_POST['id'];
            $this->db->where('itemId',$id);
            $this->db->delete('items');
            $this->db->where('itemId',$id);
            $this->db->delete('variations');
            echo json_encode('success');
        }
         public function delete_image()
    {
        $id=$_POST['id'];
        $this->db->where('imageId',$id);
        $this->db->delete('item_images');
         echo json_encode("success");
    }
     public function delete_more_item() {
        $mId = $_POST['id'];
        $where = array('mItemId' => $mId);
        $this->db->where($where);
        $this->db->delete('moreitems');
        echo json_encode("success");
    }
}   