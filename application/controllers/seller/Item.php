<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('seller/Item_model', 'item');
        //print_r($_SESSION);die;
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        // Your own constructor code
    }

    public function index() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $data['result'] = $this->item->getAllItems();
        $this->load->view('seller/header');
        $this->load->view('seller/item_listing', $data);
        $this->load->view('seller/footer');
    }

    public function addItem() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        //print_r($_SESSION);die;
        $sellerId = $_SESSION['sellerid'];
        $data['cat'] = $this->item->getParentcat($sellerId);
        $data['tax'] = $this->item->getTax($sellerId);
        $this->load->view('seller/header');
        $this->load->view('seller/add_item', $data);
        $this->load->view('seller/footer');
    }

    public function getChildCat() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $id = $_POST['catid'];
        $this->db->where('parentId', $id);
        $res = $this->db->get('category')->result();
        $subId = isset($_POST['subId']) ? $_POST['subId'] : "";
        $selected = "";
        // echo json_encode($res);

        foreach ($res as $cat) {
            if ($cat->categoryId == $subId) {
                $selected = "selected";
            }
            echo "<option value='$cat->categoryId' $selected>" . $cat->name . "</option>";
            $selected = "";
        }
    }

    public function add_process() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        
//echo'<pre>';print_r($_POST);
//$iZero = array_values($_POST['group_name']);
//$array=array_map('array_values', $iZero);
//print_r($array);
////$iOne = array_combine(range(1, count($_POST['group_name'])), array_values(['group_name']));
//print_r($iZero);
//die;

        $this->form_validation->set_rules('name', 'Item name', 'trim|required');
        // $this->form_validation->set_rules('regularPrice', 'Regular price', 'trim|required|');
        // $this->form_validation->set_rules('offerPrice', 'Offer Price', 'trim|required|');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('seller/item/addItem');
        } else {
            $regularPrice = $_POST['regularPrice'];
            $offerPrice = $_POST['offerPrice'];
            if ($regularPrice < $offerPrice) {
                $this->session->set_flashdata("error", 'Offer price should less than regular price');
                redirect('seller/item/addItem');
            }
            $data = $this->item->add_item();
            if ($data = true) {
                $this->session->set_flashdata('success', 'item added successfully');
                redirect('seller/item/addItem');
            }
        }
