<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = '172.16.15.5';
$CFG->dbname    = 'abilitic_v2';
$CFG->dbuser    = 'zingHr';
$CFG->dbpass    = 'Power@004';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '',
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_unicode_ci',
);

$CFG->wwwroot   = 'https://learnuat.zinghr.com/abilitic_v2/lmscore';
$CFG->dataroot  = '/var/www/moodledata_abilitic_v2';
$CFG->app_name  = 'Abilitic V2';
$CFG->admin     = 'admin';
$CFG->md_api_key= 'sdF1PWorhLa4YYsNr8_wcQ';
$CFG->sslproxy  = true;
$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
