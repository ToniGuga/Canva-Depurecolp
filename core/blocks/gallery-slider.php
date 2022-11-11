<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (is_admin() && !defined('DOING_AJAX')) {

?>
	<div class="canva-wp-block canva-flex">

		<div class="_info canva-width-24 canva-p-4 canva-bg-grey-lighter">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Gallery Slider</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->

			<figure class="canva-width-12 canva-m-0">
				<!-- ICONA -->
				<span class="dashicons dashicons-images-alt2"></span>
				<!-- Fine Icona -->
			</figure>

		</div>

		<div class="_content canva-flex canva-bg-white">
			<?php
			$imgs = get_field('gallery');

			if ($imgs) :
			?>

				<?php foreach ($imgs as $img) : ?>

					<?php
					echo canva_get_img([
						'img_id'   =>  $img,
						'img_type' => 'img', // img, bg, url
						'thumb_size' =>  '320-free',
						// 'img_class' => 'absolute px-4 w-full h-full object-contain object-center',
						'blazy' => 'off',
					]);
					?>

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

	$posts_object = get_field('post_object');

	$template_name = 'block-gallery-slider';
	if (get_field('template_name')) {
		$template_name = esc_attr(get_field('template_name'));
	}

	if (get_field('gallery')) {

		canva_get_template(sanitize_text_field($template_name), ['img_ids' => get_field('gallery')]);
	}
}
