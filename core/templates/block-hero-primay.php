<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

// Lista variabili in ingresso
// $args = [
// 'id' => $id,
// 'class_name' => $className,
// 'bg_image' => $bg_image,
// 'bg_image_small' => $bg_image_small,
// 'video_bg_file_url' => $video_bg_file_url,
// 'layer_picture' => $layer_picture,
// 'layer_filter' => $layer_filter,
// 'layer_content' => $layer_content,
// 'action_link' => $action_link,
// 'action_link_2' => $action_link_2,
// 'layer_content' => $layer_content,
// 'toptitle' => $toptitle,
// 'title' => $title,
// 'toptitle' => $toptitle,
// 'toptitle' => $toptitle,
// 'content' => $content,
// 'cta' => $cta,
// 'cta_2' => $cta_2,
// 'form' => $form,
// ];


$layer_content_output = '';

if ($toptitle || $title || $subtitle || $content || $cta || $cta_2 || $form) {

	$layer_content_output .= '<div class="flex h-full flex-col justify-end p-4 sm:p-8 lg:p-12 xl:p-16 pt-32">';

	if ($toptitle) {
		$layer_content_output .= '<span class="block h3 fw-300 text-white">' . $toptitle . '</span>';
	}

	if ($title) {
		$layer_content_output .= '<h2 class="_title h1 lh-11 text-white">' . $title . '</h2>';
	}

	if ($subtitle) {
		$layer_content_output .= '<span class="block mt-2 h4 font-secondary text-primary">' . $subtitle . '</span>';
	}

	if ($content) {
		$layer_content_output .= '<div class="_hero-primary-content mt-8">' . $content . '</div>';
	}

	if ($form) {
		$layer_content_output .= '<div class="_hero-form-box pt-4">' . $form . '</div>';
	} else {
		$layer_content_output .= '<div class="_hero-button-box pt-4 isdark">' . $cta . ' ' . $cta_2 . '</div>';
	}

	$layer_content_output .= '</div>';
}


canva_the_layer([
	'layer_type' => '_hero', // _hero, _card, _photobutton
	'layer_id' => esc_attr($id),
	'layer_class' => '' . esc_attr($className),

	'img_id' => $bg_image,
	'img_small_id' => $bg_image_small,
	'thumb_size' => '1920-free',
	'thumb_small_size' => '640-free',
	'video_url' => $video_bg_file_url,

	'layer_visual_class' => 'absolute',

	'layer_bg' => 'on',
	'layer_bg_class' => '',

	'layer_picture' => $layer_picture,
	'layer_picture_class' => '',

	'layer_filter' => $layer_filter,
	'layer_filter_class' => '',

	'layer_graphics' => 'off',
	'layer_graphics_class' => '',

	'layer_date' => 'off',
	'layer_date_class' => '',

	'layer_status' => 'off',
	'layer_status_class' => '',

	'layer_info' => 'off',
	'layer_info_class' => '',

	'layer_content' => $layer_content,
	'layer_content_class' => 'relative',
	'layer_content_output' => $layer_content_output,
]);
