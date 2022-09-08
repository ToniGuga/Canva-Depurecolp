<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Use this to get the file extention
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $file
 * @return void
 */
function get_file_extension($file = '')
{
	$tmp = explode('.', $file);
	$extension = end($tmp);
	return $extension ? $extension : false;
}

/**
 * Returns only the file extension (without the period).
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $filename
 * @return void
 */
function get_file_ext($filename)
{
	return preg_match('/\./', $filename) ? preg_replace('/^.*\./', '', $filename) : '';
}

/**
 * Returns the file name, less the extension.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $filename
 * @return void
 */
function get_file_name($filename)
{
	return preg_replace('/.[^.]*$/', '', $filename);
}


/**
 * Return current url.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $input
 * @return string
 */
function get_current_url()
{
	global $wp;
	$current_url = home_url(add_query_arg([], $wp->request));

	return esc_url($current_url);
}

/**
 * Return url of an img src tag.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $input
 * @return string
 */
function get_img_src($input)
{
	preg_match_all("/<img[^>]*src=[\"|']([^'\"]+)[\"|'][^>]*>/i", $input, $output);
	$return = [];
	if (isset($output[1][0])) {
		$return = $output[1];
	}

	foreach ((array) $return as $source) {
		return $source . PHP_EOL;
	}
}

/**
 * Return url of an iframe src tag.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $input
 * @return string
 */
function get_iframe_src($input)
{
	preg_match_all('/<iframe[^>]+src="([^"]+)"/', $input, $output);
	$return = [];
	if (isset($output[1][0])) {
		$return = $output[1];
	}

	foreach ((array) $return as $source) {
		return $source . PHP_EOL;
	}
}


/**
 * Checks if a url is from youtube, vimeo or facebook.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $url
 * @return string
 */
function is_url_from($url, $provider = 'youtube')
{
	if (strpos($url, $provider) > 0) {
		return true;
	}
}

/**
 * Checks if a value of a key is in an array.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $value
 * @param [type] $key
 * @param [type] $array
 * @return boolean
 */

// function is_in_array($value, $key, $array)
// {
// 	$search = array_search($value, array_column($array, $key));
// 	return $search ? true : false;
// }

function is_in_array($array_key = 'product_id', $value, $array)
{
	foreach ($array as $key => $val) {
		if ($val[$array_key] === $value) {
			return true;
		}
	}
	return null;
}


/**
 * Removes http:// or https:// from an url
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $url
 * @return string
 */
function remove_http_or_https($url)
{
	$disallowed = ['http://', 'https://', '/'];
	foreach ($disallowed as $d) {
		if (0 === strpos($url, $d)) {
			return str_replace($d, '', $url);
		}
	}

	return $url;
}


/**
 *
 * Extract url and anchor text in array of a html code.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [array] $html
 * @return array
 */
function extract_links_from_html($html)
{
	$DOM = new DOMDocument();
	$DOM->loadHTML($html);

	//Extract the links from the HTML.
	$links = $DOM->getElementsByTagName('a');

	$extract_links = [];

	foreach ($links as $link) {
		//Get the link text.
		$link_text = $link->nodeValue;
		//Get the link in the href attribute.
		$link_href = $link->getAttribute('href');

		//If the link is empty, skip it and don't
		//add it to our $extract_links array
		if (0 == strlen(trim($link_href))) {
			continue;
		}

		//Skip if it is a hashtag / anchor link.
		if ('#' == $link_href[0]) {
			continue;
		}

		//Add the link to our $extract_links array.
		$extract_links[] = [
			'text' => $link_text,
			'href' => $link_href,
		];
	}

	return $extract_links;
}


/**
 * Prints wp post assigned categories in body class
 *
 * @param [type] $classes
 * @return void
 */
function canva_add_post_category_names_to_body_class($classes)
{
	if (is_singular('post')) {
		global $post;
		$categories = get_the_category($post->ID);
		foreach ($categories as $category) {
			$classes[] = 'cat-' . $category->category_nicename;
		}
	}

	return $classes;
}
add_filter('body_class', 'canva_add_post_category_names_to_body_class');


/**
 * Utility function to print terms of a taxonomy
 *
 * @param string $post_id
 * @param string $taxonomy
 * @param string $term_link
 * @param string $class
 * @param string $parent
 * @param string $facet_url
 * @return void
 */
function canva_get_category($post_id = '', $taxonomy = '', $class = 'inline-block mr-2', $parent = 'no', $term_link = 'yes',  $facet_url = '')
{
	$terms = get_the_terms($post_id, $taxonomy);

	$html = '';

	if ($terms) {
		foreach ($terms as $term) {
			if ('yes' == $term_link && !$facet_url) {
				$html .= '<a href="' . esc_url(get_term_link($term->term_id)) . '" class="' . $class . ' ' . $term->slug . '">' . $term->name . '</a>';
			} elseif ('yes' == $term_link && $facet_url) {
				$html .= '<a href="' . esc_url($facet_url . $term->slug) . '" class="' . $class . ' ' . $term->slug . '">' . $term->name . '</a>';
			} else {
				$html .= '<span class="' . $class . ' ' . $term->slug . '">' . $term->name . '</span>';
			}
		}
		if ($parent === 'yes') {
			if ('yes' == $term_link && !$facet_url) {
				$html .= '<a href="' . esc_url(get_term_link($parent)) . '" class="' . $class . ' tutti">' . __('All', 'canva-frontend') . '</a>';
			} elseif ('yes' == $term_link && $facet_url) {
				$html .= '<a href="' . esc_url($facet_url . $parent) . '" class="' . $class . ' tutti">' . __('All', 'canva-frontend') . '</a>';
			} else {
				$html .= '<span class="' . $class . ' all-terms">' . __('All', 'canva-frontend') . '</span>';
			}
		}
	}

	return $html;
}


/**
 * Stampa i termini di una determinata tassonomia con link alla pagina archivio.
 *
 * @param $post_id int
 * @param $taxonomy string
 * @param $term_data string
 *
 * @return array
 */
