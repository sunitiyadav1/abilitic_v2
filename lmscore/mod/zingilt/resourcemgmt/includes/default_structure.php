<?php 
    require_once('../../../config.php');    
    global $CFG,$PAGE;
    require_once($CFG->libdir . '/pagelib.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="no-cache">
    <meta http-equiv="Expires" content="-1">
    <meta http-equiv="Cache-Control" content="no-cache">
    <?php /*
    echo '<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">';    
        //echo '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';
        echo '<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>';
        echo '<script language="javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>';
        echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
        echo '<script src = "'.$CFG->wwwroot.'/mod/zingilt/resourcemgmt/scripts/jquery-validate/jquery.validate.js"></script>';        */
    ?>
<link rel="stylesheet" href= "<?php echo $CFG->wwwroot?>/mod/zingilt/resourcemgmt/scripts/jquery-datatable/jquery.dataTables.min.css">
<link rel="stylesheet" href= "<?php echo $CFG->wwwroot?>/mod/zingilt/resourcemgmt/scripts/css/custom.css">

<!-- <link rel="stylesheet" type="text/css" href="http://localhost/lmsmobile/mod/zingilt/resourcemgmt/scripts/evo-calendar/css/evo-calendar.css"/>
<link rel="stylesheet" type="text/css" href="http://localhost/lmsmobile/mod/zingilt/resourcemgmt/scripts/evo-calendar/css/evo-calendar.midnight-blue.css"/>   -->

<script src = "<?php echo $CFG->wwwroot?>/mod/zingilt/resourcemgmt/scripts/jquery.min.js"></script>
<script src = "<?php echo $CFG->wwwroot?>/mod/zingilt/resourcemgmt/scripts/jquery-datatable/jquery.dataTables.min.js"></script>
<script src = "<?php echo $CFG->wwwroot?>/mod/zingilt/resourcemgmt/scripts/jquery-bootstrap/bootstrap.min.js"></script>
<script src = "<?php echo $CFG->wwwroot?>/mod/zingilt/resourcemgmt/scripts/jquery-validate/jquery.validate.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/select2/chosen.jquery.css">
     <script src="<?php echo $CFG->wwwroot; ?>/mod/zingilt/resourcemgmt/scripts/select2/chosen.jquery.js"></script>
<!-- <script src="http://localhost/lmsmobile/mod/zingilt/resourcemgmt/scripts/evo-calendar/js/evo-calendar.js"></script> -->
<?php 
/*$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/jquery.min.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/jquery-datatable/jquery.dataTables.min.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/jquery-bootstrap/bootstrap.min.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot . '/mod/zingilt/resourcemgmt/scripts/jquery-validate/jquery.validate.js'));
*/
?>
</head>


