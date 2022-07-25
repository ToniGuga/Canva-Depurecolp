<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}
?>

<a href="<?php echo get_permalink($post_id); ?>">

	<!-- Card Impianto-->
	<article class="h-full">
		<div class="_card _card-settore-sm transition duration-slow bg-transparent rounded-md hover:bg-gray-100 p-4">

			<?php
				echo canva_get_img([
					'img_id'   =>  $post_id,
					'thumb_size' =>  '640-11',
					'img_class' =>  '',
					'wrapper_class' =>  'w-12 xl:w-16 mb-4',
				]);
			?>

			<div class="_title-wrap">
				<h2 class="_settore-title font-primary fs-xs mb-0 line-clamp-3">
					<?php echo get_the_title($post_id); ?>
				</h2>
			</div>

		</div>

	</article>

</a>
