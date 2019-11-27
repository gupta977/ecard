<?php
function odudecard_settings_init(  ) 
{ 
	
	
	//Basic Setting
	register_setting( 'EcardSettingPage', 'odudecard_settings' );
	

	add_settings_section(
		'odudecard_EcardSettingPage_section', 
		__( 'Settings', 'odudecard' ), 
		'odudecard_settings_section_callback', 
		'EcardSettingPage'
	);
	add_settings_field( 
		'odudecard_select_pickup_field', 
		__( 'Free Settings', 'odudecard' ), 
		'odude_free_settings', 
		'EcardSettingPage', 
		'odudecard_EcardSettingPage_section' 
	);
	add_settings_field( 
		'odudecard_text_date_enable', 
		__( 'Pro Settings', 'odudecard' ), 
		'odude_pro_settings', 
		'EcardSettingPage', 
		'odudecard_EcardSettingPage_section' 
	);
	
	
	//End Basic Setting
	//Captcha Tab
	register_setting( 'EcardSetting_Captcha_Page', 'odudecard_settings' );
		add_settings_section(
		'odudecard_EcardSettingPage_captcha_section', 
		__( 'Captcha Settings', 'odudecard' ), 
		'odudecard_settings_section_captcha_callback', 
		'EcardSetting_Captcha_Page'
	);
	

		 add_settings_field( 
		'odudecard_text_captcha_enable', 
		__( 'Google Captcha Enable', 'odudecard' ), 
		'odudecard_text_captcha_enable_render', 
		'EcardSetting_Captcha_Page', 
		'odudecard_EcardSettingPage_captcha_section' 
	);
	
	 add_settings_field( 
		'odudecard_text_captcha_key', 
		__( 'Google Captcha API Key', 'odudecard' ), 
		'odudecard_text_captcha_key_render', 
		'EcardSetting_Captcha_Page', 
		'odudecard_EcardSettingPage_captcha_section' 
	); 
	 add_settings_field( 
		'odudecard_text_secret_key', 
		__( 'Google Captcha secret Key', 'odudecard' ), 
		'odudecard_text_secret_key_render', 
		'EcardSetting_Captcha_Page', 
		'odudecard_EcardSettingPage_captcha_section' 
	);
	
	//End Captcha Tab




}

function odudecard_text_captcha_enable_render(  ) 
{ 

	$options = get_option( 'odudecard_settings','' );
	if(!isset($options['odudecard_text_captcha_enable']))
	{
		$options['odudecard_text_captcha_enable']="0";
		//update_option('odudecard_settings',$options);
	}
	?>
	<input type="checkbox" name='odudecard_settings[odudecard_text_captcha_enable]' value='1' <?php if($options['odudecard_text_captcha_enable']=='1') echo 'checked="checked"'; ?> >
	
	<?php

}
 
