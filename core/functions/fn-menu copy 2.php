<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Regisre Canva Menu locations
 */
register_nav_menus([
	//Header
	'menu-desktop-left' => 'Menu Desktop Left (Desktop OPT)',
	'menu-desktop-center' => 'Menu Desktop Center (Desktop OPT)',
	'menu-desktop-right' => 'Menu Desktop Right (Desktop OPT)',
	'off-canvas-desktop' => 'Off Canvas (Desktop OPT)',
	'menu-aux-left' => 'Menu Aux Left (Desktop OPT)',
	'menu-aux-center' => 'Menu Aux Center (Desktop OPT)',
	'menu-aux-right' => 'Menu Aux Right (Desktop OPT)',
	'off-canvas-mobile' => 'Off Canvas (Mobile OPT)',
	//Footer
	'menu-footer-items-1' => 'Menu Footer Items 1',
	'menu-footer-items-2' => 'Menu Footer Items 2',
	'menu-footer-items-3' => 'Menu Footer Items 3',
	'menu-footer-items-4' => 'Menu Footer Items 4',
	'menu-footer-items-5' => 'Menu Footer Items 5',
	'menu-footer-items-6' => 'Menu Footer Items 6',
	'menu-footer-social' => 'Menu Footer Social',
]);


class Canva_Horizontal_Walker extends Walker_Nav_Menu
{
	public function start_lvl(&$output, $depth = 0, $args = [])
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n{$indent}<ul class=\"menu horizontal dropdown\">\n";
	}
}


class Canva_Vertical_Walker extends Walker_Nav_Menu
{
	public function start_lvl(&$output, $depth = 0, $args = [])
	{
		$indent = str_repeat("\t", $depth);
		$output .= "\n{$indent}<ul class=\"menu vertical dropdown\" style=\"display: none;\">\n";
	}
}


function canva_prefix_nav_description($item_output, $item, $depth, $args)
{
	if (!empty($item->description)) {
		$item_output = str_replace($args->link_after . '</a>', '<p class="menu-item-description mb-0">' . $item->description . '</p>' . $args->link_after . '</a>', $item_output);
	}

	return $item_output;
}
add_filter('walker_nav_menu_start_el', 'canva_prefix_nav_description', 10, 4);


/**
 * Prints canva menu even as a shortcode
 *
 * @param [type] $atts
 * @return void
 */

function canva_menu($atts)
{
	extract(shortcode_atts([
		'container' => false,
		'location' => '',
		'depth' => 1,
		'css_classes' => 'flex flex-col',
		'items_wrap' => '<ul class="menu-footer %1$s %2$s">%3$s</ul>',
		'walker' => '',
		'echo' => false,
	], $atts));

	$html = wp_nav_menu([
		'container' => $container,
		'menu_class' => $css_classes,
		'items_wrap' => $items_wrap,
		'theme_location' => $location,
		'depth' => $depth,
		'fallback_cb' => false,
		'walker' => $walker,
		'echo' => $echo,
	]);

	return $html;
}
add_shortcode('canva_menu', 'canva_menu');


function canva_lang_selector()
{
	if (is_wpml_activated()) {
		$languages = icl_get_languages('skip_missing=0');
		if (!empty($languages)) {
			$html = '';
			foreach ($languages as $l) {

				if ($l['language_code'] === ICL_LANGUAGE_CODE) {
					$current_lang = 'current-language';
				} else {
					$current_lang = '';
				}

				$html .= '<li class="menu-item-lang menu-item-lang-' . $l['language_code'] . ' ' . $current_lang . '">';
				$html .= '<a href="' . $l['url'] . '" aria-label="' . $l['native_name'] . '">';
				$html .= '<span class="lang lang-' . $l['language_code'] . '" title="' . $l['native_name'] . '">' . strtoupper(icl_disp_language($l['language_code'])) . '</span>';
				$html .= '</a>';
				$html .= '</li>';
			}
			return $html;
		} else {

			return apply_filters('canva_lang_selector', $html);
		}
	}
}

