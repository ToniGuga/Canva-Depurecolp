<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>

<div class="modal-contact hidden">
	<div class="text-center bg-grey-light p-8">
		<h3 class="block h5 text-300 text-uppercase mt-4 mb-4">
			<span class="title block h3 mb-1"><?php _e('Contact us', 'canva-frontend'); ?></span>
			<!-- <span class="subtitle block h6"><?php get_the_title(); ?></span> -->
		</h3>

		<?php echo do_shortcode(get_field('modal_contact_form', 'options')); ?>
	</div>
</div>

