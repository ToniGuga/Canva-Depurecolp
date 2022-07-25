<?php
defined('ABSPATH') || exit;
?>

<div class="_wooc-modal-cart fixed top-0 w-full z-50 h-full transition-all -right-full flex justify-end">
	<div class="_wooc-modal-cart-left bg-black opacity-75 w-2/12 md:w-full"></div>

	<div class="_wooc-modal-cart-right w-11/12 lg:w-3/6 bg-white relative">
		<span class="_close-wooc-modal-cart block absolute top-0 right-0 p-4 z-2 cursor-pointer fs-h2 bg-white">&times;</span>

		<div class="_wooc-modal-cart-container relative h-full overflow-y-auto pt-24 pb-24"></div>

		<div class="_modal-cart-actions absolute bottom-0 w-full bg-white px-4 pt-8">
			<a class="button hollow w-full p-2 mb-2" href="<?php echo wc_get_cart_url(); ?>"><?php _e('Cart', 'woocommerce'); ?></a>
			<a class="button hollow w-full p-2" href="<?php echo wc_get_checkout_url(); ?>"><?php _e('Checkout', 'woocommerce'); ?></a>
		</div>
	</div>
</div>