function canva_lang_selector_submenu()
{
	if (is_wpml_activated()) {

		$languages = icl_get_languages('skip_missing=0');
		$html = '';

		if (!empty($languages)) {

			$current_language = [];
			$other_languages = [];


			foreach ($languages as $l) {
				if (ICL_LANGUAGE_CODE === $l['language_code']) {
					$current_language[] = ['url' => $l['url'], 'lang_code' => $l['language_code'], 'lang_name' => $l['native_name']];
				} else {
					$other_languages[] = ['url' => $l['url'], 'lang_code' => $l['language_code'], 'lang_name' => $l['native_name']];
				}
			}

			$html .= '<li class="menu-item-icon menu-item-has-children menu-item-lang-' . $current_language[0]['lang_code'] . '">';
			$html .= '<a href="' . $current_language[0]['url'] . '" aria-label="' . $current_language[0]['lang_name'] . '">';
			$html .= '<span class="lang lang-' . $current_language[0]['lang_code'] . '" title="' . $current_language[0]['lang_name'] . '">' . strtoupper(icl_disp_language($current_language[0]['lang_code'])) . '</span>';
			$html .= '</a>';

			$html .= '<ul class="menu lang-dropdown absolute hide">';

			foreach ($other_languages as $language) {
				$html .= '<li class="menu-item menu-item-lang-' . $language['lang_code'] . '">';
				$html .= '<a href="' . $language['url'] . '" aria-label="' . $language['lang_name'] . '">';
				$html .= '<span class="lang lang-' . $language['lang_code'] . '" title="' . $language['lang_name'] . '">' . $language['lang_name'] . '</span>';
				$html .= '</a>';
				$html .= '</li>';
			}

			$html .= '</ul>';
			$html .= '</li>';

			return $html;
		} else {

			return apply_filters('canva_lang_selector_submenu', $html);
		}
	}
}


