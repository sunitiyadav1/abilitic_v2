<?php

/* 
* @author       : Suniti Yadav 
* description   : Some modifications has been done w.r.t dynamic cohorts.
*/

require_once($CFG->dirroot.'/user/filters/lib.php');
//require_once($CFG->dirroot.'/user/filters/cust_lib.php'); // Not working - Suniti

if (!defined('MAX_BULK_USERS')) {
    define('MAX_BULK_USERS', 2000);
}

function add_selection_all($ufiltering) {
    global $SESSION, $DB, $CFG;

    $SESSION->all_users = 1; // Suniti - for getting all user selection

    list($sqlwhere, $params) = $ufiltering->get_sql_filter("id<>:exguest AND deleted <> 1", array('exguest'=>$CFG->siteguest));

    $rs = $DB->get_recordset_select('user', $sqlwhere, $params, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname');
    foreach ($rs as $user) {
        if (!isset($SESSION->bulk_users[$user->id])) {
            $SESSION->bulk_users[$user->id] = $user->id;
        }
    }
    $rs->close();
}

function get_selection_data($ufiltering) {
    global $SESSION, $DB, $CFG, $USER;

    // get the SQL filter
    list($sqlwhere, $params) = $ufiltering->get_sql_filter("id<>:exguest AND deleted <> 1", array('exguest'=>$CFG->siteguest));

    $total  = $DB->count_records_select('user', "id<>:exguest AND deleted <> 1", array('exguest'=>$CFG->siteguest));
    $acount = $DB->count_records_select('user', $sqlwhere, $params);
    $scount = count($SESSION->bulk_users);

    $userlist = array('acount'=>$acount, 'scount'=>$scount, 'ausers'=>false, 'susers'=>false, 'total'=>$total);
    $userlist['ausers'] = $DB->get_records_select_menu('user', $sqlwhere, $params, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname', 0, MAX_BULK_USERS);

    /*
    @author     : Suniti Yadav
    description : Below code is added to capture applied filters. So that we will get dynamic cohort rule set.
    */
    $sqlselect   = "select * from mdl_user where";
    $arr_to_str  = serialize($params);
    $description = serialize($SESSION->user_filtering);

    $set_sql     = 'INSERT INTO mdl_dynamic_cohort_rule_set (sqlselect, sqlwhere, sqlparam, check_all_users, description, created_by) VALUES (?,?,?,?,?,?)';

    $hparams = array();
    $hparams['sqlselect']   = $sqlselect;
    $hparams['sqlwhere']    = $sqlwhere;
    $hparams['sqlparam']    = $arr_to_str;
    $hparams['check_all_users'] = ($SESSION->all_users)?$SESSION->all_users:0;
    $hparams['description'] = $description;
    $hparams['created_by']  = $USER->id;
    $DB->execute($set_sql, $hparams);
    $SESSION->all_users     = 0;
    //end

    if ($scount) {
        if ($scount < MAX_BULK_USERS) {
            $bulkusers = $SESSION->bulk_users;
        } else {
            $bulkusers = array_slice($SESSION->bulk_users, 0, MAX_BULK_USERS, true);
        }
        list($in, $inparams) = $DB->get_in_or_equal($bulkusers);
        $userlist['susers'] = $DB->get_records_select_menu('user', "id $in", $inparams, 'fullname', 'id,'.$DB->sql_fullname().' AS fullname');

        //echo $in; exit();
    }

    return $userlist;
}
