<?php
define( 'WP_CACHE', true );
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
define( 'DB_NAME', 'u722961191_nubDJ' );

/** Database username */
define( 'DB_USER', 'u722961191_pEOvq' );

/** Database password */
define( 'DB_PASSWORD', 'NnA8mRzMac' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

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
define( 'AUTH_KEY',          'sLgwc3;!cUr,tKHu8C:l`t/ZcRg3=%Va3U6WgQ=+xRJ[l0*EoKN3cLW0`PO:^=Dq' );
define( 'SECURE_AUTH_KEY',   'HZ_fq,F/;w/w-u6qe!Te) *MXbTw>MNF[Ce9aM9D[]gY?%C]k,zy?p-z+dx&ApDR' );
define( 'LOGGED_IN_KEY',     'JTXiZTc+:=I5] t&j^<W/.aGzDAmc(FxrrF-PxE-|6l3JOqreKmouCr71[%G9F~F' );
define( 'NONCE_KEY',         'XX2LrZa&YX]?zR3P[?/JzK?@GeOeWwXu(Zp[ `rKR|1I}^Lw>mM:tDRm#FCtPQC-' );
define( 'AUTH_SALT',         'g6/[;!J Q+|!/2kJp>(-qN.gMys{opUmx.oUAXtFeE:)pH#Dg<Y9$HaGyX+Zb,oW' );
define( 'SECURE_AUTH_SALT',  'cUS:KP5D0Xx@3.Y,L2Z._7)KR$eV^Ph4@?[4dO78#x;!j#P 99FD2q^wM8rQ[J[5' );
define( 'LOGGED_IN_SALT',    ']f,J@4d3OSy?pGbu{Mgz`|3Y`^?%xl-pvEM o(d{H0.jHPai<O.[_yUK!huVM?%Y' );
define( 'NONCE_SALT',        'R2*.+YuEf?U;MtDgl%$XoC&j$&Rv(Urzn g8YB4o:81VzAGB3BzRY Q*$Nn>,8JJ' );
define( 'WP_CACHE_KEY_SALT', ':+W+hL.|Nqd/AqHm6B+Q]A:7@Pv+mR8,%m_-$z%Dbn]<5,8nOr>(pa ;DT`0iU<{' );


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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );


/* Add any custom values between this line and the "stop editing" line. */



define( 'FS_METHOD', 'direct' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
