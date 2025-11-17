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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '_Nb>;E0|L31ytH8*szmq01`$!OE9JkwSPWjvip<HwhV<$hQ(=J0^Tu3o!6j5)[.U' );
define( 'SECURE_AUTH_KEY',   'vF%U{O#Fq=21BJH5;;U?8YbZw4:NCW+^~%ju&/Pnl=4L06jEC$[ro+1pZEG/~;G1' );
define( 'LOGGED_IN_KEY',     'PKwj^C*tVRW7=#|Yn+^$.,#cv;k)u.&`nDTYJUGSbT`vaAT4)W`{~gf!c]:;b?8t' );
define( 'NONCE_KEY',         '2x7s>k]A/[`;V<O.Ax7]DO5/ 4sK*X:7^^p+:t 9Of=D,2R~s2tVSl</Dba~?fVU' );
define( 'AUTH_SALT',         'QK4o{QYbwBf <5sdGL%#hN;s~z(@S4c6/:v:9KO_zXEt~gkZ.-$gmz={-A7+z)X$' );
define( 'SECURE_AUTH_SALT',  '$w|ln2,d:q(r>Bg!)WlXAtw#N!NsE@Ra,sWhQKnP$]SI1xTKI(?^pGDbWQJ97)4K' );
define( 'LOGGED_IN_SALT',    'pqDyKni;}JB.xE9.:U]mA</XEi+Q*>j*ID@(n(~r.huS,8YrC-krGW]#QQg^s=D}' );
define( 'NONCE_SALT',        '9BZFf{7 r(~o}FlY@Y!LU=yP~4KX?x1y[G1Mk?(ViHkalC9qwz1?rJh*Gg`?sU6<' );
define( 'WP_CACHE_KEY_SALT', '4?[%&lqmCE`5=S9`,`Zjl5[bj|3%jsZ$2oah}21UK$PWv+Xc%z@dOAU7/d%8JBSj' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
