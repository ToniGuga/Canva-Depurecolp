<?php
defined('ABSPATH') || exit;

// add_action('template_redirect', function () {
// 	ob_start();
// });

//////////////////////////////////////////////////////////////////////////////////////////
// Required files
// Acf fields for theme stuff
require_once 'cpt-register.php';
require_once 'acf-fields-project.php';
// require_once 'facetwp-proximity-primo.php';
require_once 'fn-facetwp.php';
require_once 'fn-restapi.php';

//////////////////////////////////////////////////////////////////////////////////////////

// BACKEND
// aggiunge excerpt alle pagine
add_post_type_support('page', 'excerpt');


/**
 * Setup Phpmailer per Primo
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $phpmailer
 * @return void
 */
function primo_send_smtp_email($phpmailer)
{
	$phpmailer->isSMTP();
	// $phpmailer->SMTPDebug = 2;
	// $phpmailer->debug     = 1;
	$phpmailer->Host       = 'smtps.aruba.it';
	$phpmailer->SMTPAuth   = true;
	$phpmailer->Port       = '465';
	$phpmailer->Username   = 'recover@centridentisticiprimo.it';
	$phpmailer->Password   = 'Recoprimo2022!';
	$phpmailer->SMTPSecure = 'ssl';
	$phpmailer->From       = 'no-reply@centridentisticiprimo.it';
	$phpmailer->FromName   = 'centridentisticiprimo.it';
}
add_action('phpmailer_init', 'primo_send_smtp_email');


/**
 * modifica il placeholder titolo quando per post type
 *
 * @param [type] $title
 * @return void
 */
function change_default_title($title)
{
	$screen = get_current_screen();

	if ('servizio' == $screen->post_type) {
		$title = 'Aggiungi nome servizio';
	}

	if ('centro' == $screen->post_type) {
		$title = 'Aggiungi nome centro';
	}

	if ('candidatura' == $screen->post_type) {
		$title = 'Aggiungi candidatura';
	}

	if ('open-day' == $screen->post_type) {
		$title = 'Aggiungi open day';
	}

	if ('faq' == $screen->post_type) {
		$title = 'Aggiungi titolo FAQ';
	}

	return $title;
}
add_filter('enter_title_here', 'change_default_title');


/**
 * Remove the slug from published post permalinks. Only affect our custom post type, though.
 * @url https://kellenmace.com/remove-custom-post-type-slug-from-permalinks/
 */
function primo_remove_cpt_slug($post_link, $post)
{
	if ('centro' === $post->post_type && 'publish' === $post->post_status) {
		$post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);
	}

	return $post_link;
}
add_filter('post_type_link', 'primo_remove_cpt_slug', 10, 2);



/**
 * Have WordPress match postname to any of our public post types (post, page, race).
 * All of our public post types can have /post-name/ as the slug, so they need to be unique across all posts.
 * By default, WordPress only accounts for posts and pages where the slug is /post-name/.
 *
 * @param $query The current query.
 * @url https://kellenmace.com/remove-custom-post-type-slug-from-permalinks/
 */
function primo_add_cpt_post_names_to_main_query($query)
{

	// Bail if this is not the main query.
	if (!$query->is_main_query()) {
		return;
	}

	// Bail if this query doesn't match our very specific rewrite rule.
	if (!isset($query->query['page']) || 2 !== count($query->query)) {
		return;
	}

	// Bail if we're not querying based on the post name.
	if (empty($query->query['name'])) {
		return;
	}

	// Add CPT to the list of post types WP will include when it queries based on the post name.
	$query->set('post_type', array('post', 'page', 'centro'));
}
add_action('pre_get_posts', 'primo_add_cpt_post_names_to_main_query');


/**
 * add extra columns to post type centro
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $columns
 * @return void
 */
