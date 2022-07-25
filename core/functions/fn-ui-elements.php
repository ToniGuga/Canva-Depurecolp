<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}


/**
 * print html snippet for search modal
 *
 * @used in menu
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_search_modal_html()
{
	echo canva_get_template('fn-modal-search-html');
}
//action declares in fn-hooks.php


/**
 * print html snippet for contact modal
 *
 * @used in menu
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_contact_modal_html()
{
	echo canva_get_template('fn-modal-contact-html');
}
//action declares in fn-hooks.php


/**
 * print html snippet for contact modal
 *
 * @used in menu
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_modal_container_html()
{
	echo canva_get_template('fn-modal-container-html');
}
//action declares in fn-hooks.php


/**
 * print html snippet for photoswipe galleries

 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_photoswipe_html()
{
	echo canva_get_template('fn-photoswipe-html');
}
//hooked in fn-hooks.php

/**
 * Scroll tu top html button

 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_scroll_to_top_html()
{
	echo canva_get_template('fn-scroll-to-top-html');
}
//hooked in fn-hooks.php


/**
 * canva_modal_post_opener().
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $data
 * @return html
 */
function canva_modal_post_opener()
{
	// Check for nonce security
	// if (!wp_verify_nonce($_GET['nonce'], 'nonce') || !wp_verify_nonce($_POST['nonce'], 'nonce')) {
	//     wp_die('Not permitted!');
	// }

	if (isset($_GET['id'])) {
		$post_id = esc_attr($_GET['id']);
	} else {
		exit;
	}

	if (isset($_GET['template'])) {
		$template = esc_attr($_GET['template']);
	} else {
		$template = 'post-opener-single-product';
	}

	echo canva_get_template($template, ['post_id' => $post_id]);

	wp_die();
}
add_action('wp_ajax_modal_post_opener', 'canva_modal_post_opener');
add_action('wp_ajax_nopriv_modal_post_opener', 'canva_modal_post_opener');



/**
 * a place to print theme notices
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_notices_html()
{
	echo canva_get_template('fn-canva-notices-html');
}
//hooked in fn-hooks.php



/**
 * used for the off canvas mobile menu
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_off_canvas_layers_html()
{
	echo canva_get_template('fn-off-canvas-layers-html');
}
//hooked in fn-hooks.php



/**
 * used whith ajax post operner function
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_modal_post_opener_html()
{
	echo canva_get_template('fn-modal-post-opener-html');
}
//hooked in fn-hooks.php




/**
 * Stampa la privacy bar per i siti in multilingua
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return strign
 */
function canva_privacy_infobar()
{
	$privacy_page_url = get_field('privacy_page', 'option');
	$privacy_message = do_shortcode(get_field('privacy_bar_message', 'option', false, false));

	if ($privacy_page_url) {
?>
		<script>
			var x = readCookie('canva_cookie_policy_consent');

			if (x) {

				//do nothing

			} else {

				(function($) {

					$(window).on('load', function() {
						$('#canva-footer-messages').append(`<div id="cookie-message" class="pb-8 fade-in"><a href="#" class="close-cookie-modal block absolute pin-t pin-r fs-h3 mr-2">&times;</a><span class="block pl-4 pr-4"><?php echo $privacy_message; ?></span></div>`);

						$(".close-cookie-modal").on('click', function() {
							$("#cookie-message").removeClass("fade-in").fadeOut('slow');
							createCookie("canva_cookie_policy_consent", "true", 60);
							return false;
						});
					});

				})(jQuery);

			};
		</script>

<?php
	}
}
//action declares in fn-hooks.php



/**
 * used to manage next and prev posts for post types
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 *
 * @param string $post_id
 * @param string $taxonomy
 * @param string $order
 * @param boolean $show_title
 * @param string $prev_class
 * @param string $next_class
 * @param string $prev_icon_name
 * @param string $prev_icon_type
 * @param string $prev_icon_class
 * @param string $next_icon_name
 * @param string $next_icon_type
 * @param string $next_icon_class
 * @return void
 */
