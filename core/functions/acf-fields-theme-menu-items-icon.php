<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_z82aw7l6cjdjwecv',
		'title' => '[Canva] - Menu Icon',
		'fields' => [
			[
				'key' => 'field_60d20e4331c40',
				'label' => 'Menu Icon',
				'name' => 'menu_icon',
				'type' => 'image',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'return_format' => 'url',
				'preview_size' => '160-11',
				'library' => 'all',
				'min_width' => '',
				'min_height' => '',
				'min_size' => '',
				'max_width' => '',
				'max_height' => '',
				'max_size' => '',
				'mime_types' => '',
			],
		],
		'location' => [
			[
				[
					'param' => 'nav_menu_item',
					'operator' => '==',
					'value' => 'all',
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
