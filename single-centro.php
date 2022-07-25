<?php
// disattiva il json di default di yoast seo
// add_filter('wpseo_json_ld_output', '__return_false');

get_header();

$terms = get_the_terms(get_the_ID(), 'brand');

$first_term = $terms[0];
$first_term_id = $terms[0]->term_id;

$gallery_img_ids = [];

$term_featured_img = canva_get_term_featured_img_id($first_term);
$gallery_img_ids = canva_get_term_gallery_img_ids($first_term);

if (!empty($gallery_img_ids)) {
	array_push($gallery_img_ids, $term_featured_img);
	shuffle($gallery_img_ids);
} else {
	$gallery_img_ids[] = $term_featured_img;
}

// var_dump($gallery_img_ids);
?>


<?php
canva_the_layer([
	'layer_type' => '_hero', // _hero, _card, _photobutton
	'layer_id' => esc_attr($id),
	'layer_class' => 'flex-wrap rounded-b-xl' . esc_attr($className),

	'img_id' => esc_attr($gallery_img_ids[0]),
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


<div class="_white-container -mt-20">
	<div class="_row _white-container-row-main-title">
		<div class="_col _white-container-col-main-title">


			<!-- Apre container mx-w-lg per tutte le info Centro -->
			<div class="max-w-screen-lg mx-auto">

				<!--
				<?php
				$terms = get_the_terms(get_the_ID(), 'brand');
				foreach ($terms as $term) {
					echo canva_get_img([
						'img_id' => canva_get_term_logo_id($term),
						'img_type' => 'img', // img, bg, url
						'thumb_size' => '320-free',
						'wrapper_class' => 'bg-white rounded-sm p-1 w-32 mx-auto transform-gpu -translate-y-1/2',
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
				-->


				<h1 class="uppercase text-center">
					<span class="block h3 mb-1">Centro Dentistico</span>
					<span class="block h3 py-1 bg-secondary text-white" style="background-color: <?php echo canva_get_term_color($first_term); ?>">a <?php the_field('city'); ?></span>
				</h1>
				<p class="text-center lead"><?php echo get_field('address_full'); ?></p>

				<div class="_clinic-contacts mt-16 grid grid-cols-1 md:grid-cols-2 gap-4 lg:px-8">

					<?php if (get_field('email') && get_field('email') != ' ') { ?>
						<div class="_clinic-email">
							<div class="flex justify-center lg:justify-start">
								<div class="flex items-center flex-col lg:flex-row">
									<div class="_icon-wrap p-2">
										<div class="_icon w-14 h-14 p-1 text-body rounded-full bg-gray-200">
											<?php echo canva_get_svg_icon(MAIL_ICON, 'w-12 h-12 p-1 bg-white rounded-full'); ?>
										</div>
									</div>
									<div class="_info flex-1 p-2 text-center lg:text-left">
										<span class="_clinic-email block lh-11 fw-500 break-all">
											<a href="mailto:<?php echo get_field('email'); ?>"><?php echo get_field('email'); ?></a>
										</span>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if (get_field('tel') && get_field('tel') != ' ') { ?>
						<div class="_clinic-phone">
							<div class="flex justify-center lg:justify-start">
								<div class="flex items-center flex-col lg:flex-row">
									<div class="_icon-wrap p-2">
										<div class="_icon w-14 h-14 p-1 text-body rounded-full bg-gray-200">
											<?php echo canva_get_svg_icon(TEL_ICON, 'w-12 h-12 p-1 bg-white rounded-full'); ?>
										</div>
									</div>
									<div class="_info flex-1 p-2 text-center lg:text-left">
										<span class="_clinic-tel block lh-11 fw-500">
											<a href="tel:<?php echo get_field('tel'); ?>"><?php echo get_field('tel'); ?></a>
										</span>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

				</div>


				<div class="rounded-b-lg relative bg-secondary h-10 mt-16 mb-4" style="background-color: <?php echo canva_get_term_color($first_term); ?>">
					<div class="absolute w-16 h-16 left-1/2 bottom-2 transform-gpu -translate-x-1/2 bg-white rounded-full">
						<?php
							echo canva_get_img([
							'img_id' => '20428',
							'img_type' => 'img', // img, bg, url
							'thumb_size' => '320-free',
							'wrapper_class' => 'w-16 h-16 p-1 bg-white rounded-full',
							'img_class' => '',
							'bg_content' => '',
							'caption' => 'off',
							'blazy' => 'on',
							'srcset' => 'off',
							'data_attr' => '',
							'width' => '',
							'height' => '',
						]);
						?>
					</div>
				</div>


				<span class="block h5 text-center uppercase">
					Orari di apertura
				</span>


				<div class="_mon-wrap flex p-2 bg-gray-100 text-center items-center rounded-full">
					<div class="_day flex-1 uppercase h6 mb-0 font-medium">Lunedì</div>
					<div class="_hours flex-1 h6 mb-0 font-medium">
						<?php
						if (get_field('mon')) {
							echo get_field('mon');
						} else {
							echo '--';
						}
						?>
					</div>
				</div>
				<div class="_tue-wrap flex p-2 text-center items-center rounded-full">
					<div class="_day flex-1 uppercase h6 mb-0 font-medium">Martedì</div>
					<div class="_hours flex-1 h6 mb-0 font-medium">
						<?php
						if (get_field('tue')) {
							echo get_field('tue');
						} else {
							echo '--';
						}
						?>
					</div>
				</div>
				<div class="_wed-wrap flex p-2 bg-gray-100 text-center items-center rounded-full">
					<div class="_day flex-1 uppercase h6 mb-0 font-medium">Mercoledì</div>
					<div class="_hours flex-1 h6 mb-0 font-medium">
						<?php
						if (get_field('wed')) {
							echo get_field('wed');
						} else {
							echo '--';
						}
						?>
					</div>
				</div>
				<div class="_thu-wrap flex p-2 text-center items-center rounded-full">
					<div class="_day flex-1 uppercase h6 mb-0 font-medium">Giovedì</div>
					<div class="_hours flex-1 h6 mb-0 font-medium">
						<?php
						if (get_field('thu')) {
							echo get_field('thu');
						} else {
							echo '--';
						}
						?>
					</div>
				</div>
				<div class="_fri-wrap flex p-2 bg-gray-100 text-center items-center rounded-full">
					<div class="_day flex-1 uppercase h6 mb-0 font-medium">Venerdì</div>
					<div class="_hours flex-1 h6 mb-0 font-medium">
						<?php
						if (get_field('fri')) {
							echo get_field('fri');
						} else {
							echo '--';
						}
						?>
					</div>
				</div>
				<div class="_sat-wrap flex p-2 text-center items-center rounded-full">
					<div class="_day flex-1 uppercase h6 mb-0 font-medium">Sabato</div>
					<div class="_hours flex-1 h6 mb-0 font-medium">
						<?php
						if (get_field('sat')) {
							echo get_field('sat');
						} else {
							echo '--';
						}
						?>
					</div>
				</div>
				<div class="_sun-wrap flex p-2 bg-gray-100 text-center items-center rounded-full">
					<div class="_day flex-1 uppercase h6 mb-0 font-medium">Domenica</div>
					<div class="_hours flex-1 h6 mb-0 font-medium">
						<?php
						if (get_field('sun')) {
							echo get_field('sun');
						} else {
							echo '--';
						}
						?>
					</div>
				</div>


				<div class="_manager-staff mt-16 grid grid-cols-1 md:grid-cols-2 gap-4 lg:px-8">

					<?php if (get_field('director_doctor') && get_field('director_doctor') != ' ') { ?>
						<div class="_clinic-director-doctor">
							<div class="flex justify-center lg:justify-start">
								<div class="flex items-center flex-col lg:flex-row">
									<div class="_icon-wrap p-2">
										<div class="_icon w-14 h-14 p-1 text-body rounded-full bg-gray-200">
											<?php echo canva_get_svg_icon(DIRECTOR_DOCTOR_ICON, 'w-12 h-12 p-1 bg-white rounded-full'); ?>
										</div>
									</div>
									<div class="_info flex-1 p-2 text-center lg:text-left">
										<span class="block fs-xxs mb-0 font-300 lh-13 uppercase">Direttore Sanitario</span>
										<span class="block fw-400 lh-13"><?php echo get_field('director_doctor'); ?></span>
										<?php if (get_field('director_doctor_registry')) : ?>
											<span class="block fs-xxs fw-300 lh-13"><?php echo get_field('director_doctor_registry'); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if (get_field('clinic_manager') && get_field('clinic_manager') != ' ') { ?>
						<div class="_clinic-director-doctor">
							<div class="flex justify-center lg:justify-start">
								<div class="flex items-center flex-col lg:flex-row">
									<div class="_icon-wrap p-2">
										<div class="_icon w-14 h-14 p-1 text-body rounded-full bg-gray-200">
											<?php echo canva_get_svg_icon(CLINIC_MANAGER_ICON, 'w-12 h-12 p-1 bg-white rounded-full'); ?>
										</div>
									</div>
									<div class="_info flex-1 p-2 text-center lg:text-left">
										<span class="block fs-xxs mb-0 font-300 lh-13 uppercase">Clinic manager</span>
										<span class="block fw-400 lh-13"><?php echo get_field('clinic_manager'); ?></span>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

					<?php if (get_field('dentistry_manager') && get_field('dentistry_manager') != ' ') { ?>
						<div class="_clinic-dentistry-manager">
							<div class="flex justify-center lg:justify-start">
								<div class="flex items-center flex-col lg:flex-row">
									<div class="_icon-wrap p-2">
										<div class="_icon w-14 h-14 p-1 text-body rounded-full bg-gray-200">
											<?php echo canva_get_svg_icon(DENTISTRY_MANAGER_ICON, 'w-12 h-12 p-1 bg-white rounded-full'); ?>
										</div>
									</div>
									<div class="_info flex-1 p-2 text-center lg:text-left">
										<span class="block fs-xxs mb-0 font-300 lh-13 uppercase">Direttore Odontostomatologia</span>
										<span class="block fw-400 lh-13"><?php echo get_field('dentistry_manager'); ?></span>
										<?php if (get_field('dentistry_manager_registry')) : ?>
											<span class="block fs-xxs fw-300 lh-13"><?php echo get_field('dentistry_manager_registry'); ?></span>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>

				</div>


			<!-- Chiude container mx-w-lg per tutte le info Centro -->
			</div>

		</div>
	</div>
</div>


<!-- Mappa Google Maps -->
<div class="_centro-map-wrap relative">

	<div class="_centro-map-address px-4 w-full max-w-screen-md mx-auto absolute z-10 top-0 left-1/2 transform-gpu -translate-x-1/2 bg-secondary rounded-b-lg" style="background-color: <?php echo canva_get_term_color($first_term); ?>">
		<div class="_address-wrap flex items-center py-2 px-4 max-w-screen-sm mx-auto">
			<div class="_icon w-4 mr-4">
				<?php echo canva_get_svg_icon('fontawesome/light/map-marker-alt', 'text-white fill-current') ?>
			</div>
			<div class="_address flex-1 text-white lh-12">
				<?php echo get_field('address_full'); ?>
			</div>
		</div>
	</div>

	<div id="centroMap" class="_centro-map _google-maps w-full relative" data-lat="<?php echo get_field('latitude'); ?>" data-lng="<?php echo get_field('longitude'); ?>"></div>

</div>



<!-- Trattamenti in clinica -->
<div class="_block-white max-w-screen-xl mx-auto py-16">
	<div class="_row _block-white__row-main-title">
		<div class="_col _block-white__col-main-title text-center">
			<h3 class="uppercase">Trattamenti <br />Presenti in struttura</h3>
			<p class="max-w-screen-lg mx-auto">Centri Dentistici Primo e Caredent, presenti in Italia da oltre 10 anni, hanno dato vita ad un network pensato per <strong>mettere a tua disposizione più di 160 centri dentistici</strong>. L’obiettivo è quello di aiutarti a prenderti cura del tuo cavo orale con <strong>percorsi di prevenzione e cura pensati su misura per le tue esigenze</strong>, a prescindere dall’età.</p>
		</div>
	</div>
	<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-8 px-6">
		<?php canva_show_posts($post_type = 'servizio', $ids = '', $posts_per_page = -1, $random = 'no', $template_name = 'card-servizio'); ?>
	</div>
	<div class="_row justify-center mt-8">
		<div class="_col max-w-screen-sm text-center">
			<p class="">Per scoprire tutte le prestazioni disponibili e fissare il tuo appuntamento, puoi metterti in contatto con noi.</p>
			<a class="button" href="#richiedi-visita">Richiedi visita</a>
		</div>
	</div>
</div>

<!-- Form Hubspot prenota -->
<div id="richiedi-visita" class="_container-bt-form mb-8">
	<div class="_row">
		<div class="_col lg:w-1/2">
			<h2 class="has-text-align-left _title-main-bt-form">Prenota la tua visita dentistica</h2>
			<p>Compila il form: il nostro Servizio Pazienti ti chiamerà al numero indicato il prima possibile.</p>
			<?php echo canva_get_svg_icon('primo-icons/icon-prenotazioni-disegno-Primo-Centri-Dentistici', 'w-64') ?>
		</div>
		<div class="_col lg:w-1/2">
			<div class="_hubspot-form-centro">
				<?php echo canva_render_blocks(21979); ?>
			</div>
		</div>
	</div>
</div>


<!-- Card Centro Medico -->
<?php if (get_field('poliambulatorio')) : ?>
	<div class="_row max-w-screen-lg mx-auto mb-8">
		<div class="_centro-medico-wrap relative group flex flex-wrap w-full items-center justify-center px-4 py-2 md:px-8 md:py-6 rounded-lg bg-white border-2 border-gray-200">
			<div class="_title-wrap flex flex-1 mr-4">
				<div class="_icon w-12 sm:w-16 mr-4 rounded-full bg-white">
					<?php echo canva_get_svg_icon('primo-icons/icon-poliambulatorio-primo-centri-dentistici', ''); ?>
				</div>
				<div class="flex-1 mt-2 mb-2">
					<h6 class="uppercase mb-1">Questo centro è anche un poliambulatorio</h6>
					<p class="mb-0">Informati sulle nostre visite specialistiche</p>
				</div>
			</div>
			<div class="_cta-wrap inline-flex">
				<a class="button mt-2 mb-2" href="<?php echo esc_url(get_field('poliambulatorio_url')); ?>">Scopri i servizi</a>
			</div>
		</div>
	</div>
<?php endif; ?>




<!-- Pulsante telefona fixed -->
<?php if (get_field('tel')) : ?>
	<div class="_phone-fixed">
		<div class="js-toggle-class js-target-_phone-fixed js-class-open">
			<div class="_phone-fixed-icon">
			<?php echo canva_get_svg_icon(TEL_ICON, 'w-12 h-12'); ?>
			</div>
		</div>
		<a class="_phone-fixed-link" href="tel:<?php echo str_replace(' ', '', get_field('tel')); ?>">
			<span class="fs-xs fw-300 lh-10 mr-2">Chiama</span><?php the_field('tel'); ?>
		</a>
	</div>
<?php endif; ?>


<?php
get_footer();
