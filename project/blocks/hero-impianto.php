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
				<?php _e('Hero Impianti', 'canva-backend'); ?>
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

				<div class="_info canva-flex-1 canva-p-4">
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
	$hero_pb = '';
	if (get_field('image')) {
		$hero_pb = 'pb-32';
	}
?>

	<div class="_main__section">
		<div class="_hero-impianto wp-block-columns bg-gray-100 rounded-xl overflow-hidden gap-y-16 py-16 <?php echo $hero_pb; ?>">

			<div class="_col-1 col-span-12 lg:col-span-6 xl:col-span-5 xxl:col-span-4x px-8 md:px-12 lg:px-16 xl:px-16">
				<h1 class="fs-h2 xl:fs-h1 break-words mb-16 slide-in-left"><?php echo get_field('title'); ?></h1>

				<?php if (get_field('types')) { ?>
					<span class="block mt-4"><a class="no-underline arrow-after" href="#impianto-tipologie">Tipologie</a></span>
				<?php } ?>

				<?php if (get_field('case_history')) { ?>
					<span class="block mt-4"><a class="no-underline arrow-after" href="#impianto-case-history">Case History</a></span>
				<?php } ?>

				<div class="_trattamenti-wrap mt-8">
					<?php
						$terms = canva_get_post_terms(get_the_ID(), 'cat_trattamento', $term_data = 'slug');

						echo canva_get_posts_per_term($post_type = 'trattamento', $taxonomy = 'cat_trattamento', $field_type = 'slug', $terms, $template_name = 'tag-trattamento', $posts_per_page = -1, $order = 'DESC', $orderby = 'date', $facetwp = false);
					?>
				</div>

			</div>

			<div class="_col-2 col-span-12 lg:col-span-6 xl:col-span-7 xxl:col-span-8x px-8 md:px-12 lg:pl-0 lg:pr-16 xl:pr-24 xxl:pr-32">
				<InnerBlocks />
			</div>

		</div>
	</div>

	<div class="_main__section _impianto-image">

		<div class="wp-block-columns">
			<div class="_col-2 col-span-12 lg:col-span-6 lg:col-start-6 lg:col-start-7 xl:col-span-7 xl:col-start-6 xxl:col-span-8x xxl:col-start-5x px-8 md:px-12 lg:pl-0 lg:pr-0">

				<?php if(get_field('image')){
					echo canva_get_img([
							'img_id' => get_field('image'),
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '',
							'wrapper_class' => 'rounded-md overflow-hidden -mt-24',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'on',
							'srcset' => 'off',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);
					}
				?>
			</div>
		</div>

	</div>

<?php
}
