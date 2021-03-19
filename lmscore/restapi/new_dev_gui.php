<?php

/* 
  @author: Suniti Yadav 
  description : Its for SSO "Portal" to "LMS" secured login with guid code.
  // Entry in "learn -> manage_moodle_path -> mdl_manage_url_calls" DB is complusion.

*/

require_once '../config.php';
global $CFG;

$key = hex2bin("6908c94c380ff92ce183a81dd945aec4");
$iv  = hex2bin("d8af5ae01bc99ba9f476e9a72f0803a5");

$default_url = "https://clientuat.zinghr.com/2015/pages/authentication/login.aspx";
// $default_url = "https://portal.zinghr.com/2015/pages/authentication/login.aspx";
$encrypted   = $_REQUEST['code'];

function decrypt($ciphertext) {
    global $key,$iv;
    $method = "AES-128-CBC";

    return openssl_decrypt($ciphertext, $method, $key, OPENSSL_RAW_DATA, $iv);
}

$decrypted = decrypt(base64_decode($encrypted)); 
$response  = json_decode($decrypted);
//print_r($response); exit();

$emp_decrypted_cd   = $response->employee_code;
$cmp_decrypted_cd   = $response->company_code;
$guid_decrypted_cd  = $response->guid; 

if(!empty($emp_decrypted_cd) && !empty($cmp_decrypted_cd) && !empty($guid_decrypted_cd)){ 

      $sql = "SELECT u.firstaccess,u.id as user_id,t.token,u.deleted,u.username FROM mdl_user as u 
      left join mdl_external_tokens as t on u.id = t.userid 
      WHERE u.company_code= ? and u.employee_code= ? and u.deleted = 0 ";

      $query_fetch_user = $DB->get_record_sql($sql, array('company_code' => $cmp_decrypted_cd ,'employee_code' => $emp_decrypted_cd));
      //print_r($query_fetch_user); exit();

      if(!empty($query_fetch_user))
      {
          //$firstaccess = $query_fetch_user->firstaccess;
          $userid      = $query_fetch_user->user_id;
          $token       = $query_fetch_user->token;
          $username    = $query_fetch_user->username;

          // Check if gui code already exist or not.
          $query_fetch_sess = $DB->get_record_sql("SELECT * FROM `mdl_sessions` WHERE userid = ? and gui_code = ? order by id desc", array('userid' => $userid ,'gui_code' => $guid_decrypted_cd));

          if(empty($query_fetch_sess))
          {
              //login then insert gui code
              if(empty($token) && $token == null)
              {
                  $ch = curl_init();  
                  curl_setopt($ch,CURLOPT_URL,$CFG->wwwroot."/login/token.php?username=".$username."&password=Test@123&service=moodle_mobile_app");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                  $output=curl_exec($ch);
                  $result = json_decode($output, true);
              }

              $user = $DB->get_record_sql("SELECT * FROM mdl_user WHERE id = '$userid' ");
              if(complete_user_login($user))
              {
                  $query_fetch_sess1 = $DB->get_record_sql("SELECT * FROM `mdl_sessions` WHERE userid = ? order by id desc", array('userid' => $userid));
                  $DB->execute("update mdl_sessions set gui_code = ? where id = ?", array('gui_code' => $guid_decrypted_cd, 'id' => $query_fetch_sess1->id));

                  header('Location: '.$CFG->wwwroot);
                  $message = "login";
              }
              else
              {
                  $message = "Not able to login";
              }
          }
          else
          {
              // redirect to portal login page
              header('Location: '.$default_url);
          }

      }
      else
      {
        echo $data = json_encode(['Message'=>'Invalid Api Token']);
      }
      
}else{
    echo $data = json_encode(['Message'=>'Parameters are missing']);
}

?>
        