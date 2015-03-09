<?php echo $html->warningmessage;?>
<div id="top-wbar">
	<div id="wbar-inner">
   <a id="wlogo"  href="http://www2.warwick.ac.uk/"><?php //echo $SITE->shortname; ?> <img id="warlogo" src="<?php echo $OUTPUT-> pix_url('logo_warwick', 'theme');?>" alt="University of Warwick Logo" /> </a>
   
      	<div id="wbar_search">
        <form id="coursesearch" action="/course/search.php" method="get">
        	<fieldset class="coursesearchbox invisiblefieldset">
        	<label for="coursesearchbox"><span id="wbar-search-icon-outer"><i class="fa fa-search wbar-search-icon"></i></span></label>
            <input type="text" id="coursesearchbox" size="30" name="search" value="" placeholder="Moodle Courses"  >
       <!--     <input type="submit" value="search" class="btn btn-primary">-->
            <input type="submit" value="GO" class=" btn-moo-blue"><!-- <i class="fa fa-chevron-right wbar-search-icon"></i>--></input>
            </fieldset>
        </form>
 		</div>
   
   <?php echo $PAGE->navigation(); ?>
   
		<div id="wbar-log-outer">
   			<ul id="wbar-login">
    			<li class="navbar-text"><?php echo $OUTPUT->login_info() ?></li>
    		</ul>
            
         <?php if (isloggedin()) {
                                	?>
                                  <a class="signout_link2" href="<?php echo "$CFG->wwwroot/login/logout.php?sesskey=" . sesskey();?> "><i class="fa fa-sign-in"></i> Sign Out</a>
                                <?php
                                      } else {
                                ?>       
                                  <a class="signin_link2" href="<?php echo get_login_url()?>"><i class="fa fa-sign-in"></i> Sign In</a>
                                <?php
                                  }
                                ?>

     	</div>   
	</div>
</div>
<!-- END OF HEADER -->