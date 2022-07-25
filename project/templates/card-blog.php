<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}
?>

<a href="<?php echo get_permalink($post_id); ?>">

	<!-- Nuova card -->
	<article>
		<div class="_card _blog pb-4 group rounded-md overflow-hidden transform-gpu transition hover:-translate-y-2">
			<div class="_card-img _layer-wrap relative">

				<div class="_layer-visual relative ratio-3-2 rounded-md overflow-hidden">

					<div class="_layer-picture">
						<?php
						echo canva_get_img([
							'img_id'   =>  $post_id,
							'thumb_size' =>  '640-32',
							'img_class' =>  'transition transform-gpu group-hover:scale-105',
							'wrapper_class' =>  'rounded-md overflow-hidden',
						]);
						?>
					</div>

					<div class="_layer-info">
						<div class="_category-wrap absolute left-4 inline-block px-4 py-1 bg-secondary rounded-b">
							<?php echo canva_get_category($post_id, $taxonomy = 'category', $class = '_category-title block text-white fs-xs fw-300 mb-0', $parent = 'no', $term_link = 'no', $facet_url = '') ?>
						</div>
					</div>

				</div>

			</div>

			<div class="_card-info-wrap px-2 -mt-8 w-full">
				<div class="_card-info relative p-4 rounded-t-md bg-white text-center" style="z-index: 10;">
					<div class="_title-wrap flex h-16 items-center justify-center">
						<h2 class="_post-title h6 line-clamp-2">
							<?php echo get_the_title($post_id); ?>
						</h2>
					</div>

					<div class="_date fs-xs text-gray-500 py-2 border-t border-b border-gray-200">
						<?php echo get_the_date('d F Y', $post_id); ?>
					</div>

					<div class="_excerpt py-2">
						<p class="line-clamp-3 fs-sm">
							<?php echo canva_get_trimmed_post_content($post_id, $trim_words = 30); ?>
						</p>
					</div>

					<div class="_cta-wrap flex justify-center">
						<div class="_cta-discover w-24">
							<span class="">Scopri di più</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>

</a>
