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
    require_once dirname(__FILE__) . "/lib.php";

    function resource_booking_form_generate($mform, $facetofaceid = "", $sessionid = "", $action = "")
    {
      global $CFG, $PAGE, $DB, $USER;
      //echo "<pre>";print_r($mform);die;
      if ($facetofaceid == "" && $sessionid == "") {
        $facetofaceid = 0;
        $sessionid = 0;
      } else if ($sessionid != "" && $facetofaceid == "0") {
        $s = $DB->get_record("facetoface_sessions", array("id" => $sessionid));
        //print_r($s);
        $facetofaceid = $s->facetoface;
        //echo $facetofaceid."===".$sessionid;
      } else {
        $sessionid = 0;
      }

      if ($facetofaceid != null) {

        // $lang = current_language();
        $typename = "t.name as resource_type_name";
        $subtypename = "st.name as resource_subtype_name";
        $context = context_system::instance();
        $companyid = 0; //iomad::get_my_companyid($context);
        //echo "<pre>";print_r($mform->coursemodule);die;
        $sql = "select rb.*," . $typename . "," . $subtypename . ",r.resource_name as resource_name from {resource_booking} as rb
                      JOIN {resource_type} as t on rb.resource_type_id=t.id
                      JOIN {resource_subtype} as st on rb.resource_subtype_id=st.id
                      JOIN {resources} as r on rb.resource_id=r.id
                  where rb.companyid=" . $companyid . " and facetoface_id=" . $facetofaceid . " and session_id=" . $sessionid;
        //echo $sql;
        $records = $DB->get_records_sql($sql);
        // print_r($records);
        //die;
        if ($records != null) {
          $res = array();
          $i = 1;
          foreach ($records as $k => $r) {
            $obj = new stdclass;
            $obj->hidden_startdate = $r->start_date;
            $obj->hidden_enddate = $r->end_date;
            $obj->resource_type_id = $r->resource_type_id;
            $obj->resource_type_name = $r->resource_type_name;
            $obj->resource_subtype_id = $r->resource_subtype_id;
            $obj->resource_sub_type_name = $r->resource_subtype_name;
            $obj->resource_id = $r->resource_id;
            $obj->resource_name = $r->resource_name;
            $obj->resource_qty = $r->resource_qty;
            $obj->resource_option = $r->resource_option;
            $obj->resource_option_name = $r->resource_option;
            $obj->resource_status = $r->booking_status;
            $obj->booking_status = $r->booking_status;
            $obj->objid = $k;
            $res[] = $obj;
          }
          //print_r($res);
          $booking_data_json = json_encode($res);
          //echo $facetofaceid;die("in edit");
        } else {
          $booking_data_json = "";
        }
      }

      // $PAGE->requires->js_call_amd('local_resources/venuevalidate', 'init', array());
      $PAGE->requires->js_call_amd('local_resources/resourcebooking', 'initbooking', array("action" => $action, "facetofaceid" => $facetofaceid, "sessionid" => $sessionid));
      $mform->addElement('header', 'resource_booking', get_string('resource_booking', 'local_resources'));

      //$mform->addElement("html","<div id='div_class_dates'>Dates : </div>");
      $mform->addElement('hidden', 'hidden_startdate', '', array("id" => "hidden_startdate"));
      $mform->setType("hidden_startdate", PARAM_RAW);
      $mform->addElement('hidden', 'hidden_enddate', '', array("id" => "hidden_enddate"));
      $mform->setType("hidden_enddate", PARAM_RAW);
      $mform->addElement("hidden", 'resource_facetoface_id', ($facetofaceid != "" ? $facetofaceid : "0"), array("id" => "resource_facetoface_id"));
      $mform->setType("resource_facetoface_id", PARAM_RAW);
      $mform->addElement("hidden", 'resource_session_id', ($sessionid != "" ? $sessionid : "0"), array("id" => "resource_session_id"));
      $mform->setType("resource_session_id", PARAM_RAW);

      $mform->addElement("hidden", 'resource_action', $action, array("id" => "resource_action"));
      $mform->setType("resource_action", PARAM_RAW);

      $resource_type = getResourceType();
      $mform->addElement('select', 'resource_type_id', get_string('resource_type', 'local_resources'), $resource_type);
      //$mform->addRule('resource_type_id', $strrequired, 'required', null, 'client');

      $resource_subtype[''] = get_string('select');
      $mform->addElement('select', 'resource_subtype_id', get_string('resource_subtype', 'local_resources'), $resource_subtype);
      //  $mform->addRule('resource_subtype_id', $strrequired, 'required', null, 'client');

      $resource_id[] = get_string('select');
      $mform->addElement("select", "resource_id", get_string('resource_name', 'local_resources'));

      $mform->addElement("hidden", "resource_qty", get_string("resource_qty", "local_resources"));
      //$mform->addRule('resource_qty', "Number Required", 'numeric', null, 'client');
      $mform->setDefault("resource_qty", 1);

      $options[''] = get_string('select');
      $options['OPTIONAL'] = "OPTIONAL";
      $options['REQUIRED'] = "REQUIRED";
      $mform->addElement("select", "resource_option", get_string("resource_option", "local_resources"), $options);
      $mform->setDefault("resource_option", '');

      $mform->addElement("hidden", "booking_data_json", $booking_data_json, array("id" => "booking_data_json"));

      $mform->addElement("html", "<a type='button' class='btn btn-secondary' id='btnaddresource' href='#'>Add Resource</a>");

      //adding modal html code 
      $mform->addElement("html", '<!-- Modal -->
        <div id="bookingModal" class="modal fade" role="dialog">
          <div class="modal-dialog modal-lg">    
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Resource Booking Details</h4>
              </div>
              <div class="modal-body">
                <div id="show_table_div"></div>
                <div id="show_calendar_div"></div>           
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>    
          </div>
        </div>');
      $mform->addElement("html", '<div id="div_table"><BR><BR><div class="d-flex flex-row align-items-center" style="height: 32px"><div class="bg-pulse-grey rounded-circle" style="height: 32px; width: 32px;"></div><div style="flex: 1" class="pl-2"><div class="bg-pulse-grey w-100" style="height: 15px;"></div><div class="bg-pulse-grey w-75 mt-1" style="height: 10px;"></div></div></div></div><BR><span class="text-danger" id="errspan" style="display:none;"></span>');
    }

    function resource_booking_delete_for_class($facetofaceid, $sessionid = 0)
    {
      global $DB, $USER;
      try {
        $transaction = $DB->start_delegated_transaction();
        // Do something here.
        if ($sessionid != 0) {
          $id = $DB->delete_records('resource_booking', array('facetoface_id' => $facetofaceid, "session_id" => $sessionid));
        } else {
          $id = $DB->delete_records('resource_booking', array('facetoface_id' => $facetofaceid));
        }
        $transaction->allow_commit();
      } catch (Exception $e) {
        // Make sure transaction is valid.
        if (!empty($transaction) && !$transaction->is_disposed()) {
          $transaction->rollback($e);
        }
      }
    }
    function resource_booking_add_to_class($data, $facetofaceid, $sessionid = 0)
    {
      global $DB, $USER;
      resource_booking_delete_for_class($facetofaceid, $sessionid);
      /* $transaction = $DB->start_delegated_transaction();

        if ($DB->delete_records('resource_booking', array('facetoface_id' => $facetofaceid,"session_id"=>0))) {
        $transaction->allow_commit();
        } else {
        $transaction->rollback();
        }
        $transaction->rollback();
        */
      //die($facetofaceid."==".$sessionid);
      $context = context_system::instance();
      $companyid = 0; //iomad::get_my_companyid($context);
      if ($data != "") {
        $booking_data = json_decode($data);
        //print_r($booking_data);die;
        if ($booking_data != null) {
          foreach ($booking_data as $b) {
            //if ($b->resource_status != "CONFIRMED" && $b->resource_status != "PLANNED") {
            $rs = $DB->get_record("resources", array("id" => $b->resource_id));
            // print_r($rs);
            $bdata = new stdclass;
            $bdata->companyid = $companyid;
            $bdata->facetoface_id = $facetofaceid;
            $bdata->session_id = $sessionid;
            $bdata->start_date = $b->hidden_startdate;
            $bdata->end_date = $b->hidden_enddate;
            $bdata->starttime = date("H:i:s", strtotime($b->hidden_startdate));
            $bdata->endtime = date("H:i:s", strtotime($b->hidden_enddate));
            $bdata->resource_type_id = $rs->resource_type_id;
            $bdata->resource_subtype_id = $rs->resource_subtype_id;
            $bdata->resource_id = $b->resource_id;
            $bdata->resource_qty = 0; // !empty($b->resource_qty) ? $b->resource_qty : "0";
            $bdata->resource_option = $b->resource_option;
            $bdata->is_active = 0;
            $bdata->is_class = 1;
            if ($b->resource_status != "CONFIRMED" && $b->resource_status != "PLANNED") {
              if ($b->resource_status == "CONFIRMED - Available") {
                $bdata->booking_status = 'CONFIRMED';
              } else if ($b->resource_status == "PLANNED - Unavailable") {
                $bdata->booking_status = 'PLANNED';
              }
              /* if ($b->resource_status == "Booking Available") {
                            if ($sessionid == 0) {$bdata->booking_status = "PLANNED";} else { $bdata->booking_status = 'CONFIRMED';}
                        } else {
                            $bdata->booking_status = 'PLANNED';
                        }*/
            } else {
              $bdata->booking_status = $b->resource_status;
            }
            $bdata->created_at = !empty($data->timecreated) ? $data->timecreated : date('Y-m-d H:i:s');
            $bdata->created_by = $USER->id;
            $bdata->updated_at = $bdata->created_at;
            $bdata->updated_by = $USER->id;
            //print_r($bdata);
            $bookids[] = $DB->insert_record('resource_booking', $bdata);
            $bdata = null;
            //   }
          }
          //print_r($bookids);die;
          return $bookids;
        }
      }
    }
    function get_trainer_from_resource_booking($datajson)
    {
      global $DB;
      if ($datajson != "") {
        $booking_data = json_decode($datajson);
        //echo "<pre>";print_r($booking_data);
        $trainer_id = "";
        if ($booking_data != null) {
          foreach ($booking_data as $b) {
            if ($b->resource_type_id == 2 && $b->resource_subtype_id == 7) {
              //$data['trainer_id']=
              $trainer = $DB->get_record_sql("select tr.emp_id from mdl_resources as r LEFT JOIN mdl_trainer_requests as tr on tr.id=r.trainer_request_id where r.id=" . $b->resource_id);

              if ($trainer->emp_id != null) {
                $trainer_id = $trainer->emp_id;
                break;
              }
            }
          }
        }
      }
      return $trainer_id;
    }
    function newResourceBookingForm($mform, $facetofaceid = "", $sessionid = "", $action = "")
    {
      global $CFG, $PAGE, $DB, $USER;
      //echo "<pre>";print_r($mform);die;
      if ($facetofaceid == "" && $sessionid == "") {
        $facetofaceid = 0;
        $sessionid = 0;
      } else if ($sessionid != "" && $facetofaceid == "0") {
        $s = $DB->get_record("zingilt_sessions", array("id" => $sessionid));
        //print_r($s);
        $facetofaceid = $s->zingilt;
        //echo $facetofaceid."===".$sessionid;
      } else {
        $sessionid = 0;
      }
      if($action == "add_session"){
        $sessionid = 0;
      }
      if ($facetofaceid != null) {

        // $lang = current_language();
        $typename = "t.name as resource_type_name";
        $subtypename = "st.name as resource_subtype_name";
        $context = context_system::instance();
        $companyid = 0; //iomad::get_my_companyid($context);
        //echo "<pre>";print_r($mform->coursemodule);die;
        $sql = "select rb.*," . $typename . "," . $subtypename . ",r.resource_name as resource_name from {resource_booking} as rb
                              JOIN {resource_type} as t on rb.resource_type_id=t.id
                              JOIN {resource_subtype} as st on rb.resource_subtype_id=st.id
                              JOIN {resources} as r on rb.resource_id=r.id
                          where rb.companyid=" . $companyid . " and facetoface_id=" . $facetofaceid . " and session_id=" . $sessionid;
        //echo $sql;
        $records = $DB->get_records_sql($sql);
        // print_r($records);
        //die;
        if ($records != null) {
          $res = array();
          $i = 1;
          foreach ($records as $k => $r) {
            $obj = new stdclass;
            //$obj->hidden_startdate = $r->start_date;
         //   $obj->hidden_enddate = $r->end_date;
            //$obj->resource_type_id = $r->resource_type_id;
            //$obj->resource_type_name = $r->resource_type_name;
            //$obj->resource_subtype_id = $r->resource_subtype_id;
            // $obj->resource_sub_type_name = $r->resource_subtype_name;
            $obj->resource_id = $r->resource_id;
            $obj->resource_name = $r->resource_name;
            //  $obj->resource_qty = $r->resource_qty;
            $obj->resource_option = $r->resource_option;
            $obj->resource_option_name = $r->resource_option;
            $obj->resource_status = $r->booking_status;
            $obj->booking_status = $r->booking_status;
            $obj->objid = $k;
            $res[$obj->resource_id] = $obj;
          }
          //print_r($res);
          $booking_data_json = json_encode(array_values($res));
          //echo $facetofaceid;die("in edit");
        } else {
          $booking_data_json = "";
        }
      }
      else{
        $booking_data_json = "";
      }

      $PAGE->requires->js(new moodle_url("/mod/zingilt/resourcemgmt/scripts/jquery.min.js"));
      $PAGE->requires->js(new moodle_url("/mod/zingilt/resourcemgmt/scripts/js/rbooking.js"));
      $mform->addElement('header', 'resource_booking', get_string('resource_booking', 'mod_zingilt'));

      //$mform->addElement("html","<div id='div_class_dates'>Dates : </div>");
      // $mform->addElement('text', 'hidden_startdate', '', array("id" => "hidden_startdate"));
      // $mform->setType("hidden_startdate", PARAM_RAW);
      // $mform->addElement('text', 'hidden_enddate', '', array("id" => "hidden_enddate"));
      // $mform->setType("hidden_enddate", PARAM_RAW);
      $mform->addElement("hidden", 'resource_facetoface_id', ($facetofaceid != "" ? $facetofaceid : "0"), array("id" => "resource_facetoface_id"));
      $mform->setType("resource_facetoface_id", PARAM_RAW);
      $mform->addElement("hidden", 'resource_session_id', ($sessionid != "" ? $sessionid : "0"), array("id" => "resource_session_id"));
      $mform->setType("resource_session_id", PARAM_RAW);

      $mform->addElement("hidden", 'resource_action', $action, array("id" => "resource_action", "value" => $action, "style" => "border:none;"));
      $mform->setType("resource_action", PARAM_RAW);
      //echo $action;//die;
      /*
                $resource_type = getResourceType();
                $mform->addElement('select', 'resource_type_id', get_string('resource_type', 'local_resources'), $resource_type);
                //$mform->addRule('resource_type_id', $strrequired, 'required', null, 'client');

                $resource_subtype[''] = get_string('select');
                $mform->addElement('select', 'resource_subtype_id', get_string('resource_subtype', 'local_resources'), $resource_subtype);
                //  $mform->addRule('resource_subtype_id', $strrequired, 'required', null, 'client');

                $resource_id[] = get_string('select');
                $mform->addElement("select", "resource_id", get_string('resource_name', 'local_resources'));

                $mform->addElement("hidden", "resource_qty", get_string("resource_qty", "local_resources"));
                //$mform->addRule('resource_qty', "Number Required", 'numeric', null, 'client');
                $mform->setDefault("resource_qty", 1);

                $options[''] = get_string('select');
                $options['OPTIONAL'] = "OPTIONAL";
                $options['REQUIRED'] = "REQUIRED";
                $mform->addElement("select", "resource_option", get_string("resource_option", "local_resources"), $options);
                $mform->setDefault("resource_option", '');
            */
      $mform->addElement("hidden", "booking_data_json", $booking_data_json, array("id" => "booking_data_json", "value" => $booking_data_json, "size" => "100"));
      $mform->setType("booking_data_json", PARAM_RAW);

      //adding modal html code 
      $mform->addElement("html", '<!-- Modal -->
                <div id="bookingModal" class="modal fade" role="dialog">
                  <div class="modal-dialog modal-lg">    
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title">Resource Booking Details</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>         
                      </div>
                      <div class="modal-body" id="calbody">
                      
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>    
                  </div>
                </div>');
      $mform->addElement("html", '
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/jquery.min.js"></script>
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/jquery-ui.min.js"></script>
                    <script src ="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/bootstrap.min.js"></script>
                    <link rel="stylesheet" type="text/css" href="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/tui-date-picker.css" />
                    <link rel="stylesheet" type="text/css" href="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/tui-time-picker.css" />
                    
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/tui-code-snippet.js"></script>
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/tui-dom.js"></script>
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/tui-time-picker.min.js"></script>
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/tui-date-picker.min.js"></script>
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/tui-calendar.js"></script>
                    <script src="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/moment.min.js"></script>
                    <link rel="stylesheet" type="text/css" href="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/tui-calendar/calendar.css" />
                    
                  
                        <div id="bookingModal1" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-lg">    
                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <h4 class="modal-title">Resource Booking Details</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>         
                              </div>
                              <div class="modal-body" id="calbody1">
                              <div id="menu">
                          <span id="menu-navi">
                            <button type="button" class="btn btn-default btn-sm move-today" data-action="move-today">Today</button>
                            <button type="button" class="btn btn-default btn-sm move-day" data-action="move-prev">
                              <i class="calendar-icon ic-arrow-line-left" data-action="move-prev"></i>
                            </button>
                            <button type="button" class="btn btn-default btn-sm move-day" data-action="move-next">
                              <i class="calendar-icon ic-arrow-line-right" data-action="move-next"></i>
                            </button>
                          </span>
                          <span id="renderRange" class="render-range"></span>
                        </div>
                                  <div id="calendar1"></div>       
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div>
                            </div>    
                          </div>
                        </div>');
      //$mform->addElement("html", '<div id="div_table"><BR><BR><div class="d-flex flex-row align-items-center" style="height: 32px"><div class="bg-pulse-grey rounded-circle" style="height: 32px; width: 32px;"></div><div style="flex: 1" class="pl-2"><div class="bg-pulse-grey w-100" style="height: 15px;"></div><div class="bg-pulse-grey w-75 mt-1" style="height: 10px;"></div></div></div></div><BR><span class="text-danger" id="errspan" style="display:none;"></span>');
      $mform->addElement("html", "<button type='button' class='btn btn-secondary' id='btnaddresource' data-url='" . $CFG->wwwroot . "/mod/zingilt/resourcemgmt/bookingajax.php'>Add Resource</button>");
    //  $mform->addElement("html", "<B><div>Start Date:<span id='spn_hidden_startdate'></span></div><div>End Date :<span id='spn_hidden_enddate'></span></div></B>");
      $mform->addElement("html", '<table class="table table-bordered" id="tblresourcebooking"> 
                <thead> 
                  <tr> 
                    <th class="text-center">Select Resource</th> 
                    <th class="text-center">Resource Option</th> 
                    <th class="text-center">Status</th> 
                    <th class="text-center">Action</th> 
                  </tr> 
                </thead> 
                <tbody id="trbody"> 

                </tbody> 
              </table> 
            </div> ');
    }
    function trainer_enrol_course($trainerid, $course)
    {
      global $DB, $USER;
      if ($trainerid != 0 && $trainerid != null && $trainerid != "") {
        $from       = $DB->get_record('user', array('id' => 2));
        $sql        = "SELECT u.* from {user} as u  where u.id = ? and u.deleted = ?";
        $user       = $DB->get_record_sql($sql, array($trainerid, 0), $strictness = IGNORE_MISSING);
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

        //TRAINER_ROLE_ID role assignment at course level
        $context = context_course::instance($course->id);
        $context = isset($context) ? $context : context_system::instance(); //print_r($context->id); print_r($context); exit();

        $r_assign = $DB->get_record_sql('SELECT * FROM `mdl_role_assignments` WHERE `contextid` = ? and userid = ? and roleid = ? ORDER BY id asc limit 0,1', array('contextid' => $context->id, 'userid' => $user->id, 'roleid' => TRAINER_ROLE_ID));
        // print_r($context); print_r($user->id);
        // print_r($r_assign); exit();

        if (empty($r_assign)) {
          $ins_rec = new stdClass();
          $ins_rec->roleid      = TRAINER_ROLE_ID;
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
      return $trainerid;
    }
    function trainer_check_other_enrolment($trainerid, $sessionid, $course)
    {
      global $DB;
      $sql = "SELECT f.id,f.course,s.id,s.trainer_id 
      FROM `mdl_zingilt_sessions` as s 
      join mdl_zingilt as f on s.zingilt = f.id
      where f.course = " . $course->id . " and s.id !=" . $sessionid;
      $rs = $DB->get_records_sql($sql);
      if ($rs != null && count($rs) > 0) {
        foreach ($rs as $r) {
          $status = false;
          if ($r->trainer_id != '') {
            $tarr = explode(",", $r->trainer_id);
            if (in_array($trainerid, $tarr)) {
              $status = true;
              break;
            }
          }
        }
        return $status;
      } else {
        return false;
      }
    }
    function trainer_unenrol_course($trainerid, $course)
    {
      global $DB;
      $enrol      = $DB->get_record_sql('SELECT id,enrol FROM `mdl_enrol` WHERE `courseid` = ? and status = 0 ORDER BY id asc limit 0,1', array('courseid' => $course->id)); //print_r($enrol); //exit();
      if ($enrol != null) {
        $DB->execute("delete from {user_enrolments} where userid=" . $trainerid . " and enrolid = " . $enrol->id);
        $context = context_course::instance($course->id);
        $context = isset($context) ? $context : context_system::instance();
        $DB->execute('delete FROM `mdl_role_assignments` WHERE `contextid` = ' . $context->id . ' and userid =' . $trainerid . '  and roleid = ' . TRAINER_ROLE_ID);
      }
    }
    function trainer_enrol_session($trainerid, $sessionid)
    {
      global $DB, $USER;
      if (!empty($sessionid)) {
        $sql = "select * from {zingilt_signups} where userid =" . $trainerid . " and sessionid=" . $sessionid;
        $rs = $DB->get_record_sql($sql);
        if ($rs == null) {
          $insert_rec = new stdClass;
          $insert_rec->sessionid         = $sessionid;
          $insert_rec->userid            = $trainerid;
          $insert_rec->mailedreminder    = 0;
          $insert_rec->notificationtype  = 3;

          $signupid = $DB->insert_record('zingilt_signups', $insert_rec);
          $status_array = ['30' => '1', '40' => '1', '50' => '1', '70' => '0'];

          if (!empty($signupid)) {
            $signup_rec = new stdClass;
            foreach ($status_array as $key1 => $value1) {

              $signup_rec->signupid   = $signupid;
              $signup_rec->statuscode = $key1;
              $signup_rec->superceded = $value1;
              $signup_rec->createdby  = $USER->id;
              $signup_rec->timecreated = time();

              $DB->insert_record('zingilt_signups_status', $signup_rec);
            }
          }
        }
      }
      return $trainerid;
    }
    function trainer_unenrol_session($trainerid, $sessionid)
    {
      global $DB;
      if ($trainerid != null && $sessionid != null) {
        $sql = "select * from {zingilt_signups} where userid=" . $trainerid . " and sessionid=" . $sessionid;
        $rs = $DB->get_record_sql($sql);
        //print_r($rs);die;
        if ($rs != null) {
          $signupid = $rs->id;
          $DB->execute("DELETE From {zingilt_signups_status} where signupid=" . $signupid);
          $sql = "delete from {zingilt_signups} where userid=" . $trainerid . " and sessionid=" . $sessionid;
          //echo $sql;
          $DB->execute($sql);
          // die("here");
        }
      }
      return $trainerid;
    }
    function manage_trainer_enrolment($datajson, $course, $old_trainer_id, $sessionid, $sessiondates)
    {
      global $DB;
      try {
        $booking_arr = json_decode($datajson);
        $trainers = array();
        //print_r($booking_arr);
        if ($booking_arr != null) {
          foreach ($booking_arr as $r) {
            $resid = $r->resource_id;
            $rtype = $DB->get_record_sql("select * from {resources} where id = " . $resid . " and resource_subtype_id=3");
            //for the Trainer Course Enrollment
            if ($rtype != null) {
              //check for course enrolment 
              $trainerid = $rtype->trainer_request_id;
              $tid = trainer_enrol_course($trainerid, $course);
              //    $tid1= trainer_enrol_session($trainerid,$sessionid);
              //  send_email_to_trainers($trainerid,$sessiondates,$course,$sessionid);
              $trainers[] = $trainerid;
            }
          }
        }
        //  $old_trainer_id=$fromform->trainer_id;
        if ($old_trainer_id != null && $old_trainer_id != '') {
          $oldtrainers = explode(",", $old_trainer_id);
          //print_r($oldtrainer); //print_r($trainers);
          // trainer_unenrol_course($oldtrainers,$trainers,$course);

          $result = array_diff($oldtrainers, $trainers);
          // print_r($result);//die("here");
          if ($result != null) {
            $tarr1 = array();
            foreach ($result as $tid) {
              if (trainer_check_other_enrolment($tid, $sessionid, $course) == false) {
                $ctid = trainer_unenrol_course($tid, $course);
              }
              // echo $tid;
              $tarr1[] = $tid;

              $tid1 = trainer_unenrol_session($tid, $sessionid);
              // echo $tid1."=====";
            }
          }
        }

        $trainer_id = implode(",", $trainers);
        return $trainer_id;
      } catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
      }
    }

    function send_email_to_trainers($trainerid, $sessiondates, $course, $sessionid)
    {
      global $DB;
      //   if(is_array($trainers) && count($trainers)>0){
      //  foreach($trainers as $t){
      $from = $DB->get_record('user', array('id' => 2));
      $user = $DB->get_record("user", array("id" => $trainerid));
      $session = $DB->get_record('zingilt_sessions', array("id" => $sessionid));
      //mail to trainer
      $start_date = date("l M j, Y H:i:s", $sessiondates[0]->timestart);
      $end_date   = date("l M j, Y H:i:s", $sessiondates[0]->timefinish);
      $portal_link = "https://clientuat.zinghr.com/2015/pages/authentication/login.aspx"; //"""https://learn2.zinghr.com/aisatsuat/lms/index.php";
      $get_category_name = "LMS";
      $body    = "<p>Dear " . $user->firstname . " " . $user->lastname . ", <br><br> 
            You have been assigned as a <b> Trainer </b> for the training session <b>" . $session->name . "</b> under the Course <b>" . $course->fullname . ". </b> <br><br>
            The schedule is as shown below : <br><br> 
            From  " . $start_date . "  To  " . $end_date . " at <br>
            
            Kindly click on the link to access the course. <a href='" . $portal_link . "'>Portal Link </a> <br> 
            NOTE : [ For LMS navigation - Please login with Portal Link and then click on LMS icon .You will land on 'Home' page of LMS. Click on category <b>" . $get_category_name . " </b>, with in this you will get course <b>" . $course->fullname . " </b> inside this course you will find the training session <b>" . $session->name . "] <br>
            Happy Learning !! <br><br>
            Regards,<br>
            <i>BMA Learning & Development Team </i></p>";
      /*   $body    = "<p>Dear ".$user->firstname." ".$user->lastname.", <br><br> 
            You have been assigned as a <b> Trainer </b> for the training session <b>".$course->fname."</b> under the Course <b>".$course->fullname.". </b> <br><br>
            The schedule is as shown below : <br><br> 
            From  ".$start_date."  To  ".$end_date." at <br>
            Location:  ".$fromform->custom_location." <br>
            Venue:   ".$fromform->custom_venue." <br>
            Room:   ".$fromform->custom_room." <br><br>
            Kindly click on the link to access the course. <a href='".$portal_link."'>Portal Link </a> <br> 
            NOTE : [ For LMS navigation - Please login with Portal Link and then click on LMS icon .You will land on 'Home' page of LMS. Click on category <b>".$get_category_name." </b>, with in this you will get course <b>".$course->fullname." </b> inside this course you will find the training session <b>".$course->fname."] <br>
            Happy Learning !! <br><br>
            Regards,<br>
            <i>BMA Learning & Development Team </i></p>";*/


      email_to_user($user, $from, 'Trainer Notification', 'The text of the message', $body);

      //}
      //}
    }
    function session_wise_resources_table($sessionid)
    {
      global $DB;
      $output = '';
      $sql = "select r.resource_name as resource_name,rt.name as resource_type_name,rst.name as resource_subtype_name,
            rb.resource_option
        from {resource_booking} as rb 
                join {resources} as r on rb.resource_id = r.id
                join {resource_type} as rt on rb.resource_type_id = rt.id
                join {resource_subtype} as rst on rb.resource_subtype_id = rst.id
        where session_id = " . $sessionid;
      $rs = $DB->get_records_sql($sql);
      if ($rs != null) {
        $table = new html_table();
        $table->summary = get_string('previoussessionslist', 'zingilt');
        $table->head = array("Resource Name", "Resource Type", "Resource SubType", "Resource Option");
        $table->data = array();
        $rbrow = array();
        foreach ($rs as $r) {
          $rbrow[] = $r->resource_name;
          $rbrow[] = $r->resource_type_name;
          $rbrow[] = $r->resource_subtype_name;
          $rbrow[] = $r->resource_option;
          $row = new html_table_row($rbrow);
          $table->data[] = $row;
        }
        $output .= html_writer::table($table);
      } else {
        $output = '';
      }
      return $output;
    }
