<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

?>
	<div class="canva-wp-block canva-flex">

		<div class="_info canva-width-24 canva-p-4 canva-bg-grey-lighter">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">loghiSlider</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo apply_filters('loghi_slider_block_icon', '<span class="dashicons dashicons-images-alt2"></span>'); ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4 canva-bg-white">

			<?php
			$slider_loghi = get_field('slider_loghi');

			if ($slider_loghi) :
				foreach ($slider_loghi as $slider_logo) {
					echo canva_get_img([
						'img_id' => $slider_logo,
						'img_type' => 'img', // img, bg, url
						'thumb_size' => '320-free',
						'wrapper_class' => 'relative ratio-1-1',
						'img_class' => 'w-32',
						'blazy' => 'off',
					]);
				}
			?>

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

	if (!get_field('template_name')) {
		$template_name = 'block-loghi-slider';
	} else {
		$template_name = esc_attr(get_field('template_name'));
	}

	$slider_loghi = get_field('slider_loghi');

	if ($slider_loghi) {
	?>

		<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
			<?php
			canva_slider_post_ids([
				'post_ids' => $slider_loghi,
				'template_name' => $template_name,
				'swiper_hero_class' => get_field('css_classes'),
				'swiper_container_class' => 'py-4',
				'slides_per_view_xsmall' => 1,
				'slides_per_view_small' => get_field('slides_per_view_small'),
				'slides_per_view_medium' => get_field('slides_per_view_medium'),
				'slides_per_view_large' => get_field('slides_per_view_large'),
				'slides_per_view_xlarge' => get_field('slides_per_view_large'),
				'prev_next' => 'true',
				'pagination' => 'false',
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
