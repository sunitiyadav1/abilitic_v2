<?php  // Moodle configuration file

function db_connection($dbname,$wwroot,$dataroot)
{
	echo "m here <br>"; 
	echo "dbname - ".$dbname." root - ".$wwroot." data - ".$dataroot;
	//exit();


	unset($CFG);
	global $CFG;
	$CFG = new stdClass();

	$CFG->dbtype    = 'mysqli';
	$CFG->dblibrary = 'native';
	$CFG->dbhost    = 'localhost';
	$CFG->dbname    = $dbname;
	$CFG->dbuser    = 'root';
	$CFG->dbpass    = 'Power@004';
	$CFG->prefix    = 'mdl_';
	$CFG->dboptions = array (
	  'dbpersist' => 0,
	  'dbport' => '',
	  'dbsocket' => '',
	  'dbcollation' => 'utf8_unicode_ci',
	);

	$CFG->wwwroot   = $wwroot; //'https://learn.zinghr.com/bma';
	$CFG->dataroot  = $dataroot; //'/var/www/moodleapidata';
	$CFG->admin     = 'admin';

	$CFG->directorypermissions = 0777;

	echo "just before";
	require_once(__DIR__ . '/lib/setup.php');

	return true;
}
