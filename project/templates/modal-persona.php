<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}
?>

<div class="_persona-large-clip md:p-16 bg-white p-8 shadow grid grid-cols-1 gap-8">
	<div class="_persona-main-grid grid grid-cols-1 lg:grid-cols-2 gap-8">
		<div class="_persona-img-col w-full -mt-8">
			<?php
			if(has_post_thumbnail($post_id)){
				echo canva_get_img([
					'img_id'   =>  get_post_thumbnail_id($post_id),
					'thumb_size' =>  '640-11',
					'img_class' =>  '',
					'wrapper_class' =>  'rounded-t-md overflow-hidden border-b-2 border-white',
					'blazy' => 'on'
				]);
			}else{
				echo canva_get_svg_icon('fontawesome/regular/image', 'icon');
			}
			?>
			<div class="bg-secondary rounded-b-md p-4 text-center">
				<h3 class="mb-0">
					<span class="_title h4 mb-1 text-white"><?php echo get_field('nickname', $post_id) . ' ' . get_field('first_name', $post_id) . ' ' . get_field('last_name', $post_id); ?></span>
					<?php if (get_field('qualification', $post_id)) : ?>
						<span class="_subtitle h6 mb-0 text-white"><?php echo get_field('qualification', $post_id); ?></span>
					<?php endif; ?>
				</h3>
			</div>
		</div>

		<div class="_persona-description-col w-full">
			<?php if (get_field('qualification', $post_id)) : ?>
				<p class="toptitle uppercase"><?php echo get_field('qualification', $post_id); ?></p>
			<?php endif; ?>

				<h3>
					<span class="_title block h4 mb-1"><?php echo get_field('nickname', $post_id) . ' ' . get_field('first_name', $post_id) . ' ' . get_field('last_name', $post_id); ?></span>
					<?php if ( get_field('quote', $post_id) ) : ?>
						<span class="_subtitle block h6"><?php echo get_field('quote', $post_id); ?></span>
					<?php endif; ?>

				</h3>

				<?php if ( get_field('biography', $post_id) ) : ?>
					<p><?php echo get_field('biography', $post_id); ?></p>
				<?php endif; ?>

		</div>
	</div>
</div>