function odudecard_text_captcha_key_render(  ) 
{ 

	$options = get_option( 'odudecard_settings' );
	if(!isset($options['odudecard_text_captcha_key']))
		$options['odudecard_text_captcha_key']="";
	?>
	<input type='text' name='odudecard_settings[odudecard_text_captcha_key]' value='<?php echo $options['odudecard_text_captcha_key']; ?>'>
	<?php

}
function odudecard_text_secret_key_render(  ) 
{ 

	$options = get_option( 'odudecard_settings','' );
	if(!isset($options['odudecard_text_secret_key']))
		$options['odudecard_text_secret_key']="";
	?>
	<input type='text' name='odudecard_settings[odudecard_text_secret_key]' value='<?php echo $options['odudecard_text_secret_key']; ?>'>
	<?php

}

 


 
 function odude_free_settings() 
 {
	 echo '<div class="pure-form pure-form-aligned">
 
  <fieldset>';
$options = get_option('odudecard_settings');

if(!isset($options['odudecard_select_pickup_field']))
		$options['odudecard_select_pickup_field']="";

	echo '<div class="pure-control-group"> <label for="name">Select Pickup Page</label> ';
    wp_dropdown_pages(
        array(
             'name' => 'odudecard_settings[odudecard_select_pickup_field]',
             'echo' => 1,
             'show_option_none' => __( '&mdash; Select &mdash;' ),
             'option_none_value' => '0',
             'selected' => $options['odudecard_select_pickup_field']
			 
        )
    );
	echo 'Shortcode used as [odudecard-pick]</div>';
	if(!isset($options['odudecard_from']))
		$options['odudecard_from']=get_bloginfo( 'admin_email' );
	if(!isset($options['odudecard_fbid']))
		$options['odudecard_fbid']="";
	if(!isset($options['odudecard_metatag_enable']))
		$options['odudecard_metatag_enable']="0";
	if(!isset($options['odudecard_fb_like']))
		$options['odudecard_fb_like']="0";

	if(!isset($options['odudecard_send_opt']))
		$options['odudecard_send_opt']="toboth";
	
	?>
	
		<div class="pure-control-group">
	<label for="name">System email from address. </label>
	<input type='text' name='odudecard_settings[odudecard_from]' value='<?php echo $options['odudecard_from']; ?>'> Tips: Use authorize email address to prevent from spam.
	</div>
	
	<div class="pure-control-group">
	<label for="name">Facebook App ID </label>
	<input type='text' name='odudecard_settings[odudecard_fbid]' value='<?php echo $options['odudecard_fbid']; ?>'> <a href="https://developers.facebook.com/docs/apps/register" target="_blank">Get Facebook App ID</a>
	</div>
	


	
		<div class="pure-control-group">
	 <label for="name">Ecard Sending Options: </label>
	 <br>Via Email :
	 <input type="radio" name="odudecard_settings[odudecard_send_opt]" value="toemail" <?php checked('toemail', $options['odudecard_send_opt']); ?> /><br>
	 Via Facebook & Share: 
   <input type="radio" name="odudecard_settings[odudecard_send_opt]" value="tofb" <?php checked('tofb', $options['odudecard_send_opt']); ?> /><br>
   All Above:
   <input type="radio" name="odudecard_settings[odudecard_send_opt]" value="toboth" <?php checked('toboth', $options['odudecard_send_opt']); ?> /><br /> 
 
	</div>

	
	 </fieldset>
	</div>
	
	<?php
	
	
}

 function odude_pro_settings() 
 {
$options = get_option('odudecard_settings');
	if(!isset($options['odudecard_text_date_enable']))
	{
		$options['odudecard_text_date_enable']="0";
		//update_option('odudecard_settings',$options);
	}
	$proactive=false;
	if ( is_plugin_active( 'odude-card-pro/odude-ecard-pro.php' ) ) 
	{
		echo "<b><a href='http://www.odude.com'>ODude ECard PRO</a> is Active</b>";
		$proactive=true;
	} 
	else
	{
		echo "<br>Install <b><a href='http://odude.com/product/odude-ecard-wordpress/'>ODude Ecard PRO</a></b> for complete features.<br>Only US$15 for all features.";
	}
	if($proactive)
	{
	
	?>
	<hr><b>Enable Send on Specific Date:</b> <input type="checkbox" name='odudecard_settings[odudecard_text_date_enable]' value='1' <?php if($options['odudecard_text_date_enable']=='1') echo 'checked="checked"'; ?> ><br>
	
	<hr>
	

	
	<?php
	}
	else
	{
		?><br><br>These features are not availabe in free version.
		<ul>
		<li>Google reCaptcha to prevent from email spam</li>
		<li>Enable/Disable Send ecard on specified date</li>	
		<li>Background Music: <b>OFF</b></li>

		</ul>
		<input type="hidden" name='odudecard_settings[odudecard_text_date_enable]' value='0'>

		<?php
	}
	
}


function odudecard_settings_section_callback(  ) 
{ 

	//echo __( 'Update or modify required settings.', 'odudecard' );
	/**
 * Detect plugin. For use on Front End only.
 */
 //include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	
	
}


//Captcha Tab
function odudecard_settings_section_captcha_callback(  ) 
{ 

	echo __( 'This is Captcha setting page', 'odude-ecard' );
	
	
}



function odudecard_options_page(  ) 
{ 

/**
 * Detect plugin. For use on Front End only.
 */
 //include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	$proactive=false;
 
	if ( is_plugin_active( 'odude-card-pro/odude-ecard-pro.php' ) ) 
	{
		 $proactive=true;
	} 
	
	$propassive="This features is only available to ODude Ecard PRO Version.";




	?>
	
	<script>
jQuery(document).ready(function($){
       $("#tabs").tabs();
});
  </script>
  
<div class="wrap">
	



	<form action='options.php' method='post'>
		
		<h2>ODude Ecard</h2>
		<div id="tabs">
	<ul>
		  
        <li><a href="#tab-1"><?php echo __("Basic Settings","odude-ecard");?></a></li>
        <li><a href="#tab-2"><?php echo __("Google reCaptcha V2","odude-ecard");?></a></li>    
		
				
	</ul>
	 <div id="tab-1">
     <?php
	 settings_fields( 'EcardSettingPage' );
	do_settings_sections( 'EcardSettingPage' );
	 ?>
    </div>
    <div id="tab-2">
      <?php
	  if($proactive)
	  {
	  settings_fields( 'EcardSetting_Captcha_Page' );
		do_settings_sections( 'EcardSetting_Captcha_Page' );
	  }
	  else
	  {
		  echo $propassive;
			//$options['odudecard_text_captcha_enable']="0";
			//update_option('odudecard_settings',$options);
	  }
	  ?>
    </div>

	</div>
		
		<?php
		
		submit_button();
		flush_rewrite_rules();
		?>
		
	</form>
</div>
	<?php

}
?>