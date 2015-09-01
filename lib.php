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

/**
 * Parses CSS before it is cached.
 *
 * This function can make alterations and replace patterns within the CSS.
 *
 * @param string $css The CSS
 * @param theme_config $theme The theme config object.
 * @return string The parsed CSS The parsed CSS.
 */
function theme_warwickclean_process_css($css, $theme) {

    // Set the background image for the logo.
    $logo = $theme->setting_file_url('logo', 'logo');
    $css = theme_warwickclean_set_logo($css, $logo);

    // Set custom CSS.
    if (!empty($theme->settings->customcss)) {
        $customcss = $theme->settings->customcss;
    } else {
        $customcss = null;
    }
    $css = theme_warwickclean_set_customcss($css, $customcss);

    return $css;
}

/**
 * Adds the logo to CSS.
 *
 * @param string $css The CSS.
 * @param string $logo The URL of the logo.
 * @return string The parsed CSS
 */
function theme_warwickclean_set_logo($css, $logo) {
    $tag = '[[setting:logo]]';
    $replacement = $logo;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Serves any files associated with the theme settings.
 *
 * @param stdClass $course
 * @param stdClass $cm
 * @param context $context
 * @param string $filearea
 * @param array $args
 * @param bool $forcedownload
 * @param array $options
 * @return bool
 */
function theme_warwickclean_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel == CONTEXT_SYSTEM and $filearea === 'logo') {
        $theme = theme_config::load('warwickclean');
        return $theme->setting_file_serve('logo', $args, $forcedownload, $options);
    } else {
        send_file_not_found();
    }
}

/**
 * Adds any custom CSS to the CSS before it is cached.
 *
 * @param string $css The original CSS.
 * @param string $customcss The custom CSS to add.
 * @return string The CSS which now contains our custom CSS.
 */
function theme_warwickclean_set_customcss($css, $customcss) {
    $tag = '[[setting:customcss]]';
    $replacement = $customcss;
    if (is_null($replacement)) {
        $replacement = '';
    }

    $css = str_replace($tag, $replacement, $css);

    return $css;
}

/**
 * Returns an object containing HTML for the areas affected by settings.
 *
 * @param renderer_base $output Pass in $OUTPUT.
 * @param moodle_page $page Pass in $PAGE.
 * @return stdClass An object with the following properties:
 *      - navbarclass A CSS class to use on the navbar. By default ''.
 *      - heading HTML to use for the heading. A logo if one is selected or the default heading.
 *      - footnote HTML to use as a footnote. By default ''.
 */
function theme_warwickclean_get_html_for_settings(renderer_base $output, moodle_page $page) {
    global $CFG;
    $return = new stdClass;

    $return->navbarclass = '';
    if (!empty($page->theme->settings->invert)) {
        $return->navbarclass .= ' navbar-inverse';
    }

    if (!empty($page->theme->settings->logo)) {
        $return->heading = html_writer::link($CFG->wwwroot, '', array('title' => get_string('home'), 'class' => 'logo'));
    } else {
        $return->heading = $output->page_heading();
    }

    $return->footnote = '';
    if (!empty($page->theme->settings->footnote)) {
        $return->footnote = '<div class="footnote text-center">'.$page->theme->settings->footnote.'</div>';
    }

    $return->warningcolor = '';
    if (!empty($page->theme->settings->warningcolor)) {
        $return->warningcolor = $page->theme->settings->warningcolor;
    }

    $return->warningmessage = '';
    if (!empty($page->theme->settings->warningmessage)) {
        //$return->warningmessage = '<div class="warning-message text-center mdl_alert_'.$return->warningcolor.'">'.$page->theme->settings->warningmessage.'</div>';
        $return->warningmessage = html_writer::tag('div', $page->theme->settings->warningmessage, array('class'=>'warning-message text-center mdl_alert_'.$return->warningcolor));
    }

    return $return;
}

/**
 * All theme functions should start with theme_warwickclean_
 * @deprecated since 2.5.1
 */
function warwickclean_process_css() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

/**
 * All theme functions should start with theme_warwickclean_
 * @deprecated since 2.5.1
 */
function warwickclean_set_logo() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

/**
 * All theme functions should start with theme_clean_
 * @deprecated since 2.5.1
 */
function warwickclean_set_customcss() {
    throw new coding_exception('Please call theme_'.__FUNCTION__.' instead of '.__FUNCTION__);
}

// add jQuery - http://docs.moodle.org/dev/jQuery#Basic_jQuery_in_add-on_theme & http://docs.moodle.org/dev/jQuery (MIGRATE)
function theme_warwickclean_page_init(moodle_page $page){
	$page->requires->jquery();
	$page->requires->jquery_plugin('migrate', 'theme_warwickclean');
}

