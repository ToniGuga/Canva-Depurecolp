<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/* * *********************************************************************** */
/* Remove Action For Hooks TUTTI ******************************************* */
/* * *********************************************************************** */

//Risolve BUG Prezzi Prodotto Variabile
//mostra i prezzi dei prodotti variabili quando esiste anche solo una variazione
//https://github.com/woocommerce/woocommerce/issues/11827
add_filter('woocommerce_show_variation_price', '__return_true');

//Disattiva i 3 css di default di woocommerce
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

//Mostra 40 prodotti per pagina product per page
add_filter('loop_shop_per_page', 'new_loop_shop_per_page', 40);

// Gallery Support
//add_theme_support( 'wc-product-gallery-zoom' );
//add_theme_support( 'wc-product-gallery-lightbox' );
//add_theme_support( 'wc-product-gallery-slider' );

//Disattiva galleria e lightbox
remove_theme_support('wc-product-gallery-zoom');
remove_theme_support('wc-product-gallery-lightbox');
remove_theme_support('wc-product-gallery-slider');

//Disattiva breadcrumb
// remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);

// Add WooCommerce support for wrappers per
// http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
// remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
// remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);


// ARCHIVI: Rimuove "ordina prodotti per" dalle liste prodotti
// remove_action('woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30);
// ARCHIVI: Rimuove il titolo dalle liste prodotti
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
// ARCHIVI: Rimuove il rating dalle liste prodotti
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
// ARCHIVI: Rimuove il prezzo dalle liste prodotti
// remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);


// SINGOLA: Rimuove il sconti
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
// SINGOLA: Rimuove immagine del prodotto
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

// SINGOLA: Rimuove il Titolo dalla scheda singola
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
// SINGOLA: Rimuove il Rating dalla scheda singola
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
// SINGOLA: Rimuove il Prezzo dalla scheda singola
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
// SINGOLA: Rimuove il Riassunto dalla scheda singola
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
// SINGOLA: Rimuove il Aggiungi al Carrello dalla scheda singola
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
// SINGOLA: Rimuove il Meta Info dalla scheda singola
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
// SINGOLA: Rimuove il Social Sharing dalla scheda singola
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50);


// SINGOLA: Rimuove i TAB informativi standard WOOC dalla scheda singola
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
// SINGOLA: Rimuove i UPSELL dalla scheda singola
//remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
// SINGOLA: Rimuove i RELATED PRODUCTS dalla scheda singola
// remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);



//remove cross sell from cart
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
//serve per sganciare il metpdo di pagamento modificat hardcoded sul template
// remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );

//remove coupon
// remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
// add_action('woocommerce_review_order_before_payment', 'woocommerce_checkout_coupon_form');

//remove accordion for term & conditions
//https://gist.github.com/rynaldos/4993f8515580601856d51fccf974f8de
// remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_checkout_privacy_policy_text', 20 );
// remove_action( 'woocommerce_checkout_terms_and_conditions', 'wc_terms_and_conditions_page_content', 30 );


// Add WooCommerce support for wrappers per http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
// !!! Verify if this feature is still in use
// remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
// add_action('woocommerce_before_main_content', 'canva_before_content', 10);
// remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
// add_action('woocommerce_after_main_content', 'canva_after_content', 10);



function filter_woocommerce_get_item_data($item_data, $cart_item)
{
	return $item_data;
}
add_filter('woocommerce_get_item_data', 'filter_woocommerce_get_item_data', 10, 2);


/**
 * Aggiorna la quantità nel menu via AJAX.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $fragments
 */

if (!function_exists('canva_wooc_ajax_update_menu_cart_fragment')) {

	function canva_wooc_ajax_update_menu_cart_fragment($fragments)
	{
		global $woocommerce;

		ob_start();

		echo '<span class="_cart-items" > '. WC()->cart->get_cart_contents_count() . '</span>';

		$fragments['.menu-item-icon-cart ._cart-items'] = ob_get_clean();

		return $fragments;
	}
}
add_filter('woocommerce_add_to_cart_fragments', 'canva_wooc_ajax_update_menu_cart_fragment');


/**
 * fix per i coupon con restrizione per email
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $result
 * @param [type] $coupon
 * @return void
 */
function wc_check_coupon_is_valid($result, $coupon)
{
	$user = wp_get_current_user();
	$restricted_emails = $coupon->get_email_restrictions();

	if (count($restricted_emails) > 0) {
		if (in_array($user->user_email, $restricted_emails)) {
			return $result;
		} else {
			return false;
		}
	} else {
		return $result;
	}
}
add_filter('woocommerce_coupon_is_valid', 'wc_check_coupon_is_valid', 10, 2);


/**
 * funzione anonima per gestire l'ordinamento nell'archivio prodotti
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $options
 * @return void
 */

add_filter('woocommerce_catalog_orderby', function ($options) {

	unset($options['popularity']);
	//unset( $options[ 'menu_order' ] );
	unset($options['rating']);
	//unset( $options[ 'date' ] );
	//unset( $options[ 'price' ] );
	//unset( $options[ 'price-desc' ] );

	return $options;
});




function canva_wooc_ajax_update_modal_cart_fragment()
{
	$cart = WC()->cart;

	// ob_start();

	$fragments = '(' . $cart->get_cart_contents_count() . ' pz - sub.tot. ' . $cart->get_total() . ')';

	echo $fragments;

	// ob_get_clean();

	wp_die();
}
add_action('wp_ajax_canva_wooc_ajax_update_modal_cart_fragment', 'canva_wooc_ajax_update_modal_cart_fragment');
add_action('wp_ajax_nopriv_canva_wooc_ajax_update_modal_cart_fragment', 'canva_wooc_ajax_update_modal_cart_fragment');



/**
 * trova ID variazione in base agli attributi
 *
 * @param [type] $product_id
 * @param array $attributes
 * @return void
 * @example https://stackoverflow.com/questions/53958871/woocommerce-get-product-variation-id-from-matching-attributes
 */
function get_product_variation_id_by_attributes($product_id, $attributes = [])
{
    return (new \WC_Product_Data_Store_CPT())->find_matching_product_variation(
        new \WC_Product($product_id),
        $attributes
    );
}
