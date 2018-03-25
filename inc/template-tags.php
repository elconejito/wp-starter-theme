<?php

namespace _WST\Theme\TemplateTags;

use _WST\Theme\Assets;
use _WST\Theme\TemplateFunction;
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package WP_Starter_Theme
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }

    $time_string = sprintf( $time_string,
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_attr( get_the_modified_date( 'c' ) ),
        esc_html( get_the_modified_date() )
    );

    $posted_on = sprintf(
        /* translators: %s: post date. */
        esc_html_x( 'Posted on %s', 'post date', wp-starter-theme ),
        '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
    );

    $byline = sprintf(
        /* translators: %s: post author. */
        esc_html_x( 'by %s', 'post author', wp-starter-theme ),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    );

    echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function entry_footer() {
    // Hide category and tag text for pages.
    if ( 'post' === get_post_type() ) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( esc_html__( ', ', wp-starter-theme ) );
        if ( $categories_list ) {
            /* translators: 1: list of categories. */
            printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', wp-starter-theme ) . '</span>', $categories_list ); // WPCS: XSS OK.
        }

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', wp-starter-theme ) );
        if ( $tags_list ) {
            /* translators: 1: list of tags. */
            printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', wp-starter-theme ) . '</span>', $tags_list ); // WPCS: XSS OK.
        }
    }

    if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
        echo '<span class="comments-link">';
        comments_popup_link(
            sprintf(
                wp_kses(
                    /* translators: %s: post title */
                    __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', wp-starter-theme ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            )
        );
        echo '</span>';
    }

    edit_post_link(
        sprintf(
            wp_kses(
                /* translators: %s: Name of current post. Only visible to screen readers */
                __( 'Edit <span class="screen-reader-text">%s</span>', wp-starter-theme ),
                array(
                    'span' => array(
                        'class' => array(),
                    ),
                )
            ),
            get_the_title()
        ),
        '<span class="edit-link">',
        '</span>'
    );
};

/**
 * Page titles
 */
function title() {
    if (is_home()) {
        if (get_option('page_for_posts', true)) {
            return get_the_title(get_option('page_for_posts', true));
        } else {
            return __('Latest Posts', wp-starter-theme);
        }
    } elseif (is_archive()) {
        return get_the_archive_title();
    } elseif (is_search()) {
        return sprintf(__('Search Results for %s', wp-starter-theme), get_search_query());
    } elseif (is_404()) {
        return __('Not Found', wp-starter-theme);
    } else {
        return get_the_title();
    }
}

function getLogo() {
    TemplateFunction\getSVG( Assets\asset_path('images/logo_security-solutions-2018_dark.svg') );
}
