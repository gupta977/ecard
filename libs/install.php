<?php
function odudecard_add_admin_menu()
{

  add_menu_page('ODude Ecard Dashboard', 'ODude Ecard', 'manage_options', 'odudecard', 'odudecard_dashboard', 'dashicons-admin-users');

  add_submenu_page('odudecard', 'ODude Ecard Settings', 'Ecard Settings', 'manage_options', 'odude_ecard', 'odudecard_options_page');

  add_submenu_page('odudecard', 'ODude Ecard Statistics', 'Ecard Statistics', 'manage_options', 'odude_ecard_stat', 'odudecard_stat_page');
}





function odudecard_install()
{


  global $wpdb;
  $tablename = $wpdb->prefix . 'odudecard_view';


  $qry = "CREATE TABLE IF NOT EXISTS `" . $tablename . "` (
  `id` int(15) NOT NULL,
  `SN` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `SE` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `RN` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `RE` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `clock` date NOT NULL DEFAULT '0000-00-00',
  `sub` varchar(50) NOT NULL DEFAULT '',
  `body` text NOT NULL,
  `notify` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `status` char(1) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `card` int(10) NOT NULL,
  `IP` text CHARACTER SET utf8 NOT NULL,
  `count` int(11) NOT NULL,
  `term` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8";


  $wpdb->query($qry);


  if (!$wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[odudecard-pick]%'")) {
    wp_insert_post(array('post_title' => 'Pick Your Card', 'post_content' => '[odudecard-pick]', 'post_type' => 'page', 'post_status' => 'publish'));
  }

  //Create post form image
  $str_post_image = '
    [upg-form class="pure-form" title="Post Ecard Image" name="my_ecard_image" taxonomy="upg_cate" tag_taxonomy="upg_tag" preview="ecard"]
    [upg-form-tag type="post_title" title="Image Title" value="" placeholder="main title"]
    [upg-form-tag type="category" title="Select category" taxonomy="upg_cate" filter="image"]
    [upg-form-tag type="tag" title="Insert tag"]
    [upg-form-tag type="file" title="Select file" required="true"]
    [upg-form-tag type="submit" name="submit" value="Upload"]
    [/upg-form]
    ';
  $bid = wp_insert_post(array('post_title' => 'Post Ecard Image', 'post_content' => $str_post_image, 'post_type' => 'page', 'post_status' => 'publish'));
  update_post_meta($bid, "upg_hide_after_content", "hide");

  $str_post_embed = '
		[upg-form class="pure-form" title="Post Video Ecard URL" name="my_ecard" taxonomy="upg_cate" tag_taxonomy="upg_tag" post_type="video_url" preview="ecard"]
    [upg-form-tag type="post_title" title="Video Title" value="" placeholder="main title"]
    [upg-form-tag type="category" title="Select category" taxonomy="upg_cate" filter="embed"]
    [upg-form-tag type="tag" title="Insert tag"]
    [upg-form-tag type="video_url" title="Insert YouTube URL" placeholder="http://" required="true"]
    [upg-form-tag type="submit" name="submit" value="Upload"]
    [/upg-form]
		';



  $cid = wp_insert_post(array('post_title' => 'Post Ecard Video URL', 'post_content' => $str_post_embed, 'post_type' => 'page', 'post_status' => 'publish'));
  update_post_meta($cid, "upg_hide_after_content", "hide");
}

function odudecard_drop()
{

  global $wpdb;

  $tablename = $wpdb->prefix . 'odudecard_view';

  $qry = "DROP TABLE " . $tablename;

  $wpdb->query($qry);
}
