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
define( 'DB_NAME', 'appia' );

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
define( 'AUTH_KEY',         '3D,;;PsGm2!ia@vArINn:hQG,S~T..#KvCVjK:krCOlZ8||!2RN(_I7g$,6X6{*/' );
define( 'SECURE_AUTH_KEY',  'pu[G?OF:]r<SiT(/D8RHfF*IR[iH$H9asF|SR3z`VLqhw6e6Y`L&q(eaffD@w!3$' );
define( 'LOGGED_IN_KEY',    'v`%EKiO^?2ekIH-)~(VLPoi<l@.}5U|(n%/GWd2AlqGOrB6j^1~kXAgeR{D|Zk-L' );
define( 'NONCE_KEY',        'zi177l2?pr4kp[Z@_E=n(rD6Cn&D+qS.J4NEpFQ6Hw([TUwuE1&@fmXFFbQTZTEt' );
define( 'AUTH_SALT',        '#shY*qd1+A9D#EN> #c}WcF)*<sr(<GV^y)448zJl[G`e0xaZ6QYQ$Gnme@d(,`m' );
define( 'SECURE_AUTH_SALT', 'IJ{#|C-eG*W5]yVpJJ-F<;0@3%8:3S18#Ybt}hpy,.enan_d|Q3Z=JRbm|=E?? =' );
define( 'LOGGED_IN_SALT',   'ppn.C-m$?9pVkf0c!)YSMCrjW!vEB<5)u3kQy9lTP,13` Wf:0.9 CTUl1`SP8UQ' );
define( 'NONCE_SALT',       'g~ {;C7}OWzx=cNu7a~v3?0|nxo&cNx@kJI2@5@5Hw3D8#K 8yK0d. c~CQS|yiG' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
