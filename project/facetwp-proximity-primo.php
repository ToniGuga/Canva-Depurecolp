<?php

class FacetWP_Facet_SG_Proximity
{

	/* (array) Ordered array of post IDs */
	public $ordered_posts = [];

	/* (array) Associative array containing each post ID and its distance */
	public $distance = [];


	function __construct()
	{
		$this->label = __('Proximity SG', 'fwp');

		add_filter('facetwp_index_row', [$this, 'index_latlng'], 1, 2);
		add_filter('facetwp_sort_options', [$this, 'sort_options'], 1, 2);
		add_filter('facetwp_filtered_post_ids', [$this, 'sort_by_distance'], 10, 2);
	}


	/**
	 * Generate the facet HTML
	 */
	function render($params)
	{

		$output = '';
		$facet = $params['facet'];
		$value = $params['selected_values'];
		$unit = empty($facet['unit']) ? 'mi' : $facet['unit'];

		$lat = empty($value[0]) ? '' : $value[0];
		$lng = empty($value[1]) ? '' : $value[1];
		$chosen_radius = empty($value[2]) ? '' : (float) $value[2];
		$location_name = empty($value[3]) ? '' : urldecode($value[3]);

		$radius_options = [5, 10, 25, 50, 100];

		// Grab the radius UI
		$radius_ui = empty($facet['radius_ui']) ? 'dropdown' : $facet['radius_ui'];

		// Grab radius options from the UI
		if (!empty($facet['radius_options'])) {
			$radius_options = explode(',', preg_replace('/\s+/', '', $facet['radius_options']));
		}

		// Grab default radius from the UI
		if (empty($chosen_radius) && !empty($facet['radius_default'])) {
			$chosen_radius = (float) $facet['radius_default'];
		}

		// Support dynamic radius
		if (!empty($chosen_radius) && 0 < $chosen_radius) {
			if (!in_array($chosen_radius, $radius_options)) {
				$radius_options[] = $chosen_radius;
			}
		}

		$radius_options = apply_filters('facetwp_proximity_sg_radius_options', $radius_options);

		ob_start();
?>

		<button class="sg-locate-me button bg-primary" onclick="ga('send', 'event', 'FacetWP', 'Facets', 'Proximity SG');"><?php _e('Rileva la mia posizione', 'canva-facetwp'); ?></button>
		<a class="sg-locate-reset button hollow hidden" onclick="FWP.reset(); refreshPage();"><?php _e('Azzera', 'canva-facetwp'); ?></a>

		<?php if ('dropdown' == $radius_ui) : ?>

			<select class="facetwp-radius facetwp-radius-dropdown">
				<?php foreach ($radius_options as $radius) : ?>
					<?php $selected = ($chosen_radius == $radius) ? ' selected' : ''; ?>
					<option value="<?php echo $radius; ?>" <?php echo $selected; ?>><?php echo "$radius $unit"; ?></option>
				<?php endforeach; ?>
			</select>

		<?php elseif ('slider' == $radius_ui) : ?>

			<div class="facetwp-radius-wrap">
				<input class="facetwp-radius facetwp-radius-slider" type="range" min="<?php echo $facet['radius_min']; ?>" max="<?php echo $facet['radius_max']; ?>" value="<?php echo $chosen_radius; ?>" />
				<div class="facetwp-radius-label">
					<span class="facetwp-radius-dist"><?php echo $chosen_radius; ?></span>
					<span class="facetwp-radius-unit"><?php echo $facet['unit']; ?></span>
				</div>
			</div>

		<?php elseif ('none' == $radius_ui) : ?>

			<input class="facetwp-radius facetwp-hidden" value="<?php echo $chosen_radius; ?>" />

		<?php endif; ?>

		<div class="facetwp-hidden">
			<input type="text" class="facetwp-lat" value="<?php echo esc_attr($lat); ?>" />
			<input type="text" class="facetwp-lng" value="<?php echo esc_attr($lng); ?>" />
		</div>
	<?php
		return ob_get_clean();
	}


	/**
	 * Filter the query based on selected values
	 */
	function filter_posts($params)
	{
		global $wpdb;

		$facet = $params['facet'];
		$selected_values = $params['selected_values'];
		$unit = empty($facet['unit']) ? 'mi' : $facet['unit'];
		$earth_radius = ('mi' == $unit) ? 3959 : 6371;

		if (empty($selected_values) || empty($selected_values[0])) {
			return 'continue';
		}

		$lat = (float) $selected_values[0];
		$lng = (float) $selected_values[1];
		$radius = (float) $selected_values[2];

		$sql = "
        SELECT DISTINCT post_id, ( $earth_radius * acos(
            greatest( -1, least( 1, ( /* acos() must be between -1 and 1 */
                cos( radians( $lat ) ) *
                cos( radians( facet_value ) ) *
                cos( radians( facet_display_value ) - radians( $lng ) ) +
                sin( radians( $lat ) ) *
                sin( radians( facet_value ) )
                ) ) )
        ) ) AS distance
        FROM {$wpdb->prefix}facetwp_index
        WHERE facet_name = '{$facet['name']}'
        HAVING distance < $radius
        ORDER BY distance";

		$this->ordered_posts = [];
		$this->distance = [];

		if (apply_filters('facetwp_proximity_sg_store_distance', false)) {
			$results = $wpdb->get_results($sql);
			foreach ($results as $row) {
				$this->ordered_posts[] = $row->post_id;
				$this->distance[$row->post_id] = $row->distance;
			}
		} else {
			$this->ordered_posts = $wpdb->get_col($sql);
		}

		return $this->ordered_posts;
	}


