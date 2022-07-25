<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if(wp_doing_ajax()){
	require '../wp-load.php';
}

if (!$post_id) {
	$post_id = get_the_ID();
}
// echo $post_id;
$post = get_post($post_id);
echo do_shortcode($post->post_content);
