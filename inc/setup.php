<?php

namespace WST\Theme\Setup;

use WST\Theme\Assets;

/**
 * Theme setup
 */
function setup() {
    // Enable features from Soil when plugin is activated
    // https://roots.io/plugins/soil/
    add_theme_support('soil-clean-up');
    // add_theme_support('soil-disable-asset-versioning');
    add_theme_support('soil-disable-trackbacks');
    // add_theme_support('soil-google-analytics', 'UA-XXXXX-Y');
    // add_theme_support('soil-jquery-cdn');
    add_theme_support('soil-js-to-footer');
    // add_theme_support('soil-nav-walker');
    add_theme_support('soil-nice-search');
    add_theme_support('soil-relative-urls');

    // Make theme available for translation
    // Community translations can be found at https://github.com/roots/sage-translations
    load_theme_textdomain('wst', get_template_directory() . '/languages');

    // Enable plugins to manage the document title
    // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
    add_theme_support('title-tag');

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'wst')
    ]);

    // Enable HTML5 markup support
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

    // Add default posts and comments RSS feed links to head
    // https://codex.wordpress.org/Automatic_Feed_Links
    add_theme_support( 'automatic-feed-links' );

    // Use main stylesheet for visual editor
    // To add custom styles edit /assets/styles/layouts/_tinymce.scss
    add_editor_style(Assets\asset_path('css/main.css'));

    // Enable post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
    register_sidebar([
        'name'          => __('Primary', 'wst'),
        'id'            => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ]);

    register_sidebar([
        'name'          => __('Footer', 'wst'),
        'id'            => 'sidebar-footer',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3>',
        'after_title'   => '</h3>'
    ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
    static $display;

    isset($display) || $display = !in_array(true, [
        // The sidebar will NOT be displayed if ANY of the following return true.
        // @link https://codex.wordpress.org/Conditional_Tags
        is_404(),
        is_front_page(),
    ]);

    return apply_filters('wst/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {
    wp_enqueue_style('wst_styles', Assets\asset_path('css/main.css'), false, null);

    wp_enqueue_script('wst_js-vendors', Assets\asset_path('js/vendors.js'), [], null, true);
    wp_enqueue_script('wst_js', Assets\asset_path('js/main.js'), ['wst_js-vendors'], null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);