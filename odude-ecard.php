<?php
/*
Plugin Name: ODude Ecard
Plugin URI: http://odude.com/
Description: ODude Ecard to make a complete greetings card site.
Version: 2.4
Author: ODude Network
Author URI: http://odude.com/
License: GPLv2 or later
Text Domain: odude-ecard
*/


define('odudecard_ROOT_URL', plugin_dir_url(__FILE__));
define('odudecard_FOLDER', dirname(plugin_basename(__FILE__)));
define('odudecard_BASE_DIR', WP_CONTENT_DIR . '/plugins/' . odudecard_FOLDER . '/');
define('odudecard_PLUGIN_URL', content_url('/plugins/' . odudecard_FOLDER));


include(dirname(__FILE__) . "/libs/lib.php");
include(dirname(__FILE__) . "/libs/hooks.php");
include(dirname(__FILE__) . "/setting.php");
include(dirname(__FILE__) . "/dashboard.php");
include(dirname(__FILE__) . "/stat.php");
include(dirname(__FILE__) . "/libs/install.php");

function odudecard_languages()
{
	load_plugin_textdomain('odude-ecard', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}



register_activation_hook(__FILE__, 'odudecard_install');
register_uninstall_hook(__FILE__, 'odudecard_drop');

//Adding meta boxes
function odudecard_meta_boxes()
{
	$prefix = 'odudecard_';

	$meta_boxes = array(


		'odudecard-layout' => array('title' => __('Ecard Theme', "odudecard"), 'callback' => 'odudecard_meta_box_layout', 'position' => 'side', 'priority' => 'core'),

		'odudecard-music' => array('title' => __('Select Ecard Music', "odudecard"), 'callback' => 'odudecard_meta_box_music', 'position' => 'side', 'priority' => 'core'),

		'odudecard-color' => array('title' => __('Ecard Background Color', "odudecard"), 'callback' => 'odudecard_meta_box_color', 'position' => 'side', 'priority' => 'core'),

	);



	$meta_boxes = apply_filters("odudecard_meta_box", $meta_boxes);
	foreach ($meta_boxes as $id => $meta_box) {
		extract($meta_box);
		add_meta_box($id, $title, $callback, 'upg', $position, $priority);
	}
}

function odudecard_meta_box_color($post)
{
	wp_nonce_field(plugin_basename(__FILE__), 'odudecard_color_nonce');
	global $post;
	$custom  = get_post_custom($post->ID);
	if (isset($custom["color"][0]))
		$color    = $custom["color"][0];
	else
		$color = "";



	echo '<input type="text" value="' . $color . '" class="my-color-field" data-default-color="#ffffff" name="color" />';
	echo "<script>jQuery(document).ready(function($){
    $('.my-color-field').wpColorPicker();
});</script>";
}

//Music select
function odudecard_meta_box_music($post)
{
	if (is_upg_pro()) {
		wp_nonce_field(plugin_basename(__FILE__), 'odudecard_music_nonce');

		global $post;
		$custom  = get_post_custom($post->ID);
		if (isset($custom["music_link"][0]))
			$link    = $custom["music_link"][0];
		else
			$link = "";
		$count   = 0;
		echo '<div class="link_header">';
		$query_pdf_args = array(
			'post_type' => 'attachment',
			'post_mime_type' => 'audio/wav,audio/mpeg,audio/ogg',
			'post_status' => 'inherit',
			'posts_per_page' => -1,
		);
		$query_pdf = new WP_Query($query_pdf_args);
		$pdf = array();
		echo '<select name="music_link">';
		echo '<option class="pdf_select">None</option>';
		foreach ($query_pdf->posts as $file) {
			if ($link == $pdf[] = $file->guid) {
				echo '<option value="' . $pdf[] = $file->guid . '" selected="true">' . $pdf[] = $file->guid . '</option>';
			} else {
				echo '<option value="' . $pdf[] = $file->guid . '">' . $pdf[] = $file->guid . '</option>';
			}
			$count++;
		}
		echo '</select><br /></div>';
		echo '<p>List MP3,Wav,Ogg files from Media Manager.</p>';
		echo '<div class="pdf_count"><span>Files:</span> <b>' . $count . '</b></div>';
	} else {
		echo "Install UPG-PRO";
	}
}

//Layout of ecard
function odudecard_meta_box_layout()
{
	global $post;
	$all_odudecard_fields = get_post_custom($post->ID);
	if (isset($all_odudecard_fields["ecard_layout"][0]))
		$ecard_layout = $all_odudecard_fields["ecard_layout"][0];
	else
		$ecard_layout = "basic";

	$dir    = odudecard_BASE_DIR . 'layout/media/';
	$filelist = "";
	$files = array_map("htmlspecialchars", scandir($dir));

	foreach ($files as $file) {
		if ($ecard_layout == $file)
			$checked = 'checked=checked';
		else
			$checked = "";

		if (!strpos($file, '.') && $file != "." && $file != "..")
			$filelist .= sprintf('<input type="radio" ' . $checked . ' name="ecard_layout" value="%s"/>%s layout<br>' . PHP_EOL, $file, $file);
	}
	echo $filelist;
}

