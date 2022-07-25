<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (is_acf_activated()) {

	// Theme Options
	if (function_exists('acf_add_options_page')) {

		acf_add_options_page([
			'page_title'  => __('Theme Settings', 'canva-backend'),
			'menu_title'  => __('Theme Settings', 'canva-backend'),
			'menu_slug'   => 'options',
			'capability'  => 'activate_plugins',
			'redirect'    => false
		]);

		acf_add_options_sub_page([
			'page_title'  => __('Layout', 'canva-backend'),
			'menu_title'  => __('Layout', 'canva-backend'),
			'parent_slug' => 'options',
			'menu_slug'   => 'options-layout',
			'capability'  => 'activate_plugins',
		]);

		/**
		 * @todo Decomment condition
		 */
		// if (is_woocommerce_activated()) {
		// acf_add_options_sub_page([
		// 	'page_title' 	=> __('Woocommerce', 'canva-backend'),
		// 	'menu_title' 	=> __('Woocommerce', 'canva-backend'),
		// 	'parent_slug' 	=> 'options',
		// 	'capability' 	=> 'activate_plugins',
		// ]);
		// }
	}

	// People Post Type
	if (get_field('people_post_type', 'options')) {
		function canva_register_cpt_people()
		{
			/**
			 * Post Type: People.
			 */
			$labels = [
				'name' 			=> __('People', 'canva-backend'),
				'singular_name' => __('People', 'canva-backend'),
				'add_new' 		=> __('Add People', 'canva-backend'),
			];

			$args = [
				'label' 					=> __('People', 'canva-backend'),
				'labels' 					=> $labels,
				'description' 				=> '',
				'public' 					=> true,
				'publicly_queryable' 		=> true,
				'show_ui' 					=> true,
				'show_in_rest' 				=> true,
				'rest_base' 				=> '',
				'rest_controller_class' 	=> 'WP_REST_Posts_Controller',
				'has_archive' 				=> false,
				'show_in_menu' 				=> true,
				'show_in_nav_menus' 		=> false,
				'delete_with_user' 			=> false,
				'exclude_from_search' 		=> false,
				'capability_type' 			=> ['person', 'persons'],
				'map_meta_cap' 				=> true,
				'hierarchical' 				=> false,
				'rewrite' 					=> ['slug' => 'People', 'with_front' => true],
				'menu_icon' 				=> 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" fill="#FFFFFF"><path d="M544 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-112c17.6 0 32 14.4 32 32s-14.4 32-32 32-32-14.4-32-32 14.4-32 32-32zM96 224c44.2 0 80-35.8 80-80s-35.8-80-80-80-80 35.8-80 80 35.8 80 80 80zm0-112c17.6 0 32 14.4 32 32s-14.4 32-32 32-32-14.4-32-32 14.4-32 32-32zm396.4 210.9c-27.5-40.8-80.7-56-127.8-41.7-14.2 4.3-29.1 6.7-44.7 6.7s-30.5-2.4-44.7-6.7c-47.1-14.3-100.3.8-127.8 41.7-12.4 18.4-19.6 40.5-19.6 64.3V432c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48v-44.8c.2-23.8-7-45.9-19.4-64.3zM464 432H176v-44.8c0-36.4 29.2-66.2 65.4-67.2 25.5 10.6 51.9 16 78.6 16 26.7 0 53.1-5.4 78.6-16 36.2 1 65.4 30.7 65.4 67.2V432zm92-176h-24c-17.3 0-33.4 5.3-46.8 14.3 13.4 10.1 25.2 22.2 34.4 36.2 3.9-1.4 8-2.5 12.3-2.5h24c19.8 0 36 16.2 36 36 0 13.2 10.8 24 24 24s24-10.8 24-24c.1-46.3-37.6-84-83.9-84zm-236 0c61.9 0 112-50.1 112-112S381.9 32 320 32 208 82.1 208 144s50.1 112 112 112zm0-176c35.3 0 64 28.7 64 64s-28.7 64-64 64-64-28.7-64-64 28.7-64 64-64zM154.8 270.3c-13.4-9-29.5-14.3-46.8-14.3H84c-46.3 0-84 37.7-84 84 0 13.2 10.8 24 24 24s24-10.8 24-24c0-19.8 16.2-36 36-36h24c4.4 0 8.5 1.1 12.3 2.5 9.3-14 21.1-26.1 34.5-36.2z"/></svg>'),
				'query_var' 				=> true,
				'menu_position'				=> 8,
				'supports' 					=> ['title', 'editor', 'thumbnail', 'author', 'revisions'],
				'taxonomies' 				=> ['people-role'],
			];

			register_post_type('people', $args);
		}

		add_action('init', 'canva_register_cpt_people');

		// Roles - People Taxonomy

		function canva_register_tax_people_roles()
		{
			/**
			 * Taxonomy: Roles.
			 */
			$labels = [
				'name' 				=> __('Roles', 'canva-backend'),
				'singular_name' 	=> __('Roles', 'canva-backend'),
			];

			$args = [
				'label' 				=> __('Roles', 'canva-backend'),
				'labels' 				=> $labels,
				'public' 				=> false,
				'publicly_queryable' 	=> true,
				'hierarchical' 			=> true,
				'show_ui' 				=> true,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' 	=> false,
				'query_var' 			=> true,
				'rewrite' 				=> ['slug' => 'people-role', 'with_front' => true],
				'show_admin_column' 	=> true,
				'show_in_rest' 			=> true,
				'rest_base' 			=> 'people-role',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
				'show_in_quick_edit' 	=> false,
			];
			register_taxonomy('people-role', ['people'], $args);
		}
		add_action('init', 'canva_register_tax_people_roles');
	}

	// Project Post Type
	if (get_field('project_post_type', 'options')) {
		function canva_register_cpt_project()
		{
			/**
			 * Post Type: project.
			 */
			$labels = [
				'name' 			=> __('Projects', 'canva-backend'),
				'singular_name' => __('Project', 'canva-backend'),
				'add_new' 		=> __('Add a project', 'canva-backend'),
			];

			$args = [
				'label' 					=> __('Projects', 'canva-backend'),
				'labels' 					=> $labels,
				'description' 				=> '',
				'public' 					=> true,
				'publicly_queryable' 		=> true,
				'show_ui' 					=> true,
				'show_in_rest' 				=> true,
				'rest_base' 				=> '',
				'rest_controller_class' 	=> 'WP_REST_Posts_Controller',
				'has_archive' 				=> false,
				'show_in_menu' 				=> true,
				'show_in_nav_menus' 		=> false,
				'delete_with_user' 			=> false,
				'exclude_from_search' 		=> false,
				'capability_type' 			=> ['project', 'projects'],
				'map_meta_cap' 				=> true,
				'hierarchical' 				=> false,
				'rewrite' 					=> ['slug' => 'project', 'with_front' => true],
				'menu_icon' 				=> 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" fill="#ffffff"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M608 0H480c-17.67 0-32 14.33-32 32v32H192V32c0-17.67-14.33-32-32-32H32C14.33 0 0 14.33 0 32v128c0 17.67 14.33 32 32 32h95.72L224 360.12V480c0 17.67 14.33 32 32 32h128c17.67 0 32-14.33 32-32V352c0-17.67-14.33-32-32-32H274.76L192 175.5V128h256v32c0 17.67 14.33 32 32 32h128c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32zM144 144H48V48h96v96zm128 224h96v96h-96v-96zm320-224h-96V48h96v96z"/></svg>'),
				'query_var' 				=> true,
				'menu_position'				=> 8,
				'supports' 					=> ['title', 'editor', 'thumbnail', 'author', 'revisions'],
				'taxonomies' 				=> ['project-type'],
			];

			register_post_type('project', $args);
		}

		add_action('init', 'canva_register_cpt_project');


		// Typology - Project Taxonomy
		function canva_register_tax_project_type()
		{
			/**
			 * Taxonomy: Typology.
			 */
			$labels = [
				'name' 				=> __('Project types', 'canva-backend'),
				'singular_name' 	=> __('Project type', 'canva-backend'),
			];

			$args = [
				'label' 				=> __('Project types', 'canva-backend'),
				'labels' 				=> $labels,
				'public' 				=> false,
				'publicly_queryable' 	=> true,
				'hierarchical' 			=> true,
				'show_ui' 				=> true,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' 	=> false,
				'query_var' 			=> true,
				'rewrite' 				=> ['slug' => 'project-type', 'with_front' => true],
				'show_admin_column' 	=> true,
				'show_in_rest' 			=> true,
				'rest_base' 			=> 'project-type',
				'rest_controller_class' => 'WP_REST_Terms_Controller',
				'show_in_quick_edit' 	=> false,
			];
			register_taxonomy('project-type', ['project'], $args);
		}
		add_action('init', 'canva_register_tax_project_type');
	}


	if (get_field('stores_post_type', 'options')) {
		function canva_register_cpt_stores()
		{
			/**
			 * Post Type: Stores.
			 */
			$labels = [
				'name' 			=> __('Stores', 'canva-backend'),
				'singular_name' => __('Store', 'canva-backend'),
			];

			$args = [
				'label' 					=> __('Stores', 'canva-backend'),
				'labels' 					=> $labels,
				'description' 				=> '',
				'public' 					=> true,
				'publicly_queryable' 		=> true,
				'show_ui' 					=> true,
				'show_in_rest' 				=> true,
				'rest_base' 				=> '',
				'rest_controller_class' 	=> 'WP_REST_Posts_Controller',
				'has_archive' 				=> false,
				'show_in_menu' 				=> true,
				'show_in_nav_menus'			=> false,
				'delete_with_user' 			=> false,
				'exclude_from_search' 		=> false,
				'capability_type' 			=> ['store', 'stores'],
				'map_meta_cap' 				=> true,
				'hierarchical' 				=> false,
				'rewrite' 					=> ['slug' => 'store', 'with_front' => true],
				'query_var' 				=> true,
				'menu_icon' 				=> 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 616 512" fill="#ffffff"><path d="M602 118.6L537.1 15C531.3 5.7 521 0 510 0H106C95 0 84.7 5.7 78.9 15L14 118.6c-29.6 47.2-10 110.6 38 130.8v227.4c0 19.4 14.3 35.2 32 35.2h448c17.7 0 32-15.8 32-35.2V249.4c48-20.2 67.6-83.6 38-130.8zM516 464H100v-96h416zm-.2-144.2H100v-64.7c24-3.3 45.1-15.2 60.3-32.2 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 18 20.1 44.3 33.1 73.8 33.1 29.6 0 55.8-13 73.8-33.1 15.3 17 36.3 28.9 60.3 32.2zm47.9-133c-3.2 6.8-10.9 18.6-27 20.8-2.4.3-4.8.5-7.2.5-14.7 0-28.2-6.1-38.1-17.2L455.7 151 420 190.8c-9.9 11.1-23.5 17.2-38.1 17.2s-28.2-6.1-38.1-17.2L308 151l-35.7 39.8c-9.9 11.1-23.5 17.2-38.1 17.2-14.7 0-28.2-6.1-38.1-17.2L160.3 151l-35.7 39.8c-9.9 11.1-23.5 17.2-38.1 17.2-2.5 0-4.9-.2-7.2-.5-16-2.2-23.8-13.9-27-20.8-5-10.8-7.1-27.6 2.3-42.6L114.8 48h386.3l60.2 96.1c9.5 15.1 7.5 31.9 2.4 42.7z"/></svg>'),
				'supports' 					=> ['title', 'editor', 'thumbnail', 'author', 'revisions'],
			];

			register_post_type('stores', $args);
		}

		add_action('init', 'canva_register_cpt_stores');
	}

	if (get_field('events_post_type', 'options')) {
		function canva_register_cpt_events()
		{
			/**
			 * Post Type: Events.
			 */
			$labels = [
				'name' 				=> __('Events', 'canva-backend'),
				'singular_name' 	=> __('Event', 'canva-backend'),
			];

			$args = [
				'label' 				=> __('Events', 'canva-backend'),
				'labels' 				=> $labels,
				'description' 			=> '',
				'public' 				=> true,
				'publicly_queryable' 	=> true,
				'show_ui' 				=> true,
				'show_in_rest' 			=> true,
				'rest_base' 			=> '',
				'rest_controller_class' => 'WP_REST_Posts_Controller',
				'has_archive'			 => false,
				'show_in_menu' 			=> true,
				'show_in_nav_menus' 	=> true,
				'delete_with_user' 		=> false,
				'exclude_from_search' 	=> false,
				'capability_type' 		=> ['event', 'events'],
				'map_meta_cap' 			=> true,
				'hierarchical' 			=> false,
				'rewrite' 				=> ['slug' => 'event', 'with_front' => true],
				'query_var' 			=> true,
				'menu_icon' 			=> 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#ffffff"><path d="M148 288h-40c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12zm108-12v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 96v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm-96 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm192 0v-40c0-6.6-5.4-12-12-12h-40c-6.6 0-12 5.4-12 12v40c0 6.6 5.4 12 12 12h40c6.6 0 12-5.4 12-12zm96-260v352c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V112c0-26.5 21.5-48 48-48h48V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h128V12c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v52h48c26.5 0 48 21.5 48 48zm-48 346V160H48v298c0 3.3 2.7 6 6 6h340c3.3 0 6-2.7 6-6z"/></svg>'),
				'supports' 				=> ['title', 'editor', 'thumbnail', 'author', 'revisions'],
				'taxonomies' 			=> ['event-cat'],
			];
			register_post_type('event', $args);
		}

		add_action('init', 'canva_register_cpt_events');

		// Events - Event Taxonomy

		function canva_register_tax_events_cat()
		{
			/**
			 * Taxonomy: event-cat.
			 */
			$labels = [
				'name' 				=> __('Categories', 'canva-backend'),
				'singular_name' 	=> __('Category', 'canva-backend'),
			];

			$args = [
				'label' 					=> __('Categories', 'canva-backend'),
				'labels' 					=> $labels,
				'public' 					=> false,
				'publicly_queryable' 		=> true,
				'hierarchical' 				=> true,
				'show_ui' 					=> true,
				'show_in_menu' 				=> true,
				'show_in_nav_menus' 		=> false,
				'query_var' 				=> true,
				'rewrite' 					=> ['slug' => 'event-cat', 'with_front' => true],
				'show_admin_column' 		=> true,
				'show_in_rest' 				=> true,
				'rest_base' 				=> 'event-cat',
				'rest_controller_class' 	=> 'WP_REST_Terms_Controller',
				'show_in_quick_edit' 		=> false,
			];
			register_taxonomy('event-cat', ['event'], $args);
		}
		add_action('init', 'canva_register_tax_events_cat');
	}


	if (get_field('faq_post_type', 'options')) {
		function canva_register_cpt_faq()
		{

			/**
			 * Post Type: FAQ.
			 */

			$labels = [
				"name" 							=> __("FAQs", "custom-post-type-ui"),
				"singular_name"					=> __("FAQ", "custom-post-type-ui"),
				"menu_name" 					=> __("FAQ", "custom-post-type-ui"),
				"all_items" 					=> __("All FAQs", "custom-post-type-ui"),
				"add_new"						=> __("Add new", "custom-post-type-ui"),
				"add_new_item" 					=> __("Add new FAQ", "custom-post-type-ui"),
				"edit_item" 					=> __("Edit FAQ", "custom-post-type-ui"),
				"new_item" 						=> __("New FAQ", "custom-post-type-ui"),
				"view_item" 					=> __("View FAQ", "custom-post-type-ui"),
				"view_items" 					=> __("View FAQs", "custom-post-type-ui"),
				"search_items" 					=> __("Search FAQs", "custom-post-type-ui"),
				"not_found" 					=> __("No FAQs founds", "custom-post-type-ui"),
				"not_found_in_trash" 			=> __("No FAQs found in trash", "custom-post-type-ui"),
				"parent" 						=> __("Parent FAQ:", "custom-post-type-ui"),
				"featured_image" 				=> __("FAQ featured image", "custom-post-type-ui"),
				"set_featured_image" 			=> __("Set as FAQ featured image", "custom-post-type-ui"),
				"remove_featured_image" 		=> __("Remove as featured image", "custom-post-type-ui"),
				"use_featured_image" 			=> __("Use featured image", "custom-post-type-ui"),
				"archives" 						=> __("FAQ archive", "custom-post-type-ui"),
				"insert_into_item" 				=> __("Insert in this FAQ", "custom-post-type-ui"),
				"uploaded_to_this_item" 		=> __("Uploaded to this FAQ", "custom-post-type-ui"),
				"filter_items_list" 			=> __("Filter the list of FAQs", "custom-post-type-ui"),
				"items_list_navigation" 		=> __("FAQ navigation item list", "custom-post-type-ui"),
				"items_list" 					=> __("FAQ list", "custom-post-type-ui"),
				"attributes" 					=> __("FAQ attributes", "custom-post-type-ui"),
				"name_admin_bar" 				=> __("FAQ", "custom-post-type-ui"),
				"item_published" 				=> __("FAQ published.", "custom-post-type-ui"),
				"item_published_privately" 		=> __("FAQ published privately.", "custom-post-type-ui"),
				"item_reverted_to_draft" 		=> __("FAQ reverted to draft.", "custom-post-type-ui"),
				"item_scheduled" 				=> __("FAQ scheduled.", "custom-post-type-ui"),
				"item_updated" 					=> __("FAQ updated.", "custom-post-type-ui"),
				"parent_item_colon" 			=> __("Parent FAQ:", "custom-post-type-ui"),
			];

			$args = [
				"label" 						=> __("FAQ", "custom-post-type-ui"),
				"labels" 						=> $labels,
				"description" 					=> "",
				"public" 						=> true,
				"publicly_queryable" 			=> true,
				"show_ui" 						=> true,
				"show_in_rest" 					=> true,
				"rest_base" 					=> "",
				"rest_controller_class" 		=> "WP_REST_Posts_Controller",
				"has_archive" 					=> false,
				"show_in_menu" 					=> true,
				"show_in_nav_menus"				=> true,
				"delete_with_user" 				=> false,
				"exclude_from_search" 			=> false,
				'capability_type' 				=> ['faq', 'faqs'],
				"map_meta_cap" 					=> true,
				"hierarchical" 					=> false,
				"rewrite" 						=> ["slug" => "faq", "with_front" => true],
				"query_var" 					=> true,
				"supports" 						=> ['title', 'thumbnail', 'author', 'revisions'],
				"show_in_graphql" 				=> false,
				'taxonomies' 					=> ['faq-cat'],
			];

			register_post_type("faq", $args);
		}

		add_action('init', 'canva_register_cpt_faq');


		function canva_register_tax_faq_cat()
		{

			/**
			 * Taxonomy: Tipologie FAQ.
			 */

			$labels = [
				"name" 							=> __("FAQ types", "custom-post-type-ui"),
				"singular_name" 				=> __("FAQ type", "custom-post-type-ui"),
				"menu_name" 					=> __("FAQ types", "custom-post-type-ui"),
				"all_items" 					=> __("All FAQ Types", "custom-post-type-ui"),
				"edit_item" 					=> __("Edit FAQ Type", "custom-post-type-ui"),
				"view_item" 					=> __("View FAQ Type", "custom-post-type-ui"),
				"update_item" 					=> __("Update FAQ Type name", "custom-post-type-ui"),
				"add_new_item" 					=> __("Add new FAQ Type", "custom-post-type-ui"),
				"new_item_name" 				=> __("New FAQ Type naome", "custom-post-type-ui"),
				"parent_item" 					=> __("Parent FAQ Type", "custom-post-type-ui"),
				"parent_item_colon" 			=> __("FAQ Type parent:", "custom-post-type-ui"),
				"search_items" 					=> __("Search FAQ Types", "custom-post-type-ui"),
				"popular_items" 				=> __("Popular FAQ Types", "custom-post-type-ui"),
				"separate_items_with_commas" 	=> __("Separate FAQ Types with commas", "custom-post-type-ui"),
				"add_or_remove_items" 			=> __("Add or remove FAQ Types", "custom-post-type-ui"),
				"choose_from_most_used" 		=> __("Choose from the most used FAQ Types", "custom-post-type-ui"),
				"not_found" 					=> __("No FAQ Type found", "custom-post-type-ui"),
				"no_terms"						=> __("No FAQ Types", "custom-post-type-ui"),
				"items_list_navigation" 		=> __("FAQ Types list navigation", "custom-post-type-ui"),
				"items_list" 					=> __("FAQ Types list", "custom-post-type-ui"),
				"back_to_items" 				=> __("Back to FAQ Types", "custom-post-type-ui"),
			];


			$args = [
				"label" 					=> __("FAQ Types", "custom-post-type-ui"),
				"labels" 					=> $labels,
				"public" 					=> true,
				"publicly_queryable" 		=> true,
				"hierarchical" 				=> true,
				"show_ui" 					=> true,
				"show_in_menu" 				=> true,
				"show_in_nav_menus" 		=> true,
				"query_var" 				=> true,
				"rewrite" 					=> ['slug' => 'faq-cat', 'with_front' => true,],
				"show_admin_column" 		=> true,
				"show_in_rest" 				=> true,
				"rest_base" 				=> "faq-cat",
				"rest_controller_class" 	=> "WP_REST_Terms_Controller",
				"show_in_quick_edit" 		=> true,
				"show_in_graphql" 			=> false,
				"meta_box_cb"				 => false,
			];
			register_taxonomy("faq-cat", ["faq"], $args);
		}
		add_action('init', 'canva_register_tax_faq_cat');
	}

	function canva_register_cpt_common_blocks()
	{
		/**
		 * Post Type: Common Blocks.
		 */
		$labels = [
			'name' 					=> __('Common Blocks', 'canva-backend'),
			'singular_name' 		=> __('Common Blocks', 'canva-backend'),
			'menu_name' 			=> __('Common Blocks', 'canva-backend'),
			'all_items' 			=> __('All Common Blocks', 'canva-backend'),
			'add_new' 				=> __('Add Common Block', 'canva-backend'),
			'add_new_item' 			=> __('Add new Common Block', 'canva-backend'),
			'edit_item' 			=> __('Edit Common Block', 'canva-backend'),
			'new_item' 				=> __('New Common Block', 'canva-backend'),
			'view_item' 			=> __('View Common Block', 'canva-backend'),
			'view_items' 			=> __('View Common Blocks', 'canva-backend'),
			'search_items' 			=> __('Search a Common Block', 'canva-backend'),
			'not_found' 			=> __('No Common Blocks found', 'canva-backend'),
			'not_found_in_trash' 	=> __('No Common Blocks found in trash', 'canva-backend'),
		];

		$args = [
			'label' 				=> __('Common Blocks', 'canva-backend'),
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
			'capability_type' 		=> ['common_block', 'common_blocks'],
			'map_meta_cap' 			=> true,
			'hierarchical' 			=> false,
			'rewrite' 				=> ['slug' => 'common-blocks', 'with_front' => true],
			// 'menu_icon' 			=> 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="#FFFFFF"><path d="M437.983 261.352c-4.321 2.778-10.839 6.969-13.122 7.279-24.067-.092.757-103.841 5.813-124.714-29.614 5.697-134.448 26.337-159.932 7.046C271.197 132.585 304 116.55 304 73.588 304 28.222 261.986 0 216.994 0 171.147 0 112 25.756 112 75.063c0 40.881 28.702 64.642 31.994 74.559-.739 28.838-115.981 1.752-143.994-5.469v351.556C10.464 498.412 56.682 512 104 512c45.3-.001 88-15.737 88-60.854 0-31.773-32-45.657-32-73.834 0-16.521 29.235-27.063 49.361-27.063 21.125 0 46.639 11.414 46.639 25.588 0 24.02-32 36.882-32 77.924 0 66.838 81.555 58.073 134.44 51.225 37.039-4.797 33.159-3.906 73.069-3.906-2.799-8.954-28.061-81.125-13.892-100.4 10.021-13.639 39.371 31.32 84.037 31.32C548.715 432 576 380.487 576 336c0-57.793-45.975-133.814-138.017-74.648zM501.654 384c-24.507 0-37.496-32.763-79.116-32.763-35.286 0-67.12 27.143-53.431 104.031-19.03 2.234-84.249 12.922-96.329 2.29C261.633 447.771 304 419.385 304 375.837c0-46.326-49.475-73.588-94.639-73.588-46.686 0-97.361 27.417-97.361 75.063 0 50.809 41.414 70.396 29.601 79.554-16.851 13.064-71.854 5.122-93.601.935V204.584c63.934 10.948 144 9.33 144-55.435 0-31.802-32-45.775-32-74.086C160 58.488 199.338 48 216.994 48 233.19 48 256 55.938 256 73.588c0 23.524-33.264 36.842-33.264 77.924 0 60.396 86.897 58.813 146.508 51.68-6.592 53.714 1.669 113.439 55.691 113.439 31.223 0 45.141-28.631 75.22-28.631C517.407 288 528 315.957 528 336c0 21.606-12.157 48-26.346 48z"/></svg>'),
			'menu_icon' 			=> 'dashicons-editor-table',
			// "rewrite" 			=> false,
			'query_var' 			=> true,
			'supports' 				=> ['title', 'editor', 'thumbnail', 'author', 'revisions'],
		];

		register_post_type('common-blocks', $args);
	}

	add_action('init', 'canva_register_cpt_common_blocks');
} //endif


