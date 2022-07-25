<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {
?>

	<div class="canva-wp-block canva-flex">

		<div class="_info canva-width-24 canva-p-4 canva-bg-grey-lighter">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Modal</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo apply_filters('faq_selector_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-faq-selector', null)); ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4 canva-bg-white">
			<?php
			$posts_object = get_field('post_object');

			if ($posts_object) :
			?>

				<?php foreach ($posts_object as $post_object) : ?>

					<h3 class="canva-flex canva-align-middle canva-mt-0 canva-mb-2 canva-p-2 canva-font-theme canva-fs-h5 canva-fw-700 canva-lh-10 canva-bg-grey-lighter">
						<?php echo get_the_title($post_object); ?>
					</h3>

					<a href="<?php echo get_edit_post_link($post_object); ?>" target="_blank"><?php _e('Modifica modale', 'canva-be'); ?></a>

				<?php endforeach; ?>

			<?php else : ?>

				<h3 class="canva-flex canva-align-middle canva-mt-0 canva-mb-2 canva-p-2 canva-font-theme canva-fs-h5 canva-fw-700 canva-lh-10 canva-bg-grey-lighter">
					<?php _e('Imposta la modale', 'canva-be'); ?>
				</h3>

			<?php endif; ?>

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

	$post_object = get_field('post_object');
	$post = get_post($post_object[0]);

	$toptitle = '';
	if (get_field('toptitle')) {
		$toptitle = get_field('toptitle');
	}

	$toptitle_css_classes = 'fw-300 mb-0';
	if (get_field('toptitle_css_classes')) {
		$toptitle_css_classes = get_field('toptitle_css_classes');
	}

	$title = '';
	if (get_field('title')) {
		$title = get_field('title');
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

	$template_name = 'data-template-name="render-post-content"';
	if (get_field('template_name')) {
		$template_name = 'data-template-name="' . esc_attr(get_field('template_name')) . '"';
	}

	$button = '';
	if (get_field('button_mode')) {
		$button = 'button';
	}

	$hollow = '';
	if (get_field('hollow_mode')) {
		$hollow = 'hollow';
	}

	$track_event = canva_get_ga_event_tracker('Modal', 'click', $post->post_name);

	$animation_in_css_classes = 'modal-in-from-bottom';
	if (get_field('animation_in_css_classes')) {
		$animation_in_css_classes = esc_attr(get_field('animation_in_css_classes'));
	}

	$animation_out_css_classes = 'modal-out-to-bottom';
	if (get_field('animation_out_css_classes')) {
		$animation_out_css_classes = esc_attr(get_field('animation_out_css_classes'));
	}

	$modal_container_css_classes = '';
	if (get_field('modal_container_css_classes')) {
		$modal_container_css_classes = esc_attr(get_field('modal_container_css_classes'));
	}

	$icon_css_classes = '';
	if (get_field('icon_css_classes')) {
		$icon_css_classes = esc_attr(get_field('icon_css_classes'));
	}

	$icon = get_field('icon');

	if ($icon) {
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

	$inline_mode = 'inline-modal-post-open';
	if (!get_field('inline_mode')) {
		$inline_mode = 'modal-post-open';
	}
?>

	<?php if ($post_object) { ?>

		<div class="<?php echo esc_attr(is_array($className) ? $parent_className : $className); ?> <?php echo esc_attr($alignment); ?>">

			<a id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($inline_mode); ?> inline-flex <?php echo esc_attr($button . ' ' . $hollow . ' ' . $icon_right); ?> <?php echo esc_attr($child_className); ?>" data-post-id="<?php echo esc_attr($post_object[0]); ?>" data-action-name="modal_post_opener" <?php echo esc_attr($template_name); ?> data-animation-in="<?php echo esc_attr($animation_in_css_classes); ?>" data-animation-out="<?php echo esc_attr($animation_out_css_classes); ?>" data-modal-container-class="<?php echo esc_attr($modal_container_css_classes); ?>" href="<?php echo get_the_permalink($post); ?>" <?php echo $track_event; ?>>

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

					<?php if ($title) { ?>
						<span class="title <?php echo esc_attr($title_css_classes); ?>">
							<?php echo $title; ?>
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

		<?php if (get_field('inline_mode')) : ?>
			<div class="hide <?php echo esc_attr('_modal-id-' . $post_object[0]); ?>">
				<div>
					<?php canva_render_blocks($post_object[0]) ?>
				</div>
			</div>
		<?php endif; ?>

<?php
	}
}
