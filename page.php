<?php
get_header();
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
get_footer();
