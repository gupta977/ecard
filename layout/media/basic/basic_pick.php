<?php
$from = esc_html__('From', 'odude-ecard');

?>
<style>
	.ecard-container {
		background-color: <?php odudecard_set_color($post, '#ffffff'); ?>;
	}
</style>

<?php echo $from; ?>: <?php echo $ecardview->SN; ?> - (<?php echo $ecardview->SE; ?>)
<hr>
<div class="ecard-container">
	<div class="pure-g">
		<div class="pure-u-1-1" style="text-align:center;">
			<div class="margin-box">
				<center>

					<?php do_action("upg_layout_up"); ?>
					<?php
					if (upg_isVideo($post)) {
						$attr = array(
							'src'      => esc_url(upg_isVideo($post)),
							'width'    => 560,
							'height'   => 315

						);

						//echo wp_video_shortcode( $attr );
						echo wp_oembed_get($attr['src']);
					} else {
						//Display image only if available
						if (stripos($image, 'spacer.png') == false) {
							?>
							<div class="upg_image-frame"><img src="<?php echo $image; ?>"></div>
							<?php echo upg_show_icon_grid(); ?>
					<?php
						}
					}
					?>

				</center>
			</div>
			<h3><?php echo $ecardview->sub; ?></h3>
		</div>

	</div>

	<div id="ecard-message"><?php echo $ecardview->body; ?><br><br></div>
</div>

<?php

do_action('odudecard_music', $post);


if (isset($_GET['pick'])) {
	?>
	<hr><a href='<?php echo get_permalink($post, false); ?>' class='pure-button pure-button-primary'><?php echo esc_html__('Send this Ecard to others', 'odude-ecard'); ?></a>


<?php

}
?>