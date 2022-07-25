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
	<meta name="author" content="<?php echo get_field('signature_name', 'options'); ?>" />
	<meta name="copyright" content="<?php bloginfo('name'); ?>" />
	<meta name="theme-color" content="<?php the_field('mobile_bar_color', 'options'); ?>" />
	<meta name="msapplication-navbutton-color" content="<?php the_field('mobile_bar_color', 'options'); ?>">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php do_action('canva_body_data'); ?>>

	<?php
	/**
	 * canva_body_start hook.
	 *
	 * @hooked esempio_fonction_hook - 1
	 */
	do_action('canva_body_start');

	?>

	<?php if (is_woocommerce_activated() && (is_cart() || is_checkout() || is_account_page())) { ?>
		<main class="main max-w-screen-xxl mx-auto px-2 md:px-4 xl:px-8 pt-12">
	<?php } else { ?>
		<main class="main">
	<?php } ?>

			<?php
			/**
			 * canva_container_start hook.
			 *
			 * @hooked nome_funzione - 1
			 */
			do_action('canva_container_start');
