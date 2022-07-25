<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}



/**
 * rimuove la versione dagli script e css
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $src
 * @return void
 */
function remove_css_js_wp_version($src)
{
	if (strpos($src, 'ver=')) {
		$src = remove_query_arg('ver', $src);
	}

	return $src;
}

add_filter('style_loader_src', 'remove_css_js_wp_version', 10, 2);
add_filter('script_loader_src', 'remove_css_js_wp_version', 10, 2);

/**
 * Define scripts versions
 *
 * @param [type] $script
 * @return void
 */
function canva_script_version($script)
{

	switch ($script) {

		case 'modernizr':
			return '2.8.3';
			break;
		case 'jquery':
			return '3.5.1';
			break;
		case 'jquery_migrate':
			return '3.3.2';
			break;
		case 'photoswipe':
			return '4.1.3';
			// return '5.2.4'; // non funzionante
			break;
		case 'swiper':
			return '6.6.2';
			break;
		case 'list':
			return '2.3.1';
			break;
		case 'blazy':
			return '1.8.2';
			break;
		case 'paroller':
			return '1.4.6';
			break;
		case 'clipboard':
			return '2.0.6';
			break;
		case 'lottie':
			return '5.7.3';
			break;
	}
}

if (!function_exists('canva_register_scripts')) {
	function canva_register_scripts()
	{

		wp_deregister_script('wp-embed');

		wp_deregister_script('jquery');
		// header scripts

		wp_register_script('photoswipe-async', '//cdnjs.cloudflare.com/ajax/libs/photoswipe/' . canva_script_version('photoswipe') . '/photoswipe.min.js', null, null, null);
		wp_enqueue_script('photoswipe-async');

		wp_register_script('photoswipeui-async', '//cdnjs.cloudflare.com/ajax/libs/photoswipe/' . canva_script_version('photoswipe') . '/photoswipe-ui-default.min.js', null, null, null);
		wp_enqueue_script('photoswipeui-async');

		wp_register_script('swiper', '//unpkg.com/swiper@' . canva_script_version('swiper') . '/swiper-bundle.min.js', null, null, null);
		wp_enqueue_script('swiper');

		//footer scripts
		wp_register_script('jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/' . canva_script_version('jquery') . '/jquery.min.js', null, null, true);
		wp_enqueue_script('jquery');

		if (get_field('script_jquery_migrate', 'options')) {
			wp_register_script('jquery-migrate', '//cdnjs.cloudflare.com/ajax/libs/jquery/' . canva_script_version('jquery_migrate') . '/jquery-migrate.min.js', null, null, true);
			wp_enqueue_script('jquery-migrate');
		}

		wp_register_script('blazy', '//cdnjs.cloudflare.com/ajax/libs/blazy/' . canva_script_version('blazy') . '/blazy.min.js', null, null, true);
		wp_enqueue_script('blazy');

		if (get_field('script_paroller', 'options')) {
			wp_register_script('paroller', '//cdnjs.cloudflare.com/ajax/libs/paroller.js/' . canva_script_version('paroller') . '/jquery.paroller.min.js', ['jquery'], null, true);
			wp_enqueue_script('paroller');
		}

		if (get_field('script_lottie', 'options')) {
			wp_register_script('lottie', '//cdnjs.cloudflare.com/ajax/libs/bodymovin/' . canva_script_version('lottie') . '/lottie.min.js', null, null, null);
			wp_enqueue_script('lottie');
		}

		wp_register_script('clipboard', '//cdnjs.cloudflare.com/ajax/libs/clipboard.js/' . canva_script_version('clipboard') . '/clipboard.min.js', null, null, true);
		wp_enqueue_script('clipboard');

		//Google Maps
		if ('' != get_google_map_api_key()) {
			wp_register_script('google-maps-api-asyncdefer', 'https://maps.googleapis.com/maps/api/js?key=' . get_google_map_api_key() . '&callback=initMap&v=weekly', [], null, true);
			wp_enqueue_script('google-maps-api-asyncdefer');
		}

		wp_register_script('canva-frontend',  CANVA_PROJECT_JS_URI . 'frontend.min.js?last_time=' . filemtime(CANVA_PROJECT_JS . 'frontend.min.js'), ['jquery'], false, true);
		wp_enqueue_script('canva-frontend');
		wp_set_script_translations('canva-frontend', 'canva'); // translation for js scripts

		// wc add to cart ajax Canva version
		// if (is_woocommerce_activated()) {
		// 	wp_deregister_script('wc-add-to-cart');
		// 	wp_register_script('wc-add-to-cart', CANVA_CORE_JS_URI . 'add-to-cart.min.js?last_time=' . filemtime(CANVA_CORE_JS . 'add-to-cart.min.js'), ['jquery'], false, true);
		// 	wp_enqueue_script('wc-add-to-cart');
		// }

		//ajax stuff for canva-frontend
		wp_localize_script(
			'canva-frontend',
			'WPURLS',
			[
				'homeurl' => esc_url(home_url()),
				'ajaxurl' => esc_url(admin_url('admin-ajax.php')),
				'nonce' => wp_create_nonce('nonce')
			]
		);

		if (is_singular() && comments_open() && get_option('thread_comments')) {
			wp_enqueue_script('comment-reply');
		}

		if (get_field('google_maps_style', 'options')) {
			wp_add_inline_script(
				'google-maps-api-asyncdefer',
				'var google_maps_style = ' . canva_minifier(get_field('google_maps_style', 'options')) . ';',
				'before'
			);
		} else {
			wp_add_inline_script(
				'google-maps-api-asyncdefer',
				'var google_maps_style',
				'before'
			);
		}
	}

	add_action('wp_enqueue_scripts', 'canva_register_scripts');
}

