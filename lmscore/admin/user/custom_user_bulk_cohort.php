<?php

/* 
* @author : Suniti Yadav 
* description : Taken inspiration from user bulk screen and modified below code as per our requirement for dynamic cohorts.
*/
require_once('../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once($CFG->dirroot.'/'.$CFG->admin.'/user/cust_lib.php');
require_once($CFG->dirroot.'/'.$CFG->admin.'/user/cust_user_bulk_forms.php');
$message  = optional_param('m', 'n', PARAM_ALPHA); // SY

admin_externalpage_setup('userbulk');

//SY
$SESSION->dc = 1;
if($message == 'o' || $message == 'd')
{
    unset($SESSION->bulk_users);
    unset($SESSION->user_filtering);
}

if (!isset($SESSION->bulk_users)) {
    $SESSION->bulk_users = array();
}
// create the user filter form
$ufiltering = new user_filtering();

// array of bulk operations
// create the bulk operations form
$action_form = new user_bulk_action_form();
if ($data = $action_form->get_data()) {
    // check if an action should be performed and do so
    switch ($data->action) {
        // case 1: redirect($CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk_confirm.php');
        // case 2: redirect($CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk_message.php');
        // case 3: redirect($CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk_delete.php');
        // case 4: redirect($CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk_display.php');
        // case 5: redirect($CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk_download.php');
        // case 7: redirect($CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk_forcepasswordchange.php');
        case 8: redirect($CFG->wwwroot.'/'.$CFG->admin.'/user/user_bulk_cohortadd.php?dc=1');
    }
}

$user_bulk_form = new user_bulk_form(null, get_selection_data($ufiltering));
// echo "here";
// print_r($user_bulk_form); exit();

if ($data = $user_bulk_form->get_data()) {
    if (!empty($data->addall)) {
        add_selection_all($ufiltering);

    } else if (!empty($data->addsel)) {
        if (!empty($data->ausers)) {
            if (in_array(0, $data->ausers)) {
                add_selection_all($ufiltering);
            } else {
                foreach($data->ausers as $userid) {
                    if ($userid == -1) {
                        continue;
                    }
                    if (!isset($SESSION->bulk_users[$userid])) {
                        $SESSION->bulk_users[$userid] = $userid;
                    }
                }
            }
        }

    } else if (!empty($data->removeall)) {
        $SESSION->bulk_users= array();

    } else if (!empty($data->removesel)) {
        if (!empty($data->susers)) {
            if (in_array(0, $data->susers)) {
                $SESSION->bulk_users= array();
            } else {
                foreach($data->susers as $userid) {
                    if ($userid == -1) {
                        continue;
                    }
                    unset($SESSION->bulk_users[$userid]);
                }
            }
        }
    }

    // reset the form selections
    unset($_POST);
    $user_bulk_form = new user_bulk_form(null, get_selection_data($ufiltering));
}
// do output
echo $OUTPUT->header();
?>

<div>
    <b> 
        <?php 
        if($message == 'd')
        {
            unset($SESSION->bulk_users);
            unset($SESSION->user_filtering);
        ?>
            <div class="alert alert-success alert-block fade in " role="alert" data-aria-autofocus="true">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Users are added in cohort successfully !!!
            </div>
        <?php
        }
        else if($message == 'ca')
        {
        ?>
            <div class="alert alert-success alert-block fade in " role="alert" data-aria-autofocus="true">
                <button type="button" class="close" data-dismiss="alert">×</button>
                Cohort created successfully !!!
            </div>
        <?php
        }
        ?>
        <a href="<?php echo $CFG->wwwroot.'/cohort/edit.php?contextid=1&dc=1'; ?>"> Add Cohort </a> - Before further process
        
    </b>
</div>
<br>

<?php

$ufiltering->display_add();
$ufiltering->display_active();
//echo"<pre>"; print_r($ufiltering);// exit();
//echo"<pre>"; print_r($SESSION->user_filtering); //exit();

$user_bulk_form->display();

$action_form->display();

echo $OUTPUT->footer();
?>