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
				'title' => __('Primo Dentisti'), //modificare con mone progetto
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


		acf_register_block([
			'name' 				=> 'hero-trattamento', //modificare slug del blocco
			'title' 			=> __('Hero Trattamento', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Hero Trattamento - Block Template con InnerBlocks', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'project_be_block_callback', //non modificare
			'category' 			=> 'project_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_100_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['hero', 'trattamento', ''],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
			'example'  => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview'    => true
					],
				],
			],
		]);




		acf_register_block([
			'name' 				=> 'hero-settore', //modificare slug del blocco
			'title' 			=> __('Hero Settore', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Hero Settore - Block Template con InnerBlocks', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'project_be_block_callback', //non modificare
			'category' 			=> 'project_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_100_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['hero', 'settore', ''],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
			'example'  => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview'    => true
					],
				],
			],
		]);




		acf_register_block([
			'name' 				=> 'hero-impianto', //modificare slug del blocco
			'title' 			=> __('Hero Impianto', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Hero Impianto - Block Template con InnerBlocks', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'project_be_block_callback', //non modificare
			'category' 			=> 'project_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_100_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['hero', 'settore', ''],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
			'example'  => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview'    => true
					],
				],
			],
		]);
		
		
		
		acf_register_block([
			'name' 				=> 'hero-case-history', //modificare slug del blocco
			'title' 			=> __('Hero Case History', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Hero Case History - Block Template con InnerBlocks', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'project_be_block_callback', //non modificare
			'category' 			=> 'project_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_100_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['hero', 'case', 'history'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
			'example'  => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview'    => true
					],
				],
			],
		]);
		
		
		
		
		acf_register_block([
			'name' 				=> 'dettagli-settore', //modificare slug del blocco
			'title' 			=> __('Dettagli Settore', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Dettagli Settore - Block Template con InnerBlocks', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'project_be_block_callback', //non modificare
			'category' 			=> 'project_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_100_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['dettagli', 'settore', ''],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
			'example'  => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview'    => true
					],
				],
			],
		]);




		

		acf_register_block([
			'name' 				=> 'table-of-contents', //modificare slug del blocco
			'title' 			=> __('Table of Contents', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Table of Contents', 'canva-backend'), //modificare azione del blocco
			'render_callback'	=> 'project_be_block_callback', //non modificare
			'category'			=> 'project_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('hero_one_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-2-preview', null)),
			'keywords'			=> array('Table', 'Table of Contents', 'Indice', 'Index'),
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
			'example'  => [
				'attributes' => [
					'mode' => 'preview',
					'data' => [
						'is_preview'    => true
					],
				],
			],
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

		// Sezioni Coind

		'acf/hero-trattamento',
		'acf/hero-settore',
		'acf/hero-impianto',
		'acf/hero-case-history',
		'acf/dettagli-settore',


		
		// Testing
		// 'bod/modal-block',
	];

	return array_merge($new_blocks, $allowed_blocks);
}
add_filter('canva_block_list', 'project_allowed_blocks', 10, 1);
