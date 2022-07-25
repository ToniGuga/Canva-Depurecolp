<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * custom canva
 * @return html
 */
function canva_dashicon()
{
	echo '
		<style>
			.dashicons-canva {
				background-image: url("' . get_template_directory_uri() . '/core/assets/img/canva-icon.svg");
				background-repeat: no-repeat;
				background-position: center;
				background-size: 16px 16px;
			}
		</style>
		';
}
add_action('admin_head', 'canva_dashicon');


/**
 * Remove Admin Menu Link to Theme Customizer
 *
 * @return void
 */
function canva_remove_customize()
{
	$customize_url_arr = array();
	$customize_url_arr[] = 'customize.php'; // 3.x
	$customize_url = add_query_arg('return', urlencode(wp_unslash($_SERVER['REQUEST_URI'])), 'customize.php');
	$customize_url_arr[] = $customize_url; // 4.0 & 4.1
	if (current_theme_supports('custom-header') && current_user_can('customize')) {
		$customize_url_arr[] = add_query_arg('autofocus[control]', 'header_image', $customize_url); // 4.1
		$customize_url_arr[] = 'custom-header'; // 4.0
	}
	if (current_theme_supports('custom-background') && current_user_can('customize')) {
		$customize_url_arr[] = add_query_arg('autofocus[control]', 'background_image', $customize_url); // 4.1
		$customize_url_arr[] = 'custom-background'; // 4.0
	}
	foreach ($customize_url_arr as $customize_url) {
		remove_submenu_page('themes.php', $customize_url);
	}
}
add_action('admin_menu', 'canva_remove_customize', 999);


/**
 * Disabilita le rest-api degli users
 *
 * @author Michele Tenaglia <toni@schiavoneguga.com>
 */
if (!function_exists('canva_disable_rest_endpoints')) {
	function canva_disable_rest_endpoints($endpoints)
	{
		$whitelist = ['127.0.0.1', '::1'];

		if (!in_array($_SERVER['REMOTE_ADDR'], $whitelist)) {
			if (isset($endpoints['/wp/v2/users'])) {
				unset($endpoints['/wp/v2/users']);
			}

			if (isset($endpoints['/wp/v2/users/(?P<id>[\d]+)'])) {
				unset($endpoints['/wp/v2/users/(?P<id>[\d]+)']);
			}
		}

		return $endpoints;
	}
	if (!is_user_logged_in()) {
		add_filter('rest_endpoints', 'canva_disable_rest_endpoints');
	}
}

/**
 * ACF settings & queries.
 *
 * @param mixed $args
 * @param mixed $field
 * @param mixed $post_id
 */
function canva_acf_fields_relationship_query($args, $field, $post_id)
{
	// Show 30 posts per AJAX call.
	$args['posts_per_page'] = 30;
	$args['order'] = 'DESC';
	$args['orderby'] = 'date';

	return $args;
}
add_filter('acf/fields/relationship/query', 'canva_acf_fields_relationship_query', 10, 3);

/**
 * Adds wp_block post type for acf post object and relationsship.
 *
 * @param mixed $post_types
 */
function canva_filter_acf_get_post_types($post_types)
{
	if (!in_array('common-blocks', $post_types)) {
		$post_types[] = 'common-blocks';
	}

	return $post_types;
}
add_filter('acf/get_post_types', 'canva_filter_acf_get_post_types', 10, 1);


/**
 * change the default footer message of WordPress.
 *
 * @return html
 */
function canva_footer_admin()
{
	return '<strong>Developed by</strong> <a href="' . get_field('signature_url', 'options') . '" target="_blank" rel="noopener nofollower">' . get_field('signature_name', 'options') . '</a> with <a href="https://wordpress.org/" target="_blank" rel="noopener">Wordpress&reg; ' . get_bloginfo('version') . '</a>';
}
add_filter('admin_footer_text', 'canva_footer_admin');


/**
 * add SVG thumbnail for wp media
 *
 *  @from https://wordpress.org/plugins/svg-support/
 * @return void
 */
