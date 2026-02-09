<?php
/**
 * Theme bootstrap.
 *
 * Loads theme files, registers setup, CPT, taxonomies, and other core includes.
 *
 * @package Alkes_Katalog
 */

defined( 'ABSPATH' ) || exit;

// Enqueue assets (Vite / CSS / JS)
require_once get_template_directory() . '/inc/enqueue.php';

// Theme setup (menus, supports, etc)
require_once get_template_directory() . '/inc/theme-setup.php';

// ACF setup & field groups
require_once get_template_directory() . '/inc/acf-setup.php';

// Custom Post Types
require_once get_template_directory() . '/inc/cpt-product.php';

// Taxonomies for Custom Post Types
require_once get_template_directory() . '/inc/taxonomies.php';

// Custom Post Product Editor Classic
require_once get_template_directory() . '/inc/editor.php';

// Data fetchers
require_once get_template_directory() . '/inc/data/hero-products.php';
require_once get_template_directory() . '/inc/data/featured-products.php';

// Helpers functions
require_once get_template_directory() . '/inc/helpers.php';

// Custom queries modifications
require_once get_template_directory() . '/inc/queries.php';

// REST API endpoints
require_once get_template_directory() . '/inc/rest.php';

// Shortcodes
require_once get_template_directory() . '/inc/shortcodes.php';

// Layout Field in Products Form
