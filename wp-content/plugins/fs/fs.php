<?php

/*
 * Plugin Name:       FS Project
 * Description:       Shares posts on Facebook when published.
 * Version:           1.9
 * Author:            Khayyam Musazade
 * Author URI:        https://www.linkedin.com/in/khayyam-musazade/
 * Text Domain:       fs
 * Domain Path:       /languages
 */


function fs_add_logs_table()
{
    global $wpdb;

    $charset_collate = $wpdb -> get_charset_collate();

    $sql = "CREATE TABLE wp_fs_logs (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                post_id mediumint(9) NOT NULL,
                post_title varchar(255) NOT NULL,
                post_link varchar(255) NOT NULL,
                shared_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
            ) $charset_collate;";

    $wpdb -> query( $sql );
}

function fs_activate()
{
    fs_add_logs_table();

    add_option( 'fs_categories', '{ "selected" : [] }' );
}

register_activation_hook( __FILE__, 'fs_activate' );


add_action( 'admin_menu', 'fs_menu' );

function fs_menu()
{
    add_menu_page( __( 'FS Project', 'fs' ), __( 'FS Project', 'fs' ), 'read', 'fs', null, null, 2 );

    add_submenu_page( 'fs', __( 'Settings', 'fs' ), __( 'Settings', 'fs' ), 'read', 'fs-categories', 'fs_view_categories' );

    add_submenu_page( 'fs', __( 'Logs', 'fs' ), __( 'Logs', 'fs' ), 'read', 'fs-logs', 'fs_view_logs' );

    remove_submenu_page( 'fs', 'fs' );
}

function fs_view_categories()
{
    if( isset( $_POST[ 'fs_categories' ] ) ) update_option( 'fs_categories', json_encode( [ 'selected' => wp_unslash( $_POST[ 'fs_categories' ] ) ] ) );

    $categories = fs_get_categories();

    include plugin_dir_path( __FILE__ ) . 'views/categories.php';
}

function fs_view_logs()
{
    global $wpdb;

    $logs = $wpdb -> get_results( 'SELECT * FROM wp_fs_logs;' );

    include plugin_dir_path( __FILE__ ) . 'views/logs.php';
}


function fs_get_categories()
{
    $categories = get_categories();

    $selected_categories = json_decode( get_option( 'fs_categories' ) ) -> selected;

    foreach( $categories as $k => $category ) $categories[ $k ] -> selected = in_array( $category -> slug, $selected_categories );

    return $categories;
}


add_action( 'save_post', 'fs_share_post', 10, 3 );

function fs_share_post( $post_id, $post )
{
    global $wpdb;

    if( $post -> post_type == 'post' && $post -> post_status == 'publish' && $post -> post_date == $post -> post_modified )
    {
        $share = false;

        $selected_categories = json_decode( get_option( 'fs_categories' ) ) -> selected;

        foreach( get_the_category( $post_id ) as $category )
        {
            if( in_array( $category -> slug, $selected_categories ) )
            {
                $share = true;

                break;
            }
        }

        if( $share )
        {
            $wpdb -> insert( 'wp_fs_logs', [
                'post_id' => $post_id,
                'post_title' => $post -> post_title,
                'post_link' => $post -> guid
            ] );
        }
    }
}


add_action( 'admin_enqueue_scripts', 'fs_admin_enqueue' );
function fs_admin_enqueue( $hook )
{
    if( $hook != 'fs-project_page_fs-logs' ) return;

    wp_enqueue_script(
        'ajax-script',
        plugins_url( '/scripts/fs.js', __FILE__ ),
        [ 'jquery' ],
        '1.0.0',
        [
            'in_footer' => true,
        ]
    );
}


add_action( 'wp_ajax_fs_remove_log', 'fs_remove_log' );

function fs_remove_log()
{
    global $wpdb;

    $id = wp_unslash( $_POST[ 'fs_log_id' ] );

    $wpdb -> delete( 'wp_fs_logs', [ 'id' => $id ] );

    wp_die();
}


add_action( 'init', 'fs_load_textdomain' );

function fs_load_textdomain()
{
    $locale = apply_filters( 'plugin_locale', determine_locale(), 'fs' );

    load_textdomain( 'fs', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/fs-' . $locale . '.mo', $locale );
}


function fs_style()
{
    wp_enqueue_style( 'style', plugins_url( '/shortcode/fs-shortcode.css', __FILE__ ) );
}

add_action( 'wp_enqueue_scripts', 'fs_style' );


include dirname( __FILE__ ) . '/shortcode/fs-shortcode.php';