function centro_extra_columns($columns)
{

	$columns['clinic_id'] = __('Clinic ID', 'your-translate-text-domain');
	// $columns['zipcode'] = __('CAP', 'your-translate-text-domain');
	$columns['city'] = __('Città', 'your-translate-text-domain');
	// $columns['province'] = __('Provincia', 'your-translate-text-domain');
	$columns['address_full'] = __('Indirizzo', 'your-translate-text-domain');
	$columns['clinic_manager'] = __('Clinic manager', 'your-translate-text-domain');
	$columns['director_doctor'] = __('Director doctor', 'your-translate-text-domain');
	$columns['director_doctor_registry'] = __('Director doctor reg', 'your-translate-text-domain');
	$columns['dentistry_manager'] = __('Dentistry manager', 'your-translate-text-domain');
	$columns['dentistry_manager_registry'] = __('Dentistry manager reg', 'your-translate-text-domain');
	$columns['email'] = __('Email', 'your-translate-text-domain');
	$columns['tel'] = __('Tel', 'your-translate-text-domain');
	$columns['poliambulatorio'] = __('Poliambulatorio', 'your-translate-text-domain');
	$columns['opening_hours'] = __('Orari', 'your-translate-text-domain');

	return $columns;
}
add_filter('manage_edit-centro_columns', 'centro_extra_columns', 10);

/**
 * populate centro extra columns with data
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $column
 * @return void
 */
function centro_extra_columns_content($column)
{
	global $post;

	//esempio con campi ACF
	if ('clinic_id' === $column) {
		echo get_field('id', $post->ID);
	} elseif ('zipcode' === $column) {
		echo get_field('zipcode', $post->ID);
	} elseif ('city' === $column) {
		echo get_field('city', $post->ID);
	} elseif ('province' === $column) {
		echo get_field('province', $post->ID);
	} elseif ('address_full' === $column) {
		echo get_field('address_full', $post->ID);
	} elseif ('clinic_manager' === $column) {
		echo get_field('clinic_manager', $post->ID);
	} elseif ('director_doctor' === $column) {
		echo get_field('director_doctor', $post->ID);
	} elseif ('director_doctor_registry' === $column) {
		echo get_field('director_doctor_registry', $post->ID);
	} elseif ('dentistry_manager' === $column) {
		echo get_field('dentistry_manager', $post->ID);
	} elseif ('dentistry_manager_registry' === $column) {
		echo get_field('dentistry_manager_registry', $post->ID);
	} elseif ('email' === $column) {
		echo get_field('email', $post->ID);
	} elseif ('tel' === $column) {
		echo get_field('tel', $post->ID);
	} elseif ('poliambulatorio' === $column) {
		if (get_field('poliambulatorio', $post->ID)) {
			echo 'Si';
		} else {
			echo 'No';
		}
	} elseif ('opening_hours' === $column) {
		echo get_field('mon', $post->ID) . '<br>';
		echo get_field('tue', $post->ID) . '<br>';
		echo get_field('wed', $post->ID) . '<br>';
		echo get_field('thu', $post->ID) . '<br>';
		echo get_field('fri', $post->ID) . '<br>';
		echo get_field('sat', $post->ID) . '<br>';
		echo get_field('sun', $post->ID) . '<br>';
	}
}
add_action('manage_centro_posts_custom_column', 'centro_extra_columns_content');


function primo_change_default_title($title)
{
	$screen = get_current_screen();

	if ('centro' == $screen->post_type) {
		$title = 'Nome Centro';
	}

	return $title;
}

add_filter('enter_title_here', 'primo_change_default_title');


// FRONTEND

// project default icons
define('MAIL_ICON', 'primo-icons/icon-mail-Primo-Centri-Dentistici');
define('TEL_ICON', 'primo-icons/icon-phone-call');
define('CLINIC_MANAGER_ICON', 'primo-icons/icon-clinic-manager');
define('DIRECTOR_DOCTOR_ICON', 'primo-icons/icon-direttore-sanitario');
define('DENTISTRY_MANAGER_ICON', 'primo-icons/icon-responsabile-odontostomatologia');
define('CLOCK_ICON', 'primo-icons/icon-orari');

