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
 * Moodle's warwickclean theme, an example of how to make a Bootstrap theme
 *
 * DO NOT MODIFY THIS THEME!
 * COPY IT FIRST, THEN RENAME THE COPY AND MODIFY IT INSTEAD.
 *
 * For full information about creating Moodle themes, see:
 * http://docs.moodle.org/dev/Themes_2.0
 *
 * @package   theme_warwickclean
 * @copyright 2013 Moodle, moodle.org
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    // Invert Navbar to dark background.
    $name = 'theme_warwickclean/invert';
    $title = get_string('invert', 'theme_warwickclean');
    $description = get_string('invertdesc', 'theme_warwickclean');
    $setting = new admin_setting_configcheckbox($name, $title, $description, 0);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Logo file setting.
    $name = 'theme_warwickclean/logo';
    $title = get_string('logo','theme_warwickclean');
    $description = get_string('logodesc', 'theme_warwickclean');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'logo');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Custom CSS file.
    $name = 'theme_warwickclean/customcss';
    $title = get_string('customcss', 'theme_warwickclean');
    $description = get_string('customcssdesc', 'theme_warwickclean');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Footnote setting.
    $name = 'theme_warwickclean/footnote';
    $title = get_string('footnote', 'theme_warwickclean');
    $description = get_string('footnotedesc', 'theme_warwickclean');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);

    // Warning message setting.
    $name = 'theme_warwickclean/warningmessage';
    $title = get_string('warning_message', 'theme_warwickclean');
    $description = get_string('warning_messagedesc', 'theme_warwickclean');
    $default = '';
    $setting = new admin_setting_configtextarea($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
    
    // Warning message color
    $name = 'theme_warwickclean/warningcolor';
    $title = get_string('warning_color','theme_warwickclean');
    $description = get_string('warning_colordesc', 'theme_warwickclean');
    $default = 'amber';
    $choices = array('red'=>'red', 'amber'=>'amber', 'green'=>'green', 'blue'=>'blue');
    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $settings->add($setting);
}
