<?php

namespace _WST\Theme\TemplateFunction;

use _WST\Theme\Setup;

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package WP_Starter_Theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function body_class($classes) {
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }
    // Add class if sidebar is active
    if (Setup\display_sidebar()) {
        $classes[] = 'sidebar-primary';
    }
    return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');

/**
 * Clean up the_excerpt()
 */
function excerpt_more() {
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', wp-starter-theme) . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');

/**
 * Output SVGs
 */
function getSVG($path) {
    echo file_get_contents( $path );
}

/**
 * Compare URL against relative URL
 */
function url_compare($url, $rel) {
    $url = trailingslashit($url);
    $rel = trailingslashit($rel);
    return strcasecmp($url, $rel) === 0;
}
