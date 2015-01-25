<!--
<div class="section section-backup " id="section-backup">
		<h4 class="heading">Backup/Export</h4>
		<div class="option">
			<div class="controls">
				<p class="description">Here are the stored settings for the current theme:</p>
				<textarea name="backup_restore" cols="60" rows="10"><?php echo get_option('backup_restore');?></textarea>
				<p><a href="?page=backup-options&action=download" class="button-secondary">Download as file</a></p>
			</div>
		</div>
</div>

<div class="section section-restore " id="section-restore">
		<h4 class="heading">Restore/Import</h4>
		<div class="option">
			<div class="controls">
				<p><label class="description" for="upload">Restore a previous backup</label></p>
				<p><input type="file" name="file" /> <input type="submit" name="upload" id="upload" class="button-primary" value="Upload file" /></p>
			</div>
		</div>
</div>
-->




			<form action="" method="POST" enctype="multipart/form-data">
				<style>#backup-options td { display: block; margin-bottom: 20px; }</style>
				<table id="backup-options">
					<tr>
						<td>
							<h3>Backup/Export</h3>
							<p>Here are the stored settings for the current theme:</p>
							<p><textarea class="widefat code" rows="20" cols="100" onclick="this.select()"><?php echo serialize(_get_options()); ?></textarea></p>
							<p><a href="?page=theme-option&action=download" class="button-secondary">Download as file</a></p>
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
