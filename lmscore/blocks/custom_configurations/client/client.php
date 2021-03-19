<?php
// This client for local_custommm is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//

/**
 * XMLRPC client for Moodle 2 - local_custommm
 *
 * This script does not depend of any Moodle code,
 * and it can be called from a browser.
 *
 * @authorr Jerome Mouneyrac
 */

/// MOODLE ADMINISTRATION SETUP STEPS
// 1- Install the plugin
// 2- Enable web service advance feature (Admin > Advanced features)
// 3- Enable XMLRPC protocol (Admin > Plugins > Web services > Manage protocols)
// 4- Create a token for a specific user (Admin > Plugins > Web services > Manage tokens)
// 5- Run this script directly from your browser

/// SETUP - NEED TO BE CHANGED
$token = '8084a3fa8ae29abded4ca7ab0aadb7e0';
$domainname = 'http://localhost/newlms';

/// FUNCTION NAME
$functionname = 'block_progress_get_myprogress';
$restformat = 'json';

/// PARAMETERS
$params = array('userid' => 2); //, 'component' => 'mod_assign', 'cmid' => 2, 'userids' => array(3));

/// REST CALL

$serverurl = $domainname . '/webservice/rest/server.php' . '?wstoken=' . $token . '&wsfunction=' . $functionname;
require_once('./curl.php');
$curl = new curl;
//if rest format == 'xml', then we do not add the param for backward compatibility with Moodle < 2.2
$restformat = ($restformat == 'json') ? '&moodlewsrestformat=' . $restformat : '';
$resp = $curl->post($serverurl . $restformat, $params); //array('grades' => $params));
print_r($resp);
