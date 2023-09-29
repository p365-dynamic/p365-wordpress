<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'policies365');

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
define('AUTH_KEY',         'q*.~Kv4??7w8tK,l|5P3&;S0Wh5SN*&I1}&I$izcv|LikM&:274|B%2q|.}4ECK]');
define('SECURE_AUTH_KEY',  'JJV~x2* yhs-3H[xf>jUQ1DGB:.bamgsW}Cr|ew;pa&#[Wiw(vjvDNDtn89g&HJS');
define('LOGGED_IN_KEY',    'SG.w-,~T;5zx,0~XS:X7u}#oP9|I^1`tsP@ZjtF!gaRO*MTr{Y,v[[6g~Xu}V;?T');
define('NONCE_KEY',        '$A+`GkY|xKccdo@wA}x.tOr2VcD .`5dAJ?@5J.,Mb#.:Mbs7i`i{S61j+7ct?Jn');
define('AUTH_SALT',        '/xa@*?qBDY:i9:^V$ZJuQbA~[7/BD*-*$(e4!S bHY{3jI1t$d?G&,WbG`P6M?^m');
define('SECURE_AUTH_SALT', '2/Z%<qeNc?E4H5]L1SGl,wqzBqwdE6,p^x9a2,G3eQqc#&)$=%bzmh0sp=9lkRBe');
define('LOGGED_IN_SALT',   'JPly},El#.S*i.5k&%9;@s.r2dhhP6I>ZUuL/pAqfy%o@4mQ2/nBI3.JD#1?r-Z]');
define('NONCE_SALT',       'J+_1]yyCNM0J:W^Y_nqQ;(Yf8OFV`@t2gQ!Ej!+D}p,Ohw;Wv>j`MFx~zVhg;w/{');

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

