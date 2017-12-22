<?php
/**
 * Includes
 *
 * The $wst_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$wst_includes = [
    'inc/assets.php',               // Scripts and stylesheets
    'inc/template-functions.php',   // Template functions
    'inc/template-tags.php',        // Template Markup functions
    'inc/setup.php',                // Theme setup
];

foreach ( $wst_includes as $file ) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'wst'), $file), E_USER_ERROR);
    }
    require_once $filepath;
}

unset($file, $filepath);