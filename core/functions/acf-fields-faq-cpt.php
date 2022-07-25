<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * Register ACF Fields in custom post type Stores
 * because wp all import doesn't support wp blocks
 */

if (function_exists('acf_add_local_field_group')) {
    acf_add_local_field_group([
        'key' => 'group_609d3c1530408',
        'title' => '[Canva] - FAQ',
        'fields' => [
			// [
			// 	'key' => 'field_6homu2tn0smg1ses',
			// 	'label' => __('Sottotitolo', 'canva-backend'),
			// 	'name' => 'subtitle',
			// 	'type' => 'text',
			// 	'instructions' => '',
			// 	'required' => 0,
			// 	'conditional_logic' => 0,
			// 	'wrapper' => [
			// 		'width' => '100',
			// 		'class' => '',
			// 		'id' => '',
			// 	],
			// 	'default_value' => '',
			// 	'placeholder' => '',
			// 	'prepend' => '',
			// 	'append' => '',
			// 	'maxlength' => '',
			// ],
            [
                'key' => 'field_609d3c5321325',
                'label' => 'Contenuto',
                'name' => 'content',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ],
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ],
            [
                'key' => 'field_609e85914f8a7',
                'label' => 'Tipologia',
                'name' => 'tipologia',
                'type' => 'taxonomy',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => [
                    'width' => '33',
                    'class' => '',
                    'id' => '',
                ],
                'taxonomy' => 'faq-cat',
                'field_type' => 'multi_select',
                'allow_null' => 0,
                'add_term' => 1,
                'save_terms' => 1,
                'load_terms' => 0,
                'return_format' => 'object',
                'multiple' => 0,
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'faq',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
    ]);
}
