<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly


/**
 * Extending woocommerce admin product search
 *
 * @param [type] $query
 * @return void
 * @example https://gist.github.com/leobaiano/f835b9d9ff387ac2995f
 */

function abac_admin_post_search_by_custom_fields($query)
{
	if (!is_admin()) {
		return;
	}

	// Search just for posts
	if (isset($query->query_vars['post_type']) && 'post' !== $query->query_vars['post_type']) {
		return;
	}

	if (!empty($query->query_vars['s'])) {
		$term = $query->query_vars['s'];

		// $custom_fields = array('cp_product_id'); // Set here your custom fields for search
		// $meta_query    = array('relation' => 'OR');

		// foreach ($custom_fields as $field) {
		// 	array_push($meta_query, array(
		// 		'key'     => $field,
		// 		'value'   => $term,
		// 		'compare' => 'LIKE'
		// 	));
		// }
		// $query->set('meta_query', $meta_query);

		$tax_query = array('relation' => 'OR');
		array_push($tax_query, array(
			'taxonomy' => 'product_tag',
			'field'    => 'slug',
			'terms'    => $term,
		));

		$query->set('tax_query', $tax_query);

		dump_to_error_log($tax_query);

		// Exclude regular search
		unset($query->query_vars['s']);
	}
}
// add_filter('pre_get_posts', 'abac_admin_post_search_by_custom_fields');


function abac_wooc_new_price_fields()
{
	global $woocommerce, $post;

	woocommerce_wp_text_input(array(
		'id' => '_abac_suggested_new_price',
		'label' => __('Suggested new price', 'woocommerce'),
		'type' => 'text',
		'placeholder' => '1000,55',
		'value' => get_post_meta($post->ID, '_abac_suggested_new_price', true),
	));
}
add_action('woocommerce_product_options_pricing', 'abac_wooc_new_price_fields');


function abac_wooc_new_price_fields_save($post_id)
{
	$_abac_suggested_new_price = isset($_POST['_abac_suggested_new_price']) ? $_POST['_abac_suggested_new_price'] : '';
	update_post_meta($post_id, '_abac_suggested_new_price', esc_attr($_abac_suggested_new_price));
}
add_action('woocommerce_process_product_meta', 'abac_wooc_new_price_fields_save');


/**
 * add extra columns to post type evento
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $columns
 * @return void
 */
function wooc_products_extra_columns($columns)
{

	$columns['suggested_new_price'] = __('New Price', 'canva-abac');

	return $columns;
}
add_filter('manage_edit-product_columns', 'wooc_products_extra_columns', 10);


/**
 * populate evento extra columns with data
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $column
 * @return void
 */
function wooc_products_extra_columns_content($column)
{
	global $post;

	//esempio con campi ACF
	if ('suggested_new_price' === $column) {
		echo get_post_meta($post->ID, '_abac_suggested_new_price', true);
	}
}
add_action('manage_product_posts_custom_column', 'wooc_products_extra_columns_content');


/**
 * make this extra columns sortable
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $columns
 * @return void
 */
function wooc_products_extra_columns_content_sortable($columns)
{
	$columns['suggested_new_price'] = 'suggested_new_price';

	//To make a column 'un-sortable' remove it from the array
	//unset($columns['date']);

	return $columns;
}
add_filter('manage_edit-product_sortable_columns', 'wooc_products_extra_columns_content_sortable');


/**
 * adjust orderby query
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $query
 * @return void
 */
function wooc_admin_columns_orderby($query)
{
	// limitia utilizzo solo per il beckend
	if (!is_admin()) {
		return;
	}

	$orderby = $query->get('orderby');

	if ('suggested_new_price' == $orderby) {

		$query->set('meta_key', '_abac_suggested_new_price');
		$query->set('orderby', 'meta_value');

		// usa meta_value_num in caso di numeri

	}
}
add_action('pre_get_posts', 'wooc_admin_columns_orderby');



/**
 * Carrello
 * Modifica taglio e classi immagine prodotto
 *
 * @param [type] $product_get_image
 * @param [type] $cart_item
 * @param [type] $cart_item_key
 * @return void
 */

function filter_woocommerce_cart_item_thumbnail($product_get_image, $cart_item, $cart_item_key)
{
	$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
	return $_product->get_image('160-free', array('class' => 'w-24'));
};
add_filter('woocommerce_cart_item_thumbnail', 'filter_woocommerce_cart_item_thumbnail', 10, 3);



/**
 * Modifica il numero di prodotti per pagina
 *
 * @param [type] $q
 * @return void
 */
function woocommerce_product_query($q)
{
	if ($q->is_main_query() && ($q->get('wc_query') === 'product_query')) {
		$q->set('posts_per_page', 12);

		if (is_facetwp_activated()) {
			$q->set('facetwp', 1);
		}
	}
}
add_action('woocommerce_product_query', 'woocommerce_product_query');


