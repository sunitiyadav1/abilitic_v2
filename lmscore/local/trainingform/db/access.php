<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = array(
    'local/trainingform:manage' => array(
        'captype' => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes' => array(
            'manager'=> CAP_ALLOW,        
        ),
    ),
);