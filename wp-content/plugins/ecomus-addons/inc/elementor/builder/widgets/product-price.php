<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Price extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-price';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Price', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-price';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'price', 'product' ];
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
			'section_price_style',
			[
				'label' => esc_html__( 'Price', 'ecomus-addon' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'gap',
			[
				'label' => __( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
					]
				],
				'default' => [],
				'selectors' => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .price' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addon' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .price',
			]
		);

		$this->add_control(
			'sale_heading',
			[
				'label' => esc_html__( 'Sale Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sale_price_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addon' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'ecomus-addon' ),
				'name' => 'sale_price_typography',
				'selector' => '.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .price ins',
			]
		);

		$this->add_control(
			'old_heading',
			[
				'label' => esc_html__( 'Old Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'old_price_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addon' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'ecomus-addon' ),
				'name' => 'old_price_typography',
				'selector' => '.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .price del',
			]
		);

		$this->add_control(
			'suffix_heading',
			[
				'label' => esc_html__( 'Suffix', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'suffix_price_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addon' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .woocommerce-price-suffix' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'ecomus-addon' ),
				'name' => 'suffix_price_typography',
				'selector' => '.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .woocommerce-price-suffix',
			]
		);

		$this->add_control(
			'sale_off_heading',
			[
				'label' => esc_html__( 'Sale Off', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => esc_html__( 'Typography', 'ecomus-addon' ),
				'name' => 'sale_off_typography',
				'selector' => '.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .sale-off',
			]
		);

		$this->add_control(
			'sale_off_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addon' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .sale-off' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sale_off_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addon' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .sale-off' => 'backgroundcolor: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sale_off_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .sale-off' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .sale-off' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'sale_off_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .sale-off' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart.single-product.single-product-elementor div.product {{WRAPPER}} .ecomus-product-price .sale-off' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
		global $product;
		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		if( function_exists('woocommerce_template_single_price') ) {
			add_filter( 'woocommerce_format_sale_price', array( $this, 'format_sale_price' ), 10, 3 );
			add_filter( 'woocommerce_variable_price_html', array( $this, 'format_variable_price' ), 10, 2 );

			echo '<div class="ecomus-product-price">';
				woocommerce_template_single_price();
			echo '</div>';

			remove_filter( 'woocommerce_format_sale_price', array( $this, 'format_sale_price' ), 10, 3 );
			remove_filter( 'woocommerce_variable_price_html', array( $this, 'format_variable_price' ), 10, 2 );
		}
	}

	/**
	 * Format a sale price for display.
	 *
	 * @param  string $regular_price Regular price.
	 * @param  string $sale_price    Sale price.
	 * @return string
	 */
	public function format_sale_price( $price, $regular_price, $sale_price ) {
		if( empty( $regular_price ) || empty( $sale_price ) ) {
			return $price;
		}

		if(  $regular_price <  $sale_price ) {
			return $price;
		}

		if(  ! is_numeric($regular_price) || ! is_numeric($sale_price) ) {
			return $price;
		}

		$sale_percentage      = round( ( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) );
		return $this->price_save( $price, $sale_percentage );

	}

	/**
	 * Format Variable Price
	 *
	 * @param string $regular_price
	 * @param string $sale_price
	 * @return void
	 */
	public function format_variable_price($price, $product) {
		$available_variations = $product->get_available_variations();
		$sale_percentage = 0;
		foreach ( $available_variations as $variation_product ) {
			$regular_price       = $variation_product['display_regular_price'];
			$sale_price         = $variation_product['display_price'];
			$variation_sale_percentage      = $regular_price && $sale_price ? round( ( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 ) ) : 0;

			if ( $variation_sale_percentage > $sale_percentage ) {
				$sale_percentage = $variation_sale_percentage;
			}
		}
		return $this->price_save( $price, $sale_percentage );
	}

	/**
	 * Price Save
	 *
	 * @param string $regular_price
	 * @param string $sale_price
	 * @return void
	 */
	public  function price_save( $price, $sale_percentage ) {
		if( empty( $sale_percentage ) ) {
			return $price;
		}

		$sale_percentage = apply_filters( 'ecomus_sale_percentage' , $sale_percentage . '%' . ' ' . esc_html('OFF', 'ecomus'), $sale_percentage );

		return  $price . '<span class="sale-off em-font-bold">' . $sale_percentage . '</span>';
	}
}
