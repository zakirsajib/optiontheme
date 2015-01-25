<?php

// create custom plugin settings menu
add_action('admin_menu', 'theme_create_menu');
function theme_create_menu() {
	//create new top-level menu
	add_theme_page('Theme Settings', 'Options', 'administrator', 'theme_option', 'theme_settings_page', 6);
}

//call register settings function
add_action( 'admin_init', 'register_settings' );
function register_settings(){
	register_setting( 'theme_option', 'theme_option' );
}


function theme_settings_page() {
?>

<div class="wrap">
<?php settings_errors(); ?>
	<div id="header">
		<div class="logo">
			<h3>Theme Name</h3>
			<span>v1.0.0</span>
		</div>
		
		<div id="icon-themes" class="icon32"></div>
		<div class="clear"></div>
	</div>
	
	
		<div id="tabs">
			<ul> 
				<li class="headeroptions"><a href="#tabs-1">Header</a></li>
	            <li><a href="#tabs-2">Social</a></li>
		        <li><a href="#tabs-3">Footer</a></li>
		        <li><a href="#tabs-4">Google Analytics</a> </li>
		        <li><a href="#tabs-5">CSS</a></li>
		        <li><a href="#tabs-6">Custom CSS</a></li>
		        <li><a href="#tabs-7">Reset</a></li>
		        <!-- <li><a href="#tabs-9">Backup Options</a></li> -->
            </ul>
        	
        	
        	<div class="options-form">
        		<form class="form" method="post" action="options.php">
        			<?php $current_path= dirname(__FILE__);?>
        			<?php settings_fields( 'theme_option' ); ?>
        			
        				<?php $options = get_option('theme_option'); ?>
        			        		
				    	<div id="tabs-1" class="tab_block">
				            <?php include_once ($current_path. '/templ/header_option_template.php');?>
				            <div class="clear"></div>
				    	</div>
				    	
				    	<div id="tabs-2" class="tab_block">
							<?php include_once ($current_path. '/templ/social_option_template.php');?>
				    	</div>
				    	
				    	<div id="tabs-3" class="tab_block">
				            	<?php include_once ($current_path. '/templ/footer_option_template.php');?>
				    	</div>
				    	
				    	<div id="tabs-4" class="tab_block">
				    		<?php include_once ($current_path. '/templ/ganalytics_option_template.php');?>
				    	</div>
				    	<div id="tabs-5" class="tab_block">
				    		<?php include_once ($current_path. '/templ/css_option_template.php');?>
				    	</div>
				    	<div id="tabs-6" class="tab_block">
				    		<?php include_once ($current_path. '/templ/customcss_option_template.php');?>
				    	</div>
				    	<div id="tabs-7" class="tab_block">
				            	<?php include_once ($current_path. '/templ/reset_option_template.php');?>
				    	</div>
				    	<!-- <div id="tabs-9"> -->
				            	<?//php get_template_part('templ/backup_option_template');?>
				    	<!-- </div> -->
				         
			</div> <!-- /options-form -->
		</div>  <!-- end tabs -->
		
		<div class="options-footer">
			<?php submit_button(); ?>
		</div>
			
		</form>
		
</div> <!-- end wrap -->
<?php } // end theme_settings_page ?>