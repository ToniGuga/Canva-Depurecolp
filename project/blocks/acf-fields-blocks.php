<?php
defined('ABSPATH') || exit;

add_action('acf/init', 'acf_project_blocks_fields');

function acf_project_blocks_fields()
{
	acf_add_local_field_group([
		'key' => 'group_9kzss91tzn4lf67u',
		'title' => '[Canva] Common Block Slider',
		'fields' => [
			[
				'key' => 'field_2gq967lvrv99b0tt',
				'label' => 'Common Block Slider',
				'name' => 'post_object',
				'type' => 'relationship',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				// 'post_type' => 'common-blocks',
				'post_type' => array(
					0 => 'element',
					1 => 'common-blocks',
				),
				'taxonomy' => '',
				'filters' => [
					0 => 'search',
					1 => 'post_type',
					// 2 => 'taxonomy',
				],
				'elements' => [
					0 => 'featured_image',
				],
				'min' => '',
				'max' => '',
				'return_format' => 'id',
			],
			// [
			// 	'key' => 'field_i3g2dr4agj0x10n8',
			// 	'label' => 'Template Name',
			// 	'name' => 'template_name',
			// 	'type' => 'text',
			// 	'instructions' => '',
			// 	'required' => 0,
			// 	'conditional_logic' => 0,
			// 	'wrapper' => [
			// 		'width' => '',
			// 		'class' => '',
			// 		'id' => '',
			// 	],
			// 	'default_value' => '',
			// 	'placeholder' => 'Default: render-blocks',
			// 	'prepend' => '',
			// 	'append' => '',
			// 	'maxlength' => '',
			// ],
		],
		'location' => [
			[
				[
					'param' => 'block',
					'operator' => '==',
					'value' => 'acf/element-block-slider',
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
