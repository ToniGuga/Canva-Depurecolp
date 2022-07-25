<?php
defined('ABSPATH') || exit;

$layer_content_output = '';

if($post_id){
	$post_id = $post_id;
}

canva_the_layer([
	'layer_type' => '_hero', // _hero, _card, _photobutton
	'layer_id' => esc_attr($post_id),
	'layer_class' => '' . esc_attr($className),

	'img_id' => get_post_thumbnail_id($post_id),
	'img_small_id' => '',
	'thumb_size' => '1920-free',
	'thumb_small_size' => '960-free',
	'video_url' => '',

	'layer_visual_class' => 'absolute w-full h-full',

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

	'layer_content' => 'off',
	'layer_content_class' => '',
	'layer_content_output' => $layer_content_output,
]);
?>

<div class="_white-container playlist -mt-20">

	<div class="_row _white-container-row-main-title">
		<div class="_col _white-container-col-main-title px-8">
			<div class="fs-sm mb-8">
				<?php echo canva_get_breadcrumbs(); ?>
			</div>
			<div class="inline-flex items-center px-8 py-2 rounded-r-full border border-gray-200">
				<?php echo canva_get_svg_icon('fontawesome/light/glasses-alt', 'text-secondary fill-current w-8 h-8 mr-4'); ?>
				<div class="flex-1">
					<span class="block fs-xxs text-gray-500 lh-11 mb-0"><?php _e('Tempo di lettura','canva-eqipe'); ?></span>
					<span class="reading-time block text-secondary lh-11 fw-500"></span>
				</div>
			</div>
		</div>
	</div>

	<div class="_row max-w-screen-lg lg:px-16 mx-auto">
		<div class="_col">

			<h1 class="_title h2 mb-12 uppercase text-center max-w-screen-md mx-auto">
				<?php echo get_the_title($post_id); ?>
			</h1>

			<div class="_article-wrap">
				<article>
					<?php echo get_the_content($post_id); ?>
				</article>
			</div>
		</div>
	</div>
</div>

<!-- Articoli correlati -->
<div class="_white-container max-w-screen-xl mx-auto py-16">
	<div class="_row _block-white__row-main-title">
		<div class="_col _block-white__col-main-title text-center">
			<h3 class="uppercase">I nostri consigli per te</h3>
			<p class="hidden max-w-screen-lg mx-auto">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
		</div>
	</div>
	<div class="grid mt-12 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
		<?php
		canva_posts_per_term($post_type = 'post', $taxonomy = '', $field_type = '', $terms = '', $template_name = 'card-blog', $posts_per_page = 3, $order = 'DESC', $orderby = 'rand', $facetwp = false);
		?>
	</div>
</div>
