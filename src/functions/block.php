<?
function add_speak_block() {
    wp_enqueue_script(
        'speak_block_script', //スクリプトを識別するためのハンドル名
        get_template_directory_uri() . '/blocks/speak.js', 
        array( 'wp-blocks', 'wp-element' )
    );
}
add_action( 'enqueue_block_editor_assets', 'add_speak_block' );


function add_mokuji_block() {
    wp_enqueue_script(
        'mokuji_block_script', //スクリプトを識別するためのハンドル名
        get_template_directory_uri() . '/blocks/mokuji.js', 
        array( 'wp-blocks', 'wp-element' )
    );
}
add_action( 'enqueue_block_editor_assets', 'add_mokuji_block' );