<table class="form-table">
		<tr valign="top">
    		 <th scope="row">Font size</th> 		 		
		<td>
			 <p class="description"></p>
			 <?php if(get_option('theme_font_size')):?>	 	
			<input type="text" name="theme_font_size" class="fav-fontfield" value="<?php echo get_option('theme_font_size');?>"/>
			<?php else:?>
				<input type="text" name="theme_font_size" class="fav-fontfield" value="100%"/>
			<?php endif;?>
			<p class="description">Default font is 14px</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Body copy color</th> 		 		
		<td>
			 <input type="text" name="body-color" value="<?php echo get_option('body-color');?>" class="wp-color-picker-field" data-default-color="#333333" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		
</table>

<hr>

<table class="form-table">		
		
		<tr valign="top">
    		 <th scope="row">Link Color</th> 		 		
		<td>
			 <input type="text" name="link-color" value="<?php echo get_option('link-color');?>" class="wp-color-picker-field" data-default-color="#8BC53F" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Link:hover Color</th> 		 		
		<td>
			 <input type="text" name="link-hover-color" value="<?php echo get_option('link-hover-color');?>" class="wp-color-picker-field" data-default-color="#0f3647" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Link:active Color</th> 		 		
		<td>
			 <input type="text" name="link-active-color" value="<?php echo get_option('link-active-color');?>" class="wp-color-picker-field" data-default-color="#000000" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
</table>


<hr>

<table class="form-table">		
		
		<tr valign="top">
    		 <th scope="row">Nav item color</th> 		 		
		<td>
			 <input type="text" name="nav-color" value="<?php echo get_option('nav-color');?>" class="wp-color-picker-field" data-default-color="#999999" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Nav:hover Color</th> 		 		
		<td>
			 <input type="text" name="nav-hover-color" value="<?php echo get_option('nav-hover-color');?>" class="wp-color-picker-field" data-default-color="#ffffff" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Current page active Color</th> 		 		
		<td>
			 <input type="text" name="nav-active-color" value="<?php echo get_option('nav-active-color');?>" class="wp-color-picker-field" data-default-color="#FFFFFF" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Nav background Color</th> 		 		
		<td>
			 <input type="text" name="nav-bg-color" value="<?php echo get_option('nav-bg-color');?>" class="wp-color-picker-field" data-default-color="#1B1B1B" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Sub-menu item Color</th> 		 		
		<td>
			 <input type="text" name="sub-menu-color" value="<?php echo get_option('sub-menu-color');?>" class="wp-color-picker-field" data-default-color="#ffffff" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
		<tr valign="top">
    		 <th scope="row">Sub-menu hover Color</th> 		 		
		<td>
			 <input type="text" name="sub-menu-hover" value="<?php echo get_option('sub-menu-hover');?>" class="wp-color-picker-field" data-default-color="#ffffff" />
			<p class="description">Default used if no color is selected</p>
		</td>
		</tr>
		
</table>



