<?php

/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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

get_header('shop');

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action('woocommerce_before_main_content');

$queried_object = get_queried_object();
$taxonomy = $queried_object->taxonomy;
$term_id = $queried_object->term_id;
$term_slug = $queried_object->slug;

$ancestors = get_ancestors($term_id, $taxonomy);
$ancestors = array_reverse($ancestors);

$term_top_parent = get_term($ancestors[0], $taxonomy);
// $term_top_parent_name = $term_top_parent->name;

$term_parent = get_term($ancestors[1], $taxonomy);
// $term_parent_name = $term_parent->name;

$term = get_term($term_id, $taxonomy);

$childs = get_term_children($term_parent->term_id, $taxonomy);
?>


<div class="_main__section">

	<div class="wp-block-columns gap-8">

		<div class="_filters-column wp-block-column col-span-12 md:col-span-4 lg:col-span-3 sm:hide md:block">

			<div class="_filters-wrap sticky top-24 p-4 pt-12 bg-gray-100">

				<h3 class="fw-300"><?php _e('Filters', 'canva-abac'); ?></h3>
				<hr class="mt-4" />

				<?php if ($term_slug === 'tools' || $term_slug == 'air-treatment' || $term_slug == 'kit-spare-parts' || $term_slug === 'application' || in_array($term_id, $childs)) { ?>

					<?php if ($term_slug == 'application') { ?>
						<?php echo facetwp_display('facet', 'product_categories_mod_application'); ?>
					<?php } elseif ($term_slug == 'tools') { ?>
						<?php echo facetwp_display('facet', 'product_categories_mod_tools'); ?>
					<?php } elseif ($term_slug == 'kit-spare-parts') { ?>
						<?php echo facetwp_display('facet', 'product_categories_mod_kit_spare_parts'); ?>
						<?php echo facetwp_display('facet', 'pumping_units'); ?>
						<?php echo facetwp_display('facet', 'screw_hours'); ?>
					<?php } else { ?>
						<?php echo facetwp_display('facet', 'product_categories_mod_air_treatment'); ?>
					<?php } ?>

				<?php } elseif ($term_slug === 'air-compressor' || $term_slug === 'piston' || $term_slug === 'screw' || $term_slug === 'lubricants') { ?>

					<?php if ($term_slug == 'air-compressor') { ?>
						<?php echo facetwp_display('facet', 'product_categories_air_compressors'); ?>
					<?php } else { ?>
						<?php echo facetwp_display('facet', 'product_categories_lubricants'); ?>
					<?php } ?>
					<hr class="mt-4" />

					<?php if ($term_slug === 'air-compressor' || $term_slug === 'piston' || $term_slug === 'screw') { ?>

						<span class="h6 block mt-4 mb-12">Capacity</span>
						<?php echo facetwp_display('facet', 'tank_capacity_l'); ?>
						<hr class="mt-2" />

						<span class="h6 block mt-4 mb-12">Power</span>
						<?php echo facetwp_display('facet', 'power_hp'); ?>
						<hr class="mt-2" />

						<span class="h6 block mt-4 mb-12">Air flow</span>
						<?php echo facetwp_display('facet', 'air_flow_pa'); ?>
						<hr class="mt-2" />

					<?php } ?>

				<?php } ?>

				<span class="h6 block mt-4 mb-12">Price range</span>
				<?php echo facetwp_display('facet', 'price_range'); ?>

				<div class="py-8 text-center">
					<?php echo facetwp_display('facet', 'reset'); ?>
				</div>

			</div>

		</div>

		<div class="wp-block-column col-span-12 md:col-span-8 lg:col-span-9">

			<header class="woocommerce-products-header">

				<?php
				/**
				 * Hook: woocommerce_archive_description.
				 *
				 * @hooked woocommerce_taxonomy_archive_description - 10
				 * @hooked woocommerce_product_archive_description - 10
				 */
				// do_action('woocommerce_archive_description');
				?>

				<?php
				// if ($term_slug === 'kit-spare-parts' || $term_slug === 'tools' || $term_slug === 'lubrificants') :
				if ($term_slug === 'kit-spare-parts') :
				?>

					<div class="_category-header bg-primary px-4 lg:px-8 py-12 isdark mb-4">
						<div class="_title-col">
							<div class="_category-title mb-4">
								<h1 class="_title fw-400">
									<?php echo $term->name; ?>
									<span class="_sub-term block text-body"></span>
								</h1>
							</div>
							<div class="_content-wrap isdark">
								<p class="max-w-64ch"><?php echo $term->description; ?></p>
							</div>
						</div>
					</div>

					<div class="_part_number_search hide shadow-lg md:flex justify-between items-center bg-gray-100 px-4 lg:px-8 py-12 rounded-md">
						<div class="_title-col lg:flex-1">
							<div class="_category-title mb-4">
								<h2 class="fs-h2 text-black fw-700 mb-0">
									<span>Find the right spare parts </span>
									<span class="fw-300 text-gray-400">for your compressor.</span>
								</h2>
							</div>
							<div class="grid grid-cols-2 gap-8">
								<div class="pr-8">
									<p>After entering your 10 digits compressor part number into the search, you will see all spare parts that fit your equipment.</p>
								</div>
								<div class="flex justify-end">
									<?php echo facetwp_display('facet', 'part_number_search'); ?>
								</div>
							</div>
						</div>
					</div>


				<?php else : ?>

					<div class="_hero _hero-archive _layer-wrap flex-wrap min-h-hero-short fade-in">

						<div class="_layer-visual relative order-2 lg:order-1 lg:absolute h-64 lg:h-auto">
							<?php
							$term_img = canva_get_img([
								'img_id'   =>  canva_get_term_featured_img_id($term),
								'img_type' => 'url', // img, bg, url
								'thumb_size' =>  '640-free',
								'img_class' =>  '',
								'wrapper_class' =>  '',
								'blazy' => 'off',
							]);
							?>

							<div class="_layer-bg lg:top-6" style="background-image:url(<?php echo esc_url($term_img); ?>);"></div>

							<!-- <div class="_layer-filter"></div> -->

							<div class="_layer-graphics"></div>
							<div class="_layer-status"></div>
						</div>

						<div class="_layer-content relative w-full max-w-screen-xxl mx-auto order-1 lg:order-2 bg-primary lg:bg-transparent pt-12 lg:pb-16 px-4 lg:px-8">
							<!-- Content child mixed html php etc-->

							<div class="wp-block-columns h-full">
								<div class="wp-block-column col-span-12 lg:col-span-6">
									<div class="_content-wrap isdark">

										<h1 class="_title fw-400">
											<?php echo $term->name; ?>
											<span class="_sub-term block text-body"></span>
										</h1>
										<div class="_hero-primary-content fs-p text-white max-w-64ch mt-8">
											<p><?php echo $term->description; ?></p>
										</div>

									</div>
								</div>
							</div>
						</div>

					</div>

				<?php endif; ?>

			</header>

			<?php
			if (woocommerce_product_loop()) {
			?>


				<div class="_category-filter-section pt-8">

					<div class="_category-filters flex flex-wrap items-end justify-between">

						<div class="_category-filters-left flex items-center">
							<!-- <div class="_filter-label flex-1">
								<span class="block fs-xs lh-10"><?php _e('Mostra filtri', 'canva-abac'); ?></span>
							</div>
							<div class="_filter_icon ml-4 cursor-pointer w-8 h-8 bg-gray-200 flex items-center justify-center"></div> -->
						</div>

						<div class="_category-filters-right flex flex-wrap justify-between items-center w-full">

							<div class="_category-product-status sm:hide md:block flex mb-4 gap-2 px-4">

								<?php echo facetwp_display('facet', 'deals'); ?>

								<?php echo facetwp_display('facet', 'new_products'); ?>
							</div>

							<a href="javascript:;" class="button facetwp-flyout-open md:hide"><?php _e('Filters', 'canva-abac'); ?></a>

							<div class="_category-products-order sm:hide md:block">
								<?php
								/**
								 * Hook: woocommerce_before_shop_loop.
								 *
								 * @hooked woocommerce_output_all_notices - 10
								 * @hooked woocommerce_result_count - 20
								 * @hooked woocommerce_catalog_ordering - 30
								 */
								// do_action('woocommerce_before_shop_loop');

								echo facetwp_display('facet', 'sort_by');

								woocommerce_product_loop_start();
								?>
							</div>
						</div>

					</div>

				</div>

				<div class="_archive-products pt-8 pb-16">

					<div class="_archive-products-wrap max-w-screen-xxl mx-auto grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 transition-all">

						<?php
						if (wc_get_loop_prop('total')) {
							while (have_posts()) {
								the_post();

								/**
								 * Hook: woocommerce_shop_loop.
								 */

								do_action('woocommerce_shop_loop');

								wc_get_template_part('content', 'product');
							}
						}
						?>

					</div>

				</div>

				<div class="flex flex-wrap items-center justify-center">
					<?php
					woocommerce_product_loop_end();

					/**
					 * Hook: woocommerce_after_shop_loop.
					 *
					 * @hooked woocommerce_pagination - 10
					 */
					// do_action('woocommerce_after_shop_loop');
					echo facetwp_display('facet', 'load_more');
					?>
				</div>
			<?php

			} else {
				/**
				 * Hook: woocommerce_no_products_found.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action('woocommerce_no_products_found');
			}

			?>
		</div>

	</div>

</div>





<?php
/**
 * Hook: woocommerce_after_main_content.
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
// do_action('woocommerce_after_main_content');

/**
 * Hook: woocommerce_sidebar.
 *
 * @hooked woocommerce_get_sidebar - 10
 */
// do_action('woocommerce_sidebar');

get_footer('shop');
