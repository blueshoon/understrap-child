var allowedBlocks = [
    'core/code',
    'core/image',
    'core/freeform',
    'core/paragraph',
    'core/shortcode',
    'core/table',
    'core-embed/vimeo',
    'core-embed/youtube'
];
//wp.blocks.unregisterBlockType( 'core/verse' );
window.wp.domReady(function() {
    wp.blocks.getBlockTypes().forEach( function( blockType ) {
        if ( allowedBlocks.indexOf( blockType.name ) === -1 && blockType.name.indexOf('acf/') === -1 ) {
            wp.blocks.unregisterBlockType( blockType.name );
        }
    });
});