/**
 * print customer js vars for js dir uri
 *
 * @return void
 */
function canva_js_dir_uri()
{
	echo '<script>var canvaCurrentPageUri = "' . esc_url(get_permalink()) . '"; var canvaCoreJsUri = "' . esc_attr(CANVA_CORE_JS_URI) . '"; var canvaProjectJsUri = "' . esc_attr(CANVA_PROJECT_JS_URI) . '";</script>';
}
add_action('wp_head', 'canva_js_dir_uri', PHP_INT_MAX);


/**
 * add async or defer to included scripts via wp_register_script & wp_enqueue_script wp functions
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @inspired by https://matthewhorne.me/defer-async-wordpress-scripts/
 * @param [type] $tag
 * @param [type] $handle
 * @return void
 */
function canva_add_async_defer_attr($tag, $handle)
{
	if (!is_admin()) {
		if (false !== strpos($handle, 'asyncdefer')) {
			// return the tag with the async attribute
			return str_replace('<script ', '<script async defer ', $tag);
		} elseif (false !== strpos($handle, 'async')) {
			return str_replace('<script ', '<script async ', $tag);
		} elseif (false !== strpos($handle, 'defer')) {
			// return the tag with the defer attribute
			return str_replace('<script ', '<script defer ', $tag);
		} else {
			return $tag;
		}
	} else {
		return $tag;
	}
}
add_filter('script_loader_tag', 'canva_add_async_defer_attr', 10, 2);


//removes jetpack css styles
add_filter('jetpack_sharing_counts', '__return_false', PHP_INT_MAX);
add_filter('jetpack_implode_frontend_css', '__return_false', PHP_INT_MAX);


//Disable extra styles e scripts
function canva_deregister_styles()
{
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('xpay-style');
	wp_dequeue_style('contact-form-7');  // Dequeue CSS file.

	// Deregister Woocommerce Styles
	wp_dequeue_style('wc-block-style');
	wp_dequeue_style('wc-blocks-style');  // Dequeue CSS file.
	wp_dequeue_style('wc-blocks-vendors-style');  // Dequeue CSS file.

}
add_action('wp_enqueue_scripts', 'canva_deregister_styles', PHP_INT_MAX);


/**
 * Register the block.
 */
function canva_block_editor_assets()
{
	wp_enqueue_script('canva-blocks', CANVA_CORE_JS_URI . 'backend-blocks.min.js', ['wp-blocks', 'wp-element', 'wp-edit-post']);

	if (file_exists(CANVA_PROJECT_JS . 'backend-blocks.min.js')) {
		wp_enqueue_script('canva-project-blocks', CANVA_PROJECT_JS_URI . 'backend-blocks.min.js', ['wp-blocks', 'wp-element', 'wp-edit-post']);
	}
}
add_action('enqueue_block_editor_assets', 'canva_block_editor_assets', PHP_INT_MAX);



