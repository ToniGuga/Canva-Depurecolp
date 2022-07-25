<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

// echo $clinic_id;

$post = get_posts(array(
	'post_status' => array('publish'),
	'posts_per_page'	=> 1,
	'post_type'		=> 'centro',
	'meta_key'		=> 'id',
	'meta_value'	=> intval($clinic_id)
));

$clinic_post_id = $post[0]->ID;

$term = get_term_by('slug', $open_day_type, 'open_day_types');
$term_featured_img = canva_get_term_featured_img_id($term);

$terms = get_the_terms($clinic_post_id, 'brand');
$first_term = $terms[0];

$term_color = canva_get_term_color($first_term);
$term_color_2 = canva_get_term_color_secondary($first_term);

$d = wp_date('d', strtotime($date));
$m = wp_date('F', strtotime($date));

$layer_content_output = '
<div class="bg-white rounded-md p-1">
<div class="relative w-32 h-32 p-4 pt-2 border-2 rounded flex flex-col justify-center items-center" style="border-color: ' . $term_color_2 . '">
	<span class="_day-number block fs-huge fw-500 text-secondary lh-10" style="color: ' . $term_color_2 . '">' . $d . '</span>
	<span class="_month block uppercase fs-sm text-secondary lh-10 fw-400" style="color: ' . $term_color_2 . '">' . $m . '</span>
</div>
</div>';

// var_dump($gallery_img_ids);
canva_the_layer([
	'layer_type' => '_hero', // _hero, _card, _photobutton
	'layer_id' => esc_attr($id),
	'layer_class' => 'flex-wrap rounded-b-xl' . esc_attr($className),

	'img_id' => esc_attr($term_featured_img),
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
	'layer_content_class' => 'relative flex flex-wrap items-center justify-end max-w-screen-xl mx-auto w-full px-4',
	'layer_content_output' => $layer_content_output,
]);

?>

<div class="max-w-screen-xl mx-auto px-4">
	<div class="wp-block-columns flex flex-wrap relative mt-4 md:-mt-24 z-20 bg-white py-8 px-0 rounded-t-xl">

		<div class="_col max-w-screen-lg mx-auto">

			<div class="_open-day-main-info-wrap mb-8">
				<h1 class="h2 has-text-align-center mb-2">
					<span class="block mb-2 uppercase">Open Day</span>
					<span class="block mb-4 fw-500 text-white uppercase pt-2 pr-8 pb-2 pl-8" style="background-color: <?php echo canva_get_term_color($first_term); ?>">
						<?php echo str_replace('_', ' ', $open_day_type); ?>
					</span>
					<span class="block text-center lead fw-300">
						<?php echo get_field('address_number', $clinic_post_id); ?>, <?php echo get_field('city', $clinic_post_id); ?>
					</span>
				</h1>
			</div>

		</div>

		<div class="_col">
			<div class="open_day_type_description mb-16">
				<p>
					<?php echo $open_day_type_description; ?>
				</p>
			</div>
		</div>

	</div>
</div>


<!-- Form Hubspot prenota -->
<div id="richiedi-visita" class="_container-bt-form mb-8">
	<div class="_row">
		<div class="_col lg:w-1/2">
			<h2 class="has-text-align-left _title-main-bt-form">Iscriviti all'open day <br /><?php echo str_replace('_', ' ', $open_day_type); ?></h2>
			<p>Un nostro operatore ti rincontatterà per <br> <strong>confermare la prenotazione</strong></p>
			<?php echo canva_get_svg_icon('primo-icons/icon-prenotazioni-disegno-Primo-Centri-Dentistici', 'w-64') ?>
		</div>
		<div class="_col lg:w-1/2">
			<div class="_hubspot-form-centro">

				<!--[if lte IE 8]>
					<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2-legacy.js"></script>
				<![endif]-->
				<script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/v2.js"></script>
				<script>
					setTimeout(() => {
						hbspt.forms.create({
							region: "na1",
							portalId: "20340524",
							formId: "1504148a-fcdc-47a0-a60c-4bf4afc82754",

							onFormReady: function($form) {
								$('input[name="nome_open_day"]').val('<?php echo str_replace('_', ' ', $open_day_type); ?> - <?php echo $date; ?>').change();
								$('input[name="tutte_le_cliniche"]').val('<?php echo get_field('name', $clinic_post_id); ?>').change();
							}
						});
					}, 1000);
				</script>

			</div>
		</div>
	</div>
</div>

<!-- Articoli Blog -->
<div id="block_618c2fd23dd0d" class="_white-container  mt-8">
	<div class="wp-block-columns _white-container-row-main-title pb-0">
		<div class="wp-block-column _white-container-col-main-title">
			<h2 class="has-text-align-center _title-main-bt-white-basic">I nostri consigli per te</h2>
		</div>
	</div>

	<div class="wp-block-columns _row-description-bt-white-basic">
		<div class="wp-block-column _col-description-bt-white-basic">
			<p>Sul portale di Centri Dentistici Primo e Caredent troverai numerosi consigli, pensati per aiutarti a comprendere al meglio il mondo dell’odontoiatria. <strong>A tua disposizione avrai molte informazioni</strong>, aggiornate su base mensile, per poter comprendere un po’ meglio come prenderti cura del tuo sorriso, anche a casa.</p>
		</div>
	</div>

	<div class="wp-block-columns _row-description-bt-white-basic">
		<div class="wp-block-column _col-description-bt-white-basic">

			<div id="block_618c302f3dd0f" class="post-per-term-selector grid grid-cols-1 md:grid-cols-3 gap-4">
				<?php

				// per ortodonzia trasparente far vedere: ortodonzia, estetica dentale,
				// per chirurgia far vedere: iplantologia, protesi dentali
				// per bambini: odontoiatria pediatrica

				echo canva_get_posts_per_term(
					$post_type = 'post',
					$taxonomy = 'category',
					$field_type = 'slug',
					$terms = ['conservativa', 'odontoiatria', 'ortodonzia', 'endodonzia'],
					$template_name = 'card-blog',
					$posts_per_page = 3,
					$order = 'DESC',
					$orderby = 'rand',
					$facetwp = false
				);
				?>
			</div>

		</div>
	</div>
</div>
