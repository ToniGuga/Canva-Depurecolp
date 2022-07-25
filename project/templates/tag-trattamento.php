<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}
?>

<a class="bg-primary inline-block fs-xxs text-white py-0.5 px-4 mb-1 mr-1 rounded-full transition hover:bg-primary-300" href="<?php echo get_permalink($post_id); ?>">
	<?php echo get_the_title($post_id); ?>
</a>