// project default images
define('IMG_ID_PRIMO', 5861);
define('IMG_ID_CAREDENT', 5861);
define('IMG_ID_DENTIX', 5861);
define('IMG_ID_FRANCHISEE', 5861);

// project default colors
define('COLOR_PRIMO', '#adbd18');
define('COLOR_CAREDENT', '#009e92');
define('COLOR_DENTIX', '#adbd18');
define('COLOR_FRANCHISEE', '#adbd18');
define('COLOR_ETICA', '#adbd18');


/**
 * Disable Google Maps scripts
 *
 * @return void
 */
function studio42_project_deregister_google_maps_script()
{
	// if (is_page([14684, 16509])) {
	if (!is_singular('centro')) {
		wp_deregister_script('google-maps-api-asyncdefer');
	}
}
add_action('wp_enqueue_scripts', 'studio42_project_deregister_google_maps_script', PHP_INT_MAX);


//Disable extra styles e scripts
function primo_project_deregister_styles()
{
	if (is_singular('post')) {
		wp_deregister_script('swiper');
		wp_deregister_script('photoswipe-async');
		wp_deregister_script('photoswipeui-async');
	}
}
add_action('wp_enqueue_scripts', 'primo_project_deregister_styles', PHP_INT_MAX);



// Disattiva yoast seo json ld per per le pagine e per i centri
add_action('wp_enqueue_scripts', function () {
	if (is_singular('page') || is_singular('centro')) {
		add_filter('wpseo_json_ld_output', '__return_false');
	}
});


function primo_centro_json_ld()
{
	$post_id = get_the_ID();

	if (is_singular('page')) {

		// validato OK 11 ottobre 2021
		if (get_field('tel', $post_id)) {
			$phone = '"telephone": "' . get_field('tel', $post_id) . '",';
		} else {
			$phone = '"telephone": "' . get_field('telephone', 'options') . '",';
		}

		$html = '';
		$html .= '<script type="application/ld+json" class="yoast-schema-graph">';
		$html .= '
		{
			"@context": "https:\/\/schema.org",
			"@type": "MedicalOrganization",
			"name": "Primo S.p.A.",
			"url": "' . get_permalink($post_id) . '",
			"address": {
				"@type": "PostalAddress",
				"addressLocality": "' . get_field('city', $post_id) . ', Italia",
				"postalCode": "' . get_field('zipcode', $post_id) . '",
				"streetAddress": "' . get_field('address_number', $post_id) . '"
			},
			"ContactPoint": {
				"@type": "ContactPoint",
				"contactType": "customer support",
				' . $phone . '
				"areaServed": [
					"IT"
				],
				"availableLanguage": [
					"Italian"
				]
			},
			"logo": {
				"@type": "ImageObject",
				"url": "https: //www.centridentisticiprimo.it/wp-content/uploads/2020/06/logo-primo-caredent-header.png",
				"width": 540,
				"height": 162
			},
			"sameAs": [
				"' . get_field('facebook', 'options') . '",
				"' . get_field('instagram', 'options') . '",
				"' . get_field('youtube', 'options') . '",
				"' . get_field('linkedin', 'options') . '"
			]
		}
		';
		$html .= '</script>';

		// echo $html;
		echo canva_minifier($html);
	} elseif (is_singular('centro')) {

		// validato OK 11 ottobre 2021
		if (get_field('tel', $post_id)) {
			$phone = '"telephone": "' . get_field('tel', $post_id) . '",';
		} else {
			$phone = '"telephone": "' . get_field('telephone', 'options') . '",';
		}

		if (get_field('tel', $post_id)) {
			$email = '"email": "' . get_field('email', $post_id) . '",';
		} else {
			$email = '"email": "' . get_field('email', 'options') . '",';
		}

		$html = '';

		$html .= '<script type="application/ld+json">';
		$html .= '
			{
				"@context": "https:\/\/schema.org",
				"@type": "Dentist",
				"name": "' . get_field('name', $post_id) . '",
				"parentOrganization": "Primo S.p.A.",
				"description": "Centro dentistico a ' . get_field('city', $post_id) . '",
				"openingHours": [
					"Mo ' . str_replace(' ', '', get_field('lun', $post_id)) . '",
					"Tu ' . str_replace(' ', '', get_field('mar', $post_id)) . '",
					"We ' . str_replace(' ', '', get_field('mer', $post_id)) . '",
					"Th ' . str_replace(' ', '', get_field('gio', $post_id)) . '",
					"Fr ' . str_replace(' ', '', get_field('ven', $post_id)) . '",
					"Sa ' . str_replace(' ', '', get_field('sab', $post_id)) . '"
				],
				' . $phone . '
				' . $email . '
				"address": {
					"@type": "PostalAddress",
					"addressLocality": "' . get_field('city', $post_id) . ', Italia",
					"postalCode": "' . get_field('zipcode', $post_id) . '",
					"streetAddress": "' . get_field('address_number', $post_id) . '"
				},
				"paymentAccepted": "Cash, Credit Card",
				"priceRange": "$$",
				"aggregateRating": {},
				"image": "https: //www.centridentisticiprimo.it/wp-content/uploads/2020/06/logo-primo-caredent-header.png",
				"review": []
			}
		';
		$html .= '</script>';

		// echo $html;
		echo canva_minifier($html);
	}
}
add_action('wp_head', 'primo_centro_json_ld', PHP_INT_MAX);


