<?php
//require_once('../../config.php');
//global $CFG;
require_once "{$CFG->libdir}/formslib.php";

class push_notification_form extends moodleform
{

    public function definition()
    {
        global $CFG, $PAGE, $DB;

        $mform = $this->_form;
        $PAGE->requires->jquery();
        $PAGE->requires->js('/local/notifications/amd/src/validate.js');
        $mform->addElement('static', 'showerrors', '', '', array("class" => "red"));
        //subject Text box
        $mform->addElement('text', 'txtsubject', get_string('subject', 'local_notifications'));
        $mform->setType('txtsubject', PARAM_TEXT);
        $mform->addRule('txtsubject', get_string('missingtitle', 'local_notifications'), 'required', null, 'client');

        //Message Textarea
        $mform->addElement('textarea', 'txtmessage', get_string('message', 'local_notifications'));
        $mform->addRule('txtmessage', get_string('missingmessage', 'local_notifications'), 'required', null, 'client');

        $options = array(
            'multiple' => true,
            'noselectionstring' => get_string('cohorts', 'local_notifications'),
        );
        $cohorts = $this->get_all_cohorts();

        $mform->addElement('autocomplete', 'cohortids', get_string('cohorts', 'local_notifications'), $cohorts, $options);

        $uoptions = array(
            'multiple' => true,
            'noselectionstring' => get_string('users', 'local_notifications'),
        );
        $users = $this->get_all_users();

        $mform->addElement('autocomplete', 'userids', get_string('users', 'local_notifications'), $users, $uoptions);
        $frequency = array();
        $frequency['I'] = get_string("immediately", "local_notifications"); //Immediately";
        $frequency['S'] = get_string("scheduled", "local_notifications"); //Scheduled";
		$mform->addElement("select", "frequency", get_string('frequency', 'local_notifications'), $frequency);
        $templateuser = core_date::get_server_timezone_object();
		$choices = core_date::get_list_of_timezones(null, true);
        $mform->addElement('select', 'timezone1', get_string('timezone'), $choices);
        $mform->setDefault('timezone1', $templateuser->getName());
        $userTimezone = new DateTimeZone('UTC');
        $gmtTimezone = new DateTimeZone($templateuser->getName());
        $myDateTime = new DateTime(date("Y-m-d H:i:s"), $gmtTimezone);
        $offset = $userTimezone->getOffset($myDateTime);
        $myInterval=DateInterval::createFromDateString((string)$offset . 'seconds');
        $myDateTime->add($myInterval);
        $result = $myDateTime->format('Y-m-d H:i:s');
        $mform->addElement("date_time_selector", "scheduled_on", get_string("scheduled_on", 'local_notifications'));
        $mform->setDefault('scheduled_on', strtotime($myDateTime->format('Y-m-d H:i:s')));
		$mform->disabledIf('timezone1', 'frequency', 'neq', 'S');
        $mform->disabledIf('scheduled_on', 'frequency', 'neq', 'S');
        $noptions = array(
            'multiple' => true,
            'noselectionstring' => get_string('notification_type', 'local_notifications'),
        );
        $notification_type = $this->get_all_notification_type();
        $mform->addElement('autocomplete', 'notification_type_id', get_string('notification_type', 'local_notifications'), $notification_type, $noptions);
        $mform->addRule('notification_type_id', get_string('missingnotificationtype', 'local_notifications'), 'required', null, 'client');
        $mform->addElement('submit', 'sendbutton', get_string('send_notification', 'local_notifications'));
        //$this->add_action_buttons();

    }
    /**
     * Validation.
     *
     * @param array $data
     * @param array $files
     * @return array the errors that were found
     */
    public function validation($data, $files)
    {
        global $DB;
        //print_r($data);die;
        $errors = parent::validation($data, $files);
        if ($data['userids'] == null && $data['cohortids'] == null) {
            $errors['showerrors'] = "You must select Atleast Any User or Cohorts";
        }
        return $errors;
    }
    public function save($data)
    {
        global $DB;
        $title = $data->txtsubject;
        $message = $data->txtmessage;
        $cohortids = $data->cohortids;
        $userids = $data->userids;
        $frequency = $data->frequency;
        $scheduledate = $data->scheduled_on;
        $notification_type = $data->notification_type_id;
        //echo "<pre>";
        $date = new DateTime(date("Y-m-d H:i:s",$data->scheduled_on), new DateTimeZone($data->timezone1));
        //echo $date->format('Y-m-d H:i:sP') . "\n";
        $date->setTimezone(new DateTimeZone(date_default_timezone_get()));
        //echo $date->format('Y-m-d H:i:sP') . "\n";
        $data->scheduled_on = strtotime($date->format('Y-m-d H:i:sP'));
        $userlistids = array();
        $cnt = 0;
        if ($cohortids != null && is_array($cohortids)) {
            foreach ($cohortids as $c) {
                $sql = "Select userid from {cohort_members} where cohortid = " . $c;
                $userarr = $DB->get_records_sql($sql);
                if ($userarr != null) {
                    foreach ($userarr as $u) {
                        $userlistids[$u->userid]['user_id'] = $u->userid;
                        $userlistids[$u->userid]['cohort_id'] = $c;
                        $cnt++;
                    }
                }
            }
        }
        if ($userids != null && is_array($userids)) {
            foreach ($userids as $u) {
                $userlistids[$u]['user_id'] = $u;
				$userlistids[$u]['cohort_id'] = (isset($userlistids[$u]['cohort_id']) ? $userlistids[$u]['cohort_id'] : 0);
				$userlistids[$u]['player_id'] = null;
                $cnt++;
            }
        }
        if ($userlistids != null) {
            $ukeys = array_keys($userlistids);
            $sql = "select * from {push_notification} where status ='A' ";
            if ($ukeys != "") {
                $sql .= "AND user_id IN(" . implode(",", $ukeys) . ")";
            }
            $sql .= " order by user_id asc";
            $playerids = $DB->get_records_sql($sql);

            if ($playerids != null) {
                foreach ($playerids as $p) {
                    $userlistids[$p->user_id]['player_id'][] = $p->player_id;
                }
            } 
		
		//	die($userlistids);
            $refno = $this->getReferenceNo();
            if ($notification_type != null) {
                foreach ($notification_type as $n) {
                    //for mobile /APP notification
                    if ($n == 2) {
                        foreach ($userlistids as $u) {
                            $noti = new stdClass;
                            $noti->reference_code = $refno;
                            $noti->frequency = $frequency;
                            $noti->schedule_time = $scheduledate;
                            $noti->timezone = ($data->timezone1!=null? $data->timezone1:date_default_timezone_get());
                            $noti->module_name = 'MANUAL';
                            $noti->message = $message;
                            $noti->title = $title;
                            $noti->status = 0;
                            $noti->response = '';
                            $noti->image = '';
                            $noti->deeplink = '';
                            $noti->config_count = 3;
                            $noti->tries_count = 0;
                            $noti->created_at = time();
                            $noti->updated_at = time();
                            $noti->notification_type = $n;
                            $noti->user_id = $u['user_id'];
							$noti->cohort_id = $u['cohort_id'];
							
                            if ($u['player_id'] != null) {
                                foreach ($u['player_id'] as $p) {
                                    $noti1 = $noti;
									$noti1->player_id = $p;
									//print_r($noti1);
									$id[] = $DB->insert_record('push_notification_log', $noti1);
                                }
                            } else {
								$noti1 = $noti;
								$noti1->player_id = null;
								
								//print_r($noti1);
                                $id[] = $DB->insert_record('push_notification_log', $noti1);
                            }
                        }
					}
					
                }
                $result['status'] = 0;
                $result['message'] = "Notification Log Created Successfully.";
                $result['result'] = $id;
            } else {
                $result['status'] = 1;
                $result['message'] = "No Notification Type Found.";
                $result['result'] = $id;
            }
        } else {
            $result['status'] = 1;
            $result['message'] = "No User Found.";
            $result['result'] = $id;
        }
        return $result;
    }
    public function getReferenceNo()
    {
        global $DB;
        $random = substr(number_format(time() . rand(10 * 45, 100 * 98), 0, '', ''), 7, 14);
        //print_r(mt_rand(100000,999999));echo "<BR>";
        //print_r($random);
        //$refno =
        $sql = "select count(*) as cnt from {push_notification_log} where reference_code='" . $random . "'";
        $rec = $DB->get_record_sql($sql);
        if ($rec->cnt == 0) {
            return $random;
        } else {
            return $this->getReferenceNo();
        }
    }
    public function get_all_cohorts()
    {
        global $DB;
        $sql = "select cm.id as cmid, c.id as id,c.name as name from {cohort} as c JOIN {cohort_members} as cm ON cm.cohortid=c.id";
        $cohortids = $DB->get_records_sql($sql);
        //$cohortids = $DB->get_records('cohort', null, null, 'id,name');
        $arrids = array();
        foreach ($cohortids as $id) {
            $arrids[$id->id] = $id->name;
        }
        return $arrids;
    }
    public function get_all_notification_type()
    {
        global $DB;
        $sql = "Select id,name,is_active from {notification_type} where is_active=1";
        $notification_type = $DB->get_records_sql($sql);
        //$notification_type = $DB->get_records('notification_type', null, null, 'id,name,is_active');
        $arrids = array();
        foreach ($notification_type as $id) {
            $arrids[$id->id] = $id->name;
        }
        return $arrids;
    }
    public function get_all_users()
    {
        global $DB;
		//$userids = $DB->get_records('user', array('deleted'=>0), null, 'id,firstname,lastname');
		$sql = "Select * from {user} where id>2 and deleted=0";
		$userids = $DB->get_records_sql($sql);
        $arrids = array();
        foreach ($userids as $id) {
            $arrids[$id->id] = $id->firstname . " " . $id->lastname;
        }
        return $arrids;
    }
    public function getNotificationReportList()
    {
        global $DB;
        $html = "";
        $sql = "select p.id,p.reference_code, count(p.user_id) as user_count,p.frequency,
				p.schedule_time,p.title,p.message,np.name as notification_type,p.status,p.tries_count,p.config_count
				 from {push_notification_log} as p
				 JOIN {notification_type} as np ON p.notification_type = np.id
				 group by notification_type, reference_code
				 ";
        $res = $DB->get_records_sql($sql);
        $table = new html_table();
        $table->head = array(
            'Reference No.',
            'No of Users',
            'Frequency',
            'Scheduled On',
            'Title - Message',
            "Notification Type",
            'Status',
            "No. of Attempts",
        );
        //$table->align = array('left', 'right', 'right');
        $table->width = '100%';
        $table->data = array();
        foreach ($res as $r) {
            if ($r->frequency == "I") {
                $r->frequency = "Immediately";
            } else if ($r->frequency == "S") {
                $r->frequency = "Scheduled";
            }
            $table->data[] = array(
                $r->reference_code,
                $r->user_count,
                $r->frequency,
                date("d-M-Y H:i:s", $r->schedule_time),
                "<b>Title :: </b>" . $r->title . "<BR><b>Message :: </b>" . $r->message,
                $r->notification_type,
                ($r->status == 1 ? "Sent" : "Not Sent"),
                $r->tries_count . " / " . $r->config_count,
            );

        }
        $html .= html_writer::table($table);
        return $html;
    }
}
