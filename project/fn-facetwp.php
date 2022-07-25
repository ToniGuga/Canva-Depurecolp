<?php
defined('ABSPATH') || exit;

// limita le ricerche solo in italia
add_filter('facetwp_proximity_autocomplete_options', function ($options) {
	$options['componentRestrictions'] = [
		'country' => ['it'],
	];
	return $options;
});

// utilizza cita provincia
add_filter('facetwp_proximity_autocomplete_options', function ($options) {
	$options['types'] = ['(cities)'];
	return $options;
});


// Sort results by distance
add_action('pre_get_posts', function ($query) {
	if (!class_exists('FacetWP_Helper')) {
		return;
	}

	$facets_in_use = FWP()->facet->facets;
	$prefix = FWP()->helper->get_setting('prefix');
	$using_sort = isset(FWP()->facet->http_params['get'][$prefix . 'sort']);

	$is_main_query = false;
	if (is_array(FWP()->facet->template)) {
		if ('wp' != FWP()->facet->template['name'] || true === $query->get('facetwp')) {
			$is_main_query = true;
		}
	}

	if (!empty($facets_in_use) && !$using_sort && $is_main_query) {
		foreach ($facets_in_use as $f) {
			if ('proximity' == $f['type'] && !empty($f['selected_values'])) {
				$query->set('orderby', 'post__in');
				$query->set('order', 'ASC');
			}
		}
	}

}, 1000);


add_filter('facetwp_query_args', function ($query_args, $class) {


	if ('centri' === $class->ajax_params['template'] || 'centri_home' === $class->ajax_params['template']) {

		$query_args['facetwp'] = 1;
		$query_args['order'] = 'ASC';
		$query_args['orderby'] = 'meta_value';
		$query_args['meta_key'] = 'name';

	}

	return $query_args;
}, 10, 2);


function sg_facetwp_custom_output($output, $class)
{

	$GLOBALS['wp_query'] = $class->query;

	ob_start();

	if (have_posts()) {

		$container_css_classes = '';
		if ('blog' === $class->ajax_params['template']) {
			$container_css_classes = 'grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4';
		}

?>

		<div class="flex fs-small mb-4">
			<div class="mr-2"><?php _e('Risultati:', 'primodentisti'); ?> </div>
			<?php echo facetwp_display('counts'); ?>
		</div>


		<div id="facetwp-results" class="<?php echo esc_attr($container_css_classes) ?>">
			<?php

			while (have_posts()) {
				the_post();
				if ('centri' === $class->ajax_params['template'] || 'centri_home' === $class->ajax_params['template']) {
					canva_get_template('card-centro', ['post_id' => get_the_ID()]);
				} elseif ('blog' === $class->ajax_params['template']) {
					canva_get_template('card-blog', ['post_id' => get_the_ID()]);
				}
			}
			?>
		</div>

<?php
	} else {
		if ('centri' === $class->ajax_params['template'] || 'centri_home' === $class->ajax_params['template']) {
			echo '<p>Nessun centro trovato con questa ricerca.</p>';
		} elseif ('blocg' === $class->ajax_params['template']) {
			echo '<p>Nessun articolo trovato con questa ricerca.</p>';
		}
	}

	$output = ob_get_clean();

	return $output;
}

add_filter('facetwp_template_html', 'sg_facetwp_custom_output', 10, 2);
//nascone il conteggio dei post
// add_filter( 'facetwp_facet_dropdown_show_counts', '__return_false' );



/**
 * Image as checkboxes buttons in FacetWp "categorie_blog"
 *
 * @param [type] $output
 * @param [type] $params
 * @return $output
 */
add_filter('facetwp_facet_html', function ($output, $params) {

	if ('categorie_blog' == $params['facet']['name']) {

		$output = '';
		$values = (array) $params['values'];
		$selected_values = (array) $params['selected_values'];

		foreach ($values as $result) {
			$clean_val = esc_attr($result['facet_value']);
			$selected = in_array($result['facet_value'], $selected_values) ? ' checked' : '';
			$selected .= (0 == $result['counter'] && '' == $selected) ? ' disabled' : '';

			$output .= '<div class="facetwp-checkbox tag' . $selected . '" data-value="' . esc_attr($result['facet_value']) . '">';
			$output .= '<span class="text-wrap">' . $result['facet_display_value'] . '</span>';
			$output .= '</div>';
		}
	}

	// return var_export($result, true);
	return $output;
}, 10, 2);
