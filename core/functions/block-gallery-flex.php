<div class="_gallery_container relative">

	<?php
	if ($random) {
		shuffle($img_ids);
	}

	$nr = count($img_ids);

	if ($limit > 0 && $nr > $limit) {
	?>

		<div class="state-box photo-counter fs-xsmall absolute p-1 pl-2 pr-2 pin-t pin-r mt-2 mr-2 bg-grey-lightest shadow-5 z-10" style="border-radius:2rem;">
			+<?php echo $nr - $limit; ?> <?php _e('Photo', 'canva-frontend'); ?>
		</div>

	<?php
	}
	?>

	<?php
	if (!$css_class) {
		$css_class = 'grid items-center grid-cols-2 md:grid-cols-' . esc_attr($columns);
	}
	?>

	<div id="<?php echo $galleryID; ?>" class="photoswipe_gallery_container-flex relative <?php echo esc_attr($css_class); ?>">

		<?php
		if (!empty($captions)) {
			$imgs_data = array_combine($img_ids, array_map(null, $captions));
		} else {
			$imgs_data = $img_ids;
		}

		$i = 1;

		// var_dump($imgs_data);

		foreach ($imgs_data as $key => $img_data) {

			$hide = '';
			if ($limit > 0) {
				if ($key > ($limit - 1)) {
					$hide = 'hide';
				}
			}

			$item_class = 'photoswipe-item pointer gallery-item gallery-item-' . $i++ . ' ' . $hide;
			$class_figure = $item_class;
			$class_img_extra = 'gallery-img ' . $circle_class;

			echo canva_get_img(
				[
					'img_id' => $img_data,
					'img_type' => 'img', // img, bg, url
					'thumb_size' => $size, //'640-free',
					'wrapper_class' => $class_figure,
					'img_class' => $class_img_extra,
					'bg_content' => '',
					'caption' => '',
					'blazy' => 'on',
					'srcset' => 'on',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]
			);
		} //end foreach;
		?>

	</div>

</div>
