<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
    
    
    public function getAllOrders()
    {
        $where="";
        $condition=[];
        if(!empty($_GET))
        {
           if(isset($_GET['status'])||isset($_GET['to'])||isset($_GET['from'])||isset($_GET['driver_status']))
           {
                  $where=" where ";
           }
            if(isset($_GET['status']))
            {
                 $status=$_GET['status'];
                 $condition[]="status=$status";
               
               // $where.="status=$status";
            }
            if(isset($_GET['payment_method']))
            {
                 $pm=$_GET['payment_method'];
                 $condition[]="payment_method='$pm'";
               
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
        if(isset($_GET['store']))
        {
            $storeId=$_GET['store'];
            $condition[]=" store.storeId=$storeId";
            }
            if($condition){
            $where.= implode(' and ',$condition);}
        }
        
        $sql="select orders.orderId,users.fullName as user_name,store.name as store_name,orders.totalCount,orders.totalPrice,orders.promo_code,CASE
    WHEN status = 0 THEN 'Pending'
    WHEN status = 2 THEN 'Processing'
    WHEN status = 3 THEN 'Canceled'
    WHEN status = 4 THEN 'Ready'
    WHEN status = 5 THEN 'Accept'
    WHEN status = 6 THEN 'Reject'
    WHEN status = 7 THEN 'Pickup'
    ELSE 'Completed' 
    END AS status,CASE
    WHEN payment_status = 0 THEN 'Pending'
    WHEN payment_status = 2 THEN 'Refunded'
    ELSE 'Completed' 
    END AS payment_status,orders.payment_method,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId $where order by orders.orderId desc";
        $_SESSION['export_query']=$sql;
       return $this->db->query("select orders.orderId,store.name as store_name,users.fullName as user_name,users.userId,address.address,orders.totalCount,orders.description,orders.status,orders.payment_method,orders.payment_status,orders.promo_code,orders.totalPrice,orders.createdOn from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId $where order by orders.orderId desc")->result();
    }
    public function getOrderById($orderId)
    {
        $tax=0;
        $sql="select orders.orderId,orders.deliveryBoyId,store.name as store_name,store.address as store_address,store.contactNumber,users.fullName as user_name,users.phone ,orders.payment_method,users.email as user_email,users.userId,address.address,orders.totalCount,orders.description,orders.delivery_fee,orders.service_tax,orders.payment_status,users.email,orders.status,orders.totalPrice,orders.createdOn,orders.promo_code,orders.promo_code_type,orders.promo_code_value,orders.payment_method from orders join users on users.userId=orders.userId join address on address.addressId=orders.deliveryAddressId join store on store.storeId=orders.storeId where orders.orderId='$orderId'";
        $order=$this->db->query($sql)->row();
        if($order){
        $order->order_items=$this->db->query("select items.itemId,order_items.price,order_items.offerPrice,items.name as item_name,order_items.notes as notes,order_items.variation,order_items.tax from order_items join items on items.itemId=order_items.itemId where order_items.orderId=$orderId")->result();
        if($order->order_items)
        {
            foreach($order->order_items as $key=>$row)
            {
               $itemid= $row->itemId;
               $variationId=$row->variation;
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
               if($variationId)
               {
               $order->order_items[$key]->variation=$this->db->query("select * from variations where variationId=$variationId")->row();
               }
            }
        }
        }
        $order->total_tax=$tax;
      // echo"<pre>"; print_r($order);die;
        return $order;
        
    }
    public function getAllDeliveryBoys($orderId)
    {
        $store_lat_long=$this->db->query("select store.latitude,store.longitude from orders join store on store.storeId=orders.storeId where orders.orderId='$orderId'")->row();
        $store_lat=$store_lat_long->latitude;
        $store_long=$store_lat_long->longitude;
       return  $this->db->query("select *,(6371 * 2 * ASIN(SQRT( POWER(SIN(( $store_lat - s.latitude) *  pi()/180 / 2), 2) +COS( $store_lat * pi()/180) * COS(s.latitude * pi()/180) * POWER(SIN(( $store_long - s.longitude) * pi()/180 / 2), 2) ))) as distance from deliveryboy as s order by distance ASC")->result();
       // return $this->db->get("deliveryboy")->result();
    }
    public function get_earnings()
    {
         $condition=array();
         $where='';
        $query="select orderId,totalPrice,delivery_fee,CASE
    WHEN commission_type = 1 THEN 'Per Order Flat'
    WHEN commission_type = 2 THEN 'Per Order %'
    WHEN commission_type = 3 THEN 'Per Item Flat'
    ELSE '-'
    END AS commission_type,commission_rate,admin_commission,store_earning,admin_earning from orders where ";
//         if(isset($_GET['commission_type'])||isset($_GET['to'])||isset($_GET['from']))
//           {
//                  //$where=" where ";
//           }
       $condition[]='status=1';
        if( isset($_GET['to'])&& isset($_GET['from']) && $_GET['to']!='' && $_GET['from'])
        {
             $to=$_GET['to'];
                $from=$_GET['from'];
            $condition[]=" cast(createdOn as date) between ' $from' and ' $to'";

        }
        if(isset($_GET['commission_type']))
        {
            $commission_type=$_GET['commission_type'];
            $condition[]="commission_type=$commission_type";
        }
        if($condition){
        $where.= implode(' and ',$condition);}
        $query.=$where;
        $query.=" order by orderId desc";
        //print_r($query);die;
        $_SESSION['export_query']=$query;
        return $this->db->query($query)->result();
    }
    public function get_earning_stats()
    {
        $total_earnings=$this->db->query("select COALESCE(sum(admin_earning),0) as total_earning from orders where status=1")->row();
        $today_earnings=$this->db->query("SELECT COALESCE(sum(admin_earning),0) as daily_earning FROM orders WHERE CAST(createdOn AS DATE) = '".date('Y-m-d')."' and status=1")->row();
        //print_r(DATE(NOW()));die;
        $monthly_earnings=$this->db->query("SELECT COALESCE(sum(admin_earning),0) as monthly_earning  FROM orders WHERE DATE(createdOn) >= '".date('Y-m-d')."' - INTERVAL 30 DAY and DATE(createdOn)< '".date('Y-m-d')."' and status=1")->row();
        $weekly_earnings=$this->db->query("SELECT COALESCE(sum(admin_earning),0) as weekly_earning  FROM orders WHERE DATE(createdOn) >= '".date('Y-m-d')."' - INTERVAL 7 DAY and DATE(createdOn)< '".date('Y-m-d')."' and status=1")->row();
        //print_r($this->db->last_query());die;
      //  $monthly_earnings=$this->db->query("SELECT COALESCE(sum(admin_earning),0) as monthly_earning  FROM orders WHERE DATE(createdOn)  >= DATEADD(day,-30, getdate()) 
//and   DATE(createdOn)  <= getdate()")->row();
        return array($total_earnings,$monthly_earnings,$today_earnings,$weekly_earnings);
    }
    public function get_payments()
    {
          return $this->db->query("select *,orders.createdOn as date ,CASE
    WHEN admin_payment_status = 0 THEN 'Pending'
    ELSE 'Completed' 
    END AS admin_payment_status from orders left join store on orders.storeId=store.storeId where orders.status=1 order by orderId desc")->result();
    }
    public function get_driver_payments()
    {
          return $this->db->query("select *,CASE
    WHEN driver_payment_status = 0 THEN 'Pending'
    ELSE 'Completed' 
    END AS driver_payment_status,orders.createdOn as order_date from orders left join deliveryboy on orders.deliveryBoyId=deliveryboy.boyId where orders.status=1 order by orderId desc")->result();
    }
    public function get_payments_stats()
    {
      $pending=  $this->db->query("select COALESCE(count(orderId),0) as pending  from orders where admin_payment_status=0 and status=1")->row();
      $completed=  $this->db->query("select COALESCE(count(orderId),0) as complete  from orders where admin_payment_status=1 and status=1")->row();
      return array($pending,$completed);
    }
    public function get_driver_payments_stats()
    {
        $pending=  $this->db->query("select COALESCE(count(orderId),0) as pending  from orders where driver_payment_status=0 and status=1")->row();
      $completed=  $this->db->query("select COALESCE(count(orderId),0) as complete  from orders where driver_payment_status=1 and status=1")->row();
      return array($pending,$completed);
    }

    public function get_payment_by_id($id)
    {
         return $this->db->query("select *,CASE
    WHEN admin_payment_status = 0 THEN 'Pending'
    ELSE 'Completed' 
    END AS admin_payment_status from orders left join store on orders.storeId=store.storeId where orders.orderId=$id order by orderId desc")->row();
        // print_r()
    }
    public function get_driver_payment_by_id($id)
    {
         return $this->db->query("select *,CASE
    WHEN driver_payment_status = 0 THEN 'Pending'
    ELSE 'Completed' 
    END AS driver_payment_status from orders left join deliveryboy on orders.deliveryBoyId=deliveryboy.boyId where orders.orderId=$id order by orderId desc")->row();
    }
     public function get_reviews()
    {
          return $this->db->query("SELECT r.itemReviewId,r.orderID,r.userID, AVG(r.rating) AS total_rating,u.fullName FROM item_reviews r LEFT JOIN users u ON u.userId=r.userID GROUP BY r.orderID")->result();
    }
    public function get_order_reviews($oid)
    {
          return $this->db->query("SELECT r.*,u.fullName FROM item_reviews r LEFT JOIN users u ON u.userId=r.userID where r.orderID=$oid")->result();
    }
    public function edit_review($review_id)
	{
		
	$user_data=array('rating'=>$_POST['rating'],'review'=>$_POST['review'], 'is_active'=>$_POST['status']);
	  $this->db->where('itemReviewId',$review_id);
	  $this->db->update('item_reviews',$user_data);
	  return true;
    }
    public function getReviewByID($id)
    {
         $data= $this->db->query("select * from item_reviews where itemReviewId=$id")->result();
    
       if($data)
       {
          return $data;
       }
       else{
           return false;
       }
    }
}
