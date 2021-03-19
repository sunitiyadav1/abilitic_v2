<?php

/* 
  @author: Kajal C Tailor
  description : Having Dashboard Count Status APis
*/
require_once '../config.php';
require_once($CFG->libdir . '/moodlelib.php');


//require_once 'src/Mandrill.php'; 
//$mandrill = new Mandrill($CFG->md_api_key);

global $DB, $CFG, $SESSION, $USER;
$CFG->debug 		= (E_ALL | E_STRICT);
$CFG->debugdisplay  = 1;
$CFG->debugdeveloper = 1;
$current_url = "https://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$base_url    = explode('/restapi/api_dashboard.php', $current_url);
if (empty($CFG->wwwroot)) {
	$CFG->wwwroot     = $base_url[0];
}

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
header("HTTP/1.0 200 Successfull operation");
//echo '=============+++++++';exit;
$wsfunction = $_POST['wsfunction'];
$response = array();

if ($wsfunction != null && $wsfunction != "") {
	switch ($wsfunction) {
		case 'site_announcement_count':
			try {
				$status = 0;
				$ressage = '';
				$result = array();
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;
						//$sql= 'SELECT COUNT(*) AS cnt ,f.id as forumid
						// FROM mdl_forum AS f
						// JOIN mdl_forum_discussions AS fd ON f.id = fd.forum
						// JOIN mdl_forum_posts AS fp ON fd.id = fp.discussion
						// WHERE fd.userid ='.$userid.'
						// GROUP BY f.id
						// HAVING f.id =(SELECT id FROM mdl_forum WHERE course=1 AND TYPE="news" AND NAME="Site announcements") 
						// ';
						$annres = site_announcement_query($userid, false);
						//	print_r($annres);die;
						/*$announcement_count = 0;
									if($annres != null){
										$announcement_count = $annres->cnt;
										$forumid = $annres->forumid;
									}*/

						// $sql_new = 'SELECT COUNT(*) AS cnt ,f.id as forumid
						// 	FROM mdl_forum AS f
						// 	JOIN mdl_forum_discussions AS fd ON f.id = fd.forum
						// 	JOIN mdl_forum_posts AS fp ON fd.id = fp.discussion
						// 	JOIN mdl_user AS u ON  fd.userid =u.id 
						// 	WHERE fd.userid ='.$userid.' and fp.created >u.lastaccess
						// 	GROUP BY f.id
						// 	HAVING f.id =(SELECT id FROM mdl_forum WHERE course=1 AND TYPE="news" AND NAME="Site announcements") 
						// 	';					
						$annres_new = site_announcement_query($userid, true);
						/*$announcement_new_count =0;
									if($annres_new != ""){
										$announcement_new_count = $annres_new->cnt;
										$forumid = $annres_new->forumid;
									}*/
						$forumid = $annres['forumid'];
						$status = 1;
						$message = '';

						$result = array();
						$result['site_announcement_total_count'] = $annres['announcement_count'];
						$result['site_announcement_new_count'] = $annres_new['announcement_count'];
						//https://learnuat.zinghr.com/Abilitic/lmscore/mod/forum/view.php?f=18
						if($forumid !=0){
							$result['urltogo'] = (string)new moodle_url('/mod/forum/view.php', array('f' => $forumid));
						}
						else{
							$result['urltogo'] = (string) new moodle_url('?redirect=0');	
						}
						//echo json_encode($result);
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "notification_count":
			$status = 0;
			$ressage = '';
			$result = array();
			try {
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;
						//$sql= "SELECT count(*) as cnt FROM {notifications}  WHERE useridto ='.$userid.' AND eventtype NOT IN('availableupdate','insights')";


						//$annres = $DB->get_record_sql($sql);
						//$notification_count = 0;
						//if($annres != null){
						//	$notification_count = $annres->cnt;
						//}

						//$sql_new = "SELECT count(*) as cnt FROM {notifications}  WHERE useridto ='.$userid.' AND eventtype NOT IN('availableupdate','insights') AND timeread IS NULL";					

						//$annres_new = $DB->get_record_sql($sql_new);
						//$notification_new_count =0;
						//if($annres_new != null ){
						//	$notification_new_count = $annres_new->cnt;
						//}
						$notification_count = notification_query($userid, false);
						$notification_new_count = notification_query($userid, true);
						//echo $notification_new_count."====";
						$result = array();
						$result['notification_total_count'] = $notification_count;
						$result['notification_new_count'] = $notification_new_count;
						$result['urltogo'] = (string)new moodle_url('/message/output/popup/notifications.php');
						$status = 1;
						$message = '';

						//echo json_encode($result);
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "badges_count":
			$status = 0;
			$ressage = '';
			$result = array();
			try {
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;
						//       	$sql= "SELECT count(*) as cnt from mdl_badge_issued as bi join mdl_badge as b on bi.badgeid=b.id where bi.userid =".$userid."";				         	

						// $annres = $DB->get_record_sql($sql);
						// $badges_count = 0;
						// if($annres != null){
						// 	$badges_count = $annres->cnt;
						// }
						//echo $notification_new_count."====";
						$badges_count = badges_query($userid);
						$result = array();
						$result['badges_total_count'] = $badges_count;

						if ($badges_count > 0) {
							$result['urltogo'] = (string)new moodle_url('/badges/mybadges.php');
						} else {
							$result['urltogo'] = (string)new moodle_url('/user/profile.php', array("id" => $userid));
						}
						//echo json_encode($result);
						$status = 1;
						$message = '';
					} else {
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
					}
				} else {
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case 'messages_count':
			try {
				$status = 0;
				$ressage = '';
				$result = array();
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;

						$message_count = messages_query($userid, false);
						$message_new_count = messages_query($userid, true);


						$status = 1;
						$message = '';
						$result = array();
						$result['messages_total_count'] = $message_count;
						$result['messages_total_new_count'] = $message_new_count;
						$result['urltogo'] = (string)new moodle_url('/message/index.php');
						//echo json_encode($result);
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case 'calendar_count':
			try {
				$status = 0;
				$ressage = '';
				$result = array();
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;
						$calendar_count = calendar_query($userid, false);
						$calendar_new_count = calendar_query($userid, true);


						$status = 1;
						$message = '';
						$result = array();
						$result['calendar_total_count'] = $calendar_count;
						$result['calendar_total_new_count'] = $calendar_new_count;
						$result['urltogo'] = (string)new moodle_url('/calendar/view.php', array('view' => 'month'));
						//echo json_encode($result);
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "files_count":
			try {
				$status = 0;
				$ressage = '';
				$result = array();
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;
						//Files count Query
						$files_count = files_query($userid);
						$res6 = array();
						$res6['files_total_count'] = $files_count;
						$res6['urltogo'] = (string)new moodle_url('/user/files.php');

						$status = 1;
						$message = '';
						$result = array();
						$result['files_total_count'] = $files_count;
						$result['urltogo'] = (string)new moodle_url('/user/files.php');
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "course_count":
			try {
				$status = 0;
				$ressage = '';
				$result = array();
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;
						//courses count Query
						$my_courses_count = courses_query($userid, $type = "MY_COURSES");
						$self_courses_count = courses_query($userid, $type = "SELF_ENROL");
						//ILT Session count query
						$session_count = iltsession_query($userid);
						$status = 1;
						$message = '';
						$result = array();
						$result['my_courses_count'] = $my_courses_count;
						$result['self_nomination_count'] = $self_courses_count;
						$result['ilt_session_count'] = $session_count;
						$result['urltogo'] = (string)new moodle_url('/my/');
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}

			break;
		case "all_count":
			try {
				$status = 0;
				$ressage = '';
				$result = array();
				$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;
						//announcement count query
						$annres = site_announcement_query($userid, false);
						$annres_new = site_announcement_query($userid, true);
						//print_r($annres);
						$forumid = $annres['forumid'];
						$res1 = array();
						$res1['site_announcement_total_count'] = $annres['announcement_count'];
						$res1['site_announcement_new_count'] = $annres_new['announcement_count'];
						if ($forumid != "")
							$res1['urltogo'] = (string)new moodle_url('/mod/forum/view.php', array('f' => $forumid));
						else {
							$res1['urltogo'] = (string)new moodle_url('/my/');
						}

						//Notification count Query
						$notification_count = notification_query($userid, false);
						$notification_new_count = notification_query($userid, true);
						$res2 = array();
						$res2['notification_total_count'] = $notification_count;
						$res2['notification_new_count'] = $notification_new_count;
						$res2['urltogo'] = (string)new moodle_url('/message/output/popup/notifications.php');

						//badges count Query
						$badges_count = badges_query($userid);
						$res3 = array();
						$res3['badges_total_count'] = $badges_count;
						if ($badges_count > 0) {
							$res3['urltogo'] = (string)new moodle_url('/badges/mybadges.php');
						} else {
							$res3['urltogo'] = (string)new moodle_url('/user/profile.php', array("id" => $userid));
						}
						// messages count Query
						$message_count = messages_query($userid, false);
						$message_new_count = messages_query($userid, true);
						$res4 = array();
						$res4['messages_total_count'] = $message_count;
						$res4['messages_total_new_count'] = $message_new_count;
						$res4['urltogo'] = (string)new moodle_url('/message/index.php');


						// Calendar count Query
						$calendar_count = calendar_query($userid, false);
						$calendar_new_count = calendar_query($userid, true);
						$res5 = array();
						$res5['calendar_total_count'] = $calendar_count;
						$res5['calendar_total_new_count'] = $calendar_new_count;
						$res5['urltogo'] = (string)new moodle_url('/calendar/view.php', array('view' => 'month'));

						//Files count Query
						$files_count = files_query($userid);
						$res6 = array();
						$res6['files_total_count'] = $files_count;
						$res6['urltogo'] = (string)new moodle_url('/user/files.php');

						//courses count Query
						$my_courses_count = courses_query($userid, $type = "MY_COURSES");
						$self_courses_count = courses_query($userid, $type = "SELF_ENROL");
						//ILT Session count query
						$session_count = iltsession_query($userid);
						$res7 = array();
						$res7['my_courses_count'] = $my_courses_count;
						$res7['self_nomination_count'] = $self_courses_count;
						$res7['ilt_session_count'] = $session_count;
						$res7['urltogo'] = (string)new moodle_url('/my/');

						$status = 1;
						$message = '';

						$result = array();
						$result['announcement'] = $res1;
						$result['notification'] = $res2;
						$result['badges'] = $res3;
						$result['messages'] = $res4;
						$result['calendar'] = $res5;
						$result['files'] = $res6;
						$result['courses'] = $res7;
						//echo json_encode($result);
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_inprogress_courses":
			try {
				$status = 0;
				$message = '';
				$result = array();
				$employee_code  = $_POST['employee_code'];
				$company_code   = $_POST['company_code'];
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
				//echo $page."====".$limit;die;
				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					//print_r($query_fetch_user);
					if (!empty($query_fetch_user)) {
						$userid       = $query_fetch_user->userid;
						$username     = $query_fetch_user->username;
						$type = "inprogress";
						$res = get_enrolled_courses($userid, $type, $page, $limit);	

						if ($res != null && $res['totalCount']>0 ) {
							$res['courseflag'] = $type;
							$status = 1;
							$message = '';
							$result = $res;							
						} else {
							$res1 = get_all_courses($userid,$page, $limit);
							if($res1 != null &&  $res1['totalCount']>0)
							{
								$res1['courseflag'] = 'allcourses';
								$status = 1;
								$message = '';
								$result = $res1;
								//echo $data = json_encode($returndata);								
							}
							else
							{
								$status = 0;
								$message = 'No Course Found';
								$result['courses'] = [];
							}
						}
					} else {
						$status = 0;
						$message = 'No User Found';
						$result = [];
						//   echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}

				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_past_courses":
			try {
				$status = 0;
				$message = '';
				$result = array();
				$employee_code  = $_POST['employee_code'];
				$company_code   = $_POST['company_code'];
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;

				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					//print_r($query_fetch_user);
					if (!empty($query_fetch_user)) {
						$userid       = $query_fetch_user->userid;
						$username     = $query_fetch_user->username;
						$type = "past";
						$res = get_enrolled_courses($userid, $type, $page, $limit);
						if ($res != null) {

							$status = 1;
							$message = '';
							$result['courses'] = $res;
							//echo $data = json_encode($returndata);

						} else {
							$status = 0;
							$message = 'No course Enrol for this user';
							$result['courses'] = [];
							//echo $data = json_encode(['Message' => 'No course Enrol for this user']);
						}
					} else {
						$status = 0;
						$message = 'No User Found';
						$result = [];
						//   echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}

				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_future_courses":
			try {
				$status = 0;
				$message = '';
				$result = array();
				$employee_code  = $_POST['employee_code'];
				$company_code   = $_POST['company_code'];
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;

				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					//print_r($query_fetch_user);
					if (!empty($query_fetch_user)) {
						$userid       = $query_fetch_user->userid;
						$username     = $query_fetch_user->username;
						$type = "future";
						$res = get_enrolled_courses($userid, $type, $page, $limit);
						if ($res != null) {

							$status = 1;
							$message = '';
							$result['courses'] = $res;
							//echo $data = json_encode($returndata);

						} else {
							$status = 0;
							$message = 'No course Enrol for this user';
							$result['courses'] = [];
							//echo $data = json_encode(['Message' => 'No course Enrol for this user']);
						}
					} else {
						$status = 0;
						$message = 'No User Found';
						$result = [];
						//   echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}

				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_duein2days_courses":
			try {
				$status = 0;
				$message = '';
				$result = array();
				$employee_code  = $_POST['employee_code'];
				$company_code   = $_POST['company_code'];
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;

				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					//print_r($query_fetch_user);
					if (!empty($query_fetch_user)) {
						$userid       = $query_fetch_user->userid;
						$username     = $query_fetch_user->username;
						$type = "duein2days";
						$res = get_enrolled_courses($userid, $type, $page, $limit);
						if ($res != null) {

							$status = 1;
							$message = '';
							$result['courses'] = $res;
							//echo $data = json_encode($returndata);

						} else {
							$status = 0;
							$message = 'No course Enrol for this user';
							$result['courses'] = [];
							//echo $data = json_encode(['Message' => 'No course Enrol for this user']);
						}
					} else {
						$status = 0;
						$message = 'No User Found';
						$result = [];
						//   echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}

				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_all_type_enrolled_courses":
			try {
				$status = 0;
				$message = '';
				$result = array();
				$employee_code  = $_POST['employee_code'];
				$company_code   = $_POST['company_code'];
				$page           = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit          = isset($_POST['limit']) ? $_POST['limit'] : 10;

				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					//print_r($query_fetch_user);
					if (!empty($query_fetch_user)) {
						$userid       = $query_fetch_user->userid;
						$username     = $query_fetch_user->username;
						$type = "all";
						$res = get_enrolled_courses($userid, $type, $page, $limit);
						if ($res != null) {

							$status = 1;
							$message = '';
							$result['courses'] = $res;
							//echo $data = json_encode($returndata);

						} else {
							$status = 0;
							$message = 'No course Enrol for this user';
							$result['courses'] = [];
							//echo $data = json_encode(['Message' => 'No course Enrol for this user']);
						}
					} else {
						$status = 0;
						$message = 'No User Found';
						$result = [];
						//   echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}

				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_enrolled_courses":
			try {
				$status = 0;
				$message = '';
				$result = array();
				$employee_code  = $_POST['employee_code'];
				$company_code   = $_POST['company_code'];
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
				//echo $page."====".$limit;die;
				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid,u.username FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					//print_r($query_fetch_user);
					if (!empty($query_fetch_user)) {
						$userid       = $query_fetch_user->userid;
						$username     = $query_fetch_user->username;
						$type = "enrolled";
						$res = get_enrolled_courses($userid, $type, $page, $limit);
						
						if ($res != null && $res['totalCount']>0 ) {
							$res['courseflag'] = $type;
							$status = 1;
							$message = '';
							$result = $res;							
						} else {
							$res1 = get_all_courses($userid,$page, $limit);
							if($res1 != null &&  $res1['totalCount']>0)
							{
								$res1['courseflag'] = 'allcourses';
								$status = 1;
								$message = '';
								$result = $res1;
								//echo $data = json_encode($returndata);								
							}
							else
							{
								$status = 0;
								$message = 'No Course Found';
								$result['courses'] = [];
							}
						}
					} else {
						$status = 0;
						$message = 'No User Found';
						$result = [];
						//   echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}

				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_ilt_calendar":
			try {
				$employee_code = $_POST['employee_code'];
				$company_code  = $_POST['company_code'];
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
				//  $session_type  = $_POST['session_type'];
				$qry 		   = "";
				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						foreach ($query_fetch_user as $rs_fetch_user) {
							$fetch_user_data =  $rs_fetch_user;
						}

						$userid = $fetch_user_data->userid;
						$ctime = time();

						$fetch_event_data = get_ilt_calendar_query($userid, $page, $limit);
						if (count($fetch_event_data) > 0) {
							$status = 1;
							$message = '';
							$result = $fetch_event_data;
						} else {
							$status = 0;
							$message = 'No Event Data Found';
							$result = $fetch_event_data;
							//print_r($fetch_event_data);die;
						}
					} else {
						$status = 0;
						$message = 'Invalid User';
						$result = [];
						//echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_due_immediate_activities":
			try {
				$employee_code = $_POST['employee_code'];
				$company_code  = $_POST['company_code'];
				$duedays 			 = isset($_POST['duedays']) ? $_POST['duedays'] : 0;
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
				//  $session_type  = $_POST['session_type'];
				$qry 		   = "";
				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						foreach ($query_fetch_user as $rs_fetch_user) {
							$fetch_user_data =  $rs_fetch_user;
						}

						$userid = $fetch_user_data->userid;

						$activities = get_due_immediate_activities($userid, $duedays, $page, $limit);
						// print_r($activities);
						$status = 1;
						$message = '';
						$result = $activities;
					} else {
						$status = 0;
						$message = 'Invalid User';
						$result = [];
						//echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		case "get_due_activities":
			try {
				$employee_code = $_POST['employee_code'];
				$company_code  = $_POST['company_code'];
				$duedays 			 = isset($_POST['duedays']) ? $_POST['duedays'] : 1;
				$duestartdays		 = isset($_POST['duestartdays']) ? $_POST['duestartdays'] : 0;
				$page                = isset($_POST['page']) ? $_POST['page'] : 1;
				$limit               = isset($_POST['limit']) ? $_POST['limit'] : 10;
				//  $session_type  = $_POST['session_type'];
				$qry 		   = "";
				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						foreach ($query_fetch_user as $rs_fetch_user) {
							$fetch_user_data =  $rs_fetch_user;
						}

						$userid = $fetch_user_data->userid;

						$activities = get_due_activities($userid, $duestartdays,$duedays, $page, $limit);
						// print_r($activities);
						$status = 1;
						$message = '';
						$result = $activities;
					} else {
						$status = 0;
						$message = 'Invalid User';
						$result = [];
						//echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
			
		case "get_learning_plan_percentage":
			try {
				$employee_code = $_POST['employee_code'];
				$company_code  = $_POST['company_code'];
				$qry 		   = "";
				if ($employee_code != '' && $company_code != '') {
					$query_fetch_user = $DB->get_records_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						foreach ($query_fetch_user as $rs_fetch_user) {
							$fetch_user_data =  $rs_fetch_user;
						}

						$userid = $fetch_user_data->userid;

						$planpercentage = get_learning_plan_percentage($userid);
						if ($planpercentage['msg'] == "") {
							$status = 0;
						} else {
							// print_r($planpercentage);
							$status = 1;
						}
						$message = $planpercentage['msg'];
						unset($planpercentage['msg']);
						$result = $planpercentage;
					} else {
						$status = 0;
						$message = 'Invalid User';
						$result = [];
						//echo $data = json_encode(['Message'=>'Invalid Api Token']);
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = [];
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
			break;
		case "get_site_logo":
			
			try {
				$status = 0;
				$ressage = '';
				$result = array();
				/*$company_code   =  $_POST['company_code'];
				$employee_code  =  $_POST['employee_code'];
				if ($company_code != '' && $employee_code != '') {
					$query_fetch_user = $DB->get_record_sql("SELECT u.id as userid FROM mdl_user as u WHERE u.employee_code = '$employee_code' && u.company_code = '$company_code'");
					if (!empty($query_fetch_user)) {
						$userid = $query_fetch_user->userid;*/
						$context = context_system::instance();
						$PAGE->set_context($context);
						if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo1') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo1') && !empty($OUTPUT->get_theme_image_headerlogo1())){
							  $headerlogo1 =(string) $OUTPUT->get_theme_image_headerlogo1(null, 100);
							} else {
							  $headerlogo1 = $CFG->wwwroot . '/theme/edumy/images/header-logo.png';
							}
							if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo2') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo2') && !empty($OUTPUT->get_theme_image_headerlogo2())){
							  $headerlogo2 = (string)$OUTPUT->get_theme_image_headerlogo2(null, 100);
							} else {
							  $headerlogo2 = $CFG->wwwroot . '/theme/edumy/images/header-logo2.png';
							}
							if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo3') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo3') && !empty($OUTPUT->get_theme_image_headerlogo3())){
							  $headerlogo3 = (string)$OUTPUT->get_theme_image_headerlogo3(null, 100);
							} else {
							  $headerlogo3 = $CFG->wwwroot . '/theme/edumy/images/header-logo4.png';
							}
							if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_headerlogo_mobile') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_headerlogo_mobile') && !empty($OUTPUT->get_theme_image_headerlogo_mobile())){
							  $headerlogo_mobile = (string)$OUTPUT->get_theme_image_headerlogo_mobile(null, 100);
							} else {
							  $headerlogo_mobile = $CFG->wwwroot . '/theme/edumy/images/header-logo.png';
							}
							if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_footerlogo1') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_footerlogo1') && !empty($OUTPUT->get_theme_image_footerlogo1())){
							  $footerlogo1 =(string) $OUTPUT->get_theme_image_footerlogo1(null, 100);
							} else {
							  $footerlogo1 = $CFG->wwwroot . '/theme/edumy/images/header-logo.png';
							}
							if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_heading_bg') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_heading_bg') && !empty($OUTPUT->get_theme_image_heading_bg())){
							  $heading_bg = (string)$OUTPUT->get_theme_image_heading_bg(null, 100);
							} else {
							  $heading_bg = $CFG->wwwroot . '/theme/edumy/images/background/inner-pagebg.jpg';
							}
							if(method_exists('theme_edumy\output\core_renderer', 'get_theme_image_favicon') && method_exists('theme_edumy\output\core_renderer_maintenance', 'get_theme_image_favicon') && !empty($OUTPUT->get_theme_image_favicon())){
							  $favicon = (string)$OUTPUT->get_theme_image_favicon(null, 100);
							} else {
							  $favicon = $CFG->wwwroot . '/theme/edumy/pix/favicon.ico';
							}
							$ccnSettingLogoUrl = get_config('theme_edumy', 'logo_url');
							$logo_image_width = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_width'));
							$logo_image_height = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_height'));
							$logo_image_width_footer = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_width_footer'));
							$logo_image_height_footer = preg_replace("/[^0-9]/", "", get_config('theme_edumy', 'logo_image_height_footer'));
							$logo_styles = '';
							if ($logo_image_width) {
							  $logo_styles .= 'width:'.$logo_image_width.'px;max-width:none!important;';
							}
							if ($logo_image_height) {
							  $logo_styles .= 'height:'.$logo_image_height.'px;max-height:none!important;';
							}
							$logo_styles_footer = '';
							if ($logo_image_width_footer) {
							  $logo_styles_footer .= 'width:'.$logo_image_width_footer.'px;max-width:none!important;';
							}
							if ($logo_image_height_footer) {
							  $logo_styles_footer .= 'height:'.$logo_image_height_footer.'px;max-height:none!important;';
							}
							$ccnLogoUrl = $CFG->wwwroot;
							if(!empty($ccnSettingLogoUrl) && $ccnSettingLogoUrl !== ''){
							  $ccnLogoUrl = $ccnSettingLogoUrl;
							}
						
						$status = 1;
						$message = '';

						$result = array();
						$result['header_logo_light'] = $headerlogo1;
						$result['header_logo_dark'] = $headerlogo2;
						$result['header_logo_large'] = $headerlogo3;
						$result['header_logo_mobile'] = $headerlogo_mobile;
						$result['footer_logo'] =$footerlogo1;
						$result['header_bg'] =$heading_bg;
						$result['favicon'] = $favicon;
						$result['logo_image_width'] = $logo_image_width;
						$result['logo_image_height'] = $logo_image_height;
						$result['logo_image_width_footer'] = $logo_image_width_footer;
						$result['logo_image_height_footer'] = $logo_image_height_footer;
						$result['ccnLogoUrl'] = $ccnLogoUrl;
/*
					} else {
						$status = 0;
						$message = 'Incorrect Employee Code';
						$result = array();
						//echo $data = json_encode(['Message'=>'Incorrect Employee Code']);	
					}
				} else {
					$status = 0;
					$message = 'Parameters are missing';
					$result = array();
					//echo $data = json_encode(['Message'=>'Parameters are missing']);
				}*/
				$returndata = array();
				$returndata['status'] = $status;
				$returndata['message'] = $message;
				$returndata['result'] = $result;
				echo $data = json_encode($returndata);
			} catch (Exception $e) {
				$message = 'Message: ' . $e->getMessage();
			}
			break;
		
		default:
			# code...
			echo $data = json_encode(['status' => 0, 'message' => 'Function Name Parameter wsfunction is missing', 'result' => []]);
			break;
	}
} else {
	echo $data = json_encode(['status' => 0, 'message' => 'Function Name Parameter wsfunction is missing', 'result' => []]);
}

function site_announcement_query($userid, $newdata = false)
{
	global $DB;
	try {
		$cutoffdate = $now - ($CFG->forum_oldpostdays * 24 * 60 * 60);
		$sql = 'SELECT f.id as forumid, COUNT(p.id) AS cnt
              FROM mdl_forum_discussions d
                   JOIN mdl_forum_posts p     ON p.discussion = d.id
                   LEFT JOIN mdl_forum_read r ON (r.postid = p.id AND r.userid = ' . $userid . ')
                   JOIN mdl_forum AS f ON d.forum = f.id
                   JOIN mdl_user AS u ON p.userid = u.id
             WHERE d.forum = (SELECT id FROM mdl_forum WHERE course=1 AND TYPE="news" AND NAME="Site announcements")';
		if ($newdata == true) {
			$sql .= 'AND p.modified >= ' . $cutoffdate . ' AND r.id is NULL';
		}
		$sql .= ' GROUP BY f.id';
		/*$sql= 'SELECT COUNT(*) AS cnt ,f.id as forumid
					FROM mdl_forum AS f
					JOIN mdl_forum_discussions AS fd ON f.id = fd.forum
					JOIN mdl_forum_posts AS fp ON fd.id = fp.discussion
					JOIN mdl_user AS u ON  fd.userid =u.id 
					WHERE fd.userid ='.$userid.($newdata==true?' and fp.created >u.lastaccess ':'').
					' GROUP BY f.id
					HAVING f.id =(SELECT id FROM mdl_forum WHERE course=1 AND TYPE="news" AND NAME="Site announcements")';*/
		//echo $sql;
		$annres = $DB->get_record_sql($sql);
		$announcement_count = 0;
		if ($annres != null) {
			$announcement_count = $annres->cnt;
			$forumid = $annres->forumid;
		}
		else{
			$sql = 'SELECT id FROM mdl_forum WHERE course=1 AND TYPE="news" AND NAME="Site announcements"';
			$rs = $DB->get_record_sql($sql);
			if($rs != null){
				$forumid = $rs->id;
			}
			else{
				$forumid =0;
			}
		}
		$arr = array();
		$arr['announcement_count'] = $announcement_count;
		$arr['forumid'] = $forumid;
		//print_r($arr);

	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
	return $arr;
}
function notification_query($userid, $newdata = false)
{
	global $DB;
	try {
		$sql = "SELECT count(1) as cnt FROM {notifications}  WHERE  id IN (SELECT notificationid FROM {message_popup_notifications}) AND useridto =" . $userid . " ";
		if ($newdata == true) {
			$sql .= " AND timeread IS NULL";
		}
		//echo "<BR>". $sql;
		$annres = $DB->get_record_sql($sql);
		$notification_count = 0;
		if ($annres != null) {
			$notification_count = $annres->cnt;
		}
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
	return $notification_count;
}
function badges_query($userid)
{
	global $DB;
	try {
		$sql = "SELECT count(*) as cnt from mdl_badge_issued as bi join mdl_badge as b on bi.badgeid=b.id where bi.userid =" . $userid . "";
		$annres = $DB->get_record_sql($sql);
		$badges_count = 0;
		if ($annres != null) {
			$badges_count = $annres->cnt;
		}
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
	return $badges_count;
}
function messages_query($userid, $newdata = false)
{
	global $DB;
	try {
		/*$sql= 'SELECT COUNT(1) as cnt
			FROM mdl_messages AS m
			JOIN mdl_message_conversations AS mc ON mc.id = m.conversationid
			JOIN mdl_message_conversation_members AS mcm ON mcm.conversationid = mc.id
			JOIN mdl_user AS u ON mcm.userid = u.id
			WHERE mcm.userid ='.$userid ;
		if($newdata == true){
			$sql .= " and m.timecreated >u.lastaccess ";
		}
		*/
		$sql = ' SELECT count(1) as cnt
              FROM mdl_messages m
		        INNER JOIN mdl_message_conversations mc
		                ON mc.id = m.conversationid
		        INNER JOIN mdl_message_conversation_members mcm
		                ON mcm.conversationid = mc.id
		         LEFT JOIN mdl_message_user_actions mua
		                ON (mua.messageid = m.id AND mua.userid = ' . $userid . ' AND (mua.action = 2 OR mua.action = 1))
		             WHERE mua.id IS NULL
               AND mcm.userid = ' . $userid;
		if ($newdata == true) {
			$sql .= ' AND m.useridfrom <>' . $userid;
		}
		//     echo "<BR>".$sql;die;
		$annres = $DB->get_record_sql($sql);
		//print_r($annres);
		$message_count = 0;
		if ($annres != null) {
			$message_count = $annres->cnt;
		}
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
	return $message_count;
}
function calendar_query($userid, $newdata = false)
{
	global $DB;
	try {
		$sql = 'SELECT count(1) as cnt
						FROM mdl_event AS e 
						JOIN mdl_user AS u ON e.userid = u.id
						WHERE e.userid=' . $userid. " " . ($newdata == true ? ' and e.timestart >u.lastaccess ' : '');
		//echo $sql;
		$annres = $DB->get_record_sql($sql);
		$calendar_count = 0;
		if ($annres != null) {
			$calendar_count = $annres->cnt;
		}
		return $calendar_count;
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
}
function files_query($userid)
{
	global $DB;
	try {
		$sql = "SELECT COUNT(1) as cnt
						FROM mdl_files AS f
						 WHERE userid =" . $userid . " AND component ='user' AND filearea='private' AND source IS NOT NULL";
		//echo $sql;
		$annres = $DB->get_record_sql($sql);
		$files_count = 0;
		if ($annres != null) {
			$files_count = $annres->cnt;
		}
		return $files_count;
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
}
function courses_query($userid, $type = "")
{
	global $DB;
	try {
		if ($type != "") {
			$sql = "SELECT COUNT(1) as cnt FROM mdl_user AS u
						LEFT JOIN mdl_user_enrolments ue ON ue.userid = u.id
						LEFT JOIN mdl_enrol e ON e.id = ue.enrolid
						LEFT JOIN mdl_course c ON e.courseid = c.id 
						WHERE u.id=" . $userid . " AND c.visible = 1 AND c.category != 0 ";
			if ($type == "SELF_ENROL") {
				$sql .= ' AND ue.modifierid=' . $userid;
			}
			//echo "<BR>".$sql;
			//echo $sql;
			$annres = $DB->get_record_sql($sql);
			$courses_count = 0;
			if ($annres != null) {
				$courses_count = $annres->cnt;
			}

			return $courses_count;
		}
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
}
function iltsession_query($userid)
{
	global $DB, $CFG;
	try {
		//echo $CFG->dbname;
		$dbname = $CFG->dbname;
		//$dbname = "zinglearn";
		//echo $dbname;
		$checksql = 'SELECT (EXISTS(SELECT 1 FROM information_schema.tables WHERE table_schema = "' . $dbname . '" AND table_name = "mdl_zingilt")) AS zingiltexist,
       							(EXISTS(SELECT 1 FROM information_schema.tables WHERE table_schema = "' . $dbname . '" AND table_name = "mdl_facetoface")) AS f2fexist';
		//echo "<BR>".$checksql;//die;
		$rs = $DB->get_record_sql($checksql);
		//print_r($rs);
		if ($rs->zingiltexist == 1 && $rs->f2fexist == 1) {
			//union query
			//die("here");
			$sql = "SELECT COUNT(*) AS sessionCount FROM
					(SELECT COUNT(1) AS cnt
					FROM mdl_facetoface AS f
					JOIN mdl_facetoface_sessions  AS s ON f.id =s.facetoface
					JOIN mdl_facetoface_signups AS fs ON fs.sessionid = s.id
					JOIN mdl_facetoface_signups_status AS fss ON (fs.id=fss.signupid AND statuscode = 70)
					WHERE fs.userid =" . $userid . "
					UNION 
					SELECT COUNT(1) AS cnt
					FROM mdl_zingilt AS f
					JOIN mdl_zingilt_sessions  AS s ON f.id =s.zingilt
					JOIN mdl_zingilt_signups AS fs ON fs.sessionid = s.id
					JOIN mdl_zingilt_signups_status AS fss ON (fs.id=fss.signupid AND statuscode = 70)
					WHERE fs.userid =" . $userid . ") AS utable	";
		} else if ($rs->zingiltexist == 1 && $rs->f2fexist == 0) {
			//only zingilt query
			$sql = "SELECT COUNT(1) AS sessionCount
					FROM mdl_zingilt AS f
					JOIN mdl_zingilt_sessions  AS s ON f.id =s.zingilt
					JOIN mdl_zingilt_signups AS fs ON fs.sessionid = s.id
					JOIN mdl_zingilt_signups_status AS fss ON (fs.id=fss.signupid AND statuscode = 70)
					WHERE fs.userid =" . $userid;
		} else if ($rs->zingiltexist == 0 && $rs->f2fexist == 1) {
			//only f2fquery
			$sql = "SELECT COUNT(1) AS sessionCount
					FROM mdl_facetoface AS f
					JOIN mdl_facetoface_sessions  AS s ON f.id =s.facetoface
					JOIN mdl_facetoface_signups AS fs ON fs.sessionid = s.id
					JOIN mdl_facetoface_signups_status AS fss ON (fs.id=fss.signupid AND statuscode = 70)
					WHERE fs.userid =" . $userid;
		} else {
			return 0;
		}

		//	echo "<BR>".$sql;
		//echo $sql;
		$annres = $DB->get_record_sql($sql);
		//print_r($annres);
		$session_count = 0;
		if ($annres != null) {
			$session_count = $annres->sessioncount;
		}

		return $session_count;
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
}
function get_enrolled_courses($userid, $type = "all", $page = 1, $limit = 10)
{
	global $DB;
	$currenttime  = time();
	$time         = time();
	$paginationStart = ($page - 1) * $limit;

	$cond = '';
	switch ($type) {
		case "inprogress":
			$cond = " AND (c.startdate <= " . $currenttime . " AND (c.enddate >= " . $currenttime . " OR c.enddate =0))";
			break;
		case "past":
			$cond = " AND (c.enddate < " . $currenttime . " && c.enddate != 0)";
			break;
		case "future":
			$cond = " AND (c.startdate > " . $currenttime . ")";
			break;
		case "duein2days":
			$time2    = $time + (60 * 60 * 24 * 2);
			$cond = " AND(c.enddate < " . $time2 . " && c.enddate != 0)";
			break;
		case "enrolled":
			$cond = "";
			break;
		default:
			$cond = "";
			//return $completionstatus;	
			break;
	}
	//getting the Total courses count query
	$enrolledcountsql = "SELECT count(c.id) as total 
			                FROM {user} as  u
			                LEFT JOIN {user_enrolments} as ue ON ue.userid = u.id
			                LEFT JOIN {enrol} as e ON e.id = ue.enrolid
			                LEFT JOIN {course} as c ON e.courseid = c.id 
			                LEFT JOIN {course_categories} AS cc ON c.category = cc.id
			                WHERE u.id=" . $userid . " and c.visible = 1 and c.category != 0 " . $cond . "
			                order by c.fullname asc";
	//echo $enrolledcountsql; 
	$total_countrs =  $DB->get_record_sql($enrolledcountsql); //print_r($total_countrs);
	$totalCount  = (!empty($total_countrs) ? $total_countrs->total : 0);
	// Calculate total pages
	$totalPages = ceil($totalCount / $limit);
	//Fetching all the enrolled courses query 
	$sql = "SELECT c.id AS courseid,c.fullname as coursefullname,c.summary as 'summary',c.category as categoryid, cc.name AS 'categoryname',c.startdate as 'startdate',c.enddate as 'enddate',
				@total := (SELECT COUNT(1) FROM mdl_course_modules AS cm WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cm.course =c.id) AS totalmodule,
				@com := (SELECT COUNT(1) FROM mdl_course_modules AS cm  
				JOIN mdl_course_modules_completion  AS cmc ON cm.id  = cmc.coursemoduleid 
				WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cmc.completionstate = 1 
				AND  cm.course =c.id AND cmc.userid =" . $userid . "
				) AS completedmodule,
				  @lastaccessactivity := (SELECT cm.id FROM mdl_course_modules AS cm 
			JOIN mdl_course_modules_completion AS cmc ON cm.id = cmc.coursemoduleid 
			WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cmc.completionstate = 1 
			AND cm.course =c.id AND cmc.userid =u.id ORDER BY cmc.timemodified DESC LIMIT 1
				) AS lastaccessmodule,
				@lastaccessactivityname := (SELECT m.name FROM mdl_course_modules  AS cm JOIN mdl_modules AS m ON cm.module = m.id
					WHERE cm.id = @lastaccessactivity LIMIT 1
				) AS lastaccessmodulename,

				IF(@total =@com,'completed','not completed') AS completionstatus 
                FROM {user} u
                LEFT JOIN {user_enrolments} ue ON ue.userid = u.id
                LEFT JOIN {enrol} e ON e.id = ue.enrolid
                LEFT JOIN {course} c ON e.courseid = c.id 
                LEFT JOIN {course_categories} AS cc ON c.category = cc.id
                WHERE u.id=" . $userid . " and c.visible = 1 and c.category != 0 
                group by c.id
                order by c.fullname asc
                LIMIT $paginationStart, $limit ";
	//  echo $sql;
	$query_course = $DB->get_records_sql($sql);
	//	print_r($query_course);	                
	$completionstatus      =  array();
	$finalCompletionModule =  0;
	$finalTotalModule      =  0;
	$overall               = array();
	if ($query_course != null) {
		$datewisemodule   = array();
		$datewisetimeline = array();
		$enrolled_course  = array();
		$completionstatus['past'] = [];
		$completionstatus['future'] = [];
		$completionstatus['inprogress'] = [];
		$completionstatus['duein2days'] = [];
		$completionstatus['enrolled'] = [];

		foreach ($query_course as $rs_course) {
			$enrolled_course[]  = $rs_course;
			$rs_course->summary = strip_tags(str_replace("&nbsp;", " ",$rs_course->summary));
			$courseid           = $rs_course->courseid;
			$startdate          = $rs_course->startdate;
			$enddate            = $rs_course->enddate;

			$finalTotalModule       = $finalTotalModule + $rs_course->totalmodule;
			$finalCompletionModule  = $finalCompletionModule + $rs_course->completedmodule;
			$completionpercent      = (int) (($rs_course->completedmodule / $rs_course->totalmodule) * 100);
			$rs_course->completepercent = $completionpercent;
			$rs_course->courseimage = course_image($rs_course->courseid);
			$rs_course->courselink = (string)new moodle_url("/course/view.php", array("id" => $rs_course->courseid));
			if($rs_course->lastaccessmodulename!= null && $rs_course->lastaccessmodule != null){
				$rs_course->lastactivitylink = (string)new moodle_url("/mod/".$rs_course->lastaccessmodulename."/view.php", array("id" => $rs_course->lastaccessmodule));
			}
			else{
				$rs_course->lastactivitylink = '';
			}

			//print_r($enddate); exit();


			if ($enddate < $currenttime && $enddate != 0) {
				$completionstatus['past'][] = $rs_course;
			} else if ($startdate > $currenttime) {
				$completionstatus['future'][] = $rs_course;
			} else {
				$completionstatus['inprogress'][] = $rs_course;
			}

			$time2    = $time + (60 * 60 * 24 * 2);
			if ($enddate < $time2 && $enddate != 0) {
				$completionstatus['duein2days'][] = $rs_course;
			}
		}
		// $enrolled_course=implode(',',$enrolled_course);
		$coursesData = array();
		$coursesData['totalCount'] = $totalCount;
		$coursesData['totalPages'] = $totalPages;
		$coursesData['pageNo'] = $page;
		$coursesData['pageSize'] = $limit;
		switch ($type) {
			case "enrolled":
				$coursesData['courses'] = $enrolled_course;
				break;
			case "inprogress":
				$coursesData['courses'] = $completionstatus['inprogress'];
				break;
			case "past":
				$coursesData['courses'] = $completionstatus['past'];
				break;
			case "future":
				$coursesData['courses'] = $completionstatus['future'];
				break;
			case "duein2days":
				$coursesData['courses'] = $completionstatus['duein2days'];
				break;
			default:
				$coursesData['courses'] = $completionstatus;
				//return $completionstatus;	
				break;
		}
		return $coursesData;
	} else {
		return [];
		//echo $data = json_encode(['Message' => 'No course Enrol for this user']);
	}
}
function course_image($cid)
{
	global $CFG;

	$courseid = new stdClass();
	$courseid->id = $cid;

	$course   = new core_course_list_element($courseid);
	$imageurl = '';
	$outputimage = '';
	foreach ($course->get_course_overviewfiles() as $file) {
		if ($file->is_valid_image()) {
			$imagepath = '/' . $file->get_contextid() .
				'/' . $file->get_component() .
				'/' . $file->get_filearea() .
				$file->get_filepath() .
				$file->get_filename();
			$imageurl = file_encode_url(
				$CFG->wwwroot . '/pluginfile.php',
				$imagepath,
				false
			);

			/* $outputimage = html_writer::tag('div',
		                html_writer::empty_tag('img', array('src' => $imageurl)),
		                array('class' => 'courseimage'));*/


			// Use the first image found.
			break;
		}
	}
	// return $outputimage;
	return $imageurl;
}
function get_ilt_calendar_query($userid, $page = 1, $limit = 10)
{
	global $DB;
	$eventData = array();
	$fetch_event_data = array();
	try {
		$paginationStart = ($page - 1) * $limit;
		//getting the Total event count query
		$enrolledcountsql = "SELECT count(1) as total 
			                FROM  mdl_event AS e 
					WHERE (e.userid = $userid or e.eventtype='facetofacesession' OR e.eventtype='zingiltsession' )
                	AND  DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d')  AND e.courseid <> 0
                	ORDER BY e.timestart DESC";
		//echo $enrolledcountsql; 
		$total_countrs =  $DB->get_record_sql($enrolledcountsql); //print_r($total_countrs);
		$totalCount  = (!empty($total_countrs) ? $total_countrs->total : 0);
		// Calculate total pages
		$totalPages = ceil($totalCount / $limit);

		$qry = "SELECT e.id, e.name, e.description,e.courseid,e.instance,e.timestart,(e.timestart+e.timeduration) AS enddate,e.userid,e.eventtype ,
                	e.uuid,
                	CASE 
					   WHEN e.eventtype ='facetofacesession' AND e.uuid<>'' THEN
						IF((SELECT facetoface FROM mdl_facetoface_sessions WHERE id = e.uuid)>0,(SELECT facetoface FROM mdl_facetoface_sessions WHERE id = e.uuid),'0')
					   WHEN e.eventtype ='zingiltsession' AND e.uuid<>'' THEN
						IF((SELECT zingilt FROM mdl_zingilt_sessions WHERE id = e.uuid)>0,(SELECT zingilt FROM mdl_zingilt_sessions WHERE id = e.uuid),'0') 
					   ELSE
						''
					END AS iltid
					FROM  mdl_event AS e 
					WHERE (e.userid = $userid or e.eventtype='facetofacesession' OR e.eventtype='zingiltsession' )
                	AND  DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP, '%Y-%m-%d')  AND e.courseid <> 0
                	ORDER BY e.timestart DESC
                	 LIMIT $paginationStart, $limit ";
		/*   else
             	
                {
                	$qry="SELECT e.id, e.name, e.description,e.courseid,DATE_FORMAT(FROM_UNIXTIME(`timestart`), '%Y-%m-%d') as timestart,e.timemodified FROM  mdl_event as e WHERE (e.userid=$userid OR e.eventtype='facetofacesession')  ORDER BY e.timestart DESC";
                }*/
		// echo $qry; 
		$query_fetch_event = $DB->get_records_sql($qry);
		$status    = 0;
		$get_desc  = "";
		$message = "Session Not Available.";
		//print_r($query_fetch_event);
		foreach ($query_fetch_event as $rs_fetch_event) {
			$get_desc   = strip_tags($rs_fetch_event->description);
			$desc_assoc = explode("\n\n", $get_desc);
			$dec_object = [];

			foreach ($desc_assoc as $dkey => $dvalue) {
				if ($dvalue) {
					$desc_detail_assoc = explode("\n", trim($dvalue));
					$dec_object[$desc_detail_assoc[0]] = $desc_detail_assoc[1];
				}
			}
			if ($dec_object != null) {
				$rs_fetch_event->description = $dec_object;
			} else {
				$rs_fetch_event->description = '';
			}
			if ($rs_fetch_event->iltid != 0) {
				switch ($rs_fetch_event->eventtype) {
					case "zingiltsession":
						$rs_fetch_event->eventurl = (string)new moodle_url("/mod/zingilt/view.php", array("f" => $rs_fetch_event->iltid));
						break;
					case "facetofacesession":
						$rs_fetch_event->eventurl = (string)new moodle_url("/mod/facetoface/view.php", array("f" => $rs_fetch_event->iltid));
						break;
					default:
						$rs_fetch_event->eventurl = (string)new moodle_url("/course/view.php", array("id" => $rs_fetch_event->courseid));
						break;
				}
			} else {
				$rs_fetch_event->eventurl = (string)new moodle_url("/course/view.php", array("id" => $rs_fetch_event->courseid));
			}
			$fetch_event_data[] =  $rs_fetch_event;
		}

		$eventData['totalCount'] = $totalCount;
		$eventData['totalPages'] = $totalPages;
		$eventData['pageNo'] = $page;
		$eventData['pageSize'] = $limit;
		$eventData['events'] = $fetch_event_data;
	} catch (Exception $e) {
		return 'Message: ' . $e->getMessage();
	}
	return $eventData;
}
function get_due_activities($userid,$duestartdays=0, $duedays = 1, $page = 1, $limit = 10)
{
	global $DB;
	$time = time();
	$paginationStart = ($page - 1) * $limit;
	$activityData = array();
	// if($duedays >7){
	// 	$duestartdays =7;
	// }
	// else{
	// 	$duestartdays =0;
	// }
	//for totalcount query
	$countsql = "SELECT count(1) as total FROM 
					(SELECT  cm.id,c.id AS 'courseid',c.fullname AS 'coursename',
		                IF((SELECT ue.id FROM mdl_user_enrolments AS ue JOIN mdl_enrol AS e ON ue.enrolid =e.id WHERE ue.userid = u.id AND e.courseid =c.id)IS NULL,FALSE,TRUE) AS isenrolled,
		                m.name AS activitytype,
		                (CASE
		                WHEN m.name = 'assign' THEN (SELECT NAME FROM mdl_assign WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
		                WHEN m.name = 'quiz' THEN (SELECT NAME FROM mdl_quiz WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
		                WHEN m.name = 'scorm' THEN (SELECT NAME FROM mdl_scorm WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
		                WHEN m.name = 'feedback' THEN (SELECT NAME FROM mdl_feedback WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
		               # WHEN m.name = 'forum' then (select name from mdl_forum where id = cm.instance  ORDER BY id desc limit 1)
		                ELSE '-'
		                END) AS 'activityname',
		                @duedate := (CASE
		                WHEN m.name = 'assign' THEN (SELECT duedate FROM mdl_assign WHERE id = cm.instance AND duedate!=0 ORDER BY id DESC LIMIT 1)
		                WHEN m.name = 'quiz' THEN (SELECT timeclose FROM mdl_quiz WHERE id = cm.instance AND timeclose !=0 ORDER BY id DESC LIMIT 1)
		                WHEN m.name = 'scorm' THEN (SELECT timeclose FROM mdl_scorm WHERE id = cm.instance AND timeclose !=0 ORDER BY id DESC LIMIT 1)
		                WHEN m.name = 'feedback' THEN (SELECT timeclose FROM mdl_feedback WHERE id = cm.instance AND timeclose !=0 ORDER BY id DESC LIMIT 1)
		                #WHEN m.name = 'forum' THEN (SELECT duedate FROM mdl_forum WHERE id = cm.instance and duedate != 0  ORDER BY id DESC LIMIT 1)
		                #ELSE 0
		                END) AS 'activityduedate'
		                ,IF((SELECT cmc.completionstate FROM mdl_course_modules_completion AS cmc WHERE cmc.coursemoduleid = cm.id AND cmc.userid=u.id)>0 ,TRUE,FALSE) AS 'iscompleted'
		                FROM mdl_user AS u ,mdl_course AS c 
		                JOIN `mdl_course_modules` AS cm ON c.id = cm.course
		                JOIN mdl_modules AS m ON cm.module =m.id
		                ,(SELECT @s:= 0) AS s
		                WHERE u.id !=1 AND m.name IN('assign','quiz','scorm','feedback') 
		                AND u.id= 2 
		         ORDER BY `u`.`id` ASC) AS tmp
		         WHERE isenrolled = TRUE  and iscompleted = FALSE AND activityduedate IS NOT NULL  
		         AND TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) <= $duedays AND TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) >=$duestartdays
		         ORDER BY activityduedate";
	//echo $enrolledcountsql; 
	$total_countrs =  $DB->get_record_sql($countsql); //print_r($total_countrs);
	$totalCount  = (!empty($total_countrs) ? $total_countrs->total : 0);
	// Calculate total pages
	$totalPages = ceil($totalCount / $limit);
	//for records query
	$sql = "SELECT *,TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) AS daysdiff FROM 
				(SELECT  cm.id,c.id AS 'courseid',c.fullname AS 'coursename',
	                IF((SELECT ue.id FROM mdl_user_enrolments AS ue JOIN mdl_enrol AS e ON ue.enrolid =e.id WHERE ue.userid = u.id AND e.courseid =c.id)IS NULL,FALSE,TRUE) AS isenrolled,
	                m.name AS activitytype,
	                (CASE
	                WHEN m.name = 'assign' THEN (SELECT NAME FROM mdl_assign WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
	                WHEN m.name = 'quiz' THEN (SELECT NAME FROM mdl_quiz WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
	                WHEN m.name = 'scorm' THEN (SELECT NAME FROM mdl_scorm WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
	                WHEN m.name = 'feedback' THEN (SELECT NAME FROM mdl_feedback WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
	               # WHEN m.name = 'forum' then (select name from mdl_forum where id = cm.instance  ORDER BY id desc limit 1)
	                ELSE '-'
	                END) AS 'activityname',
	                @duedate := (CASE
	                WHEN m.name = 'assign' THEN (SELECT duedate FROM mdl_assign WHERE id = cm.instance AND duedate!=0 ORDER BY id DESC LIMIT 1)
	                WHEN m.name = 'quiz' THEN (SELECT timeclose FROM mdl_quiz WHERE id = cm.instance AND timeclose !=0 ORDER BY id DESC LIMIT 1)
	                WHEN m.name = 'scorm' THEN (SELECT timeclose FROM mdl_scorm WHERE id = cm.instance AND timeclose !=0 ORDER BY id DESC LIMIT 1)
	                WHEN m.name = 'feedback' THEN (SELECT timeclose FROM mdl_feedback WHERE id = cm.instance AND timeclose !=0 ORDER BY id DESC LIMIT 1)
	                #WHEN m.name = 'forum' THEN (SELECT duedate FROM mdl_forum WHERE id = cm.instance and duedate != 0  ORDER BY id DESC LIMIT 1)
	                #ELSE 0
	                END) AS 'activityduedate'
	                ,IF((SELECT cmc.completionstate FROM mdl_course_modules_completion AS cmc WHERE cmc.coursemoduleid = cm.id AND cmc.userid=u.id)>0 ,TRUE,FALSE) AS 'iscompleted'
	                FROM mdl_user AS u ,mdl_course AS c 
	                JOIN `mdl_course_modules` AS cm ON c.id = cm.course
	                JOIN mdl_modules AS m ON cm.module =m.id
	                ,(SELECT @s:= 0) AS s
	                WHERE u.id !=1 AND m.name IN('assign','quiz','scorm','feedback') 
	                AND u.id= 2 
	         ORDER BY `u`.`id` ASC) AS tmp
	         WHERE isenrolled = TRUE  and iscompleted = FALSE AND activityduedate IS NOT NULL  
	         AND TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) <= $duedays AND TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) >=$duestartdays
	         ORDER BY activityduedate
	          LIMIT $paginationStart, $limit ";
	//echo $sql;
	$rs = $DB->get_records_sql($sql);
	$activity = array();
	if ($rs != null) {
		foreach ($rs as $r) {
			if ($r->daysdiff != null && $r->daysdiff <= $duedays) {
				$r->activityurl = (string)new moodle_url("/mod/".$r->activitytype."/view.php",array("id"=>$r->id));
				$activity[] = $r;
			}
		}
		
	}
	$activityData['totalCount'] = $totalCount;
		$activityData['totalPages'] = $totalPages;
		$activityData['pageNo'] = $page;
		$activityData['pageSize'] = $limit;
		$activityData['activities'] = $activity;
	return $activityData;
}
function get_due_immediate_activities($userid, $duedays = 0, $page = 1, $limit = 10)
{
	global $DB;
	$time = time();
	$paginationStart = ($page - 1) * $limit;
	$activityData = array();
	//for totalcount query
	$countsql = "SELECT count(1) as total FROM 
					(SELECT  cm.id,c.id AS 'courseid',c.fullname AS 'coursename',
		                IF((SELECT ue.id FROM mdl_user_enrolments AS ue JOIN mdl_enrol AS e ON ue.enrolid =e.id WHERE ue.userid = u.id AND e.courseid =c.id)IS NULL,FALSE,TRUE) AS isenrolled,
		                m.name AS activitytype,
		                (CASE
		                WHEN m.name = 'assign' THEN (SELECT NAME FROM mdl_assign WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
		                ELSE '-'
		                END) AS 'activityname',
		                @duedate := (CASE
		                WHEN m.name = 'assign' THEN (SELECT duedate FROM mdl_assign WHERE id = cm.instance AND duedate!=0 ORDER BY id DESC LIMIT 1)
		                END) AS 'activityduedate',
                     	@gracedate := (CASE
		                WHEN m.name = 'assign' THEN (SELECT cutoffdate FROM mdl_assign WHERE id = cm.instance  ORDER BY id DESC LIMIT 1)
		                END) AS 'activitygracedate'
		                ,IF((SELECT cmc.completionstate FROM mdl_course_modules_completion AS cmc WHERE cmc.coursemoduleid = cm.id AND cmc.userid=u.id)>0 ,TRUE,FALSE) AS 'iscompleted'
		                FROM mdl_user AS u ,mdl_course AS c 
		                JOIN `mdl_course_modules` AS cm ON c.id = cm.course
		                JOIN mdl_modules AS m ON cm.module =m.id
		                ,(SELECT @s:= 0) AS s
		                WHERE u.id !=1 AND m.name IN('assign','quiz','scorm','feedback') 
		                AND u.id= ".$userid." 
		         ORDER BY `u`.`id` ASC) AS tmp
		         WHERE isenrolled = TRUE  and iscompleted = FALSE AND activityduedate IS NOT NULL  
	         		AND TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) <=0
            		 ORDER BY activityduedate";
	//echo $enrolledcountsql; 
	$total_countrs =  $DB->get_record_sql($countsql); //print_r($total_countrs);
	$totalCount  = (!empty($total_countrs) ? $total_countrs->total : 0);
	// Calculate total pages
	$totalPages = ceil($totalCount / $limit);
	//for records query
	$sql = "SELECT *,TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) AS daysdiff FROM 
				(SELECT  cm.id,c.id AS 'courseid',c.fullname AS 'coursename',
		                IF((SELECT ue.id FROM mdl_user_enrolments AS ue JOIN mdl_enrol AS e ON ue.enrolid =e.id WHERE ue.userid = u.id AND e.courseid =c.id)IS NULL,FALSE,TRUE) AS isenrolled,
		                m.name AS activitytype,
		                (CASE
		                WHEN m.name = 'assign' THEN (SELECT NAME FROM mdl_assign WHERE id = cm.instance ORDER BY id DESC LIMIT 1)
		                ELSE '-'
		                END) AS 'activityname',
		                @duedate := (CASE
		                WHEN m.name = 'assign' THEN (SELECT duedate FROM mdl_assign WHERE id = cm.instance AND duedate!=0 ORDER BY id DESC LIMIT 1)
		                END) AS 'activityduedate',
                     	@gracedate := (CASE
		                WHEN m.name = 'assign' THEN (SELECT cutoffdate FROM mdl_assign WHERE id = cm.instance  ORDER BY id DESC LIMIT 1)
		                END) AS 'activitygracedate'
		                ,IF((SELECT cmc.completionstate FROM mdl_course_modules_completion AS cmc WHERE cmc.coursemoduleid = cm.id AND cmc.userid=u.id)>0 ,TRUE,FALSE) AS 'iscompleted'
		                FROM mdl_user AS u ,mdl_course AS c 
		                JOIN `mdl_course_modules` AS cm ON c.id = cm.course
		                JOIN mdl_modules AS m ON cm.module =m.id
		                ,(SELECT @s:= 0) AS s
		                WHERE u.id !=1 AND m.name IN('assign','quiz','scorm','feedback') 
		                AND u.id= ".$userid." 
		         ORDER BY `u`.`id` ASC) AS tmp
	          WHERE isenrolled = TRUE  and iscompleted = FALSE AND activityduedate IS NOT NULL  
	         		AND TIMESTAMPDIFF(DAY,CURRENT_TIMESTAMP,FROM_UNIXTIME(activityduedate)) <=0
            		 ORDER BY activityduedate
	          LIMIT $paginationStart, $limit ";
	//echo $sql;
	$rs = $DB->get_records_sql($sql);
	$activity = array();
	if ($rs != null) {
		foreach ($rs as $r) {
			if ($r->daysdiff != null && $r->daysdiff <= $duedays) {
				$r->activityurl = (string)new moodle_url("/mod/assign/view.php",array("id"=>$r->id));
				$activity[] = $r;
			}
		}
		
	}
	$activityData['totalCount'] = $totalCount;
		$activityData['totalPages'] = $totalPages;
		$activityData['pageNo'] = $page;
		$activityData['pageSize'] = $limit;
		$activityData['activities'] = $activity;
	return $activityData;
}
function get_learning_plan_percentage($userid)
{
	global $DB;
	$sql = "SELECT  cc.courseid AS course_id, p.id AS plan_id, p.name AS plan_name, cf.id AS fameworkid, 
   cf.shortname AS framework_name, c.id AS competencyid,
   c.shortname AS competencyname,c.sortorder,cc.courseid,
   cou.fullname AS coursename, ct.id AS templateid,ct.shortname AS temp_name,
   p.userid AS userid,
   @total := (SELECT COUNT(1) FROM mdl_course_modules AS cm WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cm.course =cou.id) AS totalmodule,
   @com := (SELECT COUNT(1) FROM mdl_course_modules AS cm  
				JOIN mdl_course_modules_completion  AS cmc ON cm.id  = cmc.coursemoduleid 
				WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cmc.completionstate = 1 
				AND  cm.course =cou.id AND cmc.userid =" . $userid . "
				) AS completedmodule,
   IF(@total =@com,'completed','not completed') AS completionstatus 
   FROM mdl_competency_framework AS cf
   JOIN mdl_competency AS c ON c.competencyframeworkid = cf.id
   JOIN mdl_competency_coursecomp AS cc ON cc.competencyid = c.id
   JOIN mdl_course AS cou ON cou.id = cc.courseid
   JOIN mdl_competency_templatecomp AS ctc ON ctc.competencyid = c.id
   JOIN mdl_competency_template AS ct ON ct.id = ctc.templateid
   JOIN mdl_competency_plan AS p ON p.templateid = ct.id
   WHERE ct.visible = 1 AND p.userid = " . $userid . " 
   GROUP BY cf.id,c.id,c.shortname,cc.courseid
   ORDER BY c.sortorder";

	$rs = $DB->get_records_sql($sql);
	//  print_r($rs);
	$totalModules = 0;
	$completedModules = 0;
	$incompletedModules = 0;
	$completionPercent = 0;
	$incompletionPercent = 0;
	$msg = '';
	$plan= array();
	$p= array();
	if ($rs != null) {
		//$plan[$r->plan_id] = new stdClass;
		foreach ($rs as $r) {
			$totalModules += $r->totalmodule;
			$completedModules += $r->completedmodule;
			
			$plan[$r->plan_id]->id = $r->plan_id;
			$plan[$r->plan_id]->name = $r->plan_name;
			
			//$plan[$r->plan_id]->totalModules = isset($plan[$r->plan_id]->totalModules)?$plan[$r->plan_id]->totalModules+$r->totalmodule:$r->totalmodule;
			$p[$r->plan_id]->totalModules = isset($p[$r->plan_id]->totalModules)?$p[$r->plan_id]->totalModules+$r->totalmodule:$r->totalmodule;
			$p[$r->plan_id]->completedModules = isset($p[$r->plan_id]->completedModules)?$p[$r->plan_id]->completedModules+$r->completedmodule:$r->completedmodule;

			$p[$r->plan_id]->incompletedModules = (int)($p[$r->plan_id]->totalModules - $p[$r->plan_id]->completedModules);
				//($completedCourses / $totalCourses) * 100
			$plan[$r->plan_id]->completionPercent = round(($p[$r->plan_id]->completedModules / $p[$r->plan_id]->totalModules) * 100,0);
			$plan[$r->plan_id]->incompletionPercent = round(($p[$r->plan_id]->incompletedModules / $p[$r->plan_id]->totalModules) * 100,0);
			$plan[$r->plan_id]->plan_url = (string) new moodle_url("/admin/tool/lp/competency_course_list.php",array("p"=>$r->plan_id));			
		}
		//print_r($p);
		$incompletedModules = (int)($totalModules - $completedModules);
		//($completedCourses / $totalCourses) * 100
		$completionPercent = round(($completedModules / $totalModules) * 100,0);
		$incompletionPercent = round(($incompletedModules / $totalModules) * 100,0);
	} else {
		$msg = "No Learning Plan Found";
	}
	//echo $totalModules."====".$completedModules."=====".$completionPercent;
	$arr = array();
	//$arr['totalModules'] = $totalModules;
	//$arr['completedModules'] = $completedModules;
	//$arr['incompletedModules'] = $incompletedModules;
	$arr['msg'] = $msg;
	$arr['completionPercent'] = $completionPercent;
	$arr['incompletionPercent'] = $incompletionPercent;
	$arr['plans'] = array_values($plan);
	// print_r($arr);
	return $arr;
}

function get_all_courses($userid,$page = 1, $limit = 10)
{
	global $DB;
	$currenttime  = time();
	$time         = time();
	$paginationStart = ($page - 1) * $limit;

	//getting the Total courses count query
	$enrolledcountsql = "SELECT count(c.id) as total 
			                FROM  {course} as c 
			                LEFT JOIN {course_categories} AS cc ON c.category = cc.id
			                WHERE c.visible = 1 and c.category != 0 
			                order by c.fullname asc";
	//echo $enrolledcountsql; 
	$total_countrs =  $DB->get_record_sql($enrolledcountsql); //print_r($total_countrs);
	$totalCount  = (!empty($total_countrs) ? $total_countrs->total : 0);
	// Calculate total pages
	$totalPages = ceil($totalCount / $limit);
	//Fetching all the enrolled courses query 
	$sql = "SELECT c.id AS courseid,c.fullname as coursefullname,c.summary as 'summary',c.category as categoryid, cc.name AS 'categoryname',c.startdate as 'startdate',c.enddate as 'enddate',
				@total := (SELECT COUNT(1) FROM mdl_course_modules AS cm WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cm.course =c.id) AS totalmodule,
				@com := (SELECT COUNT(1) FROM mdl_course_modules AS cm  
				JOIN mdl_course_modules_completion  AS cmc ON cm.id  = cmc.coursemoduleid 
				WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cmc.completionstate = 1 
				AND  cm.course =c.id AND cmc.userid =" . $userid . "
				) AS completedmodule,
				  @lastaccessactivity := (SELECT cm.id FROM mdl_course_modules AS cm 
			JOIN mdl_course_modules_completion AS cmc ON cm.id = cmc.coursemoduleid 
			WHERE cm.module !=9 AND cm.deletioninprogress = 0 AND cmc.completionstate = 1 
			AND cm.course =c.id AND cmc.userid =" . $userid . " ORDER BY cmc.timemodified DESC LIMIT 1
				) AS lastaccessmodule,
				@lastaccessactivityname := (SELECT m.name FROM mdl_course_modules  AS cm JOIN mdl_modules AS m ON cm.module = m.id
					WHERE cm.id = @lastaccessactivity LIMIT 1
				) AS lastaccessmodulename,

				IF(@total =@com,'completed','not completed') AS completionstatus 
                
                FROM {course} c 
                LEFT JOIN {course_categories} AS cc ON c.category = cc.id
                WHERE c.visible = 1 and c.category != 0 
                group by c.id
                order by c.fullname asc
                LIMIT $paginationStart, $limit ";
	//  echo $sql;
	$query_course = $DB->get_records_sql($sql);
	//	print_r($query_course);	                die;
	$completionstatus      =  array();
	$finalCompletionModule =  0;
	$finalTotalModule      =  0;
	$overall               = array();
	if ($query_course != null) {
		
		$all_course  = array();
		
		foreach ($query_course as $rs_course) {
			
			$rs_course->summary = strip_tags(str_replace("&nbsp;", " ",$rs_course->summary));
			$courseid           = $rs_course->courseid;
			$startdate          = $rs_course->startdate;
			$enddate            = $rs_course->enddate;

			$finalTotalModule       = $finalTotalModule + $rs_course->totalmodule;
			$finalCompletionModule  = $finalCompletionModule + $rs_course->completedmodule;
			$completionpercent      = (int) (($rs_course->completedmodule / $rs_course->totalmodule) * 100);
			$rs_course->completepercent = $completionpercent;
			$rs_course->courseimage = course_image($rs_course->courseid);
			$rs_course->courselink = (string)new moodle_url("/course/view.php", array("id" => $rs_course->courseid));
			if($rs_course->lastaccessmodulename!= null && $rs_course->lastaccessmodule != null){
				$rs_course->lastactivitylink = (string)new moodle_url("/mod/".$rs_course->lastaccessmodulename."/view.php", array("id" => $rs_course->lastaccessmodule));
			}
			else{
				$rs_course->lastactivitylink = '';
			}
			$all_course[]  = $rs_course;
		
		}
		// $all_course=implode(',',$all_course);
		$coursesData = array();
		$coursesData['totalCount'] = $totalCount;
		$coursesData['totalPages'] = $totalPages;
		$coursesData['pageNo'] = $page;
		$coursesData['pageSize'] = $limit;
		$coursesData['courses'] = $all_course;
		
		return $coursesData;
	} else {
		return [];
		//echo $data = json_encode(['Message' => 'No course Enrol for this user']);
	}
}