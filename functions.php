<?php
define ("THEMENAME", "nakedTheme");



// Theme options
function admin_set(){
		wp_enqueue_style( 'jqueryui', get_template_directory_uri() . '/templ/css/jquery-ui.css' , false, '1.0');
		wp_enqueue_style( 'theme_options_css', get_template_directory_uri() . '/templ/css/theme-options.css', false, '1.0' );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		
		wp_register_script( 'custom-tabs', get_template_directory_uri() . '/templ/js/custom-tabs.js', array('jquery'), false );
		wp_enqueue_script( 'custom-tabs' );
}

add_action('admin_head', 'admin_set');





$current_path= dirname(__FILE__);
//require_once ($current_path. '/wpbakery/js_composer/js_composer.php');
require_once($current_path. '/theme-options.php'); // Theme options
require_once($current_path. '/dashboard/dashboard-options.php'); // Dashboard options
require_once($current_path. '/login/login-options.php'); // Login options





/********** Sets up the content width value based on the theme's design and stylesheet. ***********/
if ( ! isset( $content_width ) )
$content_width = 1000;



/********** Register themes Stylesheet ***********/
function default_theme_styles() {
	global $wp_styles;
	
	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'default-theme-style', get_stylesheet_uri() );
	
}
add_action( 'wp_enqueue_scripts', 'default_theme_styles' );




/********** Register WP thickbox ***********/

