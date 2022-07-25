<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

	// filtro che permette di sovrascrivere l'icona di questo blocco
	$default_icon = apply_filters('action_link_icon', canva_get_svg_icon('fontawesome/regular/link'));

	$action_link = get_field('action_link');

	if ($action_link && '_blank' === $action_link['target']) {
		$target_link = 'target="' . esc_attr($action_link['target']) . ' rel="noopener nofollower"';
	}
?>

	<div class="canva-flex canva-wp-block">

		<div class="info canva-width-24 canva-p-4 canva-bg-grey-lightest">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Action Link</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo $default_icon; ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="content canva-flex-1 canva-p-4 canva-bg-white">
			<?php if ($action_link) { ?>
				<a id="<?php echo esc_attr($id); ?>" class="button block<?php echo esc_attr($className); ?>" href="<?php echo esc_url($action_link['url']); ?>" <?php echo $target_link; ?>><?php echo esc_html($action_link['title']); ?></a>
			<?php } else { ?>
				<?php _e('Imposta il pulsante cliccando sull\'icona della matita', 'canva-backend'); ?>
			<?php } ?>
		</div>

	</div>

<?php
} else {

	// Create id attribute allowing for custom "anchor" value.
	$id = $block['id'];
	if (!empty($block['anchor'])) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "className" and "align" values.
	$className = '';
	if (!empty($block['className'])) {
		if (false !== strpos($block['className'], '|')) {
			$className = explode('|', $block['className']);
		} else {
			$className = $block['className'];
		}

		$parent_className = '';
		$child_className = '';
		if (is_array($className)) {
			$parent_className = $className[0];
			$child_className = $className[1];
		}
	}

	// manage alignment
	if (!empty($block['align_text'])) {
		$alignment .= 'text-' . $block['align_text'];
	}

	$action_link = get_field('action_link');

	if ($action_link && '_blank' === $action_link['target']) {
		$target_link = 'target="' . esc_attr($action_link['target']) . '" rel="noopener nofollower"';
	}

	$slug = wp_basename($action_link['url']);
	$track_event = canva_get_ga_event_tracker('Action-Link', 'click', $slug);

	$button_mode = get_field('button_mode');

	if (isset($button_mode)) {
		$button = '';
		if (get_field('button_mode')) {
			$button = 'button inline-block';
		}
	} else {
		$button = 'button inline-block';
	}

	$hollow = '';
	if (get_field('hollow_mode')) {
		$hollow = 'hollow';
	}

	$modal_class = '';
	$modal_data_contet = '';
	if (get_field('modal')) {
		$modal_class = 'modal-open';
		$modal_data_contet = 'data-modal-content="' . esc_attr($id) . '"';
	}

	$toptitle = '';
	if (get_field('toptitle')) {
		$toptitle = get_field('toptitle');
	}

	$toptitle_css_classes = 'fw-300 mb-0';
	if (get_field('toptitle_css_classes')) {
		$toptitle_css_classes = get_field('toptitle_css_classes');
	}

	$modal_title = '';
	if (get_field('title')) {
		$modal_title = get_field('title');
	}

	$title_css_classes = '';
	if (get_field('title_css_classes')) {
		$title_css_classes = get_field('title_css_classes');
	}

	$subtitle = '';
	if (get_field('subtitle')) {
		$subtitle = get_field('subtitle');
	}

	$subtitle_css_classes = '';
	if (get_field('subtitle_css_classes')) {
		$subtitle_css_classes = get_field('subtitle_css_classes');
	}

	$icon_css_classes = '';
	if (get_field('icon_css_classes')) {
		$icon_css_classes = esc_attr(get_field('icon_css_classes'));
	}

	$icon = get_field('icon');

	if($icon){
		$icon_src = canva_get_svg_icon_from_url(wp_get_attachment_url($icon), 'icon ' . $icon_css_classes);
	}

	$icon_right = '';
	if (get_field('icon_right')) {
		$icon_right = 'flex-row-reverse';
	}

	$text_align = '';
	if ($icon && $icon_right) {
		$text_align = 'text-right';
	} elseif ($icon && !$icon_right) {
		$text_align = 'text-left';
	}

?>

	<?php if ($action_link) { ?>

		<div class="<?php echo esc_attr(is_array($className) ? $parent_className : $className); ?> <?php echo esc_attr($alignment); ?>">

			<a id="<?php echo esc_attr($id); ?>" class="inline-flex <?php echo esc_attr($button . ' ' . $hollow . ' ' . $icon_right . ' ' . $child_className); ?>" href="<?php echo esc_url($action_link['url']); ?>" <?php echo $target_link . ' ' . $track_event; ?>>

				<?php
				if ($icon) {
					echo $icon_src;
				}
				?>

				<div class="<?php echo esc_attr('text-wrapper' . ' ' . $text_align); ?>">
					<?php if ($toptitle) { ?>
						<span class="toptitle <?php echo esc_attr($toptitle_css_classes); ?>">
							<?php echo $toptitle ?>
						</span>
					<?php } ?>

					<?php if ($action_link['title']) { ?>
						<span class="title">
							<?php echo esc_html($action_link['title']); ?>
						</span>
					<?php } ?>

					<?php if ($subtitle) { ?>
						<span class="subtitle <?php echo esc_attr($subtitle_css_classes); ?>">
							<?php echo $subtitle; ?>
						</span>
					<?php } ?>
				</div>

			</a>

		</div>

		<!-- <div class="<?php echo esc_attr($alignment); ?>">
			<a id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className . ' ' . $button . ' ' . $hollow . ' ' . $modal_class); ?>" href="<?php echo esc_url($action_link['url']); ?>" <?php echo $target_link . ' ' . $track_event . ' ' . $modal_data_contet; ?>>
				<?php echo esc_html($action_link['title']); ?>
			</a>
		</div> -->

		<?php if (get_field('modal')) : ?>

			<?php if (get_field('modal_content') === 'modal_content_html') : ?>

				<div class="hide <?php echo esc_attr($id); ?>">
					<?php echo get_field('wysiwyg', false, false); ?>
				</div>

			<?php else : ?>

				<div class="hide <?php echo esc_attr($id); ?>">
					<?php
					echo get_field('post_object')->post_content;
					?>
				</div>

			<?php endif; ?>

		<?php endif; ?>

<?php
	}
}
