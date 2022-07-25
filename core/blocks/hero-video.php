<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

	// filtro che permette di sovrascrivere l'icona di questo blocco
	// $default_icon = apply_filters('html_code_icon', '<svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="dashicon dashicons-admin-links"><path d="M17.74 2.76c1.68 1.69 1.68 4.41 0 6.1l-1.53 1.52c-1.12 1.12-2.7 1.47-4.14 1.09l2.62-2.61.76-.77.76-.76c.84-.84.84-2.2 0-3.04-.84-.85-2.2-.85-3.04 0l-.77.76-3.38 3.38c-.37-1.44-.02-3.02 1.1-4.14l1.52-1.53c1.69-1.68 4.42-1.68 6.1 0zM8.59 13.43l5.34-5.34c.42-.42.42-1.1 0-1.52-.44-.43-1.13-.39-1.53 0l-5.33 5.34c-.42.42-.42 1.1 0 1.52.44.43 1.13.39 1.52 0zm-.76 2.29l4.14-4.15c.38 1.44.03 3.02-1.09 4.14l-1.52 1.53c-1.69 1.68-4.41 1.68-6.1 0-1.68-1.68-1.68-4.42 0-6.1l1.53-1.52c1.12-1.12 2.7-1.47 4.14-1.1l-4.14 4.15c-.85.84-.85 2.2 0 3.05.84.84 2.2.84 3.04 0z"></path></svg>');
?>
	<div class="canva-wp-block canva-flex">

		<div class="_info canva-width-24 canva-p-4">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Canva Hero Video</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo apply_filters('hero_video_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-video', null)); ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4">
			<video class="video-hero-bg hero-bg flex-video medium-ratio-241" preload="auto" loop="loop" autoplay muted playsinline>
				<source src='<?php echo get_field('bg_video'); ?>' type='video/mp4'>
			</video>
			<span class="canva-block canva-fs-h2 canva-fw-700 sb-mb-2"><?php echo get_field('wysiwyg_left') ?></span>
			<span class="canva-block canva-fs-h4 canva-mb-4"><?php echo get_field('wysiwyg_left'); ?></span>
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

		$poster = '';

		if (get_field('bg_img')) {
			$video_poster = canva_get_img([
				'img_id' => get_field('bg_img'),
				'img_type' => 'url', // img, bg, url
				'thumb_size' => '1920-free',
			]);

			$poster = 'poster = "' . $video_poster . '"';
		}

		?>

		<div class="id-image-hero-container bg-black overflow-hidden relative z-0 p-8 md:p-12 min-h-vh-50 md:vh-50 lg:min-h-screen">

			<div class="id-top flex z-10 absolute top-0 left-0 items-center justify-center p-8 md:p-12 h-full w-full">

				<div class="container-medium flex flex-wrap items-center">

					<div class="w-full md:w-1/2">
						<?php the_field('wysiwyg_left'); ?>
					</div>

					<div class="w-full md:w-1/2">
						<?php the_field('wysiwyg_right'); ?>
					</div>

				</div>

			</div>

			<div class="id-hero-video-bg z-1 w-full top-0 left-0 bottom-0 right-0 absolute h-auto">

				<video class="min-w-full min-h-full" preload="auto" loop="loop" autoplay muted playsinline <?php echo $poster; ?>>

					<source src='<?php echo get_field('bg_video'); ?>' type='video/mp4'>

				</video>

			</div>

			<div class="id-hero-filter z-2 w-full top-0 left-0 bottom-0 right-0 absolute h-auto mix-blend-multiply bg-gradient-to-b from-gray-500 to-transparent"></div>

		</div>

	<?php } //endif
