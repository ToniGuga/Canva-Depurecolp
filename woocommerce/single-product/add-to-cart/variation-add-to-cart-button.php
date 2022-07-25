<?php

/**
 * Single variation cart button
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined('ABSPATH') || exit;

global $product;
?>
<div class="woocommerce-variation-add-to-cart variations_button">
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

	<button type="submit" class="single_add_to_cart_button ajax_add_to_cart button accent alt flex items-center w-full h-14" data-product_id="<?php echo esc_attr($product->get_id()); ?>">
		<div class="_add-to-cart-icon _icon-wrap">
			<figure class="_shopping-cart-icon absolute w-16">
				<?php
				echo canva_get_svg_icon('fontawesome/regular/shopping-cart','_shopping-cart-icon absolute');
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
				<?php _e('Prodotto aggiunto', 'canva-eqipe'); ?>
			</span>
		</div>
	</button>

	<?php do_action('woocommerce_after_add_to_cart_button'); ?>

	<input type="hidden" name="add-to-cart" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="product_id" value="<?php echo absint($product->get_id()); ?>" />
	<input type="hidden" name="variation_id" class="variation_id" value="0" />
</div>