function cptui_register_my_taxes_progress_status()
{

	/**
	 * Taxonomy: Progress Status.
	 */

	$labels = [
		"name" 					=> __("Progress", "canva-backend"),
		"singular_name" 		=> __("Progress", "canva-backend"),
	];


	$args = [
		"label" 				=> __("Progress", "canva-backend"),
		"labels" 				=> $labels,
		"public" 				=> false,
		"publicly_queryable" 	=> false,
		"hierarchical" 			=> true,
		"show_ui" 				=> true,
		"show_in_menu" 			=> true,
		"show_in_nav_menus" 	=> false,
		"query_var" 			=> false,
		"rewrite" 				=> ['slug' => 'progress_status', 'with_front' => true,],
		"show_admin_column" 	=> true,
		"show_in_rest" 			=> true,
		"rest_base" 			=> "progress_status",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" 	=> true,
		"show_in_graphql" 		=> false,
		// "default_term" 			=> ['name' => 'Status-0'],
	];

	// dump_to_error_log(get_post_types());

	$post_types = get_post_types(['_builtin' => false]);

	//delete element by value
	if (($key = array_search('acf-field-group', $post_types)) !== false) {
		unset($post_types[$key]);
	}

	register_taxonomy("progress_status", array_merge(["page", "post"], $post_types), $args);
}
add_action('init', 'cptui_register_my_taxes_progress_status');

