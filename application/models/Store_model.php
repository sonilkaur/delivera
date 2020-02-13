<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Store_model extends CI_Model {

    public function get_stores() {
        //echo"<pre>";   
        $res = $this->db->query('select * from store order by storeId desc ')->result();
        if ($res) {
            foreach ($res as $key => $store) {
                $id = $store->storeId;
                // print_r($id);
                $cat = $this->db->query("select storeCatRelationId,storeCategoryId,name from store_category_relation  join category on category.categoryId=store_category_relation.storeCategoryId where store_category_relation.storeId=$id ")->result();
                //print_r($cat);
                $res[$key]->category = $cat;
            }
        }

        // print_r(json_encode($res));
        // die();
        //  return $this->db->query('select * from store left join store_category on store.storeCategoryId=store_category.storeCatId')->result();
        return $res;
    }

    public function add_store() {
        /* check if email already  exist */
        $email = $this->input->post('email');

        $data = $this->db->query("select * from store where email='$email'")->row();
       // print_r($data);die;
        if (!empty($data)) {
            return 0;
          
        }
        $image_name = '';
        // print"<pre>";
        // print_r($_FILES);die;
        if ($_FILES['image']['name']) {

            /* upload file if exist */
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg';

            $this->load->library('upload', $config);
            $image_name = '';

            if (!$this->upload->do_upload('image')) {
                $error['info'] = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('store/add');
                //$this->load->view('add_restaurant', $error);
            } else {
                $data['info'] = array('upload_data' => $this->upload->data());
                $image_name = "uploads/" . $data['info']['upload_data']['file_name'];

                // $this->load->view('add_restaurant', $data);
            }
        }
         $digits = 4;
                //echo 'hee';die;
                $activation_code = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
                
        $data = array('name' => $_POST['name'], 'address' => $_POST['address'], 'latitude' => $_POST['latitude'], 'longitude' => $_POST['longitude'], 'email' => $email, 'cuisine' => isset($_POST['cuisine']) ? $_POST['cuisine'] : "", 'activation_code'=>$activation_code,'description' => $_POST['description'], 'password' => md5($this->input->post('password')), 'logo' => $image_name, 'contactNumber' => $_POST['contactNumber'], 'contactNumberOthers' => $_POST['contactNumberOthers'], 'contactEmail' => $_POST['contactEmail'], 'deliveryTime' => $_POST['deliveryTime'],  'minimumOrder' => $_POST['minOrder'],'commission_type'=>$_POST['commission_type'],'commission'=>$_POST['commission']);
        $this->db->insert('store', $data);
        $store_id = $this->db->insert_id();

        if (isset($_POST['store_category'])) {
            // print_r($_POST['store_category']);
            $array = $_POST['store_category'];
            $data = array();
            for ($i = 0; $i < count($array); $i++) {
                $key = key($array);
                $val = $array[$key];
                $data[$i]['storeId'] = $store_id;
                $data[$i]['storeCategoryId'] = $val;
                next($array);
            }
            // echo"<pre>";
            //print_r($data);die;
            //$data=(object)$data;
            $this->db->insert_batch('store_category_relation', $data);
        }
         if (isset($_POST['sub_category'])) {
            // print_r($_POST['store_category']);
            $array = $_POST['sub_category'];
            $data = array();
            for ($i = 0; $i < count($array); $i++) {
                $key = key($array);
                $val = $array[$key];
                $data[$i]['storeId'] = $store_id;
                $data[$i]['sub_category_id'] = $val;
                next($array);
            }
            // echo"<pre>";
            //print_r($data);die;
            //$data=(object)$data;
            $this->db->insert_batch('store_sub_category', $data);
        }
        

        return true;
    }

    public function getStoreById($id) {
        $res = $this->db->query("select * from store where storeId='$id'")->result();
        if ($res) {
            foreach ($res as $key => $store) {
                $id = $store->storeId;
                // print_r($id);
                $cat = $this->db->query("select storeCatRelationId,storeCategoryId,category.categoryId,name from store_category_relation  join category on category.categoryId=store_category_relation.storeCategoryId where store_category_relation.storeId=$id")->result();
                //print_r($cat);
              
                foreach($cat as $cat_key=>$row)
                {
                    $cat[$cat_key]->subcategory=$this->db->query("select store_sub_category_id,sub_category_id,name from store_sub_category  join category on category.categoryId=store_sub_category.sub_category_id where store_sub_category.storeId=$id and category.parentId='$row->categoryId'")->result();
                }
                  $res[$key]->category = $cat;
                
            }
        }
        
        return $res;
    }

    public function edit_process($id) {
//print_r($_POST['sub_category']);die;
        if ($_FILES['image']['name']) {
            /* upload file if exist */
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg|';

            $this->load->library('upload', $config);
            $image_name = '';
            //print_r($this->upload->do_upload());die;
            if (!$this->upload->do_upload('image')) {
                // print_r($this->upload->display_errors());die;
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect('store/edit/' . $id);
            } else {
                $data['info'] = array('upload_data' => $this->upload->data());
                $image_name = "uploads/" . $data['info']['upload_data']['file_name'];
                $this->db->query("update store set logo='$image_name' where storeId='$id'");
                // $this->load->view('add_restaurant', $data);
            }
        }
        if (!empty($_POST['old_password'])) {
            $old_pass = md5($_POST['old_password']);
            $data = $this->db->query("select * from store where storeId='$id' and password='$old_pass'")->result();
            //print_r($data);die;
            if (!empty($data)) {
                if (!empty($_POST['new_password'])) {
                    $new_pass = md5($_POST['new_password']);
                    $this->db->query('update store set password="' . $new_pass . '" where storeId="' . $id . '"');
                } else {
                    $this->session->set_flashdata('error', 'Please Enter new password');
                    redirect('store/edit/' . $id);
                }
            } else {
                $this->session->set_flashdata('error', 'Old Password doesnot Correct');
                redirect('store/edit/' . $id);
            }
        }


        $user_data = array('name' => $_POST['name'], 'cuisine' => isset($_POST['cuisine']) ? $_POST['cuisine'] : "", 'description' => $_POST['description'], 'email' => $_POST['email'], 'address' => $_POST['address'], 'latitude' => $_POST['latitude'], 'longitude' => $_POST['longitude'], 'contactNumber' => $_POST['contactNumber'], 'contactNumberOthers' => $_POST['contactNumberOthers'], 'contactEmail' => $_POST['contactEmail'], 'deliveryTime' => $_POST['deliveryTime'], 'minimumOrder' => $_POST['minOrder'],'commission_type'=>$_POST['commission_type'],'commission'=>$_POST['commission']);
        $this->db->where('storeId', $id);
        $this->db->update('store', $user_data);
        $store_id = $id;
        if (isset($_POST['store_category'])) {
            //print_r($_POST['store_category']);die;
            /* Delete relation that already exist */
            $this->db->where('storeId', $id);
            $this->db->delete('store_category_relation');

            //  print_r($_POST['store_category']);
            $array = $_POST['store_category'];
            $data = array();
            for ($i = 0; $i < count($array); $i++) {
                $key = key($array);
                $val = $array[$key];
                $data[$i]['storeId'] = $store_id;
                $data[$i]['storeCategoryId'] = $val;
                next($array);
            }
            // echo"<pre>";
            // print_r($data);die;
            // $data=(object)$data;
            $this->db->insert_batch('store_category_relation', $data);
        }
        
        if (isset($_POST['sub_category'])) {
            //print_r($_POST['store_category']);die;
            /* Delete relation that already exist */
            $this->db->where('storeId', $id);
            $this->db->delete('store_sub_category');

            //  print_r($_POST['store_category']);
            $array = $_POST['sub_category'];
            $data = array();
            for ($i = 0; $i < count($array); $i++) {
                $key = key($array);
                $val = $array[$key];
                $data[$i]['storeId'] = $store_id;
                $data[$i]['sub_category_id'] = $val;
                next($array);
            }
            // echo"<pre>";
            // print_r($data);die;
            // $data=(object)$data;
            $this->db->insert_batch('store_sub_category', $data);
        }
        return true;
    }

    public function getAllStoreCategories() {
//        $this->db->where('parentId', 0);
//        return $this->db->get('category')->result();
        
        $data=$this->db->query("select * from category where parentId=0")->result();
        foreach($data as $key=>$row)
        {
            $data[$key]->sub_categories=  $this->db->query("select * from category where parentId=$row->categoryId")->result();
        }
        return $data;
    }

}
