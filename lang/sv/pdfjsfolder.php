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
 * Swedish strings for pdfjsfolder.
 *
 * @package    mod_pdfjsfolder
 * @copyright  2013 Jonas Nockert <jonasnockert@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'PDF.js-mapp';
$string['modulenameplural'] = 'PDF.js-mappar';
$string['modulename_help'] = 'Ett mapp-tillägg byggt på PDF.js med målet att se till att PDF-filer i mappen alltid öppnas i webbläsaren (med valet att ladda ned).';

$string['pdfjsfolder:addinstance'] = 'Lägg till en ny PDF.js-mapp';
$string['pdfjsfolder:view'] = 'Visa PDF.js-mapp';

$string['pluginadministration'] = 'Administration av PDF.js-mapp';
$string['pluginname'] = 'PDF.js-mapp';

$string['pdfjsfolder_defaults_heading'] = 'Standardvärden för inställningar för PDF.js-mapp';
$string['pdfjsfolder_defaults_text'] = 'De värden du sätter här definierar standardvärdena som används av PDF.js-mappens inställningsformulär när du skapar en ny PDF.js-mapp.';
$string['pdfjsfolder_options_heading'] = 'Alternativ för PDF.js-mapp';
$string['pdfjsfolder_options_text'] = 'De värden du sätter här ändrar hur PDF.js-mappar fungerar eller visas.';

$string['filearea_pdfs'] = 'PDF:er';

$string['pdf_fieldset'] = 'PDF';

$string['pdfs'] = 'PDF:er';
$string['pdfs_help'] = 'Lägg till PDF-filerna här.';

$string['display'] = 'Visa mappinnehåll';
$string['display_help'] = "Om du väljer att visa mappinnehållet på kurssidan så kommer det inte finnas någon länk till en separat sida. Beskrivningen visas enbart om \"Visa beskrivning på kurssidan\" är ikryssad.\n\nNotera också att deltagarnas visningar inte kan loggas i det här fallet.";
$string['displaypage'] = 'På en separat sida';
$string['displayinline'] = 'På kurssidan';
$string['downloadlinktext'] = 'ladda ned';
$string['noautocompletioninline'] = 'Automatiskt slutförande vid visning av aktivitet kan inte väljas tillsammans med alternativet "Visa på kurssidan"';
$string['showexpanded'] = 'Visa undermappar expanderade';
$string['showexpanded_help'] = 'Om aktiverat så visas undermappar expanderade som standard. Om inte visas undermappar ihopfällda.';
$string['openinnewtab'] = 'Öppna PDF:er i nya tabbar/fönster';
$string['openinnewtab_help'] = 'Om aktiverat så kommer PDF:er öppnas i nya tabbar eller fönster istället för i nuvarande tabb eller fönster.';
$string['showdownloadlinks'] = 'Visa nedladdningslänkar';
$string['showdownloadlinks_help'] = "Om aktiverat så kommer varje PDF.js-baserad länk följas av en länk för att ladda ned PDF:en.\n\nDet här kan vara användbart för mobila enheter där PDF.js kan använda för mycket minne eller vara för långsamt för att fungera tillfredsställande.";
