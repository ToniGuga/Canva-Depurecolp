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
 * Funzione per reperire le info su Open Days
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_open_days()
{
	if (isset($_GET['province']) && '' != trim($_GET['province'])) {
		$province = '&province=' . esc_attr($_GET['province']);
	} elseif (isset($_POST['province']) && '' != trim($_POST['province'])) {
		$province = '&province=' . esc_attr($_POST['province']);
	}

	if (isset($_GET['open_day_type']) && '' != trim($_GET['open_day_type'])) {
		$open_day_type = '&open_day_type=' . esc_attr($_GET['open_day_type']);
	} elseif (isset($_POST['open_day_type']) && '' != trim($_POST['open_day_type'])) {
		$open_day_type = '&open_day_type=' . esc_attr($_POST['open_day_type']);
	}

	if (isset($_GET['startDate']) && '' != trim($_GET['startDate'])) {
		$startDate = '&startDate=' . esc_attr($_GET['startDate']);
	} elseif (isset($_POST['startDate']) && '' != trim($_POST['startDate'])) {
		$startDate = '&startDate=' . esc_attr($_POST['startDate']);
	}

	if (isset($_GET['endDate']) && '' != trim($_GET['endDate'])) {
		$endDate = '&endDate=' . esc_attr($_GET['endDate']);
	} elseif (isset($_POST['endDate']) && '' != trim($_POST['endDate'])) {
		$endDate = '&endDate=' . esc_attr($_POST['endDate']);
	}

	if (isset($_GET['page']) && '' != trim($_GET['page'])) {
		$page = '&page=' . esc_attr($_GET['page']);
	} elseif (isset($_POST['page']) && '' != trim($_POST['page'])) {
		$page = '&page=' . esc_attr($_POST['page']);
	}

	if (isset($_GET['debug']) && '' != trim($_GET['debug'])) {
		$debug = esc_attr($_GET['debug']);
	} else {
		$debug = 'no';
	}

	$api_token = urlencode(primo_up_auth());

	$args = array(
		'timeout'     => 10000,
		'httpversion' => '1.1',
	);

	$response = wp_safe_remote_get(esc_url_raw("https://www.primoup.it/api/v1/open_days?api_token={$api_token}{$province}{$open_day_type}{$startDate}{$endDate}{$page}"), $args);
	$open_days = json_decode(wp_remote_retrieve_body($response));

	if (!empty($open_days)) {

		if ($debug === 'yes') {
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($open_days);
			// var_dump($open_days->data);
			// var_export($response);
		} else {


			foreach ($open_days->data as $open_day) {
				canva_get_template('card-open-day', ['open_day_id' => $open_day->id, 'clinic_id' => $open_day->clinic_id, 'open_day_type' => $open_day->open_day_type, 'date' => $open_day->date]);
			}

			$next_page = '';

			for ($i = (int)$open_days->current_page; $i < (int)$open_days->last_page; $i++) {
				$next_page = (int)$open_days->current_page + 1;
			}

			echo '<div class="text-center">';
			echo '<a class="_load-more button" data-current-page="' . $open_days->current_page . '" data-current-page="' . $open_days->current_page . '" data-next-page="' . $next_page . '" data-last-page="' . $open_days->last_page . '">Mostra di più</a>';
			echo '</div>';
		}
	} else {
		echo 'Error: RestAPI body is null';
	}

	wp_die();
}
add_action('wp_ajax_primo_up_open_days', 'primo_up_open_days');
add_action('wp_ajax_nopriv_primo_up_open_days', 'primo_up_open_days');