function canva_get_post_terms($post_id = '', $taxonomy = '', $term_data = 'slug')
{
	if ('' == $post_id) {
		$post_id = get_the_ID();
	}

	$current_terms = get_the_terms($post_id, $taxonomy);

	$terms = [];
	foreach ($current_terms as $term) {
		$terms[] = $term->{$term_data};
	}

	return $terms;
}
/**
 * Check if a date is a weekend day or not
 *
 * @author toni@schiavoneguga.com
 * @param mixed $date
 * @return bolean
 */
function is_weekend($date)
{
	return (date('N', strtotime($date)) >= 6) ? true : false;
}


/**
 * Check if a date is saturday or not
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param mixed $date
 * @return bolean
 */
function is_saturday($date)
{
	$weekday = date('l', strtotime($date));

	return ('Saturday' == $weekday) ? true : false;
}


/**
 * Check if a date is sunday or not
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param mixed $date
 * @return bolean
 */
function is_sunday($date)
{
	$weekday = date('l', strtotime($date));

	return ('Sunday' == $weekday) ? true : false;
}

/**
 * Returns number of months between two dates
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $date1
 * @param [type] $date2
 *
 * @return int
 */
function canva_months_counter($date1, $date2)
{
	$begin = new DateTime($date1);
	$end = new DateTime($date2);
	$end = $end->modify('+1 month');

	$interval = DateInterval::createFromDateString('1 month');

	$period = new DatePeriod($begin, $interval, $end);
	$counter = 0;
	foreach ($period as $dt) {
		++$counter;
	}

	return $counter;
}

/**
 * Function to get the current time in unix mformat
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return bolean
 */
function canva_get_current_time($format = 'Y-m-d H:i:s')
{

	$now = strtotime(current_time($format));

	return $now;
}

/**
 * Function to get start date time acf field in unix format from post_id
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return int
 */
function canva_get_start_date_time($post_id = '', $field = 'start_date_time')
{

	$start = strtotime(get_field($field, $post_id));

	return $start;
}

/**
 * Function to get end date time acf field in unix format from post_id
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return int
 */
function canva_get_end_date_time($post_id = '', $field = 'end_date_time')
{

	$end = strtotime(get_field($field, $post_id));

	return $end;
}

/**
 * Return days left of a post rounding up.
 *
 * @date 24/07/2019
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 *
 * @param [type] $product
 * @param string $due_field
 * @param mixed  $product_id
 * @return int
 */
function canva_get_days_left($post_id = '', $due_field = '', $date_time_format = 'Y-m-d H:i:s')
{
	return $diff->format("%a");

	if (!$post_id || '' == $post_id) {
		$post_id = get_the_ID();
	}

	if (!$due_field || '' == $due_field) {
		$due_field = 'end_date_time';
	}

	$today = strtotime(date($date_time_format));
	$due_date_time = strtotime(get_field($due_field, $post_id));

	$time_diff = $due_date_time - $today;
	//arrotonda per eccesso
	return ceil($time_diff / 86400);
}

/**
 * Return author full name inside the loop
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return string
 */
function canva_get_author_full_name()
{
	$author_id = get_the_author_meta('ID');

	$full_name = get_the_author_meta('first_name', $author_id) . ' ' . get_the_author_meta('last_name', $author_id);

	return $full_name;
}


/**
 * Adds css class to paragraphs
 *
 * @param string $content
 * @param string $p_class
 * @return void
 */
function canva_add_class_to_paragraph($content = '', $p_class = '')
{
	$new_p = '<p class="' . $p_class . '">';
	echo str_replace('<p>', $new_p, $content);
}


/**
 * Useful to trim a post content by word counts
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $post_id
 * @param integer $trim_words
 * @return void
 */
function canva_get_trimmed_post_content($post_id = '', $trim_words = 120)
{
	$post = get_post($post_id);
	return wp_trim_words(wp_strip_all_tags(strip_shortcodes(excerpt_remove_blocks($post->post_content))), $trim_words);
}


/**
 * Useful to trim a content by word counts
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $content
 * @param integer $trim
 * @return string
 */
function canva_get_trimmed_content($content = '', $trim_words = 120, $strip_blocks = true, $strip_shortcode = true)
{
	if ($strip_blocks && $strip_shortcode) {
		return wp_trim_words(wp_strip_all_tags(strip_shortcodes(excerpt_remove_blocks($content))), $trim_words);
	} elseif ($strip_blocks && !$strip_shortcode) {
		return wp_trim_words(wp_strip_all_tags(excerpt_remove_blocks($content)), $trim_words);
	} elseif (!$strip_blocks && $strip_shortcode) {
		return wp_trim_words(wp_strip_all_tags(strip_shortcodes($content)), $trim_words);
	} else {
		return wp_trim_words(wp_strip_all_tags($content), $trim_words);
	}
}

/**
 * renderizza tutti i blocchi di un post
 * utile da richiamare nei micro template.
 *
 * @param mixed $post_id
 *
 * @return html
 */
function canva_render_blocks($post_id)
{
	$post = get_post($post_id);

	$post_content = apply_filters('the_content', $post->post_content);
	echo do_blocks($post_content);
}


/**
 * renderizza tutti i blocchi di un post, utile da richiamare nei micro template o in funzioni vedi esempio
 * echo canva_get_trimmed_content($trim = 20, $read_more = '', $content = canva_get_render_blocks($post_id), $class = '');
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $post_id
 * @return void
 */
function canva_get_render_blocks($post_id)
{
	ob_start();
	$post = get_post($post_id);
	$post_content = apply_filters('the_content', $post->post_content);
	echo do_blocks($post_content);
	$output = ob_get_contents();
	return $output;
}


/**
 * renderizza tutti i blocchi di un post, utile da richiamare nei micro template o in funzioni vedi esempio
 * echo canva_get_trimmed_content($trim = 20, $read_more = '', $content = canva_get_render_blocks($post_id), $class = '');
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $post_id
 * @return void
 */
