<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'hTE/-]rZa=T1Z;?>yK[m5f;d(<}^T0~Ns.6[K~u42Ct5y9YM3}IdEs0Cbjvr.-|8' );
define( 'SECURE_AUTH_KEY',  '.)5RX_l(m92IW S8|#{W+VA:/BmzIPE?Z=DF}LS][Q:1@?,u((?eK)t7OmSm4]!;' );
define( 'LOGGED_IN_KEY',    '6lF8wiQ-6sfUV Vh*Rfwx{E7q#g9W2>_I5}DevS%-~2l+Eliuef8Y%;A;RDu]k6J' );
define( 'NONCE_KEY',        'l[~93#4%{sS~f -#n)y_|=s]CK^1%/x,p`TIpZB`:sHxo_6!EG<LPY&10oJgpGx$' );
define( 'AUTH_SALT',        '@~@&X|e:Yk+twf7.@U<+k^plq~}~UU+MfD/U,sy.Jo)U8:liU/l(5$_QYQ6)i^lC' );
define( 'SECURE_AUTH_SALT', 'RGK7O+-1<t8@l05&kGj3_fTqi1s@stWmC*RU>Mmx(LHhe<GC5ik_C/H|H{-Q}rzE' );
define( 'LOGGED_IN_SALT',   'NF,l=S3H7FY6TDzQuo Cos)UvfntWHxKbv`)Au+(#]_[[~c)Ab ]?fO>T!KI~!<J' );
define( 'NONCE_SALT',       '/k%&D@}OM=&|W.9u4e1H!P1vntG^g$,4daOyuN1-^6?u>,)5^-I=UalYihi-CNIP' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */

date_default_timezone_set('Asia/Baku');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
