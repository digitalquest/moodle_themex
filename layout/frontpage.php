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

$left = (!right_to_left());  // To know if to add 'pull-right' and 'desktop-first-column' classes in the layout for LTR.

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
<body <?php echo $OUTPUT->body_attributes('two-column'); ?>>


<?php echo $OUTPUT->standard_top_of_body_html() ?>

<header role="banner" class="navbar navbar-fixed-top<?php echo $html->navbarclass ?> moodle-has-zindex"> 
<?php include ('header.php'); ?>
    <nav role="navigation" class="navbar-inner">
        <div class="container-fluid">
            <a class="brand" href="<?php echo $CFG->wwwroot;?>"><?php //echo $SITE->shortname; ?> <img id="moologo" src="<?php echo $OUTPUT-> pix_url('logo', 'theme');?>" alt="<?php echo $PAGE->heading ?>" /> </a> 
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
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
</header>
<div id="slidecont">
        <?php
        $classextra = '';
        if ($left) {
            $classextra = ' desktop-first-column';
        }
        echo $OUTPUT->blocks('side-pre', 'span3'.$classextra);
        ?>
        
<!--        <div id="myCarousel" class="carousel slide">
 
  <div class="carousel-inner">
    <div class="active item"><img src="<?php echo $OUTPUT-> pix_url('slider_example', 'theme');?>" alt="slide eample"></div>
    <div class="item"><img src="<?php echo $OUTPUT-> pix_url('slider_example2', 'theme');?>" alt="slide eample"></div>
    <div class="item"><img src="<?php echo $OUTPUT-> pix_url('slider_example3', 'theme');?>" alt="slide eample"></div>
  </div>

  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>
        -->   
	<!--<div id="slideinner"><img id="slideexample" src="<?php echo $OUTPUT-> pix_url('slider_example', 'theme');?>" alt="slide eample" /></div>-->
	
    <div id="slideinner">
    	<img id="slideexample2" class="img-responsive" src="<?php echo $OUTPUT-> pix_url('media_trans', 'theme');?>" alt="Multimedia icons exploding out from a laptop screen" />
    	<div id="front_txt_cont">
        	<div id="allwtext">
                <h1 id="welcome_head"><span id="welc_l1" class="welc_l">Welcome to Moodle at</span> <span id="welc_l2" class="welc_l">the University of Warwick</span></h1>
                <div id="welc_subtext">The University’s Online, Virtual Learning Environment<!-- used to support  the delivery of teaching and learning--></div>
                <ul id="welc_sublist">
                	<li><i class="fa fa-chevron-circle-right"></i> 24/7 online access to resources & course materials</li>
                    <li><i class="fa fa-chevron-circle-right"></i> A range of engaging activities & multimedia content </li>
                    <li><i class="fa fa-chevron-circle-right"></i> Interact & share using communication & collaboration tools</li>
                </ul>
                <span id="homelogbut">
								<?php if (isloggedin()) {
                                	?>
                                  <a class="btn btn-moo-blue pad-but" href="<?php echo "$CFG->wwwroot/login/logout.php?sesskey=" . sesskey();?> "><i class="fa fa-sign-out"></i> Sign out of Moodle</a>
                                <?php
                                      } else {
                                ?>       
                                  <a class="btn btn-moo-blue pad-but" href="<?php echo get_login_url()?>"><i class="fa fa-sign-in"></i> Sign in to Moodle</a>
                                <?php
                                  }
                                ?>
             	</span>
			</div>
        </div>
	</div>    
</div>
<div id="page" class="container-fluid">

    <header id="page-header" class="clearfix">
        <div id="page-navbar" class="clearfix">
            <div class="breadcrumb-nav"><?php echo $OUTPUT->navbar(); ?></div>
            <nav class="breadcrumb-button"><?php echo $OUTPUT->page_heading_button(); ?></nav>
        </div>
        <?php //echo $html->heading; ?>
        <div id="course-header">
            <?php echo $OUTPUT->course_header(); ?>
        </div>
    </header>
    
    <div id="page-content" class="row-fluid">

        <div class="span4 frontbox">
        	<h2><span class="fa-stack "><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-bullhorn fa-stack-1x fa-inverse"></i></span>About Moodle</h2>
            <p>Moodle is The University’s Virtual Learning Environment (VLE); a web platform designed specifically to support the delivery of teaching and learning materials and activities.</p> 
            <p>The VLE enables learning resources and activities to be collected into one online location offering users convenient 24/7 anywhere, anytime access.</p>
        </div>
        
        <div class="span4 frontbox">
        	<h2><span class="fa-stack "><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-clipboard fa-stack-1x fa-inverse"></i></span>Interactive, Multimedia Content</h2>
            <p>Moodle provides a number of interactive activities including forums, wikis, quizzes, surveys, chat and peer-to-peer activities. Users will have the opportunity to share resources, work and learn together.</p>
            <p>Pages in Moodle contain a mix of multimedia content including text, images, audio, video and interactive learning objects.</p>
            </div>
        
        <div class="span4 frontbox">
        	<h2><span class="fa-stack "><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-refresh fa-stack-1x fa-inverse"></i></span>What's New In Moodle</h2>
            <p>On 11th August Moodle was upgraded to version 2.6. The upgrade brings a host of improvements including a new responsive design, new drag and drop functionality and improved assignment options. Please take a moment to see what's new in Moodle.</p>
  <p id="newbut"><a class="btn btn-default" href="http://docs.moodle.org/26/en/New_features" target="_blank">What's New  <i class="fa fa-arrow-right greyawes"></i></a></p>
<!-- <p><a class="btn btn-moo-blue  pad-but" href="#"><i class="fa fa-chevron-right"></i> What's New</a></p>-->
        </div>
        
        <section id="region-main" class="span9<?php if ($left) { echo ' pull-right'; } ?>">
            <?php
            echo $OUTPUT->course_content_header();
            echo $OUTPUT->main_content();
            echo $OUTPUT->course_content_footer();
            ?>
        </section>
        <?php
      //  $classextra = '';
//        if ($left) {
//            $classextra = ' desktop-first-column';
//        }
//        echo $OUTPUT->blocks('side-pre', 'span3'.$classextra);
        ?>
        
    </div>


    <?php echo $OUTPUT->standard_end_of_body_html() ?>

</div>
		

<div id="foot-above"></div>
    <footer id="page-footer">
	<?php include ('footer.php'); ?>
    </footer>
</body>
</html>
