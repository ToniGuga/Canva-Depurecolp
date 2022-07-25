<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>

<div class="_modal-search hidden">
	<div class="_modal-search-container flex justify-center">

		<a class="modal-close cursor-pointer absolute top-0 right-0 p-4">
			<?php echo canva_get_svg_icon($name = 'fontawesome/regular/times', $class = 'w-5 h-5'); ?>
		</a>

		<div class="text-center bg-grey-light md:p-8 w-full md:w-3/5">

			<span class="block h5 text-300 text-uppercase mb-4"><?php _e('Search in the website', 'canva-frontend'); ?></span>

			<form role="search" method="get" class="flex flex-wrap mb-16 group" action="<?php echo esc_url(home_url('/search/')); ?>">

				<input type="search" class="search-input group-hover:shadow-md h-14" placeholder="<?php _e('Search something here...', 'canva-frontend'); ?>" value="<?php echo get_search_query(); ?>" name="_regular_search" title="<?php echo _e('Search', 'canva-frontend'); ?>" autofocus>

				<button class="search-button button group-hover:shadow-md" type="submit" value="<?php echo _e('Search', 'canva-frontend'); ?>"><?php echo _e('Search', 'canva-frontend'); ?></button>

			</form>

		</div>

	</div>
</div>
