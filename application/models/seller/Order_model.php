<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
    
    
    public function getOrders($sellerId)
    {
        //print_r($sellerId);
         $where="";
        $condition=[];
       
      
        if(isset($_GET['status'])||isset($_GET['to'])||isset($_GET['from'])||isset($_GET['driver_status'])|| isset($sellerId))
           {
                  $where=" where ";
           }
            if(isset($_GET['status']))
            {
                 $status=$_GET['status'];
                 $condition[]="status=$status";
                 
               // $where.="status=$status";
            }
            if(isset($_GET['assign_boy']))
            {
                // $status=$_GET['status'];
                 $condition[]="deliveryBoyId!=0";
                 
               // $where.="status=$status";
            }
           
            if(isset($_GET['driver_status']))
            {
                 $status=$_GET['driver_status'];
                 $condition[]="driver_status=$status";
            }
            if(isset($_GET['to']) && isset($_GET['from']) && $_GET['to']!='' && $_GET['from'])
        {
            $to=$_GET['to'];
            $from=$_GET['from'];
            $condition[]=" cast(orders.createdOn as date) between ' $from' and ' $to'";
        }
         $condition[]="store.storeId=$sellerId";
          //  print_r($condition);
            if($condition){
            $where.= implode(' and ',$condition);
            
            }
       
      //  print_r($where);die;
        
       return $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.payment_status,orders.status,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId $where ")->result();
    }
     public function getOrderById($orderId,$sellerId)
    {
        $tax=0;
        $sql="select orders.orderId,store.name as store_name,store.address as store_address,store.contactNumber,users.fullName as user_name,users.phone,users.email as user_email,users.userId,address.address,orders.totalCount,orders.description,orders.delivery_fee,orders.service_tax,users.email,orders.payment_status,orders.payment_method,orders.status,orders.totalPrice,orders.createdOn,orders.promo_code,orders.promo_code_type,orders.promo_code_value from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.orderId='$orderId' and store.storeId='$sellerId'";
        $order=$this->db->query($sql)->row();
        if($order){
        $order->order_items=$this->db->query("select items.itemId,order_items.price,order_items.offerPrice,items.name as item_name,order_items.notes as notes,order_items.variation,order_items.tax from order_items join items on items.itemId=order_items.itemId where order_items.orderId=$orderId")->result();
        if($order->order_items)
        {
            foreach($order->order_items as $key=>$row)
            {
               $itemid= $row->itemId;
                 $tax+=$row->tax;
              // print_r($order->order_items[$key]->extra);
               $order->order_items[$key]->extra=$this->db->query("select * from order_items_extra join moreitems on moreitems.mItemId=order_items_extra.mItemId where order_items_extra.orderId='$orderId' and order_items_extra.itemId='$itemid'")->result();
                if( $order->order_items[$key]->extra)
               {
                   foreach ($order->order_items[$key]->extra as $row1)
                   {
                       $tax+=$row1->tax;
                   }
               }
            }
        }
        $order->delivery_boy=$this->db->query("select db.boyId,db.fullName,db.email,db.address,db.phone,db.vehicleBrandName,db.modelNumber,db.purchaseDate,db.drivingLicense,db.photo from deliveryboy as db  join orders  on orders.deliveryBoyId=db.boyId where orders.orderId='$orderId'")->result();
        }
         $order->total_tax=$tax;
      // echo"<pre>"; print_r($order);die;
        return $order;
        
    }
      public function get_promo($sellerId)
    {
        $this->db->where('createdId',$sellerId);
          $this->db->order_by("codeId", "desc");

        return $this->db->get("promo_code")->result();
    }
    public function add_promo()
    {
         $code=$_POST['code'];
       $code_exist=$this->db->query("select * from promo_code where code='$code' and expiryDate  < '".date("Y-m-d")."'")->result();
        if(!empty($code_exist))
        {
            $this->session->set_flashdata('error', 'Code already exist');
            redirect('seller/order/add_promo');
        }
        $data=array('type'=>$_POST['type'],'createdBy'=>$_POST['created_by'],'createdId'=>$_POST['sellerId'],'minOrderAmount'=>$_POST['min_order_ammount'],'code_amount'=>$_POST['code_amount'],'total_used'=>$_POST['total_used'],'code'=>$_POST['code'],'user_used'=>$_POST['user_used'],'expiryDate'=>$_POST['expiry_date'],'status'=>$_POST['status'],'start_date'=>$_POST['start_date']);
        $this->db->insert('promo_code',$data);
    }
    public function get_codeById($id)
    {
       return  $this->db->query("select * from promo_code where codeId='$id'")->row();
    }
    public function edit_promo($id)
    {
         $code=$_POST['code'];
       $code_exist=$this->db->query("select * from promo_code where code='$code' and expiryDate  < '".date("Y-m-d")."' and codeId!=$id")->result();
        if(!empty($code_exist))
        {
            $this->session->set_flashdata('error', 'Code already exist');
             redirect('seller/order/edit_promo/'.$id);
        }
       $data=array('type'=>$_POST['type'],'minOrderAmount'=>$_POST['min_order_ammount'],'code'=>$_POST['code'],'expiryDate'=>$_POST['expiry_date'],'user_used'=>$_POST['user_used'],'total_used'=>$_POST['total_used'],'status'=>$_POST['status'],'start_date'=>$_POST['start_date']);
        $this->db->where('codeId',$id);
        $this->db->update('promo_code',$data);
    }
    public function get_seller_earning($sellerId)
    {
        $where='';
         if(isset($_GET['to']) && isset($_GET['from']) && $_GET['to']!='' && $_GET['from'])
        {
             $to=$_GET['to'];
                $from=$_GET['from'];
            $where="and cast(createdOn as date) between ' $from' and ' $to'";
//            $condition=array();
//            if(isset($_GET['to']))
//            {
//                $to=$_GET['to'];
//                $condition[]="cast(createdOn as date)<=$to";
//            }
//            if(isset($_GET['from']))
//            {
//                $from=$_GET['from'];
//                $condition[]="cast(createdOn as date)>=$from";
//            }
//            $where.= implode(' and ',$condition);
             //$query.=$where;
        }
        return $this->db->query("select *,CASE
    WHEN commission_type = 1 THEN 'Per Order Flat'
    WHEN commission_type = 2 THEN 'Per Order %'
    WHEN commission_type = 3 THEN 'Per Item Flat'
    ELSE '-'
    END AS commission_type from orders where status=1 and storeId=$sellerId $where")->result();
    }
    public function get_earning_stats($id)
    {
        $total_earnings=$this->db->query("select COALESCE(sum(store_earning),0) as total_earning from orders where status=1")->row();
        $today_earnings=$this->db->query("SELECT COALESCE(sum(store_earning),0) as daily_earning FROM orders WHERE CAST(createdOn AS DATE) = '".date('Y-m-d')."' and storeId=$id and status=1")->row();
        //print_r(DATE(NOW()));die;
        $monthly_earnings=$this->db->query("SELECT COALESCE(sum(store_earning),0) as monthly_earning  FROM orders WHERE DATE(createdOn) >= '".date('Y-m-d')."' - INTERVAL 30 DAY and DATE(createdOn)< '".date('Y-m-d')."' and storeId=$id and status=1")->row();
        $weekly_earnings=$this->db->query("SELECT COALESCE(sum(store_earning),0) as weekly_earning  FROM orders WHERE DATE(createdOn) >= '".date('Y-m-d')."' - INTERVAL 7 DAY and DATE(createdOn)< '".date('Y-m-d')."' and storeId=$id and status=1")->row();
        //print_r($this->db->last_query());die;
      //  $monthly_earnings=$this->db->query("SELECT COALESCE(sum(admin_earning),0) as monthly_earning  FROM orders WHERE DATE(createdOn)  >= DATEADD(day,-30, getdate()) 
//and   DATE(createdOn)  <= getdate()")->row();
        return array($total_earnings,$monthly_earnings,$today_earnings,$weekly_earnings);
    }
}
