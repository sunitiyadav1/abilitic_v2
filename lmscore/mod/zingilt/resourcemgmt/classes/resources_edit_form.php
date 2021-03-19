<?php 
//namespace mod_zingilt;


defined('MOODLE_INTERNAL') || die();
//require_once dirname(__FILE__) . '/../../config.php';
require_once $CFG->libdir . '/formslib.php';
require_once 'lib.php';

class resources_edit_form extends moodleform
{
    protected $isadding;
    protected $resourceid;
    public function __construct($actionurl, $isadding, $resourceid)
    {
        $this->isadding = $isadding;
        $this->resourceid = $resourceid;
       // $this->companyid = $companyid;
        parent::__construct($actionurl);
    }
    public function set_data($data)
    {
        $ar1 = array();
        $ar1['text'] = $data->resource_desc;
        $ar1['format'] = 1;
        $data->resource_desc = $ar1;

        $data->startdate = strtotime($data->startdate);
        $data->enddate = strtotime($data->enddate);
        // print_r($data);die;
        $data->rs_subtype_id = $data->resource_subtype_id;
        parent::set_data($data);
    }
    public function definition()
    {
        global $CFG, $PAGE, $DB;
         
        $context = context_system::instance();
        //$PAGE->requires->jquery();
       
       // $PAGE->requires->js("/mod/zingilt/resourcemgmt/amd/src/resourceaddedit.js");
        $mform = &$this->_form;

        $strrequired = get_string('required');

        $mform->addElement('hidden', 'id', $this->resourceid);
      //  $mform->addElement('hidden', 'companyid', $this->companyid);
        $mform->setType('id', PARAM_INT);
        //$mform->setType('companyid', PARAM_INT);

        // Then show the fields about where this block appears.
        $mform->addElement('header', 'header', get_string('general', 'mod_zingilt'));
        $resource_type = getResourceType();
        $mform->addElement('select', 'resource_type_id', get_string('resource_type', 'mod_zingilt'), $resource_type);
        $mform->addRule('resource_type_id', $strrequired, 'required', null, 'client');

        

        //$resource_subtype = getResourceSubType();
        $mform->addElement('hidden', 'rs_subtype_id', get_string('resource_subtype', 'mod_zingilt'), '');
        $mform->setType('rs_subtype_id',PARAM_RAW);
        $resource_subtype[''] = "Select";
        $mform->addElement('select', 'resource_subtype_id', get_string('resource_subtype', 'mod_zingilt'), $resource_subtype);
        $mform->addRule('resource_subtype_id', $strrequired, 'required', null, 'client');
        //$mform->setDefault('resource_subtype_id', $courseconfig->visible);

        $mform->addElement('text', 'en_resource_name', get_string('en_resource_name', 'mod_zingilt'), 'maxlength="100" size="50"');
        $mform->addRule('en_resource_name', $strrequired, 'required', null, 'client');
        $mform->setType('en_resource_name', PARAM_NOTAGS);
        
        //$mform->addElement('text', 'ar_resource_name', get_string('ar_resource_name', 'mod_zingilt'), 'maxlength="100" size="50"');
        //$mform->addRule('ar_resource_name', $strrequired, 'required', null, 'client');
        //$mform->setType('ar_resource_name', PARAM_NOTAGS);

        $editoroptions = array(
                     'subdirs' => 0,
                     'maxbytes' => 0,           
                     'trusttext' => false
                     );
        $mform->addElement('editor', 'en_resource_desc', get_string('en_resourcedesc', 'mod_zingilt'), null, $editoroptions);
       // $mform->addHelpButton('en_resource_desc', get_string('resourcedesc','mod_zingilt'));
        $mform->setType('en_resource_desc', PARAM_RAW);
        $summaryfields = 'en_resource_desc';

       // $mform->addElement('editor', 'ar_resource_desc', get_string('ar_resourcedesc', 'mod_zingilt'), null, $editoroptions);
        //$mform->addHelpButton('ar_resource_desc', get_string('resourcedesc','mod_zingilt'));
        //$mform->setType('ar_resource_desc', PARAM_RAW);
        //$summaryfields = 'ar_resource_desc';


        $mform->addElement('text', 'max_no_attendees', get_string('max_no_attendees', 'mod_zingilt'));
       //// $mform->addRule('max_no_attendees', $strrequired, 'required', null, 'client');
        $mform->addRule('max_no_attendees', "Number Required", 'numeric', null, 'client');
        $mform->setType('max_no_attendees', PARAM_INTEGER);
        $mform->setDefault("max_no_attendees",0);

        $resource_mode[] = "select";
        $resource_mode['EXTERNAL'] = "EXTERNAL";
        $resource_mode['INTERNAL'] = "INTERNAL";
        $mform->addElement('select', 'resource_mode', get_string('resource_mode', 'mod_zingilt'), $resource_mode);
          $mform->addRule('resource_mode', $strrequired, 'required', null, 'client');
        //$mform->setDefault('resource_subtype_id', $courseconfig->visible);

        $mform->addElement('header', 'headertrainingcenter', get_string('training_center', 'mod_zingilt'));
        $tprovider = getTrainingProvider();

        $mform->addElement('select', 'training_provider', get_string('training_provider', 'mod_zingilt'), $tprovider);

        $tcenter = getTrainingCenter();
        $mform->addElement('select', 'training_center', get_string('training_center', 'mod_zingilt'), $tcenter);
        
        $mform->addElement('text', 'location', get_string('location', 'mod_zingilt'), 'maxlength="120" size="50"');
        ////  $mform->addRule('location', $strrequired, 'required', null, 'client');
        $mform->setType('location', PARAM_NOTAGS);

        $mform->addElement('textarea', 'address', get_string('address', 'mod_zingilt'), '');
        ////$mform->addRule('address', $strrequired, 'required', null, 'client');
        $mform->setType('address', PARAM_NOTAGS);

        $mform->addElement('text', 'google_map_lat', get_string('google_map_lat', 'mod_zingilt'), 'maxlength="120" size="50"');
        $mform->setType('google_map_lat',PARAM_INTEGER);
        $mform->addRule('google_map_lat', "number required", 'numeric', null, 'client');

        $mform->addElement('text', 'google_map_long', get_string('google_map_long', 'mod_zingilt'), 'maxlength="120" size="50"');
        $mform->setType('google_map_long',PARAM_INTEGER);
        $mform->addRule('google_map_long', "number required", 'numeric', null, 'client');
        ////$mform->addRule('google_map', $strrequired, 'required', null, 'client');
        //$mform->setType('google_map', PARAM_NOTAGS);

        $mform->addElement('html', '<button type="button" id="btnid" disabled="disabled">Show on Map</button><div id="map" style="width: 900px; height: 500px; display:none;"></div><BR>');

        $rs = getSeatingOrientation();
        $mform->addElement('select', 'default_seating_arrangement', get_string('default_seating_arrangement', 'mod_zingilt'), $rs);
        ////$mform->addRule('google_map', $strrequired, 'required', null, 'client');
        //  $mform->setType('google_map', PARAM_NOTAGS);

      

        ////$mform->addRule('google_map', $strrequired, 'required', null, 'client');
        //  $mform->setType('google_map', PARAM_NOTAGS);

        $mform->addElement('text', 'reference', get_string('reference', 'mod_zingilt'), '');
        ////$mform->addRule('google_map', $strrequired, 'required', null, 'client');
          $mform->setType('reference', PARAM_RAW);

        $mform->addElement('header', 'headerbookinginst', get_string('booking_instruction', 'mod_zingilt'));
        $mform->addElement('date_time_selector', 'startdate', get_string('startdate', 'mod_zingilt'));
        $mform->addHelpButton('startdate', 'startdate');
      //  $date = (new DateTime())->setTimestamp(usergetmidnight(time()));
        $date = time();

        // $date->modify('+1 day');
        $mform->setDefault('startdate', $date);

        $mform->addElement('date_time_selector', 'enddate', get_string('enddate', 'mod_zingilt'));
        $mform->addHelpButton('enddate', 'enddate');

        $mform->addElement('text', 'default_price', get_string('default_price', 'mod_zingilt'), '');
        ////$mform->addRule('google_map', $strrequired, 'required', null, 'client');
        $mform->setType('default_price', PARAM_INTEGER);

        $price_unit = getPriceUnit();
        $mform->addElement('select', 'default_price_unit', get_string('default_price_unit', 'mod_zingilt'), $price_unit);
        ////$mform->addRule('google_map', $strrequired, 'required', null, 'client');
        $mform->setType('default_price_unit', PARAM_ALPHA);

        $mform->addElement('textarea', 'booking_instruction', get_string('booking_instruction', 'mod_zingilt'), '');
        ////$mform->addRule('instruction', $strrequired, 'required', null, 'client');
        $mform->setType('instruction', PARAM_NOTAGS);

        $mform->addElement('checkbox', 'overbooking_flag', get_string('overbooking_flag', 'mod_zingilt'), '');
        ////  $mform->addRule('overbooking_flag', $strrequired, 'required', null, 'client');
        //$mform->setType('overbooking_flag', PARAM_NOTAGS);

        $mform->addElement('header', 'headercontactdetails', get_string('contact_details', 'mod_zingilt'));
        $mform->addElement('text', 'contact_name', get_string('contact_name', 'mod_zingilt'), 'maxlength="100" size="50"');
        $mform->setType('contact_name', PARAM_NOTAGS);
        ////$mform->addRule('contact_name', $strrequired, 'required', null, 'client');

        $mform->addElement('text', 'contact_email', get_string('contact_email', 'mod_zingilt'));
        //$mform->addRule('name', "Email Required", 'email', null, 'client');
        $mform->setType('contact_email',PARAM_RAW);

        $mform->addElement('text', 'contact_phone_mobile', get_string('contact_phone_mobile', 'mod_zingilt'), 'maxlength="100" size="50"');
        $mform->setType('contact_phone_mobile', PARAM_INTEGER);
        //$mform->addRule('contact_phone_mobile', "Number Required", 'numeric', null, 'client');

        $mform->addElement('header', 'headerattachment', get_string('attachment', 'mod_zingilt'));

        $attachment_type[] = "select";
        $attachment_type[] = "TEXT";
        $attachment_type[] = "IMAGE";

        $mform->addElement('select', 'attachment_type', get_string('attachment_type', 'mod_zingilt'), $attachment_type);
        ////$mform->addRule('attachment_type', $strrequired, 'required', null, 'client');
        //$mform->setDefault('resource_subtype_id', $courseconfig->visible);

        //if ($overviewfilesoptions = course_overviewfiles_options($course)) {
        $mform->addElement('filemanager', 'attachment', get_string('attachment', 'mod_zingilt'), null);
        $mform->addHelpButton('attachment', 'courseoverviewfiles');
        //  $summaryfields .= ',attachment';
        //  }

        $mform->addElement('textarea', 'brief_about_trainer', get_string('brief_about_trainer', 'mod_zingilt'), '');
        $mform->setType('brief_about_trainer', PARAM_NOTAGS);
        $mform->hideIf('brief_about_trainer', 'resource_type_id', 'neq', '2');
        $mform->addElement('textarea', 'trainer_sign', get_string('trainer_sign', 'mod_zingilt'), '');
        $mform->setType('trainer_sign', PARAM_NOTAGS);
        $mform->hideIf('trainer_sign', 'resource_type_id', 'neq', '2');
        $this->add_action_buttons();
    }
    /**
     * Validation.
     *
     * @param array $data
     * @param array $files
     * @return array the errors that were found
     */
    public function validation($data, $files)
    {
        global $DB;
        $errors = parent::validation($data, $files);
        //print_r($data);die("in validation");
        // $mform = $this->_form;
        // $data = $mform->get_data();
        if ($data['startdate'] > $data['enddate']) {
            //if (date("Y-m-d H:i:s",$data->startdate) > date("Y-m-d H:i:s",$data->enddate)) {
            $errors['startdate'] = "Start Date can't be Greater than End Date";
        }
        /*if (!empty($formaterrors) && is_array($formaterrors)) {
        $errors = array_merge($errors, $formaterrors);
        }*/
        //$errors['startdate']="you must have startdate";
        return $errors;
    }
}
