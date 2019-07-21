<?php

namespace _WST\Theme\TemplateFunction;

use _WST\Theme\Setup;

/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package _WST
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
    return ' &hellip; <a href="' . get_permalink() . '">' . __('Continued', '_wst') . '</a>';
}
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');
