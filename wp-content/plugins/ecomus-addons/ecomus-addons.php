<?php
/**
 * Plugin Name: Ecomus Addons
 * Plugin URI: http://drfuri.com/plugins/ecomus-addons.zip
 * Description: Extra elements for Elementor. It was built for Ecomus theme.
 * Version: 1.7.3
 * Author: Drfuri
 * Author URI: http://drfuri.com
 * License: GPL2+
 * Text Domain: ecomus-addons
 * Domain Path: lang/
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if ( ! defined( 'ECOMUS_ADDONS_VER' ) ) {
	define( 'ECOMUS_ADDONS_VER', '1.7.3' );
}

if ( ! defined( 'ECOMUS_ADDONS_DIR' ) ) {
	define( 'ECOMUS_ADDONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'ECOMUS_ADDONS_URL' ) ) {
	define( 'ECOMUS_ADDONS_URL', plugin_dir_url( __FILE__ ) );
}

require_once ECOMUS_ADDONS_DIR . 'vendors/kirki/kirki.php';

require_once ECOMUS_ADDONS_DIR . 'plugin.php';

\Ecomus\Addons::instance();