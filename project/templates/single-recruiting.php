<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

switch ($recruiting_type) {
	case 'odontoiatria':
		$img_id = get_field('odontoiatria', $post_id);
		break;

	case 'hq':
		$img_id = get_field('hr_hq', $post_id);
		break;

	case 'medici':
		$img_id = get_field('hr_medici', $post_id);
		break;

	default:
		$img_id = get_post_thumbnail_id($post_id);
}

// var_dump($gallery_img_ids);

canva_the_layer([
	'layer_type' => '_hero', // _hero, _card, _photobutton
	'layer_id' => esc_attr($img_id),
	'layer_class' => 'flex-wrap rounded-b-xl',

	'img_id' => 23358,
	'img_small_id' => '',
	'thumb_size' => '1920-free',
	'thumb_small_size' => '960-free',
	'video_url' => '',

	'layer_visual_class' => 'absolute w-full md:h-auto',

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
	'layer_content_class' => 'relative flex flex-wrap items-start max-w-screen-xl mx-auto w-full px-4',
	'layer_content_output' => $layer_content_output,
]);

?>

<div id="block_616cb4328a809" class="_white-container max-w-screen-xl mx-auto" style="min-height: 100vh;">
	<div class="wp-block-columns flex flex-wrap relative -mt-24 z-20 bg-white py-4 px-0 rounded-t-xl">
		<div class="wp-block-column w-full">

			<div class="flex justify-center mb-8">
				<h1 class="h2 has-text-align-center uppercase mb-2 w-3/4">
					<span class="block mb-2"><?php echo $function; ?></span>
					<span class="block mb-4 fw-500 text-white uppercase pt-2 pr-8 pb-2 pl-8" style="background-color: #aa89be">
						<?php echo $city; ?>
					</span>
				</h1>
			</div>

			<div class="_description max-w-screen-lg mx-auto mb-16">

				<?php if ($company_description) { ?>
					<div class="_title-wrap flex items-center mt-8 mb-4">
						<div class="_icon w-16 mr-2 rounded-full bg-white">
							<figure class="" style="" data-url="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-descrizione-azienda-Primo-Centri-Dentistici.svg" data-size="100%x100%">
								<img class="b-lazy" src="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-descrizione-azienda-Primo-Centri-Dentistici.svg" alt="Icon Azienda" width="100%" height="100%">
								<figcaption class="image-caption block"></figcaption>
							</figure>
						</div>
						<div class="flex-1">
							<h4 class="mb-0 text-secondary uppercase">Descrizione azienda</h4>
						</div>
					</div>

					<p>
						<?php echo $company_description; ?>
					</p>
				<?php } ?>

				<?php if ($position_description) { ?>
					<div class="_title-wrap flex items-center mt-8 mb-4">
						<div class="_icon w-16 mr-2 rounded-full bg-white">
							<figure class="" style="" data-url="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-posizione-Primo-Centri-Dentistici.svg" data-size="100%x100%">
								<img class="b-lazy" src="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-posizione-Primo-Centri-Dentistici.svg" alt="Icon Posizione" width="100%" height="100%">
								<figcaption class="image-caption block"></figcaption>
							</figure>
						</div>
						<div class="flex-1">
							<h4 class="mb-0 text-secondary uppercase">Posizione</h4>
						</div>
					</div>

					<p>
						<?php echo $position_description; ?>
					</p>
				<?php } ?>

				<?php if ($position_description) { ?>
					<div class="_title-wrap flex items-center mt-8 mb-4">
						<div class="_icon w-16 mr-2 rounded-full bg-white">
							<figure class="" style="" data-url="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-requisiti-Primo-Centri-Dentistici.svg" data-size="100%x100%">
								<img class="b-lazy" src="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-requisiti-Primo-Centri-Dentistici.svg" alt="Icon Posizione" width="100%" height="100%">
								<figcaption class="image-caption block"></figcaption>
							</figure>
						</div>
						<div class="flex-1">
							<h4 class="mb-0 text-secondary uppercase">Requisiti</h4>
						</div>
					</div>

					<p>
						<?php echo $requirements_description; ?>
					</p>
				<?php } ?>

				<?php if ($other_information_description) { ?>
					<div class="_title-wrap flex items-center mt-8 mb-4">
						<div class="_icon w-16 mr-2 rounded-full bg-white">
							<figure class="" style="" data-url="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-cosa-offriamo-Primo-Centri-Dentistici.svg" data-size="100%x100%">
								<img class="b-lazy" src="https://www.centridentisticiprimo.it/wp-content/uploads/2022/03/icon-cosa-offriamo-Primo-Centri-Dentistici.svg" alt="Icon Posizione" width="100%" height="100%">
								<figcaption class="image-caption block"></figcaption>
							</figure>
						</div>
						<div class="flex-1">
							<h4 class="mb-0 text-secondary uppercase">Cosa offriamo</h4>
						</div>
					</div>

					<p>
						<?php echo $other_information_description; ?>
					</p>
				<?php } ?>

			</div>

			<?php if ($registration_iframe_url) { ?>

				<div class="_recruiting-application flex mt-8">

					<div class="w-full">
						<h3 class="uppercase mb-8">Applica ora</h3>

						<div class="_recruiting-application-form bg-white">
							<iframe class="b-lazy w-full" height="2600px" src="<?php echo esc_url($registration_iframe_url); ?>" frameborder="0" allowfullscreen></iframe>
						</div>

					</div>

				</div>

			<?php } ?>

		</div>
	</div>
</div>
