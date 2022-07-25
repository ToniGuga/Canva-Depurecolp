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
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Hero Carosello Slider</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo apply_filters('hero_slider_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-slider', null)); ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4">
			<?php
			if (have_rows('hero_slider')) {
				while (have_rows('hero_slider')) {
					the_row();
			?>
					<?php
					if (get_sub_field('video_embed')) {
						echo get_sub_field('video_embed');
					} elseif (get_sub_field('video_bg_file_url')) {
					?>

						<video class="video-hero-bg hero-bg flex-video medium-ratio-241" preload="auto" loop="loop" autoplay muted playsinline>
							<source src='<?php echo get_sub_field('video_bg_file_url'); ?>' type='video/mp4'>
						</video>
						<span class="canva-block canva-fs-h2 canva-fw-700 sb-mb-2"><?php echo get_sub_field('title') ?></span>
						<span class="canva-block canva-fs-h4 canva-mb-4"><?php echo get_sub_field('subtitle'); ?></span>

					<?php } else { ?>

						<?php
						// echo canva_get_attachment_thumbnail(get_sub_field('image'), $type = 'img', $size = '640-free', $class_figure = 'canva-m-0', $class_img = '', $bg_content = '', $caption = '', $blazy = 'off');


						echo canva_get_img([
							'img_id' => get_sub_field('image'),
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '320-free',
							'wrapper_class' => 'canva-m-0',
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

						<span class="canva-block canva-fs-h2 canva-fw-700 sb-mb-2"><?php echo get_sub_field('title') ?></span>
						<span class="canva-block canva-fs-h4 canva-mb-4"><?php echo get_sub_field('subtitle'); ?></span>

					<?php } ?>

			<?php
				}
			}
			?>
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

		$hero_slider = get_field('hero_slider');

		$autoplay = '';
		// check if first slide is a video embed
		if ($hero_slider[0]['slide_type'] === 'classic_video') {
			$autoplay = 'autoplay preload="auto"';
		}

		?>

		<?php if (have_rows('hero_slider')) { ?>

			<div id="<?php echo esc_attr($id); ?>" class="_hero_slider swiper-container overflow-hidden relative z-0 p-8 md:p-12<?php echo esc_attr($className); ?>">
				<div class="swiper-wrapper">

					<?php
					while (have_rows('hero_slider')) {
						the_row();

						$isdark = '';
						if (get_sub_field('dark_mode')) {
							$isdark = 'isdark';
						}

						$action_link = get_sub_field('link');

						$action_link_taget = '';
						if ($action_link && $action_link['target'] === '_blank') {
							$action_link_taget =  'target="' . esc_attr($action_link['target']) . '" rel="noopener nofollower"';
						}
					?>

						<!-- Container per singola slide dello swiper -->
						<div class="swiper-slide min-h-vw-100 md:vh-50 lg:min-h-vh-75 <?php echo esc_attr($isdark); ?>" data-index="<?php echo get_row_index(); ?>">

							<!-- Container slide-hero tema Canva -->
							<div class="slide-hero-container flex p-0">


								<!-- Se la slide contiene un Video Embed -->
								<?php if (get_sub_field('video_embed')) { ?>

									<div class="video-hero-embed hero-content w-100 flex-video medium-ratio-241">
										<?php echo get_sub_field('video_embed'); ?>
									</div>


									<!-- Se la slide contiene uno strato di content -->
								<?php } elseif (get_sub_field('toptitle') || get_sub_field('title') || get_sub_field('subtitle')) { ?>

									<div class="_hero_content id-bottom md:block z-10 absolute bottom-0 right-0 p-8 md:p-12 bg-black bg-opacity-50 m-12">
										<?php if (get_sub_field('toptitle')) { ?>
											<span class="_title mb-0 text-white text-6xl uppercase mb-6"><?php echo get_sub_field('toptitle'); ?></span>
										<?php }
										if (get_sub_field('title')) { ?>
											<span class="_title mb-0 text-white text-6xl uppercase mb-6"><?php echo get_sub_field('title'); ?></span>
										<?php }
										if (get_sub_field('subtitle')) { ?>
											<span class="block fs-h4 fw-300"><?php echo get_sub_field('subtitle'); ?></span>
										<?php }
										if ($action_link) { ?>
											<a class="button mr-2 mb-2" href="<?php echo esc_url($action_link['url']); ?>" <?php echo $action_link_taget; ?>><?php echo esc_html($action_link['title']); ?></a>
										<?php } ?>
									</div>

								<?php } ?>

								<?php if (get_sub_field('video_bg_file_url')) { ?>

									<div class="hero-video-bg">
										<?php
										$poster = '';
										if (get_sub_field('video_poster')) {
											$video_poster = canva_get_img([
												'img_id' => get_sub_field('video_poster'),
												'img_type' => 'url', // img, bg, url
												'thumb_size' => '1920-free',
												'figure_class' => 'hero-bg',
												'img_class' => '',
												'bg_content' => '',
												'caption' => 'off',
												'blazy' => 'off',
												'srcset' => 'off',
												'data_attr' => '',
												'width' => '',
												'height' => '',
											]);

											$poster = 'poster = "' . $video_poster . '"';
										}

										?>

										<video class="video-bg" loop="loop" muted playsinline <?php echo $autoplay . ' ' . $poster; ?>>
											<source src='<?php echo get_sub_field('video_bg_file_url'); ?>' type='video/mp4'>
										</video>

									</div>

									<div class="hero-filter"></div>

								<?php } elseif (get_sub_field('image')) { ?>

									<?php

									echo canva_get_img([
										'img_id' => get_sub_field('image'),
										'img_type' => 'bg', // img, bg, url
										'thumb_size' => '1920-free',
										'wrapper_class' => '_hero_bg z-1 w-full top-0 left-0 bottom-0 right-0 absolute h-auto bg-no-repeat bg-center bg-cover',
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

									<div class="hero-filter"></div>

								<?php } ?>

							</div>
						</div>
					<?php
					} //endforeach
					?>

				</div>

				<div class="swiper-pagination"></div>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>

			</div>

	<?php } //endif

	}
