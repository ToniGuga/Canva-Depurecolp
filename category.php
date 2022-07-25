<?php

get_header();

$socials = [
	'facebook',
	'instagram',
	'linkedin',
	'youtube'
];
?>

<div class="md:flex md:justify-between">

	<div class="p-4 md:p-16">

		<h1 class="h3 mb-0 uppercase">
			<?php single_cat_title(); ?>
		</h1>

	</div>

	<div class="p-4 md:p-16 flex items-center">

		<?php foreach ($socials as $social) : ?>

			<a href="<?php echo esc_url(get_field($social, 'options')); ?>">
				<?php echo canva_get_svg_icon('fontawesome/brands/' . $social, 'w-6 fill-current mr-4 mb-4'); ?>
			</a>

		<?php endforeach; ?>

	</div>

</div>

<?php if (have_posts()) : ?>

	<div class="_white-container">
		<div class="_primo-default-row">

			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

				<?php while (have_posts()) : the_post(); ?>

					<?php echo canva_get_template('card-blog', ['post_id' => get_the_ID()]); ?>

				<?php endwhile; ?>

			</div>

		</div>
	</div>

<?php endif; ?>

<?php get_footer();
