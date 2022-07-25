<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}
?>

<a href="<?php echo get_permalink($post_id); ?>">
	<div class="_card-h _service group flex flex-wrap items-center p-4 rounded-lg bg-white border-2 border-gray-200 hover:bg-gray-50">
		<div class="_title-wrap flex items-center mr-4">
			<div class="_icon w-12 sm:w-16 mr-2 rounded-full bg-white">
				<?php
				if(get_field('featured_icon', $post_id)){
					echo canva_get_img([
						'img_id'   =>  get_field('featured_icon', $post_id),
						'thumb_size' =>  '160-11',
						'img_class' =>  '',
						'wrapper_class' =>  '',
					]);
				}else{
					echo canva_get_no_image($thumb_size = '160-11', $css_classes = '');
				}
				?>
			</div>
			<div class="flex-1">
				<h6 class="py-2 mb-0"><?php echo get_the_title($post_id); ?></h6>
			</div>
		</div>
		<div class="_cta-wrap flex-1 flex justify-end">
			<span class="_cta-discover">Scopri di più</span>
		</div>
	</div>
</a>
