<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

if ($row === 1) {
	$isactive = 'active';
}
?>

<dt class="<?php echo esc_attr($isactive); ?>">
	<a class="_accordion-title p-4 bg-gray-50 cursor-pointer">
		<h4 class="h5 mb-2">
			<?php echo get_the_title($post_id); ?>
		</h4>
	</a>
</dt>

<?php if (get_field('content', $post_id)) : ?>
	<dd class="<?php echo esc_attr($isactive); ?>">
		<div class="text-sm p-4">
			<?php the_field('content', $post_id); ?>
		</div>
	</dd>
<?php endif; ?>
