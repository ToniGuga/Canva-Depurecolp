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
		<div class="_card _card-ch ">

			<?php
				echo canva_get_img([
					'img_id'   =>  $post_id,
					'thumb_size' =>  '640-32',
					'img_class' =>  '',
					'wrapper_class' =>  '_ch-figure rounded-md overflow-hidden mb-4',
				]);
			?>

			<div class="_title-wrap">
				<h3 class="_ch-title h4 mb-0 line-clamp-3">
					<?php echo get_the_title($post_id); ?>
				</h3>
			</div>

			<div class="_riassunto">
				<p class="line-clamp-5 fs-sm">
					<?php echo get_the_excerpt($post_id); ?>
				</p>
			</div>

		</div>

	</article>

</a>
