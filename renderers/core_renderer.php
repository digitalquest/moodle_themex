<?php
 
class theme_warwickclean_core_renderer extends core_renderer {
	
/** @var custom_menu_item language The language menu if created */
    protected $language = null;

    /*
     * This renders a notification message.
     * Uses bootstrap compatible html.
     */
    public function notification($message, $classes = 'notifyproblem') {
        $message = clean_text($message);
        $type = '';

        if ($classes == 'notifyproblem') {
            $type = 'alert alert-error';
        }
        if ($classes == 'notifysuccess') {
            $type = 'alert alert-success';
        }
        if ($classes == 'notifymessage') {
            $type = 'alert alert-info';
        }
        if ($classes == 'redirectmessage') {
            $type = 'alert alert-block alert-info';
        }
        return "<div class=\"$type\">$message</div>";
    }

    /*
     * This renders the navbar.
     * Uses bootstrap compatible html.
     */
    public function navbar() {
        $items = $this->page->navbar->get_items();
        $breadcrumbs = array();
        foreach ($items as $item) {
            $item->hideicon = true;
            /* 
            * Trying to replace the 'My home' breadcrumb
            * not very elegant; another solution may be considered later
            */
            $ismyhome = strcasecmp( $item->text , get_string('myhome') ) == 0;
            if ($ismyhome) {
                $breadcrumbs[] = '<a href="/" id="moo-home-button">&nbsp;<i class="fa fa-home fa-lg"></i></a>';
                continue; // go to next element
            }

              
            /**/
            $a = $this->render($item);
            if( strpos($a, "/course/view.php" ) !== false  ) {
              $breadcrumbs[] = html_writer::div($a, 'coursetitle');
            } else {
              $breadcrumbs[] = $a;
            }            
        }
        // ADD ELLIPSES ...
        $new_breadcrumbs = array();
        $counter = 0;
        foreach ($breadcrumbs as $breadcrumb) { //add ellipses in second position
            if ($counter == 1) $new_breadcrumbs[] = "<span id='ellipses'>...</span>";
            $new_breadcrumbs[] =  $breadcrumb;
            $counter++;
        }
        //
        $divider = '<span class="divider">'.get_separator().'</span>';
        $list_items = '<li>'.join(" $divider</li><li>", $new_breadcrumbs).'</li>';
        $title = '<span class="accesshide">'.get_string('pagepath').'</span>';
        return $title . "<ul id=\"bc1\" class=\"breadcrumb\">$list_items</ul>";
    }

    /*
     * Overriding the custom_menu function ensures the custom menu is
     * always shown, even if no menu items are configured in the global
     * theme settings page.
     */
    public function custom_menu($custommenuitems = '') {
        global $CFG;

        if (!empty($CFG->custommenuitems)) {
            $custommenuitems .= $CFG->custommenuitems;
        }
        $custommenu = new custom_menu($custommenuitems, current_language());
        return $this->render_custom_menu($custommenu);
		
    }
	

