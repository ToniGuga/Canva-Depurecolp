<?php

/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
// do_action('woocommerce_before_single_product');

if (post_password_required()) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('_main__section pb-16', $product); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	// do_action('woocommerce_before_single_product_summary');
	?>

	<div class="_main-info-section summary entry-summary max-w-screen-xl mx-auto">

		<?php
		/**
		 * Hook: woocommerce_single_product_summary.
		 *
		 * @hooked woocommerce_template_single_title - 5
		 * @hooked woocommerce_template_single_rating - 10
		 * @hooked woocommerce_template_single_price - 10
		 * @hooked woocommerce_template_single_excerpt - 20
		 * @hooked woocommerce_template_single_add_to_cart - 30
		 * @hooked woocommerce_template_single_meta - 40
		 * @hooked woocommerce_template_single_sharing - 50
		 * @hooked WC_Structured_Data::generate_product_data() - 60
		 */
		// do_action( 'woocommerce_single_product_summary' );
		?>
		<div class="grid grid-cols-12 gap-4 md:gap-16">

			<div class="_main-photo-gallery col-span-12 lg:col-span-6">

				<div class="_product-status md:hidden flex mb-4 gap-2 px-4">
					<?php if ($product->is_on_sale()) :
						$sale_percent = ($product->get_sale_price() * 100) / $product->get_regular_price();
					?>
						<div class="_discount-flag bg-skew yellow px-4">
							<span class="lh-10 fs-xs fw-700">-<?php echo ceil($sale_percent); ?>%</span>
						</div>
					<?php endif; ?>

					<?php if (get_field('new_product')) : ?>
						<div class="_new-flag bg-skew text-white px-4">
							<span class="lh-10 fs-xs fw-700">NEW</span>
						</div>
					<?php endif; ?>
				</div>

				<div class="_title-wrap md:hidden mb-4 px-4">
					<h1 class="_product-title h3 uppercase max-w-48ch mb-2"><?php echo $product->get_title(); ?></h1>

					<?php if (get_field('cp_product_id')) : ?>
						<span>PN: <?php echo get_field('cp_product_id'); ?></span>
					<?php endif; ?>

				</div>

				<div class="_product-gallery-wrap sticky top-24 lg:pt-12 px-8 md:px-16 pt-0 w-screen md:w-full">
					<div class="_product-gallery-content">
						<?php echo simple_product_silder_gallery($product->get_id()); ?>
					</div>
				</div>

			</div>

			<div class="_main-info col-span-12 lg:col-span-6">

				<div class="_info-content">

					<div class="_info-content-section-1 p-8 bg-gray-50">

						<div class="_product-status flex mb-4 gap-2">
							<?php if ($product->is_on_sale()) :
								$sale_percent = ($product->get_sale_price() * 100) / $product->get_regular_price();
							?>
								<div class="_discount-flag bg-skew yellow px-4">
									<span class="lh-10 fs-xs fw-700">-<?php echo ceil($sale_percent); ?>%</span>
								</div>
							<?php endif; ?>

							<?php if (get_field('new_product')) : ?>
								<div class="_new-flag bg-skew text-white px-4">
									<span class="lh-10 fs-xs fw-700">NEW</span>
								</div>
							<?php endif; ?>
						</div>

						<div class="_title-wrap mb-4 hidden md:block">
							<h1 class="_product-title max-w-48ch h3 uppercase mb-1"><?php echo $product->get_title(); ?></h1>

							<?php if (get_field('cp_product_id')) : ?>
								<span class="fs-sm text-gray-400">PN: <?php echo get_field('cp_product_id'); ?></span>
							<?php endif; ?>
						</div>

						<?php
						$attributes = [
							'air-consumption-l-m' => 'Air consumption <span class="fs-sm">(l/m)</span>',
							'air-consumption-l-s' => 'Air consumption <span class="fs-sm">(l/s)</span>',
							'air-flow-m3-h' => 'Air flow <span class="fs-sm">(m3/h)</span>',
							'capacity-l' => 'Capacity <span class="fs-sm">(l)</span>',
							'needles-nr' => 'Needles <span class="fs-sm">(nr)</span>',
							'pipe-lenght-mm' => 'Pipe lenght <span class="fs-sm">(mm)</span>',
							'power-hp' => 'Power <span class="fs-sm">(hp)</span>',
							'revolution-per-minute-rpm' => 'Revolution per minute <span class="fs-sm">(rpm)</span>',
							'socket-mm' => 'Socket <span class="fs-sm">(mm)</span>',
							'strokes-per-minutes-min' => 'Strokes per minutes <span class="fs-sm">(min)</span>',
							'tank-capacity-l' => 'Tank Capacity <span class="fs-sm">(l)</span>',
							'working-torque-nm' => 'Working Torque <span class="fs-sm">(nm)</span>',
						];
						?>

						<?php if ($product->get_attributes()) : ?>
							<ul class="_product-main-attributes mb-8 md:mt-8 md:mb-8 fs-sm">
								<?php foreach ($attributes as $key => $val) : ?>
									<?php if ($product->get_attribute($key)) : ?>
										<li><?php echo $val; ?>: <strong><?php echo $product->get_attribute($key); ?></strong></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>

						<!-- <?php if (get_the_excerpt($product->get_id())) : ?>
							<div class="_product-abstract mb-12">
								<p class="fs-h5"><?php echo get_the_excerpt($product->get_id()); ?></p>
								<a class="text-black fs-sm" href="#description"><?php _e('More details', 'canva-abac'); ?> &gt;&gt;</a>
							</div>
						<?php endif; ?> -->


						<div class="_add-to-cart_wrap mb-8">
							<?php echo woocommerce_template_single_price(); ?>

							<div class="_product-availability mb-8">
								<span class="_product-availability block text-gray-700 fs-xs">
									<span class="_label-availability"><?php _e('Availability', 'canva-abac'); ?>: </span>
									<span class="_product-availability-status fw-700"><?php _e('In stock', 'canva-abac'); ?></span>
								</span>
							</div>

							<?php echo woocommerce_template_single_add_to_cart(); ?>
						</div>

						<!-- <div class="_product-notes">
							<div class="flex items-center gap-2">
								<div class="_icon w-4 h-4 rounded-full bg-gray-300">
								</div>
								<div class="flex-1">
									<span class="fs-sm text-alert">Avviso sul prodotto lorem ipsum dolor sit amet dol</span>
								</div>
							</div>
						</div> -->

					</div>




					<div class="_info-content-section-2 px-8 py-4 bg-abc-yellow-100">

						<?php if (get_field('ac_shipping_time')) : ?>
							<div class="flex items-center gap-2 mb-2">
								<div class="_icon w-4 h-4 rounded-full">
									<?php
									// echo canva_get_img([
									// 	'img_id'   =>  3848,
									// 	'img_type' => 'img', // img, bg, url
									// 	'thumb_size' =>  '300-free',
									// 	'wrapper_class' => '',
									// 	'img_class' => '',
									// 	'blazy' => 'off',
									// ]);
									// echo canva_get_svg_icon('abac-icons/icon-delivery');
									?>

									<figure class="">
										<img class="b-lazy" data-src="<?php echo canva_get_theme_img_url('abac-icons/icon-delivery.svg'); ?>" alt="shipping time">
									</figure>
								</div>
								<div class="flex-1">
									<span class="fs-sm"><?php echo get_field('ac_shipping_time'); ?></span>
								</div>
							</div>
						<?php endif; ?>

						<?php if (get_field('cp_warranty2')) : ?>
							<div class="flex items-center gap-2 mb-2">
								<div class="_icon w-4 h-4 rounded-full">
									<?php
									// echo canva_get_img([
									// 	'img_id'   =>  3844,
									// 	'img_type' => 'img', // img, bg, url
									// 	'thumb_size' =>  '300-free',
									// 	'wrapper_class' => '',
									// 	'img_class' => '',
									// 	'blazy' => 'off',
									// ]);
									?>
									<figure class="">
										<img class="b-lazy" data-src="<?php echo canva_get_theme_img_url('abac-icons/icon-warranty.svg'); ?>" alt="shipping time">
									</figure>
								</div>
								<div class="flex-1">
									<span class="fs-sm"><?php echo get_field('cp_warranty2'); ?></span>
								</div>
							</div>
						<?php endif; ?>

						<div class="flex items-center gap-2 mb-2">
							<div class="_icon w-4 h-4 rounded-full">
								<?php
								// echo canva_get_img([
								// 	'img_id'   =>  3843,
								// 	'img_type' => 'img', // img, bg, url
								// 	'thumb_size' =>  '300-free',
								// 	'wrapper_class' => '',
								// 	'img_class' => '',
								// 	'blazy' => 'off',
								// ]);
								?>
								<figure class="">
									<img class="b-lazy" data-src="<?php echo canva_get_theme_img_url('abac-icons/icon-secure-payment.svg'); ?>" alt="shipping time">
								</figure>
							</div>
							<div class="flex-1">
								<span class="fs-sm"><?php _e('Secure payment', 'canva-abac'); ?></span>
							</div>
						</div>

						<div class="flex items-center gap-2 mb-2">
							<div class="_icon w-4 h-4 rounded-full">
								<?php
								// echo canva_get_img([
								// 	'img_id'   =>  3845,
								// 	'img_type' => 'img', // img, bg, url
								// 	'thumb_size' =>  '300-free',
								// 	'wrapper_class' => '',
								// 	'img_class' => '',
								// 	'blazy' => 'off',
								// ]);
								?>
								<figure class="">
									<img class="b-lazy" data-src="<?php echo canva_get_theme_img_url('abac-icons/icon-discount.svg'); ?>" alt="shipping time">
								</figure>
							</div>
							<div class="flex-1">
								<span class="fs-sm"><?php _e('X% discount available with coupon code', 'canva-abac'); ?></span>
							</div>
						</div>

					</div>




					<div class="_info-content-section-3 p-8 bg-gray-50">

						<div id="description" class="_product-description">
							<span class="block fs-sm fw-700 uppercase pb-2 border-b-2 border-secondary mb-6"><?php _e('Description', 'canva-abac'); ?></span>

							<?php echo get_the_content(); ?>
						</div>

						<div class="_additional_attributes mt-12 overflow-y-hidden">
							<span class="block fs-sm fw-700 uppercase pb-2 border-b-2 border-secondary mb-6"><?php _e('Tecnical data', 'canva-abac'); ?></span>

							<?php
							$additional_attributes = [
								'ac_shipping_time' => 'Shipping Time',
								'air_flow_m_h' => 'Air Flow <span class="fs-sm">(m3/h)</span>',
								'cp_brand_2020' => 'Brand',
								'cp_depth' => 'Depth <span class="fs-sm">(mm)</span>',
								'cp_element_type' => 'Pump ',
								'cp_fabricant_product_name' => 'Product Name',
								'cp_frequency' => 'Frequency <span class="fs-sm">(hz)</span>',
								'cp_height' => 'Height <span class="fs-sm">(mm)</span>',
								'cp_horsepower' => 'Horse power <span class="fs-sm">(hp)</span>',
								'cp_integrated_dryer_2020' => 'Integrated Dryer',
								'cp_lpa_4m' => 'Noise level lpa 4m <span class="fs-sm">(db(a))</span>',
								'cp_lwa' => 'Noise level lwa <span class="fs-sm">(db(a))</span>',
								'cp_manufacturer_code' => 'Manufacturer Code',
								'cp_maximum_bar_2020' => 'Maximum pressure <span class="fs-sm">(bar)</span>',
								'cp_mobility_2020' => 'Mobility',
								'cp_net_air_output' => 'Net Air Output <span class="fs-sm">(l/min)</span>',
								'cp_oil_free' => 'Oil Free',
								'cp_oil_volume' => 'Oil Volume <span class="fs-sm">(l)</span>',
								'cp_phases' => 'Phases',
								'cp_power' => 'Power',
								'cp_product_id' => 'Product Id (PN)',
								'cp_revolutions_per_minute' => 'Revolutions per minute <span class="fs-sm">(rpm)</span>',
								'cp_starter' => 'Starter',
								'cp_suction_capacity' => 'Suction Capacity',
								'cp_tank_configuration' => 'Tank Configuration',
								'cp_tank_size_2020' => 'Tank Size <span class="fs-sm">(l)</span>',
								'cp_type' => 'Type',
								'cp_voltage_2020' => 'Voltage <span class="fs-sm">(v)</span>',
								'cp_warranty2' => 'Warranty',
								'cp_weight' => 'Weight <span class="fs-sm">(kg)</span>',
								'cp_width' => 'Width <span class="fs-sm">(mm)</span>',
								// 'product_category' => 'Product Category',
								'cp_air_quality' => 'Air Quality',
								'cp_air_requirement' => 'Air Requirement',
								'cp_socket_square' => 'Socket square',
								'cp_socket_hexagonal' => 'Socket hexagonal',
								'cp_torque' => 'Torque <span class="fs-sm">(nm)</span>',
								'cp_vibration' => 'Vibration',
								'cp_working_pressure' => 'Working Pressure <span class="fs-sm">(bar)</span>',
								'cp_working_torque' => 'Working Torque <span class="fs-sm">(nm)</span>',
							];
							?>

							<table class="w-full text-left">
								<tr>
									<th><?php _e('Attribute', 'canva-abac'); ?></th>
									<th><?php _e('Value', 'canva-abac'); ?></th>
								</tr>
								<?php foreach ($additional_attributes as $key => $value) : ?>
									<?php if (get_field($key)) : ?>
										<tr>
											<td><?php echo $value; ?></td>
											<td>
												<?php
												if (is_numeric(get_field($key))) {
													if ($key == 'cp_product_id') {
														echo get_field($key);
													} else {
														echo number_format(get_field($key), 0, ',', '.');
													}
												} else {
													echo get_field($key);
												}
												?>
											</td>
										</tr>
									<?php endif; ?>
								<?php endforeach; ?>
							</table>
						</div>

						<div class="text-center mt-4">
							<a class="_slide-down button hollow fs-xxs" style="display:none;" href="javascript:;">
								<?php _e('Show more', 'canva-abac'); ?>
							</a>
						</div>

					</div>

				</div>
			</div>

		</div>

	</div>

</div>

<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
do_action('woocommerce_after_single_product_summary');
?>
</div>


<?php do_action('woocommerce_after_single_product'); ?>
