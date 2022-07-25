<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//Canva Theme folders paths

// Ajax Stuff
define('CANVA_ADMIN_AJAX_URI', admin_url('admin-ajax.php'));

// Core Costants
define('CANVA_CORE', get_template_directory() . '/core/');
define('CANVA_CORE_URI', get_template_directory_uri() . '/core/');
define('CANVA_CORE_TEMPLATES', get_template_directory() . '/core/templates/');
define('CANVA_CORE_CSS', get_template_directory() . '/core/assets/css/');
define('CANVA_CORE_CSS_URI', get_template_directory_uri() . '/core/assets/css/');
define('CANVA_CORE_JS', get_template_directory() . '/core/assets/js/');
define('CANVA_CORE_JS_URI', get_template_directory_uri() . '/core/assets/js/');
define('CANVA_CORE_IMG', get_template_directory() . '/core/assets/img/');
define('CANVA_CORE_IMG_URI', get_template_directory_uri() . '/core/assets/img/');
define('CANVA_CORE_BLOCKS', get_template_directory() . '/core/blocks/');
define('CANVA_CORE_BLOCKS_URI', get_template_directory_uri() . '/core/blocks/');


// Project Costants
define('CANVA_PROJECT', get_template_directory() . '/project/');
define('CANVA_PROJECT_URI', get_template_directory_uri() . '/project/');
define('CANVA_PROJECT_TEMPLATES', get_template_directory() . '/project/templates/');
define('CANVA_PROJECT_CSS', get_template_directory() . '/project/assets/css/');
define('CANVA_PROJECT_CSS_URI', get_template_directory_uri() . '/project/assets/css/');
define('CANVA_PROJECT_JS', get_template_directory() . '/project/assets/js/');
define('CANVA_PROJECT_JS_URI', get_template_directory_uri() . '/project/assets/js/');
define('CANVA_PROJECT_IMG', get_template_directory() . '/project/assets/img/');
define('CANVA_PROJECT_IMG_URI', get_template_directory_uri() . '/project/assets/img/');
define('CANVA_PROJECT_BLOCKS', get_template_directory() . '/project/blocks/');
define('CANVA_PROJECT_BLOCKS_URI', get_template_directory_uri() . '/project/blocks/');

//
define('CANVA_ACF_VERSION','5.12.2');

// Define path and URL to the ACF plugin.
define('MY_ACF_PATH', get_template_directory() . '/core/acf-'.CANVA_ACF_VERSION.'/');
define('MY_ACF_URL', get_template_directory_uri() . '/core/acf-'.CANVA_ACF_VERSION.'/');

// Include the ACF plugin.
include_once MY_ACF_PATH . 'acf.php';

// Customize the url setting to fix incorrect asset URLs.
function canva_acf_settings_url($url)
{
	return MY_ACF_URL;
}
add_filter('acf/settings/url', 'canva_acf_settings_url');

// (Optional) Hide the ACF admin menu item.
function canva_acf_settings_show_admin($show_admin)
{
	return true;
}
add_filter('acf/settings/show_admin', 'canva_acf_settings_show_admin');


/**
 * Set Security Header
 *
 * @return void
 */

function canva_set_security_headers($headers)
{

	// var_dump($headers); #=> if you want to see the current headers...

	$headers['X-XSS-Protection'] = '1; mode=block';
	$headers['Strict-Transport-Security'] = 'max-age=63072000; includeSubDomains; preload';
	$headers['X-Content-Type-Options'] = 'nosniff';
	$headers['X-Frame-Options'] = 'SAMEORIGIN';
	$headers['Access-Control-Allow-Origin'] = '*';

	return $headers;
}
add_filter('wp_headers', 'canva_set_security_headers');



/**
 * Returns the right template path
 *
 * @param [type] $slug
 * @param array $args
 * @return void
 */
function canva_get_template($template_name, $args = [])
{
	// here we're copying more of what get_template_part is doing.
	$template = '';

	if (file_exists(CANVA_PROJECT_TEMPLATES . $template_name . '.php')) {
		$template = locate_template(["{$template_name}.php", 'project/templates/' . "{$template_name}.php"]);
	} else {
		$template = locate_template(["{$template_name}.php", 'core/templates/' . "{$template_name}.php"]);
	}

	if (!$template) {
		return;
	}

	if ($args) {
		extract($args);
	}

	include $template;
}