    /*
     * This renders the bootstrap top menu.
     *
     * This renderer is needed to enable the Bootstrap style navigation.
     */
    protected function render_custom_menu(custom_menu $menu) {
        global $CFG;
		require_once($CFG->dirroot.'/course/lib.php');
 

        // TODO: eliminate this duplicated logic, it belongs in core, not
        // here. See MDL-39565.
        $addlangmenu = true;
        $langs = get_string_manager()->get_list_of_translations();
        if (count($langs) < 2
            or empty($CFG->langmenu)
            or ($this->page->course != SITEID and !empty($this->page->course->lang))) {
            $addlangmenu = false;
        }

        if (!$menu->has_children() && $addlangmenu === false) {
            return '';
        }

        if ($addlangmenu) {
            $strlang =  get_string('language');
            $currentlang = current_language();
            if (isset($langs[$currentlang])) {
                $currentlang = $langs[$currentlang];
            } else {
                $currentlang = $strlang;
            }
            $this->language = $menu->add($currentlang, new moodle_url('#'), $strlang, 10000);
            foreach ($langs as $langtype => $langname) {
                $this->language->add($langname, new moodle_url($this->page->url, array('lang' => $langtype)), $langname);
            }
        }	
		
		   // Add a login or logout link
   //     if (isloggedin()) {
//            $branchlabel = get_string('logout');
//            $branchurl   = new moodle_url('/login/logout.php');
//        } else {
//            $branchlabel = get_string('login');
//            $branchurl   = new moodle_url('/login/index.php');
//        }
//        $branch = $menu->add($branchlabel, $branchurl, $branchlabel, -1);
//		
			
		
 // Add My Courses to the menu form http://docs.moodle.org/dev/Adding_courses_and_categories_to_the_custom_menu
 
 if (isloggedin() && !isguestuser() && $mycourses = enrol_get_my_courses(NULL, 'visible DESC, fullname ASC')) {  //which does work
 
            $branchlabel = "My Moodle" ;
            $branchurl   = new moodle_url('/my');
            $branchtitle = $branchlabel;
            $branchsort  = 1000 ; // lower numbers = higher priority e.g. move this item to the left on the Custom Menu	
            $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
 
 			$branch->add('Overview',new moodle_url('/my'));
            foreach ($mycourses as $mycourse) {
                $branch->add($mycourse->shortname, new moodle_url('/course/view.php', array('id' => $mycourse->id)), $mycourse->fullname);
            }
        }
     
   // Add a custom link to top navigation
            $branchlabel = "Categories";
            $branchurl   = new moodle_url('/course');
			$branchtitle = "categories";
			$branchsort  = 2000;
       
        $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
			$branch->add('All Categories',new moodle_url('/course'));
			$branch->add('Arts',new moodle_url('/course/index.php?categoryid=3'));
			$branch->add('Medicine',new moodle_url('/course/index.php?categoryid=31'));
			$branch->add('Science',new moodle_url('/course/index.php?categoryid=50'));
			$branch->add('Social Sciences',new moodle_url('/course/index.php?categoryid=60'));
			$branch->add('Interdisciplinary/Cross-Faculty',new moodle_url('/course/index.php?categoryid=28'));
			$branch->add('Services',new moodle_url('/course/index.php?categoryid=56'));
			$branch->add('Sandbox',new moodle_url('/course/index.php?categoryid=51'));
		
	// Add a custom link to top navigation
            $branchlabel = "Help";
            $branchurl   = new moodle_url('/');
			$branchtitle = "help";
			$branchsort  = 3000;
       
        $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
			$branch->add("Medical School Help Pages", new moodle_url('http://www2.warwick.ac.uk/fac/med/study/cpd/current/moodle'),"medschool_help_cat_nav");
			//$branch->add("Physics Help Pages", new moodle_url('http://www2.warwick.ac.uk/fac/sci/physics/current/teach/module_pages/moodle'),"physics_help_cat_nav");
			$branch->add("Life Sciences Help Pages", new moodle_url('http://www2.warwick.ac.uk/fac/sci/lifesci/intranet/staffpg/moodle'),"life_sciences_help_cat_nav");
			$branch->add("Moodle Support Pages", new moodle_url('http://www2.warwick.ac.uk/services/its/servicessupport/academictechnology/our-services/moodle/support-for-moodle/helpcontacts/'),"moodle_help_nav");

	// Add a custom link to top navigation
            //$branchlabel = '<i class="fa fa-link fa-lg"></i>';
			$branchlabel = "Links";
            $branchurl   = new moodle_url('/');
			$branchtitle = "links";
			$branchsort  = 5000;
       
       $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
	  		$branch->add( "Email", new moodle_url('http://go.warwick.ac.uk/mymail/'),"insite_link");
			$branch->add( "Insite", new moodle_url('http://www2.warwick.ac.uk/insite/'),"insite_link");
			$branch->add( "My Portfolio", new moodle_url('http://myportfolio.warwick.ac.uk/'),"mahara_link");
			//$branch->add( "Moodle X", new moodle_url('http://moodlex.warwick.ac.uk/'),"moodle2_link");
			$branch->add( "Start.Warwick", new moodle_url('https://start.warwick.ac.uk/'),"start_warwick_link");
			$branch->add( "Tabula", new moodle_url('https://tabula.warwick.ac.uk/'),"tabula_link");

	// Add a custom link to top navigation
         //   $branchlabel = '<i class="fa fa-cog fa-lg"></i>';
//            $branchurl   = new moodle_url('/course/');
//			$branchtitle = "settings";
//			$branchsort  = 6000;
//       
//       $branch = $menu->add($branchlabel, $branchurl, $branchtitle, $branchsort);
// 			$branch->add('<i class="icon-user"></i>'.get_string('profile').' ',new moodle_url('/user/profile.php'),get_string('profile'));
//			$branch->add('<i class="fa fa-user"></i>'." View Profile", new moodle_url('/user/profile.php/'),"view_profile_link");
//			$branch->add('<i class="fa fa-pencil-square-o"></i>'." Edit Profile", new moodle_url('/user/edit.php'),"edit_profile_link");
//			$branch->add('<i class="fa fa-comments"></i>'." View My Forum Posts", new moodle_url('/mod/forum/user.php/'),"forumposts_link");
//			$branch->add('<i class="fa fa-envelope"></i>'." View My Messages", new moodle_url('/message/index.php'),"view_messages_link");
//			$branch->add('<i class="fa fa-bullhorn"></i>'." Notification Settings", new moodle_url('/message/edit.php'),"notification_settings_link");;
//			$branch->add('<i class="fa fa-sign-out"></i>'." Sign Out", new moodle_url('/login/logout.php'),"signout_link");  
//								
		
	// Add a custom settings icon link to top navigation
         //   $branchlabel = '<i class="fa fa-arrows-h fa-lg"></i>';
//            $branchurl   = new moodle_url('/course/');
//			$branchtitle = "maximise";
//			$branchsort  = 7000;
//       
	  //$branch = $menu->add($branchlabel, $branchurl,$branchtitle, $branchsort);  
		//$branch = $menu->add('<div id="icondiv">'.$branchlabel.'</div>', $branchurl, $branchtitle) ;
			

        $content = '<ul class="nav">';
        foreach ($menu->get_children() as $item) {
            $content .= $this->render_custom_menu_item($item, 1);
        }

        return $content.'</ul>';
    }
	

