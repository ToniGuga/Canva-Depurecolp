<?php
defined('ABSPATH') || exit;

// $layer_content_output = '<div class="w-16 h-16 bg-black rounded-full"><img src="' . CANVA_CORE_IMG_URI . '/loaders/loading.svg"></div>';
$layer_content_output = '<div class="w-16 h-16 bg-black rounded-full"><img src="' . canva_get_theme_img_url('/loaders/loading.svg') . '"></div>';

canva_the_layer([
	'layer_type' => '_canva-loading-footer _overlay', // _hero, _card, _photobutton
	'layer_id' => 'site-loader',
	'layer_class' => 'fixed top-0 left-0 z-50 opacity-0 hidden',

	'img_id' => '',
	'img_small_id' => '',
	'thumb_size' => '960-free',
	'thumb_small_size' => '960-free',
	'img_url' => '',
	'img_small_url' => '',
	'video_url' => '',

	'layer_visual_class' => '',

	'layer_bg' => 'off',
	'layer_bg_class' => 'bg-cover bg-center',

	'layer_picture' => 'off',
	'layer_picture_class' => '',

	'layer_filter' => 'on',
	'layer_filter_class' => 'bg-white opacity-50',

	'layer_graphics' => 'off',
	'layer_graphics_class' => '',

	'layer_date' => 'off',
	'layer_date_class' => '',

	'layer_status' => 'off',
	'layer_status_class' => '',
	'layer_status_output' => '',

	'layer_info' => 'off',
	'layer_info_class' => '',

	'layer_content' => 'on',
	'layer_content_class' => 'flex justify-center items-center h-screen',
	'layer_content_output' => $layer_content_output,
]);
