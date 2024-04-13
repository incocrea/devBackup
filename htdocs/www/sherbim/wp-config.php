<?php
/** 
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define('DB_NAME', 'sherbim');

/** Tu nombre de usuario de MySQL */
define('DB_USER', 'root');

/** Tu contraseña de MySQL */
define('DB_PASSWORD', '');

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define('DB_HOST', 'localhost');

/** Codificación de caracteres para la base de datos. */
define('DB_CHARSET', 'utf8mb4');

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', ']yAAsS)H)lmjZ1nHHcC%ptU+zG{_VVSr5aVVWN[@S]iFB`vCS6biTOUX_vlFiMR9');
define('SECURE_AUTH_KEY', 'sO$_=v/bZ@35c< d|8NV<Yf{</8Q}U m]lU1}hc_Q+n+}Je+6G[5DTt0}bHNPSy?');
define('LOGGED_IN_KEY', '!;/BW9+i$wtZ[mTA9vG0_hu;7qPYgFiD`[5Yo]o@WD=u3EeBj)up: h3k?s`zeEg');
define('NONCE_KEY', 'a6u4Ie2f|hO Fw74?y.c;WBvvrfMB0o[.3]Z~.oa<^oS @ * rP!Vz70:T$oG,K.');
define('AUTH_SALT', 'uC2-U~hCy]gY1Qz/.&%SOG%,c4*`,d5#gk.89q(/RP(WeFeJO,axcWHB0,8:SwTa');
define('SECURE_AUTH_SALT', 'r!?%2+8Gn;waw4m}nV#G/dSPI9UQ{}$a:KKcuY}5BXr<LHJ6hmmh<ie7d%1dN947');
define('LOGGED_IN_SALT', '(:f2$Z}:E;IM]zU`wmO$:=cuCHb%md5z!]!4*eC[MDwc.@5Dvj]2~&lVKKNjgY=n');
define('NONCE_SALT', '_MiI*7.hq9VWn}EtyDbiXSx==TQic[bK`F2)UaPpq.1?Bh1Vl_7Z=kY$nNMj(OuA');

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix  = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

