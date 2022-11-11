<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

/**
 * set jpg compression quality
 */
add_filter('jpeg_quality', function ($arg) {
	return 90;
});


/**
 * set max resolution in pixel for uploaded jpg & png files
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $file
 * @return void
 */
function canva_image_size_upload_limit($file)
{
	$is_image = strpos($file['type'], 'image') !== false;

	if ($is_image) {
		$image = getimagesize($file['tmp_name']);

		$maximum = array(
			// 'width' => '1920',
			// 'height' => '1920'
			'width' => '3000',
			'height' => '3000'
		);

		$image_height = $image[1];

		if ($image_width > $maximum['width'] || $image_height > $maximum['height']) {
			//add in the field 'error' of the $file array the message
			$file['error'] = sprintf(__('The image size exceeds the maximum limit. The maximum width and height limit is %s pixels.', 'canva-backend'), $maximum['width']);
			return $file;
		} else {
			return $file;
		}
	} else {
		return $file;
	}
}
add_filter('wp_handle_upload_prefilter', 'canva_image_size_upload_limit');



// Imposta le dimensioni dei tagli delle immagini caricate da backend
add_filter('big_image_size_threshold', '__return_false');

function canva_remove_wp_image_sizes()
{
	remove_image_size('1536x1536');
	remove_image_size('2048x2048');
	remove_image_size('1024x1024');
	remove_image_size('768x768');
}
add_action('init', 'canva_remove_wp_image_sizes');

function canva_remove_default_images($sizes)
{
	// unset( $sizes['small']); // 150px
	unset($sizes['medium'], $sizes['medium_large'], $sizes['large']); // 300px

	return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'canva_remove_default_images');


/*  ***********************

Wordpress ha di default due tagli che usiamo

thumbnail:
150 x 150px con hard crop centrale

medium:
300px dimensione massima, l'altra proporzionale

*********************** */

// add_image_size( "150", 150, 100, false );
// add_image_size( "150_square", 150, 150, true );
// add_image_size( "150-11", 150, 150, true );
// add_image_size( "325", 325 );

add_image_size('160-free', 160);
add_image_size('160-11', 160, 160, true);

add_image_size('320-free', 320);
add_image_size('320-11', 320, 320, true);
// add_image_size("320-32", 320, 214, true);
// add_image_size("320-43", 320, 234, true);
// add_image_size("320-45", 320, 400, true);

add_image_size('640-free', 640);
add_image_size('640-11', 640, 640, true);
add_image_size('640-169', 640, 360, true);
add_image_size('640-32', 640, 427, true);
add_image_size('640-43', 640, 480, true);
add_image_size('640-45', 640, 800, true);

add_image_size('960-free', 960);
add_image_size('960-11', 960, 960, true);
add_image_size('960-32', 960, 640, true);

add_image_size('1280-free', 1280);
add_image_size('1600-free', 1600);
add_image_size('1920-free', 1920);

/**
 * custom_sizes($sizes)
 * set Canva image sizes in wordpress media meta.
 *
 * @param [type] $sizes
 */
function canva_custom_image_sizes($sizes)
{
	return array_merge($sizes, [
		'160-free' 		=> __('160-free'),
		'160-11' 		=> __('160-11'),
		'320-free' 		=> __('320-free'),
		'320-11' 		=> __('320-11'),
		'640-free' 		=> __('640-free'),
		'640-11' 		=> __('640-11'),
		'640-169' 		=> __('640-169'),
		'640-32' 		=> __('640-32'),
		'640-43' 		=> __('640-43'),
		'640-45' 		=> __('640-45'),
		'960-free' 		=> __('960-free'),
		'960-32' 		=> __('960-32'),
		'1280-free' 	=> __('1280-free'),
		'1600-free' 	=> __('1600-free'),
		'1920-free' 	=> __('1920-free'),
	]);
}
add_filter('image_size_names_choose', 'canva_custom_image_sizes');


/**
 * Yoast SEO setup OG:Image Size
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_yoast_override_images_size()
{
	return ['1280-free', '1600-free', '1920-free'];
}
add_filter('wpseo_image_sizes', 'canva_yoast_override_images_size');


/**
 * Yoast SEO setup OG:Image Size
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_override_og_images_size()
{
	return '1280-free';
}
add_filter('wpseo_opengraph_image_size', 'canva_override_og_images_size');


/**
 * used to manipulate image tag to make it working with b-lazy in frontend and backend
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $content
 */
function canva_make_img_lazy($content)
{
	// Don't lazyload for feeds, previews, mobile
	if (is_feed()) {
		return $content;
	}

	// Don't lazy-load if the content has already been run through previously
	if (false !== strpos($content, 'data-src')) {
		return $content;
	}

	// $loading_img = canva_get_loading_img_url($size);

	// In case you want to change the placeholder image
	$placeholder_image = apply_filters('lazyload_images_placeholder_image', 'data:image/gif;base64,R0lGODlhAQABAIAA AAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');

	// blazy add class
	$blazy_class = 'b-lazy';

	// This is a pretty simple regex, but it works
	return preg_replace('#<img([^>]+?)src=[\'"]?([^\'"\s>]+)[\'"]?([^>]*)>#', sprintf('<img${1}src="%s" data-src="${2}"${3}><noscript><img${1}src="${2}"${3}></noscript>', $placeholder_image), $content);
}

// run this later, so other content filters have run, including image_add_wh on WP.com
// add_filter( 'the_content', 'canva_make_img_lazy', PHP_INT_MAX );
// add_filter( 'acf_the_content', 'canva_make_img_lazy', PHP_INT_MAX );