/**
 * used to print icons for menu items
 *
 * @param [type] $items
 * @param [type] $args
 * @return void
 */

function primo_wp_nav_menu_items_icons($items, $args)
{
	foreach ($items as &$item) {
		$icon = get_field('menu_icon', $item);
		$icon_hover = get_field('menu_icon_hover', $item);

		if ($icon) {

			$html = '';
			$html .= '<div class="icon">';
			$html .= canva_get_img([
				'img_id'   =>  $icon,
				'thumb_size' =>  '160-11',
				'img_class' =>  '',
				'wrapper_class' =>  '',
				'blazy' => 'off',
			]);

			if ($icon_hover) {
				$html .= canva_get_img([
					'img_id'   =>  $icon_hover,
					'thumb_size' =>  '160-11',
					'img_class' =>  '',
					'wrapper_class' =>  'hide',
					'blazy' => 'off',
				]);
			}

			$html .= '</div>';

			$item->title .= $html;

			// var_dump($item);
		}
	}

	return $items;
}

add_filter('wp_nav_menu_objects', 'primo_wp_nav_menu_items_icons', 10, 2);



// /**
//  * Aggiunge id ai titoli H
//  *
//  * @param [type] $block_content
//  * @param [type] $block
//  * @return void
//  */
// function primo_add_id_to_heading_block($block_content, $block)
// {
// 	if ('core/heading' == $block['blockName']) {
// 		// $block_content = preg_replace_callback("#<(h[1-6°])>(.*?)</\\1>#", "primo_add_id_to_heading", $block_content);
// 		$block_content = preg_replace_callback("#<(h[2])>(.*?)</\\1>#", "primo_add_id_to_heading", $block_content);
// 	}
// 	return $block_content;
// }
// add_filter('render_block', 'primo_add_id_to_heading_block', 10, 2);


// function primo_add_id_to_heading($match)
// {
// 	list(, $heading, $title) = $match;
// 	$id = sanitize_title_with_dashes($title);
// 	//$anchor = '<a href="#' . $id . '" aria-hidden="true" class="anchor" id="' . $id . '" title="Anchor for ' . $title . '">#</a>';
// 	return "<$heading id='$id' class=\"h4 mt-8 uppercase\">$title $anchor</$heading>";
// }


