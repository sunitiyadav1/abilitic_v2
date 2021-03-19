<?php
require_once dirname(__FILE__) . '/../../../config.php';
require_once 'lib.php';
global $DB, $CFG, $USER;
//print_r($_REQUEST);
if (isset($_REQUEST['action']) && $_REQUEST['action'] != "") {
    switch ($_REQUEST['action']) {
        case "get_resource_list":
            $sql = "SELECT r.*,rt.name as 'type_name',st.name as 'subtype_name',
            IF(r.startdate <=CURRENT_DATE() and r.enddate >=CURRENT_DATE(),'Active','In Active') as 'is_active' 
            FROM `mdl_resources` as r 
            left join mdl_resource_type as rt on r.resource_type_id=rt.id 
            left join mdl_resource_subtype as st on r.resource_subtype_id =st.id";
            $res = $DB->get_records_sql($sql);
            //echo "<pre>"; print_r($res);
            $arr['draw'] = 1;
            $arr['recordsTotal'] = count($res);
            $arr['recordsFiltered'] = 57;
            $arr['data'] = array_values($res);
            echo json_encode($arr);
            break;
        case "get_tprovider_list":
            $sql = "SELECT *, IF(is_active=1,'Active','In Active') as 'is_active'  FROM mdl_training_provider";
            $res = $DB->get_records_sql($sql);
            $arr['draw'] = 1;
            $arr['recordsTotal'] = count($res);
            $arr['recordsFiltered'] = 57;
            $arr['data'] = array_values($res);
            echo json_encode($arr);
            break;
        case "get_tcenter_list":
            $sql = "SELECT * FROM mdl_training_center";
            $res = $DB->get_records_sql($sql);
            $arr['draw'] = 1;
            $arr['recordsTotal'] = count($res);
            $arr['recordsFiltered'] = 57;
            $arr['data'] = array_values($res);
            echo json_encode($arr);
            break;
        case "get_resource_editdata":
            if (isset($_REQUEST["resourceid"]) && $_REQUEST['resourceid'] != "") {
                $resourceid =  $_REQUEST['resourceid'];
                $sql = "SELECT r.*,rt.name as 'type_name',st.name as 'subtype_name' 
                    FROM `mdl_resources` as r 
                    left join mdl_resource_type as rt on r.resource_type_id=rt.id 
                    left join mdl_resource_subtype as st on r.resource_subtype_id =st.id
                    where r.id=" . $resourceid;
                $res = $DB->get_record_sql($sql);
                //echo "<pre>"; print_r($res);
                //$arr['data'] = array_values($res);
                echo json_encode($res);
            }
            break;
        case "get_tprovider_editdata":
            if (isset($_REQUEST["tproviderid"]) && $_REQUEST['tproviderid'] != "") {
                $tproviderid =  $_REQUEST['tproviderid'];
                $sql = "SELECT * FROM `mdl_training_provider` where id=" . $tproviderid;
                $res = $DB->get_record_sql($sql);
                echo json_encode($res);
            }
            break;
        case "get_tcenter_editdata":
            if (isset($_REQUEST["tcenterid"]) && $_REQUEST['tcenterid'] != "") {
                $tcenterid =  $_REQUEST['tcenterid'];
                $sql = "SELECT * FROM `mdl_training_center` where id=" . $tcenterid;
                $res = $DB->get_record_sql($sql);
                echo json_encode($res);
            }
            break;
        case "save_tcenter":
            global $DB, $CFG, $USER;
            $dataarr = array_merge($_REQUEST);
            //echo "<pre>";print_r($dataarr);echo $dataarr['resource_id'];die;
            $status = 1;
            $message = '';
            $result = [];
            if (isset($dataarr['formaction']) && $dataarr['formaction'] != "") {
                switch ($dataarr['formaction']) {
                    case "add":
                        if (!empty($dataarr['tcenter_name']) && $DB->record_exists('training_center', array('name' => $dataarr['tcenter_name']))) {
                            //throw new moodle_exception(get_string('resourcenametaken'), '', '', $dataarr['resource_name']);
                            $status = 1;
                            $message = "Training Center Name Already Exist.";
                        } else {
                            $data = new stdClass;
                            $data->name = $dataarr['tcenter_name'];
                            $data->description = $dataarr['tcenter_desc'];
                            $data->location = $dataarr['location'];
                            $data->address = $dataarr['address'];
                            $data->addrline1 = $dataarr['addrline1'];
                            $data->addrline2 = $dataarr['addrline2'];
                            $data->city = $dataarr['city'];
                            $data->state = $dataarr['state'];
                            $data->country = $dataarr['country'];
                            $data->pincode = $dataarr['pincode'];
                            $data->workers_total = $dataarr['workers_total'];
                            $data->deputy_name1 = $dataarr['deputy_name1'];
                            $data->deputy_mobile1 = $dataarr['deputy_mobile1'];
                            $data->deputy_name2 = $dataarr['deputy_name2'];
                            $data->deputy_mobile2 = $dataarr['deputy_mobile2'];
                            $data->deputy_name3 = $dataarr['deputy_name3'];
                            $data->deputy_mobile3 = $dataarr['deputy_mobile3'];
                            $data->tax_type_id = $dataarr['tax_type_id'];
                            $data->vat_registration_no = '';
                            $data->tax_identification_no = '';
                            if($data->tax_type_id == '1')
                            {
                                $data->tax_identification_no = $dataarr['tax_identification_no'];
                            }
                            else if($data->tax_type_id == '2') {
                                $data->vat_registration_no = $dataarr['vat_registration_no'];
                            }
                            $data->taggroup = $dataarr['taggroup'];
                            $data->is_deleted = 0;
                            $data->created_by = $USER->id;
                            //$data->created_at = time();
                            $data->updated_by = $USER->id;
                            //$data->updated_at = time();
                            // print_r($data);die;
                            $data->id = $DB->insert_record('training_center', $data);
                            $status = 0;
                            $message = 'Training Center Added Successfully.  ';
                            $result = $data;
                        }
                        break;
                    case "edit":
                        if (empty($dataarr['tcenter_id'])) {
                            $status = 1;
                            $message = "No Training Center Id For Edit";
                            break;
                        } else if (!empty($dataarr['tcenter_name'])) {
                            $sql = "select * from {training_center} where name ='" . $dataarr['tcenter_name'] . "' and id<>" . $dataarr['tcenter_id'];
                            //if ($DB->record_exists('resources', array('resource_name' => $dataarr['resource_name']))) {
                            if ($DB->record_exists_sql($sql)) {
                                //throw new moodle_exception(get_string('resourcenametaken'), '', '', $dataarr['resource_name']);
                                $status = 1;
                                $message = "Duplicate Training Center found.";
                                break;
                            } else {
                                $status = 0;
                            }
                        }
                        if ($status == 0) {     //  echo "in else ";     die;
                            $data = new stdClass;
                            $data->name = $dataarr['tcenter_name'];
                            $data->description = $dataarr['tcenter_desc'];
                            $data->location = $dataarr['location'];
                            $data->address = $dataarr['address'];
                            $data->addrline1 = $dataarr['addrline1'];
                            $data->addrline2 = $dataarr['addrline2'];
                            $data->city = $dataarr['city'];
                            $data->state = $dataarr['state'];
                            $data->country = $dataarr['country'];
                            $data->pincode = $dataarr['pincode'];
                            $data->workers_total = $dataarr['workers_total'];
                            $data->deputy_name1 = $dataarr['deputy_name1'];
                            $data->deputy_mobile1 = $dataarr['deputy_mobile1'];
                            $data->deputy_name2 = $dataarr['deputy_name2'];
                            $data->deputy_mobile2 = $dataarr['deputy_mobile2'];
                            $data->deputy_name3 = $dataarr['deputy_name3'];
                            $data->deputy_mobile3 = $dataarr['deputy_mobile3'];
                            $data->tax_type_id = $dataarr['tax_type_id'];
                            $data->vat_registration_no = '';
                            $data->tax_identification_no = '';
                            if($data->tax_type_id == '1')
                            {
                                $data->tax_identification_no = $dataarr['tax_identification_no'];
                            }
                            else if($data->tax_type_id == '2') {
                                $data->vat_registration_no = $dataarr['vat_registration_no'];
                            }
                            $data->taggroup = $dataarr['taggroup'];
                            $data->updated_by = $USER->id;
                            $data->updated_at = date("Y-m-d H:i:s");
                            $data->id = $dataarr['tcenter_id'];
                            $DB->update_record('training_center', $data);

                            $status = 0;
                            $message = 'Training Center Edited Successfully.  ';
                            $result = $data;
                        }
                        break;
                    default:
                        $status = 0;
                        $message = '';
                        $result = [];
                        break;
                }
            } else {
                $status = 1;
                $message = 'Not Valid Ajax';
                $result = [];
            }

            //
            $res = array();
            $res['status'] = $status;
            $res['message'] = $message;
            $res['result'] = $result;
            echo json_encode($res);
            break;
        case "save_tprovider":
            global $DB, $CFG, $USER;
            $dataarr = array_merge($_REQUEST);
            //echo "<pre>";print_r($dataarr);echo $dataarr['resource_id'];die;
            $status = 1;
            $message = '';
            $result = [];
            if (isset($dataarr['formaction']) && $dataarr['formaction'] != "") {
                switch ($dataarr['formaction']) {
                    case "add":
                        if (!empty($dataarr['tprovider_name']) && $DB->record_exists('training_provider', array('name' => $dataarr['tprovider_name']))) {
                            //throw new moodle_exception(get_string('resourcenametaken'), '', '', $dataarr['resource_name']);
                            $status = 1;
                            $message = "Training Provider Name Already Exist.";
                        } else {
                            $data = new stdClass;
                            $data->name = $dataarr['tprovider_name'];
                            $data->description = $dataarr['tprovider_desc'];
                            $data->is_active = isset($dataarr['is_active']) ? 1 : 0;
                            $data->created_by = $USER->id;
                            //$data->created_at = time();
                            $data->updated_by = $USER->id;
                            //$data->updated_at = time();
                            $data->id = $DB->insert_record('training_provider', $data);
                            $status = 0;
                            $message = 'Training Provider Added Successfully.  ';
                            $result = $data;
                        }
                        break;
                    case "edit":
                        if (empty($dataarr['tprovider_id'])) {
                            $status = 1;
                            $message = "No Training Provider Id For Edit";
                            break;
                        } else if (!empty($dataarr['tprovider_name'])) {
                            $sql = "select * from {training_provider} where name ='" . $dataarr['tprovider_name'] . "' and id<>" . $dataarr['tprovider_id'];
                            //if ($DB->record_exists('resources', array('resource_name' => $dataarr['resource_name']))) {
                            if ($DB->record_exists_sql($sql)) {
                                //throw new moodle_exception(get_string('resourcenametaken'), '', '', $dataarr['resource_name']);
                                $status = 1;
                                $message = "Duplicate Training Provider found.";
                                break;
                            } else {
                                $status = 0;
                            }
                        }
                        if ($status == 0) {     //  echo "in else ";     die;
                            $data = new stdClass;
                            $data->name = $dataarr['tprovider_name'];
                            $data->description = $dataarr['tprovider_desc'];
                            $data->is_active = isset($dataarr['is_active']) ? 1 : 0;
                            $data->updated_by = $USER->id;
                            $data->updated_at = date("Y-m-d H:i:s");
                            $data->id = $dataarr['tprovider_id'];
                            $DB->update_record('training_provider', $data);
                            $status = 0;
                            $message = 'Training Provider Edited Successfully.  ';
                            $result = $data;
                        }
                        break;
                    default:
                        $status = 0;
                        $message = '';
                        $result = [];
                        break;
                }
            } else {
                $status = 1;
                $message = 'Not Valid Ajax';
                $result = [];
            }

            //
            $res = array();
            $res['status'] = $status;
            $res['message'] = $message;
            $res['result'] = $result;
            echo json_encode($res);
            break;
        case "save_resources":
            global $DB, $CFG, $USER;
            $dataarr = array_merge($_REQUEST, $_FILES);
            $status = 1;
            $message = '';
            $result = [];
            if (isset($dataarr['formaction']) && $dataarr['formaction'] != "") {
                switch ($dataarr['formaction']) {
                    case "add":

                        if (!empty($dataarr['resource_name']) && $DB->record_exists('resources', array('resource_name' => $dataarr['resource_name']))) {
                            //throw new moodle_exception(get_string('resourcenametaken'), '', '', $dataarr['resource_name']);
                            $status = 1;
                            $message = "Duplicate Resource Name Taken";
                        } else {     //echo "in add condition12312";       
                            $data = new stdClass;
                            $data->resource_name = $dataarr['resource_name'];
                            $data->resource_desc = $dataarr['resource_desc'];
                            $data->resource_type_id = $dataarr['resource_type_id'];
                            $data->resource_subtype_id = $dataarr['resource_subtype_id'];
                            $data->resource_mode = $dataarr['resource_mode'];
                            $data->max_no_attendees = $dataarr['max_no_attendees'];
                            $data->training_provider = $dataarr['training_provider_id'];
                            $data->training_center = $dataarr['training_center_id'];
                            $data->location = $dataarr['location'];
                            $data->address = $dataarr['address'];
                            $data->addrline1 = $dataarr['addrline1'];
                            $data->addrline2 = $dataarr['addrline2'];
                            $data->city = $dataarr['city'];
                            $data->state = $dataarr['state'];
                            $data->country = $dataarr['country'];
                            $data->pincode = $dataarr['pincode'];
                            $data->google_map_lat = $dataarr['google_map_lat'];
                            $data->google_map_long = $dataarr['google_map_long'];
                            $data->default_seating_arrangement = $dataarr['default_seating'];
                            $data->reference = $dataarr['reference'];
                            $data->booking_instruction = $dataarr['booking_instruction'];
                            $data->startdate = (isset($dataarr['start_date']) && $dataarr['start_date'] !='' ? $dataarr['start_date'] : date("Y-m-d"));
                            $data->enddate = (isset($dataarr['end_date']) && $dataarr['end_date'] !='' ? $dataarr['end_date'] : date("Y-m-d", strtotime('+365 days')));
                            $data->default_price = $dataarr['default_price'];
                            $data->default_price_unit = $dataarr['default_price_unit'];
                            $data->contact_name = $dataarr['contact_name'];
                            $data->contact_email = $dataarr['contact_email'];
                            $data->contact_phone_mobile = $dataarr['contact_phone_mobile'];
                            $data->brief_about_trainer = $dataarr['trainer_brief'];
                            $data->trainer_sign = $dataarr['trainer_sign'];
                            $data->overbooking_flag = isset($dataarr['overbookingflag']) ? 1 : 0;
                            $data->attachment_type = $dataarr['attachment_file']['type'];

                            $data->trainer_request_id = isset($dataarr['trainer_resource_name1']) ? $dataarr['trainer_resource_name1'] : 0;
                            $data->is_deleted = 0;
                            $data->created_by = $USER->id;
                            //$data->created_at = time();
                            $data->updated_by = $USER->id;
                            //$data->updated_at = time();
                            //  echo "<pre>"; print_r($data); die;
                            
                            $data->id = $DB->insert_record('resources', $data);
                            //attachment code for uploading the files to location
                            if (isset($dataarr['attachment_file']) && is_array($dataarr['attachment_file'])) {
                              /*  // get details of the uploaded file
                                $fileTmpPath = $dataarr['attachment_file']['tmp_name'];
                                $fileName = $dataarr['attachment_file']['name'];
                                $fileSize = $dataarr['attachment_file']['size'];
                                $fileType = $dataarr['attachment_file']['type'];
                                $fileNameCmps = explode(".", $fileName);
                                $fileExtension = strtolower(end($fileNameCmps));
                                // directory in which the uploaded file will be moved
                                $uploadFileDir = './images/attachments/resources/';
                                $dest_path = $uploadFileDir . $data->id . '_' . $fileName;

                                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                    $attachmessage = 'File is successfully uploaded.';
                                    $data->attachment = $dest_path;
                                    $DB->update_record('resources', $data);
                                } else {
                                    $attachmessage = 'File Not Uploaded.';
                                }*/
                                $attid = resource_attachment_save($dataarr,$data);
                                if(count($attid)>0){
                                    $data->attachment = implode(",",$attid);
                                    $DB->update_record('resources', $data);
                                    $attachmessage = 'File is successfully uploaded.';
                                }
                                else{
                                    $attachmessage = 'File Not Uploaded.';
                                }
                            } else {
                                $attachmessage = '';
                            }
                            ////set Trainer Role at system level for Trainer Resource
                            $trainermsg = "";
                            if ($data->resource_subtype_id == "3") {
                                if ($data->resource_mode == "INTERNAL" && $data->trainer_request_id != null) {
                                    $trainer = set_system_trainer_resource($data);
                                    if ($trainer == 1) {
                                        $trainermsg = "<BR>User with Trainer Role Added successfully.";
                                    } else {
                                        $trainermsg = "<BR>User with Trainer Role already added ";
                                    }
                                } else {
                                    //External User to be added as user first and then add role
                                    $trainer = set_system_trainer_resource($data);
                                    if ($trainer == 1) {
                                        $trainermsg = "<BR>User with Trainer Role Added successfully.";
                                    } else {
                                        $trainermsg = "<BR>User with Trainer Role already added ";
                                    }
                                }
                            }
                            //
                            // return $data->id;
                            $status = 0;
                            $message = 'Resource Added Successfully.  ' . $attachmessage;
                            $result = $data;
                        }
                        break;
                    case "edit":

                        if (empty($dataarr['resource_id'])) {
                            $status = 1;
                            $message = "No Resource Id For Edit";
                            break;
                        } else if (!empty($dataarr['resource_name'])) {
                            $sql = "select * from {resources} where resource_name ='" . $dataarr['resource_name'] . "' and id<>" . $dataarr['resource_id'];
                            //if ($DB->record_exists('resources', array('resource_name' => $dataarr['resource_name']))) {
                            if ($DB->record_exists_sql($sql)) {
                                //throw new moodle_exception(get_string('resourcenametaken'), '', '', $dataarr['resource_name']);
                                $status = 1;
                                $message = "Duplicate Resource Name Taken";
                                break;
                            } else {
                                $status = 0;
                            }
                        }
                        if ($status == 0) {     //  echo "in else ";     die;
                            $data = new stdClass;
                            $data->resource_name = $dataarr['resource_name'];
                            $data->resource_desc = $dataarr['resource_desc'];
                            $data->resource_type_id = $dataarr['resource_type_id'];
                            $data->resource_subtype_id = $dataarr['resource_subtype_id'];
                            $data->resource_mode = $dataarr['resource_mode'];
                            $data->max_no_attendees = $dataarr['max_no_attendees'];
                            $data->training_provider = $dataarr['training_provider_id'];
                            $data->training_center = $dataarr['training_center_id'];
                            $data->location = $dataarr['location'];
                            $data->address = $dataarr['address'];
                            $data->addrline1 = $dataarr['addrline1'];
                            $data->addrline2 = $dataarr['addrline2'];
                            $data->city = $dataarr['city'];
                            $data->state = $dataarr['state'];
                            $data->country = $dataarr['country'];
                            $data->pincode = $dataarr['pincode'];
                            $data->google_map_lat = $dataarr['google_map_lat'];
                            $data->google_map_long = $dataarr['google_map_long'];
                            $data->default_seating_arrangement = $dataarr['default_seating'];
                            $data->reference = $dataarr['reference'];
                            $data->booking_instruction = $dataarr['booking_instruction'];
                            $data->startdate = (isset($dataarr['start_date']) && $dataarr['start_date'] !='' ? $dataarr['start_date'] : date("Y-m-d"));
                            $data->enddate = (isset($dataarr['end_date']) && $dataarr['end_date'] !=''? $dataarr['end_date'] : date("Y-m-d", strtotime('+365 days')));
                            $data->default_price = $dataarr['default_price'];
                            $data->default_price_unit = $dataarr['default_price_unit'];
                            $data->contact_name = $dataarr['contact_name'];
                            $data->contact_email = $dataarr['contact_email'];
                            $data->contact_phone_mobile = $dataarr['contact_phone_mobile'];
                            $data->brief_about_trainer = $dataarr['trainer_brief'];
                            $data->trainer_sign = $dataarr['trainer_sign'];
                            $data->overbooking_flag = isset($dataarr['overbookingflag']) ? 1 : 0;
                            $data->attachment_type = $dataarr['attachment_file']['type'];
                            $data->trainer_request_id = isset($dataarr['trainer_resource_name1']) ? $dataarr['trainer_resource_name1'] : 0;
                            $data->is_deleted = 0;
                            // $data->created_by =$USER->id;
                            //$data->created_at = time();
                            $data->updated_by = $USER->id;
                            $data->updated_at = date("Y-m-d H:i:s");
                            //  echo "<pre>"; print_r($data); die;
                            $data->id = $dataarr['resource_id'];
                            //  echo "befor update";
                            $DB->update_record('resources', $data);
                            //  echo "after update";
                            //$data->id = $DB->insert_record('resources', $data);
                            //attachment code for uploading the files to location
                            if (isset($dataarr['attachment_file']) && is_array($dataarr['attachment_file'])) {
                            /*    // get details of the uploaded file
                                $fileTmpPath = $dataarr['attachment_file']['tmp_name'];
                                $fileName = $dataarr['attachment_file']['name'];
                                $fileSize = $dataarr['attachment_file']['size'];
                                $fileType = $dataarr['attachment_file']['type'];
                                $fileNameCmps = explode(".", $fileName);
                                $fileExtension = strtolower(end($fileNameCmps));
                                // directory in which the uploaded file will be moved
                                $uploadFileDir = './images/attachments/resources/';
                                $dest_path = $uploadFileDir . $data->id . '_' . $fileName;

                                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                    $attachmessage = 'File is successfully uploaded.';
                                    $data->attachment = $dest_path;
                                    $DB->update_record('resources', $data);
                                } else {
                                    $attachmessage = 'File Not Uploaded.';
                                }*/
                              
                                $attid = resource_attachment_save($dataarr,$data);
                               
                                if(count($attid)>0){
                                    $data->attachment = implode(",",$attid);
                                    $DB->update_record('resources', $data);
                                    $attachmessage = 'File is successfully uploaded.';
                                }
                                else{
                                    $attachmessage = 'File Not Uploaded.';
                                    $rs = $DB->get_record_sql("select GROUP_CONCAT(id) as ids from {resource_attachment} where resource_id =".$data->id);
                                    if($rs != null){
                                        $data->attachment = $rs->ids; //implode(",",$attid);
                                        $DB->update_record('resources', $data);
                                        
                                    }
                                }
                            } else {
                                $attachmessage = '';
                                $rs = $DB->get_record_sql("select GROUP_CONCAT(id) as ids from {resource_attachment} where resource_id =".$data->id);
                                if($rs != null){
                                    $data->attachment = $rs->ids; //implode(",",$attid);
                                    $DB->update_record('resources', $data);
                                    
                                }
                            }
                            ////set Trainer Role at system level for Trainer Resource
                            $trainermsg = "";
                            if ($data->resource_subtype_id == "3") {
                                if ($data->resource_mode == "INTERNAL" && $data->trainer_request_id != null) {
                                    $trainer = set_system_trainer_resource($data);
                                    if ($trainer == 1) {
                                        $trainermsg = "<BR>User with Trainer Role Added successfully.";
                                    } else {
                                        $trainermsg = "<BR>User with Trainer Role already added ";
                                    }
                                } else {
                                    //External User to be added as user first and then add role
                                    $trainer = set_system_trainer_resource($data);
                                    if ($trainer == 1) {
                                        $trainermsg = "<BR>User with Trainer Role Added successfully.";
                                    } else {
                                        $trainermsg = "<BR>User with Trainer Role already added ";
                                    }
                                }
                            }
                            //
                            // return $data->id;
                            $status = 0;
                            $message = 'Resource Edited Successfully.  ' . $attachmessage . $trainermsg;
                            $result = $data;
                            // echo ("herer");
                        }

                        break;
                    default:
                        // die("in here");
                        $status = 0;
                        $message = '';
                        $result = [];
                        break;
                }
            } else {
                $status = 1;
                $message = 'Not Valid Ajax';
                $result = [];
            }

            //
            $res = array();
            $res['status'] = $status;
            $res['message'] = $message;
            $res['result'] = $result;
            echo json_encode($res);
            break;
        case "delete_tcenter":
            if (isset($_REQUEST['tcenter_id']) && $_REQUEST['tcenter_id'] != "") {
                $sql = "DELETE FROM mdl_training_center where id=" . $_REQUEST['tcenter_id'];
                if ($DB->execute($sql)) {
                    $status = 0;
                    $message = "Training Center Deleted Successfully.";
                } else {
                    $status = 1;
                    $message = "Training Center Not Deleted.";
                }
                //$status=0;
                //$message = "Training Center Deleted Successfully.";           
            }
            $res = array();
            $res['status'] = $status;
            $res['message'] = $message;
            $res['result'] = [];
            echo json_encode($res);
            break;
        case "delete_tprovider":
            if (isset($_REQUEST['tprovider_id']) && $_REQUEST['tprovider_id'] != "") {
                $sql = "DELETE FROM mdl_training_provider where id=" . $_REQUEST['tprovider_id'];
                if ($DB->execute($sql)) {
                    $status = 0;
                    $message = "Training Provider Deleted Successfully.";
                } else {
                    $status = 1;
                    $message = "Training Provider Not Deleted.";
                }
            }
            $res = array();
            $res['status'] = $status;
            $res['message'] = $message;
            $res['result'] = [];
            echo json_encode($res);
            break;
        case "delete_resources":
            if (isset($_REQUEST['resource_id']) && $_REQUEST['resource_id'] != "") {
                $rs = $DB->get_record_sql("select * from {resources} where id = ". $_REQUEST['resource_id']." and resource_subtype_id=3");
                if($rs !=null){
                    if($rs->resource_mode == "EXTERNAL"){
                        $data= $DB->get_record_sql("select * from {user} where username like '".$rs->contact_email."'");
                        if($data!=null){
                           // print_r($data);die;
                           $user = new stdClass;
                            $user->deleted =1;
                            $user->id = $data->id;
                            $DB->update_record("user",$user);
                            $DB->execute("delete from {role_assignments} where userid =".$data->id . " and roleid = ".TRAINER_ROLE_ID." and  contextid = 1");
                        }
                    }
                    else if($rs->resource_mode=="INTERNAL"){
                        $DB->execute("delete from {role_assignments} where userid =".$rs->trainer_request_id . " and roleid = ".TRAINER_ROLE_ID." and  contextid = 1");
                    }
                }else{
                    //u can delete resource Record now..
                }

                $sql = "DELETE FROM mdl_resources where id=" . $_REQUEST['resource_id'];
                if ($DB->execute($sql)) {
                    $status = 0;
                    $message = "Resource Deleted Successfully.";
                } else {
                    $status = 1;
                    $message = "Resource Not Deleted.";
                }
            }
            $res = array();
            $res['status'] = $status;
            $res['message'] = $message;
            $res['result'] = [];
            echo json_encode($res);
            break;
        case "test":
            //print_r($_REQUEST);
            $facetofaceid = $_REQUEST['f'];
            $sessionid = $_REQUEST['s'];
            $resource_action = $_REQUEST['resource_action'];
            $fromdate = $_REQUEST['hidden_startdate'];
            $enddate = $_REQUEST['hidden_enddate'];
            $resourceid = $_REQUEST['resource_id'];
            $res = checkSessionResourceAvailability($facetofaceid, $sessionid, $resourceid, $fromdate, $enddate, $resource_action);
            //$res = getBookingActiveResources($fromdate, $enddate, $resourceid);
            echo $res;
            break;
        case "change_type":
            $subtype = getResourceSubType($_REQUEST['id']);
            echo json_encode($subtype);
            break;
        case "change_tprovider":
            $tcenter = getTrainingCenter($_REQUEST['id']);
            echo json_encode($tcenter);
            break;
        case "change_tcenter":
            $tcenter = [];
            if ($_REQUEST['id'] != null) {
                $sql = "SELECT *  from {training_center} where id=" . $_REQUEST['id'] . " order by en_name asc";
                $tcenter = $DB->get_record_sql($sql);
            }
            echo json_encode($tcenter);
            break;
        case "change_country":
            $states = getStates($_REQUEST['id']);
            echo json_encode($states);
            break;
            break;
        case "get_emp_details":
            $user = getEmployees($_REQUEST['companyid'], $_REQUEST['id']);
            echo json_encode($user);
            break;
        case "change_resource_name":
            if (isset($_REQUEST['fromdate']) && isset($_REQUEST['todate'])) {
                $daterange['fromdate'] = $_REQUEST['fromdate'];
                $daterange['todate'] = $_REQUEST['todate'];
            }
            $resources = getResources($_REQUEST['typeid'], $_REQUEST['subtypeid'], $daterange);
            echo json_encode($resources);
            break;
        case "resource_booking_before_save":
            // echo "<pre>";
            //print_r($_REQUEST);die;
            $resourcetypename = $_REQUEST['resource_type_name'];
            $resourcesubtypename = $_REQUEST['resource_sub_type_name'];
            $resourcename = $_REQUEST['resource_name'];
            $resourceqty = $_REQUEST['resource_qty'];
            $resourceoption = $_REQUEST['resource_option'];
            $fromdate = $_REQUEST['hidden_startdate'];
            $enddate = $_REQUEST['hidden_enddate'];
            $resourceid = $_REQUEST['resource_id'];
            $duplicate = false;
            if ($_REQUEST['collection'] != "") {
                $coll = json_decode($_REQUEST['collection']);
                foreach ($coll as $c) {
                    if ($c->resource_id == $resourceid) {
                        $duplicate = true;
                        break;
                    }
                }
            }
            if ($duplicate != true) {
                $resarr = new stdclass;
                foreach ($_REQUEST as $k => $r) {
                    if ($k != "collection" && $k != "action") {
                        $resarr->$k = $r;
                    }
                }
                $res = getBookingActiveResources($fromdate, $enddate, $resourceid);
                $resarr->resource_status = $res;
                $link = $CFG->wwwroot . "/local/resources/ajax.php";
                $table = new html_table();
                //$table->head = ['Resource Type', 'Resource Sub Type', 'Resource Name', 'Qty', "Option", "Status", 'Action'];
                $table->head = ['Resource Type', 'Resource Sub Type', 'Resource Name', "Option", "Status", 'Action'];

                if ($_REQUEST['collection'] != "") {
                    $coll = json_decode($_REQUEST['collection']);
                    // print_r($coll);
                    foreach ($coll as $k => $c) {
                        //$table->data[] = [$c->resource_type_name, $c->resource_sub_type_name, $c->resource_name, $c->resource_qty, $c->resource_option, $c->resource_status, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>'];
                        $table->data[] = [$c->resource_type_name, $c->resource_sub_type_name, $c->resource_name, $c->resource_option, $c->resource_status, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>'];
                        $jres[] = $c;
                    }
                    $table->data[] = array($resourcetypename, $resourcesubtypename, $resourcename, $resourceoption, $res, '<a href="' . $link . '"  onClick="deleteRequest(this.href,this.id);return false;" id="' . $resourceid . '">Delete</a> |<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $resourceid . '" >View Calendar</a>');
                    //$table->data[] = array($resourcetypename, $resourcesubtypename, $resourcename, $resourceqty, $resourceoption, $res, '<a href="' . $link . '"  onClick="deleteRequest(this.href,this.id);return false;" id="' . $resourceid . '">Delete</a> |<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $resourceid . '" >View Calendar</a>');

                    $jres[] = $resarr;
                } else {
                    // die("here");
                    $table->data[] = array($resourcetypename, $resourcesubtypename, $resourcename, $resourceoption, $res, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $resourceid . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $resourceid . '" >View Calendar</a>');
                    //$table->data[] = array($resourcetypename, $resourcesubtypename, $resourcename, $resourceqty, $resourceoption, $res, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $resourceid . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $resourceid . '" >View Calendar</a>');
                    $jres[] = $resarr;
                }
                $errMsg = '';
                $result['resource_json_data'] = json_encode($jres);
                $result['resource_table'] = html_writer::table($table);
            } else {
                $result['resource_json_data'] = $_REQUEST['collection'];
                $result['resource_table'] = '';
                $errMsg = "Resource already Added";
            }
            // echo html_writer::table($table);

            $result['errorMsg'] = $errMsg;
            echo json_encode($result);

            break;
        case "delete_resource_request":
            // print_r($_REQUEST);
            $resourceid = $_REQUEST['id'];
            if ($resourceid != "") {
                $coll = json_decode($_REQUEST['collection']);
                foreach ($coll as $c) {
                    if ($c->resource_id != $resourceid) {
                        $coll1[] = $c;
                    }
                }
                $link = $CFG->wwwroot . "/local/resources/ajax.php";
                // echo "<pre>";print_r($coll1);die;
                if ($coll1 != "") {
                    $table = new html_table();
                    //$table->head = ['Resource Type', 'Resource Sub Type', 'Resource Name', 'Qty', "Option", "Status", 'Action'];
                    $table->head = ['Resource Type', 'Resource Sub Type', 'Resource Name', "Option", "Status", 'Action'];

                    foreach ($coll1 as $k => $c) {
                        //$table->data[] = [$c->resource_type_name, $c->resource_sub_type_name, $c->resource_name, $c->resource_qty, $c->resource_option, $c->resource_status, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>'];
                        $table->data[] = [$c->resource_type_name, $c->resource_sub_type_name, $c->resource_name, $c->resource_option, $c->resource_status, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>'];
                        $jres[] = $c;
                    }
                    $errMsg = '';
                    $result['resource_json_data'] = json_encode($jres);
                    $result['resource_table'] = html_writer::table($table);
                } else {
                    $errMsg = '';
                    $result['resource_json_data'] = '';
                    $result['resource_table'] = '';
                }
                echo json_encode($result);
            }
            break;
        case "show_popup_resource_request":
            // print_r($_REQUEST);
            $coll = json_decode($_REQUEST['collection']);
            $link = $CFG->wwwroot . "/local/resources/ajax.php";
            // echo "<pre>";print_r($coll1);die;
            if ($coll != "") {
                $table = new html_table();
                $table->head = ['Resource Type', 'Resource Sub Type', 'Resource Name', 'Qty', "Option", "Status", 'Action'];
                $table->head = ['Resource Type', 'Resource Sub Type', 'Resource Name', "Option", "Status", 'Action'];

                foreach ($coll as $k => $c) {
                    //$table->data[] = [$c->resource_type_name, $c->resource_sub_type_name, $c->resource_name, $c->resource_qty, $c->resource_option, $c->resource_status, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>'];
                    $table->data[] = [$c->resource_type_name, $c->resource_sub_type_name, $c->resource_name, $c->resource_option, $c->resource_status, '<a href="' . $link . '" onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>'];
                    $jres[] = $c;
                }
                echo html_writer::table($table);
            } else {
                echo "";
            }
            break;
        case "get_resource_booking":
            // print_r($_REQUEST);
            $resourceid = $_REQUEST['id'];

            if (isset($_REQUEST['hidden_startdate']) && isset($_REQUEST['hidden_enddate'])) {
                $startdate = $_REQUEST['hidden_startdate'];
                $enddate = $_REQUEST['hidden_enddate'];
                if ($startdate != "" && $enddate != "") {
                    $hsdate = date("Y-m-d H:i:s", strtotime($startdate));
                    $hedate = date("Y-m-d H:i:s", strtotime($enddate));
                    $hDates = getDatesFromRange($sdate, $edate);
                    foreach ($hDates as $d) {
                        $year[date("Y", strtotime($d))] = date("Y", strtotime($d));
                        $mon[date("m", strtotime($d))] = date("m", strtotime($d)) - 1;
                        $day[date("d", strtotime($d))] = date("d", strtotime($d));
                        $rules[date("Y", strtotime($d))][date("m", strtotime($d)) - 1][date("d", strtotime($d))] = "preselected";
                    }
                }
            }
            $lang = current_language();
            // echo $lang."<BR>";
            $context = context_system::instance();
            $companyid = iomad::get_my_companyid($context);

            if ($lang = "en") {
                $clang = "";
            } else {
                $clang = $lang . "_";
            }
            $lang = $lang . "_";
            //echo $lang;
            $course_name = "c." . $clang . "fullname as course_name";
            $sql = "SELECT rb.*,r." . $lang . "resource_name as resource_name,f.name as facetoface_name,s.name as session_name," . $course_name . "
                    from mdl_resource_booking as rb
                    left JOIN mdl_resources as r on r.id=rb.resource_id
                    left JOIN mdl_zingilt as f on rb.facetoface_id=f.id
                    LEFT Join mdl_zingilt_sessions as s on rb.session_id=s.id
                    left joIN mdl_course as c on f.course=c.id
                    where rb.resource_id= " . $resourceid . " AND rb.booking_status='CONFIRMED' AND rb.companyid=" . $companyid;
            //echo $sql;die;
            $res = $DB->get_records_sql($sql);
            if ($res != null) {
                $rules = [];
                foreach ($res as $k => $c) {
                    $sdate = date("Y-m-d H:i:s", strtotime($c->start_date));
                    $edate = date("Y-m-d H:i:s", strtotime($c->end_date));
                    $Dates = getDatesFromRange($sdate, $edate);
                    //print_r($Dates);
                    foreach ($Dates as $d) {
                        $year[date("Y", strtotime($d))] = date("Y", strtotime($d));
                        $mon[date("m", strtotime($d))] = date("m", strtotime($d)) - 1;
                        $day[date("d", strtotime($d))] = date("d", strtotime($d));
                        $rules[date("Y", strtotime($d))][date("m", strtotime($d)) - 1][date("d", strtotime($d))] = "booked_venues";
                        $sessiondate[date("Ymd", strtotime($d))]['date'][] = date("H:i:s", strtotime($sdate)) . "-" . date("H:i:s", strtotime($edate));
                        $sessiondate[date("Ymd", strtotime($d))]['course'] = $c->course_name;
                        $sessiondate[date("Ymd", strtotime($d))]['class'] = $c->facetoface_name;
                        $sessiondate[date("Ymd", strtotime($d))]['session'] = $c->session_name;
                    }
                    /*if ($hourdiff > 8) {
                $rules[implode(",", $year)][implode(",", $mon)][implode(",", $day)] = "disable_venues";
                }*/
                }
                //print_r($sessiondate);
                foreach ($sessiondate as $k => $s) {
                    //  print_r($s);
                    $table = new html_table();
                    $table->head = array('Class-Session', 'StartTime - EndTime');
                    foreach ($s['date'] as $v) {
                        $table->data[] = array("<B>Class:</B>" . $s['class'] . "<BR><B>Session:</B>" . $s['session'], $v);
                    }
                    $datacontent[$k] = html_writer::table($table);
                    // echo html_writer::table($table);

                }
            } else {
                $rules = "";
                $datacontent = "";
            }

            if ($res != null) {
                $table = new html_table();
                $table->head = ['Course', "Class", "Session", 'Resource Name', 'Start Date/time', 'End Date/Time'];

                foreach ($res as $k => $c) {
                    $table->data[] = [$c->course_name, $c->facetoface_name, $c->session_name, $c->resource_name, date("d M Y, H:i:s", strtotime($c->start_date)), date("d M Y, H:i:s", strtotime($c->end_date))];
                }
                $datatablecontent = html_writer::table($table);
            } else {
                $datatablecontent = "";
            }
            $result['rules'] = $rules;
            $result['datacontent'] = $datacontent;
            $result['datatablecontent'] = $datatablecontent;
            echo json_encode($result);
            break;
        case "resource_booking_edit":
            //echo "<pre>";  print_r($_REQUEST);
            $coll = json_decode($_REQUEST['collection']);
            // print_r($coll);
            $fromdate = $_REQUEST['fromdate'];
            $enddate = $_REQUEST['todate'];
            $facetofaceid = $_REQUEST['f'];
            $sessionid = $_REQUEST['s'];
            $resource_action = $_REQUEST['resource_action'];
            $link = $CFG->wwwroot . "/local/resources/ajax.php";
            if ($coll != "") {
                $table = new html_table();
                //$table->head = ['id', 'Resource Type', 'Resource Sub Type', 'Resource Name', 'Qty', "Option", "Status", 'Action'];
                $table->head = ['id', 'Resource Type', 'Resource Sub Type', 'Resource Name', "Option", "Status", 'Action'];
                $resource_type = getResourceType();
                $resarr = [];
                foreach ($coll as $k => $c) {

                    //$select .= html_writer::select($courseoptions, 'course', $selected, false, ['class' => 'cal_courses_flt']);
                    $resource_type_select = html_writer::select($resource_type, 'resource_type_id[' . $k . ']', $c->resource_type_id, false, ['class' => 'resource_type', "data-id" => $k]);
                    $resource_subtype = getResourceSubType($c->resource_type_id);
                    $resource_subtype_select = html_writer::select($resource_subtype, 'resource_subtype_id[' . $k . ']', $c->resource_subtype_id, false, ['class' => 'resource_subtype', "data-id" => $k]);
                    $daterange['fromdate'] = $fromdate;
                    $daterange['todate'] = $enddate;
                    $resources = getResources($c->resource_type_id, $c->resource_subtype_id, $daterange);
                    $resource_select = html_writer::select($resources, 'resource_id[' . $k . ']', $c->resource_id, false, ['class' => 'resource', "data-id" => $k]);
                    $qty_text = "<input type='text' name='resource_qty[" . $k . "]' value='" . $c->resource_qty . "'>";
                    $options[''] = get_string('select');
                    $options['OPTIONAL'] = "OPTIONAL";
                    $options['REQUIRED'] = "REQUIRED";
                    $resource_option_select = html_writer::select($options, 'resource_option[' . $k . ']', $c->resource_option, false, ['class' => 'resource_option', "data-id" => $k]);
                    if (in_array($c->resource_id, $resarr)) {
                        $res = "Duplicate Entry";
                    } else {
                        $res = checkSessionResourceAvailability($facetofaceid, $sessionid, $c->resource_id, $fromdate, $enddate, $resource_action);
                        $resarr[] = $c->resource_id;
                    }
                    if ($res == "CONFIRMED - Available") {
                        $classname = "text-success";
                    } else if ($res == "PLANNED - Unavailable") {
                        $classname = "text-danger";
                    } else {
                        $classname = "";
                    }
                    $resource_status = "<B><span id='resource_status_$k' name='resource_status[" . $k . "]' data-id='" . $k . "' class='resource_status " . $classname . "'>" . $res . "</span><b>";
                    //$table->data[] = [$k + 1, $resource_type_select, $resource_subtype_select, $resource_select, $qty_text, $resource_option_select, $resource_status, '<a href="' . $link . '"  onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a>|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>'];
                    $table->data[] = [
                        $k + 1,
                        $resource_type_select,
                        $resource_subtype_select,
                        $resource_select,
                        $resource_option_select,
                        $resource_status,
                        '<a href="' . $link . '"  onClick="deleteRequest(this.href,this.id);return false;" id="' . $c->resource_id . '">Delete</a> 
                        | <a class="viewmodallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>',
                    ];
                    //|<a class="viewcallink"  href="' . $link . '" data-resource_id="' . $c->resource_id . '" >View Calendar</a>
                }
                echo html_writer::table($table);
            } else {
                $table = new html_table();
                //$table->head = ['id', 'Resource Type', 'Resource Sub Type', 'Resource Name', 'Qty', "Option", "Status", 'Action'];
                $table->head = ['No Resource Booking Data Available'];
                echo html_writer::table($table);
            }

            break;
        case "resource_check_availability":

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
        case "get_resource_booking_by_date":
            //echo "<pre>"; print_r($_REQUEST);
            $resourceid = $_REQUEST['id'];
            $selecteddate = $_REQUEST['selecteddate'];
            $context = context_system::instance();
            $companyid = iomad::get_my_companyid($context);
            $lang = current_language();
            if ($lang = "en") {
                $lang = "";
            } else {
                $lang = $lang . "_";
            }
            $course_name = "c." . $lang . "fullname as course_name";
            $sql = "SELECT rb.*,r." . $lang . "_resource_name as resource_name,f.name as facetoface_name,s.name as session_name," . $course_name . " from mdl_resource_booking as rb
                        left JOIN mdl_resources as r on r.id=rb.resource_id
                        left JOIN mdl_zingilt as f on rb.facetoface_id=f.id
                        LEFT Join mdl_zingilt_sessions as s on rb.session_id=s.id
                        left joIN mdl_course as c on f.course=c.id
                         where rb.resource_id= " . $resourceid . " and companyid=" . $companyid;
            //echo $sql;die;
            $res = $DB->get_records_sql($sql);
            // echo "<pre>";print_r($res);
            if ($res != null) {
                foreach ($res as $k => $c) {
                    $sdate = date("Y-m-d H:i:s", strtotime($c->start_date));
                    $edate = date("Y-m-d H:i:s", strtotime($c->end_date));
                    $Dates = getDatesFromRange($sdate, $edate);
                    //print_r($Dates);
                    foreach ($Dates as $d) {
                        $year[date("Y", strtotime($d))] = date("Y", strtotime($d));
                        $mon[date("m", strtotime($d))] = date("m", strtotime($d)) - 1;
                        $day[date("d", strtotime($d))] = date("d", strtotime($d));
                        $sessiondate[date("Ymd", strtotime($d))][] = date("H:i:s", strtotime($sdate)) . "-" . date("H:i:s", strtotime($edate));
                    }
                    //echo "<BR>". $sdate."-".$edate;
                    if ($hourdiff > 8) {
                        $rules[implode(",", $year)][implode(",", $mon)][implode(",", $day)] = "disable_venues";
                    }
                }
                // $rules[implode(",", $year)][implode(",", $mon)][implode(",", $day)] = "booked_venues";
                // print_r($rules);
                foreach ($sessiondate as $k => $s) {
                    //////////////
                    if ($k == $selecteddate) {
                        $table = new html_table();
                        $table->head = array("Course", 'Class', 'Session', 'StartTime - EndTime');
                        foreach ($s as $v) {
                            $table->data[] = array($c->course_name, $c->facetoface_name, $c->session_name, $v);
                        }
                        // echo $k."++++".html_writer::table($table);
                        $datacontent[$k] = html_writer::table($table);
                    }

                    ///////
                    /*  $table = new html_table();
                $table->head = array('StartTime - EndTime');
                foreach ($s as $v) {
                $table->data[] = array($v);
                }*/
                }
            } else {
                //$rules = "";
                $datacontent = "";
            }

            /*if ($res != null) {
            $table = new html_table();
            $table->head = ['Resource Name','facetoface_id','session_id', 'Start Date/time', 'End Date/Time'];

            foreach ($res as $k => $c) {
            $table->data[] = [$c->resource_name,$c->facetoface_id,$c->session_id, date("d M Y, H:i:s", strtotime($c->start_date)), date("d M Y, H:i:s", strtotime($c->end_date))];
            }
            // echo  html_writer::table($table);
            $datatablecontent = html_writer::table($table);
            } else {
            $datatablecontent = "";
            }*/
            // $result['rules'] = $rules;
            $result['datacontent'] = $datacontent;
            //$result['datatablecontent'] = $datatablecontent;
            echo json_encode($result);
            break;
        case "trainer_approve_request":
            //  echo "<pre>";
            //  print_r($_REQUEST);//print_r($USER);
            $logres = new stdClass;
            $logres->id = $_REQUEST['request_id'];
            $logres->submitted_by = $USER->id;
            $logres->remark = $_REQUEST['request_comment'];
            $sql = "SELECT * FROM {trainer_request_log} where trainer_request_id=" . $logres->id . " order by id desc";
            $res = $DB->get_record_sql($sql);
            //print_r($res);
            $context_system = context_system::instance();
            //print_r($context_system);
            $roles = get_user_roles($context_system, $USER->id, true);

            foreach ($roles as $r) {
                $rolename[$r->roleid] = $r->shortname;
                $roleids[] = $r->roleid;
            }
            //print_r($res);
            //print_r($rolename); die;
            // print_r($roleids);

            if ($res != null) {
                switch ($res->status) {
                    case 1:
                        //   echo "in request status 1 condition";
                        //submitted and current role is training admin then set to under review(2)
                        //request status should be >1
                        $context = context_system::instance();
                        $companyid = 0;//iomad::get_my_companyid($context);
                        if (in_array("contentprovider", $rolename) && array_key_exists(22, $rolename)) {
                            // if( $logres->request_status > $res->status ){//die("in if condition");
                            $trainer_request = $DB->get_record_sql("select * from {trainer_requests} where id = " . $logres->id . " and companyid =" . $companyid);
                            //  print_r($trainer_request->request_status);
                            // print_r($res->status);print_r($logres); die;
                            if ($trainer_request->request_status == $res->status) { //die("in if condition");
                                //die("here in if condition");

                                $trainer_request->request_status = 2;
                                $logres->request_status = 2;
                                $logres->trainer_request = $trainer_request->id;

                                $DB->update_record('trainer_requests', $trainer_request);

                                $logid = trainer_request_log_add($logres, $logres->remark);
                                //send notification to Line manager
                                $user = $DB->get_record("user", array("id" => $trainer_request->emp_id));
                                $manager = $DB->get_record("user", array("username" => $user->supervisor_username));
                                if ($user != null && $manager != null) {
                                    // $viewurl=new moodle_url("local/resources/trainer_request_list.php");
                                    $viewurl = $CFG->wwwroot . "/local/resources/trainer_request_list.php";
                                    // echo $viewurl;

                                    $notifnContent = "<p> Hi, " . $manager->firstname . "
                                                <br> This is to notify that Training Admin has requested your subordinate " . $user->firstname . "
                                                for the Trainer Registration. Requesting you to take action on the Trainer Request. <br>
                                                From ::" . $USER->firstname . " " . $USER->lastname . "[Training Admin]<BR>
                                                Remark :: " . $logres->remark . "<BR>
                                                <a href='" . $viewurl . "'>View Trainer Request</a>
                                                <br>
                                                    Thanks <br><br>
                                                    <i>SDG Learning & Development Team </i></p>";

                                    $subject = 'Trainer Request from Training Admin';
                                    $contexturl = null;
                                    $contexturlname = 'Trainer Request from Training Admin';
                                    send_mailandnotification($user->id, $notifnContent, $manager->id, $subject, $contexturl, $contexturlname);
                                }
                                $result['message'] = "Request has been Approved Successfully.";
                                $result['status'] = 'success';
                                $result['viewurl'] = $viewurl;

                                // redirect($viewurl, get_string('trainer_request_approvedok', 'local_resources'), null, \core\output\notification::NOTIFY_SUCCESS);
                                //echo "log and status updated successfully";
                                ///////////
                            } else {
                                $result['message'] = "approval can not be reverse Direction/Request status not match";
                                $result['status'] = "fail";
                                $result['viewurl'] = $viewurl;
                            }
                        } else {
                            $result['message'] = "You can not approve this Request as You are not Training Admin";
                            $result['status'] = "fail";
                            $result['viewurl'] = $viewurl;
                        }
                        echo json_encode($result);
                        break;
                    case 2: //under review and current role is SME/Line manager then set to pending security check (3)
                        //request status should be >2  notification should be going to training Reviewer
                        //echo "in request status 2 condition";
                        $context = context_system::instance();
                        $companyid =0;// iomad::get_my_companyid($context);
                        $trainer_request = $DB->get_record_sql("select * from {trainer_requests} where id = " . $logres->id . " and companyid =" . $companyid);
                        //print_r($trainer_request);
                        $user = $DB->get_record("user", array("id" => $trainer_request->emp_id));
                        $manager = $DB->get_record("user", array("username" => $user->supervisor_username));
                        if ($USER->id == $manager->id) {
                            //echo "You are allowed for this Request Approval";
                            $trainer_request->request_status = 3;
                            $logres->request_status = 3;
                            $logres->trainer_request = $trainer_request->id;

                            $DB->update_record('trainer_requests', $trainer_request);

                            $logid = trainer_request_log_add($logres, $logres->remark);
                            //notification to training Reviewer
                            /* $training_admin = $DB->get_records_sql("select u.id,u.username,u.firstname,ra.roleid from mdl_user as u
                            left join mdl_role_assignments as ra on u.id=ra.userid
                            left join mdl_company_users as cu on u.id=cu.userid
                            where ra.roleid=? and cu.companyid=? and ra.contextid=?",array(22,$USER->company->id,1));
                            print_r($training_reviewer);
                             */
                            $viewurl = $CFG->wwwroot . "/local/resources/trainer_request_list.php";
                            //   echo $viewurl;
                            ///reviewer role to be taken by Facility manager for now will be changing when reviewer role added.
                            $training_reviewer = $DB->get_records_sql("select u.id,u.username,u.firstname,ra.roleid from mdl_user as u
                                        left join mdl_role_assignments as ra on u.id=ra.userid
                                        left join mdl_company_users as cu on u.id=cu.userid
                                        where ra.roleid=? and cu.companyid=? and ra.contextid=?", array(TRAINER_ROLE_ID, $companyid, 1));
                            // print_r($training_reviewer);
                            if ($training_reviewer != null) {
                                foreach ($training_reviewer as $tr) {
                                    //sending notification to each Training Reviewer

                                    $notifnContent = "<p> Hi, " . $tr->firstname . "
                                                  <br> This is to notify that SME/Line Manager " . $USER->firstname . " has Approved his subordinate " . $user->firstname . "
                                                  request  for the Trainer Registration. Requesting you to review action on the Trainer Request. <br>
                                                  From ::" . $USER->firstname . " " . $USER->lastname . "[SME/Line Manager]<BR>
                                                  Remark :: " . $logres->remark . "<BR>
                                                  <a href='" . $viewurl . "'>View Trainer Request</a>
                                                  <br>
                                                      Thanks <br><br>
                                                      <i>SDG Learning & Development Team </i></p>";
                                    // echo $notifnContent;
                                    $subject = 'Trainer Request approval from SME/Line Manager';
                                    $contexturl = null;
                                    $contexturlname = 'Trainer Request approval from SME/Line Manager';
                                    send_mailandnotification($USER->id, $notifnContent, $tr->id, $subject, $contexturl, $contexturlname);

                                    //  notify_trainer_request($USER,$tr->id,$trainer_request->id);
                                }
                            }
                            $result['message'] = "Request has been Approved Successfully.";
                            $result['status'] = 'success';
                            $result['viewurl'] = $viewurl;
                        } else {
                            $result['message'] = "Sorry, YOu are not allowed for this Request Approval";
                            $result['status'] = 'fail';
                            $result['viewurl'] = $viewurl;
                        }
                        echo json_encode($result);
                        break;
                    case 3: // Pending Review Check and current role is current role is training dept reviewer then set to Request Information(4)
                        // request status should be >3
                        //echo "in request status 3 case--pending review check to Request Information ";
                        $context = context_system::instance();
                        $companyid = iomad::get_my_companyid($context);
                        if (in_array("trainingcoordinator", $rolename) && array_key_exists(23, $rolename)) {
                            //  echo "You are allowed in the approval request";die;
                            // if( $logres->request_status > $res->status ){//die("in if condition");
                            $trainer_request = $DB->get_record_sql("select * from {trainer_requests} where id = " . $logres->id . " and companyid =" . $companyid);
                            //print_r($trainer_request->request_status);
                            // print_r($res->status);print_r($logres); die;
                            if ($trainer_request->request_status == $res->status) { //die("in if condition");
                                //die("here in if condition");

                                $trainer_request->request_status = 4;
                                $logres->request_status = 4;
                                $logres->trainer_request = $trainer_request->id;

                                $DB->update_record('trainer_requests', $trainer_request);

                                $logid = trainer_request_log_add($logres, $logres->remark);
                                //send notification to Line manager
                                $user = $DB->get_record("user", array("id" => $trainer_request->emp_id));
                                $manager = $DB->get_record("user", array("username" => $user->supervisor_username));
                                if ($user != null && $manager != null) {

                                    $viewurl = $CFG->wwwroot . "/local/resources/trainer_request_list.php";
                                    $notifnContent = "<p> Hi, " . $user->firstname . "
                                                <br> This is to notify that Training Reviewer " . $USER->firstname . " has approved your trainer request  for the Trainer Registration.
                                                Requesting you to Enter Bank Details for the Same. <br>
                                                From ::" . $USER->firstname . " " . $USER->lastname . "[Training Department Reviewer]<BR>
                                                Remark :: " . $logres->remark . "<BR>
                                                <a href='" . $viewurl . "'>View Trainer Request</a>
                                                <br>
                                                    Thanks <br><br>
                                                    <i>SDG Learning & Development Team </i></p>";
                                    //echo $notifnContent;
                                    $subject = 'Trainer Request approval from Training Dept Reviewer';
                                    $contexturl = null;
                                    $contexturlname = 'Trainer Request approval from Training Dept Reviewer';
                                    send_mailandnotification($USER->id, $notifnContent, $user->id, $subject, $contexturl, $contexturlname);

                                    //notify_trainer_request($USER,$user->id,$trainer_request->id);
                                    //echo "Notificatin Sent";
                                }
                                //echo "log and status updated successfully";
                                ///////////
                                $result['message'] = "Request has been Approved Successfully.";
                                $result['status'] = 'success';
                                $result['viewurl'] = $viewurl;
                            } else {
                                $result['message'] = "approval can not be reverse Direction/Request status not match";
                                $result['status'] = 'fail';
                                $result['viewurl'] = $viewurl;
                            }
                        } else {
                            $result['message'] = "You can not approve this Request as You are not Training Reviewer";
                            $result['status'] = 'fail';
                            $result['viewurl'] = $viewurl;
                        }
                        echo json_encode($result);
                        break;
                    case 4: //Request Information and current role is Trainer then show the Bank details page
                        //on saving bank details page, we update the status as "Pending training manager approval" (5)
                        // request status should be  >4
                        ///code written in the Bank details form need to check trainer_request_bank_form.php
                        break;
                    case 5: //Pending Training Manager Approval and current role is training dept manager then set to approved/Rejected
                        //request status should be >5
                        //echo "In the case 5 - current role is training dept manager then set to approved and notification sent to training admin";
                        $context = context_system::instance();
                        $companyid = iomad::get_my_companyid($context);
                        if (in_array("trainingdepartmentmanager", $rolename) && array_key_exists(18, $rolename)) {
                            //  echo "You are allowed in the approval request";die;
                            //print_r($res->status);print_r($logres); die;
                            // if( $logres->request_status > $res->status ){//die("in if condition");
                            $trainer_request = $DB->get_record_sql("select * from {trainer_requests} where id = " . $logres->id . " and companyid =" . $companyid);
                            //print_r($trainer_request->request_status);
                            //print_r($res->status);print_r($logres); die;
                            if ($trainer_request->request_status == $res->status) { //die("in if condition");
                                //die("here in if condition");

                                $trainer_request->request_status = 6;
                                $logres->request_status = 6;
                                $logres->trainer_request = $trainer_request->id;
                                $DB->update_record('trainer_requests', $trainer_request);

                                $logid = trainer_request_log_add($logres, $logres->remark);
                                //send notification to Training Admin
                                $training_admin = $DB->get_records_sql("select u.id,u.username,u.firstname,ra.roleid from mdl_user as u
                                                left join mdl_role_assignments as ra on u.id=ra.userid
                                                left join mdl_company_users as cu on u.id=cu.userid
                                                where ra.roleid=? and cu.companyid=? and ra.contextid=?", array(22, $companyid, 1));
                                //print_r($training_admin);

                                ///reviewer role to be taken by Facility manager for now will be changing when reviewer role added.
                                /*$training_reviewer = $DB->get_records_sql("select u.id,u.username,u.firstname,ra.roleid from mdl_user as u
                                left join mdl_role_assignments as ra on u.id=ra.userid
                                left join mdl_company_users as cu on u.id=cu.userid
                                where ra.roleid=? and cu.companyid=? and ra.contextid=?",array(29,$USER->company->id,1));
                                print_r($training_reviewer);*/
                                if ($training_admin != null) {
                                    foreach ($training_admin as $tr) {
                                        //sending notification to each Training Admin
                                        //notify_trainer_request($USER,$tr->id,$trainer_request->id);
                                        $viewurl = $CFG->wwwroot . "/local/resources/trainer_request_list.php";

                                        $notifnContent = "<p> Hi, " . $tr->firstname . "
                                                            <br> This is to notify that training Manager " . $USER->firstname . " has Approved  request  for the Trainer Registration. Requesting you to review action on the Trainer Request. <br>
                                                            From ::" . $USER->firstname . " " . $USER->lastname . "[Training dept Manager]<BR>
                                                            Remark :: " . $logres->remark . "<BR>
                                                            <a href='" . $viewurl . "'>View Trainer Request</a>
                                                            <br>
                                                                Thanks <br><br>
                                                                <i>SDG Learning & Development Team </i></p>";
                                        //echo $notifnContent;
                                        $subject = 'Trainer Request approval from Training Dept Manager';
                                        $contexturl = null;
                                        $contexturlname = 'Trainer Request approval from Training Dept Manager';
                                        send_mailandnotification($USER->id, $notifnContent, $tr->id, $subject, $contexturl, $contexturlname);
                                    }
                                }
                                $result['message'] = "Request has been Approved Successfully.";
                                $result['status'] = 'success';
                                $result['viewurl'] = $viewurl;
                                // echo "log and status updated successfully";
                                ///////////
                            } else {
                                $result['message'] = "approval can not be reverse Direction/Request status not match";
                                $result['status'] = 'fail';
                                $result['viewurl'] = $viewurl;
                                //echo
                            }
                        } else {
                            $result['message'] = "You can not approve this Request as You are not Training Manager";
                            $result['status'] = 'fail';
                            $result['viewurl'] = $viewurl;
                        }
                        echo json_encode($result);
                        die;

                        break;
                    case 6: //Approved --set by training Manager
                        //echo "here in case 6 -approved-- you must be training Admin";
                        $context = context_system::instance();
                        $companyid = iomad::get_my_companyid($context);
                        if (in_array("contentprovider", $rolename) && array_key_exists(22, $rolename)) {
                            //  echo "You are allowed in the approval request";die;
                            //print_r($res->status);print_r($logres); die;
                            // if( $logres->request_status > $res->status ){//die("in if condition");
                            $trainer_request = $DB->get_record_sql("select * from {trainer_requests} where id = " . $logres->id . " and companyid =" . $companyid);
                            //print_r($trainer_request->request_status);
                            //print_r($res->status);print_r($logres); die;
                            if ($trainer_request->request_status == $res->status) { //die("in if condition");
                                //die("here in if condition");

                                $trainer_request->request_status = 8; //status set to Pending Contract
                                $logres->request_status = 8;
                                $logres->trainer_request = $trainer_request->id;
                                $DB->update_record('trainer_requests', $trainer_request);

                                $logid = trainer_request_log_add($logres, $logres->remark);
                                $user = $DB->get_record("user", array("id" => $trainer_request->emp_id));
                                $manager = $DB->get_record("user", array("username" => $user->supervisor_username));
                                if ($user != null && $manager != null) {

                                    $viewurl = $CFG->wwwroot . "/local/resources/trainer_request_list.php";
                                    $notifnContent = "<p> Hi, " . $user->firstname . "
                                                  <br> This is to notify that Training Admin " . $USER->firstname . " has approved your trainer request  for the Trainer Registration.
                                                  Requesting you to Upload the Contract Details for the Same. <br>
                                                  From ::" . $USER->firstname . " " . $USER->lastname . "[Training Department Admin]<BR>
                                                  Remark :: " . $logres->remark . "<BR>
                                                  <a href='" . $viewurl . "'>View Trainer Request</a>
                                                  <br>
                                                      Thanks <br><br>
                                                      <i>SDG Learning & Development Team </i></p>";
                                    //echo $notifnContent;
                                    $subject = 'Trainer Request approval from Training Dept Admin';
                                    $contexturl = null;
                                    $contexturlname = 'Trainer Request approval from Training Dept Admin';
                                    send_mailandnotification($USER->id, $notifnContent, $user->id, $subject, $contexturl, $contexturlname);
                                }

                                $result['message'] = "Request has been Approved Successfully.  Now Waiting for the Contract to Upload.";
                                $result['status'] = 'success';
                                $result['viewurl'] = $viewurl;
                                //echo "log and status updated successfully";
                                ///////////
                            } else {
                                $result['message'] = "Approval can not be reverse Direction/Request status not match";
                                $result['status'] = 'fail';
                                $result['viewurl'] = $viewurl;
                            }
                        } else {
                            $result['message'] = "You can not approve this Request as You are not Training Admin";
                            $result['status'] = 'fail';
                            $result['viewurl'] = $viewurl;
                        }
                        echo json_encode($result);
                        die;
                        break;
                    case 7: // Rejected  --set by any role
                        break;
                    case 8: //Pending Contract   -set by training Admin
                        break;
                    case 9: // Set to Master Transfer  -set by Training Admin
                        break;
                }
            } else {
                //  trainer_request_log_add($logres);
            }
            // print_r($res);
            break;
        case "trainer_reject_request":
            // echo "<pre>"; print_r($_REQUEST);
            $context = context_system::instance();
            $companyid = iomad::get_my_companyid($context);
            $logres = new stdClass;
            $logres->id = $_REQUEST['request_id'];
            $logres->submitted_by = $USER->id;
            $logres->remark = $_REQUEST['request_comment'];
            $sql = "SELECT * FROM {trainer_request_log} where trainer_request_id=" . $logres->id . " order by id desc";
            $res = $DB->get_record_sql($sql);

            $trainer_request = $DB->get_record_sql("select * from {trainer_requests} where id = " . $logres->id . " and companyid =" . $companyid);
            $trainer_request->request_status = 7; //status set to Rejected
            $logres->request_status = 7;
            $logres->trainer_request = $trainer_request->id;

            $DB->update_record('trainer_requests', $trainer_request);

            $logid = trainer_request_log_add($logres, $logres->remark);
            $user = $DB->get_record("user", array("id" => $trainer_request->emp_id));
            $manager = $DB->get_record("user", array("username" => $user->supervisor_username));
            if ($user != null) {

                $viewurl = $CFG->wwwroot . "/local/resources/trainer_request_list.php";
                $notifnContent = "<p> Hi, " . $user->firstname . "
                      <br> This is to notify that your trainer request  has been Rejected for the Trainer Registration.
                      Following are the details for the Same. <br>
                      From ::" . $USER->firstname . " " . $USER->lastname . "<BR>
                      Remark :: " . $logres->remark . "<BR>
                      <a href='" . $viewurl . "'>View Trainer Request</a>
                      <br>
                          Thanks <br><br>
                          <i>SDG Learning & Development Team </i></p>";
                // echo $notifnContent;
                $subject = 'Trainer Request Rejection';
                $contexturl = null;
                $contexturlname = 'Trainer Request Rejection';
                send_mailandnotification($USER->id, $notifnContent, $user->id, $subject, $contexturl, $contexturlname);
            }
            $result['message'] = "Request has been Rejected.";
            $result['status'] = 'success';
            $result['viewurl'] = $viewurl;
            echo json_encode($result);
            break;
    
    
        case "get_resource_attachments":
            $arr = array();
            $id= $_REQUEST['id'];
            if($id !=null){
               echo get_resource_attachments($id,false);
            }
            
            break;
        case "delete_resource_attachment":
            $arr = array();
            $id= $_REQUEST['id'];
            $rid = $_REQUEST['rid'];
            if($id != null && $rid !=null){
               $arr= resource_attachment_delete($id,$rid);
               $arr['result'] = get_resource_attachments($rid);
            }
            echo $data = json_encode($arr);
            break;
    
        case "get_employee_json":
        $us=array();
          $user = getEmp();
          if($user != null){
            foreach($user as $u){
                $r=new stdClass;
                $r->value = $u->id;
                $r->text = $u->name;
                $us[]=$r;
            }
          }
          echo json_encode($us);
        break;
        }
}
function getEmp()
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
function checkSessionResourceAvailability($facetofaceid, $sessionid, $resourceid, $fromdate, $enddate, $resource_action)
{
    global $DB, $USER;
    $context = context_system::instance();
    $companyid = iomad::get_my_companyid($context);
    if ($resourceid != "" && $facetofaceid != "" && $sessionid != "") {
        $sql1 = "select * from mdl_resource_booking where resource_id=" . $resourceid . " and companyid=" . $companyid . " and facetoface_id!=" . $facetofaceid . ($sessionid != "0" ? " and session_id!=" . $sessionid : "");
        if ($resource_action != "class") {
            $sql1 .= " AND booking_status='CONFIRMED'";
        }
        $start_date = $fromdate;
        $end_date = $enddate;

        $res1 = $DB->get_records_sql($sql1);
        if ($res1 != null) {
            $partial = [];
            foreach ($res1 as $r1) {
                $dbstartdate = strtotime($r1->start_date);
                $dbenddate = strtotime($r1->end_date);
                $startdate = strtotime($start_date);
                $enddate = strtotime($end_date);

                //echo "<BR>DB Startdate :: ".date("Y-m-d H:i:s",$dbstartdate)."===".$dbstartdate;
                //echo "<BR>DB End date :: ".date("Y-m-d H:i:s",$dbenddate)."===".$dbenddate;
                //echo "<BR>start date :: ".date("Y-m-d H:i:s",$startdate)."===". $startdate;
                //echo "<BR>end date :: " .date("Y-m-d H:i:s",$enddate)."===". $enddate;

                if ($startdate <= $dbenddate && $enddate >= $dbstartdate) {
                    //echo "partial";
                    $partial[] = $r;
                } else {
                    //echo "available";
                }
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

function set_system_trainer_resource($data)
{
    global $DB, $USER;
    // print_r($data);
    if ($data->resource_mode == "INTERNAL") {
        // ".TRAINER_ROLE_ID." role assignment at course level
        $status =0;
        if($data->trainer_request_id!=null){
            $status = set_trainer_role($data->trainer_request_id);            
        }
        return $status;
    } else if ($data->resource_mode == "EXTERNAL") {
        ///Pending code...
        $userid = create_new_trainer_user($data->contact_name,$data->contact_email);
        $sql= "update mdl_resources set trainer_request_id=".$userid . " Where id=".$data->id;
        $DB->execute($sql);
        $status =0;
        if($userid!=null){
            $status = set_trainer_role($userid);            
        }
        return $status;
    }
}
function set_trainer_role($userid){
    global $DB,$USER;
    $context = context_system::instance(); // print_r($context->id); print_r($context); exit();

    $r_assign = $DB->get_record_sql('SELECT * FROM `mdl_role_assignments` 
          WHERE `contextid` = ? and userid = ? and roleid = ? ORDER BY id asc limit 0,1',
        array('contextid' => $context->id, 'userid' => $userid, 'roleid' => TRAINER_ROLE_ID)
    );
    // print_r($context); print_r($user->id);
    // print_r($r_assign); exit();

    if (empty($r_assign)) {
        $ins_rec = new stdClass();
        $ins_rec->roleid      = TRAINER_ROLE_ID;
        $ins_rec->contextid   = $context->id;
        $ins_rec->userid      = $userid;
        $ins_rec->modifierid  = $USER->id;
        $ins_rec->timecreated = date("Y-m-d H:i:s");
        $ins_rec->component   = '';
        $ins_rec->itemid      = 0;
        $ins_rec->sortorder   = 0;
        //   print_r($ins_rec); //exit();
        $DB->insert_record('role_assignments', $ins_rec);
        return 1;
    }
    return 0;
}
function create_new_trainer_user($name,$email){
    global $DB;
    $sql = "select * from {user} where username ='".$email."'";
    $rs = $DB->get_record_sql($sql);
    if($rs == null){
        $user = new stdclass;
        $user->firstname = $name;
        $user->lastname  =" ";
        $user->email = $email;
        $user->username =  $email;
        //$user->password = md5("Test@123");
        //$user->mnethostid  = 1;
        //$user->confirmed = 1;
        $user->id =  $DB->insert_record("user",$user);
        //send_confirmation_email($user);
        setnew_password_and_mail($user);
        unset_user_preference('create_password', $user);
        set_user_preference('auth_forcepasswordchange', 1, $user);
        return $user->id;
    }
    else{
        return $rs->id;
    }
}
function resource_attachment_save($dataarr,$data){
    global $DB,$USER;
       $attid= array();
       $marr =array();
    if (isset($dataarr['attachment_file']) && is_array($dataarr['attachment_file'])) {
        //save_resource_attachments($dataarr['attachment_files'])
        //get existing record 
        
        $action = $dataarr['formaction'];
        if($action == "edit"){
            $sql = "select attachment from {resources} where id ='".$data->id."'";
            $rss = $DB->get_record_sql($sql);
            if($rss !=null && $rss->attachment !=""){
                $eattid = explode(",",$rss->attachment);                            
                //check existing files
            }
            else{
                //insert new
                $eattid = [];
            }
        }
     
        foreach($dataarr['attachment_file']['name'] as $k=>$r){

            $fileTmpPath = $dataarr['attachment_file']['tmp_name'][$k];
            $fileName = $dataarr['attachment_file']['name'][$k];
            $fileSize = $dataarr['attachment_file']['size'][$k];
            $fileType = $dataarr['attachment_file']['type'][$k];
           // echo $fileName;
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));
            // directory in which the uploaded file will be moved
            $uploadFileDir = './images/attachments/resources/';
            $dest_path = $uploadFileDir . $data->id . '_' . $fileName;
            //echo $dest_path;
            $action = $dataarr['formaction'];
            if($action =="add"){                        
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $attachmessage = 'File is successfully uploaded.';
                    $ratt = new stdClass;
                    $ratt->resource_id = $data->id;
                    $ratt->attachment_filename = $fileName;
                    $ratt->attachment_type = $fileType;
                    $ratt->attachment_size = $fileSize;
                    $ratt->attachment_filepath = $dest_path;
                    $ratt->created_by =$USER->id;
                    $ratt->created_at =time();
                    $attid[]=$DB->insert_record('resource_attachment',$ratt);
                    
                } else {
                    $attachmessage = 'File Not Uploaded.';
                }
            }else if($action=="edit"){
                $sql= "select * from {resource_attachment} where resource_id='".$data->id."' and attachment_filename='".$fileName."' and attachment_type='".$fileType."' and attachment_size ='".$fileSize."'";
                $rs = $DB->get_record_sql($sql);
                if($rs != null){
                    //already exists
                    $attid[]=$rs->id;
                }
                else{
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $attachmessage = 'File is successfully uploaded.';
                        $ratt = new stdClass;
                        $ratt->resource_id = $data->id;
                        $ratt->attachment_filename = $fileName;
                        $ratt->attachment_type = $fileType;
                        $ratt->attachment_size = $fileSize;
                        $ratt->attachment_filepath = $dest_path;
                        $ratt->created_by =$USER->id;
                        $ratt->created_at =time();
                        $attid[]=$DB->insert_record('resource_attachment',$ratt);
                        
                    } else {
                        $attachmessage = 'File Not Uploaded.';
                    }   
                }

            }

        }

       
        if(count($eattid)>0 && count($attid) >0){
         /*   $diffarr = array_diff($eattid,$attid);
            if($diffarr!= null && count($diffarr)>0){
                //delete the diffarr element 
                foreach($diffarr as $d){
                    $sql = "delete from {resource_attachment} where id=".$d;
                    $DB->execute($sql);                            
                }
            }*/
            $attid = array_unique(array_merge($eattid,$attid));
        }
    }
    return $attid;
}
