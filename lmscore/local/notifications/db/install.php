<?php 
defined('MOODLE_INTERNAL') || die;

function xmldb_local_notifications_install() {
    global $CFG, $OUTPUT, $DB;
    // Your add data code here.
    try{
        $table = 'notification_type';
        $arr = array();
        $arr[] = array("id"=>1,"name"=>"Email","is_active"=>0,"created_at"=>time(),"upadated_at"=>time());
        $arr[] = array("id"=>2,"name"=>"App/Mobile","is_active"=>1,"created_at"=>time(),"upadated_at"=>time());
        $arr[] = array("id"=>3,"name"=>"Web","is_active"=>0,"created_at"=>time(),"upadated_at"=>time());

        foreach ($arr as $record) {
            $r = new stdClass;
            $r->id = $record['id'];
            $r->name =  $record['name'];
            $r->is_active = $record['is_active'];
            $r->created_at =$record['created_at'];
            $r->upadated_at = $record['upadated_at'];
            $DB->insert_record('notification_type', $r);
        }
    }
    catch(Exception $e){    
    }
}