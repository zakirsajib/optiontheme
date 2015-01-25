<?php

/********** Change the URL ***********/

function change_wp_login_url() {
	return home_url();
}
add_filter('login_headerurl', 'change_wp_login_url');


/********** Change the Title ***********/

function change_wp_login_title() {
	return get_option('blogname');
}
//add_filter('login_headertitle', 'change_wp_login_title');






/********** Custom stylesheet ***********/
function custom_login_style() {
	echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/login/login.css" />';
}

add_action('login_head', 'custom_login_style');



/********** Custom login logo according to site's logo ***********/
function custom_login_logo() {
	
	//logo
	$login_logo = get_option('login_logo');
	if($login_logo):
		echo '<style>h1 a { background: url(' .get_option('login_logo').') 50% 50% no-repeat !important; height:84px!important; width:333px!important; }</style>';
	endif;
}
add_action('login_head', 'custom_login_logo');






/********** Custom login background ***********/
function custom_login_bg() {		
	//background logo
	$login_bg_logo = get_option('login_bg');
	if($login_bg_logo):
		echo '<style>
		body.login {
			background:url('.get_option('login_bg').');
			background-size: 100%;
			background-attachment: fixed;
		}
		</style>';
	endif;
}
add_action('login_head', 'custom_login_bg');
?>