/*
 *
 * is_there_any_post($post_type = 'post')
 * controlla se ci sono post pubblicati in un post type
 *
 */

function is_there_any_post($post_type = 'post', $taxonomy = 'category', $term_id = '')
{
	$args = [
		'posts_per_page' => -1,
		'post_type' => $post,
		'tax_query' => [
			[
				'taxonomy' => $taxonomy,
				'field' => 'term_id',
				'terms' => $term_id,
			],
		],
	];

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		return true;
	}

	return false;
	wp_reset_query();
}

/*
 *
 * is_acf_activated()
 * controlla se ACF è attivo o no
 *
 */

function is_acf_activated()
{
	return class_exists('acf') ? true : false;
}

/*
 *
 * is_woocommerce_activated()
 * controlla se woocommerce è attivo o no
 *
 */

function is_woocommerce_activated()
{
	return class_exists('woocommerce') ? true : false;
}

function is_woocommerce_membership_activated()
{
	return class_exists('wc_memberships') ? true : false;
}

function is_woocommerce_subscription_activated()
{
	return class_exists('wc_subscriptions') ? true : false;
}


 /**
  * check if WPML is active
  *
  * @return boolean
  */
function is_wpml_activated()
{
	return function_exists('icl_object_id') ? true : false;
}

/**
 * get current navigation language WPML.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return string
 */
function get_current_lang()
{
	if (is_wpml_activated()) {
		if (defined('ICL_LANGUAGE_CODE')) {
			return $current_lang = ICL_LANGUAGE_CODE;
		}
	} else {
		return 'it';
	}
}


/**
 * check if facetwp plugin is activated
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return boolean
 */
function is_facetwp_activated()
{
	return class_exists('FacetWP') ? true : false;
}


/**
 * check if maintenance mode is on
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return boolean
 */
function is_maintenance_mode_activated()
{
	$maintenance_mode = get_field('maintenance_mode','options');

	if ($maintenance_mode['maintenance_mode_option']) {
		return true;
	}else{
		return false;
	}
}


/**
 * Undocumented function
 *
 * @param integer $user_id
 * @return void
 */
function get_user_role($user_id = 0)
{
	$user = ($user_id) ? get_userdata($user_id) : wp_get_current_user();

	return current($user->roles);
}

function is_user_role($role = 'administrator')
{
	$current_user = wp_get_current_user();

	if (is_user_logged_in() && get_user_role($current_user->ID) == $role) {
		return true;
	} else {
		return false;
	}
}

/**
 * check if url is external or not
 *
 * @param [type] $url
 * @return boolean
 */
function is_url_local($url)
{
	if (empty($url)) {
		return false;
	}

	$urlParsed = parse_url($url);
	$host = $urlParsed['host'];

	if (empty($host)) {
		// maybe we have a relative link like: /wp-content/uploads/image.jpg
		// add absolute path to begin and check if file exists
		$doc_root = $_SERVER['DOCUMENT_ROOT'];
		$maybefile = $doc_root . $url;
		// Check if file exists
		$fileexists = file_exists($maybefile);
		if ($fileexists) {
			// maybe you want to convert to full url?
			return true;
		}
	}

	// strip www. if exists
	$host = str_replace('www.', '', $host);
	$thishost = $_SERVER['HTTP_HOST'];

	// strip www. if exists
	$thishost = str_replace('www.', '', $thishost);
	if ($host == $thishost) {
		return true;
	}

	return false;
}


/**
 * returns the client ip address
 *
 * @return void
 */
function get_client_ip()
{
	$ipaddress = '';

	if (getenv('HTTP_CLIENT_IP')) {
		$ipaddress = getenv('HTTP_CLIENT_IP');
	} elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	} elseif (getenv('HTTP_X_FORWARDED')) {
		$ipaddress = getenv('HTTP_X_FORWARDED');
	} elseif (getenv('HTTP_FORWARDED_FOR')) {
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	} elseif (getenv('HTTP_FORWARDED')) {
		$ipaddress = getenv('HTTP_FORWARDED');
	} elseif (getenv('REMOTE_ADDR')) {
		$ipaddress = getenv('REMOTE_ADDR');
	} else {
		$ipaddress = 'UNKNOWN';
	}

	return $ipaddress;
}
