<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Ecomus\Addons\Elementor\Base\Products_Widget_Base;
use \Ecomus\Addons\Woocommerce\Products_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Grid widget
 */
class Product_Grid extends Products_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;
	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-product-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Products Grid', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

	/**
	 * Scripts
	 *
	 * @return void
	 */
	public function get_script_depends() {
		return [
			'ecomus-elementor-widgets'
		];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function register_controls() {
		$this->section_content();
		$this->section_style();
	}

	// Tab Content
	protected function section_content() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'products_divider',
			[
				'label' => esc_html__( 'Products', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control (
			'columns',
			[
				'label'     => esc_html__( 'Columns', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'1' => esc_html__( '1', 'ecomus-addons' ),
					'2' => esc_html__( '2', 'ecomus-addons' ),
					'3' => esc_html__( '3', 'ecomus-addons' ),
					'4' => esc_html__( '4', 'ecomus-addons' ),
					'5' => esc_html__( '5', 'ecomus-addons' ),
					'6' => esc_html__( '6', 'ecomus-addons' ),
				],
				'default'   => '4',
				'frontend_available' => true,
			]
		);

		$this->register_products_controls( 'all', true );

		$this->add_control(
			'hide_rating',
			[
				'label'     => esc_html__( 'Hide Rating', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'return_value' => 'none',
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .ecomus-rating' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'pagination',
			[
				'label' => __( 'Pagination', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'ecomus-addons' ),
				'label_on'  => __( 'Show', 'ecomus-addons' ),
				'default'   => 'yes',
			]
		);

		$this->add_control(
			'pagination_type',
			[
				'label' => __( 'Pagination Type', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'infinite' => esc_attr__( 'Infinite Scroll', 'ecomus-addons' ),
					'loadmore' => esc_attr__( 'Load More', 'ecomus-addons' ),
				],
				'default' => 'loadmore',
				'condition'   => [
					'pagination' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	// Tab Style
	protected function section_style() {
		$this->start_controls_section(
			'section_style_product',
			[
				'label' => esc_html__( 'Product', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'alignment',
			[
				'label' => __( 'Alignment', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'prefix_class' => 'ecomus-product-grid-align--',
			]
		);

		$this->add_control(
			'product_content_border',
			[
				'label'     => esc_html__( 'Border', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'ecomus-addons' ),
				'label_on'  => __( 'Show', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'ecomus-products-grid-border-'
			]
		);

		$this->add_control(
			'product_content_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.ecomus-products-grid-border-yes ul.products' => '--em-products-grid-border: {{VALUE}};',
				],
				'condition'   => [
					'product_content_border' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'product_content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product .product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} ul.products li.product .product-inner' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_columns_heading',
			[
				'label' => esc_html__( 'Columns', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'product_columns_spacing',
			[
				'label'        => esc_html__( 'Columns Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} ul.products li.product' => 'padding-left: {{SIZE}}{{UNIT}};padding-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ul.products' => 'margin-left: -{{SIZE}}{{UNIT}};margin-right: -{{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'product_rows_spacing',
			[
				'label'        => esc_html__( 'Rows Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} ul.products li.product' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_image_heading',
			[
				'label' => esc_html__( 'Product Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'product_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}}' => '--em-image-rounded-product-card: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}' => '--em-image-rounded-product-card: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_summary_heading',
			[
				'label' => esc_html__( 'Product Summary', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'product_summary_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product .product-inner .product-summary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} ul.products li.product .product-inner .product-summary' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_title_heading',
			[
				'label' => esc_html__( 'Product Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_title_typography',
				'selector' => '{{WRAPPER}} .woocommerce-loop-product__title a',
			]
		);

		$this->add_control(
			'product_title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-loop-product__title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_title_hover_color',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_price_heading',
			[
				'label' => esc_html__( 'Product Price', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .price' => 'color: {{VALUE}};',
					'{{WRAPPER}} .price del' => 'color: {{VALUE}};',
					'{{WRAPPER}} .em-price-unit' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label' => esc_html__( 'Pagination', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'pagination_spacing',
			[
				'label'        => esc_html__( 'Pagination Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'default' => [
					'size' => '',
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-pagination' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->register_button_style_controls( 'outline-dark', 'woocommerce-pagination-button' );

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', 'ecomus-product-grid' );

		if ( $settings['columns'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'ecomus-product-columns--' . $settings['columns'] );
		}

		if ( $settings['columns_tablet'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'ecomus-product-columns-tablet--' . $settings['columns_tablet'] );
		}

		if ( $settings['columns_mobile'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'ecomus-product-columns-mobile--' . $settings['columns_mobile'] );
		}

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) .'>';
			printf( '%s', self::render_products() );
		echo '</div>';
	}
}