<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}
?>

<a href="<?php echo get_permalink($post_id); ?>">
	<div class="_card-h _service group p-4 rounded-lg bg-white shadow-md hover:shadow-xl transition-shadow">
		<div class="_title-wrap flex items-center mr-4 mb-4">
			<div class="_icon w-12 mr-2 rounded-full bg-white">
				<?php
				echo canva_get_img([
					'img_id'   =>  get_field('featured_icon', $post_id),
					'thumb_size' =>  '160-11',
					'img_class' =>  '',
					'wrapper_class' =>  '',
				]);
				?>
			</div>
			<div class="flex-1">
				<h5 class="mb-0"><?php echo get_the_title($post_id); ?></h5>
			</div>
		</div>
		<div class="_abstract-wrap flex mb-6">
			<p class=""><?php echo get_the_excerpt($post_id); ?></p>
		</div>
		<div class="_cta-wrap flex justify-end">
			<span class="h7 mb-0 pb-0.5 hover:pb-1 uppercase font-medium text-secondary border-b-8 border-primary">Scopri di più</span>
		</div>
	</div>
</a>
