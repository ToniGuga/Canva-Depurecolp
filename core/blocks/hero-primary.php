<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

	if (!$is_preview) {
		/* rendering in inserter preview  */
		echo '<img src="' . CANVA_PROJECT_BLOCKS_URI . '/previews/' . basename($block['name']) . '.jpg" class="block-preview" style="width:100%; height:auto;">';
	}

?>

	<div class="canva-wp-block canva-flex">

		<div class="info canva-width-24 canva-p-4">

			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">
				<?php _e('Hero CTA', 'canva-backend'); ?>
			</span>

			<figure class="canva-width-12 canva-m-0">

				<!-- Icona -->
				<?php echo apply_filters('hero_two_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-2', null)); ?>
				<!-- Fine Icona -->

			</figure>

		</div>

		<div class="_content canva-flex-1 canva-p-4">

			<?php if (get_field('bg_image')) { ?>

				<div class="canva-block-icon-text canva-flex">

					<div class="canva-icon canva-mr-6 canva-mt-3">
						<?php
						echo canva_get_img([
							'img_id' => get_field('bg_image'),
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '640-free',
							'wrapper_class' => 'canva-width-24 canva-p-0 canva-m-0 canva-mr-4',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'off',
							'srcset' => 'off',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);
						?>
					</div>

					<div class="canva-info canva-flex-1 canva-ml-4">

						<span class="canva-block canva-mb-2 canva-fs-h2 canva-font-theme canva-fw-700 canva-lh-11">
							<?php the_field('title'); ?>
						</span>

						<span class="canva-block canva-fs-h4 canva-font-theme canva-lh-11">
							<?php the_field('content'); ?>
						</span>

						<span class="canva-block canva-fs-h4 canva-font-theme canva-lh-11">
							<?php the_field('form'); ?>
						</span>

					</div>

				</div>
			<?php } else { ?>
				<span class="canva-block canva-mb-2 canva-fs-h4 canva-font-theme canva-fw-700 canva-lh-11">
					Imposta il blocco
				</span>
			<?php } ?>
		</div>

	</div>

<?php } else { ?>

<?php
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

	$action_link = get_field('action_link');

	$target_link = '';
	if ($action_link && '_blank' === $action_link['target']) {
		$target_link = 'target="' . esc_attr($action_link['target']) . '" rel="noopener nofollower"';
	}

	if ($action_link) {
		$slug = wp_basename($action_link['url']);
		$track_event = canva_get_ga_event_tracker('Action-Link', 'click', $slug);
	}

	if ($action_link && '_blank' === $action_link['target']) {
		$target_link = 'target="' . esc_attr($action_link['target']) . '" rel="noopener nofollower"';
	}

	$link_1_classes = 'button mb-0';
	if (get_field('link_1_classes')) {
		$link_1_classes = esc_attr(get_field('link_1_classes'));
	}

	$cta = '';
	if ($action_link) {
		$cta = '<a class="' . $link_1_classes . '" href="' . esc_url($action_link['url']) . '" ' . $target_link . ' ' . $track_event . '>' . esc_html($action_link['title']) . '</a>';
	}

	$action_link_2 = get_field('action_link_2');

	$target_link_2 = '';
	if ($action_link_2 && '_blank' === $action_link_2['target']) {
		$target_link_2 = 'target="' . esc_attr($action_link_2['target']) . '" rel="noopener nofollower"';
	}

	if ($action_link_2) {
		$slug = wp_basename($action_link_2['url']);
		$track_event_2 = canva_get_ga_event_tracker('Action-Link', 'click', $slug);
	}

	if ($action_link_2 && '_blank' === $action_link_2['target']) {
		$target_link_2 = 'target="' . esc_attr($action_link_2['target']) . '" rel="noopener nofollower"';
	}

	$link_2_classes = 'button mb-0';
	if (get_field('link_2_classes')) {
		$link_2_classes = esc_attr(get_field('link_2_classes'));
	}

	$cta_2 = '';
	if ($action_link_2) {
		$cta_2 = '<a class="' . $link_2_classes . '" href="' . esc_url($action_link_2['url']) . '" ' . $target_link_2 . ' ' . $track_event_2 . '>' . esc_html($action_link_2['title']) . '</a>';
	}



	$layer_content_output = '';
	if (get_field('toptitle') || get_field('title') || get_field('subtitle') || get_field('action_link')) {
		$layer_content_output = '
				<div class="flex h-full flex-col justify-end p-4 sm:p-8 lg:p-12 xl:p-16 pt-32">

					<span class="block h3 fw-300 text-white">
						' . get_field('toptitle') . '
					</span>
					<h2 class="_title h1 lh-11 text-white">
						' . get_field('title') . '
					</h2>
					<span class="block mt-2 h4 font-secondary text-primary">
						' . get_field('subtitle') . '
					</span>

					<div class="_hero-primary-content mt-8">' . get_field('content') . '</div>
					<div class="_hero-button-box pt-4 isdark">
						' . $cta . '
						' . $cta_2 . '
					</div>

				</div>
			';
	}

	if (get_field('video_bg_file_url')) {
		$layer_picture = 'on';
	}

	$layer_filter = 'on';
	$layer_content = 'on';

	if(!$layer_content_output){
		$layer_filter = 'off';
		$layer_content = 'off';
	}

	canva_the_layer([
		'layer_type' => '_hero', // _hero, _card, _photobutton
		'layer_id' => esc_attr($id),
		'layer_class' => '' . esc_attr($className),

		'img_id' => get_field('bg_image'),
		'img_small_id' => get_field('bg_image_small'),
		'thumb_size' => '1920-free',
		'thumb_small_size' => '640-free',
		'video_url' => get_field('video_bg_file_url'),

		'layer_visual_class' => 'absolute',

		'layer_bg' => 'on',
		'layer_bg_class' => '',

		'layer_picture' => $layer_picture,
		'layer_picture_class' => '',

		'layer_filter' => $layer_filter,
		'layer_filter_class' => '',

		'layer_graphics' => 'off',
		'layer_graphics_class' => '',

		'layer_date' => 'off',
		'layer_date_class' => '',

		'layer_status' => 'off',
		'layer_status_class' => '',

		'layer_info' => 'off',
		'layer_info_class' => '',

		'layer_content' => $layer_content,
		'layer_content_class' => 'relative',
		'layer_content_output' => $layer_content_output,
	]);
}