/**
 * Funzione per reperire le info su un singolo Open Day
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_open_day()
{

	if (isset($_GET['open_day_id']) && '' != trim($_GET['open_day_id'])) {
		$open_day_id = esc_attr($_GET['open_day_id']);
	} elseif (isset($_POST['open_day_id']) && '' != trim($_POST['open_day_id'])) {
		$open_day_id = esc_attr($_POST['open_day_id']);
	}

	if (isset($_GET['debug']) && '' != trim($_GET['debug'])) {
		$debug = esc_attr($_GET['debug']);
	} else {
		$debug = 'no';
	}

	$api_token = urlencode(primo_up_auth());

	$args = array(
		'timeout'     => 10000,
		'httpversion' => '1.1',
	);

	$response = wp_safe_remote_get(esc_url_raw("https://www.primoup.it/api/v1/open_days/{$open_day_id}?api_token={$api_token}"), $args);
	$open_days = json_decode(wp_remote_retrieve_body($response));

	if (!empty($open_days)) {

		if ($debug === 'yes') {
			// echo "https://www.primoup.it/api/v1/open_days/{$open_day}?api_token={$api_token}";
			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($open_days);
			// var_dump($open_days->clinic_id);
			// var_export($response);
		} else {
			canva_get_template('single-open-day', ['clinic_id' => $open_days->clinic_id, 'open_day_type' => $open_days->open_day_type, 'date' => $open_days->date, 'open_day_type_description' => $open_days->open_day_type_description, 'subscription_link' => $open_days->subscription_link]);

			if ($open_days->other_open_days) {
				echo '<div id="block_617a9252b7fc9" class="_gray-container ">';

				echo '<div class="wp-block-columns _gray-container-row-main-title">
					<div class="wp-block-column _gray-container-col-main-title">
						<h2 class="has-text-align-center _title-main-bt-gray-basic">
						Scopri altri open day <br> nella tua città
						</h2>
					</div>
				</div>';

				echo '<div class="grid grid-cols-3 gap-4">';

				foreach ($open_days->other_open_days as $open_day) {
					canva_get_template('card-open-day', ['open_day_id' => $open_day->id, 'clinic_id' => $open_day->clinic_id, 'open_day_type' => $open_day->open_day_type, 'date' => $open_day->date]);
				}
				echo '</div>';

				echo '</div>';
			}
		}
	} else {
		echo 'Error: RestAPI body is null';
	}

	wp_die();
}
add_action('wp_ajax_primo_up_open_day', 'primo_up_open_day');
add_action('wp_ajax_nopriv_primo_up_open_day', 'primo_up_open_day');


/**
 * Funzione per reperire le info su Open Days
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_open_day_types()
{
	// if (isset($_GET['endDate']) && '' != trim($_GET['endDate'])) {
	// 	$endDate = '&endDate' . esc_attr($_GET['endDate']);
	// } elseif (isset($_POST['endDate']) && '' != trim($_POST['endDate'])) {
	// 	$endDate = '&endDate' . esc_attr($_POST['endDate']);
	// }

	if (isset($_GET['debug']) && '' != trim($_GET['debug'])) {
		$debug = esc_attr($_GET['debug']);
	} else {
		$debug = 'no';
	}

	$api_token = urlencode(primo_up_auth());

	$args = array(
		'timeout'     => 10000,
		'httpversion' => '1.1',
	);

	$response = wp_safe_remote_get(esc_url_raw("https://www.primoup.it/api/v1/open_day_types?api_token={$api_token}"), $args);
	$open_day_types = json_decode(wp_remote_retrieve_body($response));

	if (!empty($open_day_types)) {

		if ($debug === 'yes') {

			header('Content-Type: application/json; charset=utf-8');
			echo json_encode($open_day_types);
			// var_dump($open_day_types->data);
			// var_export($response);

		} else {

			foreach ($open_day_types as $open_day_type) {
				wp_insert_term($open_day_type->name, 'open_day_types', ['slug' => $open_day_type->slug]);
			}
		}
	} else {
		echo 'Error: RestAPI body is null';
	}

	wp_die();
}
add_action('wp_ajax_primo_up_open_day_types', 'primo_up_open_day_types');
add_action('wp_ajax_nopriv_primo_up_open_day_types', 'primo_up_open_day_types');

/**
 * Funzione per reperire le info sulle HR
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_up_hr()
{
	if (isset($_GET['odontoiatra']) && '' != trim($_GET['odontoiatra'])) {
		$odontoiatra = esc_url_raw('https://primogroup.intervieweb.it/annunci.php?lang=it&d=centridentisticiprimo.it&k=94a5e33a274a19b813e3d307345f591f&CodP=1&format=json_en&utype=0');
	} elseif (isset($_POST['odontoiatra']) && '' != trim($_POST['odontoiatra'])) {
		$odontoiatra = esc_url_raw('https://primogroup.intervieweb.it/annunci.php?lang=it&d=centridentisticiprimo.it&k=94a5e33a274a19b813e3d307345f591f&CodP=1&format=json_en&utype=0');
	}

	if (isset($_GET['hq']) && '' != trim($_GET['hq'])) {
		$hq = esc_url_raw('https://primogroup.intervieweb.it/annunci.php?lang=it&d=centridentisticiprimo.it&k=94a5e33a274a19b813e3d307345f591f&CodP=2&format=json_en&utype=0');
	} elseif (isset($_POST['hq']) && '' != trim($_POST['hq'])) {
		$hq = esc_url_raw('https://primogroup.intervieweb.it/annunci.php?lang=it&d=centridentisticiprimo.it&k=94a5e33a274a19b813e3d307345f591f&CodP=2&format=json_en&utype=0');
	}

	if (isset($_GET['medici']) && '' != trim($_GET['medici'])) {
		$medici = esc_url_raw('https://primogroup.intervieweb.it/annunci.php?lang=it&d=centridentisticiprimo.it&k=94a5e33a274a19b813e3d307345f591f&CodP=3&format=json_en&utype=0');
	} elseif (isset($_POST['medici']) && '' != trim($_POST['medici'])) {
		$medici = esc_url_raw('https://primogroup.intervieweb.it/annunci.php?lang=it&d=centridentisticiprimo.it&k=94a5e33a274a19b813e3d307345f591f&CodP=3&format=json_en&utype=0');
	}

	if (isset($_GET['debug']) && '' != trim($_GET['debug'])) {
		$debug = esc_attr($_GET['debug']);
	} else {
		$debug = 'no';
	}

	$args = array(
		'timeout' => 10000,
		'httpversion' => '1.1',
	);

	$response = '';
	if ($odontoiatra) {
		$response = wp_safe_remote_get($odontoiatra, $args);
	} elseif ($hq) {
		$response = wp_safe_remote_get($hq, $args);
	} elseif ($medici) {
		$response = wp_safe_remote_get($medici, $args);
	}

	// var_export($response);

	$hr_data = json_decode(wp_remote_retrieve_body($response));

	if (!empty($hr_data)) {

		if ($debug === 'yes') {
			var_export($hr_data);
		} else {

			foreach ($hr_data as $hr) {
				$hr = (array) $hr;
				// var_export($hr);
				canva_get_template('card-hr', $hr);
			}
		}
	} else {
		echo 'Error: RestAPI body is null';
	}

	wp_die();
}
add_action('wp_ajax_primo_up_hr', 'primo_up_hr');
add_action('wp_ajax_nopriv_primo_up_hr', 'primo_up_hr');

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

	// $args = array(
	// 	'headers' => array(
	// 		'httpversion' => '1.1',
	// 	)
	// );

	$args = array(
		'timeout'     => 20000,
		'httpversion' => '1.1',
	);

	$api_token = urlencode(primo_up_auth());

	$response = wp_safe_remote_get(esc_url_raw("https://www.primoup.it/api/v1/clinics?api_token={$api_token}"), $args);
	$body = json_decode(wp_remote_retrieve_body($response));


	// var_dump($body);
	if ($body->success) {
		$clinics = json_decode(json_encode($body->risp));
		if ($debug === 'yes') {
			var_export($clinics);
		} else {
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

	// $args = array(
	// 	'headers' => array(
	// 		'httpversion' => '1.1',
	// 	)
	// );

	$args = array(
		'timeout'     => 20000,
		'httpversion' => '1.1',
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

				$post = get_posts(array(
					'post_status' => array('publish', 'draft'),
					'posts_per_page'	=> 1,
					'post_type'		=> 'centro',
					'meta_key'		=> 'id',
					'meta_value'	=> intval($clinic->id)
					// 'meta_value'	=> 233
				));

				if (!empty($post)) {

					// dump_to_error_log($post[0]->ID);

					$clinic_post_id = $post[0]->ID;

					// Insert fields data for clinic
					update_field('id', intval($clinic->id), $clinic_post_id);
					// update_field('name', ucfirst(strtolower(wp_unslash($clinic->name))), $clinic_post_id);
					update_field('name', wp_unslash($clinic->name), $clinic_post_id);
					// update_field('address_number', ucwords(strtolower(wp_unslash($clinic->address))), $clinic_post_id);
					update_field('address_number', $clinic->address, $clinic_post_id);
					update_field('zipcode', $clinic->zipcode, $clinic_post_id);
					// update_field('city', ucwords(strtolower(wp_unslash($clinic->city))), $clinic_post_id);
					update_field('city', wp_unslash($clinic->city), $clinic_post_id);
					update_field('province', strtoupper(wp_unslash($clinic->province)), $clinic_post_id);
					// update_field('address_full', ucwords(strtolower(wp_unslash($clinic->address . ', ' . $clinic->zipcode . ', ' . $clinic->city . ', ' . $clinic->province))), $clinic_post_id);
					update_field('address_full', wp_unslash($clinic->address . ', ' . $clinic->zipcode . ', ' . $clinic->city . ', ' . $clinic->province), $clinic_post_id);
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

					//Update post title
					$post_data = array(
						'ID'           => $clinic_post_id,
						'post_title' => wp_unslash($clinic->web_title),
						'post_name' => str_replace(' ', '-', strtolower(wp_unslash($clinic->web_slug))),
					);

					wp_update_post($post_data);
				} else {

					// Create new prodotto post
					$post_data = [
						'post_title' => wp_unslash($clinic->web_title),
						// 'post_title' => ucwords(strtolower(wp_unslash($clinic->web_title))),
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
					// update_field('name', ucfirst(strtolower(wp_unslash($clinic->name))), $clinic_post_id);
					update_field('name', wp_unslash($clinic->name), $clinic_post_id);
					// update_field('address_number', ucwords(strtolower(wp_unslash($clinic->address))), $clinic_post_id);
					update_field('address_number', $clinic->address, $clinic_post_id);
					update_field('zipcode', $clinic->zipcode, $clinic_post_id);
					// update_field('city', ucwords(strtolower(wp_unslash($clinic->city))), $clinic_post_id);
					update_field('city', wp_unslash($clinic->city), $clinic_post_id);
					update_field('province', strtoupper(wp_unslash($clinic->province)), $clinic_post_id);
					// update_field('address_full', ucwords(strtolower(wp_unslash($clinic->address . ', ' . $clinic->zipcode . ', ' . $clinic->city . ', ' . $clinic->province))), $clinic_post_id);
					update_field('address_full', wp_unslash($clinic->address . ', ' . $clinic->zipcode . ', ' . $clinic->city . ', ' . $clinic->province), $clinic_post_id);
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
