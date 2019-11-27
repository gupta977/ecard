<?php 
function odudecard_add_admin_menu(  ) 
{ 

add_menu_page( 'ODude Ecard Dashboard', 'ODude Ecard', 'manage_options', 'odudecard', 'odudecard_dashboard','dashicons-admin-users' );

	add_submenu_page( 'odudecard', 'ODude Ecard Settings', 'Ecard Settings', 'manage_options', 'odude_ecard', 'odudecard_options_page' );
	
	add_submenu_page( 'odudecard', 'ODude Ecard Statistics', 'Ecard Statistics', 'manage_options', 'odude_ecard_stat', 'odudecard_stat_page' );
}

function odudecard_post_types()
{   
$settings = maybe_unserialize(get_option('_odudecard_settings'));  

	$product=" ";
	
	//This will be removed in next version.
	
	    register_post_type("odudecard",array(
            
            'labels' => array(
                'name' => __('OLD ODude ECard',"odudecard"),
                'singular_name' => __('Ecard',"odudecard"),
                'add_new' => __('Add '.$product.' Ecard',"odudecard"),
                'add_new_item' => __('Add New '.$product.' Ecard',"odudecard"),
                'edit_item' => __('Edit '.$product.' Ecard',"odudecard"), 
                'new_item' => __('New '.$product.' Ecard',"odudecard"),
                'view_item' => __('View Ecard',"odudecard"),
                'search_items' => __('Search Ecard',"odudecard"),
                'not_found' =>  __('No Ecard found',"odudecard"),
                'not_found_in_trash' => __('No ecard found in Trash',"odudecard"), 
                'parent_item_colon' => ''
            ),
            'public' => true,
            'publicly_queryable' => true,
            'has_archive' => true,
            'show_ui' => true, 
            'query_var' => true,
            'rewrite' => array('slug'=>'ecard','with_front'=>true),
            'capability_type' => 'post',
            'hierarchical' => false,
            'menu_icon' =>odudecard_PLUGIN_URL.'/images/odude.png',
			//'supports' => array('title','editor','author','excerpt','thumbnail','ptype','comments'/*,'custom-fields'*/) ,            
            'supports' => array('title','editor','card_cate','comments'/*,'custom-fields'*/) ,
            'taxonomies' => array('card_cate'),
			'taxonomies' => array('card_tag')
             
        )
    );  
	
	//END
	
}



function register_ODudeCard_product_taxonomies()
{
  // Add new taxonomy, make it hierarchical (like categories)
  $labels = array(
    'name' => __( 'Ecard Albums',"odudecard" ),
    'singular_name' => __( 'Ecard Album',"odudecard"),
    'search_items' =>  __( 'Search Albums',"odudecard" ),
    'all_items' => __( 'All Albums',"odudecard" ),
    'parent_item' => __( 'Parent Album',"odudecard" ),
    'parent_item_colon' => __( 'Parent Album:',"odudecard" ),
    'edit_item' => __( 'Edit Album',"odudecard" ), 
    'update_item' => __( 'Update Album',"odudecard" ),
    'add_new_item' => __( 'Add New Album',"odudecard" ),
    'new_item_name' => __( 'New Album Name',"odudecard" ),
    'menu_name' => __( 'Ecard Albums',"odudecard" ),
  );     

  register_taxonomy('card_cate',array('odudecard'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'ecard_album' ),
  ));
 
 
  $labels = array(
    'name' => __( 'Ecard Tags',"odudecard" ),
    'singular_name' => __( 'Ecard Tag',"odudecard"),
    'search_items' =>  __( 'Search Tags',"odudecard" ),
    'all_items' => __( 'All Tags',"odudecard" ),
    'parent_item' => __( 'Parent Tag',"odudecard" ),
    'parent_item_colon' => __( 'Parent Tag:',"odudecard" ),
    'edit_item' => __( 'Edit Tag',"odudecard" ), 
    'update_item' => __( 'Update Tag',"odudecard" ),
    'add_new_item' => __( 'Add New Tag',"odudecard" ),
    'new_item_name' => __( 'New Tag Name',"odudecard" ),
    'menu_name' => __( 'Ecard Tags',"odudecard" ),
  );     

  register_taxonomy('card_tag',array('odudecard'), array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'ecard_tag' ),
  ));
	
  
}

function odudecard_install()
{
	//Remove in next update
	odudecard_post_types();
	 register_ODudeCard_product_taxonomies();
	
	global $wpdb;	
	$tablename = $wpdb->prefix.'odudecard_view';
	
	
	$qry = "CREATE TABLE IF NOT EXISTS `".$tablename."` (
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
	
	
	if(!$wpdb->get_var("select id from {$wpdb->prefix}posts where post_content like '%[odudecard-pick]%'"))
	{
       wp_insert_post(array('post_title'=>'Pick Your Card','post_content'=>'[odudecard-pick]','post_type'=>'page','post_status'=>'publish'));
  
    }
	

	
}

function odudecard_drop()
{
	
	global $wpdb;	
	
	$tablename = $wpdb->prefix.'odudecard_view';
	
	$qry = "DROP TABLE ".$tablename;
			
	$wpdb->query($qry);
}
?>