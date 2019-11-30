<?php
//Keep these variables also in class-pick.php
global $wpdb;
$SN = sanitize_text_field($_POST['SN']);
$SE = sanitize_email($_POST['SE']);
$RN = sanitize_text_field($_POST['RN']);
$RE = sanitize_email($_POST['RE']);
$sub = sanitize_text_field($_POST['sub']);

//$body=sanitize_text_field($_POST['body']);

$allowed_html = odudecard_allowed_html();
$body = nl2br(wp_kses($_POST['body'], $allowed_html));

$cardid = $post->ID;
$options = get_option('odudecard_settings');




if (isset($_POST['datepicker']))
	$clock = sanitize_text_field($_POST['datepicker']);
else
	$clock = "";

$errors = array();
if (empty($SE) || !is_email($SE) || empty($RE) || !is_email($RE))
	$errors['email'] = __('Please enter a valid email address', 'odude-ecard');
if (empty($SN) || empty($RN))
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

if (upg_verify_captcha() == "OK") {

	$xid = time();

	if ($clock == "")
		$query =  "insert into " . $wpdb->prefix . "odudecard_view values('$xid','$SN','$SE','" . $RN . "','$RE','$clock','$sub','$body','N','Y','$cardid','',0,'')";
	else
		$query =  "insert into " . $wpdb->prefix . "odudecard_view values('$xid','$SN','$SE','" . $RN . "','$RE','$clock','$sub','$body','N','N','$cardid','',0,'')";

	$wpdb->query($query);
	//echo $query;
	echo "<h1>" . __('Ecard Has been sent Successfully', 'odude-ecard') . "</h1>";
	echo __('Receiver Name', 'odude-ecard') . ": $RN <br>" . __('Receiver E-Mail', 'odude-ecard') . ": $RE <br>";
	//$link="<a href='".get_site_url()."/?page_id=$page_id&cardid=$cardid&pick=$xid'>".get_site_url()."/?page_id=$page_id&cardid=$cardid&pick=$xid</a>";



	$linku = esc_url(get_permalink($options['odudecard_select_pickup_field']));
	$linku = add_query_arg('pick', $xid, $linku);
	$link = "<a href='$linku'>$linku</a>";
	$msg = "Hello $RN,<br> You have received a greetings card from $SN.<br><br>Click the link below to view it.<br><br>$link<br><br>Thank you<br>";

	//echo $msg;

	//Sending Mail

	if (!isset($options['odudecard_from']))
		$options['odudecard_from'] = get_bloginfo('admin_email');

	add_filter('wp_mail_content_type', 'oset_html_content_type');
	$headers[] = 'Reply-To: ' . $SN . ' <' . $SE . '>';
	if ($options['odudecard_from'] != "")
		$headers[] = 'From: ' . $SN . ' <' . $options['odudecard_from'] . '>';



	if ($clock == "")
		wp_mail($RE, $sub, $msg, $headers);


	// Reset content-type to avoid conflicts 
	remove_filter('wp_mail_content_type', 'oset_html_content_type');

	echo "<br><br><br><a href='' class='pure-button pure-button-primary'>" . __('Send to Others', 'odude-ecard') . "</a>";
} else {
	echo "<b>" . upg_verify_captcha() . "</b><br><br><a href=\"javascript:history.go(-1)\" class=\"pure-button\">" . __('Go Back', 'odude-ecard') . "</a>";
}
