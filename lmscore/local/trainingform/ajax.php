<?php
require_once dirname(__FILE__) . '/../../config.php';
require_once("lib.php");
global $DB, $CFG, $USER;
$CFG->debug 		= (E_ALL | E_STRICT); 
 $CFG->debugdisplay  = 1;
 $CFG->debugdeveloper= 1;
//print_r($_REQUEST);
if (isset($_REQUEST['action']) && $_REQUEST['action'] != "") {
    switch ($_REQUEST['action']) {
        case "get_trainingform":
           /* $sql = "select  @a:=@a+1 as 'srno' ,t.id,t.formtype,count(distinct(tuf.userid)) as usercount,t.start_date,t.end_date,t.is_certification_program,t.created_at,t.* 
                from {trainingform} as t 
                join {trainingform_user_files} as tuf on ( t.id= tuf.trainingformid and tuf.deleted =0),
                (SELECT @a:= 0) AS a
                where t.deleted=0 
                group by t.id                
                ";
                */
            $sql = "select  @a:=@a+1 as 'srno' ,t.*,
(select count(DISTINCT(userid)) from mdl_trainingform_user_files as tuf where tuf.trainingformid = t.id and deleted=0) as usercount
from mdl_trainingform as t join (SELECT @a:= 0) a where t.deleted=0";
            $res = $DB->get_records_sql($sql);
            if($res != null){
                foreach($res as $r){
                    if($r->is_certification_program == 0){
                        $r->document_submitted = "Yes [<a data-id='" . $r->id . "' data-url='ajax.php' data-ids='" . $r->certificate_file . "' href='#' id='viewcert'>View Documents</a>]";
                    }
                    else{
                        $r->document_submitted = "No";
                    }
                    $r->start_date = date('d-m-Y',$r->start_date);
                    $r->end_date = date('d-m-Y',$r->end_date);
                    $r->created_at = date('d-m-Y H:i:s',$r->created_at);

                    $r->action = "<a data-id='" . $r->id . "' data-url='ajax.php' href='#' id='viewdetail'>View Details</a> |
                    <a href='index.php?action=edit&t=".$r->id."' >Edit</a> |
                    <a data-id='" . $r->id . "' data-url='ajax.php' href='#' id='deletedetail'>Delete</a>";
                }
            }
            $arr['draw'] = 1;
            $arr['recordsTotal'] = count($res);
            $arr['recordsFiltered'] = count($res);
            $arr['data'] = array_values($res);
            echo json_encode($arr);
            break;
        case "view_details":
            // print_r($_REQUEST);
            if (isset($_REQUEST['id']) && $_REQUEST['id'] != null) {
                $sql = 'SELECT t.id,GROUP_CONCAT(DISTINCT(concat(u.firstname," ",u.lastname))) as name,t.*,GROUP_CONCAT(distinct(f.file_name)) as filelist 
                    FROM mdl_trainingform as t 
                    join mdl_trainingform_files as f on t.id=f.trainingformid 
                    join mdl_trainingform_user_files as tu on (t.id= tu.trainingformid and f.id = tu.fileid) 
                    join mdl_user as u on tu.userid =u.id 
                    where t.id ='.$_REQUEST['id'].' and t.deleted =0
                    group by t.id
                    ORDER BY `u`.`id` ASC';
               // echo $sql;
                $rs = $DB->get_record_sql($sql);
                // echo "<pre>";
                // print_r($rs);
                // die;
                // $rs = $DB->get_record("trainingform", array('id' => $_REQUEST['id']));
                //  print_r($rs);
                if ($rs != null) {
                    echo '
               
                
                     
                    <div id="external_div" >
                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>Employee Name )</b>
                                <div>' . getUserList($rs->userid) . '</div>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>Training Program Name</b>
                                <!-- Training Program Name  -->
                                <div>' . $rs->training_program_name . '</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>Training Duration (in Mins) </b>
                                <!-- Training Duration  -->
                                <div>' . $rs->training_duration . ' Mins = ' . round(intval($rs->training_duration) / 60, 2) . ' Hr </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>Training Provider Name </b>
                                <!-- Training Provider Name  -->
                                <div>' . $rs->training_provider_name . '</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>Is Documents Submitted? </b>
                                <!-- Is it a Certification Program?  -->
                                <div>' . ($rs->is_certification_program == '1' ? "No" : "Yes") . '</div>
                            </div>
                        </div>
                        <div class="row" id="certificate_div">
                            <div class="form-group col-md-12">
                                <b>View Documents </b>
                                <!-- Upload Documents (Non-anonymous question)  -->
                               <div style="margin-left:20px;padding-left:30px;">';
                               echo getfileList($rs->id);
                    /*if ($rs->certificate_file != "") {
                        echo '<img src="' . $rs->certificate_file . '" width=200 height=200>';
                    } else {
                        echo "<pre>No Image Found.</pre>";
                    }*/

                    echo '</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <b>Training Start Date </b>
                                <!-- start Date  -->
                                <div>' . userdate($rs->start_date) . '</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <B>Training End Date </B>
                                <!-- start Date  -->
                                <div>' . userdate($rs->end_date) . '</div>
                            </div>
                        </div>
                    </div>
                ';
                }
            }
            break;
        case "view_files":
            $fileids = $_REQUEST['ids'];
            $trainingformid = $_REQUEST['trainingformid'];
            if ($fileids != null && $trainingformid != null) {
                $filearr = explode(",", $fileids);
                //  foreach($filearr as $fa){
                    echo getfileList($trainingformid);
                /*$sql = "select * from {trainingform_files} where id in(" . $fileids . ") and trainingformid =" . $trainingformid;
                // echo $sql;
                $frs = $DB->get_records_sql($sql);
                //echo "<pre>";
                //   echo "<div class='row'>
                //             <div class ='col-md-8'>asdfdfsdfdsfdsfsdf</div>
                //             <div class ='col-md-2'>sdfereasfesecond col</div>
                //             <HR>
                //         </div>";die;
                if ($frs != null) {
                    // echo "<table width='100%' border ='1'>
                    //         <tr>
                    //             <th>File List</th>
                    //             <th>Action</th>
                    //         </tr>";
                    foreach ($frs as $f) {
                        switch ($f->file_type) {
                            case "image/png":
                            case "image/jpg":
                            case "image/jpeg":
                            case "image/gif":
                                echo "<div class='row'>
                                        <div class ='col-md-8'>
                                            <p><B>File Name:</B>" . $f->file_name . "</p>";
                                echo "<img src='" . $f->file_path . "' width=100 height=100>
                                    </div>
                                    <div class ='col-md-2'>Delete File</div>
                                    
                                 </div> <HR>";
                                break;
                            case "application/pdf":
                            case "application/msword":
                            case "application/vnd.ms-excel":
                            case "text/csv":
                            case "text/html":
                            case "text/plain":
                            case "text/xml":
                                echo "<div class='row'>
                                        <div class ='col-md-8'>
                                        <p><B>File Name:</B>" . $f->file_name . "</p>
                                        </div>
                                        <div class ='col-md-2'>Delete File</div>
                                         
                                     </div><HR>";
                                //echo "<BR><iframe width=400 height=300 src ='".$f->file_path."'></iframe><HR>";
                                break;
                        }
                        //print_r($f);
                    }
                    echo "</table>  ";
                }*/
            } else {
                echo "No Files Found";
            }
            break;
   
        case "deletefile":
            $id= $_REQUEST['id'];
            $tid = $_REQUEST['tid'];
            $status =0;
            $message ='';
            $result ='';
            if($id != null && $tid !=null){
                $sql ="update {trainingform_files} set deleted = 1,updated_by='".$USER->id."',updated_at=".time()."
                where id = ".$id." and trainingformid=".$tid;
               // echo $sql;
              if($DB->execute($sql)){
                  $status =1;
                  $message = "File Deleted Successfully";
                  $result = getExistingfileList($tid);
              }   
              else{
                  $message ="File Not Deleted";
                  $status=1;
                  $result = getExistingfileList($tid);
              }         
            }
            else{
                
            }
            $result = getExistingfileList($tid);
            echo $data=json_encode(['status'=>$status,"message"=>$message,"result"=>$result]);
        break;
        case "delete_details":
                $id = $_REQUEST['id'];
           
                $status =0;
                $message ='';
                $result ='';
                if($id != null ){
                    $sql1 ="update {trainingform_files} set deleted = 1,updated_by='".$USER->id."',updated_at=".time()."
                    where trainingformid = ".$id;
                    $sql2 ="update {trainingform_user_files} set deleted = 1,updated_by='".$USER->id."',updated_at=".time()."
                    where trainingformid = ".$id;
                    $sql3 ="update {trainingform} set deleted = 1,updated_by='".$USER->id."',updated_at=".time()."
                    where id = ".$id;
                    // echo "<BR>".$sql1;
                    // echo "<BR>".$sql2;
                    // echo "<BR>".$sql3;
                     $DB->execute($sql1);
                     $DB->execute($sql2);
                    $DB->execute($sql3);
                   // echo $sql;
                //  if($r3){
                      $status =1;
                      $message = "TrainingForm Deleted Successfully";
                     
                  //}   
                  
                }
                else{
                    
                }
                 $result = getTrainingFormList();
                echo $data=json_encode(['status'=>$status,"message"=>$message,"result"=>$result]);
        break;
        }
}
function getUserList($userstr)
{
    global $DB;
    $str = '';
    if ($userstr != null) {
        $arr = explode(",", $userstr);
        $sql = "select firstname,lastname,username from {user} where id in(" . $userstr . ")";
        $rs = $DB->get_records_sql($sql);
        if ($rs != null) {
            $str .= '<ul>';
            foreach ($rs as $r) {
                $str .= '<li>' . $r->firstname . ' ' . $r->lastname . ' [ ' . $r->username . ' ]</li>';
            }
            $str .= '</ul>';
        }
    }
    return $str;
}

