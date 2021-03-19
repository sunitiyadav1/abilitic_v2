<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Script to let a user edit the properties of a particular email template.
 */

require_once dirname(__FILE__) . '/../../../config.php';
global $CFG;
if(isset($CFG->zingilt_RMsession_role) && $CFG->zingilt_RMsession_role!=""){
    $trainerrole = $CFG->zingilt_RMsession_role;
}
else{
    $trainerrole =2;
}

define("TRAINER_ROLE_ID",$trainerrole);
function getResourceSubType($id = null)
{
    global $DB;
    $resourcesubtype = array();
    $lang = current_language();
    $name = "name as subtype_name";
    $resourcesubtype[''] = get_string('select');
    if ($id != null) {
        $sql = "SELECT id,$name  from {resource_subtype} where resource_type_id=" . $id . "  AND is_active=0";
        $resourcetype = $DB->get_records_sql($sql);
    } else {
        $sql = "SELECT id,$name  from {resource_subtype}  where is_active=0 order by name asc";
        $resourcetype = $DB->get_records_sql($sql);
    }

    foreach ($resourcetype as $rt) {
        $resourcesubtype[$rt->id] = $rt->subtype_name;
    }
    return $resourcesubtype;
}
function getResourceType($all = null)
{
    global $DB;
    $resourcesubtype = array();
    $lang = current_language();
    $name = "name as subtype_name";
    $resourcesubtype[''] = get_string("select");
    if ($all != null) {
        $sql = "SELECT id,$name  from {resource_type} where id= " . $all . " AND is_active=0 order by name asc";
        $resourcetype = $DB->get_records_sql($sql);
    } else {
        $sql = "SELECT id,$name  from {resource_type} where  is_active=0  order by name asc";
        $resourcetype = $DB->get_records_sql($sql);
        //$resourcetype = $DB->get_records('resource_subtype');
    }
    foreach ($resourcetype as $rt) {
        //echo $course->id; echo $course->fullname ;  die;
        $resourcesubtype[$rt->id] = $rt->subtype_name;
    }
    return $resourcesubtype;
}
function getResourceMode()
{
    $arr = array();
    $arr[''] = get_string('select');
    $arr['INTERNAL'] = get_string('INTERNAL', 'mod_zingilt');
    $arr['EXTERNAL'] = get_string('EXTERNAL', 'mod_zingilt');
    return $arr;
}
function getSeatingOrientation($id = null)
{
    global $DB;
    if ($id != null) {
        //$resourcetype = $DB->get_record('resource_subtype', array('id' => $classroomid), '*', MUST_EXIST);
    } else {
        $s = array();
        $lang = current_language();
        $name = "name as seating_name";

        $sql = "SELECT id,$name,classimage  from {venue_seating_orientation} order by name asc";
        $rs = $DB->get_records_sql($sql);

        /*$s[''] = "Select";
        foreach ($rs as $rt) {
            //echo $course->id; echo $course->fullname ;  die;
            $s[$rt->id] = $rt->seating_name;

        }*/

        //$resourcetype = $DB->get_records('resource_subtype');
    }
    return $rs;
}
function getPriceUnit()
{
    global $DB;

    $s = array();
    $lang = current_language();
    $name = "name as currency_name";

    $sql = "SELECT id,$name  from {budget_currency} order by name asc";
    $rs = $DB->get_records_sql($sql);

    $s[''] = "Select";
    foreach ($rs as $rt) {
        //echo $course->id; echo $course->fullname ;  die;
        $s[$rt->id] = $rt->currency_name;
    }
    return $s;
}
function resources_add($data)
{
    global $DB, $CFG, $USER;

    if (!empty($data->en_resource_name)) {
        if ($DB->record_exists('resources', array('en_resource_name' => $data->en_resource_name))) {
            throw new moodle_exception(get_string('resourcenametaken'), '', '', $data->en_resource_name);
        }
    }
    /* if ($errorcode = course_validate_dates((array)$data)) {
    throw new moodle_exception($errorcode);
    }*/
    $data->en_resource_desc = $data->en_resource_desc['text'];
    $data->ar_resource_desc = $data->ar_resource_desc['text'];
    $data->startdate = date("Y-m-d H:i:s", $data->startdate);
    $data->enddate = date("Y-m-d H:i:s", $data->enddate);
    $data->overbooking_flag = isset($data->overbooking_flag) ? $data->overbooking_flag : 0;
    $data->isdeleted = 0;
    $data->brief_about_trainer = isset($data->brief_about_trainer) ? $data->brief_about_trainer : "";
    $data->trainer_sign = isset($data->trainer_sign) ? $data->trainer_sign : "";
    $data->created_by = $data->userid;
    $data->created_at = !empty($data->timecreated) ? $data->timecreated : date('Y-m-d H:i:s');
    $data->trainer_request_id = !empty($data->trainer_request_id) ? $data->trainer_request_id : 0;
    $data->updated_by = $data->userid;
    $data->updated_at = time(); //$data->timecreated;
    //   echo "<pre>";print_r($data);die("here");
    $data->id = $DB->insert_record('resources', $data);
    return $data->id;
}
function resources_edit($data)
{
    global $DB, $CFG, $USER;

    $data->en_resource_desc = $data->en_resource_desc['text'];
    $data->ar_resource_desc = $data->ar_resource_desc['text'];
    $data->startdate = date("Y-m-d H:i:s", $data->startdate);
    $data->enddate = date("Y-m-d H:i:s", $data->enddate);
    $data->overbooking_flag = isset($data->overbooking_flag) ? $data->overbooking_flag : 0;
    $data->isdeleted = 0;
    $data->brief_about_trainer = isset($data->brief_about_trainer) ? $data->brief_about_trainer : "";
    $data->trainer_sign = isset($data->trainer_sign) ? $data->trainer_sign : "";
    //$data->created_by = $data->userid;
    //$data->created_at = !empty($data->timecreated) ? $data->timecreated : date('Y-m-d H:i:s');
    $data->updated_by = $data->userid;
    $data->updated_at = $data->timecreated;
    // echo "<pre>";print_r($data);die("here");
    $DB->update_record('resources', $data);
    //$data->id = $DB->insert_record('resources', $data);
    return $data->id;
}
function getTrainingProvider($id = null)
{
    global $DB;
    if ($id != null) {
        //$resourcetype = $DB->get_record('resource_subtype', array('id' => $classroomid), '*', MUST_EXIST);
    } else {
        $rs = array();
        $lang = current_language();
        $name = "name as tprovider_name";

        $sql = "SELECT id,$name  from {training_provider} order by name asc";
        $res = $DB->get_records_sql($sql);
        // print_r($res); die;
        $rs[''] = get_string('select');
        foreach ($res as $rt) {
            $rs[$rt->id] = $rt->tprovider_name;
        }
    }
    //print_r($rs);die;
    return $rs;
}
function getTrainingCenter($id = null)
{
    global $DB;
    $lang = current_language();
    // $name = "name as tcenter_name";
    $rs = array();
    if ($id != null) {
        $sql = "SELECT id,name  from {training_center} where training_provider_id=" . $id . " order by name asc";
        $resourcetype = $DB->get_records_sql($sql);
    } else {
        $sql = "SELECT id,name  from {training_center} order by name asc";
        $resourcetype = $DB->get_records_sql($sql);
    }
    $rs[''] =  get_string('select');
    foreach ($resourcetype as $rt) {
        $rs[$rt->id] = $rt->name;
    }
    return $rs;
}