//        $data = $this->item->add_item();
//        if ($data = true) {
//            $this->session->set_flashdata('success', 'item added successfully');
//            redirect('seller/item/addItem');
//        }
    }

    public function edit($id) {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $sellerId = $_SESSION['sellerid'];
        $data['cat'] = $this->item->getParentcat($sellerId);
        $data['result'] = $this->item->getItemByID($id);
        $data['tax'] = $this->item->getTax($sellerId);
       // echo '<pre>';
       // print_r($data['result']);die;
        if ($data['result'] != false) {
            $this->load->view('seller/header');
            $this->load->view('seller/edit_item', $data);
            $this->load->view('seller/footer');
        }
    }
    

    public function edit_process($id) {
        
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        //echo "<pre>"; print_r($_POST);die;
//echo'<pre>';print_r($_POST['group_name']);
//$iZero = array_values($_POST['group_name']);
//$array=array_map('array_values', $iZero);
////print_r($array);
////$iOne = array_combine(range(1, count($_POST['group_name'])), array_values(['group_name']));
//print_r($array);
//die;
        $this->form_validation->set_rules('name', 'Item Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors()); 
            redirect('seller/item/edit/' . $id);
        } else {
  $regularPrice=$_POST['regularPrice'];
            $offerPrice=$_POST['offerPrice'];
            if($regularPrice < $offerPrice){
               // echo 'hii';die;
                $this->session->set_flashdata('error','Offer price should less than regular price');
                redirect('seller/item/edit/' . $id);
            }
           // $data = $this->item->add_item();
           // if ($data = true) {
                $this->item->edit_item_process($id);
                $this->session->set_flashdata("success", 'Item Update Successfully!!!');
                redirect('seller/item/edit/' . $id);
           // }
        }

    }

    public function delete() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $id = $_POST['id'];
        $this->db->where('itemId', $id);
        $this->db->delete('items');
        $this->db->where('itemId', $id);
        $this->db->delete('variations');
        echo json_encode('success');
    }

    public function delete_item_variation() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $varId = $_POST['id'];
        $where = array('variationId' => $varId);
        $this->db->where($where);
        $this->db->delete('variations');
        echo json_encode("success");
    }

    public function delete_more_item() {
        $mId = $_POST['id'];
        $where = array('mItemId' => $mId);
        $this->db->where($where);
        $this->db->delete('moreitems');
        echo json_encode("success");
    }

    public function delete_image() {
        $id = $_POST['id'];
        $this->db->where('imageId', $id);
        $this->db->delete('item_images');
        echo json_encode("success");
    }
    public function add_attributes(){
         if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
       
        $this->load->view('seller/header');
        $this->load->view('seller/add_attributes');
        $this->load->view('seller/footer');
    }

    public function tax() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $sellerId = $_SESSION['sellerid'];
        $data['result'] = $this->item->get_taxes_by_store($sellerId);
        $this->load->view('seller/header');
        $this->load->view('seller/tax_listing', $data);
        $this->load->view('seller/footer');
    }

    public function add_tax() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $sellerId = $_SESSION['sellerid'];

        $this->load->view('seller/header');
        $this->load->view('seller/add_tax');
        $this->load->view('seller/footer');
    }

    public function add_tax_process() {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $this->form_validation->set_rules('name', 'Tax Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("seller/item/add_tax");
        } else {
            $sellerId = $_SESSION['sellerid'];
            $data['result'] = $this->item->insert_tax($sellerId);
            $this->session->set_flashdata("success", 'Tax Add Successfully!!!');
            redirect("seller/item/add_tax");
        }
//         $sellerId=$_SESSION['sellerid'];
//          $data['result'] = $this->item->insert_tax($sellerId);
//          $this->session->set_flashdata("success", 'Tax Add Successfully!!!');
//          redirect("seller/item/add_tax");   
    }

    public function edit_tax($id) {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }
        $sellerId = $_SESSION['sellerid'];
        $data['result'] = $this->item->get_tax_by_id($id, $sellerId);
        // print_r($data);die;
        $this->load->view('seller/header');
        $this->load->view('seller/edit_tax', $data);
        $this->load->view('seller/footer');
    }

    public function edit_tax_process($id) {
        if (!isset($_SESSION['selleremail'])) {
            redirect('seller/home/');
        }


        $this->form_validation->set_rules('name', 'Tax Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("seller/item/edit_tax/" . $id);
        } else {
            $sellerId = $_SESSION['sellerid'];
            $data['result'] = $this->item->update_tax($id);
            $this->session->set_flashdata("success", 'Tax Updated Successfully!!!');
            redirect("seller/item/edit_tax/" . $id);
        }
//          $sellerId=$_SESSION['sellerid'];
//          $data['result'] = $this->item->update_tax($id);
//          $this->session->set_flashdata("success", 'Tax Updated Successfully!!!');
//          redirect("seller/item/edit_tax/".$id); 
    }

    public function delete_tax() {
        $id = $_POST['id'];
        $this->db->where('taxId', $id);
        $this->db->delete('tax');
        echo json_encode("success");
    }
    public function delete_ex_item()
    {
        $id = $_POST['id'];
        $this->db->where('extra_id', $id);
        $this->db->delete('extra_items');
        echo json_encode("success");
    }
    public function delete_ex_item_group()
    {
        $id = $_POST['id'];
        $this->db->where('group_id', $id);
        $this->db->delete('extra_items');
        $this->db->where('group_id', $id);
        $this->db->delete('extra_item_group');
        echo json_encode("success");
    }

}
