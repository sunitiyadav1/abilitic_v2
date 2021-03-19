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

require_once '../../config.php';
global $CFG,$DB;
$pluginname = 'mod_zingilt';
// Get the SYSTEM context.
$context = context_system::instance();
require_login(null, false); // Adds to $PAGE, creates $OUTPUT.
// Correct the navbar.
// Set the name for the page.
$linktext = get_string('myresources', $pluginname);
// Set the url.
$linkurl = new moodle_url('/mod/zingilt/resourcemgmt/index.php');

// Print the page header.
$PAGE->set_context($context);
$PAGE->set_url($linkurl);
$PAGE->set_pagelayout('admin');
$PAGE->set_title($linktext);
// Set the page heading.
$PAGE->set_heading(get_string('myhome') . " - $linktext");
//$PAGE->navbar->add(get_string('dashboard', 'local_resources'));
$PAGE->navbar->add($linktext, $linkurl);
echo $OUTPUT->header();
$url = $CFG->wwwroot;

//$PAGE->requires->js("/mod/zingilt/resourcemgmt/scripts/jquery-modal/jquery.min.js",true);
//$PAGE->requires->css("/mod/zingilt/resourcemgmt/scripts/jquery-bootstrap/bootstrap.min.css");
//$PAGE->requires->js("/mod/zingilt/resourcemgmt/scripts/jquery.min.js");
//$PAGE->requires->js("/mod/zingilt/resourcemgmt/scripts/jquery-bootstrap/bootstrap.min.js");
//$PAGE->requires->js("/mod/zingilt/resourcemgmt/scripts/jquery-modal/jquery.min.js",true);
//$PAGE->requires->js("/mod/zingilt/resourcemgmt/scripts/jquery-modal/jquery-ui.js");
///$PAGE->requires->css("/mod/zingilt/resourcemgmt/scripts/jquery-modal/jquery-ui.css");
//$PAGE->requires->js("/mod/zingilt/resourcemgmt/scripts/jquery-validate/jquery.validate.js");
//echo '<script src = "'.$CFG->wwwroot.'/mod/zingilt/resourcemgmt/scripts/jquery.min.js"></script>';
//echo '<link rel="stylesheet" href="'.$CFG->wwwroot.'/mod/zingilt/resourcemgmt/scripts/jquery-bootstrap/bootstrap.min.css">';

      //echo '<script src = "'.$CFG->wwwroot.'/mod/zingilt/resourcemgmt/scripts/jquery-bootstrap/bootstrap.min.js"></script>';
//echo '<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="crossorigin="anonymous"></script>';
//echo '<script src = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>';
//echo '<script src = "'.$CFG->wwwroot.'/mod/zingilt/resourcemgmt/scripts/jquery-modal/jquery-ui.js"></script>';
//echo '<link rel="stylesheet" href="'.$CFG->wwwroot.'/mod/zingilt/resourcemgmt/scripts/jquery-modal/jquery-ui.css">';
// $PAGE->requires->js("/local/resources/scripts/jquery-modal/jquery.min.js",true);
// $PAGE->requires->js("/local/resources/scripts/jquery-modal/jquery-ui.js",true);
// $PAGE->requires->css("/local/resources/scripts/jquery-modal/jquery-ui.css");

echo '<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">';
?>
