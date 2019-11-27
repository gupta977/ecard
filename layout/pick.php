<?php
$options = get_option('odudecard_settings', '');
$fbid = $options['odudecard_fbid'];
$output = "";
$put = "";
ob_start();
//Checks it's for preview of ecard or not.
if (isset($_POST['preview']) || isset($_POST['facebook'])) {
	$cardid = $_POST['cardid'];
	$post   = get_post($cardid);

	$ecard_layout = odudecard_getlayout($cardid);

	global $wpdb;
	$SN = sanitize_text_field($_POST['SN']);
	$SE = sanitize_email($_POST['SE']);

	$sub = sanitize_text_field($_POST['sub']);

	//$body=sanitize_text_field($_POST['body']);

	$allowed_html = odudecard_allowed_html();
	$body = nl2br(wp_kses($_POST['body'], $allowed_html));

	$errors = array();
	if (empty($SE) || !is_email($SE))
		$errors['email'] = __('Please enter a valid email address', 'odude-ecard');
	if (empty($SN))
		$errors['Name'] = __('Name cannot be empty', 'odudecard');
	if (empty($sub))
		$errors['subject'] = __('Please enter your subject', 'odude-ecard');
	if (empty($body) || strlen($body) < 2)
		$errors['message'] = __('Please enter a longer message', 'odude-ecard');



	if (!empty($errors)) {
		/*
        echo json_encode(array(
            'success' => 0,
            'errors'  => serialize($errors),
            'msg'     => '<p>' . __('There were errors with your form submission. Please try again.', 'odude-ecard') . '</p>',
        ));
		*/
		echo "<pre>";
		print_r($errors);
		echo "</pre>";
		echo "<a href=\"javascript:history.go(-1)\" class=\"pure-button\">" . __('Go Back', 'odude-ecard') . "</a>";

		die;
	}
	if (upgpro_verify_comment_captcha() == "OK") {
		$xid = time();
		$query =  "insert into " . $wpdb->prefix . "odudecard_view values('$xid','$SN','$SE','','','','$sub','$body','N','Y','$cardid','',0,'')";

		$wpdb->query($query);
		echo "<h1>" . __('Ecard link is successfully generated. ', 'odude-ecard') . "</h1>";
		echo "Share or copy/paste link below.<br><br>";
		$linku = esc_url(get_permalink($options['odudecard_select_pickup_field']));
		$linku = add_query_arg('pick', $xid, $linku);
		?>

		<script>
			function odudecard_myFunction() {
				/* Get the text field */
				var copyText = document.getElementById("myInput");

				/* Select the text field */
				copyText.select();

				/* Copy the text inside the text field */
				document.execCommand("Copy");

				/* Alert the copied text */
				alert("Copied Ecard Link or URL");
			}
		</script>

		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.12&appId=<?php echo $fbid; ?>&autoLogAppEvents=1';
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>

		<div class="fb-share-button" data-href="<?php echo $linku; ?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars($linku, ENT_QUOTES); ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
		<br>

		<input type="text" value="<?php echo $linku; ?>" id="myInput">
		<button onclick="odudecard_myFunction()"><?php echo __('Copy Ecard Link</button', 'odude-ecard'); ?>> <br>
	<?php

			echo "<br><br><br><a href='javascript:history.go(-1)' class='pure-button pure-button-primary'>" . __('Modify Card', 'odude-ecard') . "</a>";


			//$link="<a href='$linku'>$linku</a>";
			//echo $link;


		} else {
			echo "<b>" . upgpro_verify_comment_captcha() . "</b><br><br><a href=\"javascript:history.go(-1)\" class=\"pure-button\">" . __('Go Back', 'odude-ecard') . "</a>";
		}
	} else {
		global $wpdb;
		if (isset($_GET['pick']))
			$pickid = sanitize_text_field($_GET['pick']);
		else
			$pickid = 0;

		$query = "SELECT * FROM " . $wpdb->prefix . "odudecard_view WHERE id = '" . $pickid . "'";
		$ecardview = $wpdb->get_row($query);

		if (is_array($ecardview) && count($ecardview) == 0) {
			esc_html_e('Either card is deleted or wrong Pick-up ID provided', 'odude-ecard');
		} else {
			$post   = get_post($ecardview->card);

			$ecard_layout = odudecard_getlayout($ecardview->card);
			$image = upg_image_src('large', $post);

			require_once("media/" . $ecard_layout . "/" . $ecard_layout . "_pick.php");
		}
	}
	$put = ob_get_clean();
	return $put;

	?>