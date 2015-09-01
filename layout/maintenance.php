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

// Get the HTML for the settings bits.
$html = theme_warwickclean_get_html_for_settings($OUTPUT, $PAGE);

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
                <div class="nav-collapse collapse">
                    <?php echo $OUTPUT->custom_menu(); ?>
                    <ul class="nav pull-right">
                    	<li style="visibility:hidden;" id="jqm"><button id="jq_maxbut"><i class="fa fa-arrows-h fa-lg"></i></button></li>
                        <li><?php echo $OUTPUT->page_heading_menu(); ?></li>
                    </ul>
                </div>
            </div>
        </nav>
        
	</div>  
</div>  
</header>

<div id="page" class="container-fluid">

    <header id="page-header" class="clearfix">
        <?php echo $html->heading; ?>
    </header>

    <div id="page-content" class="row-fluid">
        <section id="region-main" class="span12">
            <?php echo $OUTPUT->main_content(); ?>
        </section>
    </div>

    <?php echo $OUTPUT->standard_end_of_body_html() ?>
</div>

<div id="foot-above"></div>
    <footer id="page-footer">
	<?php include ('footer.php'); ?> 
    </footer>
</body>
</html>
