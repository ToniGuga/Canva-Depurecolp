<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {


?>
	<div class="canva-wp-block canva-flex">

		<div class="canva-info canva-width-24 canva-p-4 canva-bg-grey-lightest">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style=""><?php _e('Video Embed', 'canva-backend'); ?></span>
			<figure class="canva-width-16 canva-m-0 canva-bg-grey-lightest canva-p-0">
				<?php echo apply_filters('video_embed_blocks_icon', canva_get_svg_icon('fontawesome/brands/youtube', null)); ?>
			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4">

			<div class="canva-block-icon-text canva-flex">

				<?php
				if (get_field('video_embed')) {

					echo get_field('video_embed');
				}else{
					_e('Imposta il blocco', 'canva-backend');
				}
				?>

			</div>
		</div>

	</div>

<?php
} else {

	// Create id attribute allowing for custom "anchor" value.
	$id = $block['id'];
	if (!empty($block['anchor'])) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$className = '';
	if (!empty($block['className'])) {
		$className .= ' ' . $block['className'];
	}

?>

	<div id="<?php echo esc_attr($id); ?>" class="_video-container <?php echo esc_attr($className); ?>">
		<?php echo get_field('video_embed'); ?>
	</div>

<?php }
