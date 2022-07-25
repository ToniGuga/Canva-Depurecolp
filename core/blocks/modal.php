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
	$alignment = '';
	if (!empty($block['align_text'])) {
		$alignment .= 'text-' . $block['align_text'];
	}

	$post_object = get_field('post_object');
	$post = get_post($post_object[0]);

	$button = '';
	if (get_field('button_mode')) {
		$button = 'button';
	}

	$hollow = '';
	if (get_field('hollow_mode')) {
		$hollow = 'hollow';
	}

	$full_width_mode = '';
	if (get_field('full_width_mode')) {
		$full_width_mode = 'w-full';
	}

	$inline_mode = get_field('inline_mode');

	if ($post_object) :
?>

		<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr(is_array($className) ? $parent_className : $className); ?> <?php echo esc_attr($alignment); ?>">

			<?php
			echo canva_get_modal(
				[
					'post_id' => intval($post_object[0]),
					'inline_mode' => intval(get_field('inline_mode')),
					'round_expansion_mode' => intval(get_field('round_expansion_mode')),
					'button' => esc_attr($button . ' ' . $hollow . ' ' . $full_width_mode . ' '  . $child_className),
					'template_name' => 'render-post-content',
					'animation_in' => esc_attr(get_field('animation_in_css_classes')),
					'animation_out' => esc_attr(get_field('animation_out_css_classes')),
					'modal_delay' => esc_attr(get_field('modal_delay')),
					'modal_container' => esc_attr(get_field('modal_container_css_classes')),
					'icon' => intval(get_field('icon')), // percorso tipo fontawesome fontawesome/regular/check
					'icon_css_classes' => esc_attr(get_field('icon_css_classes')),
					'icon_right' => get_field('icon_right'),
					'toptitle' => esc_html(get_field('toptitle')),
					'toptitle_css_classes' => esc_attr(get_field('toptitle_css_classes')),
					'title' => esc_html(get_field('title')),
					'title_css_classes' => esc_attr(get_field('title_css_classes')),
					'subtitle' => esc_html(get_field('subtitle')),
					'subtitle_css_classes' => esc_attr(get_field('subtitle_css_classes')),
				]
			);
			?>

			<?php if ( get_field('inline_mode') ) : ?>

				<div class="hide _modal-id-<?php echo esc_attr($post_object[0]); ?>">
					<?php canva_render_blocks($post_object[0]); ?>
				</div>

			<?php endif; ?>

		</div>

<?php
	endif;

}
