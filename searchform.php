<form role="search" method="get" class="flex flex-wrap mb-16 group" action="<?php echo esc_url(home_url('/')); ?>">

<input type="search" class="search-input group-hover:shadow-md" placeholder="<?php _e('Cerca...', 'silmax'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo _e('Cerca', 'silmax'); ?>" autofocus>

<button class="search-button button group-hover:shadow-md" type="submit" value="<?php echo _e('Cerca', 'silmax'); ?>"><?php echo _e('Cerca', 'silmax'); ?></button>

</form>