<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (is_admin() && !defined('DOING_AJAX')) {

	if (!$is_preview) {
		/* rendering in inserter preview  */
		echo '<img src="' . CANVA_PROJECT_BLOCKS_URI . '/previews/' . wp_basename($block['name']) . '.jpg" class="block-preview" style="width:100%; height:auto;">';
	}

?>

	<div class="canva-wp-block canva-flex">

		<div class="info canva-width-24 canva-p-4">

			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">
				<?php _e('Hero CTA', 'canva-backend'); ?>
			</span>

			<figure class="canva-width-12 canva-m-0">

				<!-- Icona -->
				<?php echo apply_filters('promo_block_slider_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-posts-selector-preview', null)); ?>
				<!-- Fine Icona -->

			</figure>

		</div>

		<div class="_content canva-flex-1 canva-p-4">

			<?php if (get_field('main_title')) { ?>
				<h1>
					<?php echo get_field('main_title'); ?>
				</h1>
				<?php
				echo canva_get_img([
					'img_id' => get_field('product'),
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '640-free',
					'wrapper_class' => 'canva-width-24 canva-p-0 canva-m-0 canva-mr-4',
					'img_class' => '',
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => 'off',
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);
				?>
				<h2>
					<?php echo get_field('title'); ?>
				</h2>
				<p>
					<?php echo get_field('text'); ?>
				</p>

			<?php } else { ?>
				<span class="canva-block canva-mb-2 canva-fs-h4 canva-font-theme canva-fw-700 canva-lh-11">
					Imposta il blocco
				</span>
			<?php } ?>
		</div>

	</div>

<?php } else { ?>

	<?php
	// Create id attribute allowing for custom "anchor" value.
	$id = $block['id'];
	if (!empty($block['anchor'])) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$className = '';
	if (!empty($block['className'])) {
		$className .= ' ' . $block['className'];
	}

	if (get_field('product')) :

		$product = wc_get_product(get_field('product')[0]);

	?>

		<a href="<?php echo esc_url(get_permalink($product->get_id())); ?>">

			<div class="_promo-banner bg-white rounded-md shadow-md group p-8 lg:p-16 relative text-center">

				<div class="_promo-banner-status absolute top-4 left-0 flex flex-col gap-2">
					<?php if ($product->is_on_sale()) :
						$sale_percent = ($product->get_sale_price() * 100) / $product->get_regular_price();
					?>
						<div class="_discount-flag bg-skew yellow pl-2 pr-4 lg:py-1 lg:px-8">
							<span class="lh-10 fs-sm fw-700">-<?php echo ceil($sale_percent); ?>%</span>
						</div>
					<?php endif; ?>

					<?php if (get_field('new_product', $product->get_id())) : ?>
						<div class="_new-flag bg-skew pl-2 pr-4 lg:py-1 lg:px-8">
							<span class="lh-10 fw-700 fs-sm text-white uppercase"><?php _e('New', 'canva-abac'); ?></span>
						</div>
					<?php endif; ?>
				</div>

				<!-- <div class="_promo-banner-status absolute top-4 left-0 flex flex-col gap-2">
				<div class="_discount-flag bg-skew yellow pl-2 pr-4 lg:py-1 lg:px-8">
					<span class="lh-10 fs-sm fw-700">- 30%</span>
				</div>
				<div class="_new-flag bg-skew pl-2 pr-4 lg:py-1 lg:px-8">
					<span class="lh-10 fw-700 fs-sm text-white">NEW</span>
				</div>
			</div> -->

				<span class="_promo-banner-main-title block pt-8 h1 px-8 lg:px-16 text-center mb-4"><?php the_field('main_title'); ?></span>

				<div class="grid justify-center mb-4">
					<?php
					echo canva_get_img([
						'img_id' => $product->get_id(),
						'img_type' => 'img', // img, bg, url
						'thumb_size' => '640-free',
						'wrapper_class' => 'relative w-64 ratio-1-1',
						'img_class' => 'absolute p-4 object-contain transition duration-fast transform-gpu group-hover:scale-110',
						'bg_content' => '',
						'caption' => 'off',
						'blazy' => 'off',
						'srcset' => 'off',
						'data_attr' => '',
						'width' => '',
						'height' => '',
					]);
					?>
				</div>

				<?php if (get_field('title')) : ?>
					<span class="_promo-banner-title block uppercase"><?php echo get_field('title'); ?></span>
				<?php endif; ?>

				<?php if (get_field('text')) : ?>
					<span class="promo-banner-text block h4"><?php echo get_field('text'); ?></span>
				<?php endif; ?>

				<?php if (get_field('product')) : ?>
					<div class="flex justify-center">
						<span class="button secondary fs-sm">
							<?php if (get_field('cta_label')) : ?>
								<?php echo get_field('cta_label'); ?></p>
							<?php else : ?>
								<?php _e('Discover', 'canva-abac'); ?>
							<?php endif; ?>
						</span>
					</div>
				<?php endif; ?>

			</div>

		</a>

<?php
	endif;
}
