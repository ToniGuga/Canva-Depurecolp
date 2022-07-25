<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}
function cptui_register_my_cpts()
{

	/**
	 * Post Type: Centri.
	 */

	$labels = [
		"name" => __("Centri", "canva"),
		"singular_name" => __("Centro", "canva"),
		"menu_name" => __("Centri", "canva"),
		"all_items" => __("Tutti i Centri", "canva"),
		"add_new" => __("Aggiungi nuovo", "canva"),
		"add_new_item" => __("Aggiungi nuovo Centro", "canva"),
		"edit_item" => __("Modifica Centro", "canva"),
		"new_item" => __("Nuovo Centro", "canva"),
		"view_item" => __("Visualizza Centro", "canva"),
		"view_items" => __("Visualizza Centri", "canva"),
		"search_items" => __("Cerca Centri", "canva"),
		"not_found" => __("No Centri", "canva"),
		"not_found_in_trash" => __("No Centri found in trash", "canva"),
		"parent" => __("Genitore Centro:", "canva"),
		"featured_image" => __("Featured image for this Centro", "canva"),
		"set_featured_image" => __("Set featured image for this Centro", "canva"),
		"remove_featured_image" => __("Remove featured image for this Centro", "canva"),
		"use_featured_image" => __("Use as featured image for this Centro", "canva"),
		"archives" => __("Centro archives", "canva"),
		"insert_into_item" => __("Insert into Centro", "canva"),
		"uploaded_to_this_item" => __("Upload to this Centro", "canva"),
		"filter_items_list" => __("Filter Centri list", "canva"),
		"items_list_navigation" => __("Centri list navigation", "canva"),
		"items_list" => __("Centri list", "canva"),
		"attributes" => __("Centri attributes", "canva"),
		"name_admin_bar" => __("Centro", "canva"),
		"item_published" => __("Centro published", "canva"),
		"item_published_privately" => __("Centro published privately.", "canva"),
		"item_reverted_to_draft" => __("Centro reverted to draft.", "canva"),
		"item_scheduled" => __("Centro scheduled", "canva"),
		"item_updated" => __("Centro updated.", "canva"),
		"parent_item_colon" => __("Genitore Centro:", "canva"),
	];

	$args = [
		"label" => __("Centri", "canva"),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => ["centro", "centri"],
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => ["slug" => "centro", "with_front" => true],
		"query_var" => true,
		"supports" => ["title", "editor", "thumbnail"],
		"show_in_graphql" => false,
	];

	register_post_type("centro", $args);

	/**
	 * Post Type: Servizi.
	 */

	$labels = [
		"name" => __("Servizi", "canva"),
		"singular_name" => __("Servizio", "canva"),
		"menu_name" => __("Servizi", "canva"),
		"all_items" => __("Tutto i Servizi", "canva"),
		"add_new" => __("Aggiungi nuovo", "canva"),
		"add_new_item" => __("Aggiungi nuovo Servizio", "canva"),
		"edit_item" => __("Modifica Servizio", "canva"),
		"new_item" => __("Nuovo Servizio", "canva"),
		"view_item" => __("Visualizza Servizio", "canva"),
		"view_items" => __("Visualizza Servizi", "canva"),
		"search_items" => __("Cerca Servizi", "canva"),
		"not_found" => __("No Servizi found", "canva"),
		"not_found_in_trash" => __("No Servizi found in trash", "canva"),
		"parent" => __("Genitore Servizio:", "canva"),
		"featured_image" => __("Featured image for this Servizio", "canva"),
		"set_featured_image" => __("Set featured image for this Servizio", "canva"),
		"remove_featured_image" => __("Remove featured image for this Servizio", "canva"),
		"use_featured_image" => __("Use as featured image for this Servizio", "canva"),
		"archives" => __("Servizio archives", "canva"),
		"insert_into_item" => __("Insert into Servizio", "canva"),
		"uploaded_to_this_item" => __("Upload to this Servizio", "canva"),
		"filter_items_list" => __("Filter Servizi list", "canva"),
		"items_list_navigation" => __("Servizi list navigation", "canva"),
		"items_list" => __("Servizi list", "canva"),
		"attributes" => __("Servizi attributes", "canva"),
		"name_admin_bar" => __("Servizio", "canva"),
		"item_published" => __("Servizio published", "canva"),
		"item_published_privately" => __("Servizio published privately.", "canva"),
		"item_reverted_to_draft" => __("Servizio reverted to draft.", "canva"),
		"item_scheduled" => __("Servizio scheduled", "canva"),
		"item_updated" => __("Servizio updated.", "canva"),
		"parent_item_colon" => __("Genitore Servizio:", "canva"),
	];

	$args = [
		"label" => __("Servizi", "canva"),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"delete_with_user" => false,
		"exclude_from_search" => false,
		"capability_type" => ["servizio", "servizi"],
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => ["slug" => "servizio", "with_front" => true],
		"query_var" => true,
		"supports" => ["title", "editor", "thumbnail","revisions"],
		"show_in_graphql" => false,
		"template" => [
			['acf/hero-cta'],
			['acf/bt-white-img-text'],
			['acf/bt-gray-grid-items'],
			['acf/bt-in-depth'],
			['acf/bt-list-numbers'],
			['acf/bt-list-ckeck'],
		],
	];

	register_post_type("servizio", $args);

	/**
	 * Post Type: Candidature.
	 */

	// $labels = [
	// 	"name" => __("Candidature", "canva"),
	// 	"singular_name" => __("Candidatura", "canva"),
	// 	"menu_name" => __("Candidature", "canva"),
	// 	"all_items" => __("Tutte le Candidature", "canva"),
	// 	"add_new" => __("Aggiungi nuovo", "canva"),
	// 	"add_new_item" => __("Aggiungi nuova Candidatura", "canva"),
	// 	"edit_item" => __("Modifica Candidatura", "canva"),
	// 	"new_item" => __("Nuova Candidatura", "canva"),
	// 	"view_item" => __("Visualizza Candidatura", "canva"),
	// 	"view_items" => __("Visualizza Candidature", "canva"),
	// 	"search_items" => __("Cerca Candidature", "canva"),
	// 	"not_found" => __("No Candidature found", "canva"),
	// 	"not_found_in_trash" => __("No Candidature found in trash", "canva"),
	// 	"parent" => __("Genitore Candidatura:", "canva"),
	// 	"featured_image" => __("Featured image for this Candidatura", "canva"),
	// 	"set_featured_image" => __("Set featured image for this Candidatura", "canva"),
	// 	"remove_featured_image" => __("Remove featured image for this Candidatura", "canva"),
	// 	"use_featured_image" => __("Use as featured image for this Candidatura", "canva"),
	// 	"archives" => __("Candidatura archives", "canva"),
	// 	"insert_into_item" => __("Insert into Candidatura", "canva"),
	// 	"uploaded_to_this_item" => __("Upload to this Candidatura", "canva"),
	// 	"filter_items_list" => __("Filter Candidature list", "canva"),
	// 	"items_list_navigation" => __("Candidature list navigation", "canva"),
	// 	"items_list" => __("Candidature list", "canva"),
	// 	"attributes" => __("Candidature attributes", "canva"),
	// 	"name_admin_bar" => __("Candidatura", "canva"),
	// 	"item_published" => __("Candidatura published", "canva"),
	// 	"item_published_privately" => __("Candidatura published privately.", "canva"),
	// 	"item_reverted_to_draft" => __("Candidatura reverted to draft.", "canva"),
	// 	"item_scheduled" => __("Candidatura scheduled", "canva"),
	// 	"item_updated" => __("Candidatura updated.", "canva"),
	// 	"parent_item_colon" => __("Genitore Candidatura:", "canva"),
	// ];

	// $args = [
	// 	"label" => __("Candidature", "canva"),
	// 	"labels" => $labels,
	// 	"description" => "",
	// 	"public" => true,
	// 	"publicly_queryable" => true,
	// 	"show_ui" => true,
	// 	"show_in_rest" => true,
	// 	"rest_base" => "",
	// 	"rest_controller_class" => "WP_REST_Posts_Controller",
	// 	"has_archive" => false,
	// 	"show_in_menu" => true,
	// 	"show_in_nav_menus" => true,
	// 	"delete_with_user" => false,
	// 	"exclude_from_search" => false,
	// 	"capability_type" => ["candidatura", "candidature"],
	// 	"map_meta_cap" => true,
	// 	"hierarchical" => false,
	// 	"rewrite" => ["slug" => "candidatura", "with_front" => true],
	// 	"query_var" => true,
	// 	"supports" => ["title", "editor", "thumbnail"],
	// 	"show_in_graphql" => false,
	// ];

	// register_post_type("candidatura", $args);

	/**
	 * Post Type: Candidature Ricevute.
	 */

	// $labels = [
	// 	"name" => __("Candidature Ricevute", "canva"),
	// 	"singular_name" => __("Candidatura Ricevuta", "canva"),
	// 	"menu_name" => __("Candidature Ricevute", "canva"),
	// 	"all_items" => __("Candidature Ricevute", "canva"),
	// 	"add_new" => __("Aggiungi nuovo", "canva"),
	// 	"add_new_item" => __("Aggiungi nuova Candidatura Ricevuta", "canva"),
	// 	"edit_item" => __("Modifica Candidatura Ricevuta", "canva"),
	// 	"new_item" => __("Nuova Candidatura Ricevuta", "canva"),
	// 	"view_item" => __("Visualizza Candidatura Ricevuta", "canva"),
	// 	"view_items" => __("Visualizza Candidature Ricevute", "canva"),
	// 	"search_items" => __("Cerca Candidature Ricevute", "canva"),
	// 	"not_found" => __("No Candidature Ricevute found", "canva"),
	// 	"not_found_in_trash" => __("No Candidature Ricevute found in trash", "canva"),
	// 	"parent" => __("Genitore Candidatura Ricevuta:", "canva"),
	// 	"featured_image" => __("Featured image for this Candidatura Ricevuta", "canva"),
	// 	"set_featured_image" => __("Set featured image for this Candidatura Ricevuta", "canva"),
	// 	"remove_featured_image" => __("Remove featured image for this Candidatura Ricevuta", "canva"),
	// 	"use_featured_image" => __("Use as featured image for this Candidatura Ricevuta", "canva"),
	// 	"archives" => __("Candidatura Ricevuta archives", "canva"),
	// 	"insert_into_item" => __("Insert into Candidatura Ricevuta", "canva"),
	// 	"uploaded_to_this_item" => __("Upload to this Candidatura Ricevuta", "canva"),
	// 	"filter_items_list" => __("Filter Candidature Ricevute list", "canva"),
	// 	"items_list_navigation" => __("Candidature Ricevute list navigation", "canva"),
	// 	"items_list" => __("Candidature Ricevute list", "canva"),
	// 	"attributes" => __("Candidature Ricevute attributes", "canva"),
	// 	"name_admin_bar" => __("Candidatura Ricevuta", "canva"),
	// 	"item_published" => __("Candidatura Ricevuta published", "canva"),
	// 	"item_published_privately" => __("Candidatura Ricevuta published privately.", "canva"),
	// 	"item_reverted_to_draft" => __("Candidatura Ricevuta reverted to draft.", "canva"),
	// 	"item_scheduled" => __("Candidatura Ricevuta scheduled", "canva"),
	// 	"item_updated" => __("Candidatura Ricevuta updated.", "canva"),
	// 	"parent_item_colon" => __("Genitore Candidatura Ricevuta:", "canva"),
	// ];

	// $args = [
	// 	"label" => __("Candidature Ricevute", "canva"),
	// 	"labels" => $labels,
	// 	"description" => "",
	// 	"public" => false,
	// 	"publicly_queryable" => false,
	// 	"show_ui" => true,
	// 	"show_in_rest" => true,
	// 	"rest_base" => "",
	// 	"rest_controller_class" => "WP_REST_Posts_Controller",
	// 	"has_archive" => false,
	// 	"show_in_menu" => "edit.php?post_type=candidatura",
	// 	"show_in_nav_menus" => false,
	// 	"delete_with_user" => false,
	// 	"exclude_from_search" => false,
	// 	"capability_type" => ["candidatura", "candidature"],
	// 	"map_meta_cap" => true,
	// 	"hierarchical" => false,
	// 	"rewrite" => ["slug" => "candidatura-ricevuta", "with_front" => true],
	// 	"query_var" => true,
	// 	"supports" => ["title", "editor", "thumbnail"],
	// 	"show_in_graphql" => false,
	// ];

	// register_post_type("candidatura-ricevuta", $args);

	/**
	 * Post Type: Open Days.
	 */

	// $labels = [
	// 	"name" => __("Open Days", "canva"),
	// 	"singular_name" => __("Open Day", "canva"),
	// 	"menu_name" => __("Open Days", "canva"),
	// 	"all_items" => __("Tutti gli Open Days", "canva"),
	// 	"add_new" => __("Aggiungi nuovo", "canva"),
	// 	"add_new_item" => __("Aggiungi un nuovo Open Day", "canva"),
	// 	"edit_item" => __("Modifica Open Day", "canva"),
	// 	"new_item" => __("Nuovo Open Day", "canva"),
	// 	"view_item" => __("Visualizza Open Day", "canva"),
	// 	"view_items" => __("Visualizza Open Days", "canva"),
	// 	"search_items" => __("Cerca Open Days", "canva"),
	// 	"not_found" => __("No Open Days found", "canva"),
	// 	"not_found_in_trash" => __("No Open Days found in trash", "canva"),
	// 	"parent" => __("Genitore Open Day:", "canva"),
	// 	"featured_image" => __("Featured image for this Open Day", "canva"),
	// 	"set_featured_image" => __("Set featured image for this Open Day", "canva"),
	// 	"remove_featured_image" => __("Remove featured image for this Open Day", "canva"),
	// 	"use_featured_image" => __("Use as featured image for this Open Day", "canva"),
	// 	"archives" => __("Open Day archives", "canva"),
	// 	"insert_into_item" => __("Insert into Open Day", "canva"),
	// 	"uploaded_to_this_item" => __("Upload to this Open Day", "canva"),
	// 	"filter_items_list" => __("Filter Open Days list", "canva"),
	// 	"items_list_navigation" => __("Open Days list navigation", "canva"),
	// 	"items_list" => __("Open Days list", "canva"),
	// 	"attributes" => __("Open Days attributes", "canva"),
	// 	"name_admin_bar" => __("Open Day", "canva"),
	// 	"item_published" => __("Open Day published", "canva"),
	// 	"item_published_privately" => __("Open Day published privately.", "canva"),
	// 	"item_reverted_to_draft" => __("Open Day reverted to draft.", "canva"),
	// 	"item_scheduled" => __("Open Day scheduled", "canva"),
	// 	"item_updated" => __("Open Day updated.", "canva"),
	// 	"parent_item_colon" => __("Genitore Open Day:", "canva"),
	// ];

	// $args = [
	// 	"label" => __("Open Days", "canva"),
	// 	"labels" => $labels,
	// 	"description" => "",
	// 	"public" => true,
	// 	"publicly_queryable" => true,
	// 	"show_ui" => true,
	// 	"show_in_rest" => true,
	// 	"rest_base" => "",
	// 	"rest_controller_class" => "WP_REST_Posts_Controller",
	// 	"has_archive" => false,
	// 	"show_in_menu" => true,
	// 	"show_in_nav_menus" => true,
	// 	"delete_with_user" => false,
	// 	"exclude_from_search" => false,
	// 	"capability_type" => ["openday", "opendays"],
	// 	"map_meta_cap" => true,
	// 	"hierarchical" => false,
	// 	"rewrite" => ["slug" => "open-day", "with_front" => true],
	// 	"query_var" => true,
	// 	"supports" => ["title", "editor", "thumbnail"],
	// 	"show_in_graphql" => false,
	// ];

	// register_post_type("open-day", $args);
}

