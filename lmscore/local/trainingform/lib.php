<?php 
//require_once '../../config.php';
global $DB;

function getExistingfileList($tformid){
    global $DB;
    $tablestr ='Existing :';
    $sql = "select * from {trainingform_files} where trainingformid =" . $tformid ." and deleted = 0";    
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
                    $tablestr.= "<div class='row' style='margin-left:15px;'>
                            <div class ='col-md-6'>
                                <p><B>File Name:</B>" . $f->file_name . "</p>";
					$tablestr.= "<img src='" . $f->file_path . "' width=100 height=100>
					<input type='hidden' name='edocfile[]' id='edocfile[]' value='".$f->id."'>
                        </div>
						<div class ='col-md-2'><a href='downloadfile.php?id=".$f->id."'>Download</a></div>
						<div class ='col-md-2'><a id='adeletefile' href='#' data-url='ajax.php' data-id='".$f->id."' data-ids='".$f->trainingformid."'>Delete</a></div>                        
                     </div> <HR>";
                    break;
                // case "application/pdf":
                // case "application/msword":
                // case "application/vnd.ms-excel":
                // case "text/csv":
                // case "text/html":
                // case "text/plain":
                // case "text/xml":
                default:
                    $tablestr.= "<div class='row' style='margin-left:15px;>
                            <div class ='col-md-6'>
							<p><B>File Name:</B>" . $f->file_name . "</p>
							<input type='hidden' name='edocfile[]' id='edocfile[]' value='".$f->id."'>
                            </div>
							<div class ='col-md-2'><a href='downloadfile.php?id=".$f->id."'>Download</a></div>                             
							<div class ='col-md-2'><a id='adeletefile' href='#' data-url='ajax.php' data-id='".$f->id."' data-ids='".$f->trainingformid."'>Delete</a></div>                        
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


function getTrainingFormList()
{
    global $DB,$CFG;
    $html = "";
    $sql = "select * from {trainingform} where deleted=0 orderby id desc";
    $res = $DB->get_records("trainingform",array("deleted"=>0));

    $table = new html_table();
    $table->head = array(
        'ID',
        'Form Type',
        'No of Users',
        'Start Date',
        'End Date',
        'Certification Program',
        "Submitted On",
        'Action'
    );
    $table->id = "tbltraining";
    //$table->align = array('left', 'right', 'right');
    $table->width = '100%';
    $table->data = array();

    if ($res != null) {
        foreach ($res as $r) {
            if ($r->userid != null) {
                $arr = explode(",", $r->userid);
                $usercount = count($arr);
            } else {
                $usercount = 0;
            }
            $table->data[] = array(
                $r->id,
                $r->formtype,
                $usercount,
                userdate($r->start_date),
                userdate($r->end_date),
                ($r->is_certification_program ==  '0' ? "Yes [<a data-id='" . $r->id . "' data-url='ajax.php' data-ids='" . $r->certificate_file . "' href='#' id='viewcert'>View Documents</a>]" : "No"),
                date("d-m-Y H:i:s", $r->created_at),
                "<a data-id='" . $r->id . "' data-url='ajax.php' href='#' id='viewdetail'>View Details</a> |
                <a href='index.php?action=edit&t=".$r->id."' >Edit</a> |
                <a data-id='" . $r->id . "' data-url='ajax.php' href='#' id='deletedetail'>Delete</a>" 
            );
        }
    } else {
    }
    $html .= html_writer::table($table);
    $html .= '<link href="' . $CFG->wwwroot . '/local/trainingform/scripts/jquery-datatable/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="' . $CFG->wwwroot . '/local/trainingform/scripts/jquery-datatable/jquery.dataTables.min.js"></script>';
    return $html;
}
