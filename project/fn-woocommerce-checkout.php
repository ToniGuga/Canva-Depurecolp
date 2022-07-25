<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Crea div apertura per controllare layout del checkout su due colonne per Medium in su
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function cutomer_details_wrap_start()
{
	echo '<div class="woocommerce-checkout-form-container py-16 px-default-section">';
	echo '<div class="woocommerce-checkout-form-wrap max-w-screen-xxl mx-auto grid md:grid-cols-2 gap-4">';
	echo '<div class="woocommerce_checkout_before_customer_details">';
}
add_action('woocommerce_checkout_before_customer_details', 'cutomer_details_wrap_start');

function cutomer_details_wrap_end()
{
	echo '</div>';
}
add_action('woocommerce_checkout_after_customer_details', 'cutomer_details_wrap_end');

function order_review_wrap_start()
{
	echo '<div class="order_review_wrap md:h-screen md:sticky md:top-32 bg-gray-100 p-4" style="min-height:1000px;">';
}
add_action('woocommerce_checkout_before_order_review_heading', 'order_review_wrap_start');

function order_review_wrap_end()
{
	echo '</div>';
	echo '</div>';
	echo '</div>';
}
add_action('woocommerce_checkout_after_order_review', 'order_review_wrap_end');


/**
 * Funzione utile per disattivare campi del checkout
 *
 * @param [type] $fields
 * @return void
 */
function wooc_custom_remove_checkout_fields($fields)
{

	//    Billing fields
	//    unset( $fields['billing']['billing_first_name'] );
	//    unset( $fields['billing']['billing_last_name'] );
	//    unset( $fields['billing']['billing_company'] );
	//    unset( $fields['billing']['billing_country'] );
	//    unset( $fields['billing']['billing_address_1'] );
	unset($fields['billing']['billing_address_2']);
	//    unset( $fields['billing']['billing_state'] );
	//    unset( $fields['billing']['billing_city'] );
	//    unset( $fields['billing']['billing_postcode'] );
	//    unset( $fields['billing']['billing_email'] );
	//    unset( $fields['billing']['billing_phone'] );

	//    Shipping fields
	//    unset( $fields['shipping']['shipping_company'] );
	//    unset( $fields['shipping']['shipping_phone'] );
	//    unset( $fields['shipping']['shipping_state'] );
	//    unset( $fields['shipping']['shipping_first_name'] );
	//    unset( $fields['shipping']['shipping_last_name'] );
	//    unset( $fields['shipping']['shipping_address_1'] );
	//    unset( $fields['shipping']['shipping_address_2'] );
	//    unset( $fields['shipping']['shipping_city'] );
	//    unset( $fields['shipping']['shipping_postcode'] );

	// Order fields
	// unset($fields['order']['order_comments']);

	return $fields;
}
add_filter('woocommerce_checkout_fields', 'wooc_custom_remove_checkout_fields');


