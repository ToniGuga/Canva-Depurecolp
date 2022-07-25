<?php

/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined('ABSPATH') || exit;

global $product;

// echo $product->get_id();

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
	return;
}

?>

<a href="<?php echo get_permalink($product->get_id()); ?>">

	<div <?php wc_product_class('_card _card-product group relative', $product); ?>>

		<?php
		// /**
		//  * Hook: woocommerce_before_shop_loop_item.
		//  *
		//  * @hooked woocommerce_template_loop_product_link_open - 10
		//  */
		// do_action( 'woocommerce_before_shop_loop_item' );

		// /**
		//  * Hook: woocommerce_before_shop_loop_item_title.
		//  *
		//  * @hooked woocommerce_show_product_loop_sale_flash - 10
		//  * @hooked woocommerce_template_loop_product_thumbnail - 10
		//  */
		// do_action( 'woocommerce_before_shop_loop_item_title' );

		// /**
		//  * Hook: woocommerce_shop_loop_item_title.
		//  *
		//  * @hooked woocommerce_template_loop_product_title - 10
		//  */
		// do_action( 'woocommerce_shop_loop_item_title' );

		// /**
		//  * Hook: woocommerce_after_shop_loop_item_title.
		//  *
		//  * @hooked woocommerce_template_loop_rating - 5
		//  * @hooked woocommerce_template_loop_price - 10
		//  */
		// do_action( 'woocommerce_after_shop_loop_item_title' );

		// /**
		//  * Hook: woocommerce_after_shop_loop_item.
		//  *
		//  * @hooked woocommerce_template_loop_product_link_close - 5
		//  * @hooked woocommerce_template_loop_add_to_cart - 10
		//  */
		// do_action( 'woocommerce_after_shop_loop_item' );
		?>

		<div class="_card-image pt-6 mb-4">

			<?php
			$thumbnail_id = get_post_thumbnail_id($product->get_id());
			$file = wp_basename(wp_get_attachment_image_src($thumbnail_id,'640-free')[0]);

			if (false !== strpos($file, 'box1') || false !== strpos($file, 'Box1') || false !== strpos($file, 'hshshsji') || false !== strpos($file, '3dd08')) {
				// return 'https://abc.dadostudio.com/wp-content/uploads/2022/06/placeholder.jpg';
				echo '<figure class="relative ratio-1-1 bg-white" style="" data-url="https://abc.dadostudio.com/wp-content/uploads/2022/06/placeholder.jpg" data-size="262x262" width="262" height="262"><img class="b-lazy px-2 object-contain transition duration-fast transform-gpu group-hover:scale-110" data-src="https://abc.dadostudio.com/wp-content/uploads/2022/06/placeholder.jpg" alt="ABAC sand blaster with hose | home use" width="262" height="262"><figcaption class="image-caption block"></figcaption></figure>';
			} else {
				echo canva_get_img([
					'img_id' => $thumbnail_id,
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '640-free',
					'img_class' => 'px-2 object-contain transition duration-fast transform-gpu group-hover:scale-110',
					'wrapper_class' => 'relative ratio-1-1 bg-white',
					'blazy' => 'on',
				]);
			}
			?>

		</div>

		<div class="_card-status absolute top-8 left-0 flex flex-col gap-2">
			<?php if ($product->is_on_sale()) :
				$sale_percent = ($product->get_sale_price() * 100) / $product->get_regular_price();
			?>
				<div class="_discount-flag bg-skew yellow px-2">
					<span class="lh-10 fs-xs fw-700">-<?php echo ceil($sale_percent); ?>%</span>
				</div>
			<?php endif; ?>

			<?php if (get_field('new_product')) : ?>
				<div class="_new-flag bg-skew px-2">
					<span class="lh-10 fw-700 fs-sm text-white uppercase"><?php _e('New', 'canva-abac'); ?></span>
				</div>
			<?php endif; ?>
		</div>

		<div class="_card-info pt-0 p-4">
			<div class="_card-info-wrap">
				<div class="_info">
					<div class="_product-title-wrap h-12 mb-4">
						<h3 class="_product-title fs-sm fw-400 line-clamp-3 mb-0"><?php echo get_the_title($product->get_id()) ?></h3>
						<!-- <span class="_price block lh-10 fs-h6 mr-4">120 €<del>140 €</del></span> -->
					</div>
					<?php
					/**
					 * Hook: woocommerce_after_shop_loop_item_title.
					 *
					 * @hooked woocommerce_template_loop_rating - 5
					 * @hooked woocommerce_template_loop_price - 10
					 */
					do_action('woocommerce_after_shop_loop_item_title');
					?>
				</div>
			</div>
		</div>

	</div>
</a>
