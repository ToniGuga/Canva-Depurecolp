<?php
defined('ABSPATH') || exit;

function project_facetwp_results($output, $class)
{
	// echo get_the_ID();
	$GLOBALS['wp_query'] = $class->query;
	ob_start();

	if ('regular_search' === $class->ajax_params['template']) {

		if (have_posts()) {
			echo '<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-4">';

			while (have_posts()) {
				the_post();

				canva_get_template('card-product', ['post_id' => get_the_ID()]);
			}

			echo '</div>';

			wp_reset_postdata();
		}
	} else if ('deals' === $class->ajax_params['template']) {
		$args = array(
			'post_type'    => 'product',
			'meta_value' => '_sale_price',
		);

		$posts = get_posts($args);

		if ($posts) {
			echo '<div class="_archive-products-wrap max-w-screen-xxl mx-auto grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 transition-all">';
			foreach ($posts as $post) {
				canva_get_template('card-product', ['post_id' => $post->ID]);
			}
			echo '</div>';
		}
	}

	$output = ob_get_clean();

	return $output;
}
add_filter('facetwp_template_html', 'project_facetwp_results', 10, 2);
// add_filter('facetwp_facet_dropdown_show_counts', '__return_false'); //nasconde il conteggio dei post


/**
 * Image as checkboxes buttons in FacetWp "categorie_blog"
 *
 * @param [type] $output
 * @param [type] $params
 * @return $output
 */
