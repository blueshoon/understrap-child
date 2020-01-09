<?php
  /*
  Plugin Name: Understrap Blocks
  Description: Remove some default Gutenberg blocks, enqueue some styles for custom blocks
  Author: Blueshoon
  Author URI: http://www.blueshoon.com/
  */


function register_understrap_gutenberg_blocks() {

  // Register our block script with WordPress
  wp_enqueue_script(
    'understrap-blocks',
    plugins_url('/blocks/dist/blocks.build.js', __FILE__),
    array('wp-blocks', 'wp-edit-post')
  );
  
  // Register our block's editor-specific CSS
 wp_enqueue_style(
    'gutenberg-card-block-edit-style',
    plugins_url('/blocks/dist/blocks.editor.build.css', __FILE__),
    array( 'wp-edit-blocks' )
  );

  // Register our block's webfonts
/*  wp_enqueue_style(
    'gutenberg-card-block-font-style',
    'https://fonts.googleapis.com/css?family=Karla:400,700',
    array( 'wp-edit-blocks' )
  );
*/

}
add_action( 'enqueue_block_editor_assets', 'register_understrap_gutenberg_blocks' );
?>