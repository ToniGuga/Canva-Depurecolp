<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

setup_postdata($post_id);
?>

<div class="">
	<?php wc_get_template_part('content', 'product');?>
</div>

<?php
wp_reset_postdata();
