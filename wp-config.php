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
define('WP_CACHE', true);
define( 'WPCACHEHOME', '/var/www/public_html/wp-content/plugins/wp-super-cache/' );
define( 'DB_NAME', 'hefisag1_wp63780' );

/** Database username */
define( 'DB_USER', 'hefisag1_wp63780' );

/** Database password */
define( 'DB_PASSWORD', '100S7](pb6' );

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
define( 'AUTH_KEY',         'vbubl5z2sraz2uk4elimatiwodegwcjwa0cu6pjctwyv2uxdmhuw3yxx4z96z1bv' );
define( 'SECURE_AUTH_KEY',  'qbjw9eqvkcggtngtiv7hii6sw6zscqmhrs23ybnwrauzdmfttmow3lugprjela9x' );
define( 'LOGGED_IN_KEY',    'sutwlwuxfiqnaxns8wwqtzwftu56nsoqyhmfzh2hlvvkxe3nn5xrnabugtnlcqpj' );
define( 'NONCE_KEY',        'zofka3fxxkftgdnkdprtvxjy1kz31gfjjqbeciicgw8ntrvvri7suonfeme4lrh1' );
define( 'AUTH_SALT',        'ygfvm3hhitxzqcdc5czeinhhltykj2s8fdudpw6wlatbgurzgffniewrbtp4r2sq' );
define( 'SECURE_AUTH_SALT', 'gfbdhvjuzyxfin60somzdswsmw3rgq9qzfbiywmnjyzgfld7ryibc5lbwjowoxng' );
define( 'LOGGED_IN_SALT',   'uk8eqjxbd0cjdvdywob5cljsxxcjdaxkdstozaog2on1yz7m43gepxuhior8icpz' );
define( 'NONCE_SALT',       'acs3zt6kpfsejkwwcibjewszt3fpqaggdzc199nuilrdbawvssb6blgz22kashcg' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wpvu_';

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

define( 'WP_AUTO_UPDATE_CORE', 'minor' );


/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