function canva_get_extra_menu_items($menu_item = '')
{

	//set the default Fontawesome Type in Regular
	$menu_fontawesome_icon_type = apply_filters('menu-fontawesome-icon-type', 'regular'); // !!! Attento Toni che qui hai scritto font"o"wesome

	$html = '';

	if ('hamburger-icon' == $menu_item) {
		$html .= '<li class="menu-item-icon menu-item-icon-hamburger">
                <a class="hamburger-modal cursor-pointer" aria-label="Menu">
                    <span class="ham-bars-container">
						<span class="ham-bars"></span>
					</span>
                </a>
             </li>';
	}

	if ('logo' == $menu_item) {
		$html .= '<li class="menu-item-logo cursor-pointer"><a class="logo" href="' . home_url() . '" aria-label="Home Page">' . canva_get_logo() . '</a></li>';
	}

	if ('search-icon-modal' == $menu_item) {
		$html .= '<li class="menu-item-icon menu-item-icon-search cursor-pointer"><a class="search-icon-modal modal-open cursor-pointer" data-modal-content="modal-search" aria-label="' . __('Search', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/search', $css_classes = 'fill-current') . '</a></li>';
	}

	if ('search-icon-inline' == $menu_item) {
		$html .= '<li class="menu-item-icon menu-item-icon-search cursor-pointer"><a class="search-icon-inline cursor-pointer" aria-label="' . __('Search', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/search', $css_classes = 'fill-current') . '</a></li>';
	}

	if ('tel-icon' == $menu_item) {
		if (get_field('telephone', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-tel cursor-pointer"><a class="tel-icon" href="tel:' . str_replace(['(+39)', ' '], '', get_field('telephone', 'options')) . '" onclick="ga(\'send\', \'event\', \'Action-Link\', \'click\', \'' . get_field('telephone', 'options') . '\');" aria-label="' . __('Phone', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/phone', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('tel-number' == $menu_item) {
		if (get_field('telephone', 'options')) {
			$html .= '<li class="menu-item menu-item-tel cursor-pointer"><a class="tel-number" href="tel:' . str_replace(['(+39)', ' '], '', get_field('telephone', 'options')) . '" onclick="ga(\'send\', \'event\', \'Action-Link\', \'click\', \'' . get_field('telephone', 'options') . '\');" aria-label="' . __('Phone', 'canva-frontend') . '">' . get_field('telephone', 'options') . '</a></li>';
		}
	}

	if ('mail-icon-form-modal' == $menu_item) {
		$html .= '<li class="menu-item-icon menu-item-icon-mail cursor-pointer"><a class="mail-icon-form-modal modal-open cursor-pointer" data-modal-content="modal-contact" aria-label="' . __('Mail', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/envelope', $css_classes = 'fill-current') . '</a></li>';
	}

	if ('mailto-icon' == $menu_item) {
		if (get_field('email', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-mailto cursor-pointer"><a class="mailto-icon cursor-pointer" href="mailto:' . get_field('email', 'options') . '" class="mailto-menu" aria-label="' . __('Mailto', 'canva-frontend') . '" onclick="ga(\'send\', \'event\', \'Action-Link\', \'click\', \'' . get_field('email', 'options') . '\');">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/envelope', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('mailto-text' == $menu_item) {
		if (get_field('email', 'options')) {
			$html .= '<li class="menu-item menu-item-mailto cursor-pointer"><a class="mailto-text" href="mailto:' . get_field('email', 'options') . '" class="mailto-menu" aria-label="' . __('Mailto', 'canva-frontend') . '" onclick="ga(\'send\', \'event\', \'Action-Link\', \'click\', \'' . get_field('email', 'options') . '\');">' . get_field('email', 'options') . '</a></li>';
		}
	}

	//WPML Lang Selector
	if ('lang-items' === $menu_item && is_wpml_activated()) {

		$html .= canva_lang_selector();
	} elseif ('lang-items-submenu' === $menu_item && is_wpml_activated()) {

		$html .= canva_lang_selector_submenu();
	}

	//Woocommerce Links
	if ('bag-icon' == $menu_item) {
		$html .= '<li class="menu-item-icon menu-item-icon-cart cursor-pointer">';
		if (is_woocommerce_activated()) {
			if (WC()->cart->get_cart_contents_count() > 0) {
				$html .= '<a class="bag-icon" href="' . esc_url(wc_get_cart_url()) . '" aria-label="' . __('Cart', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-bag', $css_classes = 'fill-current') . '<span class="fa-numbers">' . WC()->cart->get_cart_contents_count() . '</span></a>';
			} else {
				$html .= '<a class="bag-icon cursor-not-allowed" aria-label="' . __('Cart is empty', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-bag', $css_classes = 'fill-current') . '<span class="fa-numbers">' . WC()->cart->get_cart_contents_count() . '</span></a>';
			}
		} else {
			if (function_exists('is_customer_logged_in')) {
				if (is_customer_logged_in()) {
					$html .= '<a class="bag-icon cursor-not-allowed" aria-label="' . __('Cart is empty', 'canva-frontend') . '" data-items="' . apply_filters('cart_data_items', 0) . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-bag', $css_classes = 'fill-current') . '</a>';
				}
			} else {
				$html .= '<a class="bag-icon cursor-not-allowed" aria-label="' . __('Cart is empty', 'canva-frontend') . '" data-items="' . apply_filters('cart_data_items', 0) . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-bag', $css_classes = 'fill-current') . '</a>';
			}
		}
		$html .= '</li>';
	}

	if ('cart-icon' == $menu_item) {
		$html .= '<li class="menu-item-icon menu-item-icon-cart cursor-pointer">';
		if (is_woocommerce_activated()) {
			if (WC()->cart->get_cart_contents_count() > 0) {
				$html .= '<a class="cart-icon" href="' . esc_url(wc_get_cart_url()) . '" aria-label="' . __('Cart', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-cart', $css_classes = 'fill-current') . '<span class="fa-numbers">' . WC()->cart->get_cart_contents_count() . '</span></a>';
			} else {
				$html .= '<a class="cart-icon cursor-not-allowed" aria-label="' . __('Cart is empty', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-cart', $css_classes = 'fill-current') . '<span class="fa-numbers">' . WC()->cart->get_cart_contents_count() . '</span></a>';
			}
		} else {
			if (function_exists('is_customer_logged_in')) {
				if (is_customer_logged_in()) {
					$html .= '<a class="cart-icon cursor-pointer" aria-label="' . __('Cart is empty', 'canva-frontend') . '" data-items="' . apply_filters('cart_data_items', 0) . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-cart', $css_classes = 'fill-current') . '</a>';
				}
			} else {
				$html .= '<a class="cart-icon cursor-pointer" aria-label="' . __('Cart is empty', 'canva-frontend') . '" data-items="' . apply_filters('cart_data_items', 0) . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/shopping-cart', $css_classes = 'fill-current') . '</a>';
			}
		}
		$html .= '</li>';
	}

	if ('login-icon' == $menu_item) {
		if (is_woocommerce_activated()) {
			$html .= '<li class="menu-item-icon menu-item-icon-login cursor-pointer"><a class="login-icon" href="' . get_permalink(wc_get_page_id('myaccount')) . '" aria-label="' . __('Login', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/user', $css_classes = 'fill-current') . '</a></li>';
		} else {
			$html .= '<li class="menu-item-icon menu-item-icon-login cursor-pointer"><a class="login-icon" aria-label="' . __('Login', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/user', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('login-text' == $menu_item) {
		if (is_woocommerce_activated()) {
			if (!is_user_logged_in()) {
				$html .= '<li class="menu-item-icon menu-item-icon-login cursor-pointer"><a class="login-text" href="' . get_permalink(wc_get_page_id('myaccount')) . '" aria-label="' . __('Login', 'canva-frontend') . '">' . __('Login', 'canva-frontend') . '</a></li>';
			} else {
				$html .= '<li class="menu-item-icon menu-item-icon-login cursor-pointer"><a class="login-text" href="' . get_permalink(wc_get_page_id('myaccount')) . '" aria-label="' . __('Login', 'canva-frontend') . '">' . __('Account', 'canva-frontend') . '</a></li>';
			}
		} else {
			$html .= '<li class="menu-item-icon menu-item-icon-login cursor-pointer"><a class="login-text" aria-label="' . __('Login', 'canva-frontend') . '">' . __('Account', 'canva-frontend') . '</a></li>';
		}
	}

	if ('whishlist-icon' == $menu_item) {
		$html .= '<li class="menu-item-icon menu-item-icon-whishlist cursor-pointer"><a class="whishlist-icon" aria-label="' . __('Whishlist', 'canva-frontend') . '">' . canva_get_svg_icon($name = 'fontawesome/' . $menu_fontawesome_icon_type . '/heart', $css_classes = 'fill-current') . '</a></li>';
	}

	//Social Links
	if ('facebook-icon' == $menu_item) {
		if (get_field('facebook', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-facebook cursor-pointer"><a class="facebook-icon" href="' . get_field('facebook', 'options') . '" target="_blank" aria-label="Facebook">' . canva_get_svg_icon($name = 'fontawesome/brands/facebook', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('twitter-icon' == $menu_item) {
		if (get_field('twitter', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-twitter cursor-pointer"><a class="twitter-icon" href="' . get_field('twitter', 'options') . '" target="_blank" aria-label="Twitter">' . canva_get_svg_icon($name = 'fontawesome/brands/twitter', $css_classes = 'fill-current') . '</span></a></li>';
		}
	}

	if ('instagram-icon' == $menu_item) {
		if (get_field('instagram', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-instagram cursor-pointer"><a class="instagram-icon" href="' . get_field('instagram', 'options') . '" target="_blank" aria-label="Instagram">' . canva_get_svg_icon($name = 'fontawesome/brands/instagram', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('youtube-icon' == $menu_item) {
		if (get_field('youtube', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-youtube cursor-pointer"><a class="youtube-icon" href="' . get_field('youtube', 'options') . '" target="_blank" aria-label="Youtube">' . canva_get_svg_icon($name = 'fontawesome/brands/youtube', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('vimeo-icon' == $menu_item) {
		if (get_field('vimeo', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-youtube cursor-pointer"><a class="vimeo-icon" href="' . get_field('vimeo', 'options') . '" target="_blank" aria-label="Vimeo">' . canva_get_svg_icon($name = 'fontawesome/brands/vimeo', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('linkedin-icon' == $menu_item) {
		if (get_field('linkedin', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-linkedin cursor-pointer"><a class="linkedin-icon" href="' . get_field('linkedin', 'options') . '" target="_blank" aria-label="Linkedin">' . canva_get_svg_icon($name = 'fontawesome/brands/linkedin', $css_classes = 'fill-current') . '</span></a></li>';
		}
	}

	if ('pinterest-icon' == $menu_item) {
		if (get_field('pinterest', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-pinterest cursor-pointer"><a class="pinterest-icon" href="' . get_field('pinterest', 'options') . '" target="_blank" aria-label="Pinterest">' . canva_get_svg_icon($name = 'fontawesome/brands/pinterest', $css_classes = 'fill-current') . '</a></li>';
		}
	}

	if ('spotify-icon' == $menu_item) {
		if (get_field('spotify', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-spotify cursor-pointer"><a class="spotify-icon" href="' . get_field('spotify', 'options') . '" target="_blank" aria-label="Spotify">' . canva_get_svg_icon($name = 'fontawesome/brands/spotify', $css_classes = 'fill-current') . '</span></a></li>';
		}
	}

	if ('google-maps-icon' == $menu_item) {
		if (get_field('google_maps', 'options')) {
			$html .= '<li class="menu-item-icon menu-item-icon-google-maps cursor-pointer"><a class="google-maps-icon" href="' . get_field('google_maps', 'options') . '" target="_blank" rel="nofollow noopener" aria-label="Google Maps">' . canva_get_svg_icon($name = 'fontawesome/brands/map-marker-alt', $css_classes = 'fill-current') . '</span></a></li>';
		}
	}

	if ('separator' == $menu_item) {
		$html .= '<li class="menu-item-separator"><hr class="menu-item-separator" /></li>';
	}

	return $html;
}


/**
 * Navigation bar builder
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return html
 */
function canva_menu_builder()
{
	$menu_desktop = get_field('menu_desktop', 'options');
	$menu_mobile = get_field('menu_mobile', 'options');
	$menu_aux = get_field('menu_aux', 'options');
	$off_canvas_desktop = get_field('off_canvas_desktop', 'options');
	$off_canvas_mobile = get_field('off_canvas_mobile', 'options');

	// Full Width Control

	$menu_desktop_full_width = '';
	if (!$menu_desktop['full_width']) {
		$menu_desktop_full_width = 'container';
	}

	$menu_aux_full_width = '';
	if (!$menu_aux['full_width']) {
		$menu_aux_full_width = 'container';
	}

	// Fixed Control
	$menu_desktop_fixed = '';
	if ($menu_desktop['fixed']) {
		$menu_desktop_fixed = 'fixed';
	} ?>

	<?php if ($menu_desktop['active']) { ?>
		<nav class="desktop-navigation hide md:block" role="navigation">

			<?php if ($menu_aux['active']) { ?>
				<div class="menu-aux flex items-center <?php echo esc_attr($menu_aux_full_width . ' ' . $menu_aux['css_classes']); ?>">

					<?php if ($menu_aux['left_menu_items']) { ?>
						<div class="menu-left flex-1 <?php echo esc_attr($menu_aux['left_css_classes']); ?>">
							<ul class="menu flex justify-start items-center">
								<?php
								foreach ($menu_aux['left_menu_items'] as $menu_items) {
									foreach ($menu_items as $menu_item) {
										if ('menu-items' === $menu_item) {
											echo canva_menu(['location' => 'menu-aux-left', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
										}
										echo canva_get_extra_menu_items($menu_item);
									}
								}
								?>
							</ul>
						</div>
					<?php } ?>

					<?php if ($menu_aux['center_menu_items']) { ?>
						<div class="menu-center flex-1">
							<ul class="menu flex justify-center items-center <?php echo esc_attr($menu_aux['center_css_classes']); ?>">
								<?php
								foreach ($menu_aux['center_menu_items'] as $menu_items) {
									foreach ($menu_items as $menu_item) {
										if ('menu-items' === $menu_item) {
											echo canva_menu(['location' => 'menu-aux-center', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
										}
										echo canva_get_extra_menu_items($menu_item);
									}
								}
								?>
							</ul>
						</div>
					<?php } ?>

					<?php if ($menu_aux['right_menu_items']) { ?>
						<div class="menu-right flex-1">
							<ul class="menu flex justify-end items-center <?php echo esc_attr($menu_aux['right_css_classes']); ?>">
								<?php
								foreach ($menu_aux['right_menu_items'] as $menu_items) {
									foreach ($menu_items as $menu_item) {
										if ('menu-items' === $menu_item) {
											echo canva_menu(['location' => 'menu-aux-right', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
										}
										echo canva_get_extra_menu_items($menu_item);
									}
								}
								?>
							</ul>
						</div>
					<?php } ?>

				</div>
			<?php } ?>

			<?php if ($menu_desktop['active']) { ?>
				<div class="menu-desktop flex items-center <?php echo esc_attr($menu_desktop_full_width . ' ' . $menu_desktop['css_classes']); ?>">

					<?php if ($menu_desktop['left_menu_items']) { ?>
						<div class="menu-left flex-1 <?php echo esc_attr($menu_desktop['left_css_classes']); ?>">
							<ul class="menu flex justify-start items-center">
								<?php
								foreach ($menu_desktop['left_menu_items'] as $menu_items) {
									foreach ($menu_items as $menu_item) {
										if ('menu-items' === $menu_item) {
											echo canva_menu(['location' => 'menu-desktop-left', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
										}
										echo canva_get_extra_menu_items($menu_item);
									}
								}
								?>
							</ul>
						</div>
					<?php } ?>

					<?php if ($menu_desktop['center_menu_items']) { ?>
						<div class="menu-center flex-1 <?php echo esc_attr($menu_desktop['center_css_classes']); ?>">
							<ul class="menu flex justify-center items-center">
								<?php
								foreach ($menu_desktop['center_menu_items'] as $menu_items) {
									foreach ($menu_items as $menu_item) {
										if ('menu-items' === $menu_item) {
											echo canva_menu(['location' => 'menu-desktop-center', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
										}
										echo canva_get_extra_menu_items($menu_item);
									}
								}
								?>
							</ul>
						</div>
					<?php } ?>

					<?php if ($menu_desktop['right_menu_items']) { ?>
						<div class="menu-right flex-1 <?php echo esc_attr($menu_desktop['right_css_classes']); ?>">
							<ul class="menu flex justify-end items-center">
								<?php
								foreach ($menu_desktop['right_menu_items'] as $menu_items) {
									foreach ($menu_items as $menu_item) {
										if ('menu-items' === $menu_item) {
											echo canva_menu(['location' => 'menu-desktop-right', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
										}
										echo canva_get_extra_menu_items($menu_item);
									}
								}
								?>
							</ul>
						</div>
					<?php } ?>

				</div>
			<?php } ?>

		</nav>
	<?php } ?>

	<?php if ($menu_mobile['active']) { ?>
		<nav class="mobile-navigation fixed w-full md:hide z-50" role="navigation">
			<div class="menu-mobile flex items-center <?php echo esc_attr($menu_mobile['css_classes']); ?>">
				<?php if ($menu_mobile['left_menu_items']) { ?>
					<div class="menu-left flex-1 <?php echo esc_attr($menu_mobile['left_css_classes']); ?>">
						<ul class="menu flex justify-start items-center">
							<?php
							foreach ($menu_mobile['left_menu_items'] as $menu_items) {
								foreach ($menu_items as $menu_item) {
									if ('menu-items' === $menu_item) {
										echo canva_menu(['location' => 'menu-mobile-left', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
									}
									echo canva_get_extra_menu_items($menu_item);
								}
							}
							?>
						</ul>
					</div>
				<?php } ?>

				<?php if ($menu_mobile['center_menu_items']) { ?>
					<div class="menu-center flex-1 <?php echo esc_attr($menu_mobile['center_css_classes']); ?>">
						<ul class="menu flex justify-center items-center">
							<?php
							foreach ($menu_mobile['center_menu_items'] as $menu_items) {
								foreach ($menu_items as $menu_item) {
									if ('menu-items' === $menu_item) {
										echo canva_menu(['location' => 'menu-mobile-center', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
									}
									echo canva_get_extra_menu_items($menu_item);
								}
							}
							?>
						</ul>
					</div>
				<?php } ?>

				<?php if ($menu_mobile['right_menu_items']) { ?>
					<div class="menu-right flex-1 <?php echo esc_attr($menu_mobile['center_css_classes']); ?>">
						<ul class="menu flex justify-end items-center">
							<?php
							foreach ($menu_mobile['right_menu_items'] as $menu_items) {
								foreach ($menu_items as $menu_item) {
									if ('menu-items' === $menu_item) {
										echo canva_menu(['location' => 'menu-mobile-right', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Horizontal_Walker()]);
									}
									echo canva_get_extra_menu_items($menu_item);
								}
							}
							?>
						</ul>
					</div>
				<?php } ?>

			</div>
		</nav>
	<?php } ?>

	<?php if ($off_canvas_desktop['active']) { ?>
		<nav class="off-canvas-desktop hide fixed inset-0 z-50 fade-in overflow-y-auto" role="navigation">
			<div class="menu-off-canvas-desktop">
				<a class="off-canvas-close cursor-pointer absolute top-0 right-0 h-16 w-16">
					<?php echo canva_get_svg_icon($name = 'fontawesome/regular/times', $class = 'w-16 h-16 fill-current'); ?>
				</a>
				<div class="menu-center">
					<ul class="menu flex flex-col items-center">
						<?php
						foreach ($off_canvas_desktop['menu_items'] as $menu_items) {
							foreach ($menu_items as $menu_item) {
								if ('menu-items' === $menu_item) {
									echo canva_menu(['location' => 'off-canvas-desktop', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Vertical_Walker()]);
								}
								echo canva_get_extra_menu_items($menu_item);
							}
						}
						?>
					</ul>
				</div>
			</div>
		</nav>
	<?php } ?>

	<?php if ($off_canvas_mobile['active']) { ?>
		<nav class="off-canvas-mobile hide fixed inset-0 z-50 fade-in overflow-y-auto" role="navigation">
			<div class="menu-off-canvas-mobile">
				<div class="menu-center">
					<ul class="menu flex flex-col items-center">
						<?php
						foreach ($off_canvas_mobile['menu_items'] as $menu_items) {
							foreach ($menu_items as $menu_item) {
								if ('menu-items' === $menu_item) {
									echo canva_menu(['location' => 'off-canvas-mobile', 'depth' => 2, 'css_classes' => 'flex-1', 'items_wrap' => '%3$s', 'walker' => new Canva_Vertical_Walker()]);
								}
								echo canva_get_extra_menu_items($menu_item);
							}
						}
						?>
					</ul>
				</div>
			</div>
		</nav>
	<?php } ?>
<?php }


/**
 * Useful to get a json file for wp standard menu
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
// function canva_menu_items_json_export()
// {
// 	$location = '';
// 	if ($_GET['location']) {
// 		$location = esc_attr($_GET['location']);
// 	}

// 	$menu_id = '';
// 	if ($_GET['menu_id']) {
// 		$menu_id = intval($_GET['menu_id']);
// 	}

// 	if (is_wpml_activated()) {
// 		$lang = '';
// 		if ($_GET['lang']) {
// 			$lang = esc_attr($_GET['lang']);
// 		}

// 		global $sitepress;
// 		$sitepress->switch_lang($lang, true);
// 		// For Debuging
// 		// echo ICL_LANGUAGE_CODE;
// 	}

// 	$locations = get_nav_menu_locations();

// 	if ($location) {
// 		$menu_items = wp_get_nav_menu_items(wp_get_nav_menu_object($locations[$location]));
// 	} elseif ($menu_id) {
// 		$menu_items = wp_get_nav_menu_items($menu_id);
// 	}

// 	// For Debuging
// 	// echo $location;
// 	// header('Content-Type: text/plain');
// 	// var_dump($locations);

// 	// For Debuging
// 	// header('Content-Type: application/json');
// 	// echo json_encode($menu_items);

// 	// For Debuging
// 	// header('Content-Type: text/plain');
// 	// var_dump($test);

// 	$items = [];

// 	foreach ($menu_items as $menu_item) {

// 		// unset($menu_item->ID);
// 		unset($menu_item->post_author);
// 		unset($menu_item->post_date);
// 		unset($menu_item->post_date_gmt);
// 		unset($menu_item->post_content);
// 		unset($menu_item->post_title);
// 		unset($menu_item->post_excerpt);
// 		unset($menu_item->post_status);
// 		unset($menu_item->comment_status);
// 		unset($menu_item->ping_status);
// 		unset($menu_item->post_password);
// 		unset($menu_item->post_name);
// 		unset($menu_item->to_ping);
// 		unset($menu_item->pinged);
// 		unset($menu_item->post_modified);
// 		unset($menu_item->post_modified_gmt);
// 		unset($menu_item->post_content_filtered);
// 		unset($menu_item->post_parent);
// 		unset($menu_item->guid);
// 		unset($menu_item->menu_order);
// 		unset($menu_item->post_type);
// 		unset($menu_item->post_mime_type);
// 		unset($menu_item->comment_count);
// 		unset($menu_item->filter);
// 		unset($menu_item->db_id);
// 		// unset($menu_item->menu_item_parent);
// 		unset($menu_item->object_id);
// 		unset($menu_item->object);
// 		unset($menu_item->type);
// 		unset($menu_item->type_label);
// 		unset($menu_item->target);
// 		unset($menu_item->attr_title);
// 		unset($menu_item->description);
// 		unset($menu_item->classes);
// 		unset($menu_item->xfn);

// 		// For Debuging
// 		// header('Content-Type: text/plain');
// 		// var_dump($menu_item);

// 		$menu_icon = '';

// 		if (get_field('menu_icon', $menu_item->ID)) {
// 			$menu_icon = get_field('menu_icon', $menu_item->ID);
// 		}

// 		$items[] = ['menu_name' => $location, 'id' => $menu_item->ID, 'parent_id' => $menu_item->menu_item_parent, 'url' => $menu_item->url, 'title' => $menu_item->title, 'menu_icon' => $menu_icon];
// 	}

// 	// For Debuging
// 	// header('Content-Type: text/plain');
// 	// var_dump($items);

// 	header('Content-Type: application/json');
// 	echo json_encode($items);

// 	wp_die();
// }
// add_action('wp_ajax_menu_items_json', 'canva_menu_items_json_export', 10, 10);
// add_action('wp_ajax_nopriv_menu_items_json', 'canva_menu_items_json_export', 10, 1);
