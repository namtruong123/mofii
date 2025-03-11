<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Categories extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-categories';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Categories', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-meta';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'categories', 'product' ];
	}

	/**
	 * Get HTML wrapper class.
	 *
	 * Retrieve the widget container class. Can be used to override the
	 * container class for specific widgets.
	 *
	 * @since 2.0.9
	 * @access protected
	 */
	protected function get_html_wrapper_class() {
		return 'elementor-widget-' . $this->get_name() . ' entry-summary';
	}

	/**
	 * Register heading widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 3.1.0
	 * @access protected
	 */
	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[ 'label' => __( 'Content', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'category_text',
			[
				'label' => __( 'Category Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Category:', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'categories_text',
			[
				'label' => __( 'Categories Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Categories:', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} .posted_in',
			]
		);

		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posted_in' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'categories_heading',
			[
				'label' => esc_html__( 'Categories', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'categories_typography',
				'selector' => '{{WRAPPER}} .posted_in a',
			]
		);

		$this->add_control(
			'categories_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posted_in a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'categories_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .posted_in a:hover' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
	}

	/**
	 * Render heading widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		global $product;

		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		$text = ! empty( $settings['category_text'] ) ? $settings['category_text'] : esc_html__( 'Category:', 'ecomus' );
		$texts = ! empty( $settings['categories_text'] ) ? $settings['categories_text'] : esc_html__( 'Categories:', 'ecomus' );

		echo '<div class="product_meta">';
			echo wc_get_product_category_list( $product->get_id(), ', ', '<span class="posted_in">' . _n( $text, $texts, count( $product->get_category_ids() ), 'ecomus' ) . ' ', '</span>' );
		echo '</div>';
	}
}