//register default terms for progress_status
// wp_create_term('Status-0', 'progress_status');
// wp_create_term('Status-25', 'progress_status');
// wp_create_term('Status-50', 'progress_status');
// wp_create_term('Status-75', 'progress_status');
// wp_create_term('Status-100', 'progress_status');




/**
 * Canva capabilities for default Custom Post Types common_blocks, people, stores, events for admnistrator & editor roles
 *
 * @return void
 */

function canva_cpt_capabilities()
{
	$roles = array('editor', 'administrator');

	foreach ($roles as $the_role) {

		$role = get_role($the_role);

		//common
		// $role->add_cap('manage_options');

		//common_blocks
		$role->add_cap('read_common_block');
		$role->add_cap('read_private_common_blocks');
		$role->add_cap('edit_common_block');
		$role->add_cap('edit_common_blocks');
		$role->add_cap('edit_others_common_blocks');
		$role->add_cap('edit_published_common_blocks');
		$role->add_cap('publish_common_blocks');
		$role->add_cap('delete_common_blocks');
		$role->add_cap('delete_others_common_blocks');
		$role->add_cap('delete_private_common_blocks');
		$role->add_cap('delete_published_common_blocks');

		//persons
		$role->add_cap('read_person');
		$role->add_cap('read_private_persons');
		$role->add_cap('edit_person');
		$role->add_cap('edit_persons');
		$role->add_cap('edit_others_persons');
		$role->add_cap('edit_published_persons');
		$role->add_cap('publish_persons');
		$role->add_cap('delete_persons');
		$role->add_cap('delete_others_persons');
		$role->add_cap('delete_private_persons');
		$role->add_cap('delete_published_persons');

		//project
		$role->add_cap('read_project');
		$role->add_cap('read_private_projects');
		$role->add_cap('edit_project');
		$role->add_cap('edit_projects');
		$role->add_cap('edit_others_projects');
		$role->add_cap('edit_published_projects');
		$role->add_cap('publish_projects');
		$role->add_cap('delete_projects');
		$role->add_cap('delete_others_projects');
		$role->add_cap('delete_private_projects');
		$role->add_cap('delete_published_projects');

		//stores
		$role->add_cap('read_store');
		$role->add_cap('read_private_stores');
		$role->add_cap('edit_store');
		$role->add_cap('edit_stores');
		$role->add_cap('edit_others_stores');
		$role->add_cap('edit_published_stores');
		$role->add_cap('publish_stores');
		$role->add_cap('delete_stores');
		$role->add_cap('delete_others_stores');
		$role->add_cap('delete_private_stores');
		$role->add_cap('delete_published_stores');

		//events
		$role->add_cap('read_event');
		$role->add_cap('read_private_events');
		$role->add_cap('edit_event');
		$role->add_cap('edit_events');
		$role->add_cap('edit_others_events');
		$role->add_cap('edit_published_events');
		$role->add_cap('publish_events');
		$role->add_cap('delete_events');
		$role->add_cap('delete_others_events');
		$role->add_cap('delete_private_events');
		$role->add_cap('delete_published_events');

		//faq
		$role->add_cap('read_faq');
		$role->add_cap('read_private_faqs');
		$role->add_cap('edit_faq');
		$role->add_cap('edit_faqs');
		$role->add_cap('edit_others_faqs');
		$role->add_cap('edit_published_faqs');
		$role->add_cap('publish_faqs');
		$role->add_cap('delete_faqs');
		$role->add_cap('delete_others_faqs');
		$role->add_cap('delete_private_faqs');
		$role->add_cap('delete_published_faqs');
	}
}
add_action('init', 'canva_cpt_capabilities');
