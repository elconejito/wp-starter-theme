<?php
namespace _WST\Theme\Utilities;

/**
 * Common Utility functions
 *
 */


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

/**
 * Set the background of the current page
 *
 * Order of priority is page custom settings, then theme custom settings, and finally will leave whatever default
 * has been set in the theme CSS
 *
 */
function set_background() {
	// Start with most specific, landing page template override
	$style = '';
	if ( get_field( 'override_default_background' ) ) {
		// Check for Background color and image. If there's an image also check for position and attachment
		$background_color = get_field( 'background_color' );
		if ( isset($background_color) ) {
			$style .= "background-color: " . $background_color . ";\n";
		}

		$background_image = get_field( 'background_image' );
		if ( isset($background_image) && is_array($background_image) ) {
			$style .= "background-image: url( '" . $background_image['url'] . "' );\n";

			$background_image_position   = get_field( 'background_image_position' );
			$background_image_attachment = get_field( 'background_image_attachment' );
			$background_image_size       = get_field( 'background_image_size' );
			if ( isset($background_image_position) && $background_image_position != '' ) {
				$style .= "background-position: " . $background_image_position . ";\n";
			} else {
				$style .= "background-position: center;\n";
			}
			if ( isset($background_image_attachment) && $background_image_attachment == 'fixed' ) {
				$style .= "background-attachment: " . $background_image_attachment . ";\n";
			}
			if ( isset($background_image_size) && $background_image_size != '' ) {
				$style .= "background-size: " . $background_image_size . ";\n";
			}
		}
	} else {
		// is there any custom settings?

		// Check for Text color
		if ( get_field( 'text_color', 'option' ) ) {
			$style .= "color: " . get_field( 'text_color', 'option' ) . ";\n";
		}

		// Check for Background color and image. If there's an image also check for position and attachment
		if ( get_field( 'background_color', 'option' ) ) {
			$style .= "background-color: " . get_field( 'background_color', 'option' ) . ";\n";
		}

		$background_image = get_field( 'background_image', 'option' );
		if ( isset($background_image) && is_array($background_image) ) {
			$style .= "background-image: url( '" . $background_image['url'] . "' );\n";

			// Set the background image position
			if ( get_field( 'background_image_position', 'option' ) ) {
				if ( get_field( 'background_image_position', 'option' ) == 'custom' ) {
					$style .= "background-position: " . get_field( 'background_image_position_custom', 'option' ) . ";\n";
				} else {
					$style .= "background-position: " . get_field( 'background_image_position', 'option' ) . ";\n";
				}
			} else {
				$style .= "background-position: center;\n";
			}
			// Set the background image size
			if ( get_field( 'background_image_size', 'option' ) ) {
				if ( get_field( 'background_image_size', 'option' ) == 'custom' ) {
					$style .= "background-size: " . get_field( 'background_image_size_custom', 'option' ) . ";\n";
				} else {
					$style .= "background-size: " . get_field( 'background_image_size', 'option' ) . ";\n";
				}
			}
			// Set the background image attachment
			if ( get_field( 'background_image_attachment', 'option' ) ) {
				$style .= "background-attachment: " . get_field( 'background_image_attachment', 'option' ) . ";\n";
			}

		}
	}

	if ( $style != '' ) {
		?>
		<style>
			body {
			<?php echo $style; ?>
			}
		</style>
		<?php
	}

	return true;
}
add_action( 'wp_head', __NAMESPACE__.'\\set_background' );

function output_custom_css() {
	// If there's any custom CSS in the theme settings, grab that first.
	if ( get_field( 'custom_css', 'option' ) ) {
		the_field( 'custom_css', 'option' );
	}

	// IF there's any custom CSS in the POST settings, grab that next so it overwrites Theme settings
	if ( get_field( 'custom_css' ) ) {
		the_field( 'custom_css' );
	}
}
add_action( 'wp_head', __NAMESPACE__.'\\output_custom_css', 20);

function output_custom_header_scripts() {
	// If there's any custom header JS in the theme settings, grab that first.
	if ( ! is_page_template('page_victory.php') && get_field( 'custom_js_header', 'option' ) ) {
		the_field( 'custom_js_header', 'option' );
	}

	// IF there's any custom header JS in the POST settings, grab that next so it overwrites Theme settings
	if ( get_field( 'custom_js_header' ) ) {
		the_field( 'custom_js_header' );
	}
}
add_action( 'wp_head', __NAMESPACE__.'\\output_custom_header_scripts', 30);

function output_custom_footer_scripts() {
	// If there's any custom JS in the THEME settings, grab that first.
	if ( get_field( 'custom_js', 'option' ) ) {
		the_field( 'custom_js', 'option' );
	}

	// If there's any custom JS in the POST settings, grab that next so it overwrites THEME settings
	if ( get_field( 'custom_js' ) ) {
		the_field( 'custom_js' );
	}
}
add_action( 'wp_footer', __NAMESPACE__.'\\output_custom_footer_scripts', 20);

/**
 * Remove Emojis
 * @link http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 * @param $plugins
 *
 * @return array
 */
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove Emojis
 * @link http://wordpress.stackexchange.com/questions/185577/disable-emojicons-introduced-with-wp-4-2
 */
function disable_wp_emojicons() {

	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', __NAMESPACE__.'\\disable_emojicons_tinymce' );
}
add_action( 'init', __NAMESPACE__.'\\disable_wp_emojicons' );

/**
 * Remove the admin bar from the front end
 */
add_filter('show_admin_bar', '__return_false');


/**
 * Debugging function. Outputs theme template information in the footer of the page
 *
 */
if ( defined('WP_ENV') && WP_ENV == 'development' ) {
	// Debugging. Only run if in development
	add_action('wp_footer', __NAMESPACE__.'\\show_debug_template');
}
if (!function_exists('write_log')) {
	function write_log ( $log )  {
		if ( defined('WP_DEBUG') && WP_DEBUG === true ) {
			if ( is_array( $log ) || is_object( $log ) ) {
				error_log( print_r( $log, true ) );
			} else {
				error_log( $log );
			}
		}
	}
}
function show_debug_template() {
	global $template;
	print_r("<div class='column debugging'><p>DEBUGGING: Nothing to see here.</p><p>Template: ".basename($template)." | Post Format: ".get_post_format()." | Post Type: ".get_post_type()." | IsHome: ".is_home()." | IsFrontPage: ".is_front_page()."</p></div>");
}