function canva_svgs_display_thumbs()
{
	if (!is_admin()) {
		return;
	}
	ob_start();

	function canva_svgs_thumbs_filter()
	{
		$final = '';
		$final = ob_get_clean();

		echo apply_filters('final_output', $final);
	}
	add_action('shutdown', 'canva_svgs_thumbs_filter', 0);


	function canva_svgs_final_output($content)
	{
		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
                <img class="details-image" src="{{ data.url }}" draggable="false" />
                <# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',

			$content
		);

		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
                <div class="centered">
                    <img src="{{ data.url }}" class="thumbnail" draggable="false" />
                </div>
                <# } else if ( \'image\' === data.type && data.sizes ) { #>',

			$content
		);

		return $content;
	}
	add_filter('final_output', 'canva_svgs_final_output');
}
add_action('admin_init', 'canva_svgs_display_thumbs');


/**
 * ADD MIME TYPES.
 *
 * @param mixed $mimes
 */
function canva_upload_mimes($mimes)
{
	// allow SVG file upload
	$mime['jpg'] = 'image/jpeg';
	$mime['png'] = 'image/png';
	$mime['gif'] = 'image/gif';
	if (current_user_can('manage_options')) {
		$mimes['svg'] = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';
	}
	$mimes['webp']  = 'image/webp';
	$mimes['wav']  = 'audio/wav, audio/x-wav';
	$mimes['ogg']  = 'audio/ogg';
	$mimes['mp3']  = 'audio/mpeg3, audio/x-mpeg-3, video/mpeg, video/x-mpeg';
	$mimes['mp4']  = 'video/mp4';
	$mimes['m4v']  = 'video/x-m4v';
	$mimes['webm']  = 'video/webm';
	$mimes['pdf'] = 'application/pdf';
	$mimes['doc'] = 'application/msword';
	$mimes['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	$mimes['xlsx'] = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
	$mimes['xls'] = 'application/excel, application/vnd.ms-excel, application/x-excel, application/x-msexcel';
	$mimes['odt'] = 'application/vnd.oasis.opendocument.text';
	$mimes['csv'] = 'text/csv';
	$mimes['woff'] = 'application/x-font-woff';
	$mimes['woff2'] = 'application/x-font-woff2';

	return $mimes;
}
add_filter('upload_mimes', 'canva_upload_mimes');



/**
 * Check Mime Types
 * @from https://wordpress.org/plugins/svg-support/
 */
function canva_svgs_upload_check($checked, $file, $filename, $mimes)
{

	if (!$checked['type']) {

		$check_filetype        = wp_check_filetype($filename, $mimes);
		$ext                = $check_filetype['ext'];
		$type                = $check_filetype['type'];
		$proper_filename    = $filename;

		if ($type && 0 === strpos($type, 'image/') && $ext !== 'svg') {
			$ext = $type = false;
		}

		$checked = compact('ext', 'type', 'proper_filename');
	}

	return $checked;
}
add_filter('wp_check_filetype_and_ext', 'canva_svgs_upload_check', 10, 4);

/**
 * Mime Check fix for WP 4.7.1 / 4.7.2
 *
 * Fixes uploads for these 2 version of WordPress.
 * Issue was fixed in 4.7.3 core.
 * @from https://wordpress.org/plugins/svg-support/
 */
function canva_svgs_allow_svg_upload($data, $file, $filename, $mimes)
{

	global $wp_version;
	if ($wp_version !== '4.7.1' || $wp_version !== '4.7.2') {
		return $data;
	}

	$filetype = wp_check_filetype($filename, $mimes);

	return [
		'ext'                => $filetype['ext'],
		'type'                => $filetype['type'],
		'proper_filename'    => $data['proper_filename']
	];
}
add_filter('wp_check_filetype_and_ext', 'canva_svgs_allow_svg_upload', 10, 4);

/*
 *
 * canva_remove_menu_items()
 * funzione per nascondere aree del backend in base ai ruoli
 *
 */

function canva_remove_menu_items()
{
	global $menu;
	if (!is_user_role('administrator') && !is_user_role('shop_manager') && !is_user_role('editor')) {
		// remove_menu_page( 'posts' );
		remove_menu_page('edit.php?post_type=fasce-comuni');
		remove_menu_page('edit.php?post_type=persone');
		// remove_menu_page( 'edit-comments.php' );
		remove_menu_page('wpcf7');
		remove_menu_page('jetpack');
		remove_submenu_page('jetpack', 'jetpack');

		$restricted = [
			__('Posts'),
			__('Media'),
			__('Links'),
			__('Pages'),
			__('Comments'),
			__('Appearance'),
			__('Plugins'),
			__('Users'),
			__('Tools'),
			__('Settings'),
			__('Options'),
		];
		end($menu);
		while (prev($menu)) {
			$value = explode(' ', $menu[key($menu)][0]);
			if (in_array(null != $value[0] ? $value[0] : '', $restricted)) {
				unset($menu[key($menu)]);
			}
		} // end while
	}
}
add_action('admin_menu', 'canva_remove_menu_items', 99);

/**
 * Functions to show thumbnails in backend

 */
add_image_size('admin-list-thumb', 80, 80, false);

/**
 * Add featured thumbnail to admin post columns
 *
 * @param [type] $columns
 * @return void
 */
function canva_add_thumbnail_columns($columns)
{
	return [
		'cb' 				=> '<input type="checkbox" />',
		'featured_thumb'	=> __('Image', 'canva-backend'),
		'title'				=> __('Title', 'canva-backend'),
		'author'			=> __('Author', 'canva-backend'),
		'comments'			=> '<span class="vers"><div title="Comments" class="comment-grey-bubble"></div></span>',
		'date'				=> __('Date', 'canva-backend'),
	];
}

function canva_add_thumbnail_columns_data($column, $post_id)
{
	switch ($column) {
		case 'featured_thumb':
			echo '<a href="' . get_edit_post_link() . '">';
			echo the_post_thumbnail('admin-list-thumb');
			echo '</a>';

			break;
	}
}

if (function_exists('add_theme_support')) {
	add_filter('manage_posts_columns', 'canva_add_thumbnail_columns');
	add_action('manage_posts_custom_column', 'canva_add_thumbnail_columns_data', 10, 2);
	add_filter('manage_pages_columns', 'canva_add_thumbnail_columns');
	add_action('manage_pages_custom_column', 'canva_add_thumbnail_columns_data', 10, 2);
}

/**
 * gets the current post type in the WordPress Admin
 * thnx to https://gist.github.com/bradvin/1980309
 * fork https://gist.github.com/DomenicF/3ebcf7d53ce3182854716c4d8f1ab2e2.
 */
function get_current_post_type()
{
	global $post, $typenow, $current_screen;

	//we have a post so we can just get the post type from that
	if ($post && $post->post_type) {
		return $post->post_type;
	}

	//check the global $typenow - set in admin.php
	elseif ($typenow) {
		return $typenow;
	}

	//check the global $current_screen object - set in sceen.php
	elseif ($current_screen && $current_screen->post_type) {
		return $current_screen->post_type;
	}

	//we do not know the post type!
	return null;
}

/*
 *
 * canva_add_taxonomy_filters()
 * Function to print filters and columns in backend of a list of custom post types
 *
 */

function canva_add_taxonomy_filters()
{
	$post_type = get_current_post_type();
	global $wp_query, $post, $typenow, $current_screen;

	$taxonomies = get_object_taxonomies($post_type, 'objects');
	//print_r($taxonomies);

	foreach ($taxonomies as $taxonomy) {
		$tax_name = $taxonomy->name;
		$tax_slug = $tax_name;
		$tax_label = $taxonomy->label;

		$terms = get_terms($tax_name);

		if ('product_cat' != $tax_name && 'product_tag' != $tax_name && 'product_type' != $tax_name && count($terms) > 0) {
			echo "<select name='{$tax_name}' id='{$tax_name}' class='postform'>";
			echo "<option value=''>Mostra {$tax_label}</option>";
			foreach ($terms as $term) {
				echo '<option value=' . $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '', '>' . $term->name . '</option>';
			}
			echo '</select>';
		}
	}
}
add_action('restrict_manage_posts', 'canva_add_taxonomy_filters');


/*
 *
 * canva_taxonomy_columns()
 * funzione registra e crea le colonne nel backend di una lista post di un custom post type
 *
 */

function canva_taxonomy_columns($columns)
{
	$post_type = get_current_post_type();
	global $post, $typenow, $current_screen;

	$taxonomies = get_object_taxonomies($post_type, 'objects');

	if ('product' != $post_type) {
		foreach ($taxonomies as $taxonomy) {
			$columns[$taxonomy->label] = $taxonomy->label;
			unset($columns['comments']);
		}

		return $columns;
	}
}

$manage_cpt_columns = 'manage_' . get_current_post_type() . '_posts_columns';
add_filter($manage_cpt_columns, 'canva_taxonomy_columns', 10);

$manage_cpt_sortable_columns = 'manage_edit-' . get_current_post_type() . '_sortable_columns';
add_filter($manage_cpt_sortable_columns, 'canva_taxonomy_columns');
add_filter('manage_edit-page_columns', 'canva_taxonomy_columns');
// add_filter('manage_edit-page_sortable_columns', 'canva_taxonomy_columns');


/*
 *
 * canva_taxonomy_columns_row()
 * funzione che popola le righe delle colonne nel backend di una lista post di un custom post type
 * generate dalla funzione canva_taxonomy_columns()
 *
 */

function canva_taxonomy_columns_row($column_name, $post_ID)
{
	global $post, $current_screen;
	$post_type = get_current_post_type();

	$taxonomies = get_object_taxonomies($post_type, 'objects');
	//    print_r($taxonomies);

	if ('post' != $post_type && 'product' != $post_type) {

		foreach ($taxonomies as $taxonomy) {

			if ($column_name == $taxonomy->label) {
				$terms = wp_get_post_terms($post->ID, $taxonomy->name);

				$html = [];

				foreach ($terms as $term) {
					$html[] = $term->name; //do something here
				}

				echo implode(', ', $html);
			}
		}
	}
}

$manage_cpt_columns_row = 'manage_' . get_current_post_type() . '_posts_custom_column';
add_action($manage_cpt_columns_row, 'canva_taxonomy_columns_row', 10, 2);
add_action('manage_page_posts_custom_column', 'canva_taxonomy_columns_row', 10, 2);


/**
 * prints terms as css classes in admin posts lists
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $classes
 * @return void
 */
function canva_admin_posts_lists_print_terms_css_classes($classes)
{
	global $post, $typenow, $current_screen;
	$post_type = get_current_post_type();

	$taxonomies = get_object_taxonomies($post_type, 'objects');

	foreach ($taxonomies as $taxonomy) {
		$terms = wp_get_post_terms($post->ID, $taxonomy->name);

		$html = [];
		foreach ($terms as $term) {
			$classes[] = $term->slug;
		}
	}

	return $classes;
}
add_filter('post_class', 'canva_admin_posts_lists_print_terms_css_classes');


/*
 *
 * TinyMCE Editor
 * Funzioni per inserire e modificare l'editor di wordpress
 *
 */

function canva_register_tmce_button($buttons)
{
	array_push($buttons, 'canva_titoli', 'canva_shortcodes');

	return $buttons;
}

function canva_add_tmce_button($plugin_array)
{
	$plugin_array['my_button_script'] = CANVA_CORE_JS_URI . 'backend-tmce-buttons.js';

	return $plugin_array;
}

function canva_tmce_button()
{
	if ('administrator' == is_user_role()) {
		add_filter('mce_buttons', 'canva_register_tmce_button');
		add_filter('mce_external_plugins', 'canva_add_tmce_button');
	}
}
add_action('admin_init', 'canva_tmce_button');


function canva_tmce_add_quicktags()
{
	if (wp_script_is('quicktags')) {
?>
		<script type="text/javascript">
			QTags.addButton('icon', 'icon', '[icon name="" type="" class=""]', '[/icon]', 'icon', 'icon', 163);
			QTags.addButton('action_link', 'action_link',
				'[action_link class="" title="Titolo Link" url="https://... tel:+39... mailto:info@..." target="" icon_name="" icon_type="" icon_class="" action_type=""]',
				'[/action_link]', 'action_link', 'action_link', 164);
		</script>
	<?php
	}
}
add_action('admin_print_footer_scripts', 'canva_tmce_add_quicktags');

//thanks to https://trepmal.com/2011/02/16/remove-buttons-from-the-visual-editor/
function canva_remove_tmce_buttons_line_1($buttons)
{
	//Remove the format dropdown select and text color selector
	$remove = [
		// 'formatselect',
		//'bold',
		//'italic',
		//'bullist',
		//'numlist',
		//'blockquote',
		'alignleft',
		'aligncenter',
		'alignright',
		//'link',
		//'unlink',
		//'hr',
		//'charmap',
		'undo',
		'redo',
		'wp_more',
		// 'pastetext',
		// 'pasteword',
		'spellchecker',
		'dfw',
		'fullscreen',
		'wp_adv',
	];

	return array_diff($buttons, $remove);
}

add_filter('mce_buttons', 'canva_remove_tmce_buttons_line_1');

function canva_remove_tmce_buttons_line_2($buttons)
{
	//Remove the format dropdown select and text color selector
	$remove = [
		'strikethrough',
		//'hr',
		'forecolor',
		'pastetext',
		'removeformat',
		'charmap',
		'outdent',
		'indent',
		'undo',
		'redo',
		'wp_help',
	];

	return array_diff($buttons, $remove);
}
add_filter('mce_buttons_2', 'canva_remove_tmce_buttons_line_2');


function canva_tinymce_cleanup($set)
{
	$set['valid_elements'] = '*[id|class|style|href|target|rel|title|alt|src]';
	$set['invalid_styles'] = 'display position color font-family font-size text-align line-height top bottom left right margin margin-top margin-bottom margin-left margin-right border border-top border-bottom border-left border-right';

	return $set;
}
add_filter('tiny_mce_before_init', 'canva_tinymce_cleanup');


/**
 * Remove toolbar items
 *
 * @param [type] $wp_admin_bar
 * @return void
 */
function canva_remove_toolbar_nodes($wp_admin_bar)
{

	$wp_admin_bar->remove_node('wp-logo');
	$wp_admin_bar->remove_node('comments');
	$wp_admin_bar->remove_node('customize');
	$wp_admin_bar->remove_node('customize-background');
	$wp_admin_bar->remove_node('customize-header');
	// $wp_admin_bar->remove_node('new-content');
	// $wp_admin_bar->remove_node('view');
}
add_action('admin_bar_menu', 'canva_remove_toolbar_nodes', 999);

/**
 * Remove some dashboard meta
 *
 * @return void
 */
function canva_remove_dashboard_meta()
{

	if (current_user_can('install_plugins')) {
		remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
		remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
		remove_meta_box('dashboard_primary', 'dashboard', 'normal');
		remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
		remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
		remove_meta_box('dashboard_activity', 'dashboard', 'normal');
		remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'normal');
	}
}
add_action('admin_init', 'canva_remove_dashboard_meta');


