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
 * Pdfjsfolder module admin settings and defaults.
 *
 * @package    mod_pdfjsfolder
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
    require_once($CFG->libdir . '/resourcelib.php');

    $displayoptions = resourcelib_get_displayoptions(
        array(RESOURCELIB_DISPLAY_OPEN, RESOURCELIB_DISPLAY_POPUP));
    $defaultdisplayoptions = array(RESOURCELIB_DISPLAY_OPEN);

    // Options heading.
    $settings->add(
        new admin_setting_heading('pdfjsfolder_options',
                                  get_string('pdfjsfolder_options_heading', 'pdfjsfolder'),
                                  get_string('pdfjsfolder_options_text', 'pdfjsfolder')));

    // Flag for whether to show download links or not.
    $settings->add(
        new admin_setting_configcheckbox('pdfjsfolder/showdownloadlinks',
                                         get_string('showdownloadlinks', 'pdfjsfolder'),
                                         get_string('showdownloadlinks_help', 'pdfjsfolder'),
                                         1));

    // Defaults heading.
    $settings->add(
        new admin_setting_heading('pdfjsfolder_defaults',
                                  get_string('pdfjsfolder_defaults_heading', 'pdfjsfolder'),
                                  get_string('pdfjsfolder_defaults_text', 'pdfjsfolder')));

    // Default show expanded flag.
    $settings->add(
        new admin_setting_configcheckbox('pdfjsfolder/showexpanded',
                                         get_string('showexpanded', 'pdfjsfolder'),
                                         get_string('showexpanded_help', 'pdfjsfolder'),
                                         1));

    // Default open in new window/tab flag.
    $settings->add(
        new admin_setting_configcheckbox('pdfjsfolder/openinnewtab',
                                         get_string('openinnewtab', 'pdfjsfolder'),
                                         get_string('openinnewtab_help', 'pdfjsfolder'),
                                         1));
}
