<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package _WST
 */

?>

<footer id="footer" class="site-footer container">
    <div class="site-info row">
        <div class="col">
            <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'wp-starter-theme' ) ); ?>"><?php
                /* translators: %s: CMS name, i.e. WordPress. */
                printf( esc_html__( 'Proudly powered by %s', 'wp-starter-theme' ), 'WordPress' );
            ?></a>
            <span class="sep"> | </span>
            <?php
                /* translators: 1: Theme name, 2: Theme author. */
                printf( esc_html__( 'Theme: %1$s by %2$s.', 'wp-starter-theme' ), 'wp-starter-theme', '<a href="https://github.com/elconejito/wp-starter-theme/">elconejito/wp-starter-theme</a>' );
            ?>
        </div>
    </div><!-- .site-info -->
</footer><!-- #colophon -->

<?php wp_footer(); ?>

</body>
</html>
