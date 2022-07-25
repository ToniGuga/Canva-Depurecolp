<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_5f100cbb53b18',
		'title' => '[Canva] - Events Fields',
		'fields' => [
			[
				'key' => 'field_zog3qn9hlz6zn66m',
				'label' => __('Start Date Time', 'canva-backend'),
				'name' => 'start_date_time',
				'type' => 'date_time_picker',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'display_format' => 'Y-m-d H:i:s',
				'return_format' => 'Y-m-d H:i:s',
				'first_day' => 1,
			],
			[
				'key' => 'field_ojrhekhddrrwjmpq',
				'label' => __('End Date Time', 'canva-backend'),
				'name' => 'end_date_time',
				'type' => 'date_time_picker',
				'instructions' => '',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'display_format' => 'Y-m-d H:i:s',
				'return_format' => 'Y-m-d H:i:s',
				'first_day' => 1,
			],
			[
				'key' => 'field_xuj603h69ksxujwv',
				'label' => __('Event Address', 'canva-backend'),
				'name' => 'address',
				'type' => 'google_map',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => [
					'width' => '',
					'class' => '',
					'id' => '',
				],
				'center_lat' => '45.079622',
				'center_lng' => '7.6667941',
				'zoom' => '12',
				'height' => '',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'event',
				],
			],
		],
		'menu_order' => 1,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
	]);
}
