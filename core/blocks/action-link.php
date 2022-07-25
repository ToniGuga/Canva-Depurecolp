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

	<div class="canva-wp-block">

		<div class="canva-flex ">

			<div class="_info canva-width-16 canva-p-2 canva-bg-grey-lightest">
				<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Action Link</span>
				<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
				<figure class="canva-width-8 canva-m-0">

					<!-- ICONA -->
					<?php echo $default_icon; ?>
					<!-- Fine Icona -->

				</figure>
			</div>

			<div class="_content canva-flex-1 canva-p-4 canva-bg-white">
				<?php if ($action_link) { ?>
					<a id="<?php echo esc_attr($id); ?>" class="button block camva-fs-h4<?php echo esc_attr($className); ?>" href="<?php echo esc_url($action_link['url']); ?>" <?php echo $target_link; ?>><?php echo esc_html($action_link['title']); ?></a>
				<?php } else { ?>
					<span class="canva-block canva-fs-xsmall canva-lh-11">
						<?php _e('Imposta il pulsante cliccando sull\'icona della matita', 'canva-backend'); ?>
					</span>
				<?php } ?>
			</div>

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

	if ($action_link) {
		$slug = wp_basename($action_link['url']);
		$track_event = canva_get_ga_event_tracker('Action-Link', 'click', $slug);
	}

	if ($action_link && '_blank' === $action_link['target']) {
		$target_link = 'target="' . esc_attr($action_link['target']) . '" rel="noopener nofollower"';
	}

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

	$full_width_mode = '';
	if (get_field('full_width_mode')) {
		$full_width_mode = 'w-full';
	}

	if ($action_link) :
?>

		<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr(is_array($className) ? $parent_className : $className); ?> <?php echo esc_attr($alignment); ?>">

			<?php
			echo canva_get_action_link(
				[
					'url' => esc_url($action_link['url']),
					'target' => $target_link,
					'button' => esc_attr($button . ' ' . $hollow . ' ' . $full_width_mode . ' ' . $child_className),
					'icon' => intval(get_field('icon')), // percorso tipo fontawesome fontawesome/regular/check
					'icon_css_classes' => esc_attr(get_field('icon_css_classes')),
					'icon_right' => get_field('icon_right'),
					'toptitle' => get_field('toptitle'),
					'toptitle_css_classes' => esc_attr(get_field('toptitle_css_classes')),
					'title' => esc_html($action_link['title']),
					'title_css_classes' => esc_attr(get_field('title_css_classes')),
					'subtitle' => esc_html(get_field('subtitle')),
					'subtitle_css_classes' => esc_attr(get_field('subtitle_css_classes')),
				]
			);
			?>

		</div>

<?php
	endif;
}