	/**
	 * Output admin settings HTML
	 */
	function settings_html()
	{
	?>
		<div class="facetwp-row">
			<div>
				<?php _e('Longitude', 'fwp'); ?>:
				<div class="facetwp-tooltip">
					<span class="icon-question">?</span>
					<div class="facetwp-tooltip-content"><?php _e('(Optional) use a separate longitude field', 'fwp'); ?></div>
				</div>
			</div>
			<div>
				<data-sources :facet="facet" :selected="facet.source_other" :sources="$root.data_sources" settingName="source_other">
				</data-sources>
			</div>
		</div>
		<div class="facetwp-row">
			<div>
				<?php _e('Unit of measurement', 'fwp'); ?>:
			</div>
			<div>
				<select class="facet-unit">
					<option value="mi"><?php _e('Miles', 'fwp'); ?></option>
					<option value="km"><?php _e('Kilometers', 'fwp'); ?></option>
				</select>
			</div>
		</div>
		<div class="facetwp-row">
			<div>
				<?php _e('Radius UI', 'fwp'); ?>:
			</div>
			<div>
				<select class="facet-radius-ui">
					<option value="dropdown"><?php _e('Dropdown', 'fwp'); ?></option>
					<option value="slider"><?php _e('Slider', 'fwp'); ?></option>
					<option value="none"><?php echo _e('None', 'fwp'); ?></option>
				</select>
			</div>
		</div>
		<div class="facetwp-row" v-show="facet.radius_ui == 'dropdown'">
			<div>
				<?php _e('Radius options', 'fwp'); ?>:
				<div class="facetwp-tooltip">
					<span class="icon-question">?</span>
					<div class="facetwp-tooltip-content">
						A comma-separated list of radius choices
					</div>
				</div>
			</div>
			<div>
				<input type="text" class="facet-radius-options" value="10, 25, 50, 100, 250" />
			</div>
		</div>
		<div class="facetwp-row" v-show="facet.radius_ui == 'slider'">
			<div>
				<?php _e('Slider range', 'fwp'); ?>:
				<div class="facetwp-tooltip">
					<span class="icon-question">?</span>
					<div class="facetwp-tooltip-content">
						Set the lower and upper limits
					</div>
				</div>
			</div>
			<div>
				<input type="number" class="facet-radius-min" value="1" />
				<input type="number" class="facet-radius-max" value="50" />
			</div>
		</div>
		<div class="facetwp-row">
			<div>
				<?php _e('Default radius', 'fwp'); ?>:
			</div>
			<div>
				<input type="number" class="facet-radius-default" value="25" />
			</div>
		</div>
<?php
	}


	/**
	 * Index the coordinates
	 * We expect a comma-separated "latitude, longitude"
	 */
	function index_latlng($params, $class)
	{

		$facet = FWP()->helper->get_facet_by_name($params['facet_name']);

		if (false !== $facet && 'proximity_sg' == $facet['type']) {
			$latlng = $params['facet_value'];

			// Only handle "lat, lng" strings
			if (is_string($latlng)) {
				$latlng = preg_replace('/[^0-9.,-]/', '', $latlng);

				if (!empty($facet['source_other'])) {
					$other_params = $params;
					$other_params['facet_source'] = $facet['source_other'];
					$rows = $class->get_row_data($other_params);

					if (false === strpos($latlng, ',')) {
						$lng = $rows[0]['facet_display_value'];
						$lng = preg_replace('/[^0-9.,-]/', '', $lng);
						$latlng .= ',' . $lng;
					}
				}

				if (preg_match("/^([\d.-]+),([\d.-]+)$/", $latlng)) {
					$latlng = explode(',', $latlng);
					$params['facet_value'] = $latlng[0];
					$params['facet_display_value'] = $latlng[1];
				}
			}
		}

		return $params;
	}


	/**
	 * Add "Distance" to the sort box
	 */
	function sort_options($options, $params)
	{

		if (FWP()->helper->facet_setting_exists('type', 'proximity_sg')) {
			$options['distance'] = [
				'label' => __('Distance', 'fwp-front'),
				'query_args' => [
					'orderby' => 'post__in',
					'order' => 'ASC',
				],
			];
		}

		return $options;
	}


	/**
	 * After the final list of post IDs has been produced,
	 * sort them by distance if needed
	 */
	function sort_by_distance($post_ids, $class)
	{

		$ordered_posts = FWP()->helper->facet_types['proximity_sg']->ordered_posts;

		if (!empty($ordered_posts)) {

			// Sort the post IDs according to distance
			$intersected_ids = [0];

			foreach ($ordered_posts as $p) {
				if (in_array($p, $post_ids)) {
					$intersected_ids[] = $p;
				}
			}

			$post_ids = $intersected_ids;
		}

		return $post_ids;
	}
}


add_filter('facetwp_facet_types', function ($facet_types) {
	$facet_types['proximity_sg'] = new FacetWP_Facet_SG_Proximity();
	return $facet_types;
});


function add_custom_proximity_js()
{
	echo '<script src="' . CANVA_PROJECT_JS_URI . 'facetwp-proximity-primo.js"></script>';
}
add_action('wp_footer', 'add_custom_proximity_js', 30);



//Ordina i post per distanza
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
			if ('proximity_sg' == $f['type'] && !empty($f['selected_values'])) {
				$query->set('orderby', 'post__in');
				$query->set('order', 'ASC');
			}
		}
	}
});
