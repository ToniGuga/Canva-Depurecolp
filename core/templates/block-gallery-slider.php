<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>

<?php if ($img_ids) : ?>
	<div class="_main__section gallery pb-24">
		<?php
		$atts = [
			'img_ids' => $img_ids,
			'template_name' => 'gallery-slider',
			'swiper_hero_class' => '',
			'swiper_container_class' => '',
			'slides_per_view_xsmall' => 1,
			'slides_per_view_small' => 1,
			'slides_per_view_medium' => 1,
			'slides_per_view_large' => 1,
			'slides_per_view_xlarge' => 1,
			'prev_next' => 'true',
			'pagination' => 'true',
			'autoplay' => 'false',
			'loop' => 'true',
			'centered_slides_bounds' => 'false',
			'centered_slides' => 'false',
			'center_insufficient_slides' => 'false',
			'slides_offset_before' => 0,
			'slides_offset_after' => 0,
			'free_mode' => 'false'
		];

		canva_gallery_slider($atts);
		?>
	</div>
<?php endif; ?>