function table_of_contents($post_id = '')
{
	$post = get_post($post_id);

	if (has_blocks($post->post_content)) {
		$blocks = parse_blocks($post->post_content);

		// dump_to_error_log($blocks);

		echo '<ul class="toc-list canva-ul mb-0">';
		foreach ($blocks as $block) {
			// var_export($block);

			$blockName = $block['blockName'];
			if ('core/heading' === $blockName) {
				echo '<li><a href="#' . sanitize_title_with_dashes(wp_strip_all_tags($block['innerHTML'])) . '">' . wp_strip_all_tags($block['innerHTML']) . '</a></li>';
			}
		}
		echo '</ul>';
	}
}

/**
 * Serve per controllare se ci sono titoli per creare un sommario
 *
 * @param string $post_id
 * @return boolean
 */
function is_table_of_contents($post_id = '')
{
	$post = get_post($post_id);

	$val = false;
	if (has_blocks($post->post_content)) {
		$blocks = parse_blocks($post->post_content);
		// dump_to_error_log($blocks);
		foreach ($blocks as $block) {
			// var_export($block);
			$blockName = $block['blockName'];
			if ('core/heading' === $blockName) {
				$val = true;
			}
		}
	}

	return $val;
}

function primo_fascia_visita()
{
	// return;
	$post = get_post(20506);

	// $post_content = apply_filters('the_content', $post->post_content);
	$post_content = $post->post_content;
	return $post_content;
}
add_shortcode('fascia_visita', 'primo_fascia_visita');

// shortocode fallback
function primo_fascia_igiene()
{
	// return;
	$post = get_post(20506);

	// $post_content = apply_filters('the_content', $post->post_content);
	$post_content = $post->post_content;
	return $post_content;
}
add_shortcode('fascia_igiene', 'primo_fascia_igiene');

function primo_fascia_implantologia_glossario()
{
	// return;
	$post = get_post(20506);

	// $post_content = apply_filters('the_content', $post->post_content);
	$post_content = $post->post_content;
	return $post_content;
}
add_shortcode('fascia_implantologia_glossario', 'primo_fascia_implantologia_glossario');

function primo_fascia_implantologia_ebook()
{
	// return;
	$post = get_post(20506);

	// $post_content = apply_filters('the_content', $post->post_content);
	$post_content = $post->post_content;
	return $post_content;
}
add_shortcode('fascia_implantologia_ebook', 'primo_fascia_implantologia_ebook');

function primo_fascia_sbiancamento_denti()
{
	// return;
	$post = get_post(20506);

	// $post_content = apply_filters('the_content', $post->post_content);
	$post_content = $post->post_content;
	return $post_content;
}
add_shortcode('fascia_sbiancamento_denti', 'primo_fascia_sbiancamento_denti');

function primo_fascia_ortodonzia_adulti()
{
	// return;
	$post = get_post(20506);

	// $post_content = apply_filters('the_content', $post->post_content);
	$post_content = $post->post_content;
	return $post_content;
}
add_shortcode('fascia_ortodonzia_adulti', 'primo_fascia_ortodonzia_adulti');

function primo_fascia_gengive()
{
	// return;
	$post = get_post(20506);

	// $post_content = apply_filters('the_content', $post->post_content);
	$post_content = $post->post_content;
	return $post_content;
}
add_shortcode('fascia_gengive', 'primo_fascia_gengive');






/**
 * Funzione per personalizzare il breadcrumbs di Yoast
 *
 * @param [type] $links
 * @return void
 */
