<?php

/*
 * Plugin Name:       Casino
 * Description:       Casino game.
 * Version:           1.0
 * Author:            Khayyam Musazade
 * Author URI:        https://www.linkedin.com/in/khayyam-musazade/
 * Text Domain:       casino
 * Domain Path:       /languages
 */

const CASINO_DIR = __FILE__;


add_action( 'init', 'casino_load_textdomain' );

function casino_load_textdomain()
{
    $locale = apply_filters( 'plugin_locale', determine_locale(), 'casino' );

    load_textdomain( 'casino', WP_PLUGIN_DIR . '/' . dirname( plugin_basename( __FILE__ ) ) . '/languages/casino-' . $locale . '.mo', $locale );
}


include dirname( __FILE__ ) . '/casino-shortcode.php';

include dirname( __FILE__ ) . '/casino-game.php';

include dirname( __FILE__ ) . '/casino-cron.php';