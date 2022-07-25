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
				<?php _e('Hero Trattamento', 'canva-backend'); ?>
			</span>

			<figure class="canva-width-12 canva-m-0">

				<!-- Icona -->
				<?php echo apply_filters('hero_two_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-2', null)); ?>
				<!-- Fine Icona -->

			</figure>

		</div>

		<div class="_content canva-flex-1 canva-p-4">

			<!-- < class="canva-block-icon-text canva-flex"> -->

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



			<div class="canva-info canva-flex-1 canva-ml-4">

				<span class=""></span>




			</div>




		</div>
	</div>

	</div>

<?php } else {


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


	$layer_content_output = '';
	if (get_field('toptitle') || get_field('title') || get_field('subtitle')) {
		$layer_content_output .= '<div class="_main__section wp-block-columns isdark items-center">';
	}

	if (get_field('toptitle') || get_field('title')) {
		$layer_content_output .= '<div class="wp-block-column col-span-12 lg:col-span-4">';
	}

		if (get_field('toptitle')) {
			$layer_content_output .= '
							<span class="block h3 fw-300">
							' . get_field('toptitle') . '
							</span>';
		}

		if (get_field('title')) {
			$layer_content_output .= '
							<h1 class="_title lh-11 slide-in-left">
							' . get_field('title') . '
							</h1>';
	}

	if (get_field('toptitle') || get_field('title')) {
		$layer_content_output .= '</div>';
	}

	if (get_field('subtitle')) {
		$layer_content_output .= '
						<div class="wp-block-column col-span-12 lg:col-span-4">
							<h2 class="block fs-h3">
							' . get_field('subtitle') . '
							</h2>
						</div>
						';
	}

	if (get_field('toptitle') || get_field('title') || get_field('subtitle')) {
		$layer_content_output .= '</div>';
	}




	if (get_field('video_bg_file_url')) {
		$layer_picture = 'on';
	}

	$layer_filter = 'on';
	$layer_content = 'on';

	if (!$layer_content_output) {
		$layer_filter = 'off';
		$layer_content = 'off';
	}

	canva_the_layer([
		'layer_type' => '_hero _hero-trattamento', // _hero, _card, _photobutton
		'layer_id' => esc_attr($id),
		'layer_class' => '' . esc_attr($className),

		'img_id' => get_field('image'),
		'img_small_id' => get_field('image_small'),
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

		'layer_graphics' => 'on',
		'layer_graphics_class' => 'wave-bottom',

		'layer_date' => 'off',
		'layer_date_class' => '',

		'layer_status' => 'off',
		'layer_status_class' => '',

		'layer_info' => 'off',
		'layer_info_class' => '',

		'layer_content' => $layer_content,
		'layer_content_class' => 'relative flex items-center',
		'layer_content_output' => $layer_content_output,
	]);
?>

	<div class="_main__section bg-primary isdark py-16">
		<div class="wp-block-columns mb-0">
			<div class="wp-block-column col-span-12 lg:col-span-6 lg:col-start-7">
				<InnerBlocks />
			</div>
		</div>
	</div>

<?php
}
