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
define( 'DB_NAME', 'cotizamelo' );

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
define( 'AUTH_KEY',         '+rZcd;P1}{}[1|1jEF/$Bse@g1E|W[WfB7%YW:a88y3zg~=qWh`{B^2*6)ixps8Q' );
define( 'SECURE_AUTH_KEY',  ',KS5X_Z>BXMSf4pWS w)G8wTV[Ht~DQfdfTMULSlX5_)8l}nI6vsKnr7o0M=^_t%' );
define( 'LOGGED_IN_KEY',    'XV<c?drOo;Z&~h95u@uLPaVw$mHj=%8/20{ql^F;NtywpJs[4M=L[r-cnHt;/TC_' );
define( 'NONCE_KEY',        'GkMiK~>|lZs9I~67;J~T],?;fIt|x({}0n]GGLE=RmNl|K>x=_AwIk`ZM/;QC:4j' );
define( 'AUTH_SALT',        'Z-,nPF]j-JVrQj[yj5LjAV*Ik*}CZd{</6DU1:`eTum|LoI./tEY5 =+{:dmxhoV' );
define( 'SECURE_AUTH_SALT', 'Oan(N;yJS)59*cI/s8cG|@F4-Y46],jgJE9m;K7>C}bd27fp;#:|oW<QW_|P*S]/' );
define( 'LOGGED_IN_SALT',   'hLR`V,98Y:{;x3=.2dg|eAE9`E5MIW3JsBNmQT,^ta!1>iWCoIvglPTMJ/d(Ui+F' );
define( 'NONCE_SALT',       'd*r?$Z0,x3qgDP$01B?RalOC,O]&BNxq-A+W80%ALI[TSd3|I38BJ*5K]dnlWe*:' );

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