/**
 * canva_register_styles function
 * aggiunge i css gulpati del progetto.
 */
function canva_register_styles()
{

	$primary_font_google = get_field('primary_font_google', 'options');
	$secondary_font_google = get_field('secondary_font_google', 'options');
	$extra_font_google = get_field('extra_font_google', 'options');

	if ($primary_font_google['url']) {
		if ($primary_font_google['preload']) {
			wp_register_style('primary-font-google-preload', $primary_font_google['url']);
			wp_enqueue_style('primary-font-google-preload');
		} else {
			wp_register_style('primary-font-google', $primary_font_google['url']);
			wp_enqueue_style('primary-font-google');
		}
	}

	if ($secondary_font_google['url']) {
		if ($secondary_font_google['preload']) {
			wp_register_style('secondary-font-google-preload', $secondary_font_google['url']);
			wp_enqueue_style('secondary-font-google-preload');
		} else {
			wp_register_style('secondary-font-google', $secondary_font_google['url']);
			wp_enqueue_style('secondary-font-google');
		}
	}

	if ($extra_font_google['url']) {
		if ($extra_font_google['preload']) {
			wp_register_style('extra-font-google-preload', $extra_font_google['url']);
			wp_enqueue_style('extra-font-google-preload');
		} else {
			wp_register_style('extra-font-google', $extra_font_google['url']);
			wp_enqueue_style('extra-font-google');
		}
	}


	$primary_font_woff = get_field('primary_font_woff', 'options');
	$secondary_font_woff = get_field('secondary_font_woff', 'options');
	$extra_font_woff = get_field('extra_font_woff', 'options');

	if ($primary_font_woff['url']) {
		if ($primary_font_woff['preload']) {
			wp_register_style('primary-font-woff-preload', $primary_font_woff['url']);
			wp_enqueue_style('primary-font-woff-preload');
		} else {
			wp_register_style('primary-font-woff', $primary_font_woff['url']);
			wp_enqueue_style('primary-font-woff');
		}
	}

	if ($secondary_font_woff['url']) {
		if ($secondary_font_woff['preload']) {
			wp_register_style('secondary-font-woff-preload', $secondary_font_woff['url']);
			wp_enqueue_style('secondary-font-woff-preload');
		} else {
			wp_register_style('secondary-font-woff', $secondary_font_woff['url']);
			wp_enqueue_style('secondary-font-woff');
		}
	}
	if ($extra_font_woff['url']) {
		if ($extra_font_woff['preload']) {
			wp_register_style('extra-font-woff-preload', $extra_font_woff['url']);
			wp_enqueue_style('extra-font-woff-preload');
		} else {
			wp_register_style('extra-font-woff', $extra_font_woff['url']);
			wp_enqueue_style('extra-font-woff');
		}
	}

	wp_register_style('canva-frontend-min-preload', CANVA_PROJECT_CSS_URI . 'frontend.min.css?last_time=' . filemtime(CANVA_PROJECT_CSS . 'frontend.min.css'), null, false);
	wp_enqueue_style('canva-frontend-min-preload');
}
add_action('wp_enqueue_scripts', 'canva_register_styles');


/**
 * Register font face for custom static fonts loaded from Canva Page Options
 *
 * Font Names are: Primary Font; Secondary Font; Extra Font
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return string
 */
function canva_font_face()
{

	$primary_font_woff = get_field('primary_font_woff', 'options');
	$secondary_font_woff = get_field('secondary_font_woff', 'options');
	$extra_font_woff = get_field('extra_font_woff', 'options');

	$html = '';

	if ($primary_font_woff['url']) {
		if (get_file_extension($primary_font_woff['url']) === 'woff2') {
			$html .= '
			<style>
			@font-face {
				font-family: "Primary Font";
				src: url("' . esc_url($primary_font_woff['url']) . '") format("woff2");
			}
			</style>
			';
		} else {
			$html .= '
			<style>
			@font-face {
				font-family: "Primary Font";
				src: url("' . esc_url($primary_font_woff['url']) . '") format("woff");
			}
			</style>
			';
		}
	}

	if ($secondary_font_woff['url']) {
		if (get_file_extension($primary_font_woff['url']) === 'woff2') {
			$html .= '
			<style>
			@font-face {
				font-family: "Secondary Font";
				src: url("' . esc_url($secondary_font_woff['url']) . '") format("woff2");
			}
			</style>
			';
		} else {
			$html .= '
			<style>
			@font-face {
				font-family: "Secondary Font";
				src: url("' . esc_url($secondary_font_woff['url']) . '") format("woff");
			}
			</style>
			';
		}
	}

	if ($extra_font_woff['url']) {
		if (get_file_extension($extra_font_woff['url']) === 'woff2') {
			$html .= '
			<style>
			@font-face {
				font-family: "Extra Font";
				src: url("' . esc_url($extra_font_woff['url']) . '") format("woff2");
			}
			</style>
			';
		} else {
			$html .= '
			<style>
			@font-face {
				font-family: "Extra Font";
				src: url("' . esc_url($primary_font_woff['url']) . '") format("woff");
			}
			</style>
			';
		}
	}
	echo $html;
}
add_action('wp_head', 'canva_font_face');




