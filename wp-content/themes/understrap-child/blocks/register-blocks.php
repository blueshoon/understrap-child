<?php
//custom gutenberg blocks with Advanced Custom Fields
add_action('acf/init', 'sp_acf_blocks');
function sp_acf_blocks() {
	
	// check function exists
	if( function_exists('acf_register_block') ) {
		
		/* register your custom gutenberg blocks below.  EX:
		acf_register_block(array(
			'name'				=> 'columns',
			'title'				=> __('Columns'),
			'description'		=> __('A set of bootstrap columns.'),
			'render_callback'	=> 'my_acf_block_render_callback',
			'category'			=> 'layout',
			'icon'				=> 'screenoptions',
			'render_template'	=> 'blocks/templates/content-columns.php',
			'keywords'			=> array( 'columns', 'bootstrap', 'grid' ),
			'supports'			=> array(
				'align'				=> false,
				'mode'				=> 'edit',
				'className'			=> true
			)
		)); */
	}
}