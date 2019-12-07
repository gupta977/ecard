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
		<b>Notice</b>: 3 pages are created automatically after activation. This page can be used if you want users to upload ecard of their choice.
		<br>
		<hr>
		<b>1- Post Ecard Image</b><br>
		<code>
			[upg-form class="pure-form pure-form-stacked" title="Post Ecard Image" name="my_ecard_image" taxonomy="upg_cate" tag_taxonomy="upg_tag" preview="ecard"]<br>
			[upg-form-tag type="post_title" title="Image Title" value="" placeholder="main title"]<br>
			[upg-form-tag type="category" title="Select category" taxonomy="upg_cate" filter="image"]<br>
			[upg-form-tag type="tag" title="Insert tag"]<br>
			[upg-form-tag type="file" title="Select file" required="true"]<br>
			[upg-form-tag type="submit" name="submit" value="Upload"]<br>
			[/upg-form]<br>
		</code>
		<hr>
		<b>2- Post Video Ecard URL</b><br>
		<code>
			[upg-form class="pure-form pure-form-stacked" title="Post Video Ecard URL" name="my_ecard" taxonomy="upg_cate" tag_taxonomy="upg_tag" post_type="video_url" preview="ecard"]<br>
			[upg-form-tag type="post_title" title="Video Title" value="" placeholder="main title"]<br>
			[upg-form-tag type="category" title="Select category" taxonomy="upg_cate" filter="embed"]<br>
			[upg-form-tag type="tag" title="Insert tag"]<br>
			[upg-form-tag type="video_url" title="Insert YouTube URL" placeholder="http://" required="true"]<br>
			[upg-form-tag type="submit" name="submit" value="Upload"]<br>
			[/upg-form]<br>
		</code>
		<hr>
		<b>3- Pick Your Card</b>
		<code>
			[odudecard-pick]
		</code>

	</div>
<?php
}

?>