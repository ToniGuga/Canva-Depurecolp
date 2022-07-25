<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

// Elenco Variabili per promemoria
//
// $args = [
//     'id' => $id,
//     'class_name' => $class_name,
//     'isdark' => $isdark,
//     'isdark' => $isdark,
//     'action_link' => $action_link,
//     'target_link' => $target_link,
//     'href' => $href,
//     'modal' => $modal,
//     'modal_class' => $modal_class,
//     'modal_data_contet' => $modal_data_contet,
//     'track_title' => $track_title,
//     'link_wrap' => $link_wrap,
//     'button' => $button,
//     'button_title' => $button_title,
//     'bg_image' => $bg_image,
//     'bg_image_small' => $bg_image_small,
//     'video_bg_file_url' => $video_bg_file_url,
//     'icon' => $icon,
//     'photobutton_toptitle' => $photobutton_toptitle,
//     'photobutton_title' => $photobutton_title,
//     'photobutton_subtitle' => $photobutton_subtitle,
//     'photobutton_text' => $photobutton_text,
//     'modal_content' => $modal_content,
//     'wysiwyg' => $wysiwyg,
//     'post_content' => $post_content,
// ];

?>

<div id="<?php echo esc_attr($id); ?>" class="wp-block-photobutton">

		<?php if ($link_wrap) : ?>

			<a class="<?php echo esc_attr($modal_class); ?>" <?php echo $href . ' ' . $target_link; ?> <?php echo canva_get_ga_event_tracker($eventCategory = 'Action-Link', $eventAction = 'Photobutton', $eventLabel = $event_label);  ?> <?php echo $modal_data_contet; ?>>

			<?php endif; ?>

			<?php
			// Il _pb-fixed-ratio dà al photobutton un ratio di deafult definito nella variabile --pb-ratio, ma si può poi sovrascrivere da template o da backend wp con ratio-X-Y md:ratio-X-Y
			?>
			<div class="_photobutton _pb-fixed-ratio _layer-wrap <?php echo esc_attr($class_name); ?> <?php echo esc_attr($isdark); ?>">

				<!-- Layer Visual -->
				<div class="_layer-visual absolute">

					<?php
					if ($bg_image) {
						$bg_image = canva_get_img([
							'img_id' => $bg_image,
							'img_type' => 'url', // img, bg, url
							'thumb_size' => '960-free',
							'figure_class' => '_layer-bg _pb-bg',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'on',
							'srcset' => 'off',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);

						$image = 'data-src = "' . $bg_image . '"';
					}

					if ($bg_image_small) {
						$bg_image_small = canva_get_img([
							'img_id' => $bg_image_small,
							'img_type' => 'url', // img, bg, url
							'thumb_size' => '960-free',
							'figure_class' => '_layer-bg _pb-bg',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'on',
							'srcset' => 'off',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);

						$image_small = 'data-src-small="' . $bg_image_small . '"';
					}
					?>

					<?php
					if ($video_bg_file_url) :

						$poster = '';

						if ($bg_image) {
							$video_poster = canva_get_img([
								'img_id' => $bg_image,
								'img_type' => 'url', // img, bg, url
								'thumb_size' => '960-free',
								'figure_class' => '_layer-bg _pb-bg',
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

						<div class="_layer-picture _pb-picture">
							<video class="" loop="loop" muted playsinline autoplay <?php echo $poster; ?>>
								<source src='<?php echo esc_attr($video_bg_file_url); ?>' type='video/mp4'>
							</video>
						</div>

					<?php else : ?>

						<div class="_layer-bg _pb-bg b-lazy" <?php echo $image . ' ' . $image_small; ?>></div>

					<?php endif; ?>

					<div class="_layer-filter _pb-filter"></div>
					<div class="_layer-graphics"></div>

				</div>



				<!-- Layer content -->
				<div class="_layer-content absolute bottom-0">

					<?php
					// Il content-wrap è fatto in flex per permettere di allineare i contenuti in fondo quando necessario, senza dover passare al position absolute
					?>

					<div class="_content-wrap p-8">

						<?php if ($icon) : ?>
							<?php
							echo canva_get_img([
								'img_id' => $icon,
								'img_type' => 'img', // img, bg, url
								'thumb_size' => '160-free',
								'figure_class' => 'width-16',
								'img_class' => 'width-16',
								'bg_content' => '',
								'caption' => 'off',
								'blazy' => 'on',
								'srcset' => 'off',
								'data_attr' => '',
								'width' => '',
								'height' => '',
							]);
							?>
						<?php endif; ?>
						<?php if ($photobutton_toptitle) : ?>
							<h3 class="_pb-toptitle block fs-p mb-2"><?php echo $photobutton_toptitle; ?></h3>
						<?php endif; ?>
						<?php if ($photobutton_title) : ?>
							<h3 class="_pb-title block h2 lh-11 mb-0"><?php echo $photobutton_title; ?></h3>
						<?php endif; ?>
						<?php if ($photobutton_subtitle) : ?>
							<span class="_pb-subtitle h5 mt-4 mb-0"><?php echo $photobutton_subtitle; ?></span>
						<?php endif; ?>
						<?php if ($photobutton_text) : ?>
							<span class="_pb-text block mt-4 mb-0"><?php echo $photobutton_text; ?></span>
						<?php endif; ?>

						<?php if (!$hide_button) : ?>
							<div class="_pb-button-box mt-6">
							<?php if (!$link_wrap) : ?>
									<a class=" <?php echo esc_attr($button_classes) .' ' . esc_attr($modal_class); ?>" <?php echo $href . ' ' . $target_link; ?> <?php echo canva_get_ga_event_tracker($eventCategory = 'Action-Link', $eventAction = 'Photobutton', $eventLabel = $event_label);  ?> <?php echo $modal_data_contet; ?>><?php echo esc_html($button_title); ?></a>
								<?php else: ?>
									<span class="<?php echo esc_attr($button_classes) .' ' . esc_attr($modal_class); ?>" <?php echo $modal_data_contet; ?>><?php echo esc_html($button_title); ?></span>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					</div>

				</div>
			</div>

			<?php if ($link_wrap) : ?>
			</a>
		<?php endif; ?>

		<?php if ($modal) : ?>

			<?php if ($modal_content === 'modal_content_html') : ?>

				<div class="hide <?php echo esc_attr($id); ?>">
					<?php echo $wysiwyg; ?>
				</div>

			<?php else : ?>

				<div class="hide <?php echo esc_attr($id); ?>">
					<?php echo $post_content; ?>
				</div>

			<?php endif; ?>

		<?php endif; ?>

	</div>
