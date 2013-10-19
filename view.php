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
 * Prints a particular instance of pdfjsfolder
 *
 * @package    mod_pdfjsfolder
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(dirname(__FILE__) . '/../../config.php');
require_once(dirname(__FILE__) . '/locallib.php');

$cmid = required_param('id', PARAM_INT);

$context = context_module::instance($cmid);
$pdfjsfolder = new pdfjsfolder($context, null, null);
$cm = $pdfjsfolder->get_course_module();
$course = $pdfjsfolder->get_course();

require_login($course, true, $cm);
require_capability('mod/pdfjsfolder:view', $context);

// Redirect to course section if trying to view inline folder.
if ($pdfjsfolder->get_instance()->display == FOLDER_DISPLAY_INLINE) {
    // Get sectionid for fragment id section references to work.
    $sectionid = $DB->get_field('course_sections',
                                'section',
                                array('id' => $cm->section,
                                      'course' => $course->id),
                                MUST_EXIST);
    redirect(course_get_url($course, $sectionid));
}

$PAGE->set_pagelayout('incourse');

$url = new moodle_url('/mod/pdfjsfolder/view.php', array('id' => $cm->id));
$PAGE->set_url($url);

// Update 'viewed' state if required by completion system.
$completion = new completion_info($course);
$completion->set_module_viewed($cm);

// Log viewing.
add_to_log($course->id,
           'pdfjsfolder',
           'view',
           $url,
           $pdfjsfolder->get_instance()->id,
           $cm->id);

$renderer = $PAGE->get_renderer('mod_pdfjsfolder');
echo $renderer->render_pdfjsfolder($pdfjsfolder);
