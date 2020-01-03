<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

//get hashed asset name from manifest file
function asset_path($filename) {
	$manifest_path = get_stylesheet_directory() .'/assets/dist/rev-manifest.json';
	if (file_exists($manifest_path)) {
		$manifest = json_decode(file_get_contents($manifest_path), TRUE);
	} else {
		$manifest = [];
	}

	if (array_key_exists($filename, $manifest)) {
		return $manifest[$filename];
	}

	return $filename;
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();
    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() .'/assets/dist/css/' .  asset_path('child-theme.css'), array(), null );
    wp_enqueue_script( 'jquery');
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/assets/dist/js/' .  asset_path('child-theme.js'), array(), null, true );
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

function add_child_theme_textdomain() {
    load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );

/*
blocks for gutenberg
requires Advanced Custom Fields Pro
If not using ACF, remove this line
*/
require_once('blocks/register-blocks.php');

/*
Custom posts
 */
//require_once('inc/custom-posts.php');

/* Performance Improvements */
require_once('inc/wp-performance.php');


//new image sizes for responsive images
add_image_size( 'midsize', 1440, 900 );
add_image_size( 'fullsize', 1920, 1080 );

//new max width for image srcset
function understrap_srcset_max($max_width) {
    return 2880;
}
add_filter('max_srcset_image_width', 'understrap_srcset_max');


// Filter the output of logo - set alt to homepage
add_filter( 'get_custom_logo', 'understrap_child_custom_logo' );
function understrap_child_custom_logo() {
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $html = sprintf( '<a href="%1$s" class="custom-logo-link navbar-brand" rel="home">%2$s</a>',
            get_option('siteurl'),
            wp_get_attachment_image( $custom_logo_id, 'full', false, array(
				'class'    => 'custom-logo',
				'alt' => 'Homepage'
            ) )
        );
    return $html;
}


//custom editor styles
function understrap_child_tiny_mce_before_init( $settings ) {
	$style_formats = array(
		array(
			'title'    => 'Uppercase',
            'inline' => 'span',
            'classes' => 'text-uppercase'
        ),
        array(
			'title'    => 'Primary Text',
            'inline' => 'span',
            'classes' => 'text-primary'
        ),
        array(
			'title'    => 'Primary Button',
            'selector' => 'a, input, button',
            'classes' => 'btn btn-sm btn-primary'
        )
	);
	if ( isset( $settings['style_formats'] ) ) {
		$orig_style_formats = json_decode( $settings['style_formats'], true );
		$style_formats      = array_merge( $orig_style_formats, $style_formats );
	}

	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'understrap_child_tiny_mce_before_init' );


/* set priority of Yoast Meta boxes to low
   Uncomment if using Yoast SEO Plugin
/*
//add_filter( 'wpseo_metabox_prio', function() { return 'low';});
