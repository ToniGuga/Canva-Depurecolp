<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

function canva_start_cleanup()
{
	// Launching operation cleanup.
	add_action('init', 'canva_cleanup_head');

	// Remove WP version from RSS.
	add_filter('the_generator', 'canva_remove_rss_version');

	// Remove pesky injected css for recent comments widget.
	add_filter('wp_head', 'canva_remove_wp_widget_recent_comments_style', 1);

	// Clean up comment styles in the head.
	add_action('wp_head', 'canva_remove_recent_comments_style', 1);

	// Remove inline width attribute from figure tag
	add_filter('img_caption_shortcode', 'canva_remove_figure_inline_style', 10, 3);

	// Remove post-formats theme support
	remove_theme_support('post-formats');
}
add_action('after_setup_theme', 'canva_start_cleanup');


/*
 * Clean up head.+
 * ----------------------------------------------------------------------------
 */

function canva_cleanup_head()
{
	// EditURI link.
	remove_action('wp_head', 'rsd_link');

	// Category feed links.
	remove_action('wp_head', 'feed_links_extra', 3);

	// Post and comment feed links.
	remove_action('wp_head', 'feed_links', 2);

	// Windows Live Writer.
	remove_action('wp_head', 'wlwmanifest_link');

	// Index link.
	remove_action('wp_head', 'index_rel_link');

	// Previous link.
	remove_action('wp_head', 'parent_post_rel_link', 10);

	// Start link.
	remove_action('wp_head', 'start_post_rel_link', 10);

	// Canonical.
	remove_action('wp_head', 'rel_canonical', 10);

	// Shortlink.
	remove_action('wp_head', 'wp_shortlink_wp_head', 10);

	// Links for adjacent posts.
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

	// WP version.
	remove_action('wp_head', 'wp_generator');

	// Emoji detection script.
	remove_action('wp_head', 'print_emoji_detection_script', 7);

	// Emoji styles.
	remove_action('wp_print_styles', 'print_emoji_styles');
}


// Remove WP version from RSS.
function canva_remove_rss_version()
{
	return '';
}


// Remove injected CSS for recent comments widget.
function canva_remove_wp_widget_recent_comments_style()
{
	if (has_filter('wp_head', 'wp_widget_recent_comments_style')) {
		remove_filter('wp_head', 'wp_widget_recent_comments_style');
	}
}


// Remove injected CSS from recent comments widget.
function canva_remove_recent_comments_style()
{
	global $wp_widget_factory;
	if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
		remove_action('wp_head', [$wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style']);
	}
}

// Remove inline width attribute from figure tag causing images wider than 100% of its container
function canva_remove_figure_inline_style($output, $attr, $content)
{
	$atts = shortcode_atts(
		[
			'id' => '',
			'align' => 'alignnone',
			'width' => '',
			'caption' => '',
			'class' => '',
		],
		$attr,
		'caption'
	);

	$atts['width'] = (int) $atts['width'];
	if ($atts['width'] < 1 || empty($atts['caption'])) {
		return $content;
	}

	if (!empty($atts['id'])) {
		$atts['id'] = 'id="' . esc_attr($atts['id']) . '" ';
	}

	$class = trim('wp-caption ' . $atts['align'] . ' ' . $atts['class']);

	if (current_theme_supports('html5', 'caption')) {
		return '<figure ' . $atts['id'] . ' class="' . esc_attr($class) . '">'
			. do_shortcode($content) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
	}
}

