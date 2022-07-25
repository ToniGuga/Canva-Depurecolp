<?php
if (!$post_id) {
	$post_id = get_the_ID();
}

$layer_content_output = '
<div class="_content-wrap flex h-full flex-col justify-center py-12 px-default-section text-center isdark">
	<h1 class="_title h2">
		<span class="block mb-4">'.get_the_title($post_id).'</span>
		<span class="block subtitle fw-300 fs-h3 max-w-48ch mx-auto">'.get_field('subtitle').'</span>
	</h1>
</div>';
?>

<!--
<div class="py-4 px-default-section">
	<div class="max-w-screen-xxl mx-auto text-center">
		<div class="fs-sm mb-0">
			<?php echo canva_get_breadcrumbs(); ?>
		</div>
	</div>
</div>
-->


<?php
canva_the_layer([
	'layer_type' => '_hero', // _hero, _card, _photobutton
	'layer_id' => esc_attr($post_id),
	'layer_class' => ''.esc_attr($className),

	'img_id' => get_post_thumbnail_id($post_id),
	'img_small_id' => '',
	'thumb_size' => '1920-free',
	'thumb_small_size' => '960-free',
	'video_url' => '',

	'layer_visual_class' => 'absolute',

	'layer_bg' => 'on',
	'layer_bg_class' => 'bg-cover bg-center',

	'layer_picture' => 'off',
	'layer_picture_class' => '',

	'layer_filter' => 'off',
	'layer_filter_class' => '',

	'layer_graphics' => 'off',
	'layer_graphics_class' => '',

	'layer_date' => 'off',
	'layer_date_class' => '',

	'layer_status' => 'off',
	'layer_status_class' => '',

	'layer_info' => 'off',
	'layer_info_class' => '',

	'layer_content' => 'on',
	'layer_content_class' => 'relative w-full',
	'layer_content_output' => $layer_content_output,
]); ?>




<!-- Contenuto articolo -->
<div class="_article-wrap pb-16">
	<article>
		<?php the_content(); ?>
	</article>
</div>



<!-- Articoli correlati -->
<div class="_related-posts bg-black pt-16 pb-16 px-default-section">
	<div class="max-w-screen-xxl mx-auto">
		<div class="text-center mb-16">
			<h2 class="fs-h3 text-white mb-16" id="journal-highlights" style="text-transform:uppercase">Journal <span class="font-secondary">Highlights</span></h2>
			<p class="hidden max-w-screen-lg mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		</div>
	</div>
	<div class="max-w-screen-xxl mx-auto grid mt-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
		<?php
		canva_posts_per_term($post_type = 'post', $taxonomy = '', $field_type = '', $terms = '', $template_name = 'card-blog-isdark', $posts_per_page = 3, $order = 'DESC', $orderby = 'rand', $facetwp = false); ?>
	</div>
</div>
