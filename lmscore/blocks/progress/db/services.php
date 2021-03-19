<?php

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

/**
 * Web service local plugin template external functions and service definitions.
 *
 * @package    block_progress
 * @copyright  2020 Kajal Tailor
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// We defined the web service functions to install.
$functions = array(

    // === grade related functions ===

    'block_progress_get_myprogress' => array(
        'classname'   => 'block_progress_external',
        'methodname'  => 'get_myprogress',
        'classpath'   => 'blocks/progress/externallib.php',
        'description' => 'Returns myprogress details.',
        'type'        => 'read',
        'capabilities' => '',
        'services' => [MOODLE_OFFICIAL_MOBILE_SERVICE, 'local_mobile']
    ),

    'block_progress_get_teamprogress' => array(
        'classname'   => 'block_progress_external',
        'methodname'  => 'get_teamprogress',
        'classpath'   => 'blocks/progress/externallib.php',
        'description' => 'return Team Progress Details',
        'type'        => 'read',
        'capabilities' => '',
        'services' => [MOODLE_OFFICIAL_MOBILE_SERVICE, 'local_mobile']
    ),
);