/**
 * add preload to included styles via wp_register_style & wp_enqueue_script wp functions
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @inspired by https://matthewhorne.me/defer-async-wordpress-scripts/
 * @param [type] $tag
 * @param [type] $handle
 * @return void
 */

function canva_webfonts_add_preload_attr($tag, $handle)
{
	if (!is_admin()) {
		if (false !== strpos($handle, 'preload')) {
			return str_replace("rel='stylesheet'", "rel='stylesheet preload' crossorigin='true' as='font'", $tag);
		} elseif (false !== strpos($handle, 'woff')) {
			$clean = str_replace("type='text/css' media='all'", "", $tag);
			return str_replace("rel='stylesheet'", "rel='preload' crossorigin='true' as='font' type='font/woff2'", $clean);
		} else {
			return $tag;
		}
	} else {
		return $tag;
	}
}
add_filter('style_loader_tag', 'canva_webfonts_add_preload_attr', 10, 2);


/**
 * Preconnect
 *
 * @return void
 */
function canva_preconnections()
{
	$html = '';

	$html .= '<link rel="preconnect" href="//cdnjs.cloudflare.com" crossorigin />';
	$html .= '<link rel="preconnect" href="//unpkg.com" crossorigin />';
	$html .= '<link rel="preconnect" href="//connect.facebook.net" crossorigin />';
	$html .= '<link rel="preconnect" href="//www.google-analytics.com" crossorigin />';
	$html .= '<link rel="preconnect" href="//fonts.gstatic.com" crossorigin />';
	$html .= '<link rel="preconnect" href="//maps.googleapis.com" crossorigin />';

	echo $html;
}
add_action('wp_head', 'canva_preconnections', 1);



/*
 *
 * my_admin_theme_style()
 * Aggiunge uno stylesheet per il backend
 *
 */

function canva_admin_theme_style()
{
	if (is_user_role('administrator')) {
		if (file_exists(CANVA_CORE_CSS . 'backend-admin.css')) {
			wp_register_style('canva-admin-backend', CANVA_CORE_CSS_URI . 'backend-admin.css', filemtime(CANVA_CORE_CSS . 'backend-admin.css'));
			wp_enqueue_style('canva-admin-backend');
		}
	} else {
		if (file_exists(CANVA_CORE_CSS . 'backend-admin.css')) {
			wp_register_style('canva-admin-backend', CANVA_CORE_CSS_URI . 'backend-admin.css', filemtime(CANVA_CORE_CSS . 'backend-admin.css'));
			wp_enqueue_style('canva-admin-backend');
		}
		if (file_exists(CANVA_CORE_CSS . 'backend-editor.css')) {
			wp_register_style('canva-editor-backend', CANVA_CORE_CSS_URI . 'backend-editor.css', filemtime(CANVA_CORE_CSS . 'backend-editor.css'));
			wp_enqueue_style('canva-editor-backend');
		}
	}

	if (file_exists(CANVA_PROJECT_CSS . 'backend-editor.css')) {
		wp_register_style('canva-project-editor-backend', CANVA_PROJECT_CSS_URI . 'backend-editor.css', filemtime(CANVA_PROJECT_CSS . 'backend-editor.css'));
		wp_enqueue_style('canva-project-editor-backend');
	}
}
add_action('admin_enqueue_scripts', 'canva_admin_theme_style');
add_action('login_enqueue_scripts', 'canva_admin_theme_style');

