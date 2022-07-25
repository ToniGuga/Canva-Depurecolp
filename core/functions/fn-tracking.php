<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Prints js script into head of the DOM
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function gdpr_cookie_consent_bar()
{

	$html = '';

	if (get_field('iubenda', 'options')) {
		$html .= '<!--IUB-COOKIE-SKIP-START-->';
		$html .= get_field('privacy_js_scripts_head', 'options');
		$html .= '<!--IUB-COOKIE-SKIP-END-->';
	} elseif (get_field('cookiebot', 'options')) {
		$html .= '<!--COOKIEBOT-COOKIE-SKIP-START-->';
		$html .= get_field('privacy_js_scripts_head', 'options');
		$html .= '<!--COOKIEBOT-COOKIE-SKIP-END-->';
	}

	echo canva_minifier($html);
}
//hoojed in fn-hooks.php


/**
 * Function to easely track events for google analytics
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $eventCategory
 * @param string $eventAction
 * @param string $eventLabel
 * @return void
 */
function canva_get_ga_event_tracker($eventCategory = 'Action-Link', $eventAction = 'click', $eventLabel = '')
{
	if (get_field('google_analytics_id', 'options')) {
		return 'onclick="gtag(\'event\', \'' . $eventAction . '\', {\'event_category\': \'' . $eventCategory . '\', \'event_label\': \'' . $eventLabel . '\'});"';
	} else {
		return;
	}
}

function canva_get_timeonpage_tracker($eventCategory = 'Action-Link', $eventAction = 'click', $eventLabel = '')
{
	if (get_field('google_analytics_id', 'options')) {
		return 'gtag(\'event\', \'' . $eventAction . '\', {\'event_category\': \'' . $eventCategory . '\', \'event_label\': \'' . $eventLabel . '\'});';
	} else {
		return;
	}
}