add_filter('facetwp_facet_html', function ($output, $params) {

	if ('product_categories_mod_air_treatment' == $params['facet']['name'] || 'product_categories_mod_application' == $params['facet']['name'] || 'product_categories_mod_kit_spare_parts' == $params['facet']['name'] || 'product_categories_mod_tools' == $params['facet']['name']) {

		$output = '';
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];

		if (!empty($values)) {

			if ('product_categories_mod_air_treatment' == $params['facet']['name'] || 'product_categories_mod_tools' == $params['facet']['name'] || 'product_categories_mod_kit_spare_parts' == $params['facet']['name']) {
				$output .= '<span class="h6 mt-8 mb-4 hide md:block">' . __('Category', 'canva-abac') . '</span>';
			} else {
				$output .= '<span class="h6 mt-8 mb-4 hide md:block">' . __('Applications', 'canva-abac') . '</span>';
			}
		}

		foreach ($values as $result) {
			$term = get_term_by('slug', $result['facet_value'], 'product_cat');
			// dump_to_error_log($params);

			$term_img_id = get_term_meta($term->term_id, 'thumbnail_id', true);

			$border_last = '';
			if (!next($values)) {
				$border_last = 'border-b';
			}

			$term_img_url = canva_get_img([
				'img_id'   =>  $term_img_id,
				'img_type' => 'url',
				'thumb_size' =>  '160-11',
			]);

			$term_img = canva_get_img([
				'img_id'   =>  $term_img_id,
				'img_type' => 'img',
				'thumb_size' =>  '160-11',
				'img_class' =>  'w-10 mix-blend-multiply transition transform-gpu group-hover:scale-110',
				'wrapper_class' =>  'overflow-hidden',
				'blazy' => 'off'
			]);

			$clean_val = esc_attr($result['facet_value']);
			$selected = in_array($result['facet_value'], $selected_values) ? ' checked' : '';
			$selected .= (0 == $result['counter'] && '' == $selected) ? ' disabled' : '';

			$output .= '<div class="_facetwp-radio-filter facetwp-radio relative flex flex-wrap gap-2 mb-0 border-t border-gray-200 group ' . $border_last . ' ' . $selected . '" data-value="' . esc_attr($result['facet_value']) . '" data-term-img="' . $term_img_url . '">';
			if ($term_img_id) {
				$output .= '<div class="_img-wrap py-2">' . $term_img . '</div>';
			}
			$output .= '<div class="_text-wrap py-2 flex-1 flex items-center gap-1"><span class="fs-xs fw-700">' . $result['facet_display_value'] . '</span> <span class="fs-xs">(' . $result['counter'] . ')</span></div>';
			$output .= '</div>';
		}
	} elseif ('pumping_units' == $params['facet']['name'] || 'screw_hours' == $params['facet']['name']) {

		$output = '';
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];

		if (!empty($values)) {
			if ('pumping_units' == $params['facet']['name']) {
				$output .= '<span class="h6 mt-8 mb-4 hide md:block">' . __('Pumps and Maintenance Kits', 'canva-abac') . '</span>';
			} else {
				$output .= '<span class="h6 mt-8 mb-4 hide md:block">' . __('Screw Maintenance Kits', 'canva-abac') . '</span>';
			}
		}

		foreach ($values as $result) {
			if ('pumping_units' == $params['facet']['name']) {
				$term = get_term_by('slug', $result['facet_value'], 'pumping_unit');
			} else {
				$term = get_term_by('slug', $result['facet_value'], 'screw_hours');
			}

			$term_img_id = canva_get_term_featured_img_id($term);

			$border_last = '';
			if (!next($values)) {
				$border_last = 'border-b';
			}

			$term_img_url = canva_get_img([
				'img_id'   =>  $term_img_id,
				'img_type' => 'url',
				'thumb_size' =>  '160-11',
			]);

			$term_img = canva_get_img([
				'img_id'   =>  $term_img_id,
				'img_type' => 'img',
				'thumb_size' =>  '160-11',
				'img_class' =>  'w-10 mix-blend-multiply transition transform-gpu group-hover:scale-110',
				'wrapper_class' =>  '_figure',
				'blazy' => 'off'
			]);

			$clean_val = esc_attr($result['facet_value']);
			$selected = in_array($result['facet_value'], $selected_values) ? ' checked' : '';
			$selected .= (0 == $result['counter'] && '' == $selected) ? ' disabled' : '';

			$output .= '<div class="_facetwp-radio-filter facetwp-radio relative flex flex-wrap gap-2 mb-0 border-t border-gray-200 group ' . $border_last . ' ' . $selected . '" data-value="' . esc_attr($result['facet_value']) . '" data-term-img="' . $term_img_url . '">';
			if ($term_img_id) {
				$output .= '<div class="_img-wrap py-2">' . $term_img . '</div>';
			}
			$output .= '<div class="_text-wrap py-1 flex-1 flex items-center gap-1"><span class="fs-xs fw-700">' . $result['facet_display_value'] . '</span> <span class="fs-xs">(' . $result['counter'] . ')</span></div>';
			$output .= '</div>';
		}
	} elseif ('product_categories_air_compressors' == $params['facet']['name'] || 'product_categories_lubricants' == $params['facet']['name']) {

		$output = '<span class="h6 mt-4 mb-4 hide md:block">' . __('Typology', 'canva-abac') . '</span><div class="flex gap-8 my-8">';
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];

		foreach ($values as $result) {
			$clean_val = esc_attr($result['facet_value']);
			$selected = in_array($result['facet_value'], $selected_values) ? ' checked' : '';
			$selected .= (0 == $result['counter'] && '' == $selected) ? ' disabled' : '';

			$output .= '<div class="facetwp-radio' . $selected . '" data-value="' . esc_attr($result['facet_value']) . '">';
			$output .= '<span class="text-wrap">' . $result['facet_display_value'] . '</span> <span class="text-xs">(' . $result['counter'] . ')</span>';
			$output .= '</div>';
		}
	} elseif ('deals' == $params['facet']['name']) {

		$output = '<div class="flex gap-8 my-8">';
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];

		foreach ($values as $result) {
			$clean_val = esc_attr($result['facet_value']);
			$selected = in_array($result['facet_value'], $selected_values) ? ' checked' : '';
			$selected .= (0 == $result['counter'] && '' == $selected) ? ' disabled' : '';

			$output .= '<div class="facetwp-radio' . $selected . '" data-value="' . esc_attr($result['facet_value']) . '">';
			$output .= '<span class="text-wrap">'.__('Deals','canva-abac').'</span> <span class="text-xs">(' . $result['counter'] . ')</span>';
			$output .= '</div>';
		}
	} elseif ('new_products' == $params['facet']['name']) {

		$output = '<div class="flex gap-8 my-8">';
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];

		foreach ($values as $result) {
			$clean_val = esc_attr($result['facet_value']);
			$selected = in_array($result['facet_value'], $selected_values) ? ' checked' : '';
			$selected .= (0 == $result['counter'] && '' == $selected) ? ' disabled' : '';

			$output .= '<div class="facetwp-radio' . $selected . '" data-value="' . esc_attr($result['facet_value']) . '">';
			$output .= '<span class="text-wrap">'.__('New','canva-abac').'</span> <span class="text-xs">(' . $result['counter'] . ')</span>';
			$output .= '</div>';
		}
	} elseif ('part_number_search' == $params['facet']['name']) {
		$output = str_replace('Go', 'Search', $output);
	}

	$output .= '</div>';
	return $output;
}, 10, 2);