// Move Yoast to bottom
function yoast_to_bottom()
{
	return 'low';
}
add_filter('wpseo_metabox_prio', 'yoast_to_bottom');


/**
 * hides taxonomy with false in cptui
 */
add_filter('rest_prepare_taxonomy', function ($response, $taxonomy, $request) {
	$context = !empty($request['context']) ? $request['context'] : 'view';
	// Context is edit in the editor
	if ($context === 'edit' && $taxonomy->meta_box_cb === false) {
		$data_response = $response->get_data();
		$data_response['visibility']['show_ui'] = false;
		$response->set_data($data_response);
	}
	return $response;
}, 10, 3);


// Added by Michele - 13/09/2021

/**
 * Add column for Notes
 *
 * @param [type] $columns
 * @return void
 */
function canva_notes_field_backend_admin($columns)
{
	return array_merge($columns, array(
		'canva_notes'    =>    __('Notes'),
	));
}
add_filter('manage_page_posts_columns', 'canva_notes_field_backend_admin');

/**
 * !!! Somthing for Notes, who knows
 *
 * @param [type] $column
 * @param [type] $post_id
 * @return void
 */
function canva_notes_field_backend_admin_column($column, $post_id)
{
	switch ($column) {
		case 'canva_notes':
			$notes = get_post_meta($post_id, 'canva_notes', true);
			echo $notes;
			break;
	}
}
add_action('manage_page_posts_custom_column', 'canva_notes_field_backend_admin_column', 10, 2);

