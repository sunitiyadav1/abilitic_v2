<?php
/* 
  @author: Suniti Yadav 
  description : To generate token for users whose token still not generated.

*/
$base = __DIR__ . '/../';
define('CLI_SCRIPT', true);
require_once $base.'../config.php';

// require_once '../../config.php';

global $CFG;
$count      = 0;
$records    = [];

$query_fetch_users = $DB->get_records_sql("SELECT DISTINCT id,username FROM mdl_user WHERE id NOT IN (SELECT DISTINCT userid FROM mdl_external_tokens) and deleted = 0 and username != 'guest'");
//print_r(count($query_fetch_users));

if(!empty($query_fetch_users)){ 

  foreach ($query_fetch_users as $key => $value) {

	$ch = curl_init();  
    curl_setopt($ch,CURLOPT_URL,$CFG->wwwroot."/login/token.php?username=".$value->username."&password=Test@123&service=moodle_mobile_app");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    $output=curl_exec($ch);
    $result = json_decode($output, true);

    if($result['token'])
    {
      print_r($result['token']);
    }

    if ($output === FALSE) {
        die("Curl failed: " . curL_error($ch));
    }
	curl_close($ch);
  }
 
}

         
?>