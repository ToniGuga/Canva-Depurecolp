<?php
get_header();

if(is_user_logged_in()){
	the_content();
}

get_footer();
