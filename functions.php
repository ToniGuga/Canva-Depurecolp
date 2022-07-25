<?php
// Core
require_once 'core/functions/fn-core.php';
require_once 'core/functions/fn-development.php';

// Acf fields for theme stuff
require_once 'core/functions/acf-fields-theme.php';

// Register Styles & Scripts
require_once 'core/functions/fn-images.php';

// Backend
require_once 'core/functions/fn-backend.php';

// Core & Project Blocks
require_once 'core/blocks/acf-register-blocks.php';
require_once 'project/blocks/acf-register-blocks.php';
require_once 'core/blocks/acf-fields-blocks.php';
require_once 'project/blocks/acf-fields-blocks.php';

// Register Theme Custom Post Types
require_once 'core/functions/cpt-register.php';

// Acf fields for taxonomies
require_once 'core/functions/acf-fields-taxonomy.php';

if (get_field('people_post_type', 'options')) {
	require_once 'core/functions/acf-fields-people-cpt.php';
}

if (get_field('stores_post_type', 'options')) {
	require_once 'core/functions/acf-fields-stores-cpt.php';
}

if (get_field('faq_post_type', 'options')) {
	require_once 'core/functions/acf-fields-faq-cpt.php';
}

if (get_field('events_post_type', 'options')) {
	require_once 'core/functions/acf-fields-events-cpt.php';
}

// Add theme support & Cleanup Things
require_once 'core/functions/fn-theme-support.php';
require_once 'core/functions/fn-cleanup.php';

// Register Styles & Scripts
require_once 'core/functions/fn-register-style-script.php';

// Register Tracking Systema (GA & FB)
require_once 'core/functions/fn-tracking.php';

// Menu Builder Functions
require_once 'core/functions/fn-menu.php';

// // Register Styles & Scripts
// require_once 'core/functions/fn-images.php';

// Maps
require_once 'core/functions/fn-maps.php';

// Content functions
require_once 'core/functions/fn-content.php';

// Static UI HTML Elements
require_once 'core/functions/fn-ui-elements.php';

// System shortcode
require_once 'core/functions/fn-shortcode.php';

// Hooks
require_once 'core/functions/fn-hooks.php';

// Export Tools
require_once 'core/functions/class-php-export-data-xlsx-xsv-tsv.php';

// Utilities
require_once 'core/functions/fn-utilities.php';

// Project
require_once 'project/fn-project.php';
