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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'bcoins');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '{S?`F!lQON|)R A0,Pm;8THE%iz7_o;C&.fLp1FR<~gY6PX6m,(y5<sds+0,.L[$');
define('SECURE_AUTH_KEY',  '![+nlUM:j){zf){*`4sNQ`0W5>Qx)b7E$9mr}pU0cRq(:X2p s=vj_q2>h`?=+m#');
define('LOGGED_IN_KEY',    'G*FYujSLrElx:OM<J/.XnDV_cShP[wu+AgSp@(I~lp1oWLEqxDb E[ D],:^olmL');
define('NONCE_KEY',        'MDo:ErZVo6#y;,Up&@cL?r|#WTlU|?&2hFBqBwA(dEmdexN(<jaKs_-3L]V4k=y7');
define('AUTH_SALT',        ',i]E(gVVg$&r@]oq|_:(bG]CGbZFeOde#=G@aR_<*6d**}c!6bIzax^)cf4{@D/(');
define('SECURE_AUTH_SALT', ',^_IR>1[XLkd:|,lVZ7Z-rTKSbQ[1,K]/O7<<C5_dv{1Q8(:hV`Z;}dIu)s )O&J');
define('LOGGED_IN_SALT',   '>HR,Ny2`IPDm}l>)0NaI H_wvPElD@4SsS(Qe%E0c*u7h@&<3ID[cvA@x>4rH(s1');
define('NONCE_SALT',       'YJMCx D[Mg_tL,7j^ohiu`(zy8Mtj`CEF&{WE],Yfexep0ZGa)@{_t[BmEx/p#V`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
