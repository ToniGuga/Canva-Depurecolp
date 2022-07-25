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

function  canva_be_block_callback($block)
{
	// convert name ("acf/testimonial") into path friendly slug ("testimonial")
	$slug = str_replace('acf/', '', $block['name']);

	$slug = str_replace('_', '-', $slug);

	// include a template part from within the "template-parts/block" folder
	if (file_exists(CANVA_PROJECT_BLOCKS . $slug . '.php')) {
		include(CANVA_PROJECT_BLOCKS . $slug . '.php');
	} elseif (file_exists(CANVA_CORE_BLOCKS . $slug . '.php')) {
		include(CANVA_CORE_BLOCKS . $slug . '.php');
	}
}


/**
 * Aggiunge la categoria  canva per i blocchi
 *
 * Modificare il titolo => 'title' con il nome del progetto
 *
 * @param array $categories Array of block categories.
 * @return array
 */

function  canva_block_categories($categories)
{
	$category_slugs = wp_list_pluck($categories, 'slug');
	return in_array('custom_canva_block_category', $category_slugs, true) ? $categories : array_merge(
		$categories,
		array(
			array(
				'slug'  => 'canva_block_category', //non modificare
				'title' => __('Canva Core'), //modificare con mone progetto
				'icon'  => null,
			),
		)
	);
}
add_filter('block_categories_all', 'canva_block_categories');


/**
 * funzione per registare i nuovi blocchi custom del progetto
 *
 * Modificare ogni volta che vuoi aggiungere un blocco nuovo
 * devi copiare tutto il blocco della funzione acf_register_block(***);
 * sotto per registrare il nuovo blocco
 *
 * Nella cartella canva/blockeditor del tema figlio dovrai creare
 * un microtemplate con il nome dello slug => 'name' che hai dato al blocco
 *
 * esempio sotto post-header.php
 *
 * @return void
 */