/**
 * Add logo image to login
 *
 * @return void
 */
function canva_custom_login()
{
	$custom_style = get_field('logo_login_sizes', 'options')['login_style_css'];

	$primary_color = get_field('primary_color', 'options');
	$secondary_color = get_field('secondary_color', 'options');

	$font = get_field('primary_font_google', 'options')['url'];

	$logo = get_field('logo_light_mode', 'options')['img'];
	$logo_width = get_field('logo_login_sizes', 'options')['width'] . 'px ';
	$logo_height = get_field('logo_login_sizes', 'options')['height'] . 'px ';
	$logo_url = canva_get_img(
		[
			'img_id'	=>	$logo,
			'img_type'	=>	'url',
		]
	);

	echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
	echo '<link href="' . $font . '" rel="stylesheet">';

	echo '<style>';

	echo 'body.login {
			background-color: #fff;
		}
		body.login a {
			color: ' .  get_field('primary_color', 'options') . ' !important;
			text-decoration: none;
		}
		body.login a:hover {
			text-decoration: underline !important;
		}
		#login {
			padding: 20px;
			background-color: #fff;
		}
		#login h1 a {
			background-image: url(' . $logo_url . ');
			background-size: ' . $logo_width . $logo_height . ';
			width: ' . $logo_width . ';
			height: ' . $logo_height . ';
			margin: auto;
			background-repeat: no-repeat;
			background-position: center;
		}
		.login form {
			background: #fff;
			border: none;
			box-shadow: none;
			padding: 20px;
		}
		.login form .input,
		.login input[type="text"],
		.login input[type="password"] {
			font-size: 18px;
			border: none;
			background-color: rgba(0, 0, 0, .05);
		}
		.login form .input:focus,
		.login form .input:focus-within,
		.login input[type="text"]:focus,
		.login input[type="text"]:focus-within
		.login input[type="password"]:focus,
		.login input[type="password"]:focus-within {
			box-shadow: none;
			border: 2px solid ' .  $primary_color  . ';
		}
		input#user_pass {
			font-size: 14px;
			letter-spacing: 2px;
		}
		.forgetmenot,
		.login .button-primary {
			float: none;
		}
		p.submit {
			margin-top: 2rem !important;
		}
		.login .button-primary {
			display: block;
			width: 100%;
			border-radius: .75rem;
			font-size: 1rem;
			padding: .5rem 1rem !important;
			background-color: ' .  $primary_color  . ';
			border-color: ' .  $primary_color  . ';
		}
		.login .button-primary:hover,
		.login .button-primary:active,
		.login .button-primary:focus {
			background-color: ' . $secondary_color . ' !important;
			border-color: ' . $secondary_color . ' !important;
		}
		.login .button-primary:focus  {
			box-shadow: 0 0 0 1px #fff,0 0 0 3px ' . $secondary_color . ';
		}
		.login #login_error {
			border: none;
			box-shadow: none;
			background-color: #E53935;
			color: #fff;
		}
		a.privacy-policy-link {
			color: ' .  $primary_color  . ';
			font-weight: 700;
		}';

	if ($custom_style) {

		echo $custom_style;
	}

	echo '</style>';
}
add_action('login_head', 'canva_custom_login');


