<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

?>
	<div class="canva-wp-block canva-flex">

		<div class="canva-info canva-width-24 canva-p-4 canva-bg-grey-lightest">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style=""><?php _e('Icon & Text', 'canva-backend'); ?></span>
			<figure class="canva-width-16 canva-m-0 canva-bg-grey-lightest canva-p-0">
				<?php echo apply_filters('icon_text_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-icon-text', null)); ?>
			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4">

			<div class="canva-block-icon-text canva-flex">

				<div class="canva-icon canva-mr-6 canva-mt-3 canva-width-12">
					<?php
					if (get_field('icon')) {
						echo canva_get_img([
							'img_id' => get_field('icon'),
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '320-11',
							'wrapper_class' => 'canva-width-12 canva-p-0 canva-m-0 canva-mr-4',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'off',
							'srcset' => 'off',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);
					} else {
						echo canva_get_svg_icon('fontawesome/regular/image', 'canva-width-12 canva-p-0 canva-m-0 canva-mr-4');
					}
					?>
				</div>

				<div class="canva-info canva-flex-1 canva-ml-4">
					<?php echo get_field('content', false, false); ?>
				</div>

			</div>
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


	$icon_size = get_field('icon_size');

	switch ($icon_size) {
		case 'micro':
			$icon_classes = 'w-8';
			break;
		case 'mini':
			$icon_classes = 'w-12';
			break;
		case 'normal':
			$icon_classes = 'w-16';
			break;
		case 'medium':
			$icon_classes = 'w-20';
			break;
		case 'large':
			$icon_classes = 'w-32';
			break;
		case 'xlarge':
			$icon_classes = 'w-48';
			break;
	}
	?>

	<div id="<?php echo esc_attr($id); ?>" class="canva-block-icon-text sm:flex sm:flex-wrap sm:items-start <?php echo esc_attr($className); ?>">

		<div class="icon p-2 <?php echo esc_attr($icon_classes); ?>">
			<?php
			echo canva_get_img([
				'img_id' => get_field('icon'),
				'img_type' => 'img', // img, bg, url
				'thumb_size' => '320-11',
				'wrapper_class' => '',
				'img_class' => '',
				'bg_content' => '',
				'caption' => 'off',
				'blazy' => 'on',
				'srcset' => 'off',
				'data_attr' => '',
				'width' => '',
				'height' => '',
			]);
			?>
		</div>

		<div class="content flex-1 p-2">
			<?php echo get_field('content'); ?>
		</div>

	</div>

<?php }
