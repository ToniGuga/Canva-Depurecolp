<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {


?>
	<div class="canva-wp-block canva-flex">

		<div class="_info canva-width-24 canva-p-4 canva-bg-grey-lighter">
			<span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Selettore Menu</span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="canva-width-12 canva-m-0">

				<!-- ICONA -->
				<?php echo apply_filters('menu_selector_blocks_icon', canva_get_svg_icon('fontawesome/regular/hamburger', null)); ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="_content canva-flex-1 canva-p-4 canva-bg-white">
			<?php if (get_field('menu_id')) : ?>
				<nav class="canva-pl-4">
					<ul class="<?php echo esc_attr(get_field('ul_css_classes')) ?>">
						<?php echo canva_menu(['menu_id' => esc_attr(get_field('menu_id')), 'depth' => 4, 'css_classes' => esc_attr(get_field('li_css_classes')), 'items_wrap' => '%3$s', 'walker' => '']); ?>
					</ul>
				</nav>
			<?php else : ?>
				<?php _e('Imposta il blocco', 'canva-be'); ?>
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
		$className .= ' ' . $block['className'];
	}

?>

	<?php if (get_field('menu_id')) : ?>
		<nav id="<?php echo esc_attr($id); ?>" class="canva-block-menu-selector <?php echo esc_attr($className); ?> <?php echo esc_attr(get_field('ul_css_classes')) ?>">
			<ul class="<?php echo esc_attr(get_field('ul_css_classes')) ?>">
				<?php echo canva_menu(['menu_id' => esc_attr(get_field('menu_id')), 'depth' => 4, 'css_classes' => esc_attr(get_field('li_css_classes')), 'items_wrap' => '%3$s', 'walker' => '']); ?>
			</ul>
		</nav>
	<?php endif; ?>

<?php
}