function canva_render_post_blocks($post_id = '')
{

	if (isset($_GET['post_id']) && '' != trim($_GET['post_id'])) {
		$post_id = esc_attr($_GET['post_id']);
	} elseif (isset($_POST['post_id']) && '' != trim($_POST['post_id'])) {
		$post_id = esc_attr($_POST['post_id']);
	} else {
		$post_id = $post_id;
	}

	if (isset($_GET['dump_blocks']) && '' != trim($_GET['dump_blocks'])) {
		$dump_blocks = true;
	}

	$post = get_post($post_id);

	if (has_blocks($post->post_content)) {
		$blocks = parse_blocks($post->post_content);

		if ($dump_blocks) {
			var_dump($blocks);
		}

		foreach ($blocks as $block) {
			echo render_block($block);
			// var_dump($block);
		}
	}
	// wp_die();
}
add_action('wp_ajax_canva_render_post_blocks', 'canva_render_post_blocks', 10, 2);
add_action('wp_ajax_nopriv_canva_render_post_blocks', 'canva_render_post_blocks', 10, 2);


/**
 * ancora in sviluppo - per ora non funziona
 *
 * renderizza tutti i blocchi di un post, utile da richiamare nei micro template o in funzioni vedi esempio
 * echo canva_get_trimmed_content($trim = 20, $read_more = '', $content = canva_get_render_blocks($post_id), $class = '');
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $post_id
 * @return void
 */
function canva_render_block_by_id($post_id = '', $block_id = '')
{

	if (isset($_GET['post_id']) && '' != trim($_GET['post_id'])) {
		$post_id = esc_attr($_GET['post_id']);
	} elseif (isset($_POST['post_id']) && '' != trim($_POST['post_id'])) {
		$post_id = esc_attr($_POST['post_id']);
	} else {
		$post_id = $post_id;
	}

	if (isset($_GET['block_id']) && '' != trim($_GET['block_id'])) {
		$block_id = esc_attr($_GET['block_id']);
	} elseif (isset($_POST['block_id']) && '' != trim($_POST['block_id'])) {
		$block_id = esc_attr($_POST['block_id']);
	} else {
		$block_id = $block_id;
	}

	$post = get_post($post_id);

	if (has_blocks($post->post_content)) {
		$blocks = parse_blocks($post->post_content);

		$output = '';
		foreach ($blocks as $block) {

			if ('acf/row-w-100-inner-blocks' == $block['blockName']) {
				$output .= render_block($block);
				// var_dump($block);
			}
		}
		echo apply_filters('the_content', $output);
	}
	wp_die();
}
add_action('wp_ajax_canva_render_block_by_id', 'canva_render_block_by_id', 10, 2);
add_action('wp_ajax_nopriv_canva_render_block_by_id', 'canva_render_block_by_id', 10, 2);


/**
 * Returns true if handle name was found first
 *
 * @param [type] $post_id
 * @param [type] $block_handle
 * @return void
 */
function canva_first_block_is($post_id = '', $block_handle = '')
{
	$post = get_post($post_id);

	if (has_blocks($post->post_content)) {
		$blocks = parse_blocks($post->post_content);

		if ($blocks[0]['blockName'] === $block_handle) {
			return true;
		} else {
			return false;
		}
	}
}


/**
 * get other posts in the same post type
 *
 * @author Toni Guga <toni@schiavoneguga.com>  *
 * @param string $post_type
 * @param array $ids
 * @param integer $posts_per_page
 * @param boolean $random
 * @param string $template_name
 * @return void
 */
function canva_show_posts($post_type = '', $ids = [], $posts_per_page = 3, $random = false, $template_name = '')
{
	if ($random) {
		$args = [
			'post_type' => sanitize_text_field($post_type),
			'posts_per_page' => $posts_per_page,
			'post__not_in' => [get_the_ID()],
		];
	} else {
		$args = [
			'post_type' => sanitize_text_field($post_type),
			'posts_per_page' => $posts_per_page,
			'post__not_in' => [get_the_ID()],
			'orderby' => 'rand',
		];
	}

	if ($ids && !empty($ids)) {
		$post__in = ['post__in' => $ids];

		$args = array_merge($args, $post__in);
	}

	$q = new WP_Query($args);

	// var_dump($q);

	if ($q->have_posts()) {

		while ($q->have_posts()) {
			$q->the_post();
			if ($template_name && !is_admin()) {
				echo canva_get_template($template_name, ['post_id' => get_the_ID()]);
			} else {
				echo '<h3 class="canva-flex canva-align-middle canva-mt-0 canva-mb-2 canva-p-2 canva-font-theme canva-fs-h5 canva-fw-700 canva-lh-10 canva-bg-grey-lighter">';
				echo get_the_title();
				echo '</h3>';
			}
		}

		wp_reset_postdata($q);
	}
}


/**
 * Return posts of a post type filterend by taxonomy and terms using canva micro template system. Works with FacetWP plugin.
 *
 * https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $post_type
 * @param string $taxonomy
 * @param string $field
 * @param array $terms
 * @param string $template_name
 * @param integer $posts_per_page
 * @param string $order
 * @param string $orderby
 * @param boolean $facetwp
 * @return html
 */
