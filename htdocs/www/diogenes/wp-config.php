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
define( 'DB_NAME', 'diogenes' );

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
define( 'AUTH_KEY',         'dhx6{S;>=r2>UJl@>G=oQkh&]cKl{~yYlMdsi/B8o;$_BH<HRa&nA~5g`]a!|)>_' );
define( 'SECURE_AUTH_KEY',  'K2=Pw[*~)=[31%r&b*Tj Xk2GQp3U?WkYnxlf(L.2b^J,VDK=imOf`J9~{vSOWUY' );
define( 'LOGGED_IN_KEY',    'bp%p&w.;g.|pT;K+`LTWqkQx!z;WTl|p(tPxbz}`mgH,buaKf ;Nkj@)T/A39=vA' );
define( 'NONCE_KEY',        ',Ba&HJI_fS9`!fV}eB@%NEC)GV+mLY?{Q[CU;}dmZ/$/=r;n#nM]&Y(RQQEeW2k>' );
define( 'AUTH_SALT',        '1_-pNM)zJ5X9*RUL_Jy.Dp*|P|9p_-q)u#:&8S*-/ikP,T$[=hiP`NF{=UA1oxOU' );
define( 'SECURE_AUTH_SALT', '(uouNBU10gjJJyj)|3bQN*<EPyob-2D ~anmjd>Aui>lF0 ]>H>u}Xz((+n_&TZg' );
define( 'LOGGED_IN_SALT',   't$NkNHY{r4 [yZd6|sQSD5rKmni*u?F{izcKNO8Rn47@h/b2H^57<r/v,1FQDVIw' );
define( 'NONCE_SALT',       'Q+G;u+$=e;#-sO*VV.ldOl5l&r ~*Wm=M@|^s/ 4m:H3_wnugD~[ji+RT?$}9Zv*' );

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
