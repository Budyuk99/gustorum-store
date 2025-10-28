<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kirill_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'MySQL-8.0' );

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
define( 'AUTH_KEY',         'IfWO2i@uorUUzPb;**0b1(DYE2)NuTpP5da8}gk dmXI5C1amw]|PmoQR7?9Cj%(' );
define( 'SECURE_AUTH_KEY',  'cgtTO)PEHzz|]k)0n^tLKi@J7}kr8.lp]^D0(5dLUK1VVQXnyb`8NwUI#x/Bxk> ' );
define( 'LOGGED_IN_KEY',    '.hfsq:MhfAPRf6Fhy?}mh^lLTI .*aX(*jr8&m;55YiTCJ*{u/Uqec}Uu*c>sX.:' );
define( 'NONCE_KEY',        'QxJO[EUb)e2X5bC*oA#V,twGD8_57]dm9p!paj /M_d?gz%fqGXD4 |VR=5`_c&E' );
define( 'AUTH_SALT',        'GH87FCjg#.l9I8DFR>dO8~$<}WZG|`Hqiqza2DKOfj};;jY{D31LZUtW97R<Bdv4' );
define( 'SECURE_AUTH_SALT', '8Zp-+K=xw3%X2$7x)Je*dMG`iL:|?`w;dBKd|J$(VVm9XJG:[>5(i>:DA9;QPc7$' );
define( 'LOGGED_IN_SALT',   'B}X{LiY7V&eKg4`,)H{vxHWngD1)t!CHOKa|1z$cR$[`1 9r;6k{thf_WN{_=JK+' );
define( 'NONCE_SALT',       '-Q0#lv6_3;r^157F;pn<+)eluRUPtuGs#0_T`Yv;,Of3D>!A<>;G1>BVyk+Igpe&' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
