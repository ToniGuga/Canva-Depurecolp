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
//     'class_name' => $className,
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

<div id="<?php echo esc_attr($id); ?>" class="photobutton">

		<?php if ($link_wrap) : ?>

			<a class="<?php echo esc_attr($className) . ' ' . esc_attr($modal_class) . ' ' . esc_attr($button); ?>" <?php echo $href . ' ' . $target_link; ?> onclick="ga('send', 'event', 'Action-Link', 'Photobutton', '<?php echo $track_title; ?>');" <?php echo $modal_data_contet; ?>>

			<?php endif; ?>

			<div class="_photobutton _layer-wrap ratio-4-3 <?php echo esc_attr($className); ?> <?php echo esc_attr($isdark); ?>">


				<!-- Layer Visual -->
				<div class="_layer-visual absolute">

					<?php
					if ($bg_image) {
						$bg_image = canva_get_img([
							'img_id' => $bg_image,
							'img_type' => 'bg', // img, bg, url
							'thumb_size' => '960-free',
							'figure_class' => '_layer-bg ciccio',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'off',
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
							'figure_class' => '_layer-bg',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'off',
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
								'figure_class' => '_layer-bg',
								'img_class' => '',
								'bg_content' => '',
								'caption' => 'off',
								'blazy' => 'on',
								'srcset' => 'off',
								'data_attr' => '',
								'width' => '',
								'height' => '',
							]);

							$poster = 'poster = "' . $video_poster . '"';
						}
					?>

						<div class="_layer-video">
							<video class="" loop="loop" muted playsinline autoplay <?php echo $poster; ?>>
								<source src='<?php echo esc_attr($video_bg_file_url); ?>' type='video/mp4'>
							</video>
						</div>

					<?php else : ?>

						<div class="_layer-bg" <?php echo $image . ' ' . $image_small; ?>></div>

					<?php endif; ?>

					<div class="_layer-filter"></div>
					<div class="_layer-graphics"></div>

				</div>



				<!-- Layer content -->
				<div class="_layer-content absolute p-4">

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
						<h3 class="toptitle mb-1"><?php echo $photobutton_toptitle; ?></h3>
					<?php endif; ?>
					<?php if ($photobutton_title) : ?>
						<h3 class="title h2 mb-0"><?php echo $photobutton_title; ?></h3>
					<?php endif; ?>
					<?php if ($photobutton_subtitle) : ?>
						<span class="subtitle h5 mt-2 mb-0"><?php echo $photobutton_subtitle; ?></span>
					<?php endif; ?>
					<?php if ($photobutton_text) : ?>
						<span class="block"><?php echo $photobutton_text; ?></span>
					<?php endif; ?>

					<?php if (!$link_wrap) : ?>
						<a class="<?php echo esc_attr($className) . ' ' . esc_attr($modal_class) . ' ' . esc_attr($button); ?>" <?php echo $href . ' ' . $target_link; ?> onclick="ga('send', 'event', 'Action-Link', 'Photobutton', '<?php echo $track_title; ?>');" <?php echo $modal_data_contet; ?>><?php echo esc_html($button_title); ?></a>
					<?php endif; ?>
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
