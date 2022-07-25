<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!$post_id) {
	$post_id = get_the_ID();
}

canva_render_blocks($post_id);
