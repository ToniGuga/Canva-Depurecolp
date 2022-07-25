<?php

/* Template Name: Search Page */

get_header();

$search_code = esc_url(get_the_permalink(apply_filters( 'wpml_object_id', 197, 'page' )));
$advanced_search = esc_url(get_the_permalink(apply_filters( 'wpml_object_id', 195, 'page' )));
$search_catalog = esc_url(get_the_permalink(apply_filters( 'wpml_object_id', 189, 'page' )));

?>

<div class="container my-8 md:my-16">

    <div class="flex flex-wrap">

        <div class="w-full md:w-3/4 p-4 md:p-8">

            <?php if (have_posts()) : ?>

                <h1 class="h2">
                    <?php _e('Risultati per', 'silmax'); ?> <span class="text-blue-500"><?php echo $s; ?></span>
                </h1>

                <?php echo facetwp_display('template', 'regular_search'); ?>

                <div class="pt-4 md:tb-8 mt-4 md:mt-8 border-t border-gray-200">

                    <?php echo facetwp_display('facet', 'carica_altri'); ?>

                </div>

            <?php else : ?>

                <h1 class="h2">
                    <?php _e('Nessun risultato per', 'silmax'); ?> <span class="text-blue-500"><?php echo $s; ?></span>
                </h1>

                <p>
                    <?php echo _e('Effettua una nuova ricerca o utilizza il menu di navigazione.', 'silmax'); ?>  <?php echo sprintf( __('Se stai cercando un\'utensile prova la <a class="hover:underline" href="%s">ricerca per codice</a>, la <a class="hover:underline" href="%s">ricerca per lavorazione</a> oppure vai al <a class="hover:underline" href="%s">catalogo online</a>.','silmax'),$search_code,$advanced_search,$search_catalog ) ?>
                </p>

                <div class="max-w-xl">
                    <?php get_search_form(); ?>
                </div>

            <?php endif; ?>

        </div>

        <div class="w-full md:w-1/4 p-4 md:p-8">

            <h4>
                <?php _e('Cerca utensili', 'silmax'); ?>
            </h4>

            <p class="mb-4 pb-4 border-b border-gray-300">

                <a href="<?php echo get_the_permalink('197'); ?>">
                    <?php _e('Ricerca per codice', 'silmax'); ?>
                </a>

            </p>

            <p class="mb-4 pb-4 border-b border-gray-300">

                <a href="<?php echo get_the_permalink('195'); ?>">
                    <?php _e('Ricerca per lavorazione', 'silmax'); ?>
                </a>

            </p>

            <p class="mb-4 pb-4 border-b border-gray-300">

                <a href="<?php echo get_the_permalink('189'); ?>">
                    <?php _e('Vai al catalogo', 'silmax'); ?>
                </a>

            </p>

        </div>

    </div>

</div>

<?php get_footer();
