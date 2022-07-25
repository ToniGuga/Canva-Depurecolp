<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

// qui si trovano tutte le funzioni legate alle mappe di google e openstreetmap e mapbox

/**
 * funzioni per calcolare la distanza in KM tra due coordinate gps.
 *
 * @url https://stackoverflow.com/questions/29752033/filter-wordpress-posts-by-distance-between-coordinates
 */
const R = 6371; // km

function distance_between_points_rad($lat1, $lng1, $lat2, $lng2)
{
	// latlng in radians
	$x = ($lng2 - $lng1) * cos(($lat1 + $lat2) / 2);
	$y = ($lat2 - $lat1);
	// return distance in km
	return sqrt($x * $x + $y * $y) * R;
}

function get_destination_lat_rad($lat1, $lng1, $d, $brng)
{
	return asin(sin($lat1) * cos($d / R) + cos($lat1) * sin($d / R) * cos($brng));
}

function get_destination_lng_rad($lat1, $lng1, $d, $brng)
{
	$lat2 = get_destination_lat_rad($lat1, $lng1, $d, $brng);

	return $lng1 + atan2(sin($brng) * sin($d / R) * cos($lat1), cos($d / R) - sin($lat1) * sin($lat2));
}

function get_bounding_box_rad($lat, $lng, $range)
{
	// latlng in radians, $range in km
	$latmin = get_destination_lat_rad($lat, $lng, $range, 0);
	$latmax = get_destination_lat_rad($lat, $lng, $range, deg2rad(180));
	$lngmax = get_destination_lng_rad($lat, $lng, $range, deg2rad(90));
	$lngmin = get_destination_lng_rad($lat, $lng, $range, deg2rad(270));
	// return approx bounding latlng in radians
	return [$latmin, $latmax, $lngmin, $lngmax];
}

function distance_between_points_deg($lat1, $lng1, $lat2, $lng2)
{
	// latlng in degrees
	// return distance in km
	return distance_between_points_rad(
		deg2rad($lat1),
		deg2rad($lng1),
		deg2rad($lat2),
		deg2rad($lng2)
	);
}

function get_bounding_box_deg($lat, $lng, $range)
{
	// latlng in degrees, $range in km
	return array_map(rad2deg, get_bounding_box_rad(deg2rad($lat), deg2rad($lng), $range));
}


/**
 * Activates Google Maps for ACF
 *
 * @return void
 */
function get_google_map_api_key()
{
	if (get_field('google_maps_api_key', 'options')) {
		$apikey = get_field('google_maps_api_key', 'options');
	} else {
		$apikey = '';
	}

	return $apikey;
}

function canva_acf_google_map_api($api)
{
	$api['key'] = get_google_map_api_key();

	return $api;
}
add_filter('acf/fields/google_map/api', 'canva_acf_google_map_api');


function canva_acf_map_init()
{
	acf_update_setting('google_api_key', get_google_map_api_key());
}
add_action('acf/init', 'canva_acf_map_init');


/**
 *
 * canva_static_map()
 * genera mappa statica immagine come background o img tag
 *
 */
function canva_get_static_map($type = 'img', $class = 'bg-cover bg-no-repeat bg-center', $address = '', $lat = '', $lng = '', $width = '800', $height = '800', $zoom = '14')
{
	//For more info read: https://developers.google.com/maps/documentation/static-maps/intro

	if ('background' == $type || 'bg' == $type) {
		$html = '<a href="http://www.google.it/maps/preview#!q=' . urlencode($address) . '" target="_blank" rel="nofollow noopener"><div class="bg-map-static ' . $class . '" style="background-image:url(https://maps.googleapis.com/maps/api/staticmap?center=' . $lat . ',' . $lng . '&markers=color:red%7Clabel:C%7C' . $lat . ',' . $lng . '&zoom=' . $zoom . '&size=' . $width . 'x' . $height . '&key=' . get_google_map_api_key() . ')"></div></a>';
	} else {
		$html = '<a href="http://www.google.it/maps/preview#!q=' . urlencode($address) . '" target="_blank" rel="nofollow noopener"><img class="" src="https://maps.googleapis.com/maps/api/staticmap?center=' . $lat . ',' . $lng . '&markers=color:red%7Clabel:C%7C' . $lat . ',' . $lng . '&zoom=' . $zoom . '&size=' . $width . 'x' . $height . '&key=' . get_google_map_api_key() . '" /></a>';
	}

	return $html;
}

/**
 * get acf google map address
 *
 * @param string $post_id
 * @param string $field
 * @return void
 */
function canva_get_google_maps_address($post_id = '', $field = '')
{
	$field = get_field($field, $post_id);
	$sub_field = get_sub_field($field, $post_id);

	if ($field) {
		$location = $field;
	} else {
		$location = $sub_field;
	}

	if (!empty($location)) {
		return $location['address'];
	}
}

/**
 * get acf google maps adress url
 *
 * @param string $post_id
 * @param string $field
 * @return void
 */
function canva_get_google_maps_address_url($post_id = '', $field = '')
{
	$field = get_field($field, $post_id);
	$sub_field = get_sub_field($field, $post_id);

	if ($field) {
		$location = $field;
	} else {
		$location = $sub_field;
	}

	if (!empty($location)) {
		if (!empty($location['address'])) {
			return 'http://www.google.com/maps/preview#!q=' . urlencode($location['address']);
		}

		return 'http://www.google.com/maps/preview#!q=' . urlencode($location);
	}
}

function canva_get_google_maps_url($post_id = '', $field = '')
{
	echo canva_get_google_maps_address_url($post_id, $field);
}

/**
 * canva_get_google_map_url();.
 *
 * @param mixed $address
 *
 * @return string
 */
function canva_get_google_map_url($address = '')
{
	return 'http://www.google.com/maps/preview#!q=' . urlencode($address);
}

/**
 * @param mixed $address
 * @param mixed $cap
 * @param mixed $city
 * @param mixed $country
 */
function get_latitude($address = '', $cap = '', $city = '', $country = '')
{
	if ($address && $cap && $city && $country) {
		$full_address = $address . ',' . $cap . ',' . $city . ',' . $country;
	} else {
		$full_address = $address;
	}
	//api predefinita per generare le coordinate gps con GeocodeAPI di Google
	$sg_google_geocode_api_key = get_google_map_api_key();
	$request = wp_remote_get('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($full_address) . '&sensor=false&key=' . $sg_google_geocode_api_key);
	$response = wp_remote_retrieve_body($request);
	$output = json_decode($response);

	return $output->results[0]->geometry->location->lat;
}

/**
 * @param mixed $address
 * @param mixed $cap
 * @param mixed $city
 * @param mixed $country
 */
function get_longitude($address = '', $cap = '', $city = '', $country = '')
{
	if ($address && $cap && $city && $country) {
		$full_address = $address . ',' . $cap . ',' . $city . ',' . $country;
	} else {
		$full_address = $address;
	}
	//api predefinita per generare le coordinate gps con GeocodeAPI di Google
	$sg_google_geocode_api_key = get_google_map_api_key();
	$request = wp_remote_get('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($full_address) . '&sensor=false&key=' . $sg_google_geocode_api_key);
	$response = wp_remote_retrieve_body($request);
	$output = json_decode($response);
	return $output->results[0]->geometry->location->lng;
}

/*
 * canva_google_maps_single($field='')
 * stampa la mappa di un marker singolo nel template
 */
function canva_google_maps_single($field = '', $type = 'static')
{
	$location = get_field($field);
	//var_dump($location);
?>
	<?php if (!empty($location)) { ?>
		<?php if ('static' != $type) { ?>

			<div id="map" class="acf-map z-0">
				<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
			</div>

		<?php } else { ?>

			<div id="map" class="small-margin-bottom3em text-center">
				<?php echo canva_static_map($type = 'img', $address = $location['address'], $lat = $location['lat'], $lng = $location['lng'], $width = '640', $height = '480', $zoom = '17', $apikey = get_googlemap_apikey()); ?>
			</div>

		<?php } ?>
	<?php } ?>

<?php
}
