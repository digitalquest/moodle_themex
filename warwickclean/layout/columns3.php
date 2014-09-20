<?php


//print_object($USER);

/******print cat details https://moodle.org/mod/forum/discuss.php?d=204195 ******/
//global $PAGE;
//print_object($PAGE->category);
//print_object($PAGE);
//print_object($PAGE->categories);
//echo $PAGE->category->description;


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

// Get the HTML for the settings bits.
$html = theme_warwickclean_get_html_for_settings($OUTPUT, $PAGE);

if (right_to_left()) {
    $regionbsid = 'region-bs-main-and-post';
} else {
    $regionbsid = 'region-bs-main-and-pre';
}

// User Profile Options (uses custom fields in Moodle for page widths and sticky scroll)

if ($USER->profile['pagewidth'] == "DEFAULT (A mix of fixed width and percentage based pages)" AND $USER->profile['stickyscroll'] == "0") {
	$bodyCustomClass = array('hybrid_display', 'no_stickyscroll');
	
} elseif ($USER->profile['pagewidth'] == "PERCENTAGE (All pages displayed at 98% of the screen size)" AND $USER->profile['stickyscroll'] == "0")  {
    $bodyCustomClass = array('percentage_display', 'no_stickyscroll');
	
} elseif ($USER->profile['pagewidth'] == "PERCENTAGE (All pages displayed at 98% of the screen size)" AND $USER->profile['stickyscroll'] == "1")  {
    $bodyCustomClass = array('percentage_display', 'yes_stickyscroll');

} elseif ($USER->profile['pagewidth'] == "FIXED (All pages are displayed with a width of 972 px)" AND $USER->profile['stickyscroll'] == "0")  {
    $bodyCustomClass = array('fixed_display', 'no_stickyscroll');
	
} elseif ($USER->profile['pagewidth'] == "FIXED (All pages are displayed with a width of 972 px)" AND $USER->profile['stickyscroll'] == "1")  {
    $bodyCustomClass = array('fixed_display', 'yes_stickyscroll');
	
} else {
    $bodyCustomClass = array('hybrid_display', 'yes_stickyscroll');
}	


echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes(); ?>>
<head>
    <title><?php echo $OUTPUT->page_title(); ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->favicon(); ?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
 <script type="text/javascript">
$(document).ready(function(){
		
  $("button#jq_maxbut").click(function(){
    $("body").toggleClass("hide_me");
  });
    
});
</script>   
</head>

<body <?php echo $OUTPUT->body_attributes($bodyCustomClass); ?>>

<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar navbar-fixed-top<?php echo $html->navbarclass ?> moodle-has-zindex">
<?php include ('header.php'); ?>
<div id="affix-wrap">
	<div id="my-affix" data-spy="affix" data-offset-top="45">
        <nav  role="navigation" class="navbar-inner">
            <div class="container-fluid">
                <a class="brand" href="<?php echo $CFG->wwwroot;?>"><img id="moologo" src="<?php echo $OUTPUT-> pix_url('logo_smaller', 'theme');?>" alt="<?php echo $PAGE->heading ?>" /></a>
                <a class="btn btn-navbar" data-toggle="workaround-collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="nav-collapse collapse">
                    <?php echo $OUTPUT->custom_menu(); ?>
                    <ul class="nav pull-right">
                       <li class="dropdown mytopset"><a href="/" class="settings" data-toggle="dropdown"><i class="fa fa-cog fa-lg"></i><b class="caret"></b></a>
                       <ul class="dropdown-menu mysub4"><li><a class="view_profile_link" href="/user/profile.php/"><i class="fa fa-user"></i> View Profile</a></li>
                       <li><a class="edit_profile_link" href="/user/edit.php"><i class="fa fa-pencil-square-o"></i> Edit Profile</a></li>
                       <li><a class="forumposts_link" href="/mod/forum/user.php/"><i class="fa fa-comments"></i> View My Forum Posts</a></li>
                       <li><a class="view_messages_link" href="/message/index.php"><i class="fa fa-envelope"></i> View My Messages</a></li>
                       <li><a class="notification_settings_link" href="/message/edit.php"><i class="fa fa-bullhorn"></i> Notification Settings</a></li>
                       <li>     <?php if (isloggedin()) {
                                	?>
                                  <a class="" href="<?php echo "$CFG->wwwroot/login/logout.php?sesskey=" . sesskey();?> "><i class="fa fa-sign-in"></i> Sign Out</a>
                                <?php
                                      } else {
                                ?>       
                                  <a class="" href="<?php echo get_login_url()?>"><i class="fa fa-sign-in"></i> Sign In</a>
                                <?php
                                  }
                                ?>
                       </li>
                       </ul>
                    	<li id="jqm"><button id="jq_maxbut"><i class="fa fa-arrows-h fa-lg"></i></button></li>
                                  <li id="small_search">
                            <form id="coursesearch" action="/course/search.php" method="get">
                                <fieldset class="coursesearchbox invisiblefieldset">
                                <label for="coursesearchbox"><span id="wbar-search-icon-outer"><i class="fa fa-search wbar-search-icon"></i></span></label>
                                <input type="text" id="coursesearchbox" size="30" name="search" value="" placeholder="Moodle Courses"  >
                                <input type="submit" value="GO" class=" btn-moo-blue"><!-- <i class="fa fa-chevron-right wbar-search-icon"></i>--></input>
                                </fieldset>
                            </form>
                        </li>
                        <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div id="crumb-outer"> 
            <div id="page-navbar" class="custom-crumbs">
                <div class="breadcrumb-nav"><?php echo $OUTPUT->navbar(); ?></div>
                <nav class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></nav>
            </div>
        </div>
	</div>  
</div>  
</header>



<div id="page" class="container-fluid">

    <header id="page-header" class="clearfix">
       <!-- <div id="page-navbar" class="clearfix">
            <div class="breadcrumb-nav"><?php //echo $OUTPUT->navbar(); ?></div>
            <nav class="breadcrumb-button"><?php //echo $OUTPUT->page_heading_button(); ?></nav>
        </div>-->
        <?php //echo $html->heading; ?>
        <div id="course-header">
            <?php echo $OUTPUT->course_header(); ?>
        </div>
    </header>

    <div id="page-content" class="row-fluid">
        <div id="<?php echo $regionbsid ?>" class="span9">
            <div class="row-fluid">
                <section id="region-main" class="span8 pull-right">
                    <?php
                    echo $OUTPUT->course_content_header();
                    echo $OUTPUT->main_content();
                    echo $OUTPUT->course_content_footer();
                    ?>
                </section>
                <?php echo $OUTPUT->blocks('side-pre', 'span4 desktop-first-column'); ?>
            </div>
        </div>
        <?php echo $OUTPUT->blocks('side-post', 'span3'); ?>
    </div>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</div>

<div id="foot-above"></div>
    <footer id="page-footer">
	<?php include ('footer.php'); ?> 
    </footer>

</body>
</html>
