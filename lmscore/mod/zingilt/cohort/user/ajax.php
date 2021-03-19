<?php
require_once dirname(__FILE__) . '/../../../../config.php';
require_once($CFG->dirroot . '/mod/zingilt/lib.php');
//require_once 'lib.php';
define('STUDENT_ROLE_ID', 5);
global $DB, $CFG, $USER;
//print_r($_REQUEST);
if (isset($_REQUEST['action']) && $_REQUEST['action'] != "") {
    switch ($_REQUEST['action']) {
        case "get_user_count":
            //print_r($_REQUEST);
            $userids = isset($_REQUEST['userids']) ? $_REQUEST['userids'] : null;
            $cohortids = isset($_REQUEST['cohortids']) ? $_REQUEST['cohortids'] : null;
            $uids = array();
            if (isset($userids) && $userids != null) {
                foreach ($userids as $u) {
                    $uids[$u] = $u;
                }
            }
            if (isset($cohortids) && $cohortids != null) {
                foreach ($cohortids as $cid) {
                    $rs = $DB->get_records_sql("select userid from {cohort_members} where cohortid = " . $cid . " and userid !=''");
                    if ($rs != null) {
                        foreach ($rs as $u) {
                            $uids[$u->userid] = $u->userid;
                        }
                    }
                }
            }
            if (count($uids) > 0) {
                $arr = array();
                $arr['userIds'] = $uids;
                $arr['totalUsers'] = count($uids);
                $arr['status'] = 0;
                $arr['message'] = "";
            } else {
                $arr = array();
                $arr['userIds'] = $uids;
                $arr['totalUsers'] = count($uids);
                $arr['status'] = 1;
                $arr['message'] = "No Users";
            }
            echo json_encode($arr);
            break;
        case "enroll_cohort":
            // print_r($_REQUEST);
            $countuseralreadyenrolled = 0;
            $countusersuccess = 0;
            $countuserfailure = 0;
            $alreadyenrolleduserids = array();
            $enrolleduserids = array();
            $faileduserids = array();
            if (isset($_REQUEST['uids']) && $_REQUEST['uids'] != null) {
                $session_capacity = $_REQUEST['session_capacity'];
                $enrolled_capacity = $_REQUEST['enrolled_session_capacity'];
                $total_enrolments_users = $_REQUEST['total_uids'];
                $session = zingilt_get_session($_REQUEST['s']);
                //$session = $DB->get_record("zingilt_sessions",array('id'=>$_REQUEST['s']));
                $sessionid = $session->id;

                //check for session capacity and enrolled capacity and update session capacity
                //update_session_capacity($session_capacity,$enrolled_capacity,$total_enrolments_users,$sessionid);
                //////////////////////////////////////////////////////////
                $userids = json_decode($_REQUEST['uids']);
                $zingilt = $DB->get_record("zingilt", array('id' => $session->zingilt));
                //die($courseid);
                $course = $DB->get_record('course', array('id' => $zingilt->course));
                $context = context_course::instance($course->id);
                // print_r($userids);
                foreach ($userids  as $adduser) {
                    //enrolled into the course//check for all the users for course Enrollment
                    $userid = user_enrol_course($adduser, $course);
                    //enrolled into the Session 
                    // $userid = user_enrol_session($session)


                    //in loop all the users for signup 
                    $usernamefields = get_all_user_name_fields(true);
                    if ($session->datetimeknown) {
                        $status = MDL_ZILT_STATUS_BOOKED;
                    } else {
                        $status = MDL_ZILT_STATUS_WAITLISTED;
                    }
                    if (zingilt_get_user_submissions($zingilt->id, $adduser)) {
                        $rs = $DB->get_record_sql("select * from {zingilt_signups_status} as fss 
                            join {zingilt_signups} as fs on fss.signupid = fs.id
                            where fs.sessionid = " . $sessionid . " and fs.userid=" . $adduser . " and fss.statuscode = 70");
                        if ($rs != null) {
                            //'already enrolled'case 
                            $erruser = $DB->get_record('user', array('id' => $adduser), "id, {$usernamefields}");
                            //  print_r($erruser);
                            $errors[] = get_string('error:addalreadysignedupattendee', 'zingilt', fullname($erruser));
                            $countuseralreadyenrolled++;
                            $alreadyenrolleduserids[] = $adduser;
                        } else {
                            $rs1 = $DB->get_record_sql("select fss.id,fss.signupid,fss.statuscode,fss.superceded from {zingilt_signups_status} as fss 
                            join {zingilt_signups} as fs on fss.signupid = fs.id
                            where fs.sessionid = " . $sessionid . " and fs.userid=" . $adduser);
                            // print_r($rs1);
                            if ($rs1 != null) {
                                $upd = $rs1;
                                $upd->id = $rs1->id;
                                $upd->superceded = 0;
                                $upd->statuscode = 70;
                                $DB->update_record("zingilt_signups_status", $upd);
                                $countusersuccess++;
                                $enrolleduserids[] = $adduser;
                            } else {
                                //no record found    
                            }
                        }
                    } else {
                        //  echo  "<BR>". $adduser."====".zingilt_session_has_capacity($session, $context);
                        if (!zingilt_session_has_capacity($session, $context)) {
                            // echo "<BR>". $adduser."===== Full capacity";
                            $errors[] = get_string('full', 'zingilt');
                            $status = MDL_ZILT_STATUS_WAITLISTED;
                            $countuserfailure++;
                            $faileduserids[] = $adduser;
                            break; // No point in trying to add other people.
                        }

                        // Check if we are waitlisting or booking.
                        //# for avoiding approval flow for line manager.//!$suppressemail
                        if (!zingilt_user_signup_new(
                            $session,
                            $zingilt,
                            $course,
                            '',
                            MDL_ZILT_BOTH,
                            $status,
                            $adduser,
                            false,
                            $USER
                        )) {
                            //  echo "<BR>". $adduser."========= user signup done";
                            $erruser = $DB->get_record('user', array('id' => $adduser), "id, {$usernamefields}");
                            $errors[] = get_string('error:addattendee', 'zingilt', fullname($erruser));
                            $countuserfailure++;
                            $faileduserids[] = $adduser;
                        } else {
                            $countusersuccess++;
                            $enrolleduserids[] = $adduser;
                        }
                    }
                    // print_r($errors);
                }
                //check for session capacity and enrolled capacity and update session capacity
                $enrolled_capacity = zingilt_get_num_attendees($sessionid);
                $session_capacity = update_session_capacity($session_capacity, $enrolled_capacity, $countusersuccess, $sessionid);
                //////////////////////////////////////////////////////////
                /////record save to zingilt enrolment log table entry//////////

                if (isset($_REQUEST['userids']) && is_array($_REQUEST['userids']) && count($_REQUEST['userids']) != 0) {
                    $userids = implode(",", $_REQUEST['userids']);
                } else {
                    $userids = $_REQUEST['uids'];
                }
                if (isset($_REQUEST['cohortids']) && is_array($_REQUEST['cohortids']) && count($_REQUEST['cohortids']) != 0) {
                    $cohortids = implode(",", $_REQUEST['cohortids']);
                } else {
                    $cohortids = '';
                }
                $elog = new stdClass;
                $elog->zingilt = $session->zingilt;
                $elog->sessionid = $_REQUEST['s'];
                $elog->course = $course->id;
                $elog->userids_selected = $userids;
                $elog->cohortids_selected = $cohortids;
                $elog->total_users =  (isset($_REQUEST['total_uids']) && $_REQUEST['total_uids'] != "") ? $_REQUEST['total_uids'] : 0;
                $elog->enrolled_list = ($countusersuccess > 0) ? json_encode($enrolleduserids) : $countusersuccess;
                $elog->already_enrolled_list = $countuseralreadyenrolled > 0 ? json_encode($alreadyenrolleduserids) : $countuseralreadyenrolled;
                $elog->failed_list = $countuserfailure > 0 ? json_encode($faileduserids) : $countuserfailure;
                $elog->created_by = $USER->id;
                $elog->created_at = time();
                $DB->insert_record("zingilt_enrolment_log", $elog);
                //enrolment_add_to_log()
                ////////////////////////////////////////////////////////////////////////
                /*   unset($_SESSION['sess_enrolment_msg']);
                $_SESSION['sess_enrolment_msg'] = $countusersuccess . " Users Enrolled Successfully.  <BR>".
                                        ($countuseralreadyenrolled>0? $countuseralreadyenrolled . " User Already Enrolled<BR>":"").
                                        ($countuserfailure>0? $countuserfailure ." Users Failed for Enrolment":"");
               */
                $enrolment_msg =  $countusersuccess . " Users Enrolled Successfully.  <BR>" .
                    ($countuseralreadyenrolled > 0 ? $countuseralreadyenrolled . " User Already Enrolled<BR>" : "") .
                    ($countuserfailure > 0 ? $countuserfailure . " Users Failed for Enrolment" : "");
                \core\notification::add($enrolment_msg, "success");
                $arr = array();
                $arr['status'] = 1;
                $arr['url']  = $CFG->wwwroot . '/mod/zingilt/attendees.php?s=' . $session->id;
                $arr['message'] = $enrolment_msg;
                $arr['result'] = $userids;
                echo json_encode($arr);
                // $returnurl = $CFG->wwwroot."/mod/zingilt/attendees.php?s=".$session->id;
                // redirect($returnurl, $arr['message'], null, \core\output\notification::NOTIFY_SUCCESS);
            } else {
                echo "No User id Founnd";
            }



            break;
    }
}
function update_session_capacity($session_capacity, $enrolled_capacity, $total_enrolments_users, $sessionid)
{
    global $DB;
    if ($enrolled_capacity > $session_capacity) {
        $DB->execute("update {zingilt_sessions} set capacity = " . $enrolled_capacity . " where id= " . $sessionid);
        return $enrolled_capacity;
    } else {
        $rem_capacity =  intval($session_capacity) - intval($enrolled_capacity);
        if ($rem_capacity < $total_enrolments_users) {
            //update the session capacity
            $cap_to_increase = intval($total_enrolments_users) - intval($rem_capacity);
            $update_cap = intval($session_capacity) + intval($cap_to_increase);
            $DB->execute("update {zingilt_sessions} set capacity = " . $update_cap . " where id= " . $sessionid);
            //echo "session finally updated";
            return $update_cap;
        } else {
            return $session_capacity;
        }
    }
}

function user_enrol_course($userid, $course)
{
    global $DB, $USER;
    // echo $userid."=====";
    if ($userid != 0 && $userid != null && $userid != "") {
        $from       = $DB->get_record('user', array('id' => 2));
        $sql        = "SELECT u.* from {user} as u  where u.id = ? and u.deleted = ?";
        $user       = $DB->get_record_sql($sql, array($userid, 0), $strictness = IGNORE_MISSING);
        if ($user != null) {
            // Instructor Course enrollment
            $enrol      = $DB->get_record_sql('SELECT id,enrol FROM `mdl_enrol` WHERE `courseid` = ? and status = 0 ORDER BY id asc limit 0,1', array('courseid' => $course->id)); //print_r($enrol); //exit();
            $course_status = 0;

            if (!empty($enrol)) {
                $uenrol = $DB->get_record_sql('SELECT * FROM `mdl_user_enrolments` where enrolid = ? and userid = ?', array('enrolid' => $enrol->id, 'userid' => $user->id));

                if (empty($uenrol)) {
                    // course enrollment
                    $rec = new stdClass();
                    $rec->status            = $course_status;
                    $rec->enrolid           = $enrol->id;
                    $rec->userid            = $user->id;
                    $rec->timestart         = time();
                    $rec->timeend           = 0;
                    $rec->modifierid        = $USER->id;
                    $rec->timecreated       = time();
                    $rec->timemodified      = time();
                    $DB->insert_record('user_enrolments', $rec);
                }
            }
            //die("herer".$userid);

            //STUDENT_ROLE_ID role assignment at course level
             $context = context_course::instance($course->id);//context_course::course($course->id, MUST_EXIST);
            $context = isset($context) ? $context : context_system::instance(); 

            $r_assign = $DB->get_record_sql('SELECT * FROM `mdl_role_assignments` WHERE `contextid` = ? and userid = ? and roleid = ? ORDER BY id asc limit 0,1', array('contextid' => $context->id, 'userid' => $user->id, 'roleid' => STUDENT_ROLE_ID));
            // print_r($context); print_r($user->id);
            // print_r($r_assign); exit();

            if (empty($r_assign)) {
                $ins_rec = new stdClass();
                $ins_rec->roleid      = STUDENT_ROLE_ID;
                $ins_rec->contextid   = $context->id;
                $ins_rec->userid      = $user->id;
                $ins_rec->modifierid  = $USER->id;
                $ins_rec->timecreated = time();
                $ins_rec->component   = '';
                $ins_rec->itemid      = 0;
                $ins_rec->sortorder   = 0;
                //print_r($ins_rec); exit();
                $DB->insert_record('role_assignments', $ins_rec);
            }
        }
    }
    return $userid;
}
