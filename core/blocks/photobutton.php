<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

	// filtro che permette di sovrascrivere l'icona di questo blocco
	// $default_icon = apply_filters('html_code_icon', '<svg aria-hidden="true" role="img" focusable="false" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="dashicon dashicons-admin-links"><path d="M17.74 2.76c1.68 1.69 1.68 4.41 0 6.1l-1.53 1.52c-1.12 1.12-2.7 1.47-4.14 1.09l2.62-2.61.76-.77.76-.76c.84-.84.84-2.2 0-3.04-.84-.85-2.2-.85-3.04 0l-.77.76-3.38 3.38c-.37-1.44-.02-3.02 1.1-4.14l1.52-1.53c1.69-1.68 4.42-1.68 6.1 0zM8.59 13.43l5.34-5.34c.42-.42.42-1.1 0-1.52-.44-.43-1.13-.39-1.53 0l-5.33 5.34c-.42.42-.42 1.1 0 1.52.44.43 1.13.39 1.52 0zm-.76 2.29l4.14-4.15c.38 1.44.03 3.02-1.09 4.14l-1.52 1.53c-1.69 1.68-4.41 1.68-6.1 0-1.68-1.68-1.68-4.42 0-6.1l1.53-1.52c1.12-1.12 2.7-1.47 4.14-1.1l-4.14 4.15c-.85.84-.85 2.2 0 3.05.84.84 2.2.84 3.04 0z"></path></svg>');
?>

	<div class="canva-wp-block">

		<div class="_info canva-flex align-middle">
			<figure class="canva-width-12 canva-m-0 canva-bg-grey-lightest canva-p-2">
				<!-- ICONA -->
				<?php
				// filtro che permette di sovrascrivere l'icona di questo blocco
				echo apply_filters('row_w_100_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-100', null));
				?>
				<!-- Fine Icona -->
			</figure>
			<div class="canva-flex-1 canva-p-4">
				<span class="title canva-block canva-mb-1 canva-fs-small canva-font-system canva-fw-700 canva-lh-12" style=""><?php _e('Photobutton', 'canva-backend'); ?></span>
				<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
				<span class="canva-block canva-mt-0 canva-mb-0 canva-fs-xxsmall canva-font-theme canva-lh-11"><?php echo esc_html('Con scelta template file', 'canva-backend'); ?></span>
			</div>
		</div>

		<div class="_content canva-p-0">
			<div class="_pb-img">
				<?php
				// echo canva_get_attachment_thumbnail(get_field('bg_image'), $type = 'img', $size = '640-free', $class_figure = 'sg-m-0 sg-mb-4 sg-max-width-480', $class_img = '', $bg_content = '', $caption = 'off', $blazy = 'off');
				echo canva_get_img([
					'img_id'   =>  get_field('bg_image'),
					'img_type' => 'img', // img, bg, url
					'thumb_size' =>  '640-free',
					'img_class' =>  '',
					'wrapper_class' =>  'canva-m-0 canva-max-width-480',
					'blazy' => 'off',
				]);
				?>
			</div>
			<div class="_pb-content canva-p-4">
				<span class="canva-block canva-mb-0 canva-fs-h3 canva-font-theme canva-fw-700 canva-lh-11"><?php the_field('title'); ?></span>
				<span class="canva-block canva-fs-h5 canva-font-theme canva-lh-11"><?php the_field('subtitle'); ?></span>
				<span class="canva-block canva-fs-small canva-font-theme canva-lh-11"><?php the_field('text'); ?></span>
			</div>
		</div>

	</div>

<?php } else { ?>

	<?php
	// var_dump($block);

	// Create id attribute allowing for custom "anchor" value.
	$id = $block['id'];
	if (!empty($block['anchor'])) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$className = '';
	if (!empty($block['className'])) {
		$className = ' ' . $block['className'];
	}

	$isdark = '';
	if (get_field('dark_mode')) {
		$isdark = 'isdark';
	}


	$action_link = get_field('action_link');
	$target_link = '';
	$href = '';
	$event_label = '';
	$button_title = '';

	if($action_link){

		if ('_blank' === $action_link['target']) {
			$target_link = 'target="' . esc_attr($action_link['target']) . '" rel="noopener nofollower"';
		}

		if ('' !== $action_link['url']) {
			$href = 'href="' . esc_url($action_link['url']) . '"';
			$event_label = wp_basename($action_link['url']);
		}

		$button_title = $action_link['title'];
	}

	$modal = get_field('modal');
	$modal_class = '';
	$modal_data_contet = '';
	$track_title = 'Photobutton-Link';

	if ($modal) {
		$modal_class = 'modal-open';
		$modal_data_contet = 'data-modal-content="' . esc_attr($id) . '"';
		$track_title = 'Photobutton-Modal';
	}

	$link_wrap = get_field('link_wrap');
	$hide_button = get_field('hide_button');

	if (!$link_wrap) {
		if ($modal) {
			$button_title = get_field('modal_button_title');
		}
	}

	$button_classes = 'button mb-0';
	if(get_field('button_classes')){
		$button_classes = esc_attr(get_field('button_classes'));
	}

	$bg_image = get_field('bg_image');
	$bg_image_small = get_field('bg_image_small');
	$video_bg_file_url = get_field('video_bg_file_url');
	$icon = get_field('icon');
	$photobutton_toptitle = get_field('toptitle');
	$photobutton_title = get_field('title');
	$photobutton_subtitle = get_field('subtitle');
	$photobutton_text = get_field('text');

	$modal_content = get_field('modal_content');
	$wysiwyg = get_field('wysiwyg', false, false);
	$post_content = get_field('post_object')->post_content;

	$template_name = 'block-photobutton-elastic';
	if(get_field('template_name')){
		$template_name = esc_attr(get_field('template_name'));
	}

	$args = [
		'id' => $id,
		'class_name' => $className,
		'isdark' => $isdark,
		'action_link' => $action_link,
		'target_link' => $target_link,
		'href' => $href,
		'event_label' => $event_label,
		'modal' => $modal,
		'modal_class' => $modal_class,
		'modal_data_contet' => $modal_data_contet,
		'track_title' => $track_title,
		'link_wrap' => $link_wrap,
		'button_title' => $button_title,
		'hide_button'=> $hide_button,
		'button_classes' => $button_classes,
		'bg_image' => $bg_image,
		'bg_image_small' => $bg_image_small,
		'video_bg_file_url' => $video_bg_file_url,
		'icon' => $icon,
		'photobutton_toptitle' => $photobutton_toptitle,
		'photobutton_title' => $photobutton_title,
		'photobutton_subtitle' => $photobutton_subtitle,
		'photobutton_text' => $photobutton_text,
		'modal_content' => $modal_content,
		'wysiwyg' => $wysiwyg,
		'post_content' => $post_content,
	];

	canva_get_template($template_name, $args);

	?>

<?php }