function getcourses($coursestr)
{
    global $DB;
    $str = '';
    if ($coursestr != null) {
        $arr = explode(",", $coursestr);
        $sql = "select fullname from {course} where id in(" . $coursestr . ")";
        $rs = $DB->get_records_sql($sql);
        if ($rs != null) {
            $str .= '<ul>';
            foreach ($rs as $r) {
                $str .= '<li>' . $r->fullname . '</li>';
            }
            $str .= '</ul>';
        }
    }
    return $str;
}
function getfileList($tformid){
    global $DB;
    $tablestr ='';
    $sql = "select * from {trainingform_files} where trainingformid =" . $tformid." and deleted =0";    
    $frs = $DB->get_records_sql($sql);
    if ($frs != null) {
        // echo "<table width='100%' border ='1'>
        //         <tr>
        //             <th>File List</th>
        //             <th>Action</th>
        //         </tr>";
        foreach ($frs as $f) {
            switch ($f->file_type) {
                case "image/png":
                case "image/jpg":
                case "image/jpeg":
                case "image/gif":
                    $tablestr.= "<div class='row'>
                            <div class ='col-md-8'>
                                <p><B>File Name:</B>" . $f->file_name . "</p>";
                    $tablestr.= "<img src='" . $f->file_path . "' width=100 height=100>
                        </div>
                        <div class ='col-md-2'><a href='downloadfile.php?id=".$f->id."'>Download</a></div>
                        
                     </div> <HR>";
                    break;
                case "application/pdf":
                case "application/msword":
                case "application/vnd.ms-excel":
                case "text/csv":
                case "text/html":
                case "text/plain":
                case "text/xml":
                    $tablestr.= "<div class='row'>
                            <div class ='col-md-8'>
                            <p><B>File Name:</B>" . $f->file_name . "</p>
                            </div>
                            <div class ='col-md-2'><a href='downloadfile.php?id=".$f->id."'>Download</a></div>                             
                         </div><HR>";
                    //echo "<BR><iframe width=400 height=300 src ='".$f->file_path."'></iframe><HR>";
                    break;
            }
            //print_r($f);
        }
        //echo "</table>  ";
        return $tablestr;
    }
}