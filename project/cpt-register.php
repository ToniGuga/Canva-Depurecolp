<?php
defined('ABSPATH') || exit;


function abc_register_cpt_elements()
{
	/**
	 * Post Type: Elements.
	 */
	$labels = [
		'name' 					=> __('Elements', 'canva-backend'),
		'singular_name' 		=> __('Elements', 'canva-backend'),
		'menu_name' 			=> __('Elements', 'canva-backend'),
		'all_items' 			=> __('All Elements', 'canva-backend'),
		'add_new' 				=> __('Add Element', 'canva-backend'),
		'add_new_item' 			=> __('Add new Element', 'canva-backend'),
		'edit_item' 			=> __('Edit Element', 'canva-backend'),
		'new_item' 				=> __('New Element', 'canva-backend'),
		'view_item' 			=> __('View Element', 'canva-backend'),
		'view_items' 			=> __('View Elements', 'canva-backend'),
		'search_items' 			=> __('Search a Element', 'canva-backend'),
		'not_found' 			=> __('No Elements found', 'canva-backend'),
		'not_found_in_trash' 	=> __('No Elements found in trash', 'canva-backend'),
	];

	$args = [
		'label' 				=> __('Elements', 'canva-backend'),
		'labels' 				=> $labels,
		'description' 			=> '',
		'public' 				=> true,
		'publicly_queryable' 	=> true,
		'show_ui' 				=> true,
		'show_in_rest' 			=> true,
		'rest_base' 			=> '',
		'rest_controller_class' => 'WP_REST_Posts_Controller',
		'has_archive' 			=> false,
		'show_in_menu' 			=> true,
		'show_in_nav_menus' 	=> false,
		'delete_with_user' 		=> false,
		'exclude_from_search' 	=> true,
		'capability_type' 		=> ['element', 'elements'],
		'map_meta_cap' 			=> true,
		'hierarchical' 			=> false,
		'rewrite' 				=> ['slug' => 'element', 'with_front' => true],
		// 'menu_icon' 			=> 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="#FFFFFF"><path d="M437.983 261.352c-4.321 2.778-10.839 6.969-13.122 7.279-24.067-.092.757-103.841 5.813-124.714-29.614 5.697-134.448 26.337-159.932 7.046C271.197 132.585 304 116.55 304 73.588 304 28.222 261.986 0 216.994 0 171.147 0 112 25.756 112 75.063c0 40.881 28.702 64.642 31.994 74.559-.739 28.838-115.981 1.752-143.994-5.469v351.556C10.464 498.412 56.682 512 104 512c45.3-.001 88-15.737 88-60.854 0-31.773-32-45.657-32-73.834 0-16.521 29.235-27.063 49.361-27.063 21.125 0 46.639 11.414 46.639 25.588 0 24.02-32 36.882-32 77.924 0 66.838 81.555 58.073 134.44 51.225 37.039-4.797 33.159-3.906 73.069-3.906-2.799-8.954-28.061-81.125-13.892-100.4 10.021-13.639 39.371 31.32 84.037 31.32C548.715 432 576 380.487 576 336c0-57.793-45.975-133.814-138.017-74.648zM501.654 384c-24.507 0-37.496-32.763-79.116-32.763-35.286 0-67.12 27.143-53.431 104.031-19.03 2.234-84.249 12.922-96.329 2.29C261.633 447.771 304 419.385 304 375.837c0-46.326-49.475-73.588-94.639-73.588-46.686 0-97.361 27.417-97.361 75.063 0 50.809 41.414 70.396 29.601 79.554-16.851 13.064-71.854 5.122-93.601.935V204.584c63.934 10.948 144 9.33 144-55.435 0-31.802-32-45.775-32-74.086C160 58.488 199.338 48 216.994 48 233.19 48 256 55.938 256 73.588c0 23.524-33.264 36.842-33.264 77.924 0 60.396 86.897 58.813 146.508 51.68-6.592 53.714 1.669 113.439 55.691 113.439 31.223 0 45.141-28.631 75.22-28.631C517.407 288 528 315.957 528 336c0 21.606-12.157 48-26.346 48z"/></svg>'),
		'menu_icon' 			=> 'dashicons-editor-table',
		// "rewrite" 			=> false,
		'query_var' 			=> true,
		'supports' 				=> ['title', 'editor', 'thumbnail', 'author', 'revisions'],
	];

	register_post_type('element', $args);
}

add_action('init', 'abc_register_cpt_elements');

function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Pumping units.
	 */

	$labels = [
		"name" => __( "Pumping units", "canva" ),
		"singular_name" => __( "Pumping unit", "canva" ),
	];


	$args = [
		"label" => __( "Pumping units", "canva" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'pumping_unit', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "pumping_unit",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => true,
		"show_in_graphql" => false,
		"capabilities" => array(
			"manage_terms" => "manage_genre",
			"edit_terms" => "edit_genre",
			"delete_terms" => "delete_genre",
			"assign_terms" => "assign_genre",
		)
	];
	register_taxonomy( "pumping_unit", [ "product" ], $args );

	/**
	 * Taxonomy: Screw Hours.
	 */

	$labels = [
		"name" => __( "Screw Hours", "canva" ),
		"singular_name" => __( "Screw Hours", "canva" ),
	];


	$args = [
		"label" => __( "Screw Hours", "canva" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => [ 'slug' => 'screw_hours', 'with_front' => true, ],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"show_tagcloud" => false,
		"rest_base" => "screw_hours",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"rest_namespace" => "wp/v2",
		"show_in_quick_edit" => true,
		"sort" => true,
		"show_in_graphql" => false,
		"capabilities" => array(
			"manage_terms" => "manage_genre",
			"edit_terms" => "edit_genre",
			"delete_terms" => "delete_genre",
			"assign_terms" => "assign_genre",
		)
	];
	register_taxonomy( "screw_hours", [ "product" ], $args );

}
add_action( 'init', 'cptui_register_my_taxes' );