/**
 * Google Analytics Tracking
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_google_analytics_header()
{
	$gtag_id = '';
	if (get_field('google_analytics_id', 'options')) {
		$gtag_id = get_field('google_analytics_id', 'options');
	}

	$anonymize_ip = 'false';
	if (get_field('google_analytics_ip_anonymizer', 'options')) {
		$anonymize_ip = 'true';
	}
?>

	<!--IUB-COOKIE-BLOCK-START-->

	<?php if (get_field('iubenda', 'options')) { ?>
		<script async data-suppressedsrc="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_js($gtag_id); ?>" class="_iub_cs_activate"></script>
	<?php } elseif (get_field('cookiebot', 'options')) { ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_js($gtag_id); ?>"></script>
	<?php } else { ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_js($gtag_id); ?>"></script>
	<?php } ?>

	<script class="_iub_cs_activate-inline" data-cookieconsent="statistics">
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}

		gtag('js', new Date());

		gtag('config', '<?php echo esc_js($gtag_id); ?>', {
			'anonymize_ip': <?php echo esc_js($anonymize_ip); ?>
		});

		<?php if (is_wpml_activated()) { ?>
			gtag('event', 'NavigationLanguage', '<?php echo get_current_lang(); ?>', '<?php echo get_current_lang(); ?>');
		<?php } ?>

		function timer11() {
			<?php echo canva_get_timeonpage_tracker('TimeOnPage', '1', '11-30 seconds'); ?>
		}

		function timer31() {
			<?php echo canva_get_timeonpage_tracker('TimeOnPage', '2', '31-60 seconds'); ?>
		}

		function timer61() {
			<?php echo canva_get_timeonpage_tracker('TimeOnPage', '3', '61-180 seconds'); ?>
		}

		function timer181() {
			<?php echo canva_get_timeonpage_tracker('TimeOnPage', '4', '181-600 seconds'); ?>
		}

		function timer601() {
			<?php echo canva_get_timeonpage_tracker('TimeOnPage', '5', '601-1800 seconds'); ?>
		}

		function timer1801() {
			<?php echo canva_get_timeonpage_tracker('TimeOnPage', '6', '1801+ seconds'); ?>
		}

		<?php echo canva_get_timeonpage_tracker('TimeOnPage', '0', '0-0 seconds'); ?>

		setTimeout(timer11, 11000);
		setTimeout(timer31, 31000);
		setTimeout(timer61, 61000);
		setTimeout(timer181, 181000);
		setTimeout(timer601, 601000);
		setTimeout(timer1801, 1801000);
	</script>
	<!--IUB-COOKIE-BLOCK-END-->
<?php
}
//hooked in fn-hooks.php


/**
 * Checkout tracking for Google Analytics
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_google_analytics_footer()
{
	$order_id = '';
	$order = '';
	if (isset($_GET['key'])) {
		$order_id = wc_get_order_id_by_order_key($_GET['key']);
		$order = wc_get_order($order_id);
	}
?>

	<?php if (is_wc_endpoint_url('order-received') && '' != $order_id) { ?>

		<!--IUB-COOKIE-BLOCK-START-->
		<script class="_iub_cs_activate-inline">
			gtag('event', 'purchase', {
				"transaction_id": "<?php echo $order_id; ?>",
				"affiliation": "<?php echo esc_js(get_bloginfo('name')); ?>",
				"value": <?php echo esc_js($order->get_total()); ?>,
				"currency": "<?php echo esc_js(version_compare(WC_VERSION, '3.0', '<') ? $order->get_order_currency() : $order->get_currency()); ?>",
				"tax": "<?php echo esc_js($order->get_total_tax()); ?>",
				"shipping": "<?php echo esc_js($order->get_total_shipping()); ?>",
				"items": [
					<?php
					$line_items = $order->get_items();
					foreach ($line_items as $item) {
						// This will be a product
						$product = $order->get_product_from_item($item);
						$sku = $product->get_sku();
						$qty = $item['qty'];
						$total = $order->get_item_total($item, true, true);
						$brand_tax = apply_filters('analytics_brand_tax', 'product_brand');
						$brands = canva_get_post_terms($post_id = $item['product_id'], $taxonomy = $brand_tax, $term_data = 'name');
						$brands_string = implode(', ', $brands);
						$categories = canva_get_post_terms($post_id = $item['product_id'], $taxonomy = 'product_cat', $term_data = 'name');
						$categories_string = implode(', ', $categories);
					?> {
							"id": "<?php echo esc_js($product->id); ?>",
							"name": "<?php echo esc_js($product->name); ?>",
							<?php if ($brands_string) { ?> "brand": "<?php echo esc_js($brands_string); ?>",
							<?php } ?> "category": "<?php echo esc_js($categories_string); ?>",
							"quantity": "<?php echo esc_js($qty); ?>",
							"price": "<?php echo esc_js($total); ?>",
						},
					]
			});
			<?php } ?>
		</script>
		<!--IUB-COOKIE-BLOCK-END-->
<?php
	}
}
//hoojed in fn-hooks.php

/**
 * Undocumented function
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_facebook_pixel_header()
{
	?>
	<!--IUB-COOKIE-BLOCK-START-->
	<script class="_iub_cs_activate-inline">
		! function(f, b, e, v, n, t, s) {
			if (f.fbq) return;
			n = f.fbq = function() {
				n.callMethod ?
					n.callMethod.apply(n, arguments) : n.queue.push(arguments)
			};
			if (!f._fbq) f._fbq = n;
			n.push = n;
			n.loaded = !0;
			n.version = '2.0';
			n.queue = [];
			t = b.createElement(e);
			t.async = !0;
			t.src = v;
			s = b.getElementsByTagName(e)[0];
			s.parentNode.insertBefore(t, s)
		}(window, document, 'script',
			'https://connect.facebook.net/en_US/fbevents.js');

		fbq('init', '<?php echo esc_attr(get_field('facebook_pixel_id', 'options')); ?>');
		fbq('track', 'PageView');
	</script>

	<noscript>
		<img height="1" width="1" src="https://www.facebook.com/tr?id=<?php echo esc_attr(get_field('facebook_pixel_id', 'options')); ?>&ev=PageView
	&noscript=1" />
	</noscript>
	<!--IUB-COOKIE-BLOCK-END-->

<?php
}
//hoojed in fn-hooks.php


/**
 * Stampa array js CF7 da usare pe la messaggistica delle modali in ajax
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_cf7_forms_ids_js_array()
{
	$args = [
		'post_type' => 'wpcf7_contact_form',
		'posts_per_page' => -1,
	];

	$query = new WP_Query($args);

	if ($query->have_posts()) {
		$cf7_ids = [];
		while ($query->have_posts()) {
			$query->the_post();
			$cf7_ids[] = get_the_ID();
		}
		wp_reset_postdata($query);
	}

?>
	<?php if($cf7_ids && !empty($cf7_ids)) : ?>
		<script>
			var canvaCf7Ids = [<?php echo implode(',', $cf7_ids); ?>];
		</script>
	<?php endif; ?>

<?php
}
// hooked in fn-hooks.php



/**
 * Stampa eventi js per tracciare invio moduli cf7
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_cf7_event_tracker()
{
    $args = [
        'post_type' => 'wpcf7_contact_form',
        'posts_per_page' => -1,
    ];

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        ?>

		<script>
			document.addEventListener('wpcf7mailsent', function(event) {
				<?php
                while ($query->have_posts()) {
                    $query->the_post();
                    //$do_not_duplicate = $post->ID;
				?>

					if ('<?php echo get_the_ID(); ?>' == event.detail.contactFormId) {

						<?php
						if (get_field('google_analytics_id', 'options')) {
							/* ga('send', 'event', '<?php echo get_the_title(); ?> <?php echo get_the_ID(); ?>', 'submit'); */
							echo canva_get_timeonpage_tracker('Action-Link','submit', ''.get_the_title().' '.get_the_ID().'');
						}

						if (get_field('facebook_pixel_id', 'options')) {
							echo "fbq('trackCustom', '".get_the_title()." ".get_the_ID()."');";
						}
						?>
					}

                <?php } //endwhile ?>
			}, false);
		</script>

<?php
    } // endif
}
// hooked in fn-hooks.php