//disattiviamo il lazyload di default di wordpress
// add_filter('wp_lazy_loading_enabled', '__return_false');
//disattiva caption shortcode
// add_filter('disable_captions', '__return_true');

/*
 *
 * canva_custom_image_html()
 * sostituisce il template thml del aggiungi media nel editor classico di wordpress
 *
 * https://rudrastyh.com/wordpress/custom-html-for-post-images.html
 *
 * @return html
 *
 */
/**
 * sostituisce il template thml del aggiungi media nel editor classico di wordpress
 *
 * https://rudrastyh.com/wordpress/custom-html-for-post-images.html
 *
 * @param [type] $html
 * @param [type] $id
 * @param [type] $caption
 * @param [type] $title
 * @param [type] $align
 * @param [type] $url
 * @param [type] $size
 * @param [type] $alt
 * @return void
 */
function canva_custom_image_html($html, $id, $caption, $title, $align, $url, $size, $alt)
{
	//First of all lets operate with image sizes
	list($img_src, $width, $height) = image_downsize($id, $size);
	//$hwstring = image_hwstring($width, $height);

	$class_figure = 'wp-figure-' . $id;
	$class_img = 'wp-image-' . $id . ' size-' . $size . ' b-lazy';

	// return canva_get_attachment_thumbnail($post_id = $id, $type = 'img', $size, $class_figure, $class_img, $bg_content = '', $caption = 'on', $blazy = 'off', $data_attr = '');
	return canva_get_img(
		[
			'img_id' => $id, //'post_id','attachment_id',
			'img_type' => 'img', //'img', 'bg', 'url'
			'thumb_size' => $size, //'640-free',
			'wrapper_class' => $class_figure,
			'img_class' => $class_img,
			'bg_content' => '',
			'caption' => 'on',
			'blazy' => 'off',
			'srcset' => 'off',
			'data_attr' => '',
			'width' => '',
			'height' => '',
		]
	);
}
add_filter('image_send_to_editor', 'canva_custom_image_html', 10, 9);

/**
 * Set defaults in add meadia
 *
 * @return void
 */
function canva_default_attachment_display_settings()
{
	update_option('image_default_align', 'none');
	update_option('image_default_link_type', 'none');
	update_option('image_default_size', '640-free');
}
add_action('after_setup_theme', 'canva_default_attachment_display_settings');

/*
 *
 * fav_icon()
 * stampa le favicon su header.php
 *
 */
/**
 * print favicon
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @return void
 */
function canva_favicon()
{
	if (get_field('favicon', 'options')) {
		$favicon_url = canva_get_img([
			'img_id' => get_field('favicon', 'options'),
			'img_type' => 'url', // img, bg, url
			'thumb_size' => 'full',
			'wrapper_class' => '',
			'img_class' => '',
			'bg_content' => '',
			'caption' => 'off',
			'blazy' => 'off',
			'srcset' => 'off',
			'data_attr' => '',
			'width' => '',
			'height' => '',
		]);

		echo apply_filters('canva_favicon', '<link rel="icon" href="' . esc_url($favicon_url) . '">');
	}
}
// add_action('wp_head', 'canva_favicon');


/**
 * Used to switch logo on hover when darkmode is activated
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 *
 */
function canva_logo_dark_hover_trick_js()
{
	$logo_light_mode = get_field('logo_light_mode', 'options');
	$logo_dark_mode = get_field('logo_dark_mode', 'options');

	$logo_light_mode_large = canva_get_img([
		'img_id' => $logo_light_mode['large'],
		'img_type' => 'url', // img, bg, url
		'thumb_size' => 'full',
		'wrapper_class' => '',
		'img_class' => '',
		'bg_content' => '',
		'caption' => 'off',
		'blazy' => 'off',
		'srcset' => 'off',
		'data_attr' => '',
		'width' => '',
		'height' => '',
	]);

	$logo_dark_mode_large = canva_get_img([
		'img_id' => $logo_dark_mode['large'],
		'img_type' => 'url', // img, bg, url
		'thumb_size' => 'full',
		'wrapper_class' => '',
		'img_class' => '',
		'bg_content' => '',
		'caption' => 'off',
		'blazy' => 'off',
		'srcset' => 'off',
		'data_attr' => '',
		'width' => '',
		'height' => '',
	]);

	$logo_light_mode_small = canva_get_img([
		'img_id' => $logo_light_mode['small'],
		'img_type' => 'url', // img, bg, url
		'thumb_size' => 'full',
		'wrapper_class' => '',
		'img_class' => '',
		'bg_content' => '',
		'caption' => 'off',
		'blazy' => 'off',
		'srcset' => 'off',
		'data_attr' => '',
		'width' => '',
		'height' => '',
	]);

	$logo_dark_mode_small = canva_get_img([
		'img_id' => $logo_dark_mode['small'],
		'img_type' => 'url', // img, bg, url
		'thumb_size' => 'full',
		'wrapper_class' => '',
		'img_class' => '',
		'bg_content' => '',
		'caption' => 'off',
		'blazy' => 'off',
		'srcset' => 'off',
		'data_attr' => '',
		'width' => '',
		'height' => '',
	]);
?>
	<script>
		(function($) {

			var viewPortWidth = $(window).width();

			if (mobileCheck() === true && viewPortWidth < 640) {

				$('.site-navigation').on('mouseenter', function() {
					$('.site-navigation').find('.logo').attr('src', '<?php echo esc_url($logo_light_mode_small); ?>');
				});

				$('.site-navigation').on('mouseleave', function() {
					$('.site-navigation').find('.logo').attr('src', '<?php echo esc_url($logo_dark_mode_small); ?>');
				});

			} else {

				$('.site-navigation').on('mouseenter', function() {
					$('.site-navigation').find('.logo').attr('src', '<?php echo esc_url($logo_light_mode_large); ?>');
				});

				$('.site-navigation').on('mouseleave', function() {
					$('.site-navigation').find('.logo').attr('src', '<?php echo esc_url($logo_dark_mode_large); ?>');
				});

			}

		})(jQuery);
	</script>
<?php
}
// hooked in fn-menu.php