//Save data typed in post type
function odudecard_save_meta_data($post_id, $post)
{



	if (!isset($_POST['nonce_name'])) //make sure our custom value is being sent
		return;
	if (!wp_verify_nonce($_POST['nonce_name'], 'nonce_action')) //verify intent
		return;
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) //no auto saving
		return;
	if (!current_user_can('edit_post', $post_id)) //verify permissions
		return;
	//session_start();

	/* --- security verification --- */
	if (!wp_verify_nonce($_POST['odudecard_music_nonce'], plugin_basename(__FILE__))) {
		return;
	} // end if

	/* --- security verification --- */
	if (!wp_verify_nonce($_POST['odudecard_color_nonce'], plugin_basename(__FILE__))) {
		return;
	} // end if


	update_post_meta($post->ID, "ecard_layout", $_POST["ecard_layout"]);
	update_post_meta($post->ID, "music_link", $_POST["music_link"]);
	update_post_meta($post->ID, "color", $_POST["color"]);
}
function odudecard_enqueue_scripts()
{
	global $odudecard_plugin, $current_screen;
	$options = get_option('odudecard_settings', '');


	wp_enqueue_style('odudecard-style', plugins_url() . '/' . odudecard_FOLDER . '/css/style.css', '', UPG_PLUGIN_VERSION, '');

	if (isset($options['odudecard_text_captcha_enable']))
		if ($options['odudecard_text_captcha_enable'] == '1')
			wp_enqueue_script('odudecard_captcha', 'https://www.google.com/recaptcha/api.js');
}

function odudecard_admin_enqueue_scripts()
{
	global $odudecard_plugin, $current_screen;
	$screen = get_current_screen();


	if (is_plugin_active('wp-upg/wp-upg.php')) {
		if ($screen->base == 'odude-ecard_page_odude_ecard' || $screen->base == 'odude-ecard_page_odude_ecard_stat' || $screen->base == 'toplevel_page_odudecard') {
			wp_enqueue_style('odude-pure', plugins_url() . '/' . upg_FOLDER . '/css/pure-min.css', '', UPG_PLUGIN_VERSION, '');
			//wp_enqueue_style('font-awesome-css','https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css');
			wp_enqueue_style('odude-pure-grid', plugins_url() . '/' . upg_FOLDER . '/css/grids-responsive-min.css', '', UPG_PLUGIN_VERSION, '');
		}
	}
	//echo "------------------------------------------".$screen->base;

}

//pickup ecards
function odudecard_pick($params)
{
	$abc = include(odudecard_BASE_DIR . 'layout/pick.php');
	return $abc;
}

//Remove this in next update
function hide_old_ecardmenu()
{
	remove_menu_page('edit.php?post_type=odudecard');
}
add_action('admin_menu', 'hide_old_ecardmenu');


//Send pending cards on specified dates
add_action('wp_loaded', 'pending_cards');

function pending_cards()
{
	if (is_upg_pro()) {
		global $wpdb;
		$options = get_option('odudecard_settings');

		$query = "SELECT * FROM " . $wpdb->prefix . "odudecard_view WHERE status='N' and clock<=CURRENT_DATE limit 0,10";
		$cron_cards = $wpdb->get_results($query);

		if ($cron_cards) {
			foreach ($cron_cards as $card) {
				$linku = esc_url(get_permalink($options['odudecard_select_pickup_field']) . "?pick=" . $card->id);
				$link = "<a href='$linku'>$linku</a>";
				$msg = "Hello " . $card->RN . ",<br> You have received a beautiful greetings card from " . $card->SN . ".<br><br>Click the link below to view it.<br><br>$link<br><br>Thank you<br>";

				//Sending Mail
				add_filter('wp_mail_content_type', 'oset_html_content_type');
				$headers[] = 'From: ' . $card->SN . ' <' . $card->SE . '>';
				wp_mail($card->RE, $card->sub, $msg, $headers);
				// Reset content-type to avoid conflicts 
				remove_filter('wp_mail_content_type', 'oset_html_content_type');


				$up = "update " . $wpdb->prefix . "odudecard_view set status='Y' where id='" . $card->id . "'";
				$wpdb->query($up);
				//echo "am sending card";

			}
		} else {
			//echo "no cards";
		}
	}
}
add_action('odudecard_music', 'odudecard_music');
function odudecard_music($post)
{
	if (is_upg_pro()) {
		//global $post;
		$all_odudecard_fields = get_post_custom($post->ID);
		if (isset($all_odudecard_fields["music_link"][0]))
			$music_link = $all_odudecard_fields["music_link"][0];
		else
			$music_link = "None";

		if ($music_link != "None") {
			echo '<br><audio src="' . $music_link . '" autoplay loop controls preload>' . esc_html('Your browser does not support the audio tag!', 'odude-ecard') . '</audio>';
		}
	}
}
