<?php

function casino_shortcode( $atts = [], $content = null, $tag = '' )
{
    if( ! is_user_logged_in() )
    {
        $login_url = wp_login_url( get_permalink() );

        return '<p>You must <a href="' . $login_url . '">login</a> to play this game</p>';
    }

    $balance = intval( get_user_meta( get_current_user_id(), 'casino_balance', true ) );

    ob_start();

    include dirname( CASINO_DIR ) . '/views/casino-game.php';

    return ob_get_clean();
}

function casino_shortcode_init()
{
    add_shortcode( 'casino', 'casino_shortcode' );
}

add_action( 'init', 'casino_shortcode_init' );


function casino_shortcode_enqueue_block_editor_assets()
{
    wp_enqueue_script( 'casino-block', plugin_dir_url( CASINO_DIR ) . 'scripts/casino-shortcode.js', [
        'wp-blocks',
        'wp-editor',
        'wp-components',
        'wp-i18n'
    ], '1.0', true );
}

add_action( 'enqueue_block_editor_assets', 'casino_shortcode_enqueue_block_editor_assets' );


function casino_user_registration_handler( $user_id )
{
    update_user_meta( $user_id, 'casino_balance', 10 );
}

add_action( 'user_register', 'casino_user_registration_handler' );