function training_center_add($data)
{
    global $DB, $CFG, $USER;

    if (!empty($data->en_name)) {
        if ($DB->record_exists('training_center', array('name' => $data->en_name))) {
            throw new moodle_exception(get_string('tcenternametaken'), '', '', $data->en_name);
        }
    }
    $data->card_facility_issue_date = date("Y-m-d H:i:s", $data->card_facility_issue_date);
    $data->card_facility_expiry_date = date("Y-m-d H:i:s", $data->card_facility_expiry_date);
    $data->created_by = $USER->id;
    $data->updated_by = $USER->id;
    $tcid = $DB->insert_record('training_center', $data);
    return $tcid;
}

function getEmployees($userid = "")
{
    global $DB;
    $sql = "SELECT u.id as id, CONCAT(u.firstname,' ' , u.lastname,' [',u.username,'] ') as name FROM {user} as u where deleted= 0 and u.id !=1";
    if ($userid != "") {
        //   die($userid);
        $sql .= " AND u.id=" . $userid;
        // echo $sql;die;
        $users = $DB->get_record_sql($sql);
        return $users;
    }
    $users = $DB->get_records_sql($sql);
    return $users;
}
function getCourseTopics()
{
    global $DB;
    $lang = current_language();
    $name = $lang . "_name as topic_name";
    $rs = array();
    $sql = "SELECT id,$name  from {course_topic} order by en_name asc";
    $topics = $DB->get_records_sql($sql);
    $rs[''] = "Select";
    foreach ($topics as $t) {
        $rs[$t->id] = $t->topic_name;
    }
    return $rs;
}
function getVisualAds()
{
    global $DB;
    $lang = current_language();
    $name = $lang . "_name as name";
    $rs = array();
    $sql = "SELECT id,$name  from {visual_ads} order by en_name asc";
    $topics = $DB->get_records_sql($sql);
    $rs[''] = get_string("select");
    foreach ($topics as $t) {
        $rs[$t->id] = $t->name;
    }
    return $rs;
}
function getSkillsRating()
{
    global $DB;
    $lang = current_language();
    $name = $lang . "_name as name";
    $rs = array();
    $sql = "SELECT id,$name  from {skills_rating} order by id asc";
    $topics = $DB->get_records_sql($sql);
    $rs[''] = get_string("select");
    foreach ($topics as $t) {
        $rs[$t->id] = $t->name;
    }
    return $rs;
}
function getCompetencies()
{
    global $DB;
    $rs = array();
    $sql = "SELECT id,shortname as name from {competency} order by id asc";
    $topics = $DB->get_records_sql($sql);
    $rs[''] = get_string("select");
    foreach ($topics as $t) {
        $rs[$t->id] = $t->name;
    }
    return $rs;
}
function getTrainerStatus()
{
    global $DB;
    $rs = array();
    $lang = current_language();

    $sql = "SELECT id," . $lang . "_name as name from {trainer_status} order by id asc";
    $topics = $DB->get_records_sql($sql);
    $rs[''] = get_string("select");
    foreach ($topics as $t) {
        $rs[$t->id] = $t->name;
    }
    return $rs;
}
function trainer_request_log_add($data, $remark = "")
{
    global $DB, $USER;
    /* `id` int(11) NOT NULL,
    `trainer_request_id` int(11) NOT NULL,
    `submitted_by` int(11) NOT NULL,
    `status` int(11) NOT NULL,
    `created_by` int(11) NOT NULL,
    `created_at` timestamp NOT NULL DEFAUL
     */
    $log = new stdClass;
    $log->trainer_request_id = $data->id;
    $log->submitted_by = $USER->id;
    $log->status = $data->request_status;
    $log->remark = $remark;
    $log->created_by = $USER->id;
    $log->created_at = date("Y-m-d H:i:s");
    //print_r($log);die;
    $log->id = $DB->insert_record('trainer_request_log', $log);
    return $log->id;
}
function trainer_request_add($data)
{

    global $DB, $CFG, $USER;
    $data->comp = "";
    if ($data->competencies != null && is_array($data->competencies)) {
        $data->comp = $data->competencies;
        $data->competencies = implode(",", $data->competencies);
    }
    $data->resource_type_id = 2;
    if ($data->resource_mode == "EXTERNAL") {
        $data->resource_subtype_id = 8;
    } else if ($data->resource_mode == "INTERNAL") {
        $data->resource_subtype_id = 7;
    }
    $data->dob = date("Y-m-d", $data->dob);
    $data->brief_about_trainer = $data->brief_about_trainer['text'];
    $data->is_active = 1;
    $data->request_status = 1;
    $data->created_by = $data->userid;
    $data->updated_by = $USER->id;
    $data->created_at = !empty($data->timecreated) ? $data->timecreated : date('Y-m-d H:i:s');
    $data->updated_at = $data->timecreated;
    //echo "<pre>";print_r($data);die;
    $data->id = $DB->insert_record('trainer_requests', $data);
    trainer_request_log_add($data);
    if ($data->resource_mode == "INTERNAL") {
        $user = $DB->get_record("user", array("id" => $data->emp_id));
        $manager = $DB->get_record("user", array("username" => $user->supervisor_username));
        if ($user != null && $manager != null) {
            notify_trainer_request($user, $manager->id, $data->id);
        }
    }
    if ($data->comp != null && is_array($data->comp)) {
        foreach ($data->comp as $c) {
            $cp = new stdClass;
            $cp->trainer_request_id = $data->id;
            $cp->competency = $c;
            $cp->created_at = date("Y-m-d H:i:s");
            $cpid = $DB->insert_record('trainer_request_competencies', $cp);
        }
    }
    return $data->id;
}

