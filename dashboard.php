<?php
function odudecard_dashboard()
{
	?>
	<div class="wrap">
		<h2>ODude Ecard Dashboard</h2>

		All Ecard images will be posted at <a href="https://wordpress.org/plugins/wp-upg/" target="_blank">UPG plugin</a>.
		<br>
		<?php
			if (is_plugin_active('wp-upg/wp-upg.php')) {
				?>
			<br><br>
			[ <a href="<?php echo admin_url('edit.php?post_type=upg'); ?>" class="button button-primary">View Ecard</a> | <a href="<?php echo admin_url('post-new.php?post_type=upg'); ?>" class="button button-primary">Add new Ecard</a> ] @ UPG Plugin
			<br>
		<?php
			} else {
				?>
			<br>
			Download and install <br><a href="<?php echo admin_url("plugin-install.php?tab=plugin-information&plugin=wp-upg"); ?>" target="_blank" class="button button-primary">UPG (User Post Gallery)</a> <br>before any use.

		<?php
			}

			?>



		<br><br>
		<b>Step 1:</b><br>
		At UPG Basic-Settings -> Preview-Settings, set <b>Preview/Media Template as :</b> ecard layout
		<br><br>
		<b>Step 2:</b><br>
		At UPG List, Confirm the post or ecard is set as <b>UPG Preview Template: ecard layout</b> & <b>Ecard Theme: basic layout</b>. <br>UPG post will be dynamically converted into ecard.
		<br>
		<br>
		<b>Notice</b>: For older version 1.4.4 and before, all ecard posted need to be re-uploaded at UPG plugin. You can copy old images from media manager. <br>
		If you are happy with older version, <a href="https://wordpress.org/plugins/odude-ecard/advanced/">download</a> and overwrite all the files via FTP but don't upgrade it. No support will be given for older version.<br>
		<a href="<?php echo admin_url('edit.php?post_type=odudecard'); ?>">You can access your old ecard.</a>


	</div>
<?php
}

?>