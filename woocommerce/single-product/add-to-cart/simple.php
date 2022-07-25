<?php

/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
	return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

	<?php do_action('woocommerce_before_add_to_cart_form'); ?>

	<span class="block fs-xxs uppercase text-gray-700 mb-1">Quantity</span>

	<form class="cart flex flex-wrap items-center fs-sm" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action('woocommerce_before_add_to_cart_button'); ?>

		<?php
		do_action('woocommerce_before_add_to_cart_quantity');

		woocommerce_quantity_input(
			array(
				'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
				'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
				'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
			)
		);

		do_action('woocommerce_after_add_to_cart_quantity');
		?>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button secondary mt-2 md:mt-0" style="padding-top:.5em;padding-bottom:.5em;margin-bottom: 0;">
			<div class="_add-to-cart-icon _icon-wrap">
				<figure class="_shopping-cart-icon absolute w-16">
					<?php
					echo canva_get_svg_icon('fontawesome/regular/shopping-cart', '_shopping-cart-icon absolute');
					// echo canva_get_svg_icon('eqipe-icons/shopping-cart', '');
					?>
				</figure>

				<figure class="_check-icon absolute w-16 opacity-0">
					<?php
					echo canva_get_svg_icon('fontawesome/regular/check', '_check-icon absolute opacity-0');
					// echo canva_get_svg_icon('eqipe-icons/check', '');
					?>
				</figure>
			</div>
			<div class="_add-to-cart-message relative">
				<span class="_add-to-cart-text block">
					<?php echo esc_html($product->single_add_to_cart_text()); ?>
				</span>
				<span class="_added-to-cart-text block hidden">
					<?php _e('Product added', 'canva-abac'); ?>
				</span>
			</div>
		</button>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>
	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
