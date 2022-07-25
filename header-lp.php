<?php

/**
 * The template for displaying the header.
 *
 * Displays all of the head element and everything up until the "container" div.
 *
 * @since Canva 1.0.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script>
		document.documentElement.className = 'js';
	</script>
	<meta name="author" content="<?php echo get_field('signature_name','options'); ?>" />
	<meta name="copyright" content="<?php bloginfo('name'); ?>" />
	<meta name="theme-color" content="<?php the_field('mobile_bar_color', 'options'); ?>" />
	<meta name="msapplication-navbutton-color" content="<?php the_field('mobile_bar_color', 'options'); ?>">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<?php wp_head(); ?>
</head>

<body <?php body_class('landing-page'); ?>>

	<main class="main">

		<?php
		/**
		 * canva_container_start hook.
		 *
		 * @hooked nome_funzione - 1
		 */
		do_action('canva_container_start');
