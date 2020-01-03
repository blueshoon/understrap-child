<?php
/*include('pre-critical-css-check.php');

function async_load_css( $html, $handle, $href, $media ) {
	if ( !is_admin() && $GLOBALS['pagenow'] !== 'wp-login.php' && !defined('PRE_CRITICAL_CSS')) {
		$html = '<link rel="preload" href="' . esc_url( $href ) . '" as="style" onload="this.onload=null;this.rel=\'stylesheet\'">
		<noscript><link rel="stylesheet" href="' . esc_url( $href ) . '"></noscript>';
	}
    return $html;
}
add_filter( 'style_loader_tag', 'async_load_css', 10, 4 );*/
 
//remove emojis from site
function disable_wp_emojicons() {
	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	//remove dns prefetch
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'disable_wp_emojicons' );