/**
 * Crea la modale del carrello
 *
 * @return void
 */
function eqipe_wooc_modal_cart()
{
	$cart = WC()->cart;

	if (!$cart->is_empty()) {

?>
		<div class="_cart-modal-top fixed w-full p-4 bg-white shadow">
			<div class="_cart-modal-title flex items-center gap-4">
				<div class="_cart-icon hidden">
					<?php echo canva_get_svg_icon('fontawesome/regular/shopping-cart', 'fill-current w-6'); ?>
				</div>
				<div class="_cart-text">
					<span class="block h3 mb-1">
						<?php _e('Cart', 'woocommerce'); ?>
					</span>
					<span class="_cart-sub-totals block fs-sm fw-300">
						<?php echo  $cart->get_cart_contents_count(); ?> pezzi - Sub Totale <?php echo $cart->get_total() ?>
					</span>
				</div>
			</div>

		</div>

		<div class="pt-24">
			<?php

			foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
				$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
				$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
				$product = $cart_item['data'];
				$delete_item = apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'woocommerce_cart_item_remove_link',
					sprintf(
						'<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">' . __('Delete', 'woocommerce') . '</a>',
						esc_url(wc_get_cart_remove_url($cart_item_key)),
						esc_attr__('Delete', 'woocommerce'),
						esc_attr($product_id),
						esc_attr($cart_item_key),
						esc_attr($_product->get_sku())
					),
					$cart_item_key
				);

			?>
				<div class="_cart-item flex gap-4 p-4 py-8 border-b border-gray-200">

					<div class="_product-img">
						<a href="<?php echo $product->get_permalink($cart_item); ?>">
							<?php
							// $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('160-free',array('class' => 'w-24')), $cart_item, $cart_item_key);
							if (!$product_permalink) {
								// echo $thumbnail; // PHPCS: XSS ok.
								echo $_product->get_image('160-free', array('class' => 'w-24'));
							} else {
								echo canva_get_img([
									'img_id'   =>  $cart_item['product_id'],
									'img_type' => 'img', // img, bg, url
									'thumb_size' =>  '320-11',
									'img_class' =>  '',
									'wrapper_class' =>  '',
									'blazy' => 'off',
								]);
							}
							?>
						</a>
					</div>

					<div class="_product-data flex-1 pr-8">
						<a href="<?php echo $product->get_permalink($cart_item); ?>">
							<span class="_title block fs-xs uppercase fw-400 mb-4"><?php echo get_the_title($product_id); ?></span>
						</a>
						<!-- <span class="_price block fw-700"><?php echo $cart->get_product_price($product); ?></span> -->
						<span class="_price block fw-700 mb-4"><?php echo $cart->get_product_subtotal($product, $cart_item['quantity']); ?></span>
						<!-- <span class="_color block uppercase fs-xxs text-gray-400 lh-10 mb-2"><?php _e('Colore', 'canva-eqipe'); ?>: <span class="fw-700 text-black ml-2"><?php echo $product->get_attribute('combinazioni_colore'); ?></span></span> -->
						<!-- <span class="_size block uppercase fs-xxs text-gray-400 lh-10 mb-2"><?php _e('Taglia', 'canva-eqipe'); ?>: <span class="fw-700 text-black ml-2"><?php echo $product->get_attribute('taglia'); ?></span></span> -->
						<span class="_quantity flex items-center gap-8 fs-xxs lh-10">
							<span class="_quantity text-gray-400 inline-flex gap-2 items-center mr-8"><?php _e('Quantity', 'woocommerce'); ?>
								<span class="fw-700 text-black w-10 h-6 flex items-center justify-center rounded-full border border-black"><?php echo $cart_item['quantity']; ?></span>
							</span>
							<span class="_delete-item block"><?php echo $delete_item; ?></span>
						</span>
					</div>
					<div class="_product-item-delete self-end hide">
						<?php echo $delete_item; ?>
					</div>

				</div>


		<?php
			}
		} else {
			echo '<p class="pl-4">' . __('cart is empty', 'woocommerce') . '</p>';
		}
		?>
		</div>
		<?php

		wp_die();
	}
	add_action('wp_ajax_eqipe_wooc_modal_cart', 'eqipe_wooc_modal_cart');
	add_action('wp_ajax_nopriv_eqipe_wooc_modal_cart', 'eqipe_wooc_modal_cart');


	/**
	 * Output a list of variation attributes for use in the cart forms.
	 *
	 * @param array $args Arguments.
	 * @since 2.4.0
	 */
	function wc_dropdown_variation_attribute_options($args = array())
	{
		$args = wp_parse_args(
			apply_filters('woocommerce_dropdown_variation_attribute_options_args', $args),
			array(
				'options'          => false,
				'attribute'        => false,
				'product'          => false,
				'selected'         => false,
				'name'             => '',
				'id'               => '',
				'class'            => '',
				'show_option_none' => __('Choose an option', 'woocommerce'),
			)
		);

		// Get selected value.
		if (false === $args['selected'] && $args['attribute'] && $args['product'] instanceof WC_Product) {
			$selected_key = 'attribute_' . sanitize_title($args['attribute']);
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			$args['selected'] = isset($_REQUEST[$selected_key]) ? wc_clean(wp_unslash($_REQUEST[$selected_key])) : $args['product']->get_variation_default_attribute($args['attribute']);
			// phpcs:enable WordPress.Security.NonceVerification.Recommended
		}

		$options               = $args['options'];
		$product               = $args['product'];
		$attribute             = $args['attribute'];
		$name                  = $args['name'] ? $args['name'] : 'attribute_' . sanitize_title($attribute);
		$id                    = $args['id'] ? $args['id'] : sanitize_title($attribute);
		$class                 = $args['class'];
		$show_option_none      = (bool) $args['show_option_none'];
		$show_option_none_text = $args['show_option_none'] ? $args['show_option_none'] : __('Choose an option', 'woocommerce'); // We'll do our best to hide the placeholder, but we'll need to show something when resetting options.

		if (empty($options) && !empty($product) && !empty($attribute)) {
			$attributes = $product->get_variation_attributes();
			$options    = $attributes[$attribute];
		}

		$html  = '<select id="' . esc_attr($id) . '" class="' . esc_attr($class) . '" name="' . esc_attr($name) . '" data-attribute_name="attribute_' . esc_attr(sanitize_title($attribute)) . '" data-show_option_none="' . ($show_option_none ? 'yes' : 'no') . '">';
		$html .= '<option value="">' . esc_html($show_option_none_text) . '</option>';

		if (!empty($options)) {
			if ($product && taxonomy_exists($attribute)) {
				// Get terms if this is a taxonomy - ordered. We need the names too.
				$terms = wc_get_product_terms(
					$product->get_id(),
					$attribute,
					array(
						'fields' => 'all',
					)
				);

				foreach ($terms as $term) {
					if (in_array($term->slug, $options, true)) {
						if ($attribute === 'pa_combinazioni') {
							$color = '<div class="_color-combination mr-4 mb-4 rounded-full overflow-hidden border-2 border-gray-300 transition-colors hover:border-black w-9">
							<div class="border-3 border-white h-8 w-8 rounded-full" style="background: linear-gradient(90deg, ' . get_field('term_color', $term) . ' 50%, ' . get_field('term_color_secondary', $term) . ' 50%);"></div>
						</div>';
						}
						$html .= '<option data-color-primary="' . get_field('term_color', $term) . '" data-color-secondary="' . get_field('term_color_secondary', $term) . '" value="' . esc_attr($term->slug) . '" ' . selected(sanitize_title($args['selected']), $term->slug, false) . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $term->name, $term, $attribute, $product)) . ' ' . $color . '</option>';
					}
				}
			} else {
				foreach ($options as $option) {
					// This handles < 2.4.0 bw compatibility where text attributes were not sanitized.
					$selected = sanitize_title($args['selected']) === $args['selected'] ? selected($args['selected'], sanitize_title($option), false) : selected($args['selected'], $option, false);
					$html    .= '<option value="' . esc_attr($option) . '" ' . $selected . '>' . esc_html(apply_filters('woocommerce_variation_option_name', $option, null, $attribute, $product)) . '</option>';
				}
			}
		}

		$html .= '</select>';

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo apply_filters('woocommerce_dropdown_variation_attribute_options_html', $html, $args);
	}


	/**
	 * Funzione usata per ajax per stampare la gallery per versioni desktop
	 *
	 * @author Toni Guga <toni@schiavoneguga.com>
	 * @return void
	 */
	function abac_simple_product_gallery()
	{
		if (isset($_GET['post_id']) && ('' != trim($_GET['post_id']))) {
			$post_id = esc_attr($_GET['post_id']);
		} elseif (isset($_POST['post_id']) && '' != trim($_POST['post_id'])) {
			$post_id = esc_attr($_POST['post_id']);
		} elseif (isset($_REQUEST['post_id']) && '' != trim($_REQUEST['post_id'])) {
			$post_id = esc_attr($_REQUEST['post_id']);
		}

		$gallery = explode(',', get_post_meta($post_id, '_product_image_gallery', true));
		if ($gallery) :
		?>

			<div class="_gallery-variation grid grid-cols-1 lg:grid-cols-2 gap-1">

				<?php
				$i = 1;
				foreach ($gallery as $img) {
					echo canva_get_img([
						'img_id' => $img,
						'img_type' => 'img', // img, bg, url
						'thumb_size' => '960-free',
						// 'img_class' => '',
						// 'wrapper_class' => 'photoswipe-item gallery-item gallery-item-' . $i++,
						'wrapper_class' => 'photoswipe-item relative ratio-1-1 group gallery-item gallery-item-' . $i++,
						'img_class' => 'absolute object-cover transform-gpu transition-all duration-slow group-hover:scale-105',
						'blazy' => 'off',
						'sercset' => 'on',
					]);
				}
				?>

			</div>

		<?php else : ?>

			<div class="_product-photo">
				<?php
				echo canva_get_img([
					'img_id'   =>  $post_id,
					'img_type' => 'img', // img, bg, url
					'thumb_size' =>  '960-free',
					'wrapper_class' => 'photoswipe-item relative ratio-4-5 group gallery-item gallery-item' . $post_id,
					'img_class' => 'absolute object-cover transform-gpu w-3/4',
					'blazy' => 'off',
				]);
				?>
			</div>

		<?php endif; ?>

		<?php
		wp_die();
	}
	add_action('wp_ajax_abac_simple_product_gallery', 'abac_simple_product_gallery');
	add_action('wp_ajax_nopriv_abac_simple_product_gallery', 'abac_simple_product_gallery');



	/**
	 * stampa i post scelti con il post object di ACF con impostazione formato di ritorno ID e genera uno slider con swiper.
	 *
	 * @author Toni Guga <toni@schiavoneguga.com>
	 * @param $attributes array
	 */
	function canva_simple_slider_by_ids($attributes = [])
	{
		extract(shortcode_atts([
			'post_ids' => array(),
			'template_name' => 'render-blocks',
			'swiper_hero_class' => '',
			'swiper_container_class' => '',
			'prev_next' => 'true',
			'pagination' => 'true',
		], $attributes));

		// wp_send_json(wp_json_encode($attributes));

		if ($post_ids) {

			$element_id = esc_attr(wp_generate_password(16, false, false));
		?>
			<!-- ///////// Slider Posts ///////// -->
			<div id="<?php echo $element_id; ?>" class="<?php echo esc_attr($swiper_hero_class); ?>">

				<div class="swiper-container <?php echo $element_id; ?> <?php echo esc_attr($swiper_container_class); ?>">

					<div class="swiper-wrapper">

						<?php
						$i = 1;
						foreach ($post_ids as $post_id) {
							$item = $i++;
							// echo '<div class="swiper-slide">';
							canva_get_template(sanitize_text_field($template_name), ['post_id' => $post_id, 'item' => $item]);
							// echo '</div>';
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
		<?php
		}
	}

	/**
	 * stampa i post scelti con il post object di ACF con impostazione formato di ritorno ID e genera uno slider con swiper.
	 *
	 * @author Toni Guga <toni@schiavoneguga.com>
	 * @param $attributes array
	 */
	function canva_simple_slider_thumbs_by_ids($attributes = [])
	{
		extract(shortcode_atts([
			'post_ids' => array(),
			'template_name' => 'render-blocks',
			'swiper_hero_class' => '',
			'swiper_container_class' => '',
			'prev_next' => 'true',
			'pagination' => 'true',
		], $attributes));

		// wp_send_json(wp_json_encode($attributes));

		if ($post_ids) {
		?>
			<!-- ///////// Slider Posts ///////// -->
			<div class="<?php echo esc_attr($swiper_hero_class); ?>">

				<div class="swiper-container <?php echo esc_attr($swiper_container_class); ?>">

					<div class="swiper-wrapper">
						<?php
						$i = 1;
						foreach ($post_ids as $post_id) {
							$item = $i++;
							echo '<div class="swiper-slide">';
							canva_get_template(sanitize_text_field($template_name), ['post_id' => $post_id]);
							echo '</div>';
						} ?>
					</div>

				</div>


			</div>
		<?php
		}
	}

	/**
	 * Funzione usata per ajax per stampare la gallery per versioni mobile
	 *
	 * @author Toni Guga <toni@schiavoneguga.com>
	 * @return void
	 */
	function simple_product_silder_gallery($post_id)
	{

		if (has_post_thumbnail($post_id)) {

			$thumbnail_id = get_post_thumbnail_id($thumbnail_id);
			$file = wp_basename(wp_get_attachment_image_src($thumbnail_id, '640-free')[0]);

			if (false !== strpos($file, 'box1') || false !== strpos($file, 'Box1') || false !== strpos($file, 'hshshsji') || false !== strpos($file, '3dd08')) {
				$thumbnail_id = 3967;
			} else {
				$thumbnail_id = get_post_thumbnail_id($post_id);
			}
		} else {

			$thumbnail_id = 3967;
		}

		if (get_post_meta($post_id, '_product_image_gallery', true)) {
			$gallery = explode(',', rtrim(get_post_meta($post_id, '_product_image_gallery', true), ','));
		}

		if (!empty($gallery)) :

			array_unshift($gallery, $thumbnail_id);

			canva_simple_slider_by_ids([
				'post_ids' => $gallery,
				'template_name' => 'swiper-product-gallery',
				'swiper_hero_class' => '_swiper-gallery',
				'swiper_container_class' => '',
				'prev_next' => 'true',
				'pagination' => 'true',
			]);

			if (count($gallery) > 1) {
				canva_simple_slider_thumbs_by_ids([
					'post_ids' => $gallery,
					'template_name' => 'swiper-product-gallery-thumb',
					'swiper_hero_class' => '_swiper-gallery-thumb',
					'swiper_container_class' => 'gallery-thumbs grid gap-4 grid-cols-' . count($gallery),
					'prev_next' => 'true',
					'pagination' => 'true',
				]);
			}
		?>

		<?php else : ?>

			<div class="_product-photo">
				<?php
				echo canva_get_img([
					'img_id'   =>  $thumbnail_id,
					'img_type' => 'img', // img, bg, url
					'thumb_size' =>  '960-free',
					'wrapper_class' => 'photoswipe-item relative ratio-1-1 group gallery-item gallery-item' . $post_id,
					'img_class' => 'absolute object-cover transform-gpu w-3/4',
					'blazy' => 'off',
				]);

				?>
			</div>

		<?php endif; ?>

	<?php
	}



	/**
	 * Stampa i data attribute per combinazione colore e taglia
	 *
	 * @author Toni Guga <toni@schiavoneguga.com>
	 * @param [type] $classes
	 * @return void
	 */
	function canva_body_data($classes)
	{

		$output = '';

		if (is_single()) {
			global $post;
			$output = 'data-post-id="' . $post->ID . '"';

			if (get_post_type($post) == 'product') {
				$product = wc_get_product($post->ID);

				if ($product->is_type('variable')) {
					$default_attributes = $product->get_default_attributes();

					foreach ($default_attributes as $key => $default_attribute) {
						$output .= 'data-' . $key . '="' . $default_attribute . '"';
					}
				}
			}
		}

		if (is_tax()) {
			$queried_object = get_queried_object();
			$taxonomy = $queried_object->taxonomy;
			// $term_id = $queried_object->term_id;
			$term_slug = $queried_object->slug;

			$output .= 'data-tax="' . $taxonomy . '" data-term="' . $term_slug . '"';
		}

		echo $output;
	}
	add_action('canva_body_data', 'canva_body_data');




	function abac_ajax_sub_term_header()
	{
		if (isset($_GET['term_slug']) && ('' != trim($_GET['term_slug']))) {
			$term_slug = esc_attr($_GET['term_slug']);
		} elseif (isset($_POST['term_slug']) && '' != trim($_POST['term_slug'])) {
			$term_slug = esc_attr($_POST['term_slug']);
		} elseif (isset($_REQUEST['term_slug']) && '' != trim($_REQUEST['term_slug'])) {
			$term_slug = esc_attr($_REQUEST['term_slug']);
		}

		if (isset($_GET['taxonomy']) && ('' != trim($_GET['taxonomy']))) {
			$taxonomy = esc_attr($_GET['taxonomy']);
		} elseif (isset($_POST['taxonomy']) && '' != trim($_POST['taxonomy'])) {
			$taxonomy = esc_attr($_POST['taxonomy']);
		} elseif (isset($_REQUEST['taxonomy']) && '' != trim($_REQUEST['taxonomy'])) {
			$taxonomy = esc_attr($_REQUEST['taxonomy']);
		}

		// if (isset($_GET['parent']) && ('' != trim($_GET['parent']))) {
		// 	$parent = esc_attr($_GET['parent']);
		// } elseif (isset($_POST['parent']) && '' != trim($_POST['parent'])) {
		// 	$parent = esc_attr($_POST['parent']);
		// } elseif (isset($_REQUEST['parent']) && '' != trim($_REQUEST['parent'])) {
		// 	$parent = esc_attr($_REQUEST['parent']);
		// }

		$term = get_term_by('slug', $term_slug, $taxonomy);

		// $ancestors = get_ancestors($term->term_id, $taxonomy);
		// $ancestors = array_reverse($ancestors);

		// $term_top_parent = get_term($ancestors[0], $taxonomy);
		// $term_top_parent_name = $term_top_parent->name;

		// $term_parent = get_term($ancestors[1], $taxonomy);
		// $term_parent_name = $term_parent->name;

		echo $term->name;

		wp_die();
	}
	add_action('wp_ajax_abac_ajax_sub_term_header', 'abac_ajax_sub_term_header');
	add_action('wp_ajax_nopriv_abac_ajax_sub_term_header', 'abac_ajax_sub_term_header');



	function abac_ajax_tools_mega_menu()
	{
		if (isset($_GET['term_slug']) && ('' != trim($_GET['term_slug']))) {
			$term_slug = esc_attr($_GET['term_slug']);
		} elseif (isset($_POST['term_slug']) && '' != trim($_POST['term_slug'])) {
			$term_slug = esc_attr($_POST['term_slug']);
		} elseif (isset($_REQUEST['term_slug']) && '' != trim($_REQUEST['term_slug'])) {
			$term_slug = esc_attr($_REQUEST['term_slug']);
		}

		if (isset($_GET['taxonomy']) && ('' != trim($_GET['taxonomy']))) {
			$taxonomy = esc_attr($_GET['taxonomy']);
		} elseif (isset($_POST['taxonomy']) && '' != trim($_POST['taxonomy'])) {
			$taxonomy = esc_attr($_POST['taxonomy']);
		} elseif (isset($_REQUEST['taxonomy']) && '' != trim($_REQUEST['taxonomy'])) {
			$taxonomy = esc_attr($_REQUEST['taxonomy']);
		}

		if (isset($_GET['parent']) && ('' != trim($_GET['parent']))) {
			$parent = esc_attr($_GET['parent']);
		} elseif (isset($_POST['parent']) && '' != trim($_POST['parent'])) {
			$parent = esc_attr($_POST['parent']);
		} elseif (isset($_REQUEST['parent']) && '' != trim($_REQUEST['parent'])) {
			$parent = esc_attr($_REQUEST['parent']);
		}

		$term = get_term_by('slug', $term_slug, $taxonomy);

		// echo $term->term_id;

		// $ancestors = get_ancestors($term->term_id, $taxonomy);
		// $ancestors = array_reverse($ancestors);

		// $term_top_parent = get_term($ancestors[0], $taxonomy);
		// $term_top_parent_name = $term_top_parent->name;

		// $term_parent = get_term($ancestors[1], $taxonomy);
		// $term_parent_name = $term_parent->name;

		$terms = get_terms(array('taxonomy' => $taxonomy, 'orderby' => 'menu_order', 'child_of' => $term->term_id, 'hide_empty' => true));
		// var_dump($terms);

		// $term_ids = get_term_children($term->term_id, $taxonomy);

	?>

		<?php foreach ($terms as $term) : ?>
			<?php if (is_there_any_post('post', $taxonomy, $term->term_id)) : ?>
				<li class="menu-item menu-item-<?php echo esc_attr($term->term_id); ?>">
					<?php $term = get_term_by('id', $term->term_id, $taxonomy); ?>
					<!-- <a href="<?php echo get_term_link($term, $taxonomy); ?>"> -->
					<a href="<?php echo get_term_link('tools', $taxonomy); ?>?_product_categories_mod_tools=<?php echo $term->slug; ?>">
						<div class="_tem-wrap group flex items-center gap-4">
							<div class="_term-img">
								<?php
								$term_img_id = get_term_meta($term->term_id, 'thumbnail_id', true);
								echo canva_get_img([
									'img_id'   => $term_img_id,
									'img_type' => 'img',
									'thumb_size' =>  '160-11',
									'img_class' =>  'w-12 mix-blend-multiply transition duration-fast transform-gpu group-hover:scale-110',
									'wrapper_class' =>  '',
									'blazy' => 'off'
								]);
								?>
							</div>
							<div class="_term-name flex-1">
								<span class="fs-xxs uppercase fw-700"><?php echo $term->name; ?></span>
							</div>
						</div>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>

	<?php
		wp_die();
	}
	add_action('wp_ajax_abac_ajax_tools_mega_menu', 'abac_ajax_tools_mega_menu');
	add_action('wp_ajax_nopriv_abac_ajax_tools_mega_menu', 'abac_ajax_tools_mega_menu');


	function abac_ajax_application_mega_menu()
	{
		if (isset($_GET['term_slug']) && ('' != trim($_GET['term_slug']))) {
			$term_slug = esc_attr($_GET['term_slug']);
		} elseif (isset($_POST['term_slug']) && '' != trim($_POST['term_slug'])) {
			$term_slug = esc_attr($_POST['term_slug']);
		} elseif (isset($_REQUEST['term_slug']) && '' != trim($_REQUEST['term_slug'])) {
			$term_slug = esc_attr($_REQUEST['term_slug']);
		}

		if (isset($_GET['taxonomy']) && ('' != trim($_GET['taxonomy']))) {
			$taxonomy = esc_attr($_GET['taxonomy']);
		} elseif (isset($_POST['taxonomy']) && '' != trim($_POST['taxonomy'])) {
			$taxonomy = esc_attr($_POST['taxonomy']);
		} elseif (isset($_REQUEST['taxonomy']) && '' != trim($_REQUEST['taxonomy'])) {
			$taxonomy = esc_attr($_REQUEST['taxonomy']);
		}

		if (isset($_GET['parent']) && ('' != trim($_GET['parent']))) {
			$parent = esc_attr($_GET['parent']);
		} elseif (isset($_POST['parent']) && '' != trim($_POST['parent'])) {
			$parent = esc_attr($_POST['parent']);
		} elseif (isset($_REQUEST['parent']) && '' != trim($_REQUEST['parent'])) {
			$parent = esc_attr($_REQUEST['parent']);
		}

		$term = get_term_by('slug', $term_slug, $taxonomy);

		// echo $term->term_id;

		// $ancestors = get_ancestors($term->term_id, $taxonomy);
		// $ancestors = array_reverse($ancestors);

		// $term_top_parent = get_term($ancestors[0], $taxonomy);
		// $term_top_parent_name = $term_top_parent->name;

		// $term_parent = get_term($ancestors[1], $taxonomy);
		// $term_parent_name = $term_parent->name;

		$terms = get_terms(array('taxonomy' => $taxonomy, 'orderby' => 'menu_order', 'child_of' => $term->term_id, 'hide_empty' => true));
		// var_dump($terms);

		// $term_ids = get_term_children($term->term_id, $taxonomy);

	?>

		<?php foreach ($terms as $term) : ?>
			<?php if (is_there_any_post('post', $taxonomy, $term->term_id)) : ?>
				<li class="menu-item menu-item-<?php echo esc_attr($term->term_id); ?>">
					<?php $term = get_term_by('id', $term->term_id, $taxonomy); ?>
					<!-- <a href="<?php echo get_term_link($term, $taxonomy); ?>"> -->
					<a href="<?php echo get_term_link('application', $taxonomy); ?>?_product_categories_mod_application=<?php echo $term->slug; ?>">
						<div class="_term-card group">
							<div class="_term-img">
								<?php
								$term_img_id = get_term_meta($term->term_id, 'thumbnail_id', true);
								echo canva_get_img([
									'img_id'   => $term_img_id,
									'img_type' => 'img',
									'thumb_size' =>  '640-43',
									'img_class' =>  'w-64 mix-blend-multiply mb-4 transition duration-fast transform-gpu group-hover:scale-105',
									'wrapper_class' =>  'overflow-hidden',
									'blazy' => 'off'
								]);
								?>
							</div>
							<div class="_term-name flex-1 text-left w-full">
								<span class="fs-xs capitalize text-black"><?php echo $term->name; ?></span>
							</div>
						</div>
					</a>
				</li>
			<?php endif; ?>
		<?php endforeach; ?>

	<?php
		wp_die();
	}
	add_action('wp_ajax_abac_ajax_application_mega_menu', 'abac_ajax_application_mega_menu');
	add_action('wp_ajax_nopriv_abac_ajax_application_mega_menu', 'abac_ajax_application_mega_menu');


	function abac_ajax_application_in_page_menu()
	{
		if (isset($_GET['term_slug']) && ('' != trim($_GET['term_slug']))) {
			$term_slug = esc_attr($_GET['term_slug']);
		} elseif (isset($_POST['term_slug']) && '' != trim($_POST['term_slug'])) {
			$term_slug = esc_attr($_POST['term_slug']);
		} elseif (isset($_REQUEST['term_slug']) && '' != trim($_REQUEST['term_slug'])) {
			$term_slug = esc_attr($_REQUEST['term_slug']);
		}

		if (isset($_GET['taxonomy']) && ('' != trim($_GET['taxonomy']))) {
			$taxonomy = esc_attr($_GET['taxonomy']);
		} elseif (isset($_POST['taxonomy']) && '' != trim($_POST['taxonomy'])) {
			$taxonomy = esc_attr($_POST['taxonomy']);
		} elseif (isset($_REQUEST['taxonomy']) && '' != trim($_REQUEST['taxonomy'])) {
			$taxonomy = esc_attr($_REQUEST['taxonomy']);
		}

		if (isset($_GET['parent']) && ('' != trim($_GET['parent']))) {
			$parent = esc_attr($_GET['parent']);
		} elseif (isset($_POST['parent']) && '' != trim($_POST['parent'])) {
			$parent = esc_attr($_POST['parent']);
		} elseif (isset($_REQUEST['parent']) && '' != trim($_REQUEST['parent'])) {
			$parent = esc_attr($_REQUEST['parent']);
		}

		$term = get_term_by('slug', $term_slug, $taxonomy);

		// echo $term->term_id;

		// $ancestors = get_ancestors($term->term_id, $taxonomy);
		// $ancestors = array_reverse($ancestors);

		// $term_top_parent = get_term($ancestors[0], $taxonomy);
		// $term_top_parent_name = $term_top_parent->name;

		// $term_parent = get_term($ancestors[1], $taxonomy);
		// $term_parent_name = $term_parent->name;

		$terms = get_terms(array('taxonomy' => $taxonomy, 'orderby' => 'menu_order', 'child_of' => $term->term_id, 'hide_empty' => true));
		// var_dump($terms);

		// $term_ids = get_term_children($term->term_id, $taxonomy);

	?>

		<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 p-6">
			<?php foreach ($terms as $term) : ?>
				<?php if (is_there_any_post('post', $taxonomy, $term->term_id)) : ?>
					<?php $term = get_term_by('id', $term->term_id, $taxonomy); ?>
					<a href="<?php echo get_term_link('application', $taxonomy); ?>?_product_categories_mod_application=<?php echo $term->slug; ?>">
						<div class="_term-card group">
							<div class="_term-img">
								<?php
								$term_img_id = get_term_meta($term->term_id, 'thumbnail_id', true);
								echo canva_get_img([
									'img_id'   => $term_img_id,
									'img_type' => 'img',
									'thumb_size' =>  '640-43',
									'img_class' =>  'w-64 mix-blend-multiply transition duration-fast transform-gpu group-hover:scale-105',
									'wrapper_class' =>  'overflow-hidden mb-4',
									'blazy' => 'off'
								]);
								?>
							</div>
							<div class="_term-name flex-1 text-left w-full">
								<span class="fs-h7 fw-700"><?php echo $term->name; ?></span>
							</div>
						</div>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

	<?php
		wp_die();
	}
	add_action('wp_ajax_abac_ajax_application_in_page_menu', 'abac_ajax_application_in_page_menu');
	add_action('wp_ajax_nopriv_abac_ajax_application_in_page_menu', 'abac_ajax_application_in_page_menu');


	function abac_ajax_application_product_range_in_page_menu()
	{
		if (isset($_GET['taxonomy']) && ('' != trim($_GET['taxonomy']))) {
			$taxonomy = esc_attr($_GET['taxonomy']);
		} elseif (isset($_POST['taxonomy']) && '' != trim($_POST['taxonomy'])) {
			$taxonomy = esc_attr($_POST['taxonomy']);
		} elseif (isset($_REQUEST['taxonomy']) && '' != trim($_REQUEST['taxonomy'])) {
			$taxonomy = esc_attr($_REQUEST['taxonomy']);
		}

		$terms = ['piston', 'screw', 'air-treatment', 'kit-spare-parts', 'tools', 'lubricants'];
	?>

		<div class="grid grid-cols-2 lg:grid-cols-3 gap-4 p-6">
			<?php
			foreach ($terms as $term) :
				$term = get_term_by('slug', $term, $taxonomy);
			?>
				<?php if (is_there_any_post('post', $taxonomy, $term->term_id)) : ?>
					<?php $term = get_term_by('id', $term->term_id, $taxonomy); ?>
					<a href="<?php echo get_term_link($term, $taxonomy); ?>?_product_categories_mod=<?php echo $term->slug; ?>">
						<div class="_term-card p-4 group">
							<div class="_term-img">
								<?php
								$term_img_id = get_term_meta($term->term_id, 'thumbnail_id', true);
								echo canva_get_img([
									'img_id'   => $term_img_id,
									'img_type' => 'img',
									'thumb_size' =>  '320-11',
									'img_class' =>  'w-32 p-2 mix-blend-multiply transition duration-fast transform-gpu group-hover:scale-110',
									'wrapper_class' =>  'overflow-hidden mb-2',
									'blazy' => 'off'
								]);
								?>
							</div>
							<div class="_term-name">
								<span class="fs-h7 fw-700">
									<?php
									if ($term->term_id == 17) {
										echo __('Piston Air Compressor', 'canva-abac');
									} elseif ($term->term_id == 32) {
										echo __('Screw Air Compressor', 'canva-abac');
									}else{
										echo $term->name;
									}
									?>
								</span>
							</div>
						</div>
					</a>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>

	<?php
		wp_die();
	}
	add_action('wp_ajax_abac_ajax_application_product_range_in_page_menu', 'abac_ajax_application_product_range_in_page_menu');
	add_action('wp_ajax_nopriv_abac_ajax_application_product_range_in_page_menu', 'abac_ajax_application_product_range_in_page_menu');
