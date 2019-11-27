<?php
$cardid=$post->ID;
$editor=true;	
	
	$captcha="";
	$options = get_option( 'odudecard_settings','' );	
	$linku=esc_url( get_permalink($options['odudecard_select_pickup_field']) );
	
	if(isset($options['odudecard_send_opt']))
	$sendto=$options['odudecard_send_opt'];
else
	$sendto="toboth";

$fbid=$options['odudecard_fbid'];
?>