    /*
     * This code renders the custom menu items for the
     * bootstrap dropdown menu.
     */
    protected function render_custom_menu_item(custom_menu_item $menunode, $level = 0 ) {
        static $submenucount = 0;
		

        if ($menunode->has_children()) {

            if ($level == 1) {
                $class = 'dropdown '."mytop".$submenucount;  //************added by Richard to give custom class to to top level list items************
            } else {
                $class = 'dropdown-submenu';
            }

            if ($menunode === $this->language) {
                $class .= ' langmenu';
            }
            $content = html_writer::start_tag('li', array('class' => $class));
            // If the child has menus render it as a sub menu.
            $submenucount++;
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
				$richID = $menunode->get_title(); //************added by Richard to give custom Classes to menu itmes based on the title************
            } else {
                $url = '#cm_submenu_'.$submenucount;
            }
            $content .= html_writer::start_tag('a', array('href'=>$url,'class'=>'dropdown-toggle','class'=>$richID, 'data-toggle'=>'dropdown', /*'title'=>$menunode->get_title()*/));
            $content .= $menunode->get_text();
            if ($level == 1) {
                $content .= '<b class="caret"></b>';
            }
            $content .= '</a>';
           // $content .= '<ul class="dropdown-menu">';
			$content .= "<ul class= 'dropdown-menu mysub$submenucount'>";  //************added by Richard to give custom class to sub menus based on menu count************
            foreach ($menunode->get_children() as $menunode) {
                $content .= $this->render_custom_menu_item($menunode, 0);
            }
            $content .= '</ul>';
        } else {
            $content = '<li>';
            // The node doesn't have children so produce a final menuitem.
            if ($menunode->get_url() !== null) {
                $url = $menunode->get_url();
				$richID = $menunode->get_title(); //************added by Richard to give custom Classes to menu items based on the title************
            } else {
                $url = '#';
            }
            $content .= html_writer::link($url, $menunode->get_text(), array('class'=>$richID, /*'title'=>$menunode->get_title()*/));
        }
        return $content;
    }

    /**
     * Renders tabtree
     *
     * @param tabtree $tabtree
     * @return string
     */
    protected function render_tabtree(tabtree $tabtree) {
        if (empty($tabtree->subtree)) {
            return '';
        }
        $firstrow = $secondrow = '';
        foreach ($tabtree->subtree as $tab) {
            $firstrow .= $this->render($tab);
            if (($tab->selected || $tab->activated) && !empty($tab->subtree) && $tab->subtree !== array()) {
                $secondrow = $this->tabtree($tab->subtree);
            }
        }
        return html_writer::tag('ul', $firstrow, array('class' => 'nav nav-tabs')) . $secondrow;
    }

    /**
     * Renders tabobject (part of tabtree)
     *
     * This function is called from {@link core_renderer::render_tabtree()}
     * and also it calls itself when printing the $tabobject subtree recursively.
     *
     * @param tabobject $tabobject
     * @return string HTML fragment
     */
    protected function render_tabobject(tabobject $tab) {
        if ($tab->selected or $tab->activated) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'active'));
        } else if ($tab->inactive) {
            return html_writer::tag('li', html_writer::tag('a', $tab->text), array('class' => 'disabled'));
        } else {
            if (!($tab->link instanceof moodle_url)) {
                // backward compartibility when link was passed as quoted string
                $link = "<a href=\"$tab->link\" title=\"$tab->title\">$tab->text</a>";
            } else {
                $link = html_writer::link($tab->link, $tab->text, array('title' => $tab->title));
            }
            return html_writer::tag('li', $link);
        }
    }
    /**
     * Return the standard string that says whether you are logged in (and switched
     * roles/logged in as another user).
     * @param bool $withlinks if false, then don't include any links in the HTML produced.
     * If not set, the default is the nologinlinks option from the theme config.php file,
     * and if that is not set, then links are included.
     * @return string HTML fragment.
     */
    public function login_info($withlinks = null) {
        global $USER, $CFG, $DB, $SESSION;

        if (during_initial_install()) {
            return '';
        }

        if (is_null($withlinks)) {
            $withlinks = empty($this->page->layout_options['nologinlinks']);
        }

        $loginpage = ((string)$this->page->url === get_login_url());
        $course = $this->page->course;
        if (\core\session\manager::is_loggedinas()) {
            $realuser = \core\session\manager::get_realuser();
            $fullname = fullname($realuser, true);
            if ($withlinks) {
                $loginastitle = get_string('loginas');
                $realuserinfo = " [<a href=\"$CFG->wwwroot/course/loginas.php?id=$course->id&amp;sesskey=".sesskey()."\"";
                $realuserinfo .= "title =\"".$loginastitle."\">$fullname</a>] ";
            } else {
                $realuserinfo = " [$fullname] ";
            }
        } else {
            $realuserinfo = '';
        }

        $loginurl = get_login_url();

        if (empty($course->id)) {
            // $course->id is not defined during installation
            return '';
        } else if (isloggedin()) {
            $context = context_course::instance($course->id);

            $fullname = fullname($USER, true);
            // Since Moodle 2.0 this link always goes to the public profile page (not the course profile page)
            if ($withlinks) {
                $linktitle = get_string('viewprofile');
                $username = "<a href=\"$CFG->wwwroot/user/profile.php?id=$USER->id\" title=\"$linktitle\">$fullname</a>";
            } else {
                $username = $fullname;
            }
            if (is_mnet_remote_user($USER) and $idprovider = $DB->get_record('mnet_host', array('id'=>$USER->mnethostid))) {
                if ($withlinks) {
                    $username .= " from <a href=\"{$idprovider->wwwroot}\">{$idprovider->name}</a>";
                } else {
                    $username .= " from {$idprovider->name}";
                }
            }
            if (isguestuser()) {
                $loggedinas = $realuserinfo.get_string('loggedinasguest');
                if (!$loginpage && $withlinks) {
                    $loggedinas .= " (<a href=\"$loginurl\">".get_string('login').'</a>)';
                }
            } else if (is_role_switched($course->id)) { // Has switched roles
                $rolename = '';
                if ($role = $DB->get_record('role', array('id'=>$USER->access['rsw'][$context->path]))) {
                    $rolename = ': '.role_get_name($role, $context);
                }
                $loggedinas = get_string('loggedinas', 'moodle', $username).$rolename;
                if ($withlinks) {
                    $url = new moodle_url('/course/switchrole.php', array('id'=>$course->id,'sesskey'=>sesskey(), 'switchrole'=>0, 'returnurl'=>$this->page->url->out_as_local_url(false)));
                    $loggedinas .= '('.html_writer::tag('a', get_string('switchrolereturn'), array('href'=>$url)).')';
                }
            } else {
                $loggedinas = $realuserinfo.get_string('loggedinas', 'moodle', $username);
                if ($withlinks) {
					echo  "<i class='fa fa-user hide979 mywhite'></i> ";
                    //****************$loggedinas .= " (<a href=\"$CFG->wwwroot/login/logout.php?sesskey=".sesskey()."\">".get_string('logout').'</a>)';
					$loggedinas .= " <span class=\"line-trans\">|</span><a class=\"logtop\" href=\"$CFG->wwwroot/login/logout.php?sesskey=".sesskey()."\"> ".get_string('logout').'</a><span class="line-trans"> |</span>';
                }
            }
        } else {
            $loggedinas = get_string('loggedinnot', 'moodle');
            if (!$loginpage && $withlinks) {
                //****************$loggedinas $loggedinas .= " (<a href=\"$loginurl\">".get_string('login').'</a>)';
				echo  "<i class='fa fa-lock hide979 mywhite'></i> ";
				$loggedinas .= " | <a href=\"$loginurl\">".get_string('login').'</a> |';
            }
        }

        $loggedinas = '<div class="logininfo">'.$loggedinas.'</div>';

        if (isset($SESSION->justloggedin)) {
            unset($SESSION->justloggedin);
            if (!empty($CFG->displayloginfailures)) {
                if (!isguestuser()) {
                    if ($count = count_login_failures($CFG->displayloginfailures, $USER->username, $USER->lastlogin)) {
                        $loggedinas .= '&nbsp;<div class="loginfailures">';
                        if (empty($count->accounts)) {
                            $loggedinas .= get_string('failedloginattempts', '', $count);
                        } else {
                            $loggedinas .= get_string('failedloginattemptsall', '', $count);
                        }
                        if (file_exists("$CFG->dirroot/report/log/index.php") and has_capability('report/log:view', context_system::instance())) {
                            $loggedinas .= ' (<a href="'.$CFG->wwwroot.'/report/log/index.php'.
                                                 '?chooselog=1&amp;id=1&amp;modid=site_errors">'.get_string('logs').'</a>)';
                        }
                        $loggedinas .= '</div>';
                    }
                }
            }
        }

        return $loggedinas;
    }

    /**
     * Internal implementation of user image rendering.
     *
     * @param user_picture $userpicture
     * @return string
     */
    protected function render_user_picture(user_picture $userpicture) {
        $transmuteduserpicture = new theme_warwickclean_transmuted_user_picture($userpicture);
        $userpicture = $transmuteduserpicture;

        global $CFG, $DB;
        $user = $userpicture->user;
        //if ($userpicture->alttext) {
         //   if (!empty($user->imagealt)) {
         //       $alt = $user->imagealt;
         //   } else {
         //       $alt = get_string('pictureof', '', fullname($user));
         //   }
        //} else {
            $alt = '';
        //}

        if (empty($userpicture->size)) {
            $size = 35;
        } else if ($userpicture->size === true or $userpicture->size == 1) {
            $size = 100;
        } else {
            $size = $userpicture->size;
        }
        $class = $userpicture->class;
        if ($user->picture == 0) {
            $class .= ' defaultuserpic';
        }
        $src = $userpicture->get_url($this->page, $this);
        $attributes = array('src'=>$src, 'alt'=>$alt, 'title'=>$alt, 'class'=>$class, 'width'=>$size, 'height'=>$size);
        if (!$userpicture->visibletoscreenreaders) {
            $attributes['role'] = 'presentation';
        }
        // get the image html output fisrt
        $output = html_writer::empty_tag('img', $attributes);
        // will wrap it in link if needed
        if ($userpicture->link) {
            if (empty($userpicture->courseid)) {
                $courseid = $this->page->course->id;
            } else {
                $courseid = $userpicture->courseid;
            }
            if ($courseid == SITEID) {
                $url = new moodle_url('/user/profile.php', array('id' => $user->id));
            } else {
                $url = new moodle_url('/user/view.php', array('id' => $user->id, 'course' => $courseid));
            }
            $attributes = array('href'=>$url);
            if (!$userpicture->visibletoscreenreaders) {
                $attributes['tabindex'] = '-1';
                $attributes['aria-hidden'] = 'true';
            }
            if ($userpicture->popup) {
                $id = html_writer::random_id('userpicture');
                $attributes['id'] = $id;
                $this->add_action_handler(new popup_action('click', $url), $id);
            }
        }
        /** POP OVER BOX **/
        //Get url for larger picture size.
        $userpicture->size = true;// true, 1 and 100 are the same. New size will be 100x100
        $src = $userpicture->get_url($this->page, $this);

        // Is the user a member of staff
        // need the next two lines to obtain all user fields; they are not present in the 'normal' $user variable
        $ID = $user->id;
        $user = $DB->get_record('user', array('id'=>"$ID"));
        $universityId = $user->idnumber;
        // Remove department code if any
        if (preg_match('/([a-zA-Z]{2}\d+)/', $universityId, $matches)) {
            $universityId = substr($universityId,2);
        }

        // Build the popover content
        $title = "<i class='fa fa-user fa-lg greypro-icon'></i> <span class='warmoo-pro-pop-stress-main'>$user->firstname $user->lastname</span>";
        $dataContent .= "<div class='warmoo-pro-pop-pic userpicture'>";
        $dataContent .= "<img src='$src' alt='Picture of $user->firstname $user->lastname' title='Picture of $user->firstname $user->lastname' width='90' height='90'>";
        $dataContent .= "</div>";
        $dataContent .= "<div><ul class='warmoo-pro-po-lister'>";
        $dataContent .= "<li><span class='warmoo-pro-pop-label'>Preferred Name: </span><span class='warmoo-pro-pop-stress'>$user->firstname $user->lastname</span></li>";
        $dataContent .= "<li><span class='warmoo-pro-pop-label'>User ID: </span><span class='warmoo-pro-pop-stress'>$user->idnumber</span></li>";
        $dataContent .= "<li><a  class='btn btn-moo-blue tab-prof-but' href='https://tabula.warwick.ac.uk/profiles/view/" . $universityId . "' target='_blank' role='button'>";
        $dataContent .= "<i class='fa fa-external-link-square'></i> Tabula Profile</a></li>";
        $dataContent .= "</ul>";
        
        // Add popover attributes
        $attributes2 = array('tabindex'=>0, 'data-toggle'=>'popover', 'data-content'=>$dataContent, 'title'=>$title); 
        // the following attributes seem to break the rollover box and have been taken out of $attributes2:
        //'role'=>'button', 'class'=>'btn btn-lg btn-default', 'data-container'=>'#warmoo-pro-pop', 
        
        // CHECK IF IMAGE SHOULD BE AN HYPERLINK
        if ($userpicture->link) $attributes = array_merge($attributes, $attributes2); //if it's a link $attributes has been pre-filled
        else $attributes = $attributes2;

        // Render the entire thing and return
        $tmp_output = html_writer::tag('a', $output, $attributes); //write the <a> tag
        $div_attributes = array('id'=>'warmoo-pro-pop'); // prepare the attributes of the div tag
        $rendered_user_picture = html_writer::tag('div', $tmp_output, $div_attributes); // surround the <a> tag with a <div> tag
        return $rendered_user_picture;
    }

}

