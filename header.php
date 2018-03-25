<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WP_Starter_Theme
 */

use _WST\Theme\TemplateNav;

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

	<header id="masthead" class="site-header">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#primary-navigation" aria-controls="primary-navigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <?php
                wp_nav_menu([
                    'theme_location'	=> 'primary_navigation',
                    'container'       => 'div',
                    'container_id'    => 'primary-navigation-container',
                    'container_class' => 'collapse navbar-collapse',
                    'menu_id'         => 'primary-navigation',
                    'menu_class'      => 'navbar-nav',
                    'depth'           => 2,
                    'fallback_cb'     => 'bs4Navwalker::fallback',
                    'walker'          => new TemplateNav\WP_Bootstrap_Navwalker()
                ]);
                ?>
            </div>
        </nav>
	</header><!-- #masthead -->
