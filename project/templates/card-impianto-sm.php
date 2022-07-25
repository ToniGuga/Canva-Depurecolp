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
		<div class="_card _card-impianto h-full p-4 bg-gray-100 rounded-md transform-gpu transition hover:-translate-y-2">

			<div class="_title-wrap h-16 flex mb-2">
				<h2 class="_impianto-title font-primary underline fs-h5 mb-0 line-clamp-3">
					<?php echo get_the_title($post_id); ?>
				</h2>
			</div>

			<div class="_riassunto">
				<p class="line-clamp-5 fs-sm">
					<?php echo get_the_excerpt($post_id); ?>
				</p>
			</div>

		</div>

	</article>

</a>