function primo_custom_breadcrumbs($links)
{
	global $post;

	if (is_singular('post')) {

		$blog_archive = get_permalink(get_page_by_path('consigli'));
		$terms_slug = canva_get_post_terms($post->ID, 'category', 'slug');
		$terms_name = canva_get_post_terms($post->ID, 'category', 'name');
		$blog_archive_param = $blog_archive . '?_categorie_blog=' . $terms_slug[0];

		// $breadcrumbs = [
		// 	'url' => $blog_archive,
		// 	'text' => __('Consigli', 'studio42-Primo'),
		// ];

		// array_unshift($links, $breadcrumbs);

		$breadcrumbs = [
			'url' => $blog_archive_param,
			'text' => $terms_name[0],
		];

		array_unshift($links, $breadcrumbs);
	}

	$home_page = [
		'url' => home_url(),
		'text' => '<span class="tg-homepage-icon">Home</span>',
	];

	array_unshift($links, $home_page);

	return $links;
}
add_filter('wpseo_breadcrumb_links', 'primo_custom_breadcrumbs');



/**
 * Save Heros Attachment IDS as custom fields fo preload function
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $post_id
 * @param [type] $post
 * @param [type] $update
 * @return void
 */
function primo_set_meta_preload_url($post_id, $post, $update)
{

	//Check it's not an auto save routine
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
		return;
	}

	// If this is a revision, get real post ID
	if ($parent_id = wp_is_post_revision($post_id)) {
		$post_id = $parent_id;
	}

	$post = get_post($post_id);

	if (has_blocks($post->post_content)) {

		$blocks = parse_blocks($post->post_content);

		//HERO IMAGE LINK or HERO BASIC
		if ($blocks[0]['blockName'] === 'acf/hero-form' || $blocks[0]['blockName'] === 'acf/hero-cta') {

			$bg_image = $blocks[0]['attrs']['data']['bg_image'];
			$bg_image_small = $blocks[0]['attrs']['data']['bg_image_small'];

			if ($bg_image) {
				update_post_meta($post_id, 'hero_attachment_large_id', $bg_image);
			}

			if ($bg_image_small) {
				update_post_meta($post_id, 'hero_attachment_small_id', $bg_image_small);
			}
		}
	}
}
add_action('save_post', 'primo_set_meta_preload_url', 99, 3);

/**
 * Print preload image for first hero block in wp_head
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function primo_print_preload_heros_imgs()
{
	$post_id = get_the_id();
	$hero_attachment_large_id = get_post_meta($post_id, 'hero_attachment_large_id', true);
	$hero_attachment_small_id = get_post_meta($post_id, 'hero_attachment_small_id', true);

	if ($hero_attachment_large_id) {
		$hero_img_large_url = canva_get_img(
			[
				'img_id' => $hero_attachment_large_id, //'post_id','attachment_id',
				'img_type' => 'url', //'img', 'bg', 'url'
				'thumb_size' => '1600-free', //'640-free',
				'figure_class' => '',
				'img_class' => '',
				'bg_content' => '',
				'caption' => 'off',
				'blazy' => 'off',
				'srcset' => 'off',
				'data_attr' => '',
				'width' => '',
				'height' => '',
			]
		);

		echo '<link rel="preload" as="image" href="' . esc_url($hero_img_large_url) . '" media="(min-width: 640px)">';
		if (!$hero_attachment_small_id) {
			echo '<link rel="preload" as="image" href="' . esc_url($hero_img_large_url) . '" media="(max-width: 639px)">';
		}
	}

	if ($hero_attachment_small_id) {
		$hero_img_small_url = canva_get_img(
			[
				'img_id' => $hero_attachment_small_id, //'post_id','attachment_id',
				'img_type' => 'url', //'img', 'bg', 'url'
				'thumb_size' => '640-free', //'640-free',
				'figure_class' => '',
				'img_class' => '',
				'bg_content' => '',
				'caption' => 'off',
				'blazy' => 'off',
				'srcset' => 'off',
				'data_attr' => '',
				'width' => '',
				'height' => '',
			]
		);

		echo '<link rel="preload" as="image" href="' . esc_url($hero_img_small_url) . '" media="(max-width: 639px)">';
	}
}
add_action('wp_head', 'primo_print_preload_heros_imgs', 1);
