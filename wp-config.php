<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'kioski');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         'GsWinLp6C+kOg0QP`aqsTG3Amq:EA3t9I!2&`(dX/RqM$O*0W2gv#iOTV`gq)mN8');
define('SECURE_AUTH_KEY',  'S9NIADGz&~41zulkW_Gl@$aT?pRahWS&3@YSfCQSAc4HJ"XcVcKl#W(;C@Z;)Xon');
define('LOGGED_IN_KEY',    'yLFr`mhuqQcKkZRDvx*|aS0K:R4^J&&MzNa:zNzz6Kf+f/f6O:U!y7#8+rhUH5J1');
define('NONCE_KEY',        '$^&`IngRO+^H"g~6h`)l7w@*H8c)?6Xbvfw"(T(hRi:7cvU9boItQx"5U~v)sp_E');
define('AUTH_SALT',        'mBdj(t*zb(u2?QzBDpH"q4!zpR4zE6$n*QcfR/tYxDL8cH&%4k@zw;r/")$"NC52');
define('SECURE_AUTH_SALT', 'yBtq+Xa"fy3(mi"$;LZybjTh:D#6f79w%34r4K%?~:(+a~9/$S(jM;:zYTJ8SY|/');
define('LOGGED_IN_SALT',   'k@RB)_EsY`IU"6Si&2(agC#E0s"WMx3sHkXkO/FCrQhftxR4Vq4LD*f4PhN"YQ1O');
define('NONCE_SALT',       'BE("G1gRsRU(::dkGRdB:Xd@SRpjNltvd_;;Dkbr;M?Wy$KvUB8l/Z~inI|96NtQ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_zcf3bx_';

/**
 * Limits total Post Revisions saved per Post/Page.
 * Change or comment this line out if you would like to increase or remove the limit.
 */
define('WP_POST_REVISIONS',  10);

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

