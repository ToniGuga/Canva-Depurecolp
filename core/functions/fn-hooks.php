<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// Init
if (!is_user_logged_in()) {
	add_action('template_redirect', 'canva_maintenance_mode', 10); //for all
}

if (!get_field('show_admin_bar', 'options')) {
	add_filter('show_admin_bar', '__return_false');
} else {
	if (!current_user_can('edit_posts')) {
		add_filter('show_admin_bar', '__return_false');
	}
}

// Header
if (get_field('iubenda', 'options') || get_field('cookiebot', 'options')) {
	add_action('wp_head', 'gdpr_cookie_consent_bar', 0);
}

add_action('wp_head', 'canva_favicon', 20);
add_action('wp_head', 'canva_header_scripts', PHP_INT_MAX);
add_action('wp_head', 'canva_css_inline', PHP_INT_MAX);

add_action('canva_body_start', 'canva_body_scripts', 10);
add_action('canva_body_start', 'canva_menu_builder', 20);

if (get_field('google_analytics_id', 'options')) {
	add_action('wp_head', 'canva_google_analytics_header', 90);
}

// print facebook app id if defined in theme options
if (get_field('facebook_app_id', 'options')) {
	add_action('wp_head', function () {
		echo '<meta property="fb:app_id" content="' . esc_attr(get_field('facebook_app_id', 'option')) . '" />';
	}, 91);
}

if (get_field('facebook_pixel_id', 'options')) {
	add_action('wp_head', 'canva_facebook_pixel_header', 92);
}

// Stampa array js CF7 da usare pe la messaggistica delle modali in ajax
add_action('wp_head', 'canva_cf7_forms_ids_js_array', PHP_INT_MAX);

// Body

// Footer
add_action('canva_body_end', 'canva_footer_scripts', 10);
add_action('canva_body_end', 'canva_search_modal_html', 20);
add_action('canva_body_end', 'canva_contact_modal_html', 30);
add_action('canva_body_end', 'canva_photoswipe_html', 40);
// add_action('canva_body_end', 'canva_scroll_to_top_html', 50);
add_action('canva_body_end', 'canva_notices_html', 60);
add_action('canva_body_end', 'canva_privacy_infobar', 70);
add_action('canva_body_end', 'canva_off_canvas_layers_html', 80);
add_action('canva_body_end', 'canva_loading_footer', 81);

if (is_woocommerce_activated()) {
	add_action('canva_body_end', 'canva_ajax_modal_cart_html', 82);
}

add_action('canva_body_end', 'canva_modal_container_html', 89);
add_action('canva_body_end', 'canva_modal_post_opener_html', 90);

// Analytics Ecommerce Tracking
if (get_field('google_analytics_id', 'options') && is_woocommerce_activated()) {
	add_action('canva_body_end', 'canva_google_analytics_footer', PHP_INT_MAX);
}

//Stampa eventi js per tracciare invio moduli cf7
if (get_field('google_analytics_id', 'options')) {
	add_action('canva_body_end', 'canva_cf7_event_tracker', PHP_INT_MAX);
}
