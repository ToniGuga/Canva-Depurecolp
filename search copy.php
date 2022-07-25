<?php

/* Template Name: Search Page */

get_header();
?>

<div class="container my-8 md:my-16">

    <div class="flex flex-wrap">

        <div class="w-full p-4 md:p-8">

            <?php if (have_posts()) : ?>

                <h1 class="h2">
                    <?php _e('Results for', 'canva-abac'); ?> <span class="text-blue-500"><?php echo $s; ?></span>
                </h1>

                <?php echo facetwp_display('template', 'regular_search'); ?>

                <div class="pt-4 md:tb-8 mt-4 md:mt-8 border-t border-gray-200">
                    <?php echo facetwp_display('facet', 'load_more'); ?>
                </div>

            <?php else : ?>

                <h1 class="h2">
                    <?php _e('Nothing found for', 'canva-abac'); ?> <span class="text-blue-500"><?php echo $s; ?></span>
                </h1>

                <p>
                    <?php echo _e('Search something else or try to use the navigation bar.', 'canva-abac'); ?>
                </p>

                <div class="max-w-xl">
                    <?php //get_search_form(); ?>
					<?php echo facetwp_display('facet', 'regular_search'); ?>
					<?php echo facetwp_display('template', 'regular_search'); ?>

                <div class="pt-4 md:tb-8 mt-4 md:mt-8 border-t border-gray-200">
                    <?php echo facetwp_display('facet', 'load_more'); ?>
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php get_footer();
