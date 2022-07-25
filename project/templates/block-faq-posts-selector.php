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
	<a class="_accordion-title group flex items-center mb-4 p-2 bg-secondary-100 rounded-md cursor-pointer">
		<div class="_plus bg-secondary w-8 h-8 mr-4 flex items-center justify-center rounded group-hover:bg-secondary-300">
			<span class="h3 text-white mb-0">+</span>
		</div>
		<div class="_faq-title">
			<h4 class="h6 mb-0">
				<?php echo get_the_title($post_id); ?>
			</h4>
		</div>
	</a>
</dt>

<?php if (get_field('content', $post_id)) : ?>
	<dd class="<?php echo esc_attr($isactive); ?>">
		<div class="p-4 pt-2 pl-12 mb-4 bg-secondary-100 rounded-md">
			<?php the_field('content', $post_id); ?>
		</div>
	</dd>
<?php endif; ?>
