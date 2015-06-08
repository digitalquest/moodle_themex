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
		// presumes the breadcrumbs doesn't 'contain' a course item:
		// we are not on a course page or in an activity inside a course
		$is_course = false; 
        $items = $this->page->navbar->get_items();
		//go through all the breadcrumbs items
		//if one of them is a course, we are on a course page or in an item/activity that belongs to a course
        foreach ($items as $item) {
            if (!$is_course) { //once one course item is found it's not necessary checking others
                $is_course = (navigation_node::TYPE_COURSE == $item->type);
            }
        }
		//initialise the breadcrumbs array
        $breadcrumbs = array();
		
		//we apply the logic only if we are on a course page or 'below' a course page
		//(i.e. in an activity inside a course or something that belongs to a course)
		if ($is_course) {
			//Only render: last_clickable_item<-parent_course<-parent_category
			//Will only render the 1st parent category, course node and the last node in the breadcrumbs - if any and if clickable ($item->action is not null)
			$last_node_found = false;       //presumes we have not yet found the last item in the breadcrumbs
			$items = array_reverse($items); //reverses the breadcrumbs; the last item becomes the first

			// starts looping through all the items in the breadcrumbs
			foreach ($items as $item) {
			//Only render a category or a course
			//or the last item if it is clickable ($item->action is not null)
				if( ($item->action) && (navigation_node::TYPE_CATEGORY == $item->type || navigation_node::TYPE_COURSE == $item->type || navigation_node::TYPE_SECTION == $item->type ||
					(!$last_node_found) ) ){
					// the first item we process 'states' we have found the last item in the breadcrumbs
					// the breadcrumbs were reversed so the 1st time we enter the foreach loop, we are on the last node 
					// once set to true, last_node_found will always be true
					$last_node_found = true; 
					// hide the image icon on the item						 
					$item->hideicon = true;  
					//render the item; the item is either:
					//the last clickable item, the parent course or the 1st parent category
					$breadcrumbs[] = $item;
					/*$breadcrumbs[] = $this->render($item);*/
				}
				//When we find the firt parent category we stop looping through the items
				if (navigation_node::TYPE_CATEGORY == $item->type) {
					//We're done here. exit the foreach loop
					//We don't show more than one category in the breadcrumbs
					break;
				}
			}
			//put the breadcrumbs back in the correct order
			$breadcrumbs = array_reverse($breadcrumbs);
		}
		else { //we are not on a course page or 'below' a course page
			//render all navigation nodes
            foreach ($items as $item) {
                $item->hideicon = true;
				$breadcrumbs[] = $item;
                /*$breadcrumbs[] = $this->render($item);*/
            }
		}
		
        $divider = '<span class="divider">'.get_separator().'</span>';
		$course_class = get_string('breadcrumbs_course','theme_warwickclean');
        /*$list_items = '<li>'.join(" $divider</li><li>", $breadcrumbs).'</li>';*/
		$list_items = "<li>";
		foreach ($breadcrumbs as $breadcrumb) {
			$list_items .= " $divider</li><li";
			//apply a class to course item
			if ($breadcrumb->type == navigation_node::TYPE_COURSE) $list_items .= " class=\"$course_class\" ";
			$list_items .= ">". $this->render($breadcrumb);
		}
		$list_items .= '</li>';
        $title = '<span class="accesshide">'.get_string('pagepath').'</span>';
        return $title . "<ul class=\"breadcrumb\">$list_items</ul>";
		
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
/*			$branch->add('Arts',new moodle_url('/course/index.php?categoryid=3'));
			$branch->add('Medicine',new moodle_url('/course/index.php?categoryid=31'));
			$branch->add('Science',new moodle_url('/course/index.php?categoryid=50'));
			$branch->add('Social Sciences',new moodle_url('/course/index.php?categoryid=60'));
			$branch->add('Interdisciplinary/Cross-Faculty',new moodle_url('/course/index.php?categoryid=28'));
			$branch->add('Services',new moodle_url('/course/index.php?categoryid=56'));
			$branch->add('Sandbox',new moodle_url('/course/index.php?categoryid=51'));
*/			
			//Builds category list into menu
			require_once($CFG->dirroot.'/course/lib.php');
			$categorytree = get_course_category_tree();
			foreach ($categorytree as $category) {
				$this->add_category_to_custommenu($branch, $category);
			}
			
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
			$branch->add( "My Portfolio", new moodle_url('http://mahara.warwick.ac.uk/'),"mahara_link");
			//$branch->add( "Moodle X", new moodle_url('http://moodlex.warwick.ac.uk/'),"moodle2_link");
			$branch->add( "Start.Warwick", new moodle_url('/'),"start_warwick_link");
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

	protected function add_category_to_custommenu(custom_menu_item $parent, stdClass $category) {
		$branch = $parent->add($category->name, new moodle_url('/course/category.php', array('id' =>  $category->id)));
	//adds subcategories
	/*
		if (!empty($category->categories)) {
			foreach ($category->categories as $subcategory) {
				$this->add_category_to_custommenu($branch, $subcategory);
			}
		}
	*/
	//adds courses
	/*
		if (!empty($category->courses)) {
			foreach ($category->courses as $course) {
				$branch->add($course->shortname, new moodle_url('/course/view.php', array('id' => $course->id)), $course->fullname);
			}
		}
	*/
	}
	
	  /**
     ************ OVERRIDE Output Renderes ************ implementation of user image rendering.
     *
     * @param user_picture $userpicture
     * @return string
     */
    protected function render_user_picture(user_picture $userpicture) {
        global $CFG, $DB;

        $user = $userpicture->user;

        if ($userpicture->alttext) {
            if (!empty($user->imagealt)) {
                $alt = $user->imagealt;
            } else {
                $alt = get_string('pictureof', '', fullname($user)." "."Rich");
            }
        } else {
            $alt = '';
        }

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

        // get the image html output fisrt
        $output = html_writer::empty_tag('img', $attributes);

        // then wrap it in link if needed
        if (!$userpicture->link) {
            return $output;
        }

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

        if ($userpicture->popup) {
            $id = html_writer::random_id('userpicture');
            $attributes['id'] = $id;
            $this->add_action_handler(new popup_action('click', $url), $id);
        }

        return html_writer::tag('a', $output, $attributes);
    }

	
}

