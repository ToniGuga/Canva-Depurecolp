<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}
?>

<a href="<?php echo get_permalink($post_id); ?>">

	<!-- Link Impianto-->
	<article class="">
		<div class="_link-impianto transform-gpu transition hover:translate-x-2">

			<div class="_title-wrap flex">
				<h2 class="_impianto-title fs-h5 fw-700 mb-0 font-primary underline line-clamp-3">
					<?php echo get_the_title($post_id); ?>
				</h2>
			</div>

		</div>

	</article>

</a>
