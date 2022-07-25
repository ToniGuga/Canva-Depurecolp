<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {
?>

	<div class="canva-wp-block canva-flex">

		<div class="info canva-width-24 canva-p-4">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style=""><?php _e('Hero Primary', 'canva-backend'); ?></span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">
				<?php echo apply_filters('hero_primary_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-1', null)); ?>
			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4">

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
					<span class="canva-block canva-mb-2 canva-fs-h5 canva-font-theme canva-lh-11">
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

	</div>



<?php } else { ?>

	<?php
	// $element_id = 'rid-'. rand(10,1000);
	// if(get_field('element_id')){
	//     $element_id =  esc_attr(get_field('element_id'));
	// }

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
	<div id="<?php echo esc_attr($id); ?>" class="hero-image<?php echo esc_attr($className); ?>">

		<div class="id-image-hero-container overflow-hidden relative z-0 p-8 md:p-12 md:text-right min-h-50vh md:vh-50 lg:min-h-75vh">

			<?php if (get_field('toptitle')) : ?>

				<div class="id-top absolute z-10 top-0 right-0 p-8 md:p-12">

					<span class="block mb-2 text-sm text-white">
						<?php the_field('toptitle'); ?>
					</span>

				</div>

			<?php elseif (!is_singular(array('post', 'page'))) : ?>

				<div class="id-top absolute z-10 top-0 right-0 p-8 md:p-12">

					<span class="block mb-2 text-sm text-white">
						<?php echo get_post_type(get_the_ID()); ?>
					</span>

				</div>

			<?php endif; ?>

			<!-- Blocco Icona + Titolo per medium-up -->
			<div class="id-bottom md:block z-10 absolute bottom-0 right-0 p-8 md:p-12 md:text-right">

				<?php if (get_field('title')) : ?>

					<h1 class="id-hero-title mb-0 text-white">
						<?php the_field('title'); ?>
					</h1>

				<?php endif; ?>

				<?php if (get_field('subtitle')) : ?>

					<h2 class="id-subtitle h4 mt-2 text-white">
						<?php the_field('subtitle'); ?>
					</h2>

				<?php endif; ?>

			</div>

			<?php if (get_field('bg_image')) : ?>

				<?php
				$bg_image = canva_get_img([
					'img_id' => get_field('bg_image'),
					'img_type' => 'url', // img, bg, url
					'thumb_size' => '1920-free',
					'wrapper_class' => '',
					'img_class' => '',
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => 'off',
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);

				$bg_image_small = canva_get_img([
					'img_id' => get_field('bg_image_small'),
					'img_type' => 'url', // img, bg, url
					'thumb_size' => '1920-free',
					'wrapper_class' => '',
					'img_class' => '',
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => 'off',
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);

				if (get_field('bg_image')) :
					$image = 'data-src="' . $bg_image . '"';
				endif;

				if (get_field('bg_image_small')) :
					$image_small = 'data-src-small="' . $bg_image_small . '"';
				endif;
				?>

				<div class="id-hero-bg z-1 w-full top-0 left-0 bottom-0 right-0 absolute h-auto bg-no-repeat bg-center bg-cover b-lazy rounded-lg" <?php echo $image . ' ' . $image_small ?>></div>

			<?php elseif (get_field('video_bg_file_url')) : ?>

				<div class="hero-video-bg">
					<!-- !!! verificare -->

					<video class="" preload="auto" loop="loop" autoplay muted playsinline>

						<source src='<?php echo get_sub_field('video_bg_file_url'); ?>' type='video/mp4'>

					</video>

				</div>

			<?php endif; ?>

			<div class="id-hero-filter z-2 w-full top-0 left-0 bottom-0 right-0 absolute h-auto"></div>

		</div>
	</div>

<?php }
