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
define('DB_NAME', 'db_gramcoin');

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
define('AUTH_KEY',         '8-e-DT|W#@YB@+l>>V+=`1n(dj-Z+x<K|Q%j,BOk?59KtJotXTxpZPQ^l3m32YqG');
define('SECURE_AUTH_KEY',  'W4&mpc$@e5|j~e;r&{xUI|N_-C2_Q!cdrOyLHye} A-% CX2?zWeHt(;#~!ZhtcN');
define('LOGGED_IN_KEY',    'zFn]1J-/hL1{93,|Q%DoSMR#epnBUo.PpM<>{4@I(OAk_gFU3CWjYkavF_}{V3{^');
define('NONCE_KEY',        ' ufZ4FSZNC]Kk]8d}!gjJc]l/@uZ&B+`X;/or]c*zY^V.ZC7Ii,T`.Dn_9Q^v9K_');
define('AUTH_SALT',        'WRmROGR*BaJj~C|Hpi;&m4EU0`(0Y3Y$Fm_G!` ~|i`7Dee-Z1eH7O1]O~pmYPPP');
define('SECURE_AUTH_SALT', '``FFLu<MK-<]4Citl-cFJ~LeQXR}Ri6OwP{NPj!)wX!x=r8Va#^y2{G_3Hw3|eka');
define('LOGGED_IN_SALT',   'ux3`L1@xW46:0s8(zUjEtzl,O&rIj!ggYKQ7GKIDo# bvJhXO5G;R!I+nR>,E_A_');
define('NONCE_SALT',       'S pI-/Q>K@oI~@_EjTo[=Ey*f[FYWg2H$bcBPf;(9W@wopBhT@qR=1ezjNX+,@Bs');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wpgc_';

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
