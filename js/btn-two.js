jQuery(document).ready(function() {
	
	jQuery('#upload-logo-button').click(function() {
	
		window.send_to_editor = function(html) {
			imgurl = jQuery('img',html).attr('src');
			jQuery('#theme_option\\[logo\\]').val(imgurl);
			tb_remove();
		}
		
		tb_show('Upload Logo Image', 'media-upload.php?post_id=0&type=image&TB_iframe=true');
		return false;
	
	});
	
	
});