function wooc_new_custom_checkout_fields($fields)
{

	$fields['billing']['billing_first_name'] = [
		'label' => __('Name', 'woocommerce'),
		'placeholder' => _x('Mario', 'placeholder', 'studio42-wooc'),
		// 'description' => '<span class="fs-xxsmall">'.__('Lo useremo per verificare la scadenza', 'canva-eqipe').'</span>',
		'required' => true,
		// 'class' => ['w-1/2 mr-4 mb-4'],
		'clear' => false,
		'priority' => 10,
		'custom_attributes' => ['autocorrect' => 'off', 'autocapitalize' => 'on'],
	];

	$fields['billing']['billing_last_name'] = [
		'label' => __('Last name', 'woocommerce'),
		'placeholder' => _x('Rossi', 'placeholder', 'studio42-wooc'),
		// 'description' => '<span class="fs-xxsmall">'.__('Lo useremo per verificare la scadenza', 'canva-eqipe').'</span>',
		'required' => true,
		// 'class' => ['w-1/2 mr-4 mb-4'],
		'clear' => false,
		'priority' => 20,
		'custom_attributes' => ['autocorrect' => 'off', 'autocapitalize' => 'on'],
	];

	$fields['billing']['billing_email'] = [
		'label' => __('Email', 'woocommerce'),
		'placeholder' => _x('mario.rossi@email.it', 'placeholder', 'studio42-wooc'),
		// 'description' => '<span class="fs-xxsmall">' . __('Lo useremo per comunicazioni legate alla tua richiesta', 'canva-eqipe') . '</span>',
		'required' => true,
		'class' => ['col-span-2'],
		'clear' => false,
		'priority' => 30,
		'custom_attributes' => ['autocorrect' => 'off', 'autocapitalize' => 'off', 'inputmode' => 'email'],
	];

	$fields['billing']['billing_company']['priority'] = 120;
	// $fields['billing']['billing_company']['description'] = '<span class="fs-xxsmall">' . __('Lo useremo per la fatturazione', 'canva-eqipe') . '</span>';
	// $fields['billing']['billing_company']['class'] = ['col-span-2'];
	$fields['billing']['billing_company']['autocorrect'] = 'off';


	// $fields['shipping']['shipping_first_name'] = [
	// 	'label' => __('Name', 'woocommerce'),
	// 	'placeholder' => _x('Mario', 'placeholder', 'studio42-wooc'),
	// 	// 'description' => '<span class="fs-xxsmall">'.__('Lo useremo per verificare la scadenza', 'canva-eqipe').'</span>',
	// 	'required' => true,
	// 	// 'class' => ['w-1/2 mr-4 mb-4'],
	// 	'clear' => false,
	// 	'priority' => 10,
	// 	'custom_attributes' => ['autocorrect' => 'off', 'autocapitalize' => 'on'],
	// ];

	// $fields['shipping']['shipping_last_name'] = [
	// 	'label' => __('Last name', 'woocommerce'),
	// 	'placeholder' => _x('Rossi', 'placeholder', 'studio42-wooc'),
	// 	// 'description' => '<span class="fs-xxsmall">'.__('Lo useremo per verificare la scadenza', 'canva-eqipe').'</span>',
	// 	'required' => true,
	// 	// 'class' => ['w-1/2 mr-4 mb-4'],
	// 	'clear' => false,
	// 	'priority' => 20,
	// 	'custom_attributes' => ['autocorrect' => 'off', 'autocapitalize' => 'on'],
	// ];

	// $fields['shipping']['shipping_email'] = [
	// 	'label' => __('Email', 'canva-eqipe'),
	// 	'placeholder' => _x('mario.rossi@email.it', 'placeholder', 'studio42-wooc'),
	// 	'description' => '<span class="fs-xxsmall">' . __('Lo useremo per comunicazioni legate alla tua richiesta', 'canva-eqipe') . '</span>',
	// 	'required' => true,
	// 	'class' => ['col-span-2'],
	// 	'clear' => false,
	// 	'priority' => 30,
	// 	'custom_attributes' => ['autocorrect' => 'off', 'autocapitalize' => 'off', 'inputmode' => 'email'],
	// ];

	return $fields;
}
add_filter('woocommerce_checkout_fields', 'wooc_new_custom_checkout_fields', 99);


/**
 * Funzione per creare i dati di fatturazione
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $fields
 * @return void
 */
function wooc_field_cfpiva($fields)
{

	// if (get_current_lang() == 'it') {
	// 	$fields['billing']['billing_cf'] = array(
	// 		'label' => __('Codice Fiscale', 'studio42-wooc'),
	// 		'placeholder' => _x('Codice Fiscale', 'placeholder', 'studio42-wooc'),
	// 		'required' => true,
	// 		'class' => ['col-span-2'],
	// 		'clear' => false,
	// 		'priority' => 110,
	// 		'default' => (get_current_user_id() > 0) ? get_user_meta(get_current_user_id(), 'billing_cf', true) : ''
	// 	);
	// }

	$fields['billing']['billing_piva'] = array(
		'label' => __('VAT number', 'woocommerce'),
		// 'placeholder' => _x('VAT number', 'placeholder', 'studio42-wooc'),
		'required' => false,
		// 'class' => array('column small-12 large-6'),
		'clear' => false,
		'priority' => 130,
		'default' => (get_current_user_id() > 0) ? get_user_meta(get_current_user_id(), 'billing_piva', true) : ''
	);

	// if (get_current_lang() == 'it') {
	// 	$fields['billing']['billing_pec'] = array(
	// 		'label' => __('PEC', 'studio42-wooc'),
	// 		'placeholder' => _x('Email di posta certificata', 'placeholder', 'studio42-wooc'),
	// 		'required' => false,
	// 		'class' => array('column small-12 large-6'),
	// 		'clear' => false,
	// 		'priority' => 130,
	// 		'custom_attributes' => ['autocorrect' => 'off', 'autocapitalize' => 'off', 'inputmode' => 'email'],
	// 		'default' => (get_current_user_id() > 0) ? get_user_meta(get_current_user_id(), 'billing_pec', true) : ''
	// 	);

	// 	$fields['billing']['billing_sdi_code'] = array(
	// 		'label' => __('Codice Destinatario', 'studio42-wooc'),
	// 		'placeholder' => _x('Per Fattura Elettronica', 'placeholder', 'studio42-wooc'),
	// 		'required' => false,
	// 		'class' => array('column small-12 large-6'),
	// 		'clear' => false,
	// 		'priority' => 140,
	// 		'default' => (get_current_user_id() > 0) ? get_user_meta(get_current_user_id(), 'billing_sdi_code', true) : ''
	// 	);
	// }

	return $fields;
}
add_filter('woocommerce_checkout_fields', 'wooc_field_cfpiva', 99);



