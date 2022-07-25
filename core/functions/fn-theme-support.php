<?php
defined('ABSPATH') || exit;

/**
 * Undocumented function
 *
 * @return void
 */

function canva_theme_support()
{

	// Add language support
	load_theme_textdomain('canva', get_template_directory() . '/languages');

	// Switch default core markup for search form, comment form, and comments to output valid HTML5
	add_theme_support('html5', [
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
		'navigation-widgets',
	]);

	// Add menu support
	add_theme_support('menus');

	// Let WordPress manage the document title
	add_theme_support('title-tag');

	// Add post thumbnail support: http://codex.wordpress.org/Post_Thumbnails
	add_theme_support('post-thumbnails');

	// RSS thingy
	add_theme_support('automatic-feed-links');

	// Add post formats support: http://codex.wordpress.org/Post_Formats
	// add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat']);

	// Add support for Block Styles
	add_theme_support('wp-block-styles');

	// Add support for Woocommerce
	if (is_woocommerce_activated()) {
		add_theme_support('woocommerce');
	}

	// Add support for full and wide align images.
	add_theme_support('align-wide');

	// Add support for responsive embeds.
	add_theme_support('responsive-embeds');

	// Add support for custom units.
	// This was removed in WordPress 5.6 but is still required to properly support WP 5.5.
	add_theme_support('custom-units');

	// Remove feed icon link from legacy RSS widget.
	add_filter('rss_widget_feed_link', '__return_false');


	// add_theme_support('disable-custom-font-sizes');
	// add_theme_support('editor-font-sizes', array());
	// add_theme_support('disable-custom-colors');
	// add_theme_support('editor-color-palette', array());
	// add_theme_support('disable-custom-gradients');
	// add_theme_support('editor-gradient-presets', array());
	// add_theme_support('custom-units', array());


	remove_theme_support('core-block-patterns');

}
add_action('after_setup_theme', 'canva_theme_support');
