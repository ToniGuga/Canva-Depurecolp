<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

$post = get_post($post_id);
// echo do_shortcode($post->post_content);
echo get_the_content(null, false, $post);

// $blocks = parse_blocks($post->post_content);

// $blocks = parse_blocks(get_the_content(null, false, $post));
// // var_dump($blocks);

// $content_markup = '';
// foreach ($blocks as $block) {
// 	// $content_markup .= render_block($block);
// 	// var_dump($block);

// 	$context = array();

// 	if ($post instanceof WP_Post) {
// 		$context['postId'] = $post->ID;

// 		/*
//          * The `postType` context is largely unnecessary server-side, since the ID
//          * is usually sufficient on its own. That being said, since a block's
//          * manifest is expected to be shared between the server and the client,
//          * it should be included to consistently fulfill the expectation.
//          */
// 		$context['postType'] = $post->post_type;
// 	}

// 	var_dump($context);

// 	$blocco = new WP_Block($block, $context);

// 	// var_dump($blocco);

// 	echo $blocco->render();
// }


// $priority = has_filter('the_content', 'wpautop');
// if (false !== $priority) {
// 	remove_filter('the_content', 'wpautop', $priority);
// }

// echo apply_filters('the_content', $content_markup);

// if (false !== $priority) {
// 	add_filter('the_content', 'wpautop', $priority);
// }
