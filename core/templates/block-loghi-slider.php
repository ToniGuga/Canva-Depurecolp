<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

echo canva_get_img([
	'img_id' => $post_id,
	'img_type' => 'img', // img, bg, url
	'thumb_size' => '320-11',
	'wrapper_class' => '_swiper-thumb-wrap relative ratio-1-1 group',
	'img_class' => 'absolute object-cover object-center transform-gpu transition-all duration-slow group-hover:scale-105 w-32',
	'blazy' => 'on',
	'srcset' => 'on',
]);
