<?php
/**
 * Widget Image
 */

namespace Ecomus\Addons\Modules\Mega_Menu\Widgets;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Product carousel widget class
 */
class Products_Carousel extends Widget_Base {

	use \Ecomus\Addons\WooCommerce\Products_Base;

	/**
	 * Set the widget name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'products-carousel';
	}

	/**
	 * Set the widget label
	 *
	 * @return string
	 */
	public function get_label() {
		return esc_html__( 'Products Carousel', 'ecomus-addons' );
	}

	/**
	 * Default widget options
	 *
	 * @return array
	 */
	public function get_defaults() {
		return array(
			'limit'  	=> '5',
			'columns'  	=> '2',
			'type' 		=> 'recent_products',
			'category' 	=> '',
		);
	}

	/**
	 * Render widget content
	 */
	public function render() {
		$data = $this->get_data();

		$classes = $data['classes'] ? ' ' . $data['classes'] : '';

		add_filter('ecomus_product_card_layout', array($this, 'product_card_layout'));
		echo '<div class="mega-menu-products-carousel'. esc_attr( $classes ) .'" data-columns="'. esc_attr( $data['columns'] ) .'">';
		printf( '%s', $this->render_products( $data ) );
		echo '</div>';
		remove_filter('ecomus_product_card_layout', array($this, 'product_card_layout'));
	}

	public function product_card_layout() {
		return '1';
	}

	/**
	 * Widget setting fields.
	 */
	public function add_controls() {
		$this->add_control( array(
			'type' => 'number',
			'name' => 'limit',
			'label' => esc_html__( 'Number of Products', 'ecomus-addons' ),
		) );

		$this->add_control( array(
			'type' => 'number',
			'name' => 'columns',
			'label' => esc_html__( 'Columns', 'ecomus-addons' ),
		) );

		$this->add_control( array(
			'type' => 'select',
			'name' => 'type',
			'label' => esc_html__( 'Type', 'ecomus-addons' ),
			'options' => array(
				'recent_products'       => __( 'Recent Products', 'ecomus-addons' ),
				'featured_products'     => __( 'Featured Products', 'ecomus-addons' ),
				'sale_products'         => __( 'Sale Products', 'ecomus-addons' ),
				'best_selling_products' => __( 'Best Selling Products', 'ecomus-addons' ),
				'top_rated_products'    => __( 'Top Rated Products', 'ecomus-addons' ),
			),
		) );

		$this->add_control( array(
			'type' 	=> 'select',
			'name' 	=> 'category',
			'label' => esc_html__( 'Product Category', 'ecomus-addons' ),
			'class' => 'ecomus-menu-item-taxonomy-category',
			'options' => self::get_categories(),
		) );
	}

	/**
	 * Get categories
	 *
	 * @return option
	 */
	public function get_categories() {
		$terms = \Ecomus\Addons\Helper::get_terms_hierarchy( 'product_cat', '&#8212;', false );

		if ( empty( $terms ) ) {
			return;
		}

		$options = wp_list_pluck( $terms, 'name', 'term_id' );
		$options = array( '' => esc_html__( 'Choose a category', 'ecomus-addons' ) ) + $options;

		return $options;
	}

}