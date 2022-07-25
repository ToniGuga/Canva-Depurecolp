<?php
get_header();

if (in_category(array(55))) {

	include ('single-post-playlist.php');

} else {

	include ('single-post-blog.php');

}
get_footer();
