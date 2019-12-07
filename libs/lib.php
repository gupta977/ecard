<?php
function odudecard_getlayout($cardid)
{
	$all_odudecard_fields = get_post_custom($cardid);

	if (isset($all_odudecard_fields["ecard_layout"][0]))
		$ecard_layout = $all_odudecard_fields["ecard_layout"][0];
	else
		$ecard_layout = "basic";

	return $ecard_layout;
}


function odudecard_allowed_html()
{

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
	include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	if (is_plugin_active('odude-card-pro/odude-ecard-pro.php'))
		return true;
	else
		return false;
}

function odudecard_set_color($post, $defult)
{
	$all_odudecard_fields = get_post_custom($post->ID);

	if (isset($all_odudecard_fields["color"][0]))
		echo $all_odudecard_fields["color"][0];
	else
		echo $defult;
}
