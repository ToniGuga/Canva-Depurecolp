<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>
<div class="_faq-box">

	<?php
	$i = 1;
	foreach ($ids as $id) :
		$active = '';
		$hide = 'style="display: none;"';
		$row = $i++;

		if ($row == 1) {
			$active = '_active';
			$hide = '';
		}

	?>

		<div class="_faq-wrap border-t border-black _accordion <?php echo esc_attr($active); ?>">
			<div class="_faq-title-wrap flex items-center group transition-colors hover:bg-gray-100">
				<div class="_faq-title flex-1 py-8">
					<h3 class="mb-0 h5 cursor-pointer"><?php echo get_the_title($id); ?></h3>
				</div>
				<div class="_faq-icon flex items-center justify-center w-24 transform-gpu transition-transform group-hover:scale-110">
					<div class="_icon w-12 h-12 transform-gpu transition-transform">
						<img class="_icon-arrow-down" src="<?php echo canva_get_theme_img_url('eqipe-icons/chevron-arrow-down.svg'); ?>" alt="faq icon" />
					</div>
				</div>
			</div>

			<div class="_faq-content pt-4 pb-8 _accordion-content" <?php echo $hide; ?>>
				<?php echo get_field('content', $id); ?>
			</div>
		</div>

	<?php endforeach; ?>

</div>
