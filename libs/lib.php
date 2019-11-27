<?php
function odudecard_getlayout($cardid)
{
	$all_odudecard_fields= get_post_custom($cardid);
	
			if(isset($all_odudecard_fields["ecard_layout"][0]))
				$ecard_layout=$all_odudecard_fields["ecard_layout"][0];
			else
				$ecard_layout="basic";
			
		return $ecard_layout;	
	
}

function oset_html_content_type() 
{

	return 'text/html';
}
function odudecard_allowed_html() {
 
	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'i' => array(),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
		),
		'ol' => array(
			'class' => array(),
		),
		'p' => array(
			'class' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
		),
	);
	
	return $allowed_tags;
}		

function odudecard_pro_check()
{
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	if ( is_plugin_active( 'odude-card-pro/odude-ecard-pro.php' ) ) 
		return true;
	else
		return false;
}

function odudecard_set_color($post,$defult)
{
	$all_odudecard_fields= get_post_custom($post->ID);
	
	if(isset($all_odudecard_fields["color"][0]))
			echo $all_odudecard_fields["color"][0];
			else
			echo $defult;
}

//Captcha code
function odudecard_verify_comment_captcha() 
{
	$options = get_option( 'odudecard_settings','' );
	
	if(!isset($options['odudecard_text_captcha_enable']) || $options['odudecard_text_captcha_enable']=="0")
	return "OK";	
		
	if (isset($_POST['g-recaptcha-response'])) 
	{
		$options = get_option( 'odudecard_settings','' );
		$recaptcha_secret = $options['odudecard_text_secret_key'];
		$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=". $recaptcha_secret ."&response=". $_POST['g-recaptcha-response']);
		
		if(is_array($response) && array_key_exists('body', $response))
		{
			$response = json_decode($response["body"], true);
			if (true == $response["success"]) 
			{
				//return true;
				return "OK";
			}
			else 
			{
				//return false;
				//return "oooo";
				return __("Please Complete the Security Spam Check.", "odude-card-pro" );
			}
		}
		else
		{
			return __("Google Server Error", "odude-card-pro");
		}
	} 
	else 
	{
		//return false;
		return __("Bots are not allowed to send ecards. If you are not a bot then please enable JavaScript in browser.", "odude-card-pro");
		//return "8888";
	}

}
?>