function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	
	// favicon
	wp_register_script('btn-one', get_template_directory_uri(). '/js/btn-one.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('btn-one');
	
	//logo
	wp_register_script('btn-two', get_template_directory_uri(). '/js/btn-two.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('btn-two');
}

function my_admin_styles() {
	wp_enqueue_style('thickbox');
}

if (isset($_GET['page']) == 'theme_option') {
	add_action('admin_print_scripts', 'my_admin_scripts');
	add_action('admin_print_styles', 'my_admin_styles');
}



/********** Favicon ***********/
add_action( 'wp_head', 'ilc_favicon');
function ilc_favicon(){
    if(get_option('favicon_1')):
    echo "<link rel='shortcut icon' href='" . get_option('favicon') . "' />" . "\n";
    else:
    echo "<link rel='shortcut icon' href='#' />" . "\n";
    endif;
}



/********** Color Picker ***********/

add_action( 'admin_enqueue_scripts', 'wp_enqueue_color_picker' );
function wp_enqueue_color_picker( ) {
    
     //Access the global $wp_version variable to see which version of WordPress is installed.
    global $wp_version;
    
    //If the WordPress version is greater than or equal to 3.5, then load the new WordPress color picker.
    if ( 3.5 <= $wp_version ){
    	//Both the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
    	wp_enqueue_style( 'wp-color-picker' );
    	wp_enqueue_script( 'wp-color-picker' );
    }else{
        //As with wp-color-picker the necessary css and javascript have been registered already by WordPress, so all we have to do is load them with their handle.
    	wp_enqueue_style( 'farbtastic' );
        wp_enqueue_script( 'farbtastic' );
    }
    //Load our custom javascript file
    wp_enqueue_script( 'wp-color-picker-script', get_template_directory_uri() . '/js/colorpicker.js', array( 'wp-color-picker' ), false, true ); 
}



class backup_restore_theme_options {

	function backup_restore_theme_options() {
		add_action('admin_menu', array(&$this, 'admin_menu'));
	}
	function admin_menu() {
		// add_submenu_page($parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function);
		// $page = add_submenu_page('themes.php', 'Backup Options', 'Backup Options', 'manage_options', 'backup-options', array(&$this, 'options_page'));

		// add_theme_page($page_title, $menu_title, $capability, $menu_slug, $function);
		$page = add_theme_page('Backup Options', 'Backup Options', 'manage_options', 'backup-options', array(&$this, 'options_page'));

		add_action("load-{$page}", array(&$this, 'import_export'));
	}
	function import_export() {
		if (isset($_GET['action']) && ($_GET['action'] == 'download')) {
			header("Cache-Control: public, must-revalidate");
			header("Pragma: hack");
			header("Content-Type: text/plain");
			header('Content-Disposition: attachment; filename="theme-options-'.date("dMy").'.dat"');
			echo serialize($this->_get_options());
			die();
		}
		if (isset($_POST['upload']) && check_admin_referer('shapeSpace_restoreOptions', 'shapeSpace_restoreOptions')) {
			if ($_FILES["file"]["error"] > 0) {
				// error
			} else {
				$options = unserialize(file_get_contents($_FILES["file"]["tmp_name"]));
				if ($options) {
					foreach ($options as $option) {
						update_option($option->option_name, unserialize($option->option_value));
					}
				}
			}
			wp_redirect(admin_url('themes.php?page=backup-options'));
			exit;
		}
	}
	function options_page() { ?>

		<div class="wrap">
			<?php screen_icon(); ?>
			<h2>Backup/Restore Theme Options</h2>
			<form action="" method="POST" enctype="multipart/form-data">
				<style>#backup-options td { display: block; margin-bottom: 20px; }</style>
				<table id="backup-options">
					<tr>
						<td>
							<h3>Backup/Export</h3>
							<p>Here are the stored settings for the current theme:</p>
							<p><textarea class="widefat code" rows="20" cols="100" onclick="this.select()"><?php echo serialize($this->_get_options()); ?></textarea></p>
							<p><a href="?page=backup-options&action=download" class="button-secondary">Download as file</a></p>
						</td>
						<td>
							<h3>Restore/Import</h3>
							<p><label class="description" for="upload">Restore a previous backup</label></p>
							<p><input type="file" name="file" /> <input type="submit" name="upload" id="upload" class="button-primary" value="Upload file" /></p>
							<?php if (function_exists('wp_nonce_field')) wp_nonce_field('shapeSpace_restoreOptions', 'shapeSpace_restoreOptions'); ?>
						</td>
					</tr>
				</table>
			</form>
		</div>

	<?php }
	function _display_options() {
		$options = unserialize($this->_get_options());
	}
	
	function _get_options() {
		global $wpdb;
		return $wpdb->get_results("SELECT option_name, option_value FROM {$wpdb->options} WHERE option_name = 'theme_option'"); // edit 'shapeSpace_options' to match theme options
	}
}
new backup_restore_theme_options();


/**
 * Return default array of options
 */
/*
function wt_default_options() {
	$options = array(
		'wt_logo_url' => get_template_directory_uri().'/images/logo.png',	
		'wt_favicon' => '',
		'wt_apple_touch' => '',
		'wt_rss_url' => '',
		'wt_twitter_url' => '',
		'wt_fb_url' => '',
		'wt_contact_url' => '',
		'wt_contact_email' => '',	
		'wt_contact_subject' => '',	
		'wt_header_top' => 1,			
		'wt_show_carousel' => 1,
		'wt_carousel_category' => 0,
		'wt_show_slider' => 1,		
		'wt_slider_category' => 0,
		'wt_show_sf_cats' => 1,
		'wt_sf_cat1' => 0,
		'wt_sf_cat2' => 0,
		'wt_feat_cat1' => 0,
		'wt_feat_cat2' => 0,
		'wt_feat_cat3' => 0,
		'wt_feat_cat4' => 0,
		'wt_feat_cat5' => 0,
		'wt_show_feat_gallery' => 1,	
		'wt_gallery_category' => 0,		
		'wt_show_other_posts' => 1,
		'wt_show_author_info' => 1,
		'wt_show_related_posts' => 1,
		'wt_show_post_social' => 1,	
		'wt_show_page_author_info' => 0,		
		'wt_show_page_meta' => 0,	
		'wt_show_page_comments' => 1,
		'wt_show_page_social' => 1,
		'wt_show_img_meta' => 1,
		'wt_show_img_comments' => 1,
		'wt_show_img_social' => 1,
		'wt_show_archive_cat_info' => 1,
		'wt_show_archive_tag_info' => 1,
		'wt_show_archive_author_info' => 1,
		'wt_bg_img' => 0,		
		'wt_custom_bg' => '',	
		'wt_bg_color' => '',
		'wt_primary_color' => '',	
		'wt_second_color' => '',		
		'wt_h1_fontsize' => '',
		'wt_h2_fontsize' => '',
		'wt_h3_fontsize' => '',	
		'wt_h4_fontsize' => '',	
		'wt_h5_fontsize' => '',	
		'wt_h6_fontsize' => '',	
		'wt_text_fontsize' => '',	
		'wt_h1_fontstyle' => '',
		'wt_h2_fontstyle' => '',
		'wt_h3_fontstyle' => '',
		'wt_h4_fontstyle' => '',
		'wt_h5_fontstyle' => '',
		'wt_h6_fontstyle' => '',	
		'wt_text_fontstyle' => '',
		'wt_h1_lineheight' => '',
		'wt_h2_lineheight' => '',
		'wt_h3_lineheight' => '',
		'wt_h4_lineheight' => '',
		'wt_h5_lineheight' => '',
		'wt_h6_lineheight' => '',
		'wt_text_lineheight' => '',
		'wt_h1_marginbottom' => '',	
		'wt_h2_marginbottom' => '',	
		'wt_h3_marginbottom' => '',	
		'wt_h4_marginbottom' => '',	
		'wt_h5_marginbottom' => '',	
		'wt_h6_marginbottom' => '',	
		'wt_text_font_name' => '',
		'wt_headings_font_name' => '',
		'wt_headings_color' => '',	
		'wt_text_color' => '',
		'wt_links_color' => '',
		'wt_links_hover_color' => '',		
		'wt_footer_headings_color' => '',
		'wt_footer_text_color' => '',			
		'wt_custom_css' => '',
		'wt_meta_keywords' => '',
		'wt_meta_description' => '',
		'wt_google_verification' => '',
		'wt_bing_verification' => '',	
		'wt_header_ad468' => '<a href='.get_site_url().'><img src='.get_template_directory_uri().'/images/ad468.png /></a>',
		'wt_header_code' => '',
		'wt_header_tagline' => get_bloginfo('description'),
		'wt_footer_text_left' => '&copy;'. date('Y') . ' '. get_bloginfo('name'),
		'wt_footer_text_right' => 'Designed by <a href="http://wellthemes.com">WellThemes.com</a>',
		'wt_footer_code' => ''		
	);
	return $options;
}
*/
/**
 * Sanitize and validate options
 */
/*
function wt_validate_options( $input ) {
	$submit = ( ! empty( $input['submit'] ) ? true : false );
	$reset = ( ! empty( $input['reset'] ) ? true : false );
	if( $submit ) :	
		
		$input['wt_logo_url'] = esc_url_raw($input['wt_logo_url']);
		$input['wt_favicon'] = esc_url_raw($input['wt_favicon']);
		$input['wt_apple_touch'] = esc_url_raw($input['wt_apple_touch']);		
		$input['wt_custom_bg'] = esc_url_raw($input['wt_custom_bg']);
		$input['wt_rss_url'] = esc_url_raw($input['wt_rss_url']);
		$input['wt_twitter_url'] = esc_url_raw($input['wt_twitter_url']);
		$input['wt_fb_url'] = esc_url_raw($input['wt_fb_url']);
		$input['wt_contact_url'] = esc_url_raw($input['wt_contact_url']);
		$input['wt_contact_email'] = wp_filter_nohtml_kses($input['wt_contact_email']);
		$input['wt_contact_subject'] = wp_kses_stripslashes($input['wt_contact_subject']);
		$input['wt_text_color'] = wp_filter_nohtml_kses($input['wt_text_color']);
		$input['wt_links_hover_color'] = wp_filter_nohtml_kses($input['wt_links_hover_color']);
		$input['wt_footer_headings_color'] = wp_filter_nohtml_kses($input['wt_footer_headings_color']);
		$input['wt_footer_text_color'] = wp_filter_nohtml_kses($input['wt_footer_text_color']);			
		$input['wt_bg_color'] = wp_filter_nohtml_kses($input['wt_bg_color']);
		$input['wt_primary_color'] = wp_filter_nohtml_kses($input['wt_primary_color']);	
		$input['wt_second_color'] = wp_filter_nohtml_kses($input['wt_second_color']);			
		$input['wt_custom_css'] = wp_kses_stripslashes($input['wt_custom_css']);
		$input['wt_meta_keywords'] = wp_filter_post_kses($input['wt_meta_keywords']);
		$input['wt_meta_description'] = wp_filter_post_kses($input['wt_meta_description']);
		$input['wt_google_verification'] = wp_filter_post_kses($input['wt_google_verification']);
		$input['wt_bing_verification'] = wp_filter_post_kses($input['wt_bing_verification']);
		$input['wt_header_ad468'] = wp_kses_stripslashes($input['wt_header_ad468']);
		$input['wt_header_code'] = wp_kses_stripslashes($input['wt_header_code']);
		$input['wt_header_tagline'] = wp_kses_stripslashes($input['wt_header_tagline']);
		$input['wt_footer_text_left'] = wp_kses_stripslashes($input['wt_footer_text_left']);
		$input['wt_footer_text_right'] = wp_kses_stripslashes($input['wt_footer_text_right']);
		$input['wt_footer_code'] = wp_kses_stripslashes($input['wt_footer_code']);
		
		if ( ! isset( $input['wt_header_top'] ) )
			$input['wt_header_top'] = null;
		$input['wt_header_top'] = ( $input['wt_header_top'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_slider'] ) )
			$input['wt_show_slider'] = null;
		$input['wt_show_slider'] = ( $input['wt_show_slider'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['wt_show_sf_cats'] ) )
			$input['wt_show_sf_cats'] = null;
		$input['wt_show_sf_cats'] = ( $input['wt_show_sf_cats'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['wt_show_carousel'] ) )
			$input['wt_show_carousel'] = null;
		$input['wt_show_carousel'] = ( $input['wt_show_carousel'] == 1 ? 1 : 0 );

		if ( ! isset( $input['wt_show_feat_gallery'] ) )
			$input['wt_show_feat_gallery'] = null;
		$input['wt_show_feat_gallery'] = ( $input['wt_show_feat_gallery'] == 1 ? 1 : 0 );		
		
		if ( ! isset( $input['wt_show_other_posts'] ) )
			$input['wt_show_other_posts'] = null;
		$input['wt_show_other_posts'] = ( $input['wt_show_other_posts'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_author_info'] ) )
			$input['wt_show_author_info'] = null;
		$input['wt_show_author_info'] = ( $input['wt_show_author_info'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_related_posts'] ) )
			$input['wt_show_related_posts'] = null;
		$input['wt_show_related_posts'] = ( $input['wt_show_related_posts'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_post_social'] ) )
			$input['wt_show_post_social'] = null;
		$input['wt_show_post_social'] = ( $input['wt_show_post_social'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_page_author_info'] ) )
			$input['wt_show_page_author_info'] = null;
		$input['wt_show_page_author_info'] = ( $input['wt_show_page_author_info'] == 1 ? 1 : 0 );	
				
		if ( ! isset( $input['wt_show_page_meta'] ) )
			$input['wt_show_page_meta'] = null;
		$input['wt_show_page_meta'] = ( $input['wt_show_page_meta'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_page_comments'] ) )
			$input['wt_show_page_comments'] = null;
		$input['wt_show_page_comments'] = ( $input['wt_show_page_comments'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_page_social'] ) )
			$input['wt_show_page_social'] = null;
		$input['wt_show_page_social'] = ( $input['wt_show_page_social'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_img_meta'] ) )
			$input['wt_show_img_meta'] = null;
		$input['wt_show_img_meta'] = ( $input['wt_show_img_meta'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_img_comments'] ) )
			$input['wt_show_img_comments'] = null;
		$input['wt_show_img_comments'] = ( $input['wt_show_img_comments'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_img_social'] ) )
			$input['wt_show_img_social'] = null;
		$input['wt_show_img_social'] = ( $input['wt_show_img_social'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_archive_cat_info'] ) )
			$input['wt_show_archive_cat_info'] = null;
		$input['wt_show_archive_cat_info'] = ( $input['wt_show_archive_cat_info'] == 1 ? 1 : 0 );	
		
		if ( ! isset( $input['wt_show_archive_tag_info'] ) )
			$input['wt_show_archive_tag_info'] = null;
		$input['wt_show_archive_tag_info'] = ( $input['wt_show_archive_tag_info'] == 1 ? 1 : 0 );
		
		if ( ! isset( $input['wt_show_archive_author_info'] ) )
			$input['wt_show_archive_author_info'] = null;
		$input['wt_show_archive_author_info'] = ( $input['wt_show_archive_author_info'] == 1 ? 1 : 0 );		
		
		$categories = get_categories( array( 'hide_empty' => 0, 'hierarchical' => 0 ) );
		$cat_ids = array();
		foreach( $categories as $category )
			$cat_ids[] = $category->term_id;
						
		if( !in_array( $input['wt_carousel_category'], $cat_ids ) && ( $input['wt_carousel_category'] != 0 ) )
			$input['wt_carousel_category'] = $options['wt_carousel_category'];
			
		if( !in_array( $input['wt_slider_category'], $cat_ids ) && ( $input['wt_slider_category'] != 0 ) )
			$input['wt_slider_category'] = $options['wt_slider_category'];
		
		if( !in_array( $input['wt_sf_cat1'], $cat_ids ) && ( $input['wt_sf_cat1'] != 0 ) )
			$input['wt_sf_cat1'] = $options['wt_sf_cat1'];
			
		if( !in_array( $input['wt_sf_cat2'], $cat_ids ) && ( $input['wt_sf_cat2'] != 0 ) )
			$input['wt_sf_cat2'] = $options['wt_sf_cat2'];
			
		if( !in_array( $input['wt_feat_cat1'], $cat_ids ) && ( $input['wt_feat_cat1'] != 0 ) )
			$input['wt_feat_cat1'] = $options['wt_feat_cat1'];
			
		if( !in_array( $input['wt_feat_cat2'], $cat_ids ) && ( $input['wt_feat_cat2'] != 0 ) )
			$input['wt_feat_cat2'] = $options['wt_feat_cat2'];
		
		if( !in_array( $input['wt_feat_cat3'], $cat_ids ) && ( $input['wt_feat_cat3'] != 0 ) )
			$input['wt_feat_cat3'] = $options['wt_feat_cat3'];
			
		if( !in_array( $input['wt_feat_cat4'], $cat_ids ) && ( $input['wt_feat_cat4'] != 0 ) )
			$input['wt_feat_cat4'] = $options['wt_feat_cat4'];
			
		if( !in_array( $input['wt_feat_cat5'], $cat_ids ) && ( $input['wt_feat_cat5'] != 0 ) )
			$input['wt_feat_cat5'] = $options['wt_feat_cat5'];
						
		if( !in_array( $input['wt_gallery_category'], $cat_ids ) && ( $input['wt_gallery_category'] != 0 ) )
			$input['wt_gallery_category'] = $options['wt_gallery_category'];			
					
		return $input;
		
	elseif( $reset ) :
		$input = wt_default_options();
		return $input;
		
	endif;
}
*/

?>