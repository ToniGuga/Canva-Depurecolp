<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

?>
	<div class="canva-wp-block canva-flex">

		<div class="_info canva-width-24 canva-p-4 canva-bg-grey-lighter">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Element Block Slider</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo apply_filters('faq_selector_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-faq-selector', null)); ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4 canva-bg-white">
			<?php
			$posts_object = get_field('post_object');

			if ($posts_object) :
			?>

				<?php foreach ($posts_object as $post_object) : ?>

					<h3 class="canva-flex canva-align-middle canva-mt-0 canva-mb-2 canva-p-2 canva-font-theme canva-fs-h5 canva-fw-700 canva-lh-10 canva-bg-grey-lighter">
						<?php echo get_the_title($post_object); ?> - <a href="<?php echo get_edit_post_link($post_object); ?>" target="_blank"> <?php _e('Modifica Blocco', 'canva-be'); ?></a>
					</h3>

				<?php endforeach; ?>

			<?php else : ?>

				<h3 class="canva-flex canva-align-middle canva-mt-0 canva-mb-2 canva-p-2 canva-font-theme canva-fs-h5 canva-fw-700 canva-lh-10 canva-bg-grey-lighter">
					<?php _e('Imposta il blocco', 'canva'); ?>
				</h3>

			<?php endif; ?>
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

	// if (!get_field('template_name')) {
	// 	$template_name = 'render-blocks';
	// } else {
	// 	$template_name = esc_attr(get_field('template_name'));
	// }

	$posts_object = get_field('post_object');

	if ($posts_object) {
	?>

		<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
			<?php
			canva_slider_post_ids([
				'post_ids' => $posts_object,
				'template_name' => 'render-blocks',
				'swiper_hero_class' => '_swiper-hero',
				'swiper_container_class' => '',
				'slides_per_view_xsmall' => 1,
				'slides_per_view_small' => 1,
				'slides_per_view_medium' => 1,
				'slides_per_view_large' => 1,
				'slides_per_view_xlarge' => 1,
				'prev_next' => 'true',
				'pagination' => 'true',
				'autoplay' => 'true',
				'loop' => 'true',
				'centered_slides_bounds' => 'false',
				'centered_slides' => 'false',
				'center_insufficient_slides' => 'false',
				'slides_offset_before' => 0,
				'slides_offset_after' => 0,
				'free_mode' => 'false',
			]);
			?>
		</div>

<?php
	}
}