function notify_trainer_request($user, $managerid, $trainerid)
{
    $notifnContent = "<p> Hi, <br> This is to notify that Training Admin has requested your subordinate " . $user->firstname . "
     for the Trainer Registration. Requesting you to take action on the Trainer Request. <br>

     <br>
         Happy Learning !! <br><br>
            Regards,<br>
            <i>SDG Learning & Development Team </i></p>";

    $subject = 'Trainer Request';
    $contexturl = null;
    $contexturlname = 'Trainer Request';
    send_mailandnotification($user->id, $notifnContent, $managerid, $subject, $contexturl, $contexturlname);
    return true;
}
function trainer_request_edit($data)
{

    global $DB, $CFG, $USER;

    $data->resource_type_id = 2;
    if ($data->resource_mode == "EXTERNAL") {
        $data->resource_subtype_id = 8;
    } else if ($data->resource_mode == "INTERNAL") {
        $data->resource_subtype_id = 7;
    }
    $data->dob = date("Y-m-d", $data->dob);
    $data->brief_about_trainer = $data->brief_about_trainer['text'];
    $data->is_active = 1;
    $data->request_status = 1;
    $data->created_by = $data->userid;
    $data->updated_by = $USER->id;
    $data->created_at = !empty($data->timecreated) ? $data->timecreated : date('Y-m-d H:i:s');
    $data->updated_at = $data->timecreated;
    //echo "<pre>";print_r($data);die;
    $DB->update_record('trainer_requests', $data);

    //$data->id = $DB->insert_record('trainer_requests', $data);
    return $data->id;
}
function getResources($typeid, $subtypeid, $daterange = "")
{
    $context = context_system::instance();
    $companyid = 0; //iomad::get_my_companyid($context);
    global $DB, $USER; //echo "<pre>"; print_r($USER->company->id);
    $resourcesubtype = array();
    $lang = current_language();
    // $name = $lang . "_name as subtype_name";
    if ($daterange != "" && is_array($daterange)) {
        $fromdate = $daterange['fromdate'];
        $todate = $daterange['todate'];
        //$cond =" AND CURRENT_DATE() >= '".$fromdate."' and CURRENT_DATE <= '".$todate."'";
        $cond = " AND startdate <= '" . $fromdate . "' and enddate >= '" . $todate . "'";
    } else {
        $cond = "";
    }
    if ($typeid != "" && $subtypeid != "") {
        $sql = "SELECT id," . $lang . "_resource_name as resource_name  from {resources} where resource_type_id= " . $typeid . " and resource_subtype_id=" . $subtypeid . " And companyid=" . $companyid . $cond . "  order by " . $lang . "_resource_name asc";
        //echo $sql;die;
        $resourcetype = $DB->get_records_sql($sql);
    } else {
        $sql = "SELECT id," . $lang . "_resource_name as resource_name  from {resources} where companyid=" . $companyid . " order by " . $lang . "_resource_name asc";
        $resourcetype = $DB->get_records_sql($sql);
        //$resourcetype = $DB->get_records('resource_subtype');
    }
    $resourcesubtype[''] = get_string("select");
    foreach ($resourcetype as $rt) {
        //echo $course->id; echo $course->fullname ;  die;
        $resourcesubtype[$rt->id] = $rt->resource_name;
    }
    return $resourcesubtype;
}

