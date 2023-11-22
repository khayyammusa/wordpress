<?php

function casino_game_enqueue_ajax_script()
{
    wp_enqueue_script( 'my-ajax-script', plugin_dir_url( CASINO_DIR ) . 'scripts/casino-game.js', [ 'jquery' ], '1.0', true );

    wp_localize_script( 'my-ajax-script', 'casino_ajax_object', [
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'top_up_message' => __( 'Top up balance' ),
        'congratulation_message' => __( 'Congratulations!!!' ),
        'error_message' => __( 'Something went wrong!' )
    ] );
}

add_action( 'wp_enqueue_scripts', 'casino_game_enqueue_ajax_script' );


function casino_get_post_id_with_shortcode()
{
    global $wpdb;

    $shortcode_tag = esc_sql( 'casino' );
    $shortcode_pattern = '%[casino%';

    return $wpdb -> get_var( $wpdb -> prepare( "
        SELECT ID
        FROM $wpdb->posts
        WHERE post_content LIKE %s
        LIMIT 1
    ", $shortcode_pattern ) );
}


function casino_play_game()
{
    $user_id = get_current_user_id();

    $balance = intval( get_user_meta( $user_id, 'casino_balance', true ) );

    $amount = intval( $_POST[ 'casino_amount' ] );

    if( $balance >= $amount )
    {
        $prize = rand( 0, $amount * 2 );

        if( $prize > $amount ) $balance += $prize;

        else $balance -= $amount;

        update_user_meta( $user_id, 'casino_balance', $balance );

        echo json_encode( [
            'balance' => $balance,
            'prize' => $prize,
            'won' => $prize > $amount
        ] );

        update_user_meta( $user_id, 'casino_last_played_at', date( 'Y-m-d H:i:s' ) );
    }

    wp_die();
}

add_action( 'wp_ajax_casino_play_game', 'casino_play_game' );


function casino_detect_woocommerce_activation()
{
    if( class_exists( 'WooCommerce' ) )
    {
        $product = new WC_Product_Simple();

        $product -> set_name( 'FS Product' );

        $product -> set_regular_price( 1 );

        $product_id = $product -> save();

        add_option( 'casino_product_id', $product_id );
    }
}

add_action( 'activated_plugin', 'casino_detect_woocommerce_activation' );


function casino_top_up_balance()
{
    $user_id = get_current_user_id();

    $balance = intval( get_user_meta( $user_id, 'casino_balance', true ) );

    $amount = intval( $_POST[ 'casino_amount' ] );

    if( $amount )
    {
        if( class_exists( 'WooCommerce' ) )
        {
            $current_user = wp_get_current_user();

            $username = $current_user -> user_login;

            $product_id = get_option( 'casino_product_id' );

            $product = wc_get_product( $product_id );

            $product -> set_name( 'Top up balance - ' . $username );

            $product -> set_regular_price( $amount );

            $product -> save();

            WC() -> cart -> add_to_cart( $product_id, 1 );

            echo json_encode( wc_get_cart_url() );
        }
    }

    wp_die();
}

add_action( 'wp_ajax_casino_top_up_balance', 'casino_top_up_balance' );


function casino_payment_complete_action( $order_id )
{
    $order = wc_get_order( $order_id );

    $amount = $order -> get_total();

    $user_id = get_current_user_id();

    $balance = get_user_meta( $user_id, 'casino_balance', true );

    update_user_meta( $user_id, 'casino_balance', $balance + $amount );

    $post_id = casino_get_post_id_with_shortcode();

    wp_redirect( get_permalink( $post_id ) );

    exit();
}

add_action( 'woocommerce_thankyou', 'casino_payment_complete_action', 10, 1 );