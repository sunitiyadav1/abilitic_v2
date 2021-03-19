<?php
/* 
  @author: Suniti Yadav 
  description : Existing SSO script - "Portal" to "LMS" login.
  // Entry in "learn -> manage_moodle_path -> mdl_manage_url_calls" DB is complusion.

*/
require_once '../config.php';
global $CFG;

//$emp_bundle  = "5vv7RtllliL8qGLLCrPo4A=="; // $_REQUEST['employee_code'];
//$cmp_bundle  = "8zIqRlFsvnUmU4B8gs/6Kg=="; // $_REQUEST['company_code'];

$emp_bundle  =  $_REQUEST['employee_code'];
$cmp_bundle  =  $_REQUEST['company_code'];

?>

<!DOCTYPE html>
<html>
  <head>
    <title>example</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
<script type="text/javascript">
function removeCookies() {
  var res = document.cookie;
    var multiple = res.split(";");
    for(var i = 0; i < multiple.length; i++) {
      var key = multiple[i].split("=");
        document.cookie = key[0]+" =; expires = Thu, 01 Jan 1970 00:00:00 UTC";
    }
}

function getCookie(Name) {
    var search = Name + "="
    if (document.cookie.length > 0) { // if there are any cookies 
        var offset = document.cookie.indexOf(search)
        if (offset != -1) { // if cookie exists 
            offset += search.length
            var end = document.cookie.indexOf(";", offset)
            if (end == -1) end = document.cookie.length
            return unescape(document.cookie.substring(offset, end))
        }
    }
}

var key = CryptoJS.enc.Hex.parse("0123456789abcdef0123456789abcdef");
var iv  = CryptoJS.enc.Hex.parse("abcdef9876543210abcdef9876543210");

var encrypted_emp = '<?php echo $emp_bundle; ?>' // "5vv7RtllliL8qGLLCrPo4A==";
var encrypted_cmp = '<?php echo $cmp_bundle; ?>' // "8zIqRlFsvnUmU4B8gs/6Kg==";

var decrypted_emp = CryptoJS.AES.decrypt(encrypted_emp, key, { iv: iv });
var js_var_emp    = decrypted_emp.toString(CryptoJS.enc.Utf8);

var decrypted_cmp = CryptoJS.AES.decrypt(encrypted_cmp, key, { iv: iv });
var js_var_cmp    = decrypted_cmp.toString(CryptoJS.enc.Utf8);

document.cookie = "employee_code = " + js_var_emp;
document.cookie = "company_code = " + js_var_cmp;

  console.log(document.cookie);
  if(getCookie("employee_code")!==null&&getCookie("employee_code")!==""&&getCookie("company_code")!==null&&getCookie("company_code")!==""){
    // location.reload(1);
    location.href = location.origin + location.pathname; 
  }else{
    document.write("Plese enable cookies in your browser.");
  }
</script>
   </head>
   <body>
    <?php 
    
    $emp_decrypted_cd = $_COOKIE['employee_code'];
    $cmp_decrypted_cd = $_COOKIE['company_code']; 
    // echo $emp_bundle.' empcode '.$cmp_bundle;

    if($emp_decrypted_cd != '' && $cmp_decrypted_cd != '' && empty($emp_bundle) == True && empty($cmp_bundle) == True){ 

          $sql = "SELECT u.firstaccess,u.id as user_id,t.token,u.deleted,u.username FROM mdl_user as u left join mdl_external_tokens as t on u.id = t.userid WHERE u.company_code='$cmp_decrypted_cd' and u.employee_code='$emp_decrypted_cd' and u.deleted = 0 ";
          
          $query_fetch_user = $DB->get_record_sql($sql);
          // print_r($query_fetch_user); exit();
          if(!empty($query_fetch_user))
          {
              $firstaccess = $query_fetch_user->firstaccess;
              $userid      = $query_fetch_user->user_id;
              $token       = $query_fetch_user->token;
              $username    = $query_fetch_user->username;

              if(!empty($token))
              {
                  if($firstaccess == 0){
                     
                     $up_sql = "UPDATE mdl_user SET firstaccess = '".time()."', lastaccess = '".time()."' WHERE id = ".$userid; 
                      $DB->execute($up_sql); 

                  }else{
                      
                      $up_sql = "UPDATE mdl_user SET lastaccess = '".time()."' WHERE id = ".$userid; 
                      $ans = $DB->execute($up_sql); 
                      // print_r($ans); exit();
                  }

                  // echo $data = json_encode(['Token'=>$token, 'userid'=>$userid,'username'=>$username]);
              }
              else
              {
                  $ch = curl_init();  
                  curl_setopt($ch,CURLOPT_URL,$CFG->wwwroot."/login/token.php?username=".$username."&password=Test@123&service=moodle_mobile_app");
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
                  $output=curl_exec($ch);
                  $result = json_decode($output, true);
                  //print_r($result['token']); //exit();
                  $token = $result['token'];
                  // echo $data = json_encode(['Token'=>$token, 'userid'=>$userid, 'username'=>$username]);
              }

              $user = $DB->get_record_sql("SELECT * FROM mdl_user WHERE id = '$userid' ");
              // print_r($user); exit();

              if(complete_user_login($user))
              {
                  header('Location: '.$CFG->wwwroot);
                  $returndata['Message'] = "login";
              }
              else
              {
                  $returndata['Message'] = "not login";
              }
            
              // echo $data = json_encode($returndata);

          }
          else{
             echo $data = json_encode(['Message'=>'Invalid Api Token']);
          }
          
    }else{
      echo $data = json_encode(['Message'=>'Parameters are missing']);
    }

  ?>
   </body>
 </html>
        