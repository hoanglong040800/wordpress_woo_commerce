<?php

// Configuration common to all environments
include_once __DIR__ . '/wp-config.common.php';

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'woo_commerce' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'i9`trwWPAMI_^RskzqMNoG#;c2_32X`%Y3is4!YkBge9Sh_d0-vk%E+7L8ynfDIy' );
define( 'SECURE_AUTH_KEY',  'Ln|boX@KKR@I,mZu}Wh(;ll]XMx^(Pd9Zu%VQR8(lX.ctDa*7i77v;1iS7hF${*e' );
define( 'LOGGED_IN_KEY',    '^xy-P,9o@FX|q,plLJp%p&kkVstB#*&h@35`q;yM;sHm1iA{Mu$I{7ipv~x?M,;m' );
define( 'NONCE_KEY',        'ox5nKvRak>zqy8l9YCt5O<YCDA(n!HI*lcJYLe[Ket{f{!<CIC[(ga-1)nawp>,~' );
define( 'AUTH_SALT',        ',;5|sMEs%dOyK1k#0t=%BE.#H0}+X3t+_DPYhAcFt/^)`*L}JI,tS,Aa:?KpT+V3' );
define( 'SECURE_AUTH_SALT', 'tbI5=<*9)]>5vI|ZP;0~)5EqkYSs_~F7ib;X52</or+0@@N2Aa*c_S8Kj`J16a]D' );
define( 'LOGGED_IN_SALT',   '?l9=E`~W(AJdC|!{_aIR*k@@6VWiREw+RP!R8HW2 5jrqq^?8h<^Yc,9s rhX`D/' );
define( 'NONCE_SALT',       ')oYM6cNrdlud+2`r2F8H,*ufAG)41Z$FZNyRMTzme{~cO=dNj.,Gp=gW%fL$yBGB' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
