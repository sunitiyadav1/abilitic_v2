<?php
require_once dirname(__FILE__) . '/../../../config.php';
global $DB, $CFG, $USER;
$id = $_REQUEST['id'];
            $rs = $DB->get_record("resource_attachment",array("id"=>$id));
            if($rs !=null){
                $file = $rs->attachment_filepath;
                $filename = $rs->attachment_filename;
               // $file = str_replace("./","/local/trainingform/",$file);
               // echo (string)new moodle_url($file);
                //die($file);
                //if($file != null && $file !="")
                if (file_exists($file)) {
                    header('Content-Description: File Transfer');
                    header('Content-Type: application/octet-stream');
                    header('Content-Disposition: attachment; filename="'.basename($file).'"' );
                    header('Expires: 0');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Content-Length: ' . filesize($file));
                    ob_clean();
                    flush();
                    header("Content-Disposition: attachment; filename=\"". basename($file) ."\""); 
                    readfile ($file);
                }
            }
            exit(); 
?>