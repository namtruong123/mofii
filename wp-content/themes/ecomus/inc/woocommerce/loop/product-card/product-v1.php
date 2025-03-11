<?php
/**
 * Product Card v1 hooks.
 *
 * @package Ecomus
 */

 namespace Ecomus\WooCommerce\Loop\Product_Card;

use Ecomus\Helper;
use Ecomus\Icon;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Class of Product Card v1
 */
class Product_V1 extends Base {
	/**
	 * Instance
	 *
	 * @var $instance
	 */
	protected static $instance = null;

	/**
	 * Initiator
	 *
	 * @since 1.0.0
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
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
		add_action( 'ecomus_product_loop_thumbnail_1', array( $this, 'product_featured_icons_open' ), 5 );
		add_action( 'ecomus_product_loop_thumbnail_1', 'woocommerce_template_loop_add_to_cart', 10 );

		add_action( 'ecomus_product_loop_thumbnail_1', array( $this, 'product_featured_icons_close' ), 90 );

		add_action( 'ecomus_after_shop_loop_item_1', array( $this, 'product_add_to_cart_mobile' ), 30 );
	}

}
