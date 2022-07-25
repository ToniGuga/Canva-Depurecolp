<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
?>

<div class="modal-search hidden">

	<div class="text-center bg-grey-light p-8">
	
		<span class="block h5 text-300 text-uppercase mb-4"><?php _e('Search something here...', 'canva-frontend'); ?></span>
		
		<form role="search" method="get" class="inline-flex w-100" action="<?php echo esc_url(home_url('/')); ?>">
		
			<input style="height:45px; margin-right:.5rem;" type="search" class="search-input" placeholder="<?php _e('Search something here...', 'canva-frontend'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo _e('Search', 'canva-frontend'); ?>" autofocus>
			
			<button class="search-button button" type="submit" value="<?php echo _e('Search', 'canva-frontend'); ?>"><?php echo _e('Search', 'canva-frontend'); ?></button>
	
		</form>

	</div>

</div>
