<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

echo canva_get_img([
	'img_id'   =>  $post_id,
	'img_type' => 'img', // img, bg, url
	'thumb_size' =>  '960-free',
	'wrapper_class' => 'photoswipe-item gallery-item gallery-item-' . $post_id . ' relative ratio-16-9',
	'img_class' => 'absolute px-4 w-full h-full object-contain object-center',
	'blazy' => 'on',
]);
