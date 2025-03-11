<?php

namespace Ecomus\Addons\Modules\Inventory;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Main class of plugin for admin
 */
class Settings  {

	/**
	 * Instance
	 *
	 * @var $instance
	 */
	private static $instance;


	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Instantiate the object.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function __construct() {
		add_filter( 'woocommerce_inventory_settings', array( $this, 'inventory_settings' ) );
	}

	/**
	 * Free Shipping Bar section
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function inventory_settings( $settings ) {
		$custom_setting = array(
			'title'    => __('Out of Stock display', 'ecomus-addons'),
			'desc'     => __('Show out of stock products at the end of the catalog', 'ecomus-addons'),
			'id'       => 'ecomus_out_of_stock_last',
			'default'  => 'no',
			'type'     => 'checkbox',
		);

		$position = count($settings) - 2;
		array_splice($settings, $position, 0, array($custom_setting));

		return $settings;
	}
}