<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Change navigation position class
 *
 * @param [type] $classes
 * @return void
 */
function canva_desktop_nav_body_class($classes)
{
	global $post;

	if (get_post_type($post) == 'page') {

		$classes[] = get_field('desktop_navigation', $post->ID);
	}

	return $classes;
}
add_filter('body_class', 'canva_desktop_nav_body_class');

/**
 * Get post by slug
 *
 * @param [type] $page_slug
 * @param [type] $output
 * @param string $post_type
 * @return void
 */
function get_post_by_slug($page_slug, $output = OBJECT, $post_type = 'page')
{

	global $wpdb;

	$post = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s AND post_status = 'publish'", $page_slug, $post_type));

	if ($post)

		return get_post($post, $output);

	return null;
}

/**
 * Get page by slug
 *
 * @param [type] $page_slug
 * @param [type] $output
 * @param string $post_type
 * @return void
 */
function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page')
{
	return get_post_by_slug($page_slug, $output, $post_type);
}

/**
 * Get percentage
 *
 * @param [type] $total
 * @param [type] $part
 * @return void
 */
function get_percent($total, $part)
{

	$percent = ($part * 100) / $total;

	$percent = number_format((float)$percent, 2, '.', '');

	return $percent;
}

/**
 * Echo number in € format
 *
 * @param [type] $euro
 * @return void
 */
function canva_euro_format($euro)
{

	// $lang = get_bloginfo('language');

	// $fmt = new NumberFormatter($lang, NumberFormatter::CURRENCY);

	// echo $fmt->formatCurrency($euro, 'EUR');
	if ($euro != 0) {

		echo number_format(floatval($euro), 2, ',', '.') . '€';
	} else {

		echo '0€';
	}
}

/**
 * Array key replace
 *
 * @param [type] $item
 * @param [type] $replace_with
 * @param array $array
 * @return void
 */
function array_key_replace($item, $replace_with, array $array)
{
	$updated_array = [];

	foreach ($array as $key => $value) {

		if (!is_array($value) && $key == $item) {

			$updated_array = array_merge($updated_array, [$replace_with => $value]);

			continue;
		}

		$updated_array = array_merge($updated_array, [$key => $value]);
	}

	return $updated_array;
}

/**
 * return author id from display_name field
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $display_name
 * @return void
 */
function get_user_id_by_display_name($display_name)
{
	global $wpdb;

	$query = "SELECT ID FROM {$wpdb->prefix}users WHERE `display_name` = '{$display_name}'";
	return (int) $wpdb->get_var($wpdb->prepare($query));
}

/**
 * useful to minify html output code
 *
 * @param [type] $buffer
 * @return void
 */
function canva_minifier($buffer) {

	// ob_start("canva_minifier"); //use this outside to minify all the html output

    $search = array(
        '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
        '/[^\S ]+\</s',     // strip whitespaces before tags, except space
        '/(\s)+/s',         // shorten multiple whitespace sequences
        // '/<!--(.|\s)*?-->/' // Remove HTML comments
    );

    $replace = array(
        '>',
        '<',
        '\\1',
        ''
    );

    $buffer = preg_replace($search, $replace, $buffer);

    return $buffer;
}