/*
*
*
*
*
*
*
*/
   class theme_warwickclean_transmuted_user_picture extends user_picture {

        public function __construct(user_picture $userpicture) {
            parent::__construct($userpicture->user);
        }

        /**
         * Works out the URL for the users picture.
         *
         * This method is recommended as it avoids costly redirects of user pictures
         * if requests are made for non-existent files etc.
         *
         * @param moodle_page $page
         * @param renderer_base $renderer
         * @return moodle_url
         */
        public function get_url(moodle_page $page, renderer_base $renderer = null) {
            global $CFG;
            if (is_null($renderer)) {
                $renderer = $page->get_renderer('core');
            }
            // Sort out the filename and size. Size is only required for the gravatar
            // implementation presently.
            if (empty($this->size)) {
                $filename = 'f2';
                $size = 35;
            } else if ($this->size === true or $this->size == 1) {
                $filename = 'f1';
                $size = 100;
            } else if ($this->size > 100) {
                $filename = 'f3';
                $size = (int)$this->size;
            } else if ($this->size >= 50) {
                $filename = 'f1';
                $size = (int)$this->size;
            } else {
                $filename = 'f2';
                $size = (int)$this->size;
            }
            $defaulturl = $renderer->pix_url('u/'.$filename); // default image
            if ((!empty($CFG->forcelogin) and !isloggedin()) ||
                (!empty($CFG->forceloginforprofileimage) && (!isloggedin() || isguestuser()))) {
                // Protect images if login required and not logged in;
                // also if login is required for profile images and is not logged in or guest
                // do not use require_login() because it is expensive and not suitable here anyway.
                return $defaulturl;
            }
            // First try to detect deleted users - but do not read from database for performance reasons!
            if (!empty($this->user->deleted) or strpos($this->user->email, '@') === false) {
                // All deleted users should have email replaced by md5 hash,
                // all active users are expected to have valid email.
                return $defaulturl;
            }
            // Did the user upload a picture?
            if ($this->user->picture > 0) {
                if (!empty($this->user->contextid)) {
                    $contextid = $this->user->contextid;
                } else {
                    $context = context_user::instance($this->user->id, IGNORE_MISSING);
                    if (!$context) {
                        // This must be an incorrectly deleted user, all other users have context.
                        return $defaulturl;
                    }
                    $contextid = $context->id;
                }
                $path = '/';
                if (clean_param($page->theme->name, PARAM_THEME) == $page->theme->name) {
                    // We append the theme name to the file path if we have it so that
                    // in the circumstance that the profile picture is not available
                    // when the user actually requests it they still get the profile
                    // picture for the correct theme.
                    $path .= $page->theme->name.'/';
                }
                // Set the image URL to the URL for the uploaded file and return.
                $url = moodle_url::make_pluginfile_url($contextid, 'user', 'icon', NULL, $path, $filename);
                $url->param('rev', $this->user->picture);
                return $url;
            }
            // Is the user a member of staff
            $staff_status = "University Staff";
            if ( !empty($this->user->status) && ($this->user->status == $staff_status) ) {
                // If it is a staff memeber we return the default URL
                return $defaulturl;
            }

            if ($this->user->picture == 0) {
                // Normalise the size variable to acceptable bounds
                if ($size < 1 || $size > 512) {
                    $size = 35;
                }
                // Hash the users email address
                //$md5 = md5(strtolower(trim($this->user->email)));

                // Find the best default image URL we can (MDL-35669)
                $absoluteimagepath = $page->theme->resolve_image_location('u/'.$filename, 'core');
                if (strpos($absoluteimagepath, $CFG->dirroot) === 0) {
                    $gravatardefault = $CFG->wwwroot . substr($absoluteimagepath, strlen($CFG->dirroot));
                } else {
                    $gravatardefault = $CFG->wwwroot . '/pix/u/' . $filename . '.png';
                }

                // Build a gravatar URL with what we know.                
                $applicationId = "itsmoodle";
                $applicationkey = "RtqXJkDsdmk2mO!zmF&QmkDkAb#PxwzJuX9%^9S0";
                //$universityId = $this->user->idnumber;
                if (!empty($this->user->idnumber)) $universityId = $this->user->idnumber;
                else $universityId = "1473579"; // 4011418,1562611, 1473579, 1271126, 1562557, 1255783

                // Hash the application key and user id
                $hashstring = $applicationkey. $universityId;
                $md5 = md5($hashstring);

                $image_url = "https://photos-test.warwick.ac.uk/{$applicationId}/photo/{$md5}/{$universityId}";
                return new moodle_url("$image_url", array('s' => $size, 'd' => $gravatardefault));
            }
            return $defaulturl;
        }

    }


