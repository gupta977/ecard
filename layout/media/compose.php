	<?php
	$captcha = "";
	$options = get_option('odudecard_settings', '');

	if (isset($options['odudecard_text_captcha_enable']) && $options['odudecard_text_captcha_enable'] == '1')
		$captcha = '<div class="g-recaptcha" data-sitekey="' . $options['odudecard_text_captcha_key'] . '"></div><br>';

	$futuredate = "";
	if (is_upg_pro() && isset($options['odudecard_text_date_enable']) && $options['odudecard_text_date_enable'] == '1')
		$futuredate = '<input type="date" class="datepicker" name="datepicker" value="" />';

	do_action('odudecard_music', $post);


	if (isset($_GET['facebook']) || $sendto == "tofb") {
		//This is for sending ecard to facebook messenger
		if ($sendto == "toboth") {
			?>

			<ul id="odudecard_tabnav">

				<li class="odudecard_tab1"><a href="<?php echo get_permalink($post); ?>">Send to Email</a></li>
				<li class="odudecard_tab2"><a href="<?php echo add_query_arg('facebook', '', get_permalink($post)); ?>" class="active">Send to Other</a></li>

			</ul>

			<div id="odudecard_divider">Enter Details &#8595;</div>
		<?php
			}



			?>
		<form class="pure-form pure-form-stacked" method="post">
			<div class="pure-g">
				<div class="pure-u-1-2"><?php esc_html_e('Your Name', 'odude-ecard'); ?></div>
				<div class="pure-u-1-2"><?php esc_html_e('Your Email', 'odude-ecard'); ?></div>
				<div class="pure-u-1-2"> <input id="SN" name="SN" class="pure-u-1" type="text" required></div>
				<div class="pure-u-1-2"><input id="SE" name="SE" class="pure-u-1" type="email" required></div>

				<div class="pure-u-1-1"><?php esc_html_e('Subject', 'odude-ecard'); ?>: <input id="sub" name="sub" class="pure-u-1-1 pure-input-rounded" type="text"><br></div>


				<div class="pure-u-1-1">

					<?php if ($editor) { ?>


						<?php $settings = array(
									'wpautop'          => true,  // enable rich text editor
									'media_buttons'    => false,  // enable add media button
									'textarea_name'    => 'body', // name
									'textarea_rows'    => '10',  // number of textarea rows
									'tabindex'         => '',    // tabindex
									'editor_css'       => '',    // extra CSS
									'editor_class'     => 'odudecard-rich-textarea', // class
									'teeny'            => false, // output minimal editor config
									'dfw'              => false, // replace fullscreen with DFW
									'tinymce'          => true,  // enable TinyMCE
									'quicktags'        => false,  // enable quicktags
									'drag_drop_upload' => false, // enable drag-drop
								);
								wp_editor('', 'odudecard_msg', apply_filters('odudecard_editor_settings', $settings)); ?>


					<?php
						} else {
							?>

						<?php esc_html_e('Message', 'odude-ecard'); ?>:<br> <textarea id="body" name="body" class="pure-u-1" placeholder="" rows="4" cols="50"></textarea>


					<?php
						}
						?>
				</div>
				<div class="pure-u-1-1"><?php
											do_action("upg_submit_form");
											?></div>
				<div class="pure-u-1-1 pure-u-md-1-2"><button type="submit" class="pure-button" name="facebook" id="facebook" formaction="<?php echo $linku; ?>"><i class="fa fa-share"></i> <?php esc_html_e('Generate Ecard Link', 'odude-ecard'); ?></button> <input type="hidden" name="cardid" value="<?php echo $cardid; ?>"></div>


			</div>
		</form>


		<?php
		} else {
			//This is to send ecard to email
			if ($sendto == "toboth") {
				?>

			<ul id="odudecard_tabnav">

				<li class="odudecard_tab1"><a href="<?php echo get_permalink($post); ?>" class="active">Send to Email</a></li>
				<li class="odudecard_tab2"><a href="<?php echo add_query_arg('facebook', '', get_permalink($post)); ?>">Send to Others</a></li>

			</ul>


			<div id="odudecard_divider">Enter Details &#8595;</div>
		<?php
			}
			?>
		<form class="pure-form pure-form-stacked" method="post">
			<div class="pure-g">
				<div class="pure-u-1-2"><?php esc_html_e('Your Name', 'odude-ecard'); ?></div>
				<div class="pure-u-1-2"><?php esc_html_e('Your Email', 'odude-ecard'); ?></div>
				<div class="pure-u-1-2"> <input id="SN" name="SN" class="pure-u-1" type="text" required></div>
				<div class="pure-u-1-2"><input id="SE" name="SE" class="pure-u-1" type="email" required></div>
				<div class="pure-u-1-2"><?php esc_html_e('Receiver Name', 'odude-ecard'); ?></div>
				<div class="pure-u-1-2"><?php esc_html_e('Receiver E-Mail', 'odude-ecard'); ?></div>
				<div class="pure-u-1-2"> <input id="RN" name="RN" class="pure-u-1" type="text" required></div>
				<div class="pure-u-1-2"> <input id="RE" name="RE" class="pure-u-1" type="email" required></div>
				<div class="pure-u-1-1"><?php esc_html_e('Subject', 'odude-ecard'); ?>: <input id="sub" name="sub" class="pure-u-1-1 pure-input-rounded" type="text"><br></div>


				<div class="pure-u-1-1">

					<?php if ($editor) { ?>


						<?php $settings = array(
									'wpautop'          => true,  // enable rich text editor
									'media_buttons'    => false,  // enable add media button
									'textarea_name'    => 'body', // name
									'textarea_rows'    => '10',  // number of textarea rows
									'tabindex'         => '',    // tabindex
									'editor_css'       => '',    // extra CSS
									'editor_class'     => 'odudecard-rich-textarea', // class
									'teeny'            => false, // output minimal editor config
									'dfw'              => false, // replace fullscreen with DFW
									'tinymce'          => true,  // enable TinyMCE
									'quicktags'        => false,  // enable quicktags
									'drag_drop_upload' => false, // enable drag-drop
								);
								wp_editor('', 'odudecard_msg', apply_filters('odudecard_editor_settings', $settings)); ?>


					<?php
						} else {
							?>

						<?php esc_html_e('Message', 'odude-ecard'); ?>:<br> <textarea id="body" name="body" class="pure-u-1" placeholder="" rows="4" cols="50"></textarea>


					<?php
						}
						?>
				</div>

				<div class="pure-u-1-2"><?php if ($futuredate != "") esc_html_e('Send card on specific date:', 'odude-ecard'); ?><?php echo $futuredate; ?></div>
				<div class="pure-u-1-2">&nbsp;</div>

				<div class="pure-u-1-1">
					<?php
						do_action("upg_submit_form");
						?>
				</div>

				<div class="pure-u-1-1 pure-u-md-1-2"> <button type="submit" class="pure-button pure-button-primary">
						<i class="fa fa-envelope"></i>
						<?php esc_html_e('Email This Ecard', 'odude-ecard'); ?></button></div>

				<div class="pure-u-1-1 pure-u-md-1-2">&nbsp;</div>


			</div>
		</form>


	<?php
	}

	?>