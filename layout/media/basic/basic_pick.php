<?php
$from = esc_html__( 'From', 'odude-ecard' );

?>
<style>
.ecard-container {
  background-color: <?php odudecard_set_color($post,'#ffffff'); ?>;
}
</style>

<?php echo $from; ?>: <?php echo $ecardview->SN; ?> - (<?php echo $ecardview->SE; ?>)<hr>
		<div class="ecard-container">
<div class="pure-g">
	<div class="pure-u-1-1" style="text-align:center;">
	<img src="<?php echo $image; ?>">
	<h3><?php echo $ecardview->sub; ?></h3>
	</div>
	
	</div>

		<div id="ecard-message"><?php echo $ecardview->body; ?><br><br></div>
	</div>	

		<?php
		
		do_action('odudecard_music',$post);
		
		
		if(isset($_GET['pick']))
		{
			?>
		<hr><a href='<?php echo get_permalink( $post,false); ?>' class='pure-button pure-button-primary'><?php echo esc_html__( 'Send this Ecard to others', 'odude-ecard' ); ?></a>
		
		
<?php

		}
?>