function canva_admin_project_colors()
{

	if (get_field('primary_color', 'options')) {

		echo '<style>';

		echo ':root {';

		echo '--wp-admin-theme-color: ' . get_field('primary_color', 'options') . ';';
		echo '--color-accent: ' . get_field('secondary_color', 'options') . ';';

		echo '}';

		echo '.canva-icon-accent{ fill: ' . get_field('primary_color', 'options') . ' !important; }';

		echo '</style>';
	}
}
add_action('admin_head', 'canva_admin_project_colors');


/**
 * Include js in backend
 *
 * @return void
 */
function canva_custom_admin_js()
{

	wp_register_script('canva-admin-js', CANVA_CORE_JS_URI . 'backend-admin.js', ['jquery-core'], filemtime(CANVA_CORE_JS . 'backend-admin.js'));
	wp_enqueue_script('canva-admin-js');
}
add_action('admin_enqueue_scripts', 'canva_custom_admin_js');



/*
 *
 * canva_login_logo()
 * Cambia il logo della login page
 *
 */

function canva_login_logo()
{
	if (get_field('logo_light_mode', 'options')) {

		$image = get_field('logo_light_mode', 'options');

		$bg_size = '';

		if (get_field('logo_login_sizes', 'options')) {
			$sizes = get_field('logo_login_sizes', 'options');
			$bg_size = 'background-size:' . $sizes['width'] . 'px ' . $sizes['heigth'] . 'px';
		}

		$img = $image['sizes']['640-free']; ?>

		<style type="text/css">
			body.login div#login h1 a {
				background-image: url(<?php echo $img; ?>);
				<?php echo $bg_size; ?>
			}
		</style>

<?php
	}
}
// add_action('login_enqueue_scripts', 'canva_login_logo');

/*
 *
 * my_login_logo_url()
 * Definisce il link dell'logo della login page
 *
 */

function canva_login_logo_url()
{
	return home_url();
}
add_filter('login_headerurl', 'canva_login_logo_url');


/**
 * Queue some code to be output in the footer.
 *
 * @param string $code code
 */
function canva_enqueue_code_to_wp_footer($code)
{
	global $canva_enqueue_code_to_wp_footer;

	if (empty($canva_enqueue_code_to_wp_footer)) {
		$canva_enqueue_code_to_wp_footer = '';
	}

	$canva_enqueue_code_to_wp_footer .= "\n" . $code . "\n";
}

/**
 * Output any queued javascript code in the footer.
 */
function canva_print_code_to_wp_footer()
{
	global $canva_enqueue_code_to_wp_footer;

	if (!empty($canva_enqueue_code_to_wp_footer)) {
		// Sanitize.
		$canva_enqueue_code_to_wp_footer = wp_check_invalid_utf8($canva_enqueue_code_to_wp_footer);
		$canva_enqueue_code_to_wp_footer = preg_replace('/&#(x)?0*(?(1)27|39);?/i', "'", $canva_enqueue_code_to_wp_footer);
		$canva_enqueue_code_to_wp_footer = str_replace("\r", '', $canva_enqueue_code_to_wp_footer);

		$code = "\n{$canva_enqueue_code_to_wp_footer}\n";

		/**
		 * Queued codefilter.
		 *
		 * @since 2.6.0
		 *
		 * @param string $code javaScript code
		 */
		echo apply_filters('canva_queued_code_to_wp_footer', $code); // WPCS: XSS ok.

		unset($canva_enqueue_code_to_wp_footer);
	}
}
//hooked in canva-actions.php


function canva_header_scripts()
{
	if (get_field('scripts_head', 'options')) {
		echo canva_minifier(get_field('scripts_head', 'options'));
	}
}
//hooked in canva-actions.php

function canva_body_scripts()
{
	if (get_field('scripts_body', 'options')) {
		echo canva_minifier(get_field('scripts_body', 'options'));
	}
}
//hooked in canva-actions.php

function canva_footer_scripts()
{
	if (get_field('scripts_footer', 'options')) {
		echo canva_minifier(get_field('scripts_footer', 'options'));
	}
}
//hooked in canva-actions.php

function canva_css_inline()
{
	if (get_field('css_inline', 'options')) {
		echo '<style>' . canva_minifier(get_field('css_inline', 'options')) . '</style>';
	}
}
//hooked in canva-actions.php
