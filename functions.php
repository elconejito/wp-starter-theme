<?php
/**
 * Includes
 *
 * The $file_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */
$file_includes = [
    'inc/assets.php',               // Scripts and stylesheets
    'inc/template-functions.php',   // Template functions
    'inc/template-tags.php',        // Template Markup functions
    'inc/setup.php',                // Theme setup
    'inc/template-nav-walker.php',  // Nav Walker for Bootstrap 4
];

foreach ( $file_includes as $file ) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'wp-starter-theme'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}

unset($file, $filepath);
