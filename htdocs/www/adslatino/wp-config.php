<?php
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
define( 'DB_NAME', 'adslatino' );

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
define( 'AUTH_KEY',         '6aM<`|la)*Vst1?x0o!$q#PM2++1ohQC9b[sm=,n%KD7;r]rc?K|kSCVdSfME`[7' );
define( 'SECURE_AUTH_KEY',  'lvT+mE~4yHe&m@+LX`+HKz$7FzoR43r^|_2 d1 VZF0tq/M]r[f96!qgcZk8a[`P' );
define( 'LOGGED_IN_KEY',    'Z]gSJOA}ij@-q({c&R;[C0]5Uj$+,8Q{pg;Xze21w>VqH[<G>[/^T40ndV=}~943' );
define( 'NONCE_KEY',        '(_b/@mah-YzG<>M6{n`6x(6Wo+Y*1=[gN.JC`MMkVYU1--eqm#hF2C`:rK?lNUt{' );
define( 'AUTH_SALT',        '<=h|xdP6m?QR}#xj8]k/j3E^A/</=SeZHwvO*3,`}apI6bGG|D5KwHYCskC=.oZr' );
define( 'SECURE_AUTH_SALT', '2Js(-#2#<@K1d6S^d)]3N2?s1DJ01PZeHKt}y%nNaEdp-FD5Y/{zp=!h /<KzIF#' );
define( 'LOGGED_IN_SALT',   '&Iv>GATgB-P>2RcLn3V~sEw2M4FZPc8E!Oc ;e^;?z[HEp9`r(%NwLGF*|v[}Ru#' );
define( 'NONCE_SALT',       'b{1Uj,2Fo`G~UiYN@M3 I(r3]|9E!8{h8Q#rd4}rYjhX02~n(!.fe:oY(;x8L{zu' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ad_';

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
