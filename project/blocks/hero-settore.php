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

		<div class="_content canva-flex-1 canva-p-4" style="background:#f0f0f0;">

			<div class="_main-info canva-flex">

				<div class="_image">
					<?php
					echo canva_get_img([
						'img_id' => get_field('image'),
						'img_type' => 'img', // img, bg, url
						'thumb_size' => '320-11',
						'wrapper_class' => 'canva-width-24 canva-p-0 canva-m-0',
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

				<div class="_info canva-flex-1 canva-p-4">
					<span class="canva-block canva-mb-2 canva-fs-h6 canva-font-theme canva-fw-700 canva-lh-11">
						<?php the_field('toptitle'); ?>
					</span>
					<span class="canva-block canva-mb-2 canva-fs-h2 canva-font-theme canva-fw-700 canva-lh-11">
						<?php the_field('title'); ?>
					</span>
					<span class="canva-block canva-fs-h4 canva-font-theme canva-lh-11">
						<?php the_field('subtitle'); ?>
					</span>
				</div>

			</div>
		</div>

		<InnerBlocks />

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
	} ?>


	<div class="_main__section">
		<div class="_row bg-gray-100 rounded-lg overflow-hidden">


			<?php if (get_field('image')) { ?>
				<div class="_col hidden md:flex p-0 w-1/3 lg:w-5/12">
					<?php
					echo canva_get_img([
						'img_id' => get_field('image'),
						'img_type' => 'img', // img, bg, url
						'thumb_size' => '640-free',
						'wrapper_class' => 'h-full bg-primary',
						'img_class' => 'h-full object-cover',
						'bg_content' => '',
						'caption' => 'off',
						'blazy' => 'on',
						'srcset' => 'off',
						'data_attr' => '',
						'width' => '',
						'height' => '',
					]);
					?>
				</div>

				<div class="_col p-0 w-full md:hidden">
					<?php
					if (get_field('bg_img_small')) {
						echo canva_get_img([
							'img_id' => get_field('bg_img_small'),
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '640-free',
							'wrapper_class' => 'h-full bg-primary',
							'img_class' => 'h-full object-cover',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'on',
							'srcset' => 'off	',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);
					} else {
						echo canva_get_img([
							'img_id' => get_field('image'),
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '640-free',
							'wrapper_class' => 'h-full bg-primary',
							'img_class' => 'h-full object-cover',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'on',
							'srcset' => 'off	',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);
					}
					?>
				</div>
			<?php } ?>

			<div class="_col w-full md:w-2/3 lg:w-7/12" style="padding: 8.333333%">

				<?php if (get_field('title')) { ?>
					<h1 class="mb-12">
						<?php if (get_field('toptitle')) { ?>
							<span class="block fs-sm mb-2"><?php echo get_field('toptitle'); ?></span>
						<?php } ?>
						<span class="slide-in-left fs-h2 sm:fs-h1 block lh-10"><?php echo get_field('title'); ?></span>
					</h1>
				<?php } ?>

				<InnerBlocks />

			</div>

		</div>
	</div>

<?php }
