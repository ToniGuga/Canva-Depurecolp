<?php
/*
 * Template Name: Landing Page
 * Template Post Type: page
 */

get_header($name = 'lp');
?>

<?php if (post_password_required()) { ?>
	<div class="flex items-center">
		<div class="p-16">
			<?php
			echo get_the_password_form(); // WPCS: XSS ok.
			return;
			?>
		</div>
	</div>
<?php }	?>

<?php
the_content();
get_footer($name = 'lp');
