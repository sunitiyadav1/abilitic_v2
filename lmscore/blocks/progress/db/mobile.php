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

/**
 * Mobile add-on.
 *
 * @package mod_oucontent
 * @copyright 2017 The Open University
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$addons = [
    'block_progress' => [
        'handlers' => [
            'blockprogressview' => [
                'delegate' => 'CoreBlockDelegate',
                'method' => 'mobile_block_myprogress',
                /*'displaydata' => [
                        'class' => 'happyblock'
                ]*/
            ],
            'myprogressview' => [
                'delegate' => 'CoreBlockDelegate',
                'method' => 'mobile_block_myprogress_view',
                /*'displaydata' => [
                        'class' => 'happyblock'
                ]*/
                'styles' => [
                    'url' => $CFG->wwwroot . '/blocks/progress/css/progress-bar.css',
                    //'version' => 2019062500
                ],
            ],
            'teamprogressview' => [
                'delegate' => 'CoreBlockDelegate',
                'method' => 'mobile_block_teamprogress_view',
                /*'displaydata' => [
                        'class' => 'happyblock'
                ]*/
                'styles' => [
                    'url' => $CFG->wwwroot . '/blocks/progress/css/progress-bar.css',
                    //'version' => 2019062500
                ],
            ],
        ],
        'lang' => [
            ['pluginname', 'block_progress'],
            ['my_progress', 'block_progress'],
            ['team_progress', 'block_progress'],
            ['view_more', 'block_progress'],
        ]
    ]
];
