<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}


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
	if (get_field('google_universal_analytics_id','options')) {
		return 'onclick="ga(\'send\', \'event\', \'' . $eventCategory . '\', \'' . $eventAction . '\', \'' . esc_attr($eventLabel) . '\');"';
	} elseif (get_field('google_analytics_4_id','options')) {
		return 'onclick="gtag(\'event\', {' . $eventAction . '}, {\'event_category\': ' . $eventCategory . ', \'event_label\': ' . $eventLabel . '});"';
	} else {
		return;
	}
}

/*

RICORDA DI COPIARE QUESTO IN thankyou.php di WOOC

// Used to track orders with analytics Canva
$GLOBALS['order_id'] = $order->get_id();

 */

if (!function_exists('canva_google_analytics_header')) {
	function canva_google_analytics_header()
	{
?>
		<script>
			var gadwpDnt = false;
			var gadwpProperty = '<?php echo get_field('google_universal_analytics_id', 'options'); ?>';
			var gadwpDntFollow = true;
			var gadwpOptout = true;
			var disableStr = 'ga-disable-' + gadwpProperty;
			if (gadwpDntFollow && (window.doNotTrack === "1" || navigator.doNotTrack === "1" || navigator.doNotTrack === "yes" || navigator.msDoNotTrack === "1")) {
				gadwpDnt = true;
			}
			if (gadwpDnt || (document.cookie.indexOf(disableStr + '=true') > -1 && gadwpOptout)) {
				window[disableStr] = true;
			}

			function gaOptout() {
				var expDate = new Date;
				expDate.setFullYear(expDate.getFullYear() + 10);
				document.cookie = disableStr + '=true; expires=' + expDate.toGMTString() + '; path=/';
				window[disableStr] = true;
			}

			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

			ga('create', '<?php echo get_field('google_universal_analytics_id', 'options'); ?>', 'auto');
			ga('send', 'pageview');
			ga('set', 'anonymizeIp', true);
			ga('set', 'forceSSL', true);

			<?php if (is_wpml_activated()) { ?>
				ga('send', 'event', 'NavigationLanguage', '<?php echo get_current_lang(); ?>', '<?php echo get_current_lang(); ?>');
			<?php } ?>

			function timer11() {
				ga('send', 'event', 'TimeOnPage', '1', '11-30 seconds', {
					'nonInteraction': 1
				});
			}

			function timer31() {
				ga('send', 'event', 'TimeOnPage', '2', '31-60 seconds', {
					'nonInteraction': 1
				});
			}

			function timer61() {
				ga('send', 'event', 'TimeOnPage', '3', '61-180 seconds', {
					'nonInteraction': 1
				});
			}

			function timer181() {
				ga('send', 'event', 'TimeOnPage', '4', '181-600 seconds', {
					'nonInteraction': 1
				});
			}

			function timer601() {
				ga('send', 'event', 'TimeOnPage', '5', '601-1800 seconds', {
					'nonInteraction': 1
				});
			}

			function timer1801() {
				ga('send', 'event', 'TimeOnPage', '6', '1801+ seconds', {
					'nonInteraction': 1
				});
			}
			ga('send', 'event', 'TimeOnPage', '0', '0-10 seconds', {
				'nonInteraction': 1
			});
			setTimeout(timer11, 11000);
			setTimeout(timer31, 31000);
			setTimeout(timer61, 61000);
			setTimeout(timer181, 181000);
			setTimeout(timer601, 601000);
			setTimeout(timer1801, 1801000);
		</script>

	<?php
	}
}


if (!function_exists('canva_google_analytics_footer')) {
	function canva_google_analytics_footer()
	{
		$order_id = '';
		if (isset($GLOBALS['order_id'])) {
			$order_id = $GLOBALS['order_id'];
			$order = wc_get_order($order_id);
		} ?>
		<script>
			<?php if (is_checkout() && '' != $order_id) { ?>

				ga('require', 'ecommerce');
				ga('ecommerce:addTransaction', {
					'id': '<?php echo $order->id; ?>',
					/* Transaction ID. Required */
					'affiliation': '<?php echo esc_js(get_bloginfo('name')); ?>',
					/* Affiliation or store name */
					'revenue': '<?php echo esc_js($order->get_total()); ?>',
					/* Grand Total */
					'shipping': '<?php echo esc_js($order->get_total_shipping()); ?>',
					/* Shipping */
					'tax': '"<?php echo esc_js($order->get_total_tax()); ?>',
					/* Tax */
					'currency': '<?php echo esc_js(version_compare(WC_VERSION, '3.0', '<') ? $order->get_order_currency() : $order->get_currency()); ?>' /* Currency */
				});

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
					$categories_string = implode(', ', $categories); ?>

					ga('ecommerce:addItem', {
						'id': '<?php echo esc_js($product->id); ?>',
						/* Transaction ID (Required) */
						'name': '<?php echo esc_js($product->name); ?>',
						/* Product name. (Required) */
						'sku': '<?php echo esc_js($sku); ?>',
						/* SKU/code */
						<?php if ($brands_string) { ?> 'brand': '<?php echo esc_js($brands_string); ?>',
							/* Product brands */
						<?php } ?> 'category': '<?php echo esc_js($categories_string); ?>',
						/* Category or variation */
						'price': '<?php echo esc_js($total); ?>',
						/* Unit price */
						'quantity': '<?php echo esc_js($qty); ?>' /* Quantity */
					});

				<?php
				} ?>

				ga('ecommerce:send');

			<?php } ?>
		</script>

	<?php
	}
	// add_action('foundationpress_before_closing_body', 'canva_google_analytics_footer', 80);
}

if (!function_exists('canva_google_analytics_4')) {
	function canva_google_analytics_4()
	{
	?>

		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo get_field('google_analytics_4_id', 'options'); ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push(arguments);
			}
			gtag('js', new Date());

			gtag('config', '<?php echo get_field('google_analytics_4_id', 'options'); ?>');
		</script>

	<?php
	}
}


if (!function_exists('canva_facebook_pixel_header')) {
	function canva_facebook_pixel_header()
	{
	?>
		<!-- Facebook Pixel Code -->
		<script>
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
		<!-- End Facebook Pixel Code -->
<?php
	}
}
