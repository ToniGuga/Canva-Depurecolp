<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (is_admin()) {
	// filtro che permette di sovrascrivere l'icona di questo blocco
	$default_icon = apply_filters('file_attachment_repeater_icon', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M528 288h-92.1l46.1-46.1c30.1-30.1 8.8-81.9-33.9-81.9h-64V48c0-26.5-21.5-48-48-48h-96c-26.5 0-48 21.5-48 48v112h-64c-42.6 0-64.2 51.7-33.9 81.9l46.1 46.1H48c-26.5 0-48 21.5-48 48v128c0 26.5 21.5 48 48 48h480c26.5 0 48-21.5 48-48V336c0-26.5-21.5-48-48-48zm-400-80h112V48h96v160h112L288 368 128 208zm400 256H48V336h140.1l65.9 65.9c18.8 18.8 49.1 18.7 67.9 0l65.9-65.9H528v128zm-88-64c0-13.3 10.7-24 24-24s24 10.7 24 24-10.7 24-24 24-24-10.7-24-24z"/></svg>'); ?>

	<div class="canva-wp-block canva-flex">

		<div class="_info canva-width-24 canva-p-4">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">File Allegati</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo $default_icon; ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="content canva-flex-1 canva-p-4">

			<?php if (have_rows('file_attachment_repeater')) {
				while (have_rows('file_attachment_repeater')) {
					the_row(); ?>

					<span class="canva-flex canva-align-middle canva-mt-0 canva-mb-2 canva-p-2 canva-font-theme canva-fs-h6 canva-fw-700 canva-lh-10 canva-bg-grey-lighter"><?php echo get_sub_field('title'); ?> - <a href="<?php echo get_sub_field('file'); ?>" target="_blank"><span class="canva-fw-300"> Link</span></a></span>

			<?php
				}
			} //endwhile enfid
			?>

		</div>

	</div>

<?php
} else { ?>
	<?php

	// Create id attribute allowing for custom "anchor" value.
	$id = $block['id'];
	if (!empty($block['anchor'])) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$className = '';
	if (!empty($block['className'])) {
		$className .= ' ' . $block['className'];
	}
	?>
	<?php if (have_rows('file_attachment_repeater')) { ?>

		<div id="<?php echo esc_attr($id); ?>" class="_file-attachment-repeater row sezione pt-0 align-center<?php echo esc_attr($className); ?>">

			<div class="column small-12">

				<?php while (have_rows('file_attachment_repeater')) {
					the_row(); ?>

					<?php

						// echo canva_get_action_link($class = 'attachment flex align-middle p-3 mb-2 fs-p color-body', $title = get_sub_field('title'), $url = get_sub_field('file'), $target = , $icon_name = 'download', $icon_type = '', $icon_class = 'width-8 mr-4 color-primary', $action_type = '');

						echo canva_get_action_link(
							[
								'url' => esc_url(get_sub_field('file')),
								'target' => '_blank',
								'button' => 'button', // classi pulsante
								'icon' => 'fontawesome/regular/download', // percorso tipo fontawesome fontawesome/regular/check
								'icon_css_classes' => 'width-8 mr-4 color-primary',
								'icon_right' => false,
								'toptitle' => '',
								'toptitle_css_classes' => '',
								'title' => esc_html(get_sub_field('title')),
								'title_css_classes' => '',
								'subtitle' => '',
								'subtitle_css_classes' => '',
							]
						);

					?>

				<?php
				} //endwhile
				?>

			</div>

		</div>

	<?php } //endif;
	?>

<?php }