/**
 * Funzione per la validazione formale del codice fiscale nella pagina di checkout
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
// function wooc_checkout_field_process()
// {
// 	// Check if set, if its not set add an error.

// 	if ($_POST['billing_cf'] == "" || preg_match('/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/i', $_POST['billing_cf'])) {
// 		//do nothing

// 	} elseif ($_POST['billing_cf'] != "" && !preg_match('/^[A-Z]{6}\d{2}[A-Z]\d{2}[A-Z]\d{3}[A-Z]$/i', $_POST['billing_cf'])) {

// 		wc_add_notice(__('<b>Codice Fiscale</b> non valido.', 'studio42-wooc'), 'error');
// 	}
// }
// add_action('woocommerce_checkout_process', 'wooc_checkout_field_process');



/**
 * Aggiunge i campi cf, piva, sdi, pec nel backend pagine ordine
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $fields
 * @return void
 */
function wooc_admin_field_cf_piva($fields)
{

	// $fields['cf'] = array(
	// 	'label' => __('Codice Fiscale', 'studio42-wooc'),
	// 	'show' => true
	// );

	$fields['piva'] = array(
		'label' => __('VAT Number', 'woocommerce'),
		'show' => true
	);

	// $fields['pec'] = array(
	// 	'label' => __('PEC', 'studio42-wooc'),
	// 	'show' => true
	// );

	// $fields['sdi_code'] = array(
	// 	'label' => __('Codice Destinatario', 'studio42-wooc'),
	// 	'show' => true
	// );


	return $fields;
}
add_filter('woocommerce_admin_billing_fields', 'wooc_admin_field_cf_piva');



/**
 * Aggiunge i campi cf, piva, sdi, pec nel backend pagina di modifica utente
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $fields
 * @return void
 */
function wooc_admin_user_field_cf_piva($fields)
{

	// $fields['billing']['fields']['billing_cf'] = array(
	// 	'label' => 'Codice fiscale',
	// 	'description' => ''
	// );

	$fields['billing']['fields']['billing_piva'] = array(
		'label' => 'VAT Number',
		'description' => ''
	);

	// $fields['billing']['fields']['billing_pec'] = array(
	// 	'label' => 'PEC',
	// 	'description' => ''
	// );

	// $fields['billing']['fields']['billing_sdi_code'] = array(
	// 	'label' => 'Codice Destinatario',
	// 	'description' => ''
	// );

	return $fields;
}
add_filter('woocommerce_customer_meta_fields', 'wooc_admin_user_field_cf_piva');


/**
 * Aggiunge controllo jquery sul select della nazione per nascondere il codice fiscale per l'italia
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function wooc_billing_fields_scripts()
{
?>
	<script>
		(function($) {

			// $(document).ready(function() {
			// 	var order_review_heading = '<h3>' + $('#order_review_heading').text() + '</h3>';
			// 	setTimeout(() => {
			// 		$('.woocommerce-checkout-review-order').prepend(order_review_heading);
			// 	}, 1200);
			// });

			$('select#billing_country').on('change', function() {

				var country = $('select#billing_country').val();

				var check_countries = new Array(<?php echo '"IT"'; ?>);

				if (country && $.inArray(country, check_countries) >= 0) {

					$('#billing_cf_field').fadeIn();

				} else {

					$('#billing_cf_field').fadeOut();
					$('#billing_cf_field input').val('');
					$("#billing_cf_field").removeClass('validate-required');

					$('#billing_pec_field').fadeOut();
					$('#billing_pec_field input').val('');
					$("#billing_pec_field").removeClass('validate-required');

					$('#billing_sdi_code_field').fadeOut();
					$('#billing_sdi_code_field input').val('');
					$("#billing_sdi_code_field").removeClass('validate-required');

				}

			});
		})(jQuery);
	</script>

<?php

}
// add_action('studio42_before_closing_body', 'wooc_billing_fields_scripts', 75);
