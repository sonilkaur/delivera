<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {
    
    public function get_items()
    {
       return  $this->db->query("select items.itemId,items.name,items.regularPrice,items.offerPrice,items.featuredImage,category.name as catName,store.storeId,store.name as storename,store.contactEmail,store.contactNumber from items join category on items.categoryId=category.categoryId join store on items.storeId=store.storeId  order by items.itemId desc")->result();
    }
     public function getParentcat($sellerId)
    {
          return $this->db->query("select * from store_category_relation join category on category.categoryId=store_category_relation.storeCategoryId where store_category_relation.storeId=$sellerId")->result();
        //$this->db->where('parentId',0);
       // return $this->db->get('category')->result();
    }
    public function getItemById($id)
    {
         $data= $this->db->query("select items.itemId,items.name,items.is_active,items.categoryId,items.description,items.regularPrice,items.offerPrice,items.subCatId,items.sub_subCatId,items.featuredImage,store.storeId,store.name as storename,store.contactEmail,store.contactNumber from items join store on items.storeId=store.storeId    where items.itemId='$id'")->result();
       $data[0]->variations=array();
       $data[0]->more_items=array();
       if($data)
       {
          $moreItems=$this->db->query("select * from moreitems where itemId='$id'")->result();
          if($moreItems)
          {
              foreach($data as $item)
              {
                  $data[0]->more_items=$moreItems;
              }
          }
          $variations=$this->db->query("select * from variations where itemId='$id'")->result();
          if($variations)
          {
              foreach($data as $item)
              {
                  $data[0]->variations=$variations;
              }
          }
           $gallery_images=$this->db->query("select * from item_images where itemId='$id'")->result();
             if ($gallery_images) {
                foreach ($data as $item) {
                    $data[0]->gallery = $gallery_images;
                }
            }
          return $data;
       }
       else{
           return false;
       }
    }
   public function edit_item_process($id) {

      // echo '<pre>';print_r($_POST);die;
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $this->load->library('upload', $config);
        $image_name = '';

        if (!$this->upload->do_upload('image')) {
            $error['info'] = array('error' => $this->upload->display_errors());
            //  print_r($error);die;
        } else {
            $data['info'] = array('upload_data' => $this->upload->data());
            $image_name = "uploads/" . $data['info']['upload_data']['file_name'];
            $this->db->query("update items set featuredImage='$image_name' where itemId='$id'");
            // $this->load->view('add_restaurant', $data);
        }
        $subcat = $this->db->query("select * from items where itemId='$id'")->result();
        $subcatId = $subcat[0]->subCatId;
        $data = array(
            'categoryId' => $_POST['categoryId'],
            'subCatId' => isset($_POST['sub_cat']) ? $_POST['sub_cat'] : $subcatId,
            'name' => $_POST['name'],
            'is_active' => $_POST['status'],
            'description' => $_POST['description'],
            'regularPrice' => $_POST['regularPrice'],
            'offerPrice' => $_POST['offerPrice']
           
                //'extraItems'=>$_POST['extraItems']
        );
        $this->db->where('itemId', $id);
        $this->db->update('items', $data);
        
           // If file upload form submitted
       // print_r($_FILES['files']['name']);die;
        
        if(!empty($_FILES['files']['name'])){
            $filesCount = count($_FILES['files']['name']);
            for($i = 0; $i < $filesCount; $i++){
                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error']     = $_FILES['files']['error'][$i];
                $_FILES['file']['size']     = $_FILES['files']['size'][$i];
               //echo"<pre>";  print_r($_FILES);
                // File upload configuration
                $uploadPath = './uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';
                
                // Load and initialize upload library
                $this->load->library('upload', $config);
             $this->upload->initialize($config); 
                
                // Upload file to server
//                print_r($this->upload->do_upload('file'));
//                print_r($this->upload->display_errors());die;
                if($this->upload->do_upload('file')){
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['image'] = "uploads/". $fileData['file_name'];
                    $uploadData[$i]['itemId'] = $id;
                }
            }
            
            if(!empty($uploadData)){
                // Insert files data into the database
               // $insert = $this->file->insert($uploadData);
                   $insert = $this->db->insert_batch('item_images',$uploadData);
                
                // Upload status message
                $statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg',$statusMsg);
            }
        }
        
         if (!empty($_POST['item_count'])) {
            $i = 0;
            foreach ($_POST['item_count'] as $item_count) {

                $data = array();
                $itemId = isset($_POST['item_id'][$i])?$_POST['item_id'][$i]:"";
                $data['itemId'] = $id;
                $data['name'] = $_POST['item'][$i];
                $data['price'] = $_POST['price'][$i];
                
                 if (!empty($itemId)) {
                    // $itemId = isset($_POST['item_id'][$i]);
                    $this->db->where('mItemId',  $itemId);
                    $this->db->update('moreitems', $data);
                } else {
                    $data['itemId'] = $id;
                    //$this->db->where('variationId',$var_id);
                    $this->db->insert('moreitems', $data);
                }

                $i++; 
                // print_r($data);
               // $this->db->insert('moreitems', $data);
            }
        }

        if (!empty($_POST['count'])) {
            $i = 0;
            foreach ($_POST['count'] as $row_count) {

                $data = array();
                $varId = isset($_POST['var_id'][$i])?$_POST['var_id'][$i]:"";
                $data['options'] = $_POST['options'][$i];
                $data['regularPrice'] = $_POST['reg_price'][$i];
                $data['offerPrice'] = $_POST['off_price'][$i];

                //$this->db->where('variationId',$var_id);
                // $varExist=$this->db->get('variations')->row();
                if (!empty($varId)) {
                    $this->db->where('variationId', $varId);
                    $this->db->update('variations', $data);
                } else {
                    $data['itemId'] = $id;
                    //$this->db->where('variationId',$var_id);
                    $this->db->insert('variations', $data);
                }

                $i++;
                // print_r($data);
                // $this->db->insert('variations',$data);
            }
        }

        return true;
    }

}