function canva_get_next_prev_post($post_id = '', $taxonomy = '', $order = 'menu_order', $show_title = true, $prev_class = '', $next_class = '', $prev_icon_name = '', $prev_icon_type = '', $prev_icon_class = '', $next_icon_name = '', $next_icon_type = '', $next_icon_class = '')
{
	if (!$post_id) {
		$post_id = get_the_ID();
	}

	$post_type = get_post_type($post_id);

	$terms = get_the_terms($post_id, $taxonomy);

	$terms_links = [];

	foreach ($terms as $term) {
		$terms_links[] = $term->slug;
	}

	if (!$taxonomy) {
		$args = [
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'order' => 'ASC',
			'orderby' => $order,
		];
	} else {
		$args = [
			'post_type' => $post_type,
			'posts_per_page' => -1,
			'order' => 'ASC',
			'orderby' => $order,
			'tax_query' => [
				[
					'taxonomy' => $taxonomy,
					'field' => 'slug',
					'terms' => $terms_links,
				],
			],
		];
	}

	query_posts($args);

	$posts = [];

	while (have_posts()) {
		the_post();
		array_push($posts, get_the_ID());
	}

	wp_reset_query();

	// Identify the position of the current product within the $posts-array
	$current = array_search($post_id, $posts);

	// Identify ID of previous product
	$prevID = $posts[$current - 1];

	// Identify ID of next product
	$nextID = $posts[$current + 1];

	// Link "previous product"
	if (!empty($prevID)) {

		canva_get_template('fn-prev', $args = ['prevID' => $prevID, 'prev_class' > $prev_class, 'show_title' => $show_title, 'prev_icon_name' => $prev_icon_name, 'prev_icon_type' => $prev_icon_type, 'prev_icon_class' => $prev_icon_class]);
	} //endif

	// Link "next product"
	if (!empty($nextID)) {

		canva_get_template('fn-next', $args = ['prevID' => $nextID, 'next_class' > $next_class, 'show_title' => $show_title, 'next_icon_name' => $next_icon_name, 'next_icon_type' => $next_icon_type, 'next_icon_class' => $next_icon_class]);
	} //endif

}


/**
 * Prints footer blocks in footer
 *
 * @return void
 */
function canva_footer_opt()
{

	$footer_posts = get_field('footer_posts', 'options');

	if ($footer_posts) {
		foreach ($footer_posts as $footer_post) {

			canva_render_blocks($footer_post);
		}
	}
} //end function
add_action('canva_footer_start', 'canva_footer_opt');


/**
 * Canva loading footer
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_loading_footer()
{

	echo canva_get_template('fn-canva-loading-footer-html');

}
//action declares in fn-hooks.php

/**
 * Canva loading footer
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
/**
 * stampa container per il carrello in modale
 *
 * @return void
 */
function canva_ajax_modal_cart_html()
{
	echo canva_get_template('fn-canva-ajax-modal-cart-html');
}
//action declares in fn-hooks.php


/**
 * Canva loading icon
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_get_loading($wrapper_class = 'text-center', $icon_name = 'loaders/loading', $icon_class = 'inline-block')
{

	$html = '';
	$html .= '<div class="_loading ' . esc_attr($wrapper_class) . '">';
	$html .= canva_get_svg_icon($icon_name, $icon_class);
	$html .= '</div>';

	return $html;
}

/**
 * The canva_get_loading shortcode function
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $atts
 * @return void
 */
function canva_get_loading_shortcode($atts)
{
	extract(shortcode_atts([
		'wrapper_class' => 'text-center',
		'icon_name' => 'fontawesome/regular/loading',
		'icon_class' => 'inline-block',
	], $atts));

	return canva_get_loading($wrapper_class, $icon_name, $icon_class);
}
add_shortcode('loading', 'canva_get_loading_shortcode');
