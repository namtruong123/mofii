<?php
namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Ecomus\Addons\Elementor\Base\Products_Widget_Base;
use Elementor\Icons_Manager;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product price tables Carousel
 */
class Product_Price_Tables_Carousel extends Products_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * product_details
	 *
	 * @var $product_details
	 */
	protected static $product_details = [];

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-product-price-tables-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Product Price Tables Carousel', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-carousel';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return ['ecomus-addons'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'products carousel', 'product', 'price', 'table', 'carousel', 'woocommerce', 'ecomus-addons' ];
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
		$this->section_content_products();
		$this->section_content_carousel();
	}

	protected function section_content_products() {
		$this->start_controls_section(
			'section_products',
			[
				'label' => __( 'Products', 'ecomus-addons' ),
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'product_id',
			[
				'label' => __( 'Products', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => false,
				'source'      => 'product',
				'sortable'    => true,
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'ecomus-addons' ),
				'type'    => Controls_Manager::TEXTAREA,
			]
		);

		$repeater->add_control(
			'button_text',
			[
				'label'       => __( 'Text', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'default'     => __( 'Click here', 'ecomus-addons' ),
				'placeholder' => __( 'Click here', 'ecomus-addons' ),
			]
		);

		$repeater->add_control(
			'highlight',
			[
				'label'       => esc_html__( 'Featured', 'ecomus-addons' ),
				'type'        => Controls_Manager::SWITCHER,
			]
		);

        $this->add_control(
			'products',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'prevent_empty' => false,
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
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-variation-items' => 'display: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'order_product_summary',
			[
				'label' => esc_html__( 'Order of items in the product summary', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'order_text',
			[
				'label' => esc_html__( 'Product Text', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 1,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__text' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'order_product_rating',
			[
				'label' => esc_html__( 'Product Rating', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 2,
				'selectors' => [
					'{{WRAPPER}} .ecomus-rating' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'order_product_name',
			[
				'label' => esc_html__( 'Product Name', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 3,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-loop-product__title' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'order_product_attributes',
			[
				'label' => esc_html__( 'Product Attributes', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 4,
				'selectors' => [
					'{{WRAPPER}} .product-variation-items' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'order_product_price',
			[
				'label' => esc_html__( 'Product Price', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 5,
				'selectors' => [
					'{{WRAPPER}} .price' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'order_description',
			[
				'label' => esc_html__( 'Product Description', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 6,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__description' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'order_button',
			[
				'label' => esc_html__( 'Product Button', 'ecomus-addons' ),
				'type' => Controls_Manager::NUMBER,
				'min' => 1,
				'max' => 10,
				'step' => 1,
				'default' => 7,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__button' => 'order: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_control',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_button_icon_controls();

		$this->end_controls_section();
	}

	protected function section_content_carousel() {
		$this->start_controls_section(
			'section_products_carousel',
			[
				'label' => __( 'Carousel Settings', 'ecomus-addons' ),
			]
		);

		$controls = [
			'slides_to_show'   => 3,
			'slides_to_scroll' => 1,
			'space_between'    => 30,
			'navigation'       => '',
			'autoplay'         => '',
			'autoplay_speed'   => 3000,
			'pause_on_hover'   => 'yes',
			'animation_speed'  => 800,
			'infinite'         => '',
		];

		$this->register_carousel_controls( $controls );

		$this->add_responsive_control(
			'slidesperview_auto',
			[
				'label' => __( 'Slides Per View Auto', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Off', 'ecomus-addons' ),
				'label_on'  => __( 'On', 'ecomus-addons' ),
				'default'   => '',
				'responsive' => true,
				'frontend_available' => true,
				'prefix_class' => 'ecomus%s-slidesperview-auto--'
			]
		);

		$this->end_controls_section();
	}

	// Tab Content
	protected function section_style() {
		$this->section_style_product();
		$this->section_style_product_featured();
		$this->section_style_carousel();
	}

	protected function section_style_product() {
		$this->start_controls_section(
			'section_product_style',
			[
				'label'     => __( 'Product', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_item_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-summary' => 'background-color: {{VALUE}};',
				],
			]
		);



		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'product_item_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} ul.products li.product .product-inner',
			]
		);

		$this->add_responsive_control(
			'product_item_padding',
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

		$this->add_responsive_control(
			'product_item_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product .product-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} ul.products li.product .product-inner' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
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

		$this->register_aspect_ratio_controls();

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
			'product_featured_button_heading',
			[
				'label' => esc_html__( 'Product Featured Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_product_featured_button_style' );

		$this->start_controls_tab(
			'tab_product_featured_button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_featured_button_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .button' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_bg_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .button' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .button' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_product_featured_button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_featured_button_color_hover',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .button' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_bg_color_hover',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .button' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_border_color_hover',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .button' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
			'product_text_heading',
			[
				'label' => esc_html__( 'Product Text', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_text_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-price-tables-carousel__text',
			]
		);

		$this->add_control(
			'product_text_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__text' => '--em-color__base: {{VALUE}}; --em-color__dark: {{VALUE}}; --em-heading-color: {{VALUE}}; --em-link-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_text_spacing',
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
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__text' => 'margin-top: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}} .woocommerce-loop-product__title' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'product_attributes_heading',
			[
				'label' => esc_html__( 'Product Attributes', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_attributes_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-variation-items .product-variation-item' => '--em-variation-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_attributes_border_hover_color',
			[
				'label'     => __( 'Border Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-variation-items .product-variation-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_attributes_spacing',
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
					'{{WRAPPER}} ul.products li.product .product-variation-items' => 'margin-top: {{SIZE}}{{UNIT}}',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_price_typography',
				'selector' => '{{WRAPPER}} ul.products li.product .price',
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
				],
			]
		);

		$this->add_control(
			'product_price_color_del',
			[
				'label'     => __( 'Old Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .price del' => '--em-price-del-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_price_color_ins',
			[
				'label'     => __( 'Sale Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .price ins' => '--em-color-price-sale: {{VALUE}};',
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
					'{{WRAPPER}} ul.products li.product .price' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'product_description_heading',
			[
				'label' => esc_html__( 'Product Description', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_description_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_description_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-price-tables-carousel__description' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'product_description_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-price-tables-carousel__description' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'product_description_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-product-price-tables-carousel__description',
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

		$this->register_button_style_controls( '', 'ecomus-product-price-tables-carousel__button' );

		$this->add_responsive_control(
			'product_button_spacing',
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
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__button' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function section_style_product_featured() {
		$this->start_controls_section(
			'section_style_product_featured',
			[
				'label'     => __( 'Product Featured', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_item_background_color_highlight',
			[
				'label'     => __( 'Highlight Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product.ecomus-product-price-tables-carousel__highlight .product-summary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_heading_highlight',
			[
				'label' => esc_html__( 'Product Featured Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_product_featured_button_highlight_style' );

		$this->start_controls_tab(
			'tab_product_featured_button_highlight_normal',
			[
				'label' => __( 'Highlight', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_featured_button_color_highlight',
			[
				'label'     => __( 'Highlight Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .product-featured-icons .button' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_bg_color_highlight',
			[
				'label'     => __( 'Highlight Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .product-featured-icons .button' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_border_color_highlight',
			[
				'label'     => __( 'Highlight Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .product-featured-icons .button' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_product_featured_button_highlight_hover',
			[
				'label' => __( 'Highlight Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_featured_button_color_hover_highlight',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .product-featured-icons .button' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_bg_color_hover_highlight',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .product-featured-icons .button' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_border_color_hover_highlight',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .product-featured-icons .button' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_featured_button_background_effect_hover_color_highlight',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .product-featured-icons .button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'product_text_heading_highlight',
			[
				'label' => esc_html__( 'Product Text', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_text_color_highlight',
			[
				'label'     => __( 'Highlight Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__text' => '--em-color__base: {{VALUE}}; --em-color__dark: {{VALUE}}; --em-heading-color: {{VALUE}}; --em-link-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_title_heading_highlight',
			[
				'label' => esc_html__( 'Product Title', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_title_color_highlight',
			[
				'label'     => __( 'Highlight Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .woocommerce-loop-product__title a' => '--em-color__dark: {{VALUE}}; --em-heading-color: {{VALUE}}; --em-link-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_attributes_heading_highlight',
			[
				'label' => esc_html__( 'Product Attributes', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_attributes_border_color_highlight',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product.ecomus-product-price-tables-carousel__highlight .product-variation-items .product-variation-item' => '--em-variation-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_attributes_border_hover_color_highlight',
			[
				'label'     => __( 'Border Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product.ecomus-product-price-tables-carousel__highlight .product-variation-items .product-variation-item:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_price_heading_highlight',
			[
				'label' => esc_html__( 'Product Price', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_price_color_highlight',
			[
				'label'     => __( 'Highlight Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_price_color_del_highlight',
			[
				'label'     => __( 'Highlight Old Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .price del' => '--em-price-del-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_price_color_ins_highlight',
			[
				'label'     => __( 'Highlight Sale Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .price ins' => '--em-color-price-sale: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_description_heading_highlight',
			[
				'label' => esc_html__( 'Product Description', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_description_color_highlight',
			[
				'label'     => __( 'Highlight Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'product_description_border_highlight',
				'label' => esc_html__( 'Border Hightlight', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__description',
			]
		);

		$this->add_control(
			'product_button_highlight',
			[
				'label' => esc_html__( 'Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_button_highlight_style' );

		$this->start_controls_tab(
			'tab_button_highlight_normal',
			[
				'label' => __( 'Highlight', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_button_color_highlight',
			[
				'label'     => __( 'Highlight Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__button' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_button_bg_color_highlight',
			[
				'label'     => __( 'Highlight Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__button' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_button_border_color_highlight',
			[
				'label'     => __( 'Highlight Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__button' => '--em-button-border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_highlight_hover',
			[
				'label' => __( 'Highlight Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_button_color_hover_highlight',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__button' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_button_bg_color_hover_highlight',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__button' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_button_border_color_hover_highlight',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__button' => '--em-button-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_button_background_effect_hover_color_highlight',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-price-tables-carousel__highlight .ecomus-product-price-tables-carousel__button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
				'condition' => [
					'button_style' => ['']
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function section_style_carousel() {
		$this->start_controls_section(
			'section_style_carousel',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', [
			'ecomus-product-price-tables-carousel',
			'ecomus-products-carousel--elementor',
			'ecomus-carousel--elementor',
			'ecomus-carousel--slidesperview-auto'
		] );

		$this->add_render_attribute( 'wrapper', 'style', [ $this->render_aspect_ratio_style() ] );

		$product_ids = [];

		if( ! empty( $settings['products'] ) ) {
			foreach( $settings['products'] as $product ) {
				if( ! empty( $product['product_id'] ) ) {
					$product_ids[] = $product['product_id'];

					if( ! empty( $product['description'] ) ) {
						self::$product_details['description'][$product['product_id']] = $product['description'];
					}

					if( ! empty( $product['button_text'] ) ) {
						self::$product_details['button'][$product['product_id']] = [ 'button_classes' => ' ecomus-product-price-tables-carousel__button', 'button_text' => $product['button_text'] ];
					}

					if( ! empty( $product['text'] ) ) {
						self::$product_details['text'][$product['product_id']] = $product['text'];
					}

					if( ! empty( $product['highlight'] ) ) {
						self::$product_details['highlight'][$product['product_id']] = $product['highlight'];
					}
				}
			}
		}

		$col = ! empty( $settings['slides_to_show'] ) ? $settings['slides_to_show'] : 3;
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col_tablet;

		$settings = [
			'type'           => 'custom_products',
			'orderby'        => 'menu_order',
			'ids'            => ! empty( $product_ids ) ? implode( ',', $product_ids ) : '',
			'per_page'       => intval( count( $product_ids ) ),
			'columns'        => $col,
            'swiper'         => true,
		];

		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'text' ], 3 );
		add_action( 'woocommerce_after_shop_loop_item', [ $this, 'description_button' ], 40 );
		add_filter( 'woocommerce_post_class', [ $this, 'product_classes'], 10, 2 );

		$this->add_render_attribute( 'swiper', 'class', [ 'swiper', 'product-swiper--elementor', 'columns-'. esc_attr( $col ), 'tablet-col-'. esc_attr( $col_tablet ), 'mobile-col-'. esc_attr( $col_mobile ) ] );
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ) ?>>
			<?php
				echo '<div class="ecomus-products-carousel--relative em-relative">';
					?><div <?php echo $this->get_render_attribute_string( 'swiper' ) ?>><?php
						printf( '%s', self::render_products( $settings ) );
					?></div><?php
					echo $this->render_arrows();
					echo $this->render_pagination();
				echo '</div>';
			?>
		</div>
		<?php

		remove_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'text' ], 3 );
		remove_action( 'woocommerce_after_shop_loop_item', [ $this, 'description_button' ], 40 );
		remove_filter( 'woocommerce_post_class', [ $this, 'product_classes'], 10, 2 );
	}

	public function text() {
		if( empty( self::$product_details['text'][get_the_ID()] ) ) {
			return;
		}

		$this->add_render_attribute( 'text', 'class', [ 'ecomus-product-price-tables-carousel__text' ] );

		echo '<div '. $this->get_render_attribute_string( 'text' ). '>';
			echo wp_kses_post( self::$product_details['text'][get_the_ID()] );
		echo '</div>';
	}

	public function description_button() {
		$this->add_render_attribute( 'description', 'class', [ 'ecomus-product-price-tables-carousel__description' ] );

		if( ! empty( self::$product_details['description'][get_the_ID()] ) ) {
			echo '<div '. $this->get_render_attribute_string( 'description' ). '>';
				echo wpautop( do_shortcode( self::$product_details['description'][get_the_ID()] ) );
			echo '</div>';
		}

		if( ! empty( self::$product_details['button'][get_the_ID()] ) ) {
			$this->render_button( self::$product_details['button'][get_the_ID()], get_the_ID(), [ 'url' => esc_url( get_the_permalink() ) ] );
		}
	}

	public function product_classes( $classes, $_product ) {
		if( ! empty( self::$product_details['highlight'][$_product->get_id()] ) ) {
			$classes[] = 'ecomus-product-price-tables-carousel__highlight';
		}

		return $classes;
	}
}