function canva_be_acf_init()
{
	// check function exists
	if (function_exists('acf_register_block_type')) {

		acf_register_block([
			'name' 				=> 'hero-slider', //modificare slug del blocco
			'title' 			=> __('Hero Slider', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Add a Hero Slider', 'canva-backend'), //modificare azione del blocco
			'render_callback'	=> 'canva_be_block_callback', //non modificare
			'category'			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('hero_slider_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-slider-preview', null)),
			'keywords'			=> array('Hero', 'Slider', 'Swiper'),
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block_type([
			'name' 				=> 'hero-primary', //modificare slug del blocco
			'title' 			=> __('Hero Primary'), //modificare titolo del blocco
			'description' 		=> __('Add a Hero Primary Block'), //modificare azione del blocco
			'render_callback'	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('hero_one_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-1-preview', null)),
			'keywords' 			=> ['hero', 'primary', 'hero image'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'hero-video', //modificare slug del blocco
			'title' 			=> __('Hero Video', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('A Hero Video', 'canva-backend'), //modificare azione del blocco
			'render_callback'	=> 'project_be_block_callback', //non modificare
			'category'			=> 'project_block_category', //non modificare
			'icon' 				=> apply_filters('hero_video_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-hero-video-preview', null)),
			'keywords'			=> array('Hero', 'Video'),
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block([
			'name'				=> 'icon-text', //modificare slug del blocco
			'title'				=> __('Icon & Text', 'canva-backend'), //modificare titolo del blocco
			'description'		=> __('Add an Icon & Text block', 'canva-backend'), //modificare azione del blocco
			'render_callback'	=> 'canva_be_block_callback', //non modificare
			'category'			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('icon_text_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-icon-text-preview', null)),
			'keywords'			=> array('Icon', 'Text'),
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block([
			'name' 				=> 'icon-inner-text', //modificare slug del blocco
			'title' 			=> __('Icon Inner Text', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('A width 100% wrapper div', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('icon_text_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-icon-text-preview', null)),
			'keywords' 			=> ['icon', 'inner', 'text'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'row-w-100-inner-blocks', //modificare slug del blocco
			'title' 			=> __('Row W-100%', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('A width 100% wrapper div', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_100_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['100%', 'width', 'wrapper', 'div', 'full'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'bt-row-w-xxl-inner-blocks', //modificare slug del blocco
			'title' 			=> __('Row W-XXL', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('A width XXL wrapper div', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_xxl_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['100%', 'width', 'wrapper', 'div', 'full'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'bt-row-w-xl-inner-blocks', //modificare slug del blocco
			'title' 			=> __('Row W-XL', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('A width XL wrapper div', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_xl_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['100%', 'width', 'wrapper', 'div', 'full'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'bt-row-w-lg-inner-blocks', //modificare slug del blocco
			'title' 			=> __('Row W-LG', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('A width XL wrapper div', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'mode' 				=> 'preview',
			'icon' 				=> apply_filters('row_w_lg_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-row-w-100-preview', null)),
			'keywords' 			=> ['100%', 'width', 'wrapper', 'div', 'full'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'mode' => false, 'jsx' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'posts-selector', //modificare slug del blocco
			'title' 			=> __('Posts Selector', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Select Posts to be presented with a custom template', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('posts_selector_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-posts-selector-preview', null)),
			'keywords' 			=> ['Posts', 'Selector'],
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block([
			'name' 				=> 'common-block-selector', //modificare slug del blocco
			'title' 			=> __('Common Block Selector', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Common Block selector to be presented with a custom template', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('common_block_selector_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-posts-selector-preview', null)),
			'keywords' 			=> ['Posts', 'Selector', 'Common', 'Block'],
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block([
			'name' 				=> 'common-block-slider', //modificare slug del blocco
			'title' 			=> __('Common Block Slider', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Common Block slider to be presented with a custom template', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('common_block_slider_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-posts-selector-preview', null)),
			'keywords' 			=> ['Posts', 'slider', 'Common', 'Block'],
			'supports'			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block([
			'name' 				=> 'faq-selector', //modificare slug del blocco
			'title' 			=> __('FAQ Selector', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Select FAQ Posts to be presented with a custom template', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('faq_selector_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-faq-selector-preview', null)),
			'keywords' 			=> ['FAQ', 'Posts', 'Selector'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'faq-selector-new', //modificare slug del blocco
			'title' 			=> __('FAQ Selector (New)', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Select FAQ Posts to be presented with a custom template', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('faq_selector_preview_blocks_icon', canva_get_svg_icon('canva-icons/canva-icon-faq-selector-preview', null)),
			'keywords' 			=> ['FAQ', 'Posts', 'Selector'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'posts-per-term-selector', //modificare slug del blocco
			'title' 			=> __('Posts per categoria', 'canva-be-it'), //modificare titolo del blocco
			'description' 		=> __('Aggiungi un Posts per categoria'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('post_per_term_selector_icon', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497.83 97.98L413.94 14.1c-9-9-21.2-14.1-33.89-14.1H175.99C149.5.1 128 21.6 128 48.09v215.98H12c-6.63 0-12 5.37-12 12v24c0 6.63 5.37 12 12 12h276v48.88c0 10.71 12.97 16.05 20.52 8.45l71.77-72.31c4.95-4.99 4.95-13.04 0-18.03l-71.77-72.31c-7.55-7.6-20.52-2.26-20.52 8.45v48.88H175.99V48.09h159.97v103.98c0 13.3 10.7 23.99 24 23.99H464v287.95H175.99V360.07H128v103.94c0 26.49 21.5 47.99 47.99 47.99h287.94c26.5 0 48.07-21.5 48.07-47.99V131.97c0-12.69-5.17-24.99-14.17-33.99zm-113.88 30.09V51.99l76.09 76.08h-76.09z"/></svg>'),
			'keywords' 			=> ['posts', 'post list', 'posts per term', 'posts per categoria', 'taxonomy', 'tassonomia'],
			'supports' 			=> ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' 				=> 'action-link', //modificare slug del blocco
			'title' 			=> __('Action Link', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Create a button link with GA Tracking Events', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('action_link_icon', canva_get_svg_icon('fontawesome/regular/link')),
			'keywords' 			=> ['Action', 'Link', 'Button', 'Pulsante'],
			'supports'			=> array('align' => false, 'align_text' => true, 'multiple' => true, 'anchor' => true),
		]);

		acf_register_block([
			'name' 				=> 'modal', //modificare slug del blocco
			'title' 			=> __('Modal', 'canva-backend'), //modificare titolo del blocco
			'description' 		=> __('Add an Modal with button or link', 'canva-backend'), //modificare azione del blocco
			'render_callback' 	=> 'canva_be_block_callback', //non modificare
			'category' 			=> 'canva_block_category', //non modificare
			'icon' 				=> apply_filters('action_link_icon', canva_get_svg_icon('fontawesome/regular/link')),
			'keywords' 			=> ['Modal', 'Post', 'Opener'],
			'supports'			=> array('align' => false, 'align_text' => true, 'multiple' => true, 'anchor' => true),
		]);

		//
		acf_register_block(array(
			'name'				=> 'photobutton', //modificare slug del blocco
			'title'				=> __('Photobutton'), //modificare titolo del blocco
			'description'		=> __('Add a Photobutton'), //modificare azione del blocco
			'render_callback'	=> 'canva_be_block_callback', //non modificare
			'category'			=> 'canva_block_category', //non modificare
			'icon'				=> 'editor-kitchensink', //modificare icona del blocco
			'keywords'			=> array('photobutton', 'button', 'categoria'),
			'supports' 			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		));

		//
		acf_register_block(array(
			'name'				=> 'video-embed', //modificare slug del blocco
			'title'				=> __('Video Embed'), //modificare titolo del blocco
			'description'		=> __('Add a Video Embed from Youtube or Vimeo'), //modificare azione del blocco
			'render_callback'	=> 'canva_be_block_callback', //non modificare
			'category'			=> 'canva_block_category', //non modificare
			'icon'				=> apply_filters('video_embed_blocks_icon', canva_get_svg_icon('fontawesome/brands/youtube', null)),
			'keywords'			=> array('video', 'embed', 'youtube', 'vimeo'),
			'supports' 			=> array('align' => false, 'multiple' => true, 'anchor' => true),
		));

		// Spacing Blocks
		$spacers_icon = apply_filters('spacers_icon', '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><path d="M13 4v2h3.59L6 16.59V13H4v7h7v-2H7.41L18 7.41V11h2V4h-7"></path></svg>');

		acf_register_block([
			'name' => 'spacer-py-1',
			'title' => __('Spazio py-1'),
			'description' => __('Aggiungi uno Spazio di misura 1'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-1', 'Spazio py-1'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-1-5',
			'title' => __('Spazio py-1.5'),
			'description' => __('Aggiungi uno Spazio di misura 1.5'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-1.5', 'Spazio py-1.5'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-2',
			'title' => __('Spazio py-2'),
			'description' => __('Aggiungi uno Spazio di misura 2'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-2', 'Spazio py-2'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-2-5',
			'title' => __('Spazio py-2.5'),
			'description' => __('Aggiungi uno Spazio di misura 2.5'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-2.5', 'Spazio py-2.5'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-3',
			'title' => __('Spazio py-3'),
			'description' => __('Aggiungi uno Spazio di misura 3'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-3.5', 'Spazio py-3.5'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-3-5',
			'title' => __('Spazio py-3'),
			'description' => __('Aggiungi uno Spazio di misura 3'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-3.5', 'Spazio py-3.5'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-4',
			'title' => __('Spazio py-4'),
			'description' => __('Aggiungi uno Spazio di misura 4'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-4', 'Spazio py-4'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-5',
			'title' => __('Spazio py-5'),
			'description' => __('Aggiungi uno Spazio di misura 5'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-5', 'Spazio py-5'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-6',
			'title' => __('Spazio py-6'),
			'description' => __('Aggiungi uno Spazio di misura 6'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-6', 'Spazio py-6'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-7',
			'title' => __('Spazio py-7'),
			'description' => __('Aggiungi uno Spazio di misura 7'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-7', 'Spazio py-7'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);

		acf_register_block([
			'name' => 'spacer-py-8',
			'title' => __('Spazio py-8'),
			'description' => __('Aggiungi uno Spazio di misura 8'),
			'render_callback' => 'canva_be_block_callback',
			'category' => 'canva_block_category',
			'icon' => $spacers_icon,
			'keywords' => ['Spacer py-8', 'Spazio py-8'],
			'supports' => ['align' => false, 'multiple' => true, 'anchor' => true],
		]);
	}
}
add_action('acf/init', 'canva_be_acf_init');


/**
 *
 * funzione per generare whitelist dei blocchi da utilizzare di per il progetto
 *
 * @url https://rudrastyh.com/gutenberg/remove-default-blocks.html
 *
 */
function canva_allowed_blocks($allowed_blocks)
{
	$allowed_blocks =  [
		//wp core blocks
		'core/block', //attiva menu blocchi riusabili
		// 'core/group', // attiva gruppi di blocchi
		'core/columns',
		'core/image',
		'core/gallery',
		'core/heading',
		'core/paragraph',
		'core/list',
		'core/table',
		'core/quote',
		'core/html',
		'core/shortcode',
		'core/embed',
		// 'core-embed/youtube',
		// 'core-embed/vimeo',

		// ACF Blocks
		'acf/hero-slider',
		'acf/hero-primary',
		'acf/hero-video',
		'acf/icon-text',
		'acf/icon-inner-text',
		'acf/row-w-100-inner-blocks',
		'acf/bt-row-w-xxl-inner-blocks',
		'acf/bt-row-w-xl-inner-blocks',
		'acf/bt-row-w-lg-inner-blocks',
		'acf/posts-selector',
		'acf/common-block-selector',
		'acf/common-block-slider',
		'acf/faq-selector',
		'acf/faq-selector-new',
		'acf/posts-per-term-selector',
		'acf/action-link',
		'acf/modal',
		'acf/photobutton',
		// 'acf/video-embed',

		// Spacers
		'acf/spacer-py-1',
		'acf/spacer-py-1-5',
		'acf/spacer-py-2',
		'acf/spacer-py-2-5',
		'acf/spacer-py-3',
		'acf/spacer-py-3-5',
		'acf/spacer-py-4',
		'acf/spacer-py-5',
		'acf/spacer-py-6',
		'acf/spacer-py-7',
		'acf/spacer-py-8',
	];


	$allowed_blocks = array_merge($allowed_blocks, (array) apply_filters('canva_block_list', []));

	return $allowed_blocks;

	// return apply_filters('canva_block_list', $allowed_blocks);

}
add_filter('allowed_block_types_all', 'canva_allowed_blocks', 10, 1);
