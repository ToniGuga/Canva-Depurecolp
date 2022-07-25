<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

echo canva_get_img([
	'img_id' => $post_id,
	'img_type' => 'img', // img, bg, url
	'thumb_size' => '640-free',
	'wrapper_class' => 'swiper-slide photoswipe-item relative ratio-1-1 group gallery-item gallery-item-' . $item,
	'img_class' => 'absolute object-cover transform-gpu transition-all duration-slow group-hover:scale-105',
	'blazy' => 'off',
	'srcset' => 'on',
]);
