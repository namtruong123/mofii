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
define( 'DB_NAME', 'mofii' );

/** Database username */
define( 'DB_USER', '' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         '~-u:Fm]q@U,b~mM0RY#DdH3eZ+ $}ONP;{?@7C,ZkL DP=y(k9cA:H#Qc-u6pE+c' );
define( 'SECURE_AUTH_KEY',  '+q)gG0q8oPvM#.k7 `>{7p.--%4jcTaa.vZfr|mRpKzp9Ax,YY6G/Y>}+l|*vw=R' );
define( 'LOGGED_IN_KEY',    '(pW9QGNzw3[&9U`*7yPCfgIpTAMz|~<iJfKs=9Ku ,$-%K9Q-zZQS$Eq}j|glZpX' );
define( 'NONCE_KEY',        'NUi&D+htvR|$O,nfF.^yJ@gGb!wTu@3]bc.OT@T,_i@S(]#aLK=OY{Aw&kTZ*0vx' );
define( 'AUTH_SALT',        'ZODg i6qNwx&$:;@md7Kmxw)`4S?QPMfnb%).0]EjT>D4mFf!FwVuXRuU,WKZ YO' );
define( 'SECURE_AUTH_SALT', '9WiUaG%Cff-Q>D8t7;PZSR97@+7Ko(tb@kI]]*&qU+rfhm@C|O]?. %b!|8*zB#-' );
define( 'LOGGED_IN_SALT',   'RhEvVjY:;8zC,y@8n nW-SG|#mv|)Qw!4!=LZ6eDKaDo}AD??&%9*%((;>JO[QUT' );
define( 'NONCE_SALT',       'Nf2N6?qgbS>-*_6Cv5hv?{5U/Cj(eenCvlIXF,VZ%>Us2/H0TyT9hShz0 }4o`e%' );

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
$table_prefix = 'wp_admin';

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
