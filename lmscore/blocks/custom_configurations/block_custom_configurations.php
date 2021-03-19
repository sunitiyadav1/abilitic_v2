<?php
/*
 * @author : Suniti Yadav
 * description : Show all the links which we were showing on HTML block.
 */

class block_custom_configurations extends block_base
{
   public $rowcount =5;
    public function init()
    {
        $this->title = get_string('pluginname', 'block_custom_configurations');
    }

    public function instance_allow_multiple()
    {
        return true;
    }

    public function has_config()
    {
        return false;
    }

    public function instance_allow_config()
    {
        return true;
    }

    public function applicable_formats()
    {
        return array(
            'admin' => false,
            'site-index' => true,
            'course-view' => true,
            'mod' => false,
            'my' => true,
        );
    }

    public function specialization()
    {
        if (empty($this->config->title)) {
            $this->title = get_string('custom_configurations', 'block_custom_configurations');
        } else {
            $this->title = $this->config->title;
        }
    }

    public function get_content()
    {
        global $CFG, $PAGE;
        
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();
        $this->content->text ='<style>
            #leaderboard-table tr.curuserclass{
                    border: 1px solid yellow;
                    background-color: yellow;
            }
        </style>';

        if(is_siteadmin()){
            $this->content->text .= '<div><a href="' . $CFG->wwwroot . '/customconfig/config/setconfigurations.php">Set Configurations </a></div>';

            $this->content->text .= '<div><a href="' . $CFG->wwwroot . '/local/notifications/index.php">Manual Notifications </a></div>';
        }
        $this->content->text .= '<div><a href="' . $CFG->wwwroot . '/customconfig/cohort/attribute/v1/dynamic_cohort.php">Dynamic Cohort </a></div>';
        
        $this->content->text .= '<div><a href="' . $CFG->wwwroot . '/mod/zingilt/resourcemgmt/index.php">Resource Management </a></div>';

        return $this->content;
    }
}
