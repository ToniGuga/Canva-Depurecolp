<?php
defined('ABSPATH') || exit;
?>

<div class="_wooc-modal-cart fixed top-0 w-full z-50 h-full transition-all -right-full flex justify-end">
	<div class="_wooc-modal-cart-left bg-black opacity-25 w-1/12 lg:w-full"></div>

	<div class="_wooc-modal-cart-right w-11/12 lg:w-3/6 bg-white relative">

		<div class="_close-wooc-modal-cart _canva-close-button absolute top-2 right-2"></div>

		<div class="_wooc-modal-cart-container relative h-full overflow-y-auto pb-48"></div>

		<div class="_modal-cart-actions absolute bottom-0 w-full bg-white p-4 text-center">
			<a class="button hollow w-64 mb-4" href="<?php echo wc_get_cart_url(); ?>"><?php _e('Cart', 'woocommerce'); ?></a>
			<a class="button w-64 mb-0" href="<?php echo wc_get_checkout_url(); ?>"><?php _e('Checkout', 'woocommerce'); ?></a>
		</div>
	</div>
</div>
