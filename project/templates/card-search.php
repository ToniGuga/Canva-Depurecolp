<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

$post = get_post($post_id);
?>

<a class="mb-4" href="<?php echo get_permalink($post_id); ?>">

	<div class="_card _card-search pb-4 group flex flex-wrap">

		<div class="_card-img _layer-wrap relative w-full lg:w-1/4">

			<div class="_layer-visual relative ratio-16-9">

				<div class="_layer-picture">
					<?php
					if(has_post_thumbnail($post_id)){
						echo canva_get_img([
							'img_id'   =>  $post_id,
							'thumb_size' =>  '640-free',
							'img_class' =>  'transition object-contain object-center duration-slow transform-gpu group-hover:scale-105',
							'wrapper_class' =>  'overflow-hidden',
						]);
					}else{
						echo canva_get_no_image();
					}
					?>
				</div>

			</div>

		</div>


		<div class="_card-info-wrap flex items-center w-full lg:w-3/4 min-h-full">

			<div class="_card-info py-6 px-2 lg:px-6">

				<h2 class="_post-title fs-h3 md:fs-h2 mb-0">
					<span class="block line-clamp-2 mb-2"><?php echo get_the_title($post_id); ?></span>
				</h2>

				<div class="_excerpt">
					<p class="line-clamp-3 fs-p">
						<?php //echo canva_get_trimmed_post_content($post_id, $trim_words = 20); ?>
						<?php echo canva_get_trimmed_content($post->post_content, $trim_words = 20, $strip_blocks = false, $strip_shortcode = true); ?>
					</p>
				</div>

			</div>

		</div>
	</div>

</a>
