<?php
defined('ABSPATH') || exit;

// add_action('template_redirect', function () {
// 	ob_start();
// });

//////////////////////////////////////////////////////////////////////////////////////////
// Required files
// Acf fields for theme stuff
require_once 'cpt-register.php';
require_once 'acf-fields-project.php';

if (is_woocommerce_activated()) {
	require_once 'fn-woocommerce.php';
	require_once 'fn-woocommerce-checkout.php';
	require_once 'fn-woocommerce-gettext.php';
}

if (is_facetwp_activated()) {
	// require_once 'facetwp-proximity-primo.php';
	require_once 'fn-facetwp.php';
}

require_once 'fn-restapi.php';
require_once 'fn-wpallimport.php';

//////////////////////////////////////////////////////////////////////////////////////////

/**
 * Redirect dealer to a custom my account page after login
 *
 */
function abc_dealer_redirect_dashboard_after_login($url, $request, $user)
{
	if ($user && is_object($user) && is_a($user, 'WP_User')) {
		if ($user->has_cap('dealer')) {
			$url = admin_url('admin.php?page=wc-admin&path=%2Fanalytics%2Foverview');
		}
	}
	return $url;
}
add_filter('login_redirect', 'abc_dealer_redirect_dashboard_after_login', 10, 3);


/**
 *
 * Redirect dealer when try to access to the wp dashboard
 *
 */
function abc_dealer_redirect_dashboard()
{
	if (is_user_role('dealer')) {
		wp_safe_redirect(admin_url('admin.php?page=wc-admin&path=%2Fanalytics%2Foverview'));
	}
}
add_action('load-index.php', 'abc_dealer_redirect_dashboard');


/**
 * Remove toolbar items
 *
 * @param [type] $wp_admin_bar
 * @return void
 */
function abc_admin_remove_extra_toolbar_nodes($wp_admin_bar)
{
	if (is_user_role('dealer')) {
		$wp_admin_bar->remove_node('my-sites');
	}
}
add_action('admin_bar_menu', 'abc_admin_remove_extra_toolbar_nodes', 999);



/**
 * funzione per nascondere aree del backend in base ai ruoli
 *
 * @return void
 */

function abac_admin_remove_menu_items()
{
	global $menu;
	if (is_user_role('dealer')) {
		// remove_menu_page('admin.php?page=wc-admin');
		// remove_submenu_page('woocommerce', 'wc-admin');
		// remove_submenu_page('page', 'options');

		$restricted = [
			__('Posts'),
		];

		end($menu);
		while (prev($menu)) {
			$value = explode(' ', $menu[key($menu)][0]);
			if (in_array(null != $value[0] ? $value[0] : '', $restricted)) {
				unset($menu[key($menu)]);
			}
		} // end while
	}
}
add_action('admin_menu', 'abac_admin_remove_menu_items', 99);



/**
 * Disable ACF Fields in back end submission forms
 */
if (is_admin() && !current_user_can('activate_plugins')) {
	function disable_some_acf_fields($field)
	{
		$field['disabled'] = true;
		return $field;
	}
	add_filter('acf/load_field/name=new_product', 'disable_some_acf_fields');
}



/**
 * Cambio Icone di sistema con quelle progettuali
 */

// Shopping-Cart
// add_filter('shopping_cart_icon', function () {
// 	// return canva_get_svg_icon('eqipe-icons/test-cart', 'fill-current w-8');
// 	return canva_get_svg_icon('fontawesome/' . MENU_FONTAWESOME_ICON_TYPE . '/shopping-bag', 'fill-current w-8');
// });

// //Shopping-Cart
// add_filter('login_icon', function () {
// 	return canva_get_svg_icon('eqipe-icons/user-account', 'fill-current w-8');
// });


/**
 * Setup Phpmailer per Primo
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $phpmailer
 * @return void
 */
// function canva_send_smtp_email($phpmailer)
// {
// 	$phpmailer->isSMTP();
// 	// $phpmailer->SMTPDebug = 2;
// 	// $phpmailer->debug     = 1;
// 	$phpmailer->Host       = 'send.one.com';
// 	$phpmailer->SMTPAuth   = true;
// 	$phpmailer->Port       = '465';
// 	$phpmailer->Username   = 'toni@schiavoneguga.com';
// 	$phpmailer->Password   = '4xJ_k-oVGAFL_aFPKV';
// 	$phpmailer->SMTPSecure = 'ssl';
// 	$phpmailer->From       = 'no-reply@eqipe.it';
// 	$phpmailer->FromName   = 'eqipe.it';
// }
// add_action('phpmailer_init', 'canva_send_smtp_email');


/**
 * Funzione ajax per il mega menu in evidence
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $url
 * @return void
 */
function canva_get_featured_image_from_post_url($url)
{

	if (isset($_GET['url']) && ('' != trim($_GET['url']))) {
		$url = esc_attr($_GET['url']);
	} elseif (isset($_POST['url']) && '' != trim($_POST['url'])) {
		$url = esc_attr($_POST['url']);
	} elseif (isset($_REQUEST['url']) && '' != trim($_REQUEST['url'])) {
		$url = esc_attr($_REQUEST['url']);
	}

	if (isset($_GET['title']) && ('' != trim($_GET['title']))) {
		$title = esc_attr($_GET['title']);
	} elseif (isset($_POST['title']) && '' != trim($_POST['title'])) {
		$title = esc_attr($_POST['title']);
	} elseif (isset($_REQUEST['title']) && '' != trim($_REQUEST['title'])) {
		$title = esc_attr($_REQUEST['title']);
	}

	$post_data = trim($_POST['postData']);

	if ($post_data) {
		parse_str($post_data, $post_data_array);
		extract($post_data_array);
	}

	// echo $url;

	$post_id = url_to_postid(esc_url($url));
	$bg_content = '<div class="absolute bottom-0 left-4">' . $title . '</div>';

	echo canva_get_img([
		'img_id'   =>  $post_id,
		'img_type' => 'bg', // img, bg, url
		'thumb_size' =>  '320-11',
		'img_class' =>  '',
		'wrapper_class' =>  'relative min-h-full',
		// 'wrapper_style' => 'position:relative;height:400px;background-repeat:no-repeat;',
		'blazy' => 'off',
		'bg_content' => $bg_content,
	]);

	wp_die();
}
add_action('wp_ajax_canva_get_featured_image_from_post_url', 'canva_get_featured_image_from_post_url');
add_action('wp_ajax_nopriv_canva_get_featured_image_from_post_url', 'canva_get_featured_image_from_post_url');


/**
 * Contenitore Menu Tab Mobile
 *
 * @return void
 */
// function eqipe_nav_tab_mobile_template()
// {
// 	canva_get_template('menu-tab-mobile-eqipe');
// }
// add_action('menu_off_canvas_mobile_after', 'eqipe_nav_tab_mobile_template');

/**
 * Contenitore Menu Tab Mobile
 *
 * @return void
 */
function abac_mega_menu_desktop_template()
{
	canva_get_template('menu-mega-menu-desktop-abac-tools');
	canva_get_template('menu-mega-menu-desktop-abac-applications');
}
add_action('desktop_navigation_after', 'abac_mega_menu_desktop_template');
