<?php

function casino_add_logs_table()
{
    global $wpdb;

    $charset_collate = $wpdb -> get_charset_collate();

    $sql = "CREATE TABLE wp_casino_logs (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                user_id mediumint(9) NOT NULL,
                reminded_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) $charset_collate;";

    $wpdb -> query( $sql );
}

function casino_activate()
{
    add_option( 'casino_reminder_hour', 0 );

    add_option( 'casino_reminder_minute', 0 );

    add_option( 'casino_delay', 0 );

    casino_add_logs_table();

    if( ! wp_next_scheduled( 'casino_cron_event' ) ) wp_schedule_event( strtotime( 'tomorrow 00:00:00' ), 'daily', 'casino_cron_event' );
}

register_activation_hook( CASINO_DIR, 'casino_activate' );


function casino_add_submenu_to_settings()
{
    add_submenu_page(
        'options-general.php',
        __( 'Reminder', 'casino' ),
        __( 'Reminder', 'casino' ),
        'manage_options',
        'casino-reminder',
        'casino_reminder_settings_page'
    );
}

add_action( 'admin_menu', 'casino_add_submenu_to_settings' );


function casino_beautify_time( $time )
{
    return ( $time < 10 ? '0' : '' ) . $time;
}


function casino_reminder_settings_page()
{
    if( isset( $_POST[ 'casino_reminder_hour' ] ) && isset( $_POST[ 'casino_reminder_minute' ] ) && isset( $_POST[ 'casino_delay' ] ) )
    {
        $selected_hour = wp_unslash( $_POST[ 'casino_reminder_hour' ] );

        $selected_minute = wp_unslash( $_POST[ 'casino_reminder_minute' ] );

        update_option( 'casino_reminder_hour', $selected_hour );

        update_option( 'casino_reminder_minute', $selected_minute );

        update_option( 'casino_delay', wp_unslash( $_POST[ 'casino_delay' ] ) );

        wp_clear_scheduled_hook( 'casino_cron_event' );

        $new_start_time = strtotime( 'today ' . casino_beautify_time( $selected_hour ) . ':' . casino_beautify_time( $selected_minute ) . ':00' );

        wp_schedule_event( $new_start_time, 'daily', 'casino_cron_event' );
    }

    $selected_hour = get_option( 'casino_reminder_hour' );

    $selected_minute = get_option( 'casino_reminder_minute' );

    $delay = get_option( 'casino_delay' );

    include plugin_dir_path( CASINO_DIR ) . 'views/casino-reminder.php';
}


function casino_cron_job()
{
    global $wpdb;

    $delay = get_option( 'casino_delay' );

    $deys_before = date( 'Y-m-d H:i:s', strtotime( '-' . $delay . ' day' ) );

    $args = [
        'meta_query' => [
            [
                'key' => 'casino_last_played_at',
                'value' => $deys_before,
                'compare' => '<',
                'type' => 'DATE'
            ]
        ]
    ];

    $user_query = new WP_User_Query( $args );

    $users = $user_query -> get_results();

    foreach( $users as $user ) $wpdb -> insert( 'wp_casino_logs', [ 'user_id' => $user -> ID ] );
}

add_action( 'casino_cron_event', 'casino_cron_job' );


function casino_deactivate()
{
    wp_clear_scheduled_hook( 'casino_cron_event' );
}

register_deactivation_hook( CASINO_DIR, 'casino_deactivate' );