<?php
/********** Remove wp logo ***********/

// I dont think i need this function as we are using custom logo
function annointed_admin_bar_remove() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
}
//add_action('wp_before_admin_bar_render', 'annointed_admin_bar_remove', 0);


/********** Create admin logo 20 X 20px***********/

function custom_admin_logo() {
  $dsh_logo = get_option('dsh_logo');
  if($dsh_logo):
  echo 
  '<style type="text/css">
  #wp-admin-bar-wp-logo > .ab-item .ab-icon { 
  	background-image: url('.get_option('dsh_logo').') !important;
  	width:20px!important; 
  	height:20px!important;
  	background-position: 0 0;
  }
  
  #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
	background-position: 0 0;
	}
  </style>';
  else:
  	echo 
  '<style type="text/css">
  #wp-admin-bar-wp-logo > .ab-item .ab-icon { 
  	background-image: url('.get_bloginfo('stylesheet_directory') . '/images/admin/admin-logo.png) !important;
  	width:20px!important; 
  	height:20px!important;
  	background-position: 0 0;
  }
  
  #wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
	background-position: 0 0;
	}
  </style>';
  endif;
}
add_action('admin_head', 'custom_admin_logo');


/********** Hide wordpress update version message ***********/

//add_action('admin_menu','wphidenag');
function wphidenag() {
remove_action( 'admin_notices', 'update_nag', 3 );
}


/********** Change footer text ***********/

function remove_footer_admin () {
  $dashboard_footer_text = get_option('dashboard_footer_text');
  if($dashboard_footer_text):
  	echo '&copy; 2014 '.$dashboard_footer_text.' ';
  else:
  	echo '&copy; 2014 Company Name: to change this please go to Appearance->options->dashboard->footer text';
  endif;
}
add_filter('admin_footer_text', 'remove_footer_admin');


/********** Remove Page attributes meta box ***********/

//add_action( 'admin_menu', 'remove_meta_boxes' );
function remove_meta_boxes() {
	remove_meta_box( 'pageparentdiv', 'page', 'side' ); // Page attributes meta box
}

/********** REMOVE META BOXES FROM WORDPRESS DASHBOARD FOR ALL USERS ***********/

add_action('wp_dashboard_setup', 'example_remove_dashboard_widgets' ); 
function example_remove_dashboard_widgets()
{
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;
     
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}


/********** disable default dashboard widgets ***********/

add_action('admin_menu', 'disable_default_dashboard_widgets');
function disable_default_dashboard_widgets() {

	remove_meta_box('dashboard_right_now', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_comments', 'dashboard', 'core');
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'core');
	remove_meta_box('dashboard_plugins', 'dashboard', 'core');

	remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
	remove_meta_box('dashboard_recent_drafts', 'dashboard', 'core');
	remove_meta_box('dashboard_primary', 'dashboard', 'core');
	remove_meta_box('dashboard_secondary', 'dashboard', 'core');
}


/* = Header - Removing header items
-------------------------------------------------------------- */
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);



/* = Dashboard Widget - Welcome Message 
-------------------------------------------------------------- */
function welcome_dashboard_widget_function() {
	$dashboard_text = get_option('dashboard_text');
	$default_text = 'To change above text please go to Appearance->options->dashboard->descriptions';
	if($dashboard_text):
		echo '<p> '.$dashboard_text.' </p>';
	else:
		echo '<p>Welcome to '.get_bloginfo('title').' </p>';
		echo '<p>'.$default_text.'</p>';
	endif;
} 

function welcome_add_dashboard_widgets() {
	$dashboard_title= get_option('dashboard_title');
	$default_text = 'To change this text please go to Appearance->options->dashboard->title';
	if($dashboard_title):
		wp_add_dashboard_widget('welcome_dashboard_widget', $dashboard_title, 'welcome_dashboard_widget_function');
	else:
		wp_add_dashboard_widget('welcome_dashboard_widget', $default_text, 'welcome_dashboard_widget_function');
	endif;
}
add_action('wp_dashboard_setup', 'welcome_add_dashboard_widgets' );



/* = Dashboard Developer Support Link
-------------------------------------------------------------- */
function manual_dashboard_widget_function() {
	$dev_url = "https://www.odesk.com/users/~0173a11de60c8f353e";
	echo '<h2>General Information</h2>';
	echo '<ul>
	<li>Release Date: NA</li>
	<li>Developer: Zakir Sajib.</li>
	<li>Developer url: <a href=" '.$dev_url.' " target="_blank">Zakir Sajib</a></li>
	</ul>';
	
	echo '<h2>Developer support</h2>';
	echo '<p>If you have any additional questions or problems then please contact our <a href="mailto:zakirsajib@gmail.com">support team.</a>';
} 

function manual_add_dashboard_widgets() {
	wp_add_dashboard_widget('manual_dashboard_widget', 'Help and Support', 'manual_dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'manual_add_dashboard_widgets' );


/********** replace WordPress Howdy in WordPress 3.3 ***********/

function replace_howdy( $wp_admin_bar ) {
    $my_account=$wp_admin_bar->get_node('my-account');
    $newtitle = str_replace( 'Howdy,', 'Logged in as', $my_account->title );            
    $wp_admin_bar->add_node( array(
        'id' => 'my-account',
        'title' => $newtitle,
    ) );
}
add_filter( 'admin_bar_menu', 'replace_howdy',25 );
?>