<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

$terms = get_the_terms($post_id, 'brand');
$first_term = $terms[0];

$terms_slug = [];
foreach ($terms as $term) {
	$terms_slug[] = $term->slug;
}

// echo $title;

?>

<a class="inline-modal-post-open" data-post-id="<?php echo esc_attr($slug); ?>" data-action-name="modal_post_opener" data-template-name="render-post-content" data-animation-in="" data-animation-out="" data-modal-delay="" data-modal-container-class="" href="#<?php echo esc_attr($slug); ?>">

	<div id="<?php echo esc_attr($slug); ?>" class="_card-h _store group flex justify-between rounded-md overflow-hidden bg-white border-2 border-gray-200 transition-colors hover:bg-gray-100 mb-4 <?php echo esc_attr(implode(', ', $terms_slug)); ?>">

		<div class="_wrap-left flex flex-1 p-4 flex-col items-start md:flex-row md:items-center">

			<div class="_logo w-32 mb-2 md:w-24 md:mb-0 md:pr-4 md:border-r md:border-gray-200 lg:w-32">

				<?php
				// var_dump($terms);

				foreach ($terms as $term) {
					echo canva_get_img([
						'img_id' => canva_get_term_logo_id($term),
						'img_type' => 'img', // img, bg, url
						'thumb_size' => '320-free',
						'wrapper_class' => 'bg-white rounded-sm p-1',
						'img_class' => '',
						'bg_content' => '',
						'caption' => 'off',
						'blazy' => 'on',
						'srcset' => 'off',
						'data_attr' => '',
						'width' => '',
						'height' => '',
					]);
				}

				?>
			</div>

			<div class="_info flex-1 md:p-2 md:pl-6">

				<h3 class="h7 mb-1">
					<?php echo $title; ?>
				</h3>

				<p><?php echo canva_get_trimmed_content($position_description, $trim_words = 30, $strip_blocks = false, $strip_shortcode = false); ?></p>

			</div>

		</div>

		<div class="_wrap-right w-5 min-h-full inline-flex items-center justify-center bg-gray-100 transition-colors group-hover:bg-gray-200">
			<?php echo canva_get_svg_icon('fontawesome/regular/chevron-right', 'text-gray-600 fill-current w-1'); ?>
		</div>

	</div>
</a>
<div class="hide _modal-id-<?php echo esc_attr($slug); ?>">
	<div class="_hr-container">
		<div class="_hr-content bg-white p-8 w-3/4">
			<h2>
				<?php echo $title; ?>
			</h2>

			<p>
				<?php echo $description; ?>
			</p>
		</div>
		<div class="_hr-application-form  bg-white p-8 w-3/4">
			<iframe class="b-lazy w-full" height="1800px" src="<?php echo esc_url($registration_iframe_url); ?>" frameborder="0" allowfullscreen></iframe>
		</div>
	</div>
</div>
