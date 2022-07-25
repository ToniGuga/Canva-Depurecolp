<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Add stats about server performances below everything
 *
 * @return void
 */
function canva_show_wp_load_stats()
{
	if (current_user_can('activate_plugins')) {
		echo '<div class="container p-1 text-center">';
		echo get_num_queries();
		echo ' queries in ';
		timer_stop(3);
		echo ' seconds</div>';
	}
}
add_action('wp_footer', 'canva_show_wp_load_stats');


/**
 * dump_to_error_log($dump_this)
 * funzione di debug che stampa output in error_log.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param mixed $dump_this
 */
function dump_to_error_log($dump_this)
{
	ob_start();
	var_dump($dump_this);
	error_log(ob_get_clean());
}

/**
 * check php info
 *
 * @return void
 */
function canva_phpinfo()
{
	phpinfo();
	wp_die();
}
add_action('wp_ajax_canva_phpinfo', 'canva_phpinfo', 10, 10);
add_action('wp_ajax_nopriv_canva_phpinfo', 'canva_phpinfo', 10, 1);


function canva_server_ip()
{

	if (!is_admin()) {
		exit;
	}

	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_URL => 'https://ipinfo.io/ip',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_CUSTOMREQUEST => "GET"
	));

	echo  'curl https://ipinfo.io/ip = ' . curl_exec($curl);

	wp_die();
}
add_action('wp_ajax_canva_server_ip', 'canva_server_ip', 10, 10);
add_action('wp_ajax_nopriv_canva_server_ip', 'canva_server_ip', 10, 1);



/**
 * Useful to re-save posts by post type
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $content
 * @param integer $trim
 * @return string
 */
function canva_update_all_posts($vars = [], $by = 'field')
{

	// if (isset($_GET['post_type']) && '' != trim($_GET['post_type'])) {
	// 	$post_type = sanitize_user($_GET['post_type']);
	// } elseif (isset($_POST['post_type']) && '' != trim($_POST['post_type'])) {
	// 	$post_type = intval(sanitize_text_field($_POST['post_type']));
	// }

	// if (isset($_GET['famiglia_id']) && '' != trim($_GET['famiglia_id'])) {
	// 	$famiglia_id = sanitize_user($_GET['famiglia_id']);
	// } elseif (isset($_POST['famiglia_id']) && '' != trim($_POST['famiglia_id'])) {
	// 	$famiglia_id = intval(sanitize_text_field($_POST['famiglia_id']));
	// }

	extract($vars);

	if($by === 'field'){
		$args = array(
			'post_type' => esc_attr($post_type),
			'posts_per_page' => 	-1,
			'meta_key'          =>   esc_attr($meta_key),
			'meta_value'        =>  $meta_value,
		);
	}else{
		$args = array(
			'post_type' => esc_attr($post_type),
			'posts_per_page' => 	-1,
			'tax_query'          =>   array(
				'taxonomy' => esc_attr($taxonomy),
				'field'    => esc_attr($field),
            	'terms'    => array($terms),
			),
		);
	}

	$all_posts = get_posts($args);

	foreach ($all_posts as $single_post) {
		$single_post->post_title = $single_post->post_title . '';
		wp_update_post($single_post);
	}

	wp_die();
}
add_action('wp_ajax_canva_update_all_posts', 'canva_update_all_posts', 10, 2);
add_action('wp_ajax_nopriv_canva_update_all_posts', 'canva_update_all_posts', 10, 2);



/**
 * Delete debug log
 *
 * @author Michele Tenaglia <info@micheletenaglia.com>
 * @return void
 */
function canva_delete_debug()
{

	$debug_file = $_SERVER['DOCUMENT_ROOT'] . '/wp-content/debug.log';
	//echo file_exists($debug_file);
	unlink($debug_file);

	die();
}
add_action('wp_ajax_canva_delete_debug', 'canva_delete_debug');
add_action('wp_ajax_nopriv_canva_delete_debug', 'canva_delete_debug');



/**
 * Create a submenu item in the WordPress admin toolbar
 *
 * @author Michele Tenaglia <info@micheletenaglia.com>
 * @return void
 */
function canva_admin_bar_debug($admin_bar)
{

	$link_url = get_home_url() . '/wp-content/debug.log';
	$args = array(
		// 'parent'	=>	'tools',
		'id'		=>	'debug-log',
		'title'		=>	__('Debug log', 'canva'),
		'href' 		=>	$link_url,
		'meta'		=>	array(
			'target' => '_blank',
		)
	);
	$admin_bar->add_node($args);
}

if (WP_DEBUG) {
  add_action('admin_bar_menu', 'canva_admin_bar_debug', 999);
}
