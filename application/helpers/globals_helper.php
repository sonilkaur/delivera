<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Globals {

    public function __construct() {
        
    }
       public static function getCurrency() {
        $ci = & get_instance();
        $res = $ci->db->query("select symbol as currency from currency")->row();
        return $res->currency;
    }
     public static function send_fcm_notification($fcm_ids, $message) {
        if (empty($fcm_ids) || empty($message))
            return 0;

        $type=$message['type'];
        if($type=='1')
        {
        $json_data = [
            "to" => $fcm_ids,
             
            "notification" => [
                "body" => $message["message"],
                "title" => $message['title'],
                "icon" => "logo"
            ],
            "data" => $message
        ];
        }
        if($type=='0')
        {
            
           $json_data = [
            "registration_ids" => $fcm_ids,
             
            "notification" => [
                "body" => $message["message"],
                "title" => $message['title'],
                "icon" => "logo"
            ],
            "data" => $message
        ];  
        }
        
        


        $data = json_encode($json_data);
       // print_r($data);die;
//FCM API end-point
        $url = 'https://fcm.googleapis.com/fcm/send';
//api_key in Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key
        $server_key = FCM_API_KEY;
//header with content_type api key
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key=' . $server_key
        );
      //  print_r($headers);die;
//CURL request to route notification to FCM connection server (provided by Google)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $result = curl_exec($ch);
       // print '<pre>';
      // print_r($result);
      //  print_r(curl_error($ch));  
       // die;
        if ($result === FALSE) {
            die('Oops! FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);

        /* $fields = [
          'registration_ids' => $fcm_ids,
          'data' => $message
          ];

          $headers = [
          'Authorization: key=' . FCM_API_KEY,
          'Content-Type: application/json'
          ];

          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, FCM_URL);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
          curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
          $result = curl_exec($ch);
          print_r($result);die;
          curl_close($ch); */
    }
}