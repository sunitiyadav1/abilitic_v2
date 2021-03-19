<?php

$base = __DIR__ . '/../../../../';
define('CLI_SCRIPT', true);
require_once $base.'config.php';

//require_once '../config.php';

define('MAX_BULK_USERS', 2000);
date_default_timezone_set("Asia/Kolkata");

error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', '1'); 
ini_set('max_execution_time', '0');

// $CFG->debug = (E_ALL | E_STRICT); 
// $CFG->debugdisplay = 1;
// $CFG->debugdeveloper= 1;


$DB->execute("update mdl_dynamic_cohort_cust_rule_set set updated_at = ?, created_at = ? ",array('updated_at' => date('Y-m-d H:i:s'), 'created_at' => date('Y-m-d H:i:s')));

?>