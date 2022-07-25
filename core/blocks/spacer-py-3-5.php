<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

//if (is_admin() && !defined('DOING_AJAX')) {
if (is_admin()) {

    ?>
    <div class="canva-wp-block canva-flex" style="border: 1px dashed #ccc">

        <div class="__info canva-width-16 canva-p-2">
            <span class="title canva-block canva-mb-2 canva-fs-xxsmall canva-font-system canva-lh-10" style="">Spacer py-3.5</span>

            <figure class="canva-width-8 canva-m-0">
                <!-- ICONA -->
				<?php echo apply_filters('spacers_icon', '<svg width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true" focusable="false"><path d="M13 4v2h3.59L6 16.59V13H4v7h7v-2H7.41L18 7.41V11h2V4h-7"></path></svg>'); ?>
                <!-- Fine Icona -->
            </figure>
        </div>

        <div class="_content canva-flex-1 canva-p-4">
            <span class="canva-block canva-mt-0 canva-mb-2 canva-fs-h4 canva-font-theme canva-fw-300 canva-lh-11 canva-color-grey">Spazio di misura 3.5</span>
            <span class="canva-block canva-mt-0 canva-mb-0 canva-fs-small canva-font-theme canva-color-grey canva-lh-11">Crea uno spazio con un'altezza proporzionale e responsive. Blocco non modificabile</span>
        </div>

    </div>

<?php
} else { ?>

    <span class="block py-3.5">&nbsp;</span>

<?php }
