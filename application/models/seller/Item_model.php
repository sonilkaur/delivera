<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Item_model extends CI_Model {

    public function getParentcat($sellerId) {

        return $this->db->query("select * from store_category_relation join category on category.categoryId=store_category_relation.storeCategoryId where store_category_relation.storeId=$sellerId")->result();
        // $this->db->where('parentId', 0);
        //return $this->db->get('category')->result();
    }

    public function getTax($sellerId) {
        return $this->db->query("select * from tax where storeId='$sellerId'")->result();
    }

    public function add_item() {

        //print_r($_FILES['files']['name']) ;die;
//         if(!empty($_FILES['files']['name'])){
//            $filesCount = count($_FILES['files']['name']);
//            for($i = 0; $i < $filesCount; $i++){
//                $_FILES['file']['name']     = $_FILES['files']['name'][$i];
//                $_FILES['file']['type']     = $_FILES['files']['type'][$i];
//                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
//                $_FILES['file']['error']     = $_FILES['files']['error'][$i];
//                $_FILES['file']['size']     = $_FILES['files']['size'][$i];
//                
//                // File upload configuration
//                $uploadPath = './uploads/';
//                $config['upload_path'] = $uploadPath;
//                $config['allowed_types'] = 'jpg|jpeg|png|gif';
//                
//                // Load and initialize upload library
//                $this->load->library('upload', $config);
//               // $this->upload->initialize($config);
//              // print_r($this->upload->do_upload('file'));
//                 $error['info'] = array('error' => $this->upload->display_errors());
//            print_r($error);die;
//                
//                // Upload file to server
//                if($this->upload->do_upload('file')){
//                    // Uploaded file data
//                    $fileData = $this->upload->data();
//                    $uploadData[$i]['file_name'] = $fileData['file_name'];
//                    $uploadData[$i]['uploaded_on'] = date("Y-m-d H:i:s");
//                }
//            }
//         }

        /* upload file if exist */
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';

        $this->load->library('upload', $config);
        $image_name = '';

        if (!$this->upload->do_upload('image')) {
            $error['info'] = array('error' => $this->upload->display_errors());
            //print_r($error);die;
        } else {
            $data['info'] = array('upload_data' => $this->upload->data());
            $image_name = "uploads/" . $data['info']['upload_data']['file_name'];

            // $this->load->view('add_restaurant', $data);
        }
        // print_r($error);
        //print_r($data['info']);
        // print_r($image_name);die;
        $data = array(
            'storeId' => $_POST['storeId'],
            'categoryId' => $_POST['categoryId'],
            'subCatId' => isset($_POST['sub_cat']) ? $_POST['sub_cat'] : 0,
            'name' => $_POST['name'],
            'is_active' => $_POST['status'],
            'description' => $_POST['description'],
            'regularPrice' => $_POST['regularPrice'],
            'offerPrice' => $_POST['offerPrice'],
            'taxId' => $_POST['taxId'],
            'featuredImage' => $image_name,
            'manage_stock' => $_POST['manage_stock'],
            'stock' => $_POST['stock']
        );
        //echo"<pre>";print_r($_POST);die;
        $this->db->insert('items', $data);
        $itemId = $this->db->insert_id();

        /* insert gallery images */

        // If file upload form submitted
        if (!empty($_FILES['files']['name'])) {
            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                // File upload configuration
                $uploadPath = './uploads/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                // Upload file to server
                if ($this->upload->do_upload('file')) {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['image'] = "uploads/" . $fileData['file_name'];
                    $uploadData[$i]['itemId'] = $itemId;
                }
            }

            if (!empty($uploadData)) {
                // Insert files data into the database
                // $insert = $this->file->insert($uploadData);
                $insert = $this->db->insert_batch('item_images', $uploadData);

                // Upload status message
                $statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg', $statusMsg);
            }
        }


        if (!empty($_POST['item_count'])) {
            $i = 0;
            foreach ($_POST['item_count'] as $item_count) {

                $data = array();
                $data['itemId'] = $itemId;
                $data['name'] = $_POST['item'][$i];
                $data['price'] = $_POST['price'][$i];

                $i++;
                // print_r($data);
                $this->db->insert('moreitems', $data);
            }
        }
        // echo'<pre>';print_r($_POST);
//$iZero = array_values($_POST['group_name']);
//$array=array_map('array_values', $iZero);
//print_r($array);
//$iOne = array_combine(range(1, count($_POST['group_name'])), array_values(['group_name']));
//print_r($iZero);
//die;
        if (!empty($_POST['group_name'])) {
            $iZero = array_values($_POST['group_name']); //reindex array
            $final_array = array_map('array_values', $iZero); //reindex sub-array
            // echo'<pre>';
            // print_r($final_array);
            foreach ($final_array as $group) {
                $extra_group_id = '';
                if (!empty($group)) {
                    foreach ($group as $key => $val) {
                        if ($key == '0') {
                            $data = array('itemId' => $itemId, 'group_name' => $val);
                            $this->db->insert('extra_item_group', $data);
                            $extra_group_id = $this->db->insert_id(); // 0 index group name
                        } elseif ($key == '2') {  // 1 index max no of  select items
                            $this->db->query("update extra_item_group set max_select='$val' where group_id='$extra_group_id'");
                        } else if($key!='1') {
                            $item_name = $val['item_name'];
                            $item_price = $val['item_price'];
                            $extra = array('group_id' => $extra_group_id, 'name' => $item_name, 'price' => $item_price);
                            $this->db->insert('extra_items', $extra);
                        }
                    }
                }
                // die;
            }
        }
        if (!empty($_POST['count'])) {
            $i = 0;
            foreach ($_POST['count'] as $row_count) {

                $data = array();
                $data['itemId'] = $itemId;
                $data['options'] = $_POST['options'][$i];
                $data['regularPrice'] = $_POST['reg_price'][$i];
                $data['offerPrice'] = $_POST['off_price'][$i];
                $i++;
                // print_r($data);
                $this->db->insert('variations', $data);
            }
        }

        return true;
    }

    public function getAllItems() {
        $storeId = $_SESSION['sellerid'];
        $data = $this->db->query("select items.itemId, items.name,items.description,items.offerPrice,items.regularPrice,items.featuredImage,category.categoryId,category.name as categoryName from items join category on category.categoryId=items.categoryId where storeId='$storeId' order by items.itemId desc")->result();
        return $data;
    }

    public function getItemByID($id) {
        $data = $this->db->query("select * from items   where itemId='$id'")->result();
        $data[0]->variations = array();
        $data[0]->more_items = array();
        $data[0]->extra_items = array();
        if ($data) {
            $moreItems = $this->db->query("select * from moreitems where itemId='$id'")->result();
            if ($moreItems) {
                foreach ($data as $item) {
                    $data[0]->more_items = $moreItems;
                }
            }
            $extra_items = $this->db->query("select * from extra_item_group where itemId='$id'")->result();
            if (!empty($extra_items)) {
                foreach ($extra_items as $key => $ex_gp) {
                    $group_id = $ex_gp->group_id;
                    $extra_items[$key]->items = $this->db->query("select * from extra_items where group_id=$group_id")->result();
                }
            }
            $data[0]->extra_items = $extra_items;
            $variations = $this->db->query("select * from variations where itemId='$id'")->result();
            if ($variations) {
                foreach ($data as $item) {
                    $data[0]->variations = $variations;
                }
            }
            $gallery_images = $this->db->query("select * from item_images where itemId='$id'")->result();
            if ($gallery_images) {
                foreach ($data as $item) {
                    $data[0]->gallery = $gallery_images;
                }
            }

            return $data;
        } else {
            return false;
        }
        // echo"<pre>";print_r(json_encode($data));die;
    }

    public function edit_item_process($id) {

        //echo '<pre>';print_r($_POST);
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
            'storeId' => $_POST['storeId'],
            'categoryId' => $_POST['categoryId'],
            'subCatId' => isset($_POST['sub_cat']) ? $_POST['sub_cat'] : $subcatId,
            'name' => $_POST['name'],
            'is_active' => $_POST['status'],
            'description' => $_POST['description'],
            'regularPrice' => $_POST['regularPrice'],
            'offerPrice' => $_POST['offerPrice'],
            'taxId' => $_POST['taxId'],
            'manage_stock' => $_POST['manage_stock'],
            'stock' => $_POST['stock']
                //'extraItems'=>$_POST['extraItems']
        );
        $this->db->where('itemId', $id);
        $this->db->update('items', $data);

        // If file upload form submitted
        // print_r($_FILES['files']['name']);die;

        if (!empty($_FILES['files']['name'])) {
            $filesCount = count($_FILES['files']['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                $_FILES['file']['size'] = $_FILES['files']['size'][$i];
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
                if ($this->upload->do_upload('file')) {
                    // Uploaded file data
                    $fileData = $this->upload->data();
                    $uploadData[$i]['image'] = "uploads/" . $fileData['file_name'];
                    $uploadData[$i]['itemId'] = $id;
                }
            }

            if (!empty($uploadData)) {
                // Insert files data into the database
                // $insert = $this->file->insert($uploadData);
                $insert = $this->db->insert_batch('item_images', $uploadData);

                // Upload status message
                $statusMsg = $insert ? 'Files uploaded successfully.' : 'Some problem occurred, please try again.';
                $this->session->set_flashdata('statusMsg', $statusMsg);
            }
        }

        if (!empty($_POST['item_count'])) {
            $i = 0;
            foreach ($_POST['item_count'] as $item_count) {

                $data = array();
                $itemId = isset($_POST['item_id'][$i]) ? $_POST['item_id'][$i] : "";
                $data['itemId'] = $id;
                $data['name'] = $_POST['item'][$i];
                $data['price'] = $_POST['price'][$i];

                if (!empty($itemId)) {
                    // $itemId = isset($_POST['item_id'][$i]);
                    $this->db->where('mItemId', $itemId);
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
        if (!empty($_POST['group_name'])) {
            $iZero = array_values($_POST['group_name']); //reindex array
            $final_array = array_map('array_values', $iZero); //reindex sub-array
            //echo'<pre>';
           // print_r($final_array);die;
            foreach ($final_array as $group) {
                $extra_group_id = '';
                if (!empty($group)) {
                    foreach ($group as $key => $val) {
                        if ($key == '0') {
                            
                            $data = array('itemId' => $id, 'group_name' => $val);
                            if($group[1]!='')
                            {
                                $group_id=$group[1];
                                $this->db->where('group_id',$group_id);
                                $this->db->update('extra_item_group',$data);
                                $extra_group_id=$group_id;
                            }
                            else{
                            $this->db->insert('extra_item_group', $data);
                             $extra_group_id = $this->db->insert_id();
                            }  // 0 index group name
                            
                        } elseif ($key == '2') {  // 1 index max no of  select items
                            $this->db->query("update extra_item_group set max_select='$val' where group_id='$extra_group_id'");
                        } else if($key!=1) {
                            
                            $item_name = $val['item_name'];
                            $item_price = $val['item_price'];
                            $item_id=  isset($val['item_id'])?$val['item_id']:"";
                            $extra = array('group_id' => $extra_group_id, 'name' => $item_name, 'price' => $item_price);
                            if($item_id=="")
                            {
                            
                            $this->db->insert('extra_items', $extra);
                            }
                            else{
                                $this->db->where('extra_id',$item_id);
                                $this->db->update('extra_items',$extra);
                            }
                        }
                        else{}
                    }
                }
                // die;
            }
        }
        if (!empty($_POST['count'])) {
            $i = 0;
            foreach ($_POST['count'] as $row_count) {

                $data = array();
                $varId = isset($_POST['var_id'][$i]) ? $_POST['var_id'][$i] : "";
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

    public function get_taxes_by_store($sellerId) {
        return $this->db->query("select * from tax where storeId='$sellerId'")->result();
    }

    public function insert_tax($sellerId) {
        $data = array('storeId' => $sellerId, 'name' => $_POST['name'], 'rate' => $_POST['rate']);
        $this->db->insert('tax', $data);
    }

    public function get_tax_by_id($tax_id, $sellerId) {
        return $this->db->query("select * from tax where storeId='$sellerId' and taxId='$tax_id'")->row();
    }

    public function update_tax($id) {
        $data = array('name' => $_POST['name'], 'rate' => $_POST['rate']);
        $this->db->where('taxId', $id);
        $this->db->update('tax', $data);
    }

}
