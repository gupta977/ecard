<?php
add_action('init', 'odudecard_languages');
add_action('admin_enqueue_scripts', 'odudecard_admin_enqueue_scripts');
add_action('wp_enqueue_scripts', 'odudecard_enqueue_scripts');
add_shortcode("odudecard-pick", "odudecard_pick");

if (is_admin()) {

	add_action('admin_init', 'odudecard_meta_boxes', 0);
	add_action('save_post', 'odudecard_save_meta_data', 10, 2);
	add_action('admin_menu', 'odudecard_add_admin_menu');

	add_action('admin_init', 'odudecard_settings_init');
}
