<?php
// Exit if accessed directly
defined('ABSPATH') || exit;

/**
 * funzione di callback che automatizza l'inclusione
 * del template che renderizza l'output del blocco
 *
 * Non modificare
 *
 * @param [type] $block
 * @return void
 */
function project_be_block_callback($block)
{
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);
	$slug = str_replace('_', '-', $slug);

	// Set preview flag to true when rendering for the block editor.
	$is_preview = false;
	if ( is_admin() && acf_is_block_editor() ) {
		$is_preview = true;
	}

	// include a template part from within the folder
	if (file_exists(CANVA_PROJECT_BLOCKS . $slug . '.php')) {
		include(CANVA_PROJECT_BLOCKS . $slug . '.php');
	} elseif (file_exists(CANVA_CORE_BLOCKS . $slug . '.php')) {
		include(CANVA_CORE_BLOCKS . $slug . '.php');
	}
}



/**
 * Aggiunge la categoria  studio42 per i blocchi
 *
 * Modificare il titolo => 'title' con il nome del progetto
 *
 * @param array $categories Array of block categories.
 * @return array
 */

function  project_block_categories($categories)
{
	$category_slugs = wp_list_pluck($categories, 'slug');
	return in_array('project_block_category', $category_slugs, true) ? $categories : array_merge(
		$categories,
		array(
			array(
				'slug'  => 'project_block_category', //non modificare
				'title' => __('Eqipe'), //modificare con mone progetto
				'icon'  => null,
			),
		)
	);
}
add_filter('block_categories_all', 'project_block_categories');


/**
 * funzione per registare i nuovi blocchi custom del progetto
 *
 * Modificare ogni volta che vuoi aggiungere un blocco nuovo
 * devi copiare tutto il blocco della funzione acf_register_block(***);
 * sotto per registrare il nuovo blocco
 *
 * Nella cartella studio42/blockeditor del tema figlio dovrai creare
 * un microtemplate con il nome dello slug => 'name' che hai dato al blocco
 *
 * esempio sotto post-header.php
 *
 * @return void
 */
function project_be_acf_init()
{
	// check function exists
	if (function_exists('acf_register_block_type')) {
	    // acf_register_block([
	    //     'name' => 'bt-newsletter', //modificare slug del blocco
	    //     'title' => __('BT Newsletter', 'canva-backend'), //modificare titolo del blocco
	    //     'description' => __('BT Newsletter - Block Template con InnerBlocks', 'canva-backend'), //modificare azione del blocco
	    //     'render_callback' => 'project_be_block_callback', //non modificare
	    //     'category' => 'project_block_category', //non modificare
	    //     'mode' => 'preview',
	    //     'icon' => apply_filters('row_w_100_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
	    //     'keywords' => ['bt', 'newsletter', ''],
	    //     'supports' => ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
	    //     'example' => [
	    //         'attributes' => [
	    //             'mode' => 'preview',
	    //             'data' => [
	    //                 'is_preview' => true,
	    //             ],
	    //         ],
	    //     ],
	    // ]);

		acf_register_block([
			'name' 				=> 'element-block-slider', //modificare slug del blocco
			'title' 			=> __('Element Block Slider', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Element Block slider to be presented with a custom template', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('element_block_slider_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-posts-selector-preview', null)),
			'keywords' 			=> ['Posts', 'slider', 'Element', 'Block'],
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block([
			'name' 				=> 'promo-banner', //modificare slug del blocco
			'title' 			=> __('Promo Banner', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Promo Banner', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('promo_block_slider_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-posts-selector-preview', null)),
			'keywords' 			=> ['Promo', 'banner', '', ''],
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);
	}
}
add_action('acf/init', 'project_be_acf_init');


/**
 *
 * funzione per generare whitelist dei blocchi da utilizzare di per il progetto
 *
 * @url https://rudrastyh.com/gutenberg/remove-default-blocks.html
 *
 */
function project_allowed_blocks($allowed_blocks)
{

	$new_blocks =  [

		'acf/element-block-slider',
		'acf/promo-banner',

		// Testing
		// 'bod/modal-block',
	];

	return array_merge($new_blocks, $allowed_blocks);
}
add_filter('canva_block_list', 'project_allowed_blocks', 10, 1);
