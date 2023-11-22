<?php

function fs_shortcode( $atts = [], $content = null, $tag = '' )
{
    global $wpdb;

    $logs = $wpdb -> get_results( 'SELECT * FROM wp_fs_logs;' );

    $logs_content = '';

    foreach( $logs as $log )
    {
        $logs_content .= '<tr>
                            <td>' . $log -> id . '</td>
                            <td>' . $log -> post_id . '</td>
                            <td>' . $log -> post_title . '</td>
                            <td>
                                <a
                                    target="_blank"
                                    href="' . $log -> post_link . '"
                                >
                                    ' . $log -> post_link . '
                                </a>
                            </td>
                            <td>' . $log -> shared_at . '</td>
                            <td>
                                <form class="fs_remove_log">
                                    <input type="hidden" name="fs_log_id" value="' . $log -> id . '">
                                    <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="❌"></p>
                                </form>
                            </td>
                        </tr>';
    }

    $atts = array_change_key_case( (array)$atts, CASE_LOWER );

    $fs_atts = shortcode_atts( [
        'style' => 'light',
    ], $atts, $tag );

    return '<table class="form-table fs-theme-' . esc_html( $fs_atts[ 'style' ] ) . '">
                <thead>
                    <tr>
                        <th>' . __( 'ID', 'fs' ) . '</th>
                        <th>' . __( 'Post ID', 'fs' ) . '</th>
                        <th>' . __( 'Post title', 'fs' ) . '</th>
                        <th>' . __( 'Post link', 'fs' ) . '</th>
                        <th>' . __( 'Date', 'fs' ) . '</th>
                        <th>' . __( 'Delete', 'fs' ) . '</th>
                    </tr>
                </thead>
                <tbody>
                    ' . $logs_content . '
                </tbody>
            </table>';
}

function fs_shortcode_init()
{
    add_shortcode( 'fs', 'fs_shortcode' );
}

add_action( 'init', 'fs_shortcode_init' );


function fs_shortcode_enqueue_block_editor_assets()
{
    wp_enqueue_script( 'fs-select-block', plugin_dir_url( __FILE__ ) . 'fs-shortcode.js', [
            'wp-blocks',
            'wp-editor',
            'wp-components',
            'wp-i18n'
        ], '1.0', true );
}

add_action( 'enqueue_block_editor_assets', 'fs_shortcode_enqueue_block_editor_assets' );