<?php
defined('ABSPATH') || exit;

/**
 * Funzione per autenticarsi alla REST API di Primo UP
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_auth()
{
	$username = urlencode('websites@primoup.it');
	$password = urlencode('wJnhstkX9T8V');

	$args = array(
		'headers' => array(
			'httpversion' => '1.1',
		)
	);

	$response = wp_remote_get(esc_url_raw("https://www.primoup.it/api/v1/login?email={$username}&password={$password}"), $args);
	$body = json_decode(wp_remote_retrieve_body($response));

	// var_dump($response);

	$api_token = '';
	foreach ($body as $b) {
		$api_token = $b->api_token;
	}

	// echo $api_token;
	return $api_token;

	wp_die();
}
// add_action('wp_ajax_primo_up_auth', 'primo_up_auth');
// add_action('wp_ajax_nopriv_primo_up_auth', 'primo_up_auth');


/**
 * Funzione per reperire le info sulle cliniche
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_open_days()
{
	$api_token = urlencode(primo_up_auth());

	if (isset($_GET['province']) && '' != trim($_GET['province'])) {
		$province = '&province=' . esc_attr($_GET['province']);
	} elseif (isset($_POST['province']) && '' != trim($_POST['province'])) {
		$province = '&province=' . esc_attr($_POST['province']);
	}

	if (isset($_GET['open_day_type']) && '' != trim($_GET['open_day_type'])) {
		$open_day_type = '&open_day_type' . esc_attr($_GET['open_day_type']);
	} elseif (isset($_POST['open_day_type']) && '' != trim($_POST['open_day_type'])) {
		$open_day_type = '&open_day_type' . esc_attr($_POST['open_day_type']);
	}

	if (isset($_GET['startDate']) && '' != trim($_GET['startDate'])) {
		$startDate = '&startDate' . esc_attr($_GET['startDate']);
	} elseif (isset($_POST['startDate']) && '' != trim($_POST['startDate'])) {
		$startDate = '&startDate' . esc_attr($_POST['startDate']);
	}

	if (isset($_GET['endDate']) && '' != trim($_GET['endDate'])) {
		$endDate = '&endDate' . esc_attr($_GET['endDate']);
	} elseif (isset($_POST['endDate']) && '' != trim($_POST['endDate'])) {
		$endDate = '&endDate' . esc_attr($_POST['endDate']);
	}

	if (isset($_GET['debug']) && '' != trim($_GET['debug'])) {
		$debug = esc_attr($_GET['debug']);
	} else {
		$debug = 'no';
	}

	$response = wp_safe_remote_get(esc_url_raw("https://www.primoup.it/api/v1/open_days?api_token={$api_token}{$province}{$open_day_type}{$startDate}{$endDate}"));
	$open_days = json_decode(wp_remote_retrieve_body($response));

	if (!empty($open_days)) {

		foreach ($open_days as $open_day) {
			// var_export($open_day);
		}

		if ($debug == 'yes') {
			var_export($open_days);
		}
	} else {
		echo 'Error: RestAPI body is null';
	}

	wp_die();
}
add_action('wp_ajax_primo_up_open_days', 'primo_up_open_days');
add_action('wp_ajax_nopriv_primo_up_open_days', 'primo_up_open_days');

/**
 * Funzione per reperire le info sulle cliniche
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_clinics()
{

	if (isset($_GET['debug']) && '' != trim($_GET['debug'])) {
		$debug = esc_attr($_GET['debug']);
	} else {
		$debug = 'no';
	}

	$api_token = urlencode(primo_up_auth());

	$args = array(
		'headers' => array(
			'httpversion' => '1.1',
		)
	);

	$response = wp_safe_remote_get(esc_url_raw("https://www.primoup.it/api/v1/clinics?api_token={$api_token}"), $args);
	$body = json_decode(wp_remote_retrieve_body($response));


	// var_dump($body);
	if ($body->success) {
		$clinics = json_decode(json_encode($body->risp));
		if($debug === 'yes'){
			var_export($clinics);
		}else{
			$debug_data = [];
			foreach ($clinics as $clinic) {
				//echo $clinic->id . ' - ' . $clinic->web_title . ' - ' . $clinic->web_title . ' - ' . $clinic->brand . '<br>';
				$debug_data[] = [$clinic->id, $clinic->web_title, str_replace('/', '', $clinic->web_slug), $clinic->brand, $clinic->latitude . '-' . $clinic->longitude, $clinic->web_visible];
			}

			foreach ($debug_data as $dd) {
				echo implode(', ', $dd) . '<br>';
			}
		}
	} else {
		echo 'Error: RestAPI body is null';
	}

	wp_die();
}
add_action('wp_ajax_primo_up_clinics', 'primo_up_clinics');
add_action('wp_ajax_nopriv_primo_up_clinics', 'primo_up_clinics');


/**
 * Funzione per reperire le info sulle cliniche
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_clinics_import_data()
{
	$api_token = urlencode(primo_up_auth());

	$args = array(
		'headers' => array(
			'httpversion' => '1.1',
		)
	);

	$response = wp_safe_remote_get(esc_url_raw("https://www.primoup.it/api/v1/clinics?api_token={$api_token}"), $args);
	$body = json_decode(wp_remote_retrieve_body($response));

	// var_dump($body);
	if ($body->success) {
		$clinics = json_decode(json_encode($body->risp));

		// var_dump($clinics);
		foreach ($clinics as $clinic) {

			/**
			 *
			 * Regole per l'import:
			 *
			 * i record senza web_title o con web_title vuoto non vengono importati
			 *
			 * i record con web_visible false e senza coordinate vengono importati e salvati in BOZZA
			 *
			 */

			if (($clinic->web_title && $clinic->web_title != '')) {

				if (!post_exists(wp_unslash($clinic->web_title))) {

					// Create new prodotto post
					$post_data = [
						// 'post_title' => ucwords(strtolower(wp_unslash($clinic->web_title))),
						'post_title' => wp_unslash($clinic->web_title),
						'post_name' => str_replace(' ', '-', strtolower(wp_unslash($clinic->web_slug))),
						'post_type' => 'centro',
						// 'post_status' => 'publish',
					];

					if ($clinic->web_visible === 1 && ($clinic->latitude && $clinic->latitude != null) && ($clinic->longitude && $clinic->longitude != null)) {
						$web_visible = ['post_status' => 'publish'];
					} else {
						$web_visible = ['post_status' => 'draft'];
					}

					$post_data = array_merge($post_data, $web_visible);

					$clinic_post_id = wp_insert_post($post_data);
					// dump_to_error_log($clinic_post_id);

					// Insert fields data for clinic
					update_field('id', intval($clinic->id), $clinic_post_id);
					update_field('name', ucfirst(strtolower(wp_unslash($clinic->name))), $clinic_post_id);
					update_field('address_number', ucwords(strtolower(wp_unslash($clinic->address))), $clinic_post_id);
					update_field('zipcode', $clinic->zipcode, $clinic_post_id);
					update_field('city', ucwords(strtolower(wp_unslash($clinic->city))), $clinic_post_id);
					update_field('province', strtoupper(wp_unslash($clinic->province)), $clinic_post_id);
					update_field('address_full', ucwords(strtolower(wp_unslash($clinic->address . ', ' . $clinic->zipcode . ', ' . $clinic->city . ', ' . $clinic->province))), $clinic_post_id);
					update_field('email', wp_unslash($clinic->email), $clinic_post_id);
					update_field('tel', wp_unslash($clinic->phone), $clinic_post_id);

					$tags = [strtolower(wp_unslash(strval($clinic->id))), strtolower(wp_unslash($clinic->zipcode)), ucwords(strtolower(wp_unslash($clinic->city))), strtoupper(wp_unslash($clinic->province))];
					// wp_set_post_terms($clinic_post_id, $tags, 'keywords');
					wp_set_object_terms($clinic_post_id, $tags, 'keywords');

					update_field('latitude', $clinic->latitude, $clinic_post_id);
					update_field('longitude', $clinic->longitude, $clinic_post_id);
					update_field('lat_lng', $clinic->latitude . ',' . $clinic->longitude, $clinic_post_id);
					update_field('google_place_id', $clinic->google_place_id, $clinic_post_id);

					// wp_set_post_terms($clinic_post_id, strtolower(wp_unslash($clinic->brand)), 'brand');
					wp_set_object_terms($clinic_post_id, strtolower(wp_unslash($clinic->brand)), 'brand');

					update_field('clinic_manager', ucfirst(strtolower(wp_unslash($clinic->clinic_manager_name))) . ' ' . ucfirst(strtolower(wp_unslash($clinic->clinic_manager_surname))), $clinic_post_id);
					update_field('director_doctor', ucfirst(strtolower(wp_unslash($clinic->director_doctor_name))) . ' ' . ucfirst(strtolower(wp_unslash($clinic->director_doctor_surname))), $clinic_post_id);
					update_field('director_doctor_registry', wp_unslash($clinic->director_doctor_registry), $clinic_post_id);
					update_field('dentistry_manager', ucfirst(strtolower(wp_unslash($clinic->dentistry_manager_name))) . ' ' . ucfirst(strtolower(wp_unslash($clinic->dentistry_manager_surname))), $clinic_post_id);
					update_field('dentistry_manager_registry', wp_unslash($clinic->dentistry_manager_registry), $clinic_post_id);

					foreach ($clinic->opening_hours as $key => $opening_hour) {
						if ($opening_hour->break_start && $opening_hour->break_end) {
							update_field(strtolower($key), $opening_hour->start . ' - ' . $opening_hour->break_start . '<br>' . $opening_hour->break_end . ' - ' . $opening_hour->end, $clinic_post_id);
						} else {
							update_field(strtolower($key), $opening_hour->start . ' - ' . $opening_hour->end, $clinic_post_id);
						}
					}

					update_field('poliambulatorio', $clinic->ambulatory_care, $clinic_post_id);
					update_field('poliambulatorio_url', $clinic->ambulatory_web_url, $clinic_post_id);
				} else {

					$clinic_post_id = get_page_by_title(wp_unslash($clinic->web_title), OBJECT, 'centro');

					// Insert fields data for clinic
					update_field('id', intval($clinic->id), $clinic_post_id);
					update_field('name', ucfirst(strtolower(wp_unslash($clinic->name))), $clinic_post_id);
					update_field('address_number', ucwords(strtolower(wp_unslash($clinic->address))), $clinic_post_id);
					update_field('zipcode', $clinic->zipcode, $clinic_post_id);
					update_field('city', ucwords(strtolower(wp_unslash($clinic->city))), $clinic_post_id);
					update_field('province', strtoupper(wp_unslash($clinic->province)), $clinic_post_id);
					update_field('address_full', ucwords(strtolower(wp_unslash($clinic->address . ', ' . $clinic->zipcode . ', ' . $clinic->city . ', ' . $clinic->province))), $clinic_post_id);
					update_field('email', wp_unslash($clinic->email), $clinic_post_id);
					update_field('tel', wp_unslash($clinic->phone), $clinic_post_id);

					$tags = [strtolower(wp_unslash(strval($clinic->id))), strtolower(wp_unslash($clinic->zipcode)), ucwords(strtolower(wp_unslash($clinic->city))), strtoupper(wp_unslash($clinic->province))];
					// wp_set_post_terms($clinic_post_id->ID, $tags, 'keywords');
					wp_set_object_terms($clinic_post_id->ID, $tags, 'keywords');

					update_field('latitude', $clinic->latitude, $clinic_post_id);
					update_field('longitude', $clinic->longitude, $clinic_post_id);
					update_field('lat_lng', $clinic->latitude . ',' . $clinic->longitude, $clinic_post_id);
					update_field('google_place_id', $clinic->google_place_id, $clinic_post_id);

					// wp_set_post_terms($clinic_post_id->ID, strtolower(wp_unslash($clinic->brand)), 'brand');
					wp_set_object_terms($clinic_post_id->ID, strtolower(wp_unslash($clinic->brand)), 'brand');

					update_field('clinic_manager', ucfirst(strtolower(wp_unslash($clinic->clinic_manager_name))) . ' ' . ucfirst(strtolower(wp_unslash($clinic->clinic_manager_surname))), $clinic_post_id);
					update_field('director_doctor', ucfirst(strtolower(wp_unslash($clinic->director_doctor_name))) . ' ' . ucfirst(strtolower(wp_unslash($clinic->director_doctor_surname))), $clinic_post_id);
					update_field('director_doctor_registry', wp_unslash($clinic->director_doctor_registry), $clinic_post_id);
					update_field('dentistry_manager', ucfirst(strtolower(wp_unslash($clinic->dentistry_manager_name))) . ' ' . ucfirst(strtolower(wp_unslash($clinic->dentistry_manager_surname))), $clinic_post_id);
					update_field('dentistry_manager_registry', wp_unslash($clinic->dentistry_manager_registry), $clinic_post_id);

					foreach ($clinic->opening_hours as $key => $opening_hour) {
						if ($opening_hour->break_start && $opening_hour->break_end) {
							update_field(strtolower($key), $opening_hour->start . ' - ' . $opening_hour->break_start . '<br>' . $opening_hour->break_end . ' - ' . $opening_hour->end, $clinic_post_id);
						} else {
							update_field(strtolower($key), $opening_hour->start . ' - ' . $opening_hour->end, $clinic_post_id);
						}
					}

					update_field('poliambulatorio', $clinic->ambulatory_care, $clinic_post_id);
					update_field('poliambulatorio_url', $clinic->ambulatory_web_url, $clinic_post_id);

					// Draft if web_visible == 0
					if (!$clinic->web_visible) {
						$web_visible = [
							'ID'    =>  $clinic_post_id,
							'post_status' => 'draft'
						];
						wp_update_post($web_visible, true);
					}

					if (is_wp_error($clinic_post_id)) {
						$errors = $clinic_post_id->get_error_messages();
						foreach ($errors as $error) {
							echo $error;
						}
					}
				}
			}
		}

		primo_fwp_purge_reindex();
	} else {
		echo 'Error: RestAPI body is null';
	}

	wp_die();
}
add_action('wp_ajax_primo_up_clinics_update', 'primo_up_clinics_import_data');
add_action('wp_ajax_nopriv_primo_up_clinics_update', 'primo_up_clinics_import_data');


/**
 * funzione che pulisce la cache di facetwp
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_fwp_purge_reindex()
{
	if (class_exists('FacetWP')) {
		global $wpdb;

		$wpdb->query("TRUNCATE TABLE {$wpdb->prefix}facetwp_index");

		delete_option('facetwp_version');
		delete_option('facetwp_indexing');
		delete_option('facetwp_transients');

		FWP()->indexer->index();
	}
}

/**
 * Funzione che triggeta la chiamata ajax per avviare l'import
 *
 * @return void
 */
function primo_up_clinics_update()
{
	wp_remote_post(admin_url('admin-ajax.php'), array(
		'method' => 'POST',
		'timeout' => 150,
		'redirection' => 5,
		'httpversion' => '1.0',
		'blocking' => false,
		'headers' => array(),
		'body' => array(
			'action' => 'primo_up_clinics_update',
			// 'microfam' => strtoupper('unv'),
			// 'records' => 3000,
			// 'nonce' => wp_create_nonce(),
		),
		'cookies'     => array(),
	));

	// if ( is_wp_error( $response ) ) {
	// 	$error_message = $response->get_error_message();
	// 	echo "Something went wrong: $error_message";
	// } else {
	// 	echo 'Response:<pre>';
	// 	print_r( $response );
	// 	echo '</pre>';
	// }

}
add_action('primo_up_clinics_update', 'primo_up_clinics_update');

/**
 * funzione che programma l'aggiornamento dei centri dentistici da REST API Primo UP
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
if (class_exists('ActionScheduler')) {
	function primo_up_clinics_daily_update() // nome nuova funzione
	{
		if (false === as_next_scheduled_action('primo_up_clinics_update')) { //funzione da richiamare
			as_schedule_recurring_action(strtotime('22:00:00'), DAY_IN_SECONDS, 'primo_up_clinics_update'); // posso usare monday e week in seconds
		}
	}
	add_action('init', 'primo_up_clinics_daily_update');
}
