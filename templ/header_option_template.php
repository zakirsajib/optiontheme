<div class="section section-favicon " id="section-favicon">
		<h4 class="heading">Upload Favicon</h4>
		<div class="option">
			<div class="controls">
  			   <input type="text" name="theme_option[favicon]" id="theme_option[favicon]" class="fav" value="<?php echo esc_attr($options['favicon']); ?>"/>

  			   <input id="upload-fav-button" class="button upload_btn_favicon" type="button" value="Upload Image" />
  			   <p class="description">Recommended size: 16 X 16 pixels</p>
			
			</div>
		</div>
</div>



<div class="section section-logo " id="section-logo">
		<h4 class="heading">Upload Logo</h4>
		<div class="option">
			<div class="controls">
				<?php $logo_1= esc_attr($options['logo'])?>
  				<?php if($logo_1):?>
  			   		<p class="description">Preview:</p>
  			   		<img class="preview-img" src="<?php echo esc_attr($options['logo']); ?>"/>
  			   	<?php endif;?>
  			   <input type="text" name="theme_option[logo]" id="theme_option[logo]" class="fav" value="<?php echo esc_attr($options['logo'])?>"/>

  			   <input id="upload-logo-button" class="button upload_btn_logo1" type="button" value="Upload Image" />
  			   <p class="description">Recommended size: 100 X 100 pixels</p>
</div>
		</div>
</div>