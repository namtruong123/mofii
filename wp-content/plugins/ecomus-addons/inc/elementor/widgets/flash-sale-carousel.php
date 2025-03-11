<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Ecomus\Addons\Elementor\Base\Products_Widget_Base;
use Ecomus\Addons\Woocommerce\Products_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

use Ecomus\Addons\Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Flash Sale Carousel widget
 */
class Flash_Sale_Carousel extends Products_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-flash-sale';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Flash Sale Carousel', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-flash';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'ecomus-addons' ];
	}

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
		$this->section_products_settings_controls();
		$this->section_carousel_settings_controls();
	}

	// Tab Style
	protected function section_style() {
		$this->section_product_style_controls();
		$this->section_carousel_style_controls();
	}

	protected function section_products_settings_controls() {
		$this->start_controls_section(
			'section_products',
			[ 'label' => esc_html__( 'Products', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Flash Sale', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your title', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'products_divider',
			[
				'label' => esc_html__( 'Products', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_card_layout',
			[
				'label'     => __( 'Product card layout', 'ecomus-addons' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => '1',
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Total Products', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 10,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'type',
			[
				'label'     => esc_html__( 'Products', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'sale_products'   => esc_html__( 'On Sale', 'ecomus-addons' ),
					'deals'           => esc_html__( 'Product Deals', 'ecomus-addons' ),
					'recent_products' => esc_html__( 'Recent Product', 'ecomus-addons' ),
				],
				'default'   => 'recent_products',
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'menu_order' => __( 'Menu Order', 'ecomus-addons' ),
					'date'       => __( 'Date', 'ecomus-addons' ),
					'title'      => __( 'Title', 'ecomus-addons' ),
					'price'      => __( 'Price', 'ecomus-addons' ),
				],
				'condition' => [
					'type' => [ 'sale_products', 'deals' ],
				],
				'default'   => 'menu_order',
			]
		);

		$this->add_control(
			'order',
			[
				'label'     => esc_html__( 'Order', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''     => esc_html__( 'Default', 'ecomus-addons' ),
					'asc'  => esc_html__( 'Ascending', 'ecomus-addons' ),
					'desc' => esc_html__( 'Descending', 'ecomus-addons' ),
				],
				'condition' => [
					'type' => [ 'sale_products', 'deals' ],
				],
				'default'   => '',
			]
		);

		$this->add_control(
			'category',
			[
				'label'       => esc_html__( 'Product Categories', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,

			]
		);

		$this->add_control(
			'tag',
			[
				'label'       => esc_html__( 'Product Tags', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,

			]
		);

		$this->add_control(
			'brand',
			[
				'label'       => esc_html__( 'Product Brands', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,

			]
		);

		$this->add_control(
			'hide_rating',
			[
				'label'     => esc_html__( 'Hide Rating', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'return_value' => 'none',
				'default'      => 'none',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .ecomus-rating' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'hide_attributes',
			[
				'label'     => esc_html__( 'Hide Attributes', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'return_value' => 'none',
				'default'      => 'none',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-variation-items' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'show_addtocart_button',
			[
				'label'     => esc_html__( 'Show Add To Cart Button', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .em-button-add-to-cart-mobile' => 'display: inline-flex;',
				],
				'prefix_class' => 'ecomus-addtocart-button-show--',
			]
		);

		$this->add_control(
			'show_countdow_below',
			[
				'label'     => esc_html__( 'Show CountDown Below', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'return_value' => 'yes',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-thumbnail .em-product-countdown' => 'display: none;',
				],
				'prefix_class' => 'ecomus-countdown-below--',
			]
		);

		$this->end_controls_section();
	}

	protected function section_carousel_settings_controls() {
		$this->start_controls_section(
			'section_carousel_settings',
			[ 'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ) ]
		);

		$controls = [
			'slides_to_show'   => 4,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => 'dots',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls($controls);

		$this->end_controls_section();
	}

	protected function section_carousel_style_controls() {
		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel Settings', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();
	}

	protected function section_product_style_controls() {
		$this->start_controls_section(
			'section_style_content',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-flash-sale-carousel' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'      => 'content_border',
				'selector'  => '{{WRAPPER}} .ecomus-flash-sale-carousel',
			]
		);

		$this->add_control(
			'content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-flash-sale-carousel' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'content_title_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'content_title_typography',
				'selector' => '{{WRAPPER}} .ecomus-flash-sale-carousel__title h4',
			]
		);

        $this->add_control(
			'content_title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_product',
			[
				'label' => esc_html__( 'Product', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_item_heading',
			[
				'label' => esc_html__( 'Item', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'item_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel ul.products li.product .product-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-flash-sale-carousel ul.products li.product .product-inner' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'item_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel ul.products li.product .product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-flash-sale-carousel ul.products li.product .product-inner' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'item_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel ul.products li.product .product-inner' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'item_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel ul.products li.product .product-inner' => 'background-color: {{VALUE}};',
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
			'product_image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_aspect_ratio_controls();

		$this->add_responsive_control(
			'product_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-flash-sale-carousel' => '--em-image-rounded-product-card: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-flash-sale-carousel' => '--em-image-rounded-product-card: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_title_typography',
				'selector' => '{{WRAPPER}} .product-summary .woocommerce-loop-product__title',
			]
		);

        $this->add_control(
			'product_title_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-summary .woocommerce-loop-product__title a' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'product_title_color_hover',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-summary .woocommerce-loop-product__title a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_title_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-summary .woocommerce-loop-product__title' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'product_title_price',
			[
				'label' => esc_html__( 'Price', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_price_typography',
				'selector' => '{{WRAPPER}} .product-summary .price',
			]
		);

		$this->add_control(
			'product_price_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-summary .price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_price_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-summary .price' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'product_title_price_sale',
			[
				'label' => esc_html__( 'Price Sale', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_price_sale_typography',
				'selector' => '{{WRAPPER}} .product-summary .price ins',
			]
		);

		$this->add_control(
			'product_price_old_color',
			[
				'label'     => __( 'Old Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-summary .price del' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_price_sale_color',
			[
				'label'     => __( 'Sale Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-summary .price ins' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_price_sale_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .product-summary .price ins' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .product-summary .price ins' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_title_sold',
			[
				'label' => esc_html__( 'Sold bar', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_title_sold_text_position',
			[
				'label'     => esc_html__( 'Text', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'below' => esc_html__( 'Below', 'ecomus-addons' ),
					'above' => esc_html__( 'Above', 'ecomus-addons' ),
				],
				'default'   => 'below',
				'prefix_class' => 'ecomus-sold-text-position--',
			]
		);

		$this->add_control(
			'product_title_sold_text_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .deal-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_title_sold_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .product-summary .deal-sold' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'product_title_button',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_style_controls( 'outline' );

		$this->add_responsive_control(
			'product_button',
			[
				'label'     => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'vh' ],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-loop-button' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', [ 'ecomus-flash-sale-carousel', 'em-relative' ] );
		$this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );
		$this->add_render_attribute( 'inner', 'class', [ 'ecomus-flash-sale-carousel__inner', 'ecomus-carousel--elementor', 'em-relative' ] );
		$this->add_render_attribute( 'swiper', 'class', [ 'swiper' ] );
		$this->add_render_attribute( 'title', 'class', [ 'ecomus-flash-sale-carousel__title' ] );

		echo '<div ' . $this->get_render_attribute_string( 'wrapper' ) .'>';
			if ( ! empty( $settings['title'] ) ) {
				echo '<div ' . $this->get_render_attribute_string( 'title' ) . '>';
					echo \Ecomus\Addons\Helper::get_svg('flash');
					echo '<h4>'. esc_html( $settings['title'] ) .'</h4>';
				echo '</div>';
			}
			echo '<div ' . $this->get_render_attribute_string( 'inner' ) .'>';
				remove_action( 'ecomus_product_loop_thumbnail', 'woocommerce_template_loop_add_to_cart', 3 );
				if ( $settings['type'] == 'deals' ) {
					add_action( 'woocommerce_after_shop_loop_item_title', [ 'Ecomus\Addons\WooCommerce\Products_Base', 'deal_progress' ], 15 );
				}

				if( $settings['show_countdow_below'] == 'yes' ) {
					add_action( 'ecomus_after_shop_loop_item_1', [ $this, 'product_countdown' ], 20 );
				}

				add_filter( 'ecomus_add_to_cart_button_mobile_classes', array( $this, 'add_to_cart_button_classes' ) );
				echo '<div ' . $this->get_render_attribute_string( 'swiper' ) .'>';
					printf( '%s', self::render_products() );
				echo '</div>';
				remove_filter( 'ecomus_add_to_cart_button_mobile_classes', array( $this, 'add_to_cart_button_classes' ) );

				if ( $settings['type'] == 'deals' ) {
					remove_action( 'woocommerce_after_shop_loop_item_title', [ 'Ecomus\Addons\WooCommerce\Products_Base', 'deal_progress' ], 15 );
				}

				if( $settings['show_countdow_below'] == 'yes' ) {
					remove_action( 'ecomus_after_shop_loop_item_1', [ $this, 'product_countdown' ], 20 );
				}

				echo $this->render_arrows();
				echo $this->render_pagination();
			echo '</div>';
		echo '</div>';
	}

	public function add_to_cart_button_classes( $classes ) {
		$settings = $this->get_settings_for_display();

		$classes = ! empty( $settings['button_style'] ) ? 'em-button-'  . esc_attr( $settings['button_style'] ) : '';

		return $classes;
	}

	public function product_countdown() {
		$sale = \Ecomus\Addons\Helper::get_countdown_shorten_texts();

		echo \Ecomus\WooCommerce\Helper::get_product_countdown($sale);
	}
}