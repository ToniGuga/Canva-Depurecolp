<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (function_exists('acf_add_local_field_group')) {

	// Put here acf fileds php export

	acf_add_local_field_group([
		'key' 		=> 'group_xp3mblbapx0hewyj',
		'title' 	=> '[PrimoGroup BE] - Faq Block Template',
		'fields' 	=> [
			[
				'key' 				=> 'field_8xqzqpeybdbzlj4d',
				'label' 			=> __('Background Image', 'canva-backend'),
				'name' 				=> 'bg_image',
				'type'				=> 'image',
				'instructions' 		=> '',
				'required' 			=> 0,
				'conditional_logic' => 0,
				'wrapper' 			=> [
					'width' => '50',
					'class' => '',
					'id' 	=> '',
				],
				'return_format' 	=> 'id',
				'preview_size' 		=> '160-11',
				'library' 			=> 'all',
				'min_width' 		=> '',
				'min_height' 		=> '',
				'min_size' 			=> '',
				'max_width' 		=> '',
				'max_height' 		=> '',
				'max_size' 			=> '',
				'mime_types' 		=> '',
			],
			[
				'key' 				=> 'field_4p1rtvk46vlimsgh',
				'label' 			=> __('Background Image (Mobile)', 'canva-backend'),
				'name' 				=> 'bg_image_small',
				'type' 				=> 'image',
				'instructions' 		=> '',
				'required' 			=> 0,
				'conditional_logic' => 0,
				'wrapper' 			=> [
					'width' => '50',
					'class' => '',
					'id' 	=> '',
				],
				'return_format' 	=> 'id',
				'preview_size' 		=> '160-11',
				'library' 			=> 'all',
				'min_width' 		=> '',
				'min_height' 		=> '',
				'min_size' 			=> '',
				'max_width' 		=> '',
				'max_height' 		=> '',
				'max_size' 			=> '',
				'mime_types' 		=> '',
			],
		],
		'location' => [
			[
				[
					'param' 		=> 'block',
					'operator' 		=> '==',
					'value' 		=> 'acf/faq-block-template',
				],
			],
		],
		'menu_order' 				=> 0,
		'position' 					=> 'normal',
		'style' 					=> 'default',
		'label_placement' 			=> 'top',
		'instruction_placement' 	=> 'label',
		'hide_on_screen'			=> '',
		'active' 					=> true,
		'description' 				=> '',
	]);

}
