<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (is_admin()) {

	if (!$is_preview) {
		/* rendering in inserter preview  */
		echo '<img src="' . CANVA_PROJECT_BLOCKS_URI . '/previews/' . basename($block['name']) . '.jpg" class="block-preview" style="width:100%; height:auto;">';
	}

?>

	<div class="canva-wp-block canva-flex">

		<div class="info canva-width-24 canva-p-4">

			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">
				<?php _e('Hero Settore', 'canva-backend'); ?>
			</span>

			<figure class="canva-width-12 canva-m-0">

				<!-- Icona -->
				<?php echo apply_filters('hero_two_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-2', null)); ?>
				<!-- Fine Icona -->

			</figure>

		</div>

		<div class="_content canva-flex-1 canva-p-4">

				<div class="canva-block-icon-text canva-flex">

					<div class="canva-icon canva-mr-6 canva-mt-3">
						<?php
						echo canva_get_img([
							'img_id' => get_field('image'),
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
							<?php the_field('subtitle'); ?>
						</span>

							<InnerBlocks />

					</div>

				</div>
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

	$cta = '';
	if ($action_link) {
		$cta = '<a class="button transform-gpu -translate-y-1/2" href="' . esc_url($action_link['url']) . '" ' . $target_link . ' ' . $track_event . '>' . esc_html($action_link['title']) . '</a>';
	}

	if (get_field('title') || get_field('content') || get_field('action_link')) {

		if (!get_field('seo_title')) {
			$layer_content_output = '
				<div class="_row _primo-default-row w-full xs:visible md:invisible">
					<div class="_col p-0 text-center">
						<div class="p-4 bg-white rounded-t-lg -mt-12 md:mt-0">
							<span class="_title block uppercase h2">
								' . get_field('title') . '
							</span>
							<p>
							' . get_field('content') . '
							</p>
						</div>
						<div class="w-full">
							' . $cta . '
						</div>
					</div>
				</div>
				<div class="_row _primo-default-row w-full xs:invisible md:visible">
					<div class="_col p-0 md:w-1/2 text-center">
						<div class="p-4 md:p-8 bg-white bg-opacity-80 rounded-b-xl">
							<span class="_title block uppercase h2">
								' . get_field('title') . '
							</span>
							<p>
							' . get_field('content') . '
							</p>
						</div>
						<div class="w-full">
							' . $cta . '
						</div>
					</div>
				</div>
			';
		} else {
			$layer_content_output = '
				<div class="_row _primo-default-row w-full md:hidden">
					<div class="_col p-0 text-center">
						<div class="p-4 bg-white rounded-t-lg -mt-12 md:mt-0">
							<h1 class="_title block h2 uppercase">
								' . get_field('title') . '
							</h1>
							<p>
							' . get_field('content') . '
							</p>
						</div>
						<div class="w-full">
							' . $cta . '
						</div>
					</div>
				</div>

				<div class="_row _primo-default-row w-full hidden md:flex">
					<div class="_col p-0 md:w-1/2 text-center">
						<div class="p-4 md:p-8 bg-white bg-opacity-90 rounded-b-xl ">
							<h1 class="_title block h2 uppercase">
								' . get_field('title') . '
							</h1>
							<p>
							' . get_field('content') . '
							</p>
						</div>
						<div class="w-full">
							' . $cta . '
						</div>
					</div>
				</div>
			';
		}
	}

	canva_the_layer([
		'layer_type' => '_hero _hero-cta pb-16 md:pb-24 -mx-2 md:-mx-4 lg:mx-0', // _hero, _card, _photobutton
		'layer_id' => esc_attr($id),
		'layer_class' => 'flex-wrap' . esc_attr($className),

		'img_id' => get_field('image'),
		// 'img_small_id' => get_field('bg_image_small'),
		'thumb_size' => '1920-free',
		'thumb_small_size' => '640-free',
		'video_url' => get_field('video_bg_file_url'),

		'layer_visual_class' => 'relative min-h-66vw rounded-none md:absolute md:h-full md:min-h-auto w-full md:h-auto lg:rounded-b-xl',

			'layer_bg' => 'on',
			'layer_bg_class' => 'bg-cover bg-center',

			'layer_picture' => 'off',
			'layer_picture_class' => 'relative w-full h-96 md:absolute md:h-auto',

			'layer_filter' => 'on',
			'layer_filter_class' => '',

			'layer_graphics' => 'off',
			'layer_graphics_class' => '',

			'layer_date' => 'off',
			'layer_date_class' => '',

			'layer_status' => 'off',
			'layer_status_class' => '',

			'layer_info' => 'off',
			'layer_info_class' => '',

		'layer_content' => 'on',
		'layer_content_class' => 'relative flex flex-wrap items-start w-full px-4 md:px-8 lg:px-16 xl:px-24',
		'layer_content_output' => $layer_content_output,
	]);
}