function getBookingActiveResources($fromdate, $enddate, $resourceid)
{
    global $DB, $USER;
    $context = context_system::instance();
    $companyid = iomad::get_my_companyid($context);
    $lang = current_language();
    $sql = "SELECT id," . $lang . "_resource_name as resource_name from mdl_resources
            where id= " . $resourceid . " AND
            DATE_FORMAT(startdate,'%Y-%m-%d %H:%i:%s') <= '" . date("Y-m-d H:i:s", strtotime($fromdate)) . "'
            AND DATE_FORMAT(enddate,'%Y-%m-%d %H:%i:%s') >= '" . date("Y-m-d H:i:s", strtotime($todate)) . "'
            AND companyid=" . $companyid;
    $res = $DB->get_records_sql($sql);
    $str = "";

    if ($res != null) {
        $context = context_system::instance();
        $companyid = iomad::get_my_companyid($context);
        //resource is active

        $sql1 = "select * from mdl_resource_booking where resource_id=" . $resourceid . " and companyid=" . $companyid;
        $res1 = $DB->get_records_sql($sql1);
        $str = '';
        $str1 = '';
        // print_r($res1);
        if ($res1 != null) {
            //then we need to check the Dates of the Resources booking.
            $full_booking = 0;
            $partial_booking = 0;

            foreach ($res1 as $r1) {
                // echo date("H:i:s",$r1->start_date)." ==". date("H:i:s",$r1->end_date);
                if ($r1->start_date <= $fromdate && $r1->end_date >= $enddate) {
                    $str = "Full Booking";
                    $str1 .= "<BR>full_booking:" . $r1->start_date . "==" . $r1->end_date;
                    break;
                } else if ($r1->start_date <= $fromdate && $r1->end_date <= $enddate) {
                    $str = "Partial Booking";
                    $str1 .= "<BR>partial_booking:" . $r1->start_date . "==" . $r1->end_date;
                    break;
                } else if ($r1->start_date >= $fromdate && $r1->end_date <= $enddate) {
                    $str = "Partial Booking";
                    $str1 .= "<BR>partial_booking:" . $r1->start_date . "==" . $r1->end_date;
                    break;
                } else if ($r1->start_date >= $fromdate && $r1->end_date >= $enddate) {
                    $str = "Partial Booking";
                    $str1 .= "<BR>partial_booking:" . $r1->start_date . "==" . $r1->end_date;
                    break;
                }
            }
        } else {
            //No Record Found so its ok to go ahead with the booking
            $str = "Booking Available";
            $str1 .= "Booking Available";
        }
    } else {
        //resource is inactive
        $str .= "Resource is Not Active";
        $str1 .= "Resource is Not Active";
    }

    //  echo "<pre>". $str1;
    return $str;
}
function rand_color()
{
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

function getCountries()
{
    global $DB;
    $rs = $DB->get_records_sql("select id,name from {countries}");
    $arr[''] = get_string('select');
    if ($rs != null) {
        foreach ($rs as $r) {
            $arr[$r->id] = $r->name;
        }
        return $arr;
    } else {
        return [];
    }
}
function getStates($cid = 0)
{
    global $DB;
    $sql = "select id,name,country_id from {states} ";

    if ($cid != 0) {
        $sql .= " where country_id=" . $cid . " order by name ";
        //echo $sql;die;
        $rs = $DB->get_records_sql($sql);
        //  print_r($rs);
    } else {
        //echo "in delse";die;
        $rs = $DB->get_records_sql($sql);
    }
    $arr[''] = get_string('select');
    if ($rs != null) {
        foreach ($rs as $r) {
            $arr[$r->id] = $r->name;
        }
        return $arr;
    } else {
        return [];
    }
}

function getTaxType($cid = 0)
{
    global $DB;
    $sql = "select id,shortname,name from {tax_type} ";

    if ($cid != 0) {
        $sql .= " where id=" . $cid;
        //echo $sql;die;
        $rs = $DB->get_records_sql($sql);
        //  print_r($rs);
    } else {
        //echo "in delse";die;
        $rs = $DB->get_records_sql($sql);
    }
    $arr[''] = get_string('select');
    if ($rs != null) {
        foreach ($rs as $r) {
            $arr[$r->id] = $r->name ."[".$r->shortname."]";
        }
        return $arr;
    } else {
        return [];
    }
}
  /**
     * Creates a new role in the system.
     *
     * You can fill $record with the role 'name',
     * 'shortname', 'description' and 'archetype'.
     *
     * If an archetype is specified it's capabilities,
     * context where the role can be assigned and
     * all other properties are copied from the archetype;
     * if no archetype is specified it will create an
     * empty role.
     *
     * @param array|stdClass $record
     * @return int The new role id
     */
    function create_trainer_role($record=null) {
        global $DB;
        $record = (array)$record;

        if (empty($record['shortname'])) {
            $record['shortname'] = 'role-' . $i;
        }

        if (empty($record['name'])) {
            $record['name'] = 'Test role ' . $i;
        }

        if (empty($record['description'])) {
            $record['description'] = 'Test role ' . $i . ' description';
        }
            $record['archetype'] = "editingteacher";
         /*   if (empty($record['archetype'])) {
                $record['archetype'] = '';
            } else {
                $archetypes = get_role_archetypes();
                if (empty($archetypes[$record['archetype']])) {
                    throw new coding_exception('\'role\' requires the field \'archetype\' to specify a ' .
                        'valid archetype shortname (editingteacher, student...)');
                }
            }*/

        // Creates the role.
        if (!$newroleid = create_role($record['name'], $record['shortname'], $record['description'], $record['archetype'])) {
            throw new coding_exception('There was an error creating \'' . $record['shortname'] . '\' role');
        }

        // If no archetype was specified we allow it to be added to all contexts,
        // otherwise we allow it in the archetype contexts.
        if (!$record['archetype']) {
            $contextlevels = array_keys(context_helper::get_all_levels());
        } else {
            // Copying from the archetype default rol.
            $archetyperoleid = $DB->get_field(
                'role',
                'id',
                array('shortname' => $record['archetype'], 'archetype' => $record['archetype'])
            );
            $contextlevels = get_role_contextlevels($archetyperoleid);
            $contextlevels[]= CONTEXT_SYSTEM;
        }
        set_role_contextlevels($newroleid, $contextlevels);

        if ($record['archetype']) {

            // We copy all the roles the archetype can assign, override, switch to and view.
            if ($record['archetype']) {
                $types = array('assign', 'override', 'switch', 'view');
                foreach ($types as $type) {
                    $rolestocopy = get_default_role_archetype_allows($type, $record['archetype']);
                    foreach ($rolestocopy as $tocopy) {
                        $functionname = "core_role_set_{$type}_allowed";
                        $functionname($newroleid, $tocopy);
                    }
                }
            }

            // Copying the archetype capabilities.
            $sourcerole = $DB->get_record('role', array('id' => $archetyperoleid));
            role_cap_duplicate($sourcerole, $newroleid);
        }

        return $newroleid;
    }

function get_trainer_role(){
    $roles = role_fix_names(get_all_roles(), \context_system::instance(), ROLENAME_ORIGINAL);
    print_r($roles);
        $rolesnames = array();
        foreach ($roles as $role) {
            if(trim($role->localname) == "TRAINER_RM1"){
                $rolesnames[$role->id] = $role->localname;
                return $role;
            }
        }
       return $rolesnames;       
  }

function get_resource_attachments($resourceid,$showdelete =true){
    global $DB;
    $attstr = '';
    $rs = $DB->get_records("resource_attachment",array("resource_id"=> $resourceid));
    if($rs != null){
        $attstr .= "<ul>";
        foreach($rs as $r){
            $attstr .= "<li >".$r->attachment_filename.  '   [<a href ="downloadfile.php?id='.$r->id.'">Download</a>] ';
            if($showdelete == true)
                $attstr .=' [<a href ="#" id="attdelete" data-id="'.$r->id.'" data-rid="'.$r->resource_id.'" data-url="ajax.php">Delete</a>]</li>';
        }
        $attstr .= "</ul>";
    }
    else
    {
        $attstr .= "No Resource Attachment Found";
    }
    return $attstr;
}

function resource_attachment_delete($id,$resourceid){
    global $DB;
    $status =0;
    $message = '';
    if($id != null && $resourceid != null){
        $rs = $DB->get_record("resource_attachment",array("id"=>$id,"resource_id"=>$resourceid));
        if($rs !=null){
            unlink($rs->attachment_filepath);
            $sql = "delete from {resource_attachment} where id = ".$id." and resource_id = ".$resourceid;
            $DB->execute($sql);
            $status =1;
            $message = "Resource Attachment Deleted Successfully";
        }
    }
   return array("status"=>$status,"message"=>$message);
}

