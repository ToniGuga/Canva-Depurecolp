<?php

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

function canva_wp_login_form_shortcode()
{
	$args = [
		'echo' => true,
		'redirect' => get_permalink(get_the_ID()),
		'remember' => true,
		'value_remember' => true,
	];

	return wp_login_form($args);
}
add_shortcode('login_form', 'canva_wp_login_form_shortcode');



function canva_home_url($atts = '')
{
	return home_url();
}
add_shortcode('home_url', 'canva_home_url');



function canva_site_name($name = '')
{
	return bloginfo('name');
}
add_shortcode('site_name', 'canva_site_name');



function canva_post_permalink($atts)
{
	//Check that $id exists.
	$id = intval($atts['id']);
	if ($id <= 0) {
		return;
	}

	// Check that $id has a URL.
	$post_url = get_the_permalink($id);

	if ('' != $post_url) {
		return $post_url;
	}
}
add_shortcode('post_url', 'canva_post_permalink');



function canva_page_permalink($atts)
{
	//Check that $id exists.
	$id = intval($atts['id']);
	if ($id <= 0) {
		return;
	}

	// Check that $id has a URL.
	$page_url = get_page_link($id);

	if ('' != $page_url) {
		return $page_url;
	}
}
add_shortcode('page_url', 'canva_page_permalink');



function canva_term_permalink($atts)
{
	//Check that $id exists.
	$id = intval($atts['id']);
	if ($id <= 0) {
		return;
	}

	// Check that $id has a URL.
	$term_url = get_term_link($id);

	if ('' != $term_url) {
		return $term_url;
	}
}
add_shortcode('term_url', 'canva_term_permalink');

/**
 * Shordcodes dates
 */
function canva_get_year()
{
	return wp_date('Y');
}
add_shortcode('year', 'canva_get_year');

function canva_get_month()
{
	return wp_date('M');
}
add_shortcode('month', 'canva_get_month');

function canva_get_month_number()
{
	return wp_date('m');
}
add_shortcode('month_number', 'canva_get_month_number');

function canva_get_day()
{
	return wp_date('d');
}
add_shortcode('day', 'canva_get_day');

/**
 * Shordcodes for options Contacts Theme Page.
 */
function canva_get_company_name()
{
	return get_field('company_name', 'options');
}
add_shortcode('company_name', 'canva_get_company_name');

function canva_get_company_legal_representative()
{
	return get_field('legal_representative', 'options');
}
add_shortcode('company_legal_representative', 'canva_get_company_legal_representative');

function canva_get_company_address()
{
	return get_field('address', 'options');
}
add_shortcode('company_address', 'canva_get_company_address');

function canva_get_company_zippostal_code()
{
	return get_field('zippostal_code', 'options');
}
add_shortcode('company_zippostal_code', 'canva_get_company_zippostal_code');

function canva_get_company_city()
{
	return get_field('city', 'options');
}
add_shortcode('company_city', 'canva_get_company_city');

function canva_get_company_region()
{
	return get_field('region', 'options');
}
add_shortcode('company_region', 'canva_get_company_region');

function canva_get_company_country()
{
	return get_field('country', 'options');
}
add_shortcode('company_country', 'canva_get_company_country');

function canva_get_company_email()
{
	return get_field('email', 'options');
}
add_shortcode('company_email', 'canva_get_company_email');

function canva_get_company_pec_email()
{
	return get_field('pec_email', 'options');
}
add_shortcode('company_pec_email', 'canva_get_company_pec_email');

function canva_get_company_phone()
{
	return get_field('telephone', 'options');
}
add_shortcode('company_phone', 'canva_get_company_phone');

function canva_get_company_mobile_phone()
{
	return get_field('mobile_phone', 'options');
}
add_shortcode('company_mobile_phone', 'canva_get_company_mobile_phone');

function canva_get_company_vat()
{
	return get_field('vat_number', 'options');
}
add_shortcode('company_vat_number', 'canva_get_company_vat');

function canva_get_company_cf()
{
	return get_field('cf_number', 'options');
}
add_shortcode('company_cf_number', 'canva_get_company_cf');

function canva_get_company_share_capital()
{
	return get_field('share_capital', 'options');
}
add_shortcode('company_share_capital', 'canva_get_company_share_capital');

function canva_get_company_rea_number()
{
	return get_field('rea_number', 'options');
}
add_shortcode('company_rea_number', 'canva_get_company_rea_number');


// Social

/**
 * used to print social icons from theme options
 *
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param array $atts
 * @return void
 */
function canva_get_social_link($atts = [])
{
	extract(shortcode_atts([
		'name' => 'facebook',
		'icon' => 'show',
		'icon_classes' => '',
		'a_classes' => '',
	], $atts));

	$facebook_url = get_field($name, 'options');
	$facebook_icon = get_field($name . '_icon', 'options');

	$icon_src = '';

	if ($facebook_icon) {
		$icon_src = canva_get_svg_icon_from_url(wp_get_attachment_url($facebook_icon), $icon_classes);
	} else {
		$icon_src = canva_get_svg_icon('fontawesome/brands/facebook', $icon_classes);
	}

	$html = '';

	if ($icon == 'show') {
		$html = '<a class="' . esc_attr('_cta-social ' . $name . ' ' . $a_classes) . '" href="' . esc_url($facebook_url) . '" target="_blank" rel="_noopener nofollow">' . $icon_src . '</a>';
	} else {
		$html = '<a class="' . esc_attr('_cta-social ' . $name . ' ' . $a_classes) . '" href="' . esc_url($facebook_url) . '" target="_blank" rel="_noopener nofollow">Facebook</a>';
	}

	return $html;
}
add_shortcode('get_social_link', 'canva_get_social_link');



/**
 * used to prints lists of posts per term filter
 *
 * using canva_get_posts_per_term() - fn-content.php
 *
 * @example [get_posts_per_term post_type="post" taxonomy="category" terms="blog" template_name="card-blog" posts_per_page="3" order="desc" orderby="date" facetwp="false"]
 * @author Toni Guga <toni@schiavoneguga.com>
 * @param array $atts
 * @return void
 */
function canva_posts_per_term_shortcode($atts = [])
{
	extract(shortcode_atts([
		'post_type' => 'post',
		'taxonomy' => 'category',
		'field_type' => 'slug',
		'terms' => 'blog,news',
		'template_name' => 'card-blog',
		'posts_per_page' => '3',
		'order' => 'DESC',
		'orderby' => 'date',
		'facetwp' => 'false',
	], $atts));

	if($terms){
		$terms = explode(',', $terms);
	}

	return canva_get_posts_per_term($post_type, $taxonomy, $field_type, $terms, $template_name, $posts_per_page, $order, $orderby, $facetwp);

}
add_shortcode('get_posts_per_term', 'canva_posts_per_term_shortcode');



