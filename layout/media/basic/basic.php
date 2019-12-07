<?php
//This page is inlcuded with UPG ecard layout

include(dirname(__FILE__) . "/../header.php");



if (isset($_POST['SN']))
	$SN = $_POST['SN'];
else
	$SN = "";

if ($SN == '') {

	?>
	<style>
		.ecard-container {
			background-color: <?php odudecard_set_color($post, '#ffffff'); ?>;
		}
	</style>
	<?php echo upg_position1(); ?>
	<div class="margin-box ecard-container" style="text-align:center;">
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

				?>
			<img src="<?php echo $image; ?>" class="pure-img">
		<?php
			}
			?>


	</div>

	<br>

<?php
	include(dirname(__FILE__) . "/../compose.php");
} else {
	include(dirname(__FILE__) . "/../submit.php");
}
?>