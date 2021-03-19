<?php
require_once dirname(__FILE__) . '/../../../config.php';
require_once 'lib.php';
global $DB, $CFG, $USER;
//print_r($_REQUEST);
global $collection;
if (isset($_REQUEST['action']) && $_REQUEST['action'] != "") {
    switch ($_REQUEST['action']) {
        case "add_resource_to_booking":
            if (isset($_REQUEST['rowidnumber']) && $_REQUEST['rowidnumber'] != "") {
                $rowidnumber = $_REQUEST['rowidnumber'];
            } else {
                $rowidnumber = 0;
            }
            $resources = get_active_resourcelist();
            $html = '';
            $html .= '<tr id="trnumber-' . $rowidnumber . '" class="resourcerow" data-id="' . $rowidnumber . '"> 
            <th>
                <select id="resource_id_' . $rowidnumber . '" class="resource" name="resource_id[' . $rowidnumber . ']" data-id="' . $rowidnumber . '" data-url="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/bookingajax.php">';
            foreach ($resources as $k => $r) {
                $html .= '<option value="' . $k . '">' . $r . '</option>';
            }

            $html .= '</select>
            </th> 
            <th class="text-center">
            <select id ="resource_option_' . $rowidnumber . '" class="resourceopt" name="resource_option[' . $rowidnumber . ']">
            <option value="OPTIONAL">OPTIONAL</option>
            <option value="REQUIRED">REQUIRED</option>
            </select>';
            $html .= '</th> 
            <th class="text-center">
            <input type="text"  name="resource_status[' . $rowidnumber . ']" id="resource_status_' . $rowidnumber . '" readonly value="">
            </th> 
            <th class="text-center">
            <button class="btndeleteresource" data-id="' . $rowidnumber . '">Delete</button>
            <button class="btnviewcalresource" data-id="' . $rowidnumber . '"  data-url="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/popupcal.php">View Calendar</button>
            </th> 
          </tr> ';
            echo $html;
            break;
        case "resource_check_availability":
            //  print_r($_REQUEST);die;
            $resourceid = $_REQUEST['resource_id'];
            if ($resourceid != null) {
                $fromdate = $_REQUEST['fromdate'];
                $enddate = $_REQUEST['todate'];
                $facetofaceid = $_REQUEST['f'];
                $sessionid = $_REQUEST['s'];
                $dataid = $_REQUEST['dataid'];
                $resource_action = $_REQUEST['resource_action'];
                $duplicate = false;
                if ($_REQUEST['collection'] != "") {
                    $coll = json_decode($_REQUEST['collection']);
                    foreach ($coll as $k => $c) {
                        if ($c->resource_id == $resourceid) {
                            $duplicate = true;
                            break;
                        }
                    }
                }
                if ($duplicate != true) {
                    $res = checkSessionResourceAvailability($facetofaceid, $sessionid, $resourceid, $fromdate, $enddate, $resource_action);
                    //$res = getBookingActiveResources($fromdate, $enddate, $resourceid);
                    echo $res;
                } else {
                    echo "Duplicate Entry";
                }
            } else {
                echo "";
            }
            break;
        case "get_resource_calendar_data":
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != null) {
                $rs = $DB->get_records_sql("select * from {resource_booking} where resource_id=" . $_REQUEST['id']);
                // print_r($rs);
                $res_arr = array();
                if ($rs != null) {
                    foreach ($rs as $k => $r) {
                        $res_arr[$k]['id'] = $r->id;
                        $res_arr[$k]['title'] = "Resource Title";
                        $res_arr[$k]['isAllDay'] = false;
                        $res_arr[$k]['start'] = date('Y-m-d\TH:i:sP', strtotime($r->start_date));
                        $res_arr[$k]['end'] = date('Y-m-d\TH:i:sP', strtotime($r->end_date));
                        $res_arr[$k]['color'] = '#ffffff';
                        $res_arr[$k]['isVisible'] = true;
                        $res_arr[$k]['bgColor'] = '#69BB2D';
                        $res_arr[$k]['dragBgColor'] = '#69BB2D';
                        $res_arr[$k]['borderColor'] = '#69BB2D';
                        $res_arr[$k]['calendarId'] = $r->id;
                        $res_arr[$k]['category'] = 'time';
                        $res_arr[$k]['dueDateClass'] = '';
                        $res_arr[$k]['customStyle'] = 'cursor:default;';
                        $res_arr[$k]['isPending'] = false;
                        $res_arr[$k]['isFocused'] = false;
                        $res_arr[$k]['isReadOnly'] = true;
                        $res_arr[$k]['isPrivate'] = false;
                        $res_arr[$k]['location'] = '';
                        $res_arr[$k]['attendees'] = '';
                        $res_arr[$k]['recurrenceRule'] = '';
                        $res_arr[$k]['state'] = '';
                    }
                    if ($res_arr != null) {
                        $res_arr = array_values($res_arr);
                        //print_r($res_arr);
                        $resource_json = json_encode($res_arr);
                        //echo $resource_json;
                    }
                }
            }
            echo $resource_json;
            break;
    }
}
function get_active_resourcelist()
{
    global $DB;
    $sql = "SELECT r.*,rt.name as 'type_name',st.name as 'subtype_name',
    IF(r.startdate <=CURRENT_DATE() and r.enddate >=CURRENT_DATE(),'Active','In Active') as 'is_active' 
    FROM `mdl_resources` as r 
    left join mdl_resource_type as rt on r.resource_type_id=rt.id 
    left join mdl_resource_subtype as st on r.resource_subtype_id =st.id
    Where r.startdate <=CURRENT_DATE() and r.enddate >=CURRENT_DATE()";
    $res = $DB->get_records_sql($sql);
    $arr = array();
    if ($res != null) {
        $arr[''] = "Select Resource";
        foreach ($res as $r) {
            $arr[$r->id] = $r->resource_name . " [ " . $r->subtype_name . " - " . $r->type_name . "]";
        }
    } else {
        $arr[''] = "Select Resource";
    }
    return $arr;
}
function checkSessionResourceAvailability($facetofaceid, $sessionid, $resourceid, $fromdate, $enddate, $resource_action)
{
    global $DB, $USER;
    $context = context_system::instance();
    $companyid = 0; // iomad::get_my_companyid($context);
    if ($resourceid != "" && $facetofaceid != "" && $sessionid != "") {
        //$sql1 = "select * from mdl_resource_booking where resource_id=" . $resourceid . " and companyid=" . $companyid . " and facetoface_id!=" . $facetofaceid . ($sessionid != "0" ? " and session_id!=" . $sessionid : "");
        $sql1 = "select * from mdl_resource_booking where resource_id=" . $resourceid . ($sessionid != "0" ? " and session_id!=" . $sessionid : "");
        if ($resource_action != "class") {
            $sql1 .= " AND booking_status='CONFIRMED'";
        }
        $start_date = json_decode($fromdate);
        $end_date = json_decode($enddate);
        
        $res1 = $DB->get_records_sql($sql1);
        if ($res1 != null) {
            $partial = [];
            foreach ($res1 as $r1) {
                $dbstartdate = strtotime($r1->start_date);
                $dbenddate = strtotime($r1->end_date);
                foreach($start_date as $k=>$s){
                    $startdate = strtotime($start_date[$k]);
                    $enddate = strtotime($end_date[$k]);
                    if ($startdate <= $dbenddate && $enddate >= $dbstartdate) {
                        //echo "partial";
                        $partial[] = $r1;
                    } else {
                        //echo "available";
                    }    
                }
                //$startdate = strtotime($start_date);
                //$enddate = strtotime($end_date);

                //echo "<BR>DB Startdate :: ".date("Y-m-d H:i:s",$dbstartdate)."===".$dbstartdate;
                //echo "<BR>DB End date :: ".date("Y-m-d H:i:s",$dbenddate)."===".$dbenddate;
                //echo "<BR>start date :: ".date("Y-m-d H:i:s",$startdate)."===". $startdate;
                //echo "<BR>end date :: " .date("Y-m-d H:i:s",$enddate)."===". $enddate;

                // if ($startdate <= $dbenddate && $enddate >= $dbstartdate) {
                //     //echo "partial";
                //     $partial[] = $r1;
                // } else {
                //     //echo "available";
                // }
            }
            if ($partial != null) {
                // print_r($partial);
                return "PLANNED - Unavailable";
            } else {
                return "CONFIRMED - Available";
            }
        } else {
            return "CONFIRMED - Available";
        }
    } else {
        return "";
    }
}