/**
 * Print the logo svg inline if its a svg or as img assets if it is a jpg or a png file
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $size
 * @param string $motto
 * @param string $class
 * @return void
 * @since 1.0.0
 */
function canva_get_logo($position = 'header')
{
	if ($position === 'header') {
		$blazy = 'off';
	} else {
		$blazy = 'on';
	}

	$logo_light_mode = get_field('logo_light_mode', 'options');
	$logo_small_light_mode = get_field('logo_small_light_mode', 'options');

	if (false !== strpos($logo_light_mode['css_classes'], '|')) {
		$css_classes = explode('|', $logo_light_mode['css_classes']);
	} else {
		$css_classes = $logo_light_mode['css_classes'];
	}

	if (false !== strpos($logo_small_light_mode['css_classes'], '|')) {
		$css_classes_small = explode('|', $logo_small_light_mode['css_classes']);
	} else {
		$css_classes_small = $logo_small_light_mode['css_classes'];
	}

	$parent_classes = '';
	$child_classes = '';

	if (is_array($css_classes)) {
		$parent_classes = $css_classes[0];
		$child_classes = $css_classes[1];
	}

	$parent_classes_small = '';
	$child_classes_small = '';

	if (is_array($css_classes_small)) {
		$parent_classes_small = $css_classes_small[0];
		$child_classes_small = $css_classes_small[1];
	}

	$html = '';
	$html_small = '';

	if ($logo_light_mode['svg_inline']) {

		$svg = canva_get_svg_icon_from_url(get_attached_file($logo_light_mode['img']), $child_classes);

		if ($parent_classes) {
			$html = '<div class="' . $parent_classes . '">' . $svg . '</div>';
		} else {
			$html = '<div class="' . $css_classes . '">' . $svg . '</div>';
		}
	} else {

		if ($parent_classes || $parent_classes_small) {

			if (!$logo_small_light_mode['img']) {
				$html = canva_get_img([
					'img_id' => $logo_light_mode['img'],
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '320-free',
					'wrapper_class' => $parent_classes,
					'img_class' => 'logo ' . $child_classes,
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => $blazy,
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);
			} else {
				$html .= '<div class="_logo-wrap relative flex items-center justify-center ' . $css_classes . '">';
				$html .= canva_get_img([
					'img_id' => $logo_light_mode['img'],
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '320-free',
					'wrapper_class' => '_logo-large absolute ' . $parent_classes,
					'img_class' => 'logo ' . $child_classes,
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => $blazy,
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);
				$html .= canva_get_img([
					'img_id' => $logo_small_light_mode['img'],
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '320-free',
					'wrapper_class' => '_logo-small absolute hidden' . $parent_classes_small,
					'img_class' => 'logo ' . $child_classes_small,
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => $blazy,
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);
				$html .= '</div>';
			}
		} else {

			if (!$logo_small_light_mode['img']) {

				$html = canva_get_img([
					'img_id' => $logo_light_mode['img'],
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '320-free',
					'wrapper_class' => $css_classes,
					'img_class' => 'logo',
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => $blazy,
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);
			} else {

				$html .= '<div class="_logo-wrap relative flex items-center justify-center ' . $css_classes . '">';
				$html .= canva_get_img([
					'img_id' => $logo_light_mode['img'],
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '320-free',
					'wrapper_class' => '_logo-large absolute ' . $css_classes,
					'img_class' => 'logo',
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => $blazy,
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);

				$html .= canva_get_img([
					'img_id' => $logo_small_light_mode['img'],
					'img_type' => 'img', // img, bg, url
					'thumb_size' => '320-free',
					'wrapper_class' => '_logo-small absolute hidden ' . $css_classes_small,
					'img_class' => 'logo',
					'bg_content' => '',
					'caption' => 'off',
					'blazy' => $blazy,
					'srcset' => 'off',
					'data_attr' => '',
					'width' => '',
					'height' => '',
				]);
				$html .= '</div>';
			}
		}
	}

	return $html;
}



/**
 *
 * The canva_get_logo shortcode function
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $atts
 * @return void
 */
function canva_get_logo_shortcode($atts)
{
	extract(shortcode_atts([
		'position' => 'header',
	], $args));

	return canva_get_logo($position);
}
add_shortcode('logo', 'canva_get_logo_shortcode');


/**
 * function to print url for static icons and images inside the theme
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $path
 * @return void
 */
function canva_get_theme_img_url($path = 'fontawesome/brands/facebook.svg')
{
	if (!$path) {
		return;
	}

	$file_url = '';
	if (file_exists(CANVA_PROJECT_IMG . $path)) {
		$file_url = CANVA_PROJECT_IMG_URI . $path;
	} elseif (file_exists(CANVA_CORE_IMG . $path)) {
		$file_url = CANVA_CORE_IMG_URI . $path;
	}

	if (!$file_url) {
		return;
	}

	return $file_url;
}



/**
 * function to print static svg icons as inline html svg
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $name
 * @param string $css_classes
 * @return void
 */
function canva_get_svg_icon($name = 'fontawesome/brands/facebook', $css_classes = 'w-16')
{
	if (!$name) {
		return;
	}

	$svg_file = '';
	if (file_exists(CANVA_PROJECT_IMG . $name . '.svg')) {
		$svg_file = file_get_contents(CANVA_PROJECT_IMG . $name . '.svg');
	} elseif (file_exists(CANVA_CORE_IMG . $name . '.svg')) {
		$svg_file = file_get_contents(CANVA_CORE_IMG . $name . '.svg');
	}

	if (!$svg_file) {
		return;
	}

	$position = strpos($svg_file, '<svg');
	$svg = substr($svg_file, $position);

	$dom = new \DOMDocument();

	libxml_use_internal_errors(true);

	$dom->loadHTML($svg);

	libxml_clear_errors();

	//# remove <!DOCTYPE
	$dom->removeChild($dom->doctype);

	// remove <html><body></body></html>
	$dom->replaceChild($dom->firstChild->firstChild->firstChild, $dom->firstChild);

	foreach ($dom->getElementsByTagName('svg') as $element) {
		$element->setAttribute('class', '_icon ' . esc_attr(wp_basename($name) . ' ' . $css_classes));
	}

	$svg = $dom->saveHTML();

	return $svg;
}

/**
 * The canva_get_icon shortcode function
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param [type] $atts
 * @return void
 */
function canva_icon_shortcode($atts)
{
	extract(shortcode_atts([
		'name' => '',
		'css_classes' => '',
	], $atts));

	return canva_get_svg_icon($name, $css_classes);
}
add_shortcode('icon', 'canva_icon_shortcode');


/**
 * function to print static svg icons as inline html svg from url
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $name
 * @param string $css_classes
 * @return void
 */
function canva_get_svg_icon_from_url($url = '', $css_classes = 'w-16')
{
	if (!$url) {
		return;
	}

	$svg_file = '';
	$svg_file = file_get_contents(esc_url($url));

	if (!$svg_file) {
		return;
	}

	$position = strpos($svg_file, '<svg');
	$svg = substr($svg_file, $position);

	$dom = new \DOMDocument();

	libxml_use_internal_errors(true);

	$dom->loadHTML($svg);

	libxml_clear_errors();

	//# remove <!DOCTYPE
	$dom->removeChild($dom->doctype);

	// remove <html><body></body></html>
	$dom->replaceChild($dom->firstChild->firstChild->firstChild, $dom->firstChild);

	foreach ($dom->getElementsByTagName('svg') as $element) {
		$element->setAttribute('class', '_icon ' . esc_attr(wp_basename($url, '.svg') . ' ' . $css_classes));
	}

	$svg = $dom->saveHTML();

	return $svg;
}



/**
 * print loading immage used for blazy stuff
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $size
 * @return void
 */
function canva_get_loading_img_url($size = '640-free')
{

	if ($size) {
		if (file_exists(CANVA_PROJECT_IMG . 'loaders/loader-' . $size . '.svg')) {
			$img = CANVA_PROJECT_IMG_URI . 'loaders/loader-' . $size . '.svg';
		} elseif (file_exists(CANVA_CORE_IMG . 'loaders/loader-' . $size . '.svg')) {
			$img = CANVA_CORE_IMG_URI . 'loaders/loader-' . $size . '.svg';;
		} else {
			$img = 'data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==';
		}
	}

	return $img;
}

/**
 * canva_get_img()
 * stampa immagine predefinita di un attachment.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $post_id
 * @param string $type
 * @param string $size
 * @param string $wrapper_figure
 * @param string $class_img
 * @param string $bg_content
 * @param string $caption
 * @param string $blazy
 * @param mixed  $data_attr
 * @param mixed  $args
 * @since 1.0.0
 */
function canva_get_img($args = [])
{
	extract(shortcode_atts([
		'img_id' => '',
		'img_type' => 'img', // img, bg, url
		'thumb_size' => '640-free',
		'wrapper_class' => '',
		'wrapper_style' => '',
		'img_class' => '',
		'img_style' => '',
		'bg_content' => '',
		'caption' => 'off',
		'blazy' => 'on',
		'srcset' => 'on',
		'data_attr' => '',
		'width' => '',
		'height' => '',
	], $args));


	if ($img_id && get_post_type($img_id) !== 'attachment') {
		$img_id = get_post_thumbnail_id($img_id);
	}

	$image = wp_get_attachment_image_src($img_id, $thumb_size);
	$image_full = wp_get_attachment_image_src($img_id, 'full');

	//sostituisce i tagli di default di wordpress
	if ('thumbnail' === $thumb_size) {
		$thumb_size = '160-free';
	} elseif ('large' === $thumb_size || 'medium' === $thumb_size) {
		$thumb_size = '640-free';
	}

	$loading_img = canva_get_loading_img_url($thumb_size);
	$image_type = @get_file_extension($image[0]);

	if ('svg' === $image_type && !$width && !$height) {
		$width = '100%';
		$height = '100%';
	} elseif (!$width && !$height) {
		$width = @$image[1];
		$height = @$image[2];
		$width_full = @$image_full[1];
		$height_full = @$image_full[2];
	}

	switch (true) {
		case '160-free' === $thumb_size:
			$image_x2 = @wp_get_attachment_image_src($img_id, '320-free');
			$image_x3 = @wp_get_attachment_image_src($img_id, '640-free');
			$data_src = @esc_url($image[0]) . '|' . esc_url($image_x2[0]) . '|' . esc_url($image_x3[0]);
			$srcset = @esc_url($image[0]) . ' 1x, ' . esc_url($image_x2[0]) . ' 2x, ' . esc_url($image_x3[0]) . ' 3x';
			break;
		case '160-11' === $thumb_size:
			$image_x2 = @wp_get_attachment_image_src($img_id, '320-11');
			$image_x3 = @wp_get_attachment_image_src($img_id, '640-11');
			$data_src = @esc_url($image[0]) . '|' . esc_url($image_x2[0]) . '|' . esc_url($image_x3[0]);
			$srcset = @esc_url($image[0]) . ' 1x, ' . esc_url($image_x2[0]) . ' 2x, ' . esc_url($image_x3[0]) . ' 3x';
			break;
		case '320-free' === $thumb_size:
			$image_x2 = @wp_get_attachment_image_src($img_id, '640-free');
			$image_x3 = @wp_get_attachment_image_src($img_id, '960-free');
			$data_src = @esc_url($image[0]) . '|' . esc_url($image_x2[0]) . '|' . esc_url($image_x3[0]);
			$srcset = @esc_url($image[0]) . ' 1x, ' . esc_url($image_x2[0]) . ' 2x, ' . esc_url($image_x3[0]) . ' 3x';
			break;
		case '320-11' === $thumb_size:
			$image_x2 = @wp_get_attachment_image_src($img_id, '640-11');
			$data_src = @esc_url($image[0]) . '|' . esc_url($image_x2[0]);
			$srcset = @esc_url($image[0]) . ' 1x, ' . esc_url($image_x2[0]) . ' 2x';
			break;
		case '640-free' === $thumb_size:
			$image_x2 = @wp_get_attachment_image_src($img_id, '1280-free');
			$image_x3 = @wp_get_attachment_image_src($img_id, 'full');
			$data_src = @esc_url($image[0]) . '|' . esc_url($image_x2[0]) . '|' . esc_url($image_x3[0]);
			$srcset_src = @esc_url($image[0]) . ' 1x, ' . esc_url($image_x2[0]) . ' 2x, ' . esc_url($image_x3[0]) . ' 3x';
			break;
		case '960-free' === $thumb_size:
			$image_x2 = @wp_get_attachment_image_src($img_id, '1280-free');
			$image_x3 = @wp_get_attachment_image_src($img_id, 'full');
			$data_src = @esc_url($image[0]) . '|' . esc_url($image_x2[0]) . '|' . esc_url($image_x3[0]);
			$srcset_src = @esc_url($image[0]) . ' 1x, ' . esc_url($image_x2[0]) . ' 2x, ' . esc_url($image_x3[0]) . ' 3x';
			break;
		default:
			$data_src = @esc_url($image[0]);
			$srcset = @esc_url($image_full[0]);
	}

	$image_meta = get_post($img_id);
	$alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
	if (!$alt) {
		$alt = $image_meta->post_title;
	}

	if ('on' === $caption) {
		$caption_content = '<figcaption class="image-caption block">' . $image_meta->post_excerpt . '</figcaption>';
	} elseif ('off' === $caption) {
		$caption_content = '<figcaption class="image-caption block"></figcaption>';
	} else {
		$caption_content = '<figcaption class="image-caption block">' . $caption . '</figcaption>';
	}

	if ('img' === $img_type) {

		if ('on' === $blazy) {

			$html = '<figure class="' . esc_attr($wrapper_class) . '" style="' . esc_attr($wrapper_style) . '" data-url="' . $image_full[0] . '" data-size="' . $width_full . 'x' . $height_full . '" ' . $data_attr . '  width="' . $width . '" height="' . $height . '"><img class="b-lazy ' . esc_attr($img_class) . '" src="' . esc_url($loading_img) . '" data-src="' . $data_src . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '" />' . $caption_content . '</figure>';
		} else {

			if ('on' === $srcset) {
				$html = '<figure class="' . esc_attr($wrapper_class) . '" style="' . esc_attr($wrapper_style) . '" data-url="' . $image_full[0] . '" data-size="' . $width_full . 'x' . $height_full . '" ' . $data_attr . '><img class="' . esc_attr($img_class) . '" style="' . esc_attr($img_style) . '" src="' . $image[0] . '" srcset="' . $srcset_src . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '"/>' . $caption_content . '</figure>';
			} else {
				$html = '<figure class="' . esc_attr($wrapper_class) . '" style="' . esc_attr($wrapper_style) . '" data-url="' . $image_full[0] . '" data-size="' . $width_full . 'x' . $height_full . '" ' . $data_attr . '><img class="' . esc_attr($img_class) . '" style="' . esc_attr($img_style) . '" src="' . $image[0] . '" alt="' . $alt . '" width="' . $width . '" height="' . $height . '"/>' . $caption_content . '</figure>';
			}
		}
	} elseif ('background' === $img_type || 'bg' === $img_type) {

		if ('on' === $blazy) {
			if ('1280-free' === $thumb_size || '1600-free' === $thumb_size || '1920-free' === $thumb_size) {
				$image_small = wp_get_attachment_image_src($img_id, '960-free');
				$html = '<div class="bg-img b-lazy bg-no-repeat ' . esc_attr($wrapper_class) . '" style="' . esc_attr($wrapper_style) . '" data-src="' . esc_url($image[0]) . '" data-src-small="' . esc_url($image_small[0]) . '" style="' . $img_class . '" ' . $data_attr . '>' . $bg_content . '</div>';
			} else {
				$html = '<div class="bg-img b-lazy bg-no-repeat ' . esc_attr($wrapper_class) . '" style="' . esc_attr($wrapper_style) . '" data-src="' . esc_url($image[0]) . '" style="' . $img_class . '" ' . $data_attr . '>' . $bg_content . '</div>';
			}
		} else {
			$html = '<div class="bg-img bg-no-repeat ' . esc_attr($wrapper_class) . '" style="background-image:url(' . esc_url($image[0]) . '); ' . esc_attr($wrapper_style) . '"' . $data_attr . '>' . $bg_content . '</div>';
		}
	} else {
		$html = @esc_url($image[0]);
	}

	return $html;
}


/**
 * Default No Image Fallback from Canva OPT with a default fallback svg icon
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param string $post_id
 * @param string $thumb_size
 * @param string $css_classes
 * @return void
 */
function canva_get_no_image($thumb_size = '640-free', $css_classes = '')
{

	$html = '';
	if (get_field('no_image_fallback', 'options')) {
		$html .=  canva_get_img([
			'img_id' => get_field('no_image_fallback', 'options'),
			'thumb_size' => $thumb_size,
			'wrapper_class' => esc_attr($css_classes),
		]);
	} else {
		$html .= canva_get_svg_icon('fontawesome/regular/image', 'icon' . esc_attr($css_classes));
	}

	return $html;
}


/**
 * Funzioni che manipolano i blocchi di gutenberg.
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param mixed $block_content
 * @param mixed $block
 */
function canva_render_core_image_block($block_content, $block)
{

	if (is_admin() && acf_is_block_editor()) {
		return $block_content;
	} else {

		// modifica output html del blcco core/image
		if ('core/image' === $block['blockName']) {

			$block_id = '';
			if ($block['id']) {
				$block_id = $block['id'];
			}

			if (!empty($block['anchor'])) {
				$block_id = $block['anchor'];
			}

			extract($block['attrs']);

			if ('center' == $align) {
				$className = 'text-center ' . $className;
			} elseif ('left' == $align) {
				$className = 'text-left ' . $className;
			} elseif ('right' == $align) {
				$className = 'text-right ' . $className;
			}

			if (false !== strpos($className, '|')) {
				$css_classes = explode('|', $className);
			} else {
				$css_classes = $className;
			}

			$parent_classes = '';
			$child_classes = '';

			if (is_array($css_classes)) {
				$parent_classes = $css_classes[0];
				$child_classes = $css_classes[1];
			} else {
				$parent_classes = $className;
			}

			if ('thumbnail' == $sizeSlug) {
				$sizeSlug = '160-free';
			}

			$DOM = new DOMDocument();
			$DOM->loadHTML($block['innerHTML']);
			$tag = $DOM->getElementsByTagName('img');

			$img_width = '';
			$img_height = '';
			foreach ($tag as $element) {
				$img_width = $element->getAttribute('width');
				$img_height = $element->getAttribute('height');
			}

			$caption = wp_strip_all_tags($block['innerHTML']);
			$links = extract_links_from_html($block['innerHTML']);

			$figure_url = '';
			$caption_url = '';
			if (!empty($links)) {
				if (count($links) > 1) {
					$figure_url = $links[0]['href'];
					$caption_url = $links[1]['href'];
				} else {
					$figure_url = $links[0]['href'];
				}
			}

			if (!$caption) {
				$caption = 'off';
			} elseif ($caption && null != $caption_url && '' != $caption_url) {
				if (!is_url_local($caption_url)) {
					$target_rel = 'target="_blank" rel="nofollow noopener"';
				}
				$caption = '<a href="' . $caption_url . '" ' . $target_rel . '>' . $caption . '</a>';
			} else {
				$caption = $caption;
			}

			// rompe salvataggio common block
			// ob_start();
			$img_output = canva_get_img(
				[
					'img_id' => $id, //'post_id','attachment_id',
					'img_type' => 'img', //'img', 'bg', 'url'
					'thumb_size' => $sizeSlug, //'640-free',
					'wrapper_class' => $parent_classes,
					'img_class' => 'photoswipe-item pointer gallery-item gallery-item-1 ' . $child_classes,
					'bg_content' => '',
					'caption' => $caption,
					'blazy' => 'on',
					'data_attr' => '',
					'width' => $img_width,
					'height' => $img_height,
				]
			);
			if ('' != $figure_url) {
				return '<a href="' . esc_url($figure_url) . '" target="_blank" rel="nofollow noopener">' . $img_output . '</a>';
			} else {
				return $img_output;
			}
			// return ob_get_clean();
		}

		if ('core/gallery' === $block['blockName']) {

			$innerBlocks = $block['innerBlocks'];
			$ids = [];
			foreach ($innerBlocks as $innerBlock) {
				$ids[] = $innerBlock['attrs']['id'];
			}

			if (!empty($block['anchor'])) {
				$block_id = $block['anchor'];
			}

			extract($block['attrs']);


			if (count($ids) <= 5) {
				$columns = count($ids);
			} else {
				$columns = 4;
			}

			if ($align) {
				$className = $align . ' ' . $className;
			}

			// Get Gallery Items
			@$DOM = new DOMDocument();
			@$DOM->loadHTML($block['innerHTML'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$figures = @$DOM->getElementsByTagName('figure');

			$img_captions = [];
			foreach ($figures as $key => $figure) {
				if (0 != $key) {
					if ('' != $figure->textContent) {
						$img_captions[] = $figure->textContent;
					} else {
						$img_captions[] = 'off';
					}
				}
			}

			// Get Gallery Figcaption
			@$FC = new DOMDocument();
			@$FC->loadHTML($block['innerHTML'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
			$remove_items = @$FC->getElementsByTagName('ul');

			foreach ($remove_items as $remove_item) {
				$remove_item->parentNode->removeChild($remove_item);
			}

			$gallery_caption = wp_strip_all_tags(@$FC->saveHTML());

			ob_start();

			canva_get_template($template_name = 'block-gallery-flex', ['img_ids' => $ids, 'captions' => $captions, 'thumb_size' => $sizeSlug, 'size' => $sizeSlug, 'limit' => $limit, 'columns' => $columns, 'galleryID' => $block_id, 'css_class' => $className]);

			return ob_get_clean();
		}

		return $block_content;
	}
}
add_filter('render_block', 'canva_render_core_image_block', 10, 2);



/**
 * Save Heros Attachment IDS as custom fields fo preload function
 *
 * @param [type] $post_id
 * @param [type] $post
 * @param [type] $update
 * @return void
 */
function canva_set_meta_preload_url($post_id, $post, $update)
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
		if ($blocks[0]['blockName'] === 'acf/hero-image-link' || $blocks[0]['blockName'] === 'acf/hero-basic') {

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
add_action('save_post', 'canva_set_meta_preload_url', 99, 3);

/**
 * Print preload image for first hero block in wp_head
 *
 * @return void
 */
function canva_print_preload_heros_imgs()
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
				'wrapper_class' => '',
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
				'wrapper_class' => '',
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
add_action('wp_head', 'canva_print_preload_heros_imgs', 1);

/**
 * Automatically set the image Title, Alt-Text, Caption & Description upon upload
 *
 * @param [type] $post_id
 * @return void
 */
function canva_media_library_set_meta($post_id)
{

	if (wp_attachment_is_image($post_id)) {

		$image_title = get_post($post_id)->post_title;

		$image_title = preg_replace('%\s*[-_\s]+\s*%', ' ', $image_title);

		$image_title = ucwords(strtolower($image_title));

		$image_meta = array(
			'ID'            => $post_id,
			'post_title'    => $image_title,
			//'post_excerpt'  => $hap_image_title, // Set image Caption (Excerpt)
			//'post_content'  => $hap_image_title, // Set image Description (Content)
		);

		update_post_meta($post_id, '_wp_attachment_image_alt', $image_title);

		wp_update_post($image_meta);
	}
}
add_action('add_attachment', 'canva_media_library_set_meta');



/**
 * used to term extra toptitle
 *
 * * @param [Object] $term
 * @return void
 */
function canva_get_term_toptitle($term)
{
	// return get_field('term_logo', $taxonomy . '_' . $term_id);
	return get_field('toptitle', $term);
}

/**
 * used to term extra title
 *
 * * @param [Object] $term
 * @return void
 */
function canva_get_term_title($term)
{
	// return get_field('term_logo', $taxonomy . '_' . $term_id);
	return get_field('title', $term);
}

/**
 * used to term extra subtitle
 *
 * * @param [Object] $term
 * @return void
 */
function canva_get_term_subtitle($term)
{
	// return get_field('term_logo', $taxonomy . '_' . $term_id);
	return get_field('subtitle', $term);
}

/**
 * used to get logo attachment id foa a term
 * * @param [Object] $term
 * @return void
 */
function canva_get_term_logo_id($term)
{
	// return get_field('term_logo', $taxonomy . '_' . $term_id);
	return get_field('term_logo', $term);
}

/**
 * used to get featured attachment id foa a term
 *
 * @param [type] $taxonomy
 * @param [type] $term
 * @return void
 */
function canva_get_term_featured_img_id($term)
{
	// return get_field('term_featured_img', $taxonomy . '_' . $term_id);
	return get_field('term_featured_img', $term);
}

/**
 * used to get gallery image ids foa a term
 *
 * @param [type] $taxonomy
 * @param [type] $term
 * @return void
 */
function canva_get_term_gallery_img_ids($term)
{
	// return get_field('term_featured_img', $taxonomy . '_' . $term_id);
	return get_field('term_gallery', $term);
}

/**
 * used to get primary color for a term
 *
 * @param [type] $taxonomy
 * @param [type] $term
 * @return void
 */
function canva_get_term_color($term)
{
	// return get_field('term_color', $taxonomy . '_' . $term_id);
	return get_field('term_color', $term);
}

/**
 * used to get the secondary color for a term
 *
 * @param [type] $taxonomy
 * @param [type] $term
 * @return void
 */
function canva_get_term_color_secondary($term)
{
	// return get_field('term_color', $taxonomy . '_' . $term_id);
	return get_field('term_color_secondary', $term);
}


/**
 * Function used to create heros cards and photobuttons
 *
 * @param array $args
 * @return void
 */
function canva_the_layer($args = [])
{
	extract(shortcode_atts([
		'layer_type' => '_hero', // Classe semantica _hero, _card, _photobutton
		'layer_id' => '',
		'layer_class' => '', // Classi di aspetto

		'img_id' => '',
		'img_small_id' => '',
		'thumb_size' => '1920-free',
		'thumb_small_size' => '1920-free',
		'img_url' => '',
		'img_small_url' => '',
		'video_url' => '',

		'layer_visual_class' => '',

		'layer_bg' => 'on',
		'layer_bg_class' => '',

		'layer_picture' => 'on',
		'layer_picture_class' => '',
		'layer_picture_content' => '',

		'layer_filter' => 'on',
		'layer_filter_class' => '',

		'layer_graphics' => 'on',
		'layer_graphics_class' => '',
		'layer_graphics_content' => '',

		'layer_date' => 'on',
		'layer_date_class' => '',
		'layer_date_content' => '',

		'layer_status' => 'on',
		'layer_status_class' => '',
		'layer_status_output' => '',

		'layer_info' => 'on',
		'layer_info_class' => '',
		'layer_info_output' => '',

		'layer_content' => 'on',
		'layer_content_class' => '',
		'layer_content_output' => '',

		'template_name' => '',

	], $args));

	$bg_image = '';

	if ($img_id) {
		$bg_image = canva_get_img([
			'img_id' => intval($img_id),
			'img_type' => 'url', // img, bg, url
			'thumb_size' => esc_attr($thumb_size),
			'wrapper_class' => '',
			'img_class' => '',
			'img_style' => '',
			'bg_content' => '',
			'caption' => 'off',
			'blazy' => 'off',
			'srcset' => 'off',
			'data_attr' => '',
			'width' => '',
			'height' => '',
		]);

		$bg_img_small = '';
		if ($img_small_id) {
			$bg_img_small = canva_get_img([
				'img_id' => intval($img_small_id),
				'img_type' => 'url', // img, bg, url
				'thumb_size' => esc_attr($thumb_small_size),
				'wrapper_class' => '',
				'img_class' => '',
				'img_style' => '',
				'bg_content' => '',
				'caption' => 'off',
				'blazy' => 'off',
				'srcset' => 'off',
				'data_attr' => '',
				'width' => '',
				'height' => '',
			]);
		}

		$image = '';
		if ($bg_img_small) {
			$blazy_class = 'b-lazy';
			$image = 'data-src="' . $bg_image . '"';
			$image_small = '';
			$image_small = 'data-src-small="' . $bg_img_small . '"';
		} else {
			$image = 'style="background-image:url(' . $bg_image . ')";';
		}
	} else {

		$bg_image = $img_url;
		$bg_img_small = $img_small_url;

		$image = '';
		if ($bg_img_small) {
			$blazy_class = 'b-lazy';
			$image = 'data-src="' . $bg_image . '"';
			$image_small = '';
			$image_small = 'data-src-small="' . $bg_img_small . '"';
		} else {
			$image = 'style="background-image:url(' . $bg_image . ')";';
		}
	}

	if (!$layer_id) {
		$layer_id = wp_generate_password(12, false, false);
	}
?>

	<?php if (!$template_name) : ?>

		<div id="<?php echo esc_attr($layer_id); ?>" class="<?php echo esc_attr($layer_type); ?> _layer-wrap <?php echo esc_attr($layer_class); ?>">

			<div class="_layer-visual <?php echo esc_attr($layer_visual_class); ?>">

				<?php if ('on' === $layer_bg) { ?>
					<div class="_layer-bg <?php echo esc_attr($blazy_class . ' ' . $layer_bg_class); ?>" <?php echo $image . ' ' . $image_small; ?>></div>
				<?php } ?>

				<?php if ('on' === $layer_picture) { ?>
					<div class="_layer-picture <?php echo esc_attr($layer_picture_class); ?>">
						<!-- Content child mixed img video -->
						<video class="object-cover" preload="auto" loop="loop" autoplay="" muted="" playsinline="">
							<source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
						</video>
					</div>
				<?php } ?>

				<?php if ('on' === $layer_filter) { ?>
					<div class="_layer-filter <?php echo esc_attr($layer_filter_class); ?>">
						<!-- Content child non previsto -->
					</div>
				<?php } ?>

				<?php if ('on' === $layer_graphics) { ?>
					<div class="_layer-graphics <?php echo esc_attr($layer_graphics_class); ?>">
						<!-- Content child mixed img svg-->
						<?php echo $layer_graphics_output; ?>
					</div>
				<?php } ?>

				<?php if ('on' === $layer_date) { ?>
					<div class="_layer-date <?php echo esc_attr($layer_date_class); ?>">
						<!-- Content child mixed html php etc-->
						<?php echo $layer_date_output; ?>
					</div>
				<?php } ?>

				<?php if ('on' === $layer_status) { ?>
					<div class="_layer-status <?php echo esc_attr($layer_status_class); ?>">
						<!-- Content child mixed html php etc-->
						<?php echo $layer_status_output; ?>
					</div>
				<?php } ?>

				<?php if ('on' === $layer_info) { ?>
					<div class="_layer-info <?php echo esc_attr($layer_info_class); ?>">
						<!-- Content child mixed html php etc-->
						<?php echo $layer_info_output; ?>
					</div>
				<?php } ?>

			</div>

			<?php if ('on' === $layer_content) { ?>
				<div class="_layer-content <?php echo esc_attr($layer_content_class); ?>">
					<!-- Content child mixed html php etc-->
					<?php echo $layer_content_output; ?>
				</div>
			<?php } ?>

		</div>

	<?php else : ?>

		<?php echo canva_get_template($template_name, $args); ?>

	<?php endif; ?>

<?php
}