add_action('init', 'cptui_register_my_cpts');



function cptui_register_my_taxes()
{

	/**
	 * Taxonomy: Brands.
	 */

	$labels = [
		"name" => __("Brands", "canva"),
		"singular_name" => __("Brand", "canva"),
	];


	$args = [
		"label" => __("Brands", "canva"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => false,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => ['slug' => 'brand', 'with_front' => true,  'hierarchical' => true,],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "brand",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy("brand", ["centro"], $args);

	/**
	 * Taxonomy: Open Day Types.
	 */

	$labels = [
		"name" => __("Open Day Types", "canva"),
		"singular_name" => __("Open Day Type", "canva"),
	];


	$args = [
		"label" => __("Open Day Types", "canva"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => false,
		"hierarchical" => true,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => ['slug' => 'open_day_types', 'with_front' => true,  'hierarchical' => true,],
		"show_admin_column" => true,
		"show_in_rest" => true,
		"rest_base" => "open_day_types",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy("open_day_types", ["centro"], $args);

	/**
	 * Taxonomy: Tipologie Servizi.
	 */

	$labels = [
		"name" => __("Tipologie Servizi", "canva"),
		"singular_name" => __("Tipologia Servizo", "canva"),
		"menu_name" => __("Tipologie Servizi", "canva"),
		"all_items" => __("Tutte le Tipologie Servizi", "canva"),
		"edit_item" => __("Modifica Tipologia Servizo", "canva"),
		"view_item" => __("Visualizza Tipologia Servizo", "canva"),
		"update_item" => __("Update Tipologia Servizo name", "canva"),
		"add_new_item" => __("Aggiungi nuova Tipologia Servizo", "canva"),
		"new_item_name" => __("Nuovo nome Tipologia Servizo", "canva"),
		"parent_item" => __("Tipologia Servizo genitore", "canva"),
		"parent_item_colon" => __("Genitore Tipologia Servizo:", "canva"),
		"search_items" => __("Cerca Tipologie Servizi", "canva"),
		"popular_items" => __("Tipologie Servizi popolari", "canva"),
		"separate_items_with_commas" => __("Separa Tipologie Servizi con le virgole", "canva"),
		"add_or_remove_items" => __("Aggiungi o rimuovi Tipologie Servizi", "canva"),
		"choose_from_most_used" => __("Scegli tra i Tipologie Servizi più utilizzati", "canva"),
		"not_found" => __("No Tipologie Servizi found", "canva"),
		"no_terms" => __("No Tipologie Servizi", "canva"),
		"items_list_navigation" => __("Tipologie Servizi list navigation", "canva"),
		"items_list" => __("Tipologie Servizi list", "canva"),
		"back_to_items" => __("Back to Tipologie Servizi", "canva"),
	];


	$args = [
		"label" => __("Tipologie Servizi", "canva"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => ['slug' => 'servizio_cat', 'with_front' => true,],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "servizio_cat",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => true,
		"show_in_graphql" => false,
	];
	register_taxonomy("servizio_cat", ["servizio"], $args);

	/**
	 * Taxonomy: Keywords.
	 */

	$labels = [
		"name" => __("Keywords", "canva"),
		"singular_name" => __("Keywords", "canva"),
	];


	$args = [
		"label" => __("Keywords", "canva"),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => false,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => false,
		"query_var" => true,
		"rewrite" => ['slug' => 'keywords', 'with_front' => true,],
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "keywords",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		"show_in_graphql" => false,
	];
	register_taxonomy("keywords", ["centro"], $args);
}
add_action('init', 'cptui_register_my_taxes');
