<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
// echo $is_preview;

if (is_admin()) {

	$hide = '';
	if (get_field('hide')) {
		$hide = 'hide';
	}

	$staff_preview = '';
	if (get_field('show_for_admin')) {
		$staff_preview = 'staff-preview';
	}

?>

	<div class="canva-wp-block <?php echo esc_attr($hide . ' ' . $staff_preview); ?>" style="border: 1px dashed #aaaaaa;">

		<div class="canva-info canva-flex align-middle">
			<figure class="canva-width-16 canva-m-0 canva-bg-grey-lightest canva-p-0">
				<!-- ICONA -->
				<?php
				// filtro che permette di sovrascrivere l'icona di questo blocco
				echo apply_filters('row_w_100_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100', null));
				?>
				<!-- Fine Icona -->
			</figure>
			<div class="canva-p-4">
				<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-12" style=""><?php _e('Row Width 100%', 'canva-backend'); ?></span>
				<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
				<span class="canva-block canva-mt-0 canva-mb-2 canva-fs-small canva-font-theme canva-lh-11"><?php echo esc_html('Full width wrapper', 'canva-backend'); ?></span>
			</div>
		</div>

		<div class="canva-content canva-p-4 canva-bg-white">

			<?php if (get_field('bg_image') || get_field('bg_image_small')) { ?>
				<div class="canva-flex">
					<p><?php _e('Background Image:', 'canva-backend'); ?> </p>
					<?php
					if (get_field('bg_image')) {
						echo canva_get_img(['img_id' => get_field('bg_image'), 'img_type' => 'img', 'thumb_size' => '160-free', 'blazy' => 'off']);
					}
					?>

					<?php
					if (get_field('bg_image_small')) {
						echo canva_get_img(['img_id' => get_field('bg_image_small'), 'img_type' => 'img', 'thumb_size' => '160-free', 'blazy' => 'off']);
					}
					?>
				</div>
			<?php } ?>

			<div class="user-locked-inner-blocks">
				<InnerBlocks />
			</div>
		</div>

	</div>

<?php
} else {
	// var_dump($block);

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

	// $now = strtotime(current_time('Y-m-d H:i:s'));
	$now = canva_get_current_time();
	$start_date_time = strtotime(get_field('start_date_time'));
	$end_date_time = strtotime(get_field('end_date_time'));

	// if(is_user_logged_in()){
	// 	echo get_field('start_date_time');
	// }
?>

	<?php
	$image = '';
	if (get_field('bg_image')) {
		$image = 'data-src="' . canva_get_img(['img_id' => get_field('bg_image'), 'img_type' => 'url', 'thumb_size' => '1600-free']) . '"';
	}

	$image_small = '';
	if (get_field('bg_image_small')) {
		$image_small = 'data-src-small="' . canva_get_img(['img_id' => get_field('bg_image_small'), 'img_type' => 'url', 'thumb_size' => 'full']) . '"';
	}
	?>

	<?php if (!get_field('hide')) { ?>

		<?php if (!$start_date_time && !$end_date_time) { ?>

			<?php if (get_field('bg_image')) { ?>
				<div id="<?php echo $id; ?>" class="b-lazy <?php echo esc_attr($className); ?>" <?php echo $image . ' ' . $image_small; ?> style="background-position: center center; background-size: cover;">
					<InnerBlocks />
				</div>
			<?php } else { ?>
				<div id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
					<InnerBlocks />
				</div>
			<?php } ?>

		<?php } else { ?>

			<div data-post-id="<?php echo esc_attr(get_the_ID()); ?>" data-block-id="<?php echo esc_attr($block['id']); ?>" data-start-time="<?php echo get_field('start_date_time'); ?>" data-end-time="<?php echo get_field('end_date_time'); ?>">

				<?php if (($start_date_time && !$end_date_time) && $now >= $start_date_time) { ?>
					<?php if (get_field('bg_image')) { ?>
						<div id="<?php echo $id; ?>" class="b-lazy <?php echo esc_attr($className); ?>" <?php echo $image . ' ' . $image_small; ?> style="background-position: center center; background-size: cover;">
							<InnerBlocks />
						</div>
					<?php } else { ?>
						<div id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
							<InnerBlocks />
						</div>
					<?php } ?>

				<?php } elseif (($start_date_time && $end_date_time) && ($now >= $start_date_time && $now <= $end_date_time)) { ?>
					<?php if (get_field('bg_image')) { ?>
						<div id="<?php echo $id; ?>" class="b-lazy <?php echo esc_attr($className); ?>" <?php echo $image . ' ' . $image_small; ?> style="background-position: center center; background-size: cover;">
							<InnerBlocks />
						</div>
					<?php } else { ?>
						<div id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
							<InnerBlocks />
						</div>
					<?php } ?>
				<?php } ?>

			</div>

		<?php } ?>

	<?php } elseif (get_field('hide') && get_field('show_for_admin') && current_user_can('edit_pages')) { ?>

		<?php if (!$start_date_time && !$end_date_time) { ?>

			<?php if (get_field('bg_image')) { ?>
				<div id="<?php echo $id; ?>" class="b-lazy <?php echo esc_attr($className); ?>" <?php echo $image . ' ' . $image_small; ?> style="background-position: center center; background-size: cover;">
					<InnerBlocks />
				</div>
			<?php } else { ?>
				<div id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
					<InnerBlocks />
				</div>
			<?php } ?>

		<?php } else { ?>

			<div data-post-id="<?php echo esc_attr(get_the_ID()); ?>" data-block-id="<?php echo esc_attr($block['id']); ?>" data-start-time="<?php echo get_field('start_date_time'); ?>" data-end-time="<?php echo get_field('end_date_time'); ?>">

				<?php if (($start_date_time && !$end_date_time) && $now >= $start_date_time) { ?>
					<?php if (get_field('bg_image')) { ?>
						<div id="<?php echo $id; ?>" class="b-lazy <?php echo esc_attr($className); ?>" <?php echo $image . ' ' . $image_small; ?> style="background-position: center center; background-size: cover;">
							<InnerBlocks />
						</div>
					<?php } else { ?>
						<div id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
							<InnerBlocks />
						</div>
					<?php } ?>

				<?php } elseif (($start_date_time && $end_date_time) && ($now >= $start_date_time && $now <= $end_date_time)) { ?>
					<?php if (get_field('bg_image')) { ?>
						<div id="<?php echo $id; ?>" class="b-lazy <?php echo esc_attr($className); ?>" <?php echo $image . ' ' . $image_small; ?> style="background-position: center center; background-size: cover;">
							<InnerBlocks />
						</div>
					<?php } else { ?>
						<div id="<?php echo $id; ?>" class="<?php echo esc_attr($className); ?>">
							<InnerBlocks />
						</div>
					<?php } ?>
				<?php } ?>

			</div>

		<?php } ?>

	<?php } ?>

<?php
}
