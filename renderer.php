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
 * Pdfjsfolder module renderering methods are defined here.
 *
 * @package    mod_pdfjsfolder
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/mod/pdfjsfolder/locallib.php');

/**
 * Pdfjsfolder module renderer class
 */
class mod_pdfjsfolder_renderer extends plugin_renderer_base {
    /**
     * Renders the pdfjsfolder page header.
     *
     * @param pdfjsfolder pdfjsfolder
     * @return string
     */
    public function pdf_header($pdfjsfolder, cm_info $cm) {
        $output = '';

        $name = $cm->get_formatted_name();
        $title = $this->page->course->shortname . ': ' . $name;

        $context = context_module::instance($cm->id);

        // Header setup.
        $this->page->set_title($title);
        $this->page->set_heading($this->page->course->fullname);

        $output .= $this->output->header();
        $output .= $this->output->heading($name, 3);

        if (!empty($pdfjsfolder->get_instance()->intro)) {
            $output .= $this->output->box_start('generalbox boxaligncenter', 'intro');
            $output .= format_module_intro('pdfjsfolder',
                                           $pdfjsfolder->get_instance(),
                                           $cm->id);
            $output .= $this->output->box_end();
        }

        return $output;
    }

    /**
     * Render the footer
     *
     * @return string
     */
    public function pdf_footer() {
        return $this->output->footer();
    }

    /**
     * Render the pdfjsfolder page
     *
     * @param pdfjsfolder pdfjsfolder
     * @return string The page output.
     */
    public function render_pdfjsfolder($pdfjsfolder) {
        $output = '';

        $coursemodule = $pdfjsfolder->get_course_module();
        $instance = $pdfjsfolder->get_instance();
        $course = $pdfjsfolder->get_course();
        $context = $pdfjsfolder->get_context();

        // Get cm_info with uservisible.
        $modinfo = get_fast_modinfo($course);
        $cm = $modinfo->get_cm($coursemodule->id);

        if (!$cm->uservisible ||
                !has_capability('mod/pdfjsfolder:view', $context)) {
            // Module is not visible to the user. Don't throw any
            // errors in renderer, just return empty string.
            return $output;
        }

        if ($instance->display == PDFJS_FOLDER_DISPLAY_INLINE &&
                $cm->showdescription &&
                !empty($instance->intro)) {
            $output .= format_module_intro('pdfjsfolder',
                                           $instance,
                                           $cm->id,
                                           false);
        }

        if ($instance->display != PDFJS_FOLDER_DISPLAY_INLINE) {
            $output .= $this->pdf_header($pdfjsfolder, $cm);
        }

        $output .= $this->pdfs($pdfjsfolder, $cm);

        if ($instance->display != PDFJS_FOLDER_DISPLAY_INLINE) {
            $output .= $this->pdf_footer($cm);
        }

        return $output;
    }

    /**
     * Utility function for getting area files
     *
     * @param int $contextid
     * @param string $areaname file area name (e.g. "pdfs")
     * @return array of stored_file objects
     */
    private function util_get_area_tree($contextid, $areaname) {
        $fs = get_file_storage();
        return $fs->get_area_tree($contextid,
                                  'mod_pdfjsfolder',
                                  $areaname,
                                  false);
    }

    /**
     * Utility function for creating the pdf folder HTML.
     *
     * @param int $contextid
     * @param pdfjsfolder $pdfjsfolder
     * @param cm_info $cm
     * @return string HTML
     */
    protected function get_pdf_folder_html(pdfjsfolder $pdfjsfolder,
                                           cm_info $cm) {
        $output = '';
        $tree = $this->util_get_area_tree($pdfjsfolder->get_context()->id,
                                          'pdfs');

        $tree['dirname'] = $cm->name;
        $toptree = array('files' => array(),
                         'subdirs' => array($tree));

        $openinnewtab = $pdfjsfolder->get_instance()->openinnewtab;

        $output .= $this->htmlize_folder($tree, $toptree, $openinnewtab);

        return $output;
    }

    /**
     * Utility function for rendering folder structure.
     *
     * @param array $tree
     * @param array $dir
     * @param boolean $openinnewtab
     * @return string HTML
     */
    protected function htmlize_folder($tree, $dir, $openinnewtab) {
        if (empty($dir['subdirs']) and empty($dir['files'])) {
            return '';
        }

        $output = '<ul>';

        foreach ($dir['subdirs'] as $subdir) {
            $icon = new pix_icon(file_folder_icon(24),
                                 $subdir['dirname'],
                                 'moodle');
            $imagehtml = $this->output->render($icon);
            $iconhtml = html_writer::tag(
                'span',
                $imagehtml,
                array('class' => 'fp-icon'));
            $namehtml = html_writer::tag(
                'span',
                s($subdir['dirname']),
                array('class' => 'fp-filename'));
            $divhtml = html_writer::tag(
                'div',
                $iconhtml . $namehtml ,
                array('class' => 'fp-filename-icon'));

            $output .= html_writer::tag(
                'li',
                $divhtml . $this->htmlize_folder($tree, $subdir, $openinnewtab));
        }

        foreach ($dir['files'] as $pdf) {
            $filename = $pdf->get_filename();
            $url = moodle_url::make_pluginfile_url(
                $pdf->get_contextid(),
                $pdf->get_component(),
                $pdf->get_filearea(),
                $pdf->get_itemid(),
                $pdf->get_filepath(),
                $filename,
                false);

            if (file_extension_in_typegroup($filename, 'web_image')) {
                $image = $url->out(
                    false,
                    array('preview' => 'tinyicon',
                          'oid' => $pdf->get_timemodified()));
                $image = html_writer::empty_tag('img', array('src' => $image));
            } else {
                $icon = new pix_icon(file_file_icon($pdf, 24),
                                     $filename,
                                     'moodle');
                $image = $this->output->render($icon);

                $pdfjsfolderurl = new moodle_url(
                    '/mod/pdfjsfolder/pdf.js-b9bceb4/web/viewer.html');
                $url = $pdfjsfolderurl . '?file=' . $url;
            }

            if ($openinnewtab) {
                $linkoptions = array('target' => '_blank');
            } else {
                $linkoptions = array();
            }

            $fileicon = html_writer::tag(
                'span', $image, array('class' => 'fp-icon'));
            $filenamespan = html_writer::tag(
                'span', $filename, array('class' => 'fp-filename'));
            $filelink = html_writer::link(
                $url,
                $fileicon . $filenamespan,
                $linkoptions);
            $filespan = html_writer::tag(
                'span',
                $filelink,
                array('class' => 'fp-filename-icon'));

            $output .= html_writer::tag('li', $filespan);
        }

        $output .= '</ul>';
        return $output;
    }

    /**
     * Renders pdfjs folder.
     *
     * @param pdfjsfolder $pdfjsfolder
     * @param cm_info $cm
     * @return string HTML
     */
    public function pdfs(pdfjsfolder $pdfjsfolder, cm_info $cm) {
        static $treecounter = 0;
        $output  = '';

        // Open folder div.
        $id = 'pdfjs_folder_' . ($treecounter++);
        $output .= $this->output->container_start('pdfjs-folder filemanager',
                                                  $id);

        // Elements for folder.
        $output .= $this->get_pdf_folder_html($pdfjsfolder, $cm);

        // Close folder div.
        $output .= $this->output->container_end();

        $showexpanded = true;
        if (empty($pdfjsfolder->get_instance()->showexpanded)) {
            $showexpanded = false;
        }

        $this->page->requires->js_init_call('M.mod_pdfjsfolder.init_tree',
                                            array($id, $showexpanded));
        return $output;
    }
}
