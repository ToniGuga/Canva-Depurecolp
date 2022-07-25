<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

	// filtro che permette di sovrascrivere l'icona di questo blocco
?>
	<div class="sg-wp-block sg-flex">

		<div class="_info sg-p-4" style="min-width: 100%">
			<span class="title sg-block sg-mb-2 sg-fs-xxsmall sg-font-system sg-lh-12" style=""><?php _e('Get Posts (Terms of post)', 'canva-be'); ?> </span>
			<!-- <span>Contiene: Sopratitolo, Titolo, Sottotitolo</span> -->
			<figure class="sg-width-8 sg-m-0">

				<!-- ICONA -->
				<?php echo apply_filters('post_per_term_selector_icon', '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M497.83 97.98L413.94 14.1c-9-9-21.2-14.1-33.89-14.1H175.99C149.5.1 128 21.6 128 48.09v215.98H12c-6.63 0-12 5.37-12 12v24c0 6.63 5.37 12 12 12h276v48.88c0 10.71 12.97 16.05 20.52 8.45l71.77-72.31c4.95-4.99 4.95-13.04 0-18.03l-71.77-72.31c-7.55-7.6-20.52-2.26-20.52 8.45v48.88H175.99V48.09h159.97v103.98c0 13.3 10.7 23.99 24 23.99H464v287.95H175.99V360.07H128v103.94c0 26.49 21.5 47.99 47.99 47.99h287.94c26.5 0 48.07-21.5 48.07-47.99V131.97c0-12.69-5.17-24.99-14.17-33.99zm-113.88 30.09V51.99l76.09 76.08h-76.09z" /></svg>'); ?>
				<!-- Fine Icona -->

			</figure>
		</div>

		<div class="content sg-flex-1 sg-p-4">
			<?php if (get_field('post_type_slug')) { ?>
				<h3 class="sg-block sg-mt-0 sg-mb-0 sg-fs-h5 sg-lh-11"><?php echo get_field('post_type_slug'); ?></h3>
			<?php } else { ?>
				<h3 class="sg-block sg-mt-0 sg-mb-0 sg-fs-h5 sg-lh-11"><?php _e('Setup the post type field', 'canva-be'); ?></h3>
			<?php } ?>
		</div>

	</div>

	<?php

} else {

	if (!get_field('hide') || (get_field('hide') && get_field('show_for_admin') && current_user_can('edit_pages'))) {

		// // Create id attribute allowing for custom "anchor" value.
		$id = $block['id'];
		if (!empty($block['anchor'])) {
			$id = $block['anchor'];
		}

		// Create class attribute allowing for custom "className" and "align" values.
		$className = '';
		if (!empty($block['className'])) {
			$className = $block['className'];
		} else {
			if (!get_field('swiper_mode')) {
				$className = apply_filters('posts_per_term_class_name', 'grid grid-cols-1 ms:grid-cols-2 lg:grid-cols-3 gap-4');
			} else {
				$className = apply_filters('posts_per_term_class_name', 'row sezione');
			}
		}

		$post_type = sanitize_key(sanitize_text_field(get_field('post_type_slug')));
		$taxonomy_slug = sanitize_key(sanitize_text_field(get_field('taxonomy_slug')));

		if(!$post_type){
			$post_type == 'post';
		}

		if(!$taxonomy_slug){
			$taxonomy_slug == 'category';
		}

		$terms = get_the_terms(get_the_ID(), $taxonomy_slug);

		$term_slug_array = [];
		foreach ($terms as $term) {
			$term_slug_array[] = $term->slug;
		}

		$template_name = sanitize_key(sanitize_text_field(get_field('template_name')));

		$order = sanitize_key(sanitize_text_field(get_field('order')));
		$orderby = sanitize_key(sanitize_text_field(get_field('orderby')));
		$posts_per_page = sanitize_key(sanitize_text_field(get_field('posts_per_page')));
		$offset = sanitize_key(sanitize_text_field(get_field('offset')));

		$now = current_time('Y-m-d H:i:s');

		$start_date_time_field_name = apply_filters('start_date_time_field_name', 'start_date_time');
		$end_date_time_field_name = apply_filters('end_date_time_field_name', 'end_date_time');
		$results_date_time_field_name = apply_filters('end_date_time_field_name', 'results_date_time');

		$coming = sanitize_key(sanitize_text_field(get_field('coming')));
		$during = sanitize_key(sanitize_text_field(get_field('during')));
		$past = sanitize_key(sanitize_text_field(get_field('past')));
		$results = sanitize_key(sanitize_text_field(get_field('results')));

		if ($coming && $during) {
			$args = [
				'facetwp' => get_field('facetwp_mode'),
				'posts_per_page' => $posts_per_page,
				'offset' => $offset,
				'post_type' => $post_type,
				'suppress_filters' => false,
				'order' => $order,
				'orderby' => 'meta_value ' . $orderby,
				'meta_key' => $start_date_time_field_name,
				// 'meta_key' => $start_date_time_field_name,
				'meta_type' => 'DATETIME',
				'tax_query' => [
					['taxonomy' => $taxonomy_slug, 'field' => 'slug', 'terms' => $term_slug_array],
				],
				'meta_query' => [
					//'relation' => 'AND',
					['key' => $end_date_time_field_name, 'compare' => '>=', 'value' => $now, 'type' => 'DATETIME'],
				],
			];
		} elseif ($during && $past) {
			$args = [
				'facetwp' => get_field('facetwp_mode'),
				'posts_per_page' => $posts_per_page,
				'offset' => $offset,
				'post_type' => $post_type,
				'suppress_filters' => false,
				'order' => $order,
				'orderby' => 'meta_value ' . $orderby,
				// 'meta_key' => 'start_day_time',
				'meta_key' => $end_date_time_field_name,
				'meta_type' => 'DATETIME',
				'tax_query' => [
					['taxonomy' => $taxonomy_slug, 'field' => 'slug', 'terms' => $term_slug_array],
				],
				'meta_query' => [
					//'relation' => 'AND',
					['key' => $start_date_time_field_name, 'compare' => '<=', 'value' => $now, 'type' => 'DATETIME'],
				],
			];
		} elseif ($coming) {
			$args = [
				'facetwp' => get_field('facetwp_mode'),
				'posts_per_page' => $posts_per_page,
				'offset' => $offset,
				'post_type' => $post_type,
				'suppress_filters' => false,
				'order' => $order,
				'orderby' => 'meta_value ' . $orderby,
				'meta_key' => $start_date_time_field_name,
				'meta_type' => 'DATETIME',
				'tax_query' => [
					['taxonomy' => $taxonomy_slug, 'field' => 'slug', 'terms' => $term_slug_array],
				],
				'meta_query' => [
					['key' => $start_date_time_field_name, 'compare' => '>=', 'value' => $now, 'type' => 'DATETIME'],
				],
			];
		} elseif ($during) {
			$args = [
				'facetwp' => get_field('facetwp_mode'),
				'posts_per_page' => $posts_per_page,
				'offset' => $offset,
				'post_type' => $post_type,
				'suppress_filters' => false,
				'order' => $order,
				'orderby' => 'meta_value ' . $orderby,
				'meta_key' => $start_date_time_field_name,
				// 'meta_key' => $start_date_time_field_name,
				'meta_type' => 'DATETIME',
				'tax_query' => [
					['taxonomy' => $taxonomy_slug, 'field' => 'slug', 'terms' => $term_slug_array],
				],
				'meta_query' => [
					'relation' => 'AND',
					// array('key' => 'start_day_time','compare' => '<=','value' => $now,'type' => 'DATETIME'),
					['key' => $start_date_time_field_name, 'compare' => '<=', 'value' => $now, 'type' => 'DATETIME'],
					['key' => $end_date_time_field_name, 'compare' => '>=', 'value' => $now, 'type' => 'DATETIME'],
				],
			];
		} elseif ($past) {
			$args = [
				'facetwp' => get_field('facetwp_mode'),
				'posts_per_page' => $posts_per_page,
				'offset' => $offset,
				'post_type' => $post_type,
				'suppress_filters' => false,
				'order' => $order,
				'orderby' => 'meta_value ' . $orderby,
				'meta_key' => $end_date_time_field_name,
				'meta_type' => 'DATETIME',
				'tax_query' => [
					['taxonomy' => $taxonomy_slug, 'field' => 'slug', 'terms' => $term_slug_array],
				],
				'meta_query' => [
					'relation' => 'AND',
					['key' => $start_date_time_field_name, 'compare' => '<', 'value' => $now, 'type' => 'DATETIME'],
					['key' => $end_date_time_field_name, 'compare' => '<', 'value' => $now, 'type' => 'DATETIME'],
				],
			];
		} elseif ($results) {
			$args = [
				'facetwp' => get_field('facetwp_mode'),
				'posts_per_page' => $posts_per_page,
				'offset' => $offset,
				'post_type' => $post_type,
				'suppress_filters' => false,
				'order' => $order,
				'orderby' => 'meta_value ' . $orderby,
				'meta_key' => $results_date_time_field_name,
				'meta_type' => 'DATETIME',
				'tax_query' => [
					['taxonomy' => $taxonomy_slug, 'field' => 'slug', 'terms' => $term_slug_array],
				],
				'meta_query' => [
					'relation' => 'AND',
					['key' => $end_date_time_field_name, 'compare' => '<', 'value' => $now, 'type' => 'DATETIME'],
					['key' => $results_date_time_field_name, 'compare' => '>', 'value' => $now, 'type' => 'DATETIME'],
				],
			];
		} else {
			$args = [
				'facetwp' => get_field('facetwp_mode'),
				'posts_per_page' => $posts_per_page,
				'offset' => $offset,
				'post_type' => $post_type,
				'suppress_filters' => false,
				'order' => $order,
				'orderby' => $orderby,
				'tax_query' => [
					['taxonomy' => $taxonomy_slug, 'field' => 'slug', 'terms' => $term_slug_array],
				],
			];
		}

		$posts = get_posts($args);

	?>

		<?php if (!get_field('swiper_mode')) { ?>

			<?php if (get_field('facetwp_mode')) { ?>
				<div class="flex fs-small">
					<div class="mr-2"><?php _e('Risultati: ', 'canva-be'); ?></div>
					<?php echo facetwp_display('counts'); ?>
				</div>

				<div class="facetwp-template">
				<?php } ?>

				<div id="<?php echo esc_attr($id); ?>" class="post-per-term-selector <?php echo esc_attr($className); ?>">

					<?php
					foreach ($posts as $p) {
						// echo $p->ID;

						// setup_postdata($p);
						// if(get_post_type($p->ID) == 'product'){
						// 	if(is_woocommerce_activated()){
						// 		wc_get_template_part('content', 'product');
						// 	}else{
						// 		echo canva_get_template($template_name, ['post_id' => $p->ID]);
						// 	}
						// }else{
						// }

						echo canva_get_template($template_name, ['post_id' => $p->ID]);
					} //end foreach

					// wp_reset_postdata();
					?>

				</div>

				<?php if (get_field('facetwp_mode')) { ?>
				</div>

				<div class="row">
					<div class="column small-12"><?php echo facetwp_display('facet', 'load_more'); ?></div>
				</div>
			<?php } ?>

		<?php } else { ?>

		<?php
			$post_ids = [];
			foreach ($posts as $p) {
				$post_ids[] = $p->ID;
			} //end foreach

			canva_slider_post_ids(
				[
					'post_ids' => $post_ids,
					'template_name' => $template_name,
					'swiper_id' => esc_attr($id),
					'swiper_hero_class' => esc_attr($className) . ' post-per-term-selector',
					'swiper_container_class' => 'w-100 swiper-controls-outside',
					'slides_per_view_xsmall' => 1,
					'slides_per_view_small' => 1,
					'slides_per_view_medium' => 2,
					'slides_per_view_large' => 3,
					'slides_per_view_xlarge' => 3,
					'prev_next' => 'true',
					'pagination' => 'true',
					'autoplay' => 'false',
					'loop' => 'false',
					'centered_slides_bounds' => 'false',
					'centered_slides' => 'false',
					'slides_offset_before' => 0,
					'slides_offset_after' => 0,
					'free_mode' => 'false',
				]
			);
		}
		?>

<?php
	}
}