function canva_get_posts_per_term($post_type = '', $taxonomy = 'category', $field_type = 'slug', $terms = '', $template_name = '', $posts_per_page = 6, $order = 'DESC', $orderby = 'date', $facetwp = false)
{
	$args = [
		'facetwp' 			=> $facetwp,
		'posts_per_page' 	=> $posts_per_page,
		'order' 			=> sanitize_text_field($order),
		'orderby' 			=> sanitize_text_field($orderby),
		'post_type' 		=> sanitize_text_field($post_type),
		'post__not_in' 		=> [get_the_ID()],
	];

	if ($taxonomy) {
		$args_2 = [
			'tax_query' => [
				[
					'taxonomy' 	=> sanitize_text_field($taxonomy),
					'field' 	=> sanitize_text_field($field_type),
					'terms' 	=> array_values($terms)
					// 'terms' 	=> $terms
				]
			],
		];

		$args = array_merge($args, $args_2);
	}

	// dump_to_error_log($args);
	// var_export($args);

	$posts = get_posts($args);

	// dump_to_error_log($post);
	// var_dump($post);

	if ($posts) {

		$html = '';
		if ($facetwp && is_facetwp_activated()) {
			$html .= '<div class="facetwp-template">';
		}

		foreach ($posts as $post) {
			$html .= canva_get_template(sanitize_text_field($template_name), ['post_id' => $post]);
		}

		if ($facetwp && is_facetwp_activated()) {
			$html .= '</div>
			<div class=" facetwp-load-more container">
				' . facetwp_display('facet', 'load_more') . '
			</div>
		';
		}
	} else {
		$html .= apply_filters('canva_no_results', '<h5 class="uppercase">' . __('No results here...', 'canva-frontend') . '</h5>');
	} //endif

	return $html;
}

function canva_posts_per_term($post_type = '', $taxonomy = 'category', $field_type = 'slug', $terms = [], $template_name = '', $posts_per_page = 6, $order = 'DESC', $orderby = 'date', $facetwp = false)
{
	echo canva_get_posts_per_term($post_type, $taxonomy, $field_type, $terms, $template_name, $posts_per_page, $order, $orderby, $facetwp);
}

/**
 * Return posts of a post type filterend by acf or custom filed using canva micro template system. Works with FacetWP plugin.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $post_type
 * @param string $field_name
 * @param string $field_value
 * @param string $template_name
 * @param integer $posts_per_page
 * @param string $order
 * @param string $orderby
 * @param boolean $facetwp
 * @return html
 */
function canva_posts_per_acf_field($post_type = '', $field_name = '', $field_value = '', $template_name = '', $posts_per_page = 6, $order = 'DESC', $orderby = 'date', $facetwp = false)
{
	$args = [
		'facetwp' 			=> $facetwp,
		'posts_per_page'	=> $posts_per_page,
		'post_type' 		=> sanitize_text_field($post_type),
		'order' 			=> sanitize_text_field($order),
		'orderby' 			=> sanitize_text_field($orderby),
		'post__not_in' 		=> [get_the_ID()],
		'meta_query' 		=> [
			[
				'key' 		=> sanitize_text_field($field_name),
				// 'value' 	=> '"' . sanitize_text_field($field_name) . '"',
				'value' 	=> sanitize_text_field($field_value),
				'compare' 	=> 'LIKE',
			],
		],
	];

	$q = new WP_Query();

	$q->query($args);

	if ($q->have_posts()) {

		if ($facetwp && is_facetwp_activated()) {
			echo '<div class="facetwp-template">';
		}

		while ($q->have_posts()) {
			$q->the_post();
			$do_not_duplicate = $post->ID;

			canva_get_template($template_name, ['post_id' => $do_not_duplicate]);
		}
		wp_reset_postdata($q);

		if ($facetwp && is_facetwp_activated()) {
			echo '</div>
			<div class=" facetwp-load-more container">
				' . facetwp_display('facet', 'load_more') . '
			</div>
		';
		}
	} else {
		echo apply_filters('canva_no_results', '<h5 class="uppercase">' . __('No results here...', 'canva-frontend') . '</h5>');
	}
}


/**
 * Return posts selected using acf post object or relationship field using canva micro template system. Works with FacetWP plugin.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $post_id
 * @param string $acf_field_name
 * @param string $template_name
 * @param boolean $facetwp
 * @return html
 */
function canva_posts_per_acf_post_object($post_id = '', $acf_field_name = '', $template_name = '', $facetwp = false)
{
	if (!$post_id) {
		$post_id = get_the_ID();
	}

	if (get_field($acf_field_name, $post_id)) {
		$posts = get_field($acf_field_name, $post_id);

		if ($facetwp && is_facetwp_activated()) {
			echo '<div class="facetwp-template">';
		}

		foreach ($posts as $post) {
			setup_postdata($post);
			canva_get_template($template_name, ['post_id' => $post->ID]);
		} //endforeach

		wp_reset_postdata();

		if ($facetwp && is_facetwp_activated()) {
			echo '</div>
			<div class=" facetwp-load-more container">
				' . facetwp_display('facet', 'load_more') . '
			</div>
		';
		}
	} else {
		echo apply_filters('canva_no_results', '<h5 class="uppercase">' . __('No results here...', 'canva-frontend') . '</h5>');
	} //endif
}


/**
 * stampa i post scelti con il post object di ACF con impostazione formato di ritorno ID e genera uno slider con swiper.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param $attributes array
 */
