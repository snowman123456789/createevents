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
define('DB_NAME', 'firstwebsite');

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
define('AUTH_KEY',         'A#}DV)hC!R;&.v. P;KuH!}{jD~tccw-2iLgV2+Wuk}o4m[PT^Z@<>+eO}n>hxR5');
define('SECURE_AUTH_KEY',  ']|4d]x/S=ShXLY6m3Y7jMs6|1h0JV^A7.%P;R]VoA*xj3B|PvTyn]Mmw:VLm@_F ');
define('LOGGED_IN_KEY',    'cutP<*J!jA>.:nBbymRLCWRpsa4ohw`Fea>.XcQWsK4?ea??w4,`Y#QbQi!9!W:M');
define('NONCE_KEY',        'N~3i]-:v1:dXc_H!OZh*oE67gv2BU#Ydh(tRhBijZB|<t0v487_$Onopo)+>+BF,');
define('AUTH_SALT',        'tF9+a%wbol];M5A2n?TKV1h#>/DhsMy%Q8(@+}%,mb?BIe+!:R9Q{Ay/EXwho=Sy');
define('SECURE_AUTH_SALT', 'NWs,hXWY5PFXYdQ:|!c=$o1D9R0oE+,,~!?8o=WNK?FSbsu,I_Zy@ds[(v.,]#Br');
define('LOGGED_IN_SALT',   'ci[l3]YL7[2(3M}N(FADiiFf_E*x6enyU< TVEuFOL~{7V)wZ8t0+O6eV8Ou2za:');
define('NONCE_SALT',       '=OA>_r64$N.&`j>Vi+84gV.fbNObI^*T^Mg&!R]byh/Sr?UD&XKSeig8Y?F{J)nl');

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