/**
 * stampa messaggio fisso negli avvisi per il backend.
 * campo in opzioni del tema settings
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_admin_notice__info()
{
	if (get_field('backend_notices', 'option')) {
	?>
		<div class="notice notice-info">
			<p><?php echo get_field('backend_notices', 'option'); ?></p>
		</div>
<?php
	}
}
add_action('admin_notices', 'canva_admin_notice__info');



/**
 * Mette il sito offline in modalità manutenzione oppure comming soon
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_maintenance_mode()
{
	$maintenance_mode = get_field('maintenance_mode', 'options');

	if ($maintenance_mode['maintenance_mode_option']) {
		$token = '';
		if (isset($_GET['token'])) {
			$token = $_GET['token'];
		}

		$token_cookie = '';
		if (isset($_COOKIE['canva_bypass_token'])) {
			$token_cookie = $_COOKIE['canva_bypass_token'];
		}

		if ($token == $maintenance_mode['token']) {
			setcookie('canva_bypass_token', $maintenance_mode['token'], time() + (86400 * 7), '/'); // 86400 = 1 day
		}

		// dump_to_error_log($maintenance_mode['token']);

		if ($token == $maintenance_mode['token'] || $token_cookie == $maintenance_mode['token']) {
			if (is_page($maintenance_mode['maintenance_mode_page'])) {
				wp_redirect(home_url(), 302);
				exit();
			}
		} else {
			if (!is_page($maintenance_mode['maintenance_mode_page'])) {
				$redirect_url = get_permalink($maintenance_mode['maintenance_mode_page']);
				wp_redirect($redirect_url, 302);
				exit();
			}
		}
	}
}
//action fired in canva-hooks.php

/**
 * Assenga template page-lp.php a tutte le pagine quando è attivo il maintenance mode
 *
 * @author Michele Tenaglia <info@micheletenaglia.com>
 * @param [type] $template
 * @return void
 */
function canva_maintenance_page_template($template)
{

	$maintenance_mode = get_field('maintenance_mode', 'options');

	if (is_singular('page') &&  $maintenance_mode['maintenance_mode_option'] && !is_user_logged_in()) {
		$landing_page = locate_template(array('page-lp.php'));
		if ('' != $landing_page) {
			return $landing_page;
		}
	}

	return $template;
}
add_filter('template_include', 'canva_maintenance_page_template', 99);