function canva_slider_post_ids($attributes = [])
{
	extract(shortcode_atts([
		'post_ids' => array(),
		'template_name' => 'render-blocks',
		'swiper_hero_class' => '',
		'swiper_container_class' => '',
		'slides_per_view_xsmall' => 1,
		'slides_per_view_small' => 2,
		'slides_per_view_medium' => 3,
		'slides_per_view_large' => 4,
		'slides_per_view_xlarge' => 4,
		'prev_next' => 'true',
		'pagination' => 'true',
		'autoplay' => 'false',
		'loop' => 'true',
		'centered_slides_bounds' => 'false',
		'centered_slides' => 'false',
		'center_insufficient_slides' => 'false',
		'slides_offset_before' => 0,
		'slides_offset_after' => 0,
		'free_mode' => 'false',
	], $attributes));


	if ($post_ids) {

		$element_id = esc_attr(wp_generate_password(16, false, false));

?>
		<!-- ///////// Slider Posts ///////// -->
		<div id="<?php echo $element_id; ?>" class="_swp-hero <?php echo esc_attr($swiper_hero_class); ?>">

			<div class="swiper-container <?php echo $element_id; ?> <?php echo esc_attr($swiper_container_class); ?>">

				<div class="swiper-wrapper">

					<?php
					foreach ($post_ids as $post_id) {
						echo '<div class="swiper-slide">';
						canva_get_template(sanitize_text_field($template_name), ['post_id' => $post_id]);
						echo '</div>';
					} ?>
				</div>

				<?php if ('true' === $pagination) { ?>
					<div class="swiper-pagination"></div>
				<?php } ?>



			</div>
			<?php if ('true' === $prev_next) { ?>
				<div class="swiper-button-next"></div>
				<div class="swiper-button-prev"></div>
			<?php } ?>
		</div>

		<script>
			/* swiper slider post */
			const <?php echo $element_id; ?> = new Swiper('.<?php echo esc_js($element_id); ?>', {
				preloadImages: false,
				lazy: false,
				grabCursor: true,
				<?php if ($autoplay == 'true') { ?>
					autoplay: {
						delay: 8000,
					},
				<?php } else { ?>
					autoplay: <?php echo $autoplay; ?>,
				<?php } ?>
				loop: <?php echo $loop; ?>,
				centeredSlidesBounds: <?php echo $centered_slides_bounds; ?>,
				centeredSlides: <?php echo $centered_slides; ?>,
				centerInsufficientSlides: <?php echo $center_insufficient_slides; ?>,
				slidesOffsetBefore: <?php echo $slides_offset_before; ?>,
				slidesOffsetAfter: <?php echo $slides_offset_after; ?>,
				freeMode: <?php echo $free_mode; ?>,
				speed: 300,
				/* watchOverflow: true, */
				/* freeMode: true, */
				slidesPerView: 1,
				spaceBetween: 0,
				pagination: {
					el: '.swiper-pagination',
					clickable: 'true',
					dynamicBullets: false,
					dynamicMainBullets: 5,
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				breakpoints: {
					<?php if ($slides_per_view_xsmall) { ?>
						300: {
							slidesPerView: <?php echo $slides_per_view_xsmall; ?>,
						},
					<?php }
					if ($slides_per_view_small) { ?>
						320: {
							slidesPerView: <?php echo $slides_per_view_small; ?>,
						},
					<?php }
					if ($slides_per_view_medium) { ?>
						640: {
							slidesPerView: <?php echo $slides_per_view_medium; ?>,
						},
					<?php }
					if ($slides_per_view_large) { ?>
						960: {
							slidesPerView: <?php echo $slides_per_view_large; ?>,
						},
					<?php }
					if ($slides_per_view_xlarge) { ?>
						1200: {
							slidesPerView: <?php echo $slides_per_view_xlarge; ?>,
						},
					<?php } ?>
				}

			});

			<?php echo $element_id; ?>.on('slideChange', function() {
				// console.log('slide changed');
				var bLazy = new Blazy();
				bLazy.revalidate(); // eg bLazy.revalidate()
			});
		</script>
	<?php
	}
}



/**
 * Print a slider of posts filtered by taxonomy and terms
 *
 * https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param $attributes array
 */
function canva_get_slider_posts_per_term($attributes = [])
{
	extract(shortcode_atts([
		'post_type' => 'post',
		'taxonomy' => 'category',
		'field' => 'term_id',
		'terms' => str_split($term_id),
		'posts_per_page' => 6,
		'order' => 'DESC',
		'orderby' => 'date',
		'template_name' => 'card-news',
		'swiper_hero_class' => '',
		'swiper_container_class' => 'container',
		'slides_per_view_xsmall' => 1,
		'slides_per_view_small' => 1,
		'slides_per_view_medium' => 2,
		'slides_per_view_large' => 3,
		'slides_per_view_xlarge' => 3,
		'prev_next' => 'true',
		'pagination' => 'true',
		'autoplay' => 'false',
		'loop' => 'true',
		'centered_slides_bounds' => 'false',
		'centered_slides' => 'false',
		'center_insufficient_slides' => 'false',
		'slides_offset_before' => 0,
		'slides_offset_after' => 0,
		'free_mode' => 'false',
	], $attributes));

	if ($taxonomy) {
		$args = [
			'posts_per_page' 	=> $posts_per_page,
			'order' 			=> sanitize_text_field($order),
			'orderby' 			=> sanitize_text_field($orderby),
			'post_type' 		=> sanitize_text_field($post_type),
			'post__not_in' 		=> [get_the_ID()],
			'tax_query' 		=> [
				[
					'taxonomy' => sanitize_text_field($taxonomy),
					'field' => sanitize_text_field($field),
					'terms' => array_values($terms)
				]
			],
		];
	} else {
		$args = [
			'posts_per_page' 	=> $posts_per_page,
			'order' 			=> sanitize_text_field($order),
			'orderby'			=> sanitize_text_field($orderby),
			'post_type' 		=> sanitize_text_field($post_type),
			'post__not_in' 		=> [get_the_ID()],
		];
	}
	// var_dump($args);

	$query = new WP_Query($args);
	// var_dump($query);

	if ($query->have_posts()) {

		$element_id = esc_attr(wp_generate_password(16, false, false));
	?>

		<!-- ///////// Slider Posts ///////// -->
		<div id="<?php echo $element_id; ?>" class="hero-slider <?php echo esc_attr($swiper_hero_class); ?>">

			<div class="swiper-container <?php echo $element_id; ?> <?php echo esc_attr($swiper_container_class); ?>">

				<div class="swiper-wrapper">

					<?php
					while ($query->have_posts()) {
						$query->the_post();
						$do_not_duplicate = $post->ID;
						echo '<div class="swiper-slide">';
						canva_get_template(sanitize_text_field($template_name), ['post_id' => $do_not_duplicate]);
						echo '</div>';
					} ?>
				</div>

				<?php if ('true' === $pagination) { ?>
					<div class="swiper-pagination"></div>
				<?php } ?>

				<?php if ('true' === $prev_next) { ?>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				<?php } ?>

			</div>

		</div>

		<script>
			/* swiper slider post */
			var <?php echo $element_id; ?> = new Swiper('.<?php echo esc_js($element_id); ?>', {
				preloadImages: false,
				lazy: false,
				grabCursor: true,
				autoplay: <?php echo $autoplay; ?>,
				loop: <?php echo $loop; ?>,
				centerInsufficientSlides: <?php echo $center_insufficient_slides; ?>,
				centeredSlidesBounds: <?php echo $centered_slides_bounds; ?>,
				centeredSlides: <?php echo $centered_slides; ?>,
				slidesOffsetBefore: <?php echo $slides_offset_before; ?>,
				slidesOffsetAfter: <?php echo $slides_offset_after; ?>,
				freeMode: <?php echo $free_mode; ?>,
				speed: 300,
				/* watchOverflow: true, */
				/* freeMode: true, */
				slidesPerView: 1,
				spaceBetween: 0,
				pagination: {
					el: '.swiper-pagination',
					clickable: 'true',
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				breakpoints: {
					<?php if ($slides_per_view_xsmall) { ?>
						300: {
							slidesPerView: <?php echo $slides_per_view_xsmall; ?>,
						},
					<?php }
					if ($slides_per_view_small) { ?>
						320: {
							slidesPerView: <?php echo $slides_per_view_small; ?>,
						},
					<?php }
					if ($slides_per_view_medium) { ?>
						640: {
							slidesPerView: <?php echo $slides_per_view_medium; ?>,
						},
					<?php }
					if ($slides_per_view_large) { ?>
						960: {
							slidesPerView: <?php echo $slides_per_view_large; ?>,
						},
					<?php }
					if ($slides_per_view_xlarge) { ?>
						1200: {
							slidesPerView: <?php echo $slides_per_view_xlarge; ?>,
						},
					<?php } ?>
				}

			});

			<?php echo $element_id; ?>.on('slideChange', function() {
				// console.log('slide changed');
				var bLazy = new Blazy();
				bLazy.revalidate(); // eg bLazy.revalidate()
			});
		</script>

	<?php

		wp_reset_postdata($query);
	}
}


/**
 * Print a slider of posts filtered by custom fields
 *
 * https://developer.wordpress.org/reference/classes/wp_query/#order-orderby-parameters
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param $attributes array
 */
function canva_get_slider_posts_per_field($attributes = [])
{
	extract(shortcode_atts([
		'post_type' => 'post',
		'field_name' => '',
		'field_value' => '',
		'posts_per_page' => 6,
		'order' => 'DESC',
		'orderby' => 'date',
		'template_name' => 'card-news',
		'swiper_hero_class' => '',
		'swiper_container_class' => 'container',
		'slides_per_view_xsmall' => 1,
		'slides_per_view_small' => 1,
		'slides_per_view_medium' => 2,
		'slides_per_view_large' => 3,
		'slides_per_view_xlarge' => 3,
		'prev_next' => 'true',
		'pagination' => 'true',
		'autoplay' => 'false',
		'loop' => 'true',
		'centered_slides_bounds' => 'false',
		'centered_slides' => 'false',
		'center_insufficient_slides' => 'false',
		'slides_offset_before' => 0,
		'slides_offset_after' => 0,
		'free_mode' => 'false',
	], $attributes));

	$args = [
		'posts_per_page' 	=> $posts_per_page,
		'order' 			=> sanitize_text_field($order),
		'orderby' 			=> sanitize_text_field($orderby),
		'post_type' 		=> sanitize_text_field($post_type),
		'post__not_in'		=> [get_the_ID()],
		'meta_query' 		=> [
			[
				'key' => sanitize_text_field($field_name),
				// 'value' => '"' . sanitize_text_field($value) . '"',
				'value' => sanitize_text_field($field_value),
				'compare' => 'LIKE',
			],
		],
	];
	// var_dump($args);

	$query = new WP_Query($args);
	// var_dump($query);

	if ($query->have_posts()) {

		$element_id = esc_attr(wp_generate_password(16, false, false));
	?>

		<!-- ///////// Slider Posts ///////// -->
		<div id="<?php echo $element_id; ?>" class="hero-slider <?php echo esc_attr($swiper_hero_class); ?>">

			<div class="swiper-container <?php echo $element_id; ?> <?php echo esc_attr($swiper_container_class); ?>">

				<div class="swiper-wrapper">

					<?php
					while ($query->have_posts()) {
						$query->the_post();
						$do_not_duplicate = $post->ID;
						echo '<div class="swiper-slide">';
						canva_get_template(sanitize_text_field($template_name), ['post_id' => $do_not_duplicate]);
						echo '</div>';
					} ?>
				</div>

				<?php if ('true' === $pagination) { ?>
					<div class="swiper-pagination"></div>
				<?php } ?>

				<?php if ('true' === $prev_next) { ?>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				<?php } ?>

			</div>

		</div>

		<script>
			/* swiper slider post */
			var <?php echo $element_id; ?> = new Swiper('.<?php echo esc_js($element_id); ?>', {
				preloadImages: false,
				lazy: false,
				grabCursor: true,
				autoplay: <?php echo $autoplay; ?>,
				loop: <?php echo $loop; ?>,
				centerInsufficientSlides: <?php echo $center_insufficient_slides; ?>,
				centeredSlidesBounds: <?php echo $centered_slides_bounds; ?>,
				centeredSlides: <?php echo $centered_slides; ?>,
				slidesOffsetBefore: <?php echo $slides_offset_before; ?>,
				slidesOffsetAfter: <?php echo $slides_offset_after; ?>,
				freeMode: <?php echo $free_mode; ?>,
				speed: 300,
				/* watchOverflow: true, */
				/* freeMode: true, */
				slidesPerView: 1,
				spaceBetween: 0,
				pagination: {
					el: '.swiper-pagination',
					clickable: 'true',
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				breakpoints: {
					<?php if ($slides_per_view_xsmall) { ?>
						300: {
							slidesPerView: <?php echo $slides_per_view_xsmall; ?>,
						},
					<?php }
					if ($slides_per_view_small) { ?>
						320: {
							slidesPerView: <?php echo $slides_per_view_small; ?>,
						},
					<?php }
					if ($slides_per_view_medium) { ?>
						640: {
							slidesPerView: <?php echo $slides_per_view_medium; ?>,
						},
					<?php }
					if ($slides_per_view_large) { ?>
						960: {
							slidesPerView: <?php echo $slides_per_view_large; ?>,
						},
					<?php }
					if ($slides_per_view_xlarge) { ?>
						1200: {
							slidesPerView: <?php echo $slides_per_view_xlarge; ?>,
						},
					<?php } ?>
				}

			});

			<?php echo $element_id; ?>.on('slideChange', function() {
				// console.log('slide changed');
				var bLazy = new Blazy();
				bLazy.revalidate(); // eg bLazy.revalidate()
			});
		</script>

	<?php

		wp_reset_postdata($query);
	}
}


/**
 * Print a slider of posts choosed with acf post object or relationship
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param $attributes array
 */
function canva_slider_acf_post_object($attributes = [])
{
	extract(shortcode_atts([
		'acf_field_name' => 'post_object',
		'template_name' => 'render-blocks',
		'swiper_hero_class' => '',
		'swiper_container_class' => 'container',
		'slides_per_view_xsmall' => 1,
		'slides_per_view_small' => 2,
		'slides_per_view_medium' => 3,
		'slides_per_view_large' => 4,
		'slides_per_view_xlarge' => 4,
		'prev_next' => 'true',
		'pagination' => 'true',
		'autoplay' => 'false',
		'loop' => 'true',
		'centered_slides_bounds' => 'false',
		'centered_slides' => 'false',
		'center_insufficient_slides' => 'false',
		'slides_offset_before' => 0,
		'slides_offset_after' => 0,
		'free_mode' => 'false',
	], $attributes));

	$posts = get_field($acf_field_name);

	if ($posts) {
		$element_id = esc_attr(wp_generate_password(16, false, false));
	?>
		<!-- ///////// Slider Posts ///////// -->
		<div id="<?php echo $element_id; ?>" class="hero-slider <?php echo esc_attr($swiper_hero_class); ?>">

			<div class="swiper-container <?php echo $element_id; ?> <?php echo esc_attr($swiper_container_class); ?>">

				<div class="swiper-wrapper">

					<?php
					foreach ($posts as $post) {
						setup_postdata($post);
						echo '<div class="swiper-slide">';
						canva_get_template(sanitize_text_field($template_name), ['post_id' => $post->ID]);
						echo '</div>';
					}
					wp_reset_postdata(); ?>
				</div>

				<?php if ('true' === $pagination) { ?>
					<div class="swiper-pagination"></div>
				<?php } ?>

				<?php if ('true' === $prev_next) { ?>
					<div class="swiper-button-next"></div>
					<div class="swiper-button-prev"></div>
				<?php } ?>

			</div>

		</div>

		<script>
			/* swiper slider post */
			var <?php echo $element_id; ?> = new Swiper('.<?php echo $element_id; ?>', {
				preloadImages: false,
				lazy: true,
				grabCursor: true,
				autoplay: <?php echo $autoplay; ?>,
				loop: <?php echo $loop; ?>,
				centeredSlidesBounds: <?php echo $centered_slides_bounds; ?>,
				centeredSlides: <?php echo $centered_slides; ?>,
				centerInsufficientSlides: <?php echo $center_insufficient_slides; ?>,
				slidesOffsetBefore: <?php echo $slides_offset_before; ?>,
				slidesOffsetAfter: <?php echo $slides_offset_after; ?>,
				freeMode: <?php echo $free_mode; ?>,
				speed: 300,
				/* watchOverflow: true, */
				/* freeMode: true, */
				slidesPerView: 1,
				spaceBetween: 0,
				pagination: {
					el: '.swiper-pagination',
					clickable: 'true',
				},
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev',
				},
				breakpoints: {
					<?php if ($slides_per_view_xsmall) { ?>
						300: {
							slidesPerView: <?php echo $slides_per_view_xsmall; ?>,
						},
					<?php }
					if ($slides_per_view_small) { ?>
						320: {
							slidesPerView: <?php echo $slides_per_view_small; ?>,
						},
					<?php }
					if ($slides_per_view_medium) { ?>
						640: {
							slidesPerView: <?php echo $slides_per_view_medium; ?>,
						},
					<?php }
					if ($slides_per_view_large) { ?>
						960: {
							slidesPerView: <?php echo $slides_per_view_large; ?>,
						},
					<?php }
					if ($slides_per_view_xlarge) { ?>
						1200: {
							slidesPerView: <?php echo $slides_per_view_xlarge; ?>,
						},
					<?php } ?>
				}

			});

			<?php echo $element_id; ?>.on('slideChange', function() {
				// console.log('slide changed');
				var bLazy = new Blazy();
				bLazy.revalidate(); // eg bLazy.revalidate()
			});
		</script>

<?php
	}
}

/**
 * stampa il breadcrumb
 *
 * @return void
 */
function canva_get_breadcrumbs()
{
	if (is_home() || is_front_page() || is_category() || is_archive()) {
		//print nothing
	} else {
		if (function_exists('yoast_breadcrumb')) {
			return yoast_breadcrumb();
		}
	}
}

/**
 * Crea modali come il blocco modale
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param array $args
 * @return void
 */
function canva_get_modal($args = [])
{
	extract(shortcode_atts([
		'post_id' => '',
		'inline_mode' => true,
		'round_expansion_mode' => false,
		'button' => 'button',
		'template_name' => 'render-post-content',
		'animation_in' => 'modal-in-from-bottom',
		'animation_out' => 'modal-out-to-bottom',
		'modal_delay' => 500,
		'modal_container' => '',
		'icon' => '', // percorso tipo fontawesome fontawesome/regular/check
		'icon_css_classes' => '',
		'icon_right' => false,
		'toptitle' => '',
		'toptitle_css_classes' => '',
		'title' => '',
		'title_css_classes' => '',
		'subtitle' => '',
		'subtitle_css_classes' => '',
	], $args));

	if (!$post_id) {
		return;
	}

	if ($icon && is_string($icon)) {
		$icon_src = canva_get_svg_icon($icon, $icon_css_classes);
	} elseif ($icon && !is_string($icon)) {
		$icon_src = canva_get_svg_icon_from_url(wp_get_attachment_url($icon), $icon_css_classes);
	}

	if ($icon_right) {
		$icon_right = 'flex-row-reverse';
	}

	$text_align = '';
	if ($icon && $icon_right) {
		$text_align = 'text-right';
	} elseif ($icon && !$icon_right) {
		$text_align = 'text-left';
	}

	if (!$inline_mode) {
		$modal_mode = 'modal-post-open';
	} else {
		$modal_mode = 'inline-modal-post-open';
	}

	if ($round_expansion_mode) {
		$modal_mode .= ' modal-round-expansion';
	}

	$post = get_post($post_id);
	$track_event = canva_get_ga_event_tracker('Modal', 'click', $post->post_name);

	$html = '';

	$html .= '<a id="' . esc_attr($post_id) . '" class="' . esc_attr($modal_mode) . ' inline-flex ' . esc_attr($button . ' ' . $icon_right) . '" data-post-id="' . esc_attr($post_id) . '" data-action-name="modal_post_opener" data-template-name="' . esc_attr($template_name) . '" data-animation-in="' . esc_attr($animation_in) . '" data-animation-out="' . esc_attr($animation_out) . '" data-modal-delay="' . esc_attr($modal_delay) . '" data-modal-container-class="' . esc_attr($modal_container) . '" href="' . get_the_permalink($post_id) . '" ' . $track_event . '>';

	$html .= $icon_src;

	$html .= '<div class="' . esc_attr('text-wrapper' . ' ' . $text_align) . '">';

	if ($toptitle) {
		$html .= '<span class="toptitle ' . esc_attr($toptitle_css_classes) . '">';
		$html .= $toptitle;
		$html .= '</span>';
	}

	if ($title) {
		$html .= '<span class="title ' . esc_attr($title_css_classes) . '">';
		$html .= $title;
		$html .= '</span>';
	}

	if ($subtitle) {
		$html .= '<span class="subtitle ' . esc_attr($subtitle_css_classes) . '">';
		$html .= $subtitle;
		$html .= '</span>';
	}

	$html .= '</div>';

	$html .= '</a>';

	if ($inline_mode) {
		$modal_id = '_modal-id-' . $post_id;
		$html .= '<div class="hide ' . esc_attr($modal_id) . '">';
		$html .= canva_get_render_blocks($post_id);
		$html .= '</div>';
	}

	return $html;
}


/**
 * Local option for pages. In case you need to hide the content
 * of the pageThis function hides the page content by replacing it
 * with a default or custom message.
 *
 * @author Michele Tenaglia <info@micheletenaglia.it>
 * @return void
 */
function canva_page_maintenance_mode()
{

	global $post;

	if (get_field('page_maintenance_mode_toggle', $post->ID)) {

		echo '<div class="page_maintenance_mode_wrap ' . esc_attr(get_field('page_maintenance_mode_wrapper_classes', $post->ID)) . '">';
		echo '<div class="page_maintenance_mode ' . esc_attr(get_field('page_maintenance_mode_element_classes', $post->ID)) . '">';

		if (get_field('page_maintenance_mode_message', $post->ID)) {

			echo get_field('page_maintenance_mode_message', $post->ID);
		} else {

			echo '<h1>' . $post->post_title . '</h1>';
			echo '<p>' . __('Pagina temporaneamente non disponibile.', 'canva') . '</p>';
		}
		echo '</div>';
		echo '</div>';

		get_footer();

		exit;
	}
}
add_action('canva_container_start', 'canva_page_maintenance_mode', 99);



/**
 * Crea modali come il blocco modale
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param array $args
 * @return void
 */
function canva_get_action_link($args = [])
{
	extract(shortcode_atts([
		'url' => '',
		'target' => '',
		'button' => 'button',
		'icon' => '', // percorso tipo fontawesome fontawesome/regular/check
		'icon_css_classes' => '',
		'icon_right' => false,
		'toptitle' => '',
		'toptitle_css_classes' => '',
		'title' => '',
		'title_css_classes' => '',
		'subtitle' => '',
		'subtitle_css_classes' => '',
	], $args));


	$icon_src = '';
	if ($icon && is_string($icon)) {
		$icon_src = canva_get_svg_icon($icon, '_icon ' . $icon_css_classes);
	} elseif ($icon && !is_string($icon)) {
		$icon_src = canva_get_svg_icon_from_url(wp_get_attachment_url($icon), '_icon ' . $icon_css_classes);
	}

	if ($icon_right) {
		$icon_right = 'flex-row-reverse';
	}

	$text_align = '';
	if ($icon && $icon_right) {
		$text_align = 'text-right';
	} elseif ($icon && !$icon_right) {
		$text_align = 'text-left';
	}

	$slug = wp_basename($url);
	$track_event = canva_get_ga_event_tracker('Action-Link', 'click', $slug);

	$html = '';

	$html .= '<a class="inline-flex ' . esc_attr($button . ' ' . $hollow . ' ' . $icon_right) . '" href="' . esc_url($url) . '" ' . $target . ' ' . $track_event . '>';

	$html .= $icon_src;

	$html .= '<div class="' . esc_attr('text-wrapper' . ' ' . $text_align) . '">';

	if ($toptitle) {
		$html .= '<span class="toptitle ' . esc_attr($toptitle_css_classes) . '">';
		$html .= $toptitle;
		$html .= '</span>';
	}

	if ($title) {
		$html .= '<span class="title ' . esc_attr($title_css_classes) . '">';
		$html .= $title;
		$html .= '</span>';
	}

	if ($subtitle) {
		$html .= '<span class="subtitle ' . esc_attr($subtitle_css_classes) . '">';
		$html .= $subtitle;
		$html .= '</span>';
	}

	$html .= '</div>';

	$html .= '</a>';

	return $html;
}
