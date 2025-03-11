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
 * Products Carousel
 */
class Products_Carousel extends Products_Widget_Base {
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-products-carousel';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Products Carousel', 'ecomus-addons' );
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
		return [ 'products carousel', 'products', 'carousel', 'woocommerce', 'ecomus-addons' ];
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

		$this->add_control(
			'show_heading',
			[
				'label'        => __( 'Show heading with arrows', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => '',
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'This is the text', 'ecomus-addons' ),
				'placeholder' => __( 'Enter your text', 'ecomus-addons' ),
				'label_block' => true,
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
				'default'     => [],
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'arrows_prev_icon',
			[
				'label'            => __( 'Custom Previous Icon', 'ecomus-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'separator' 		=> 'before',
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'arrows_next_icon',
			[
				'label'            => __( 'Custom Next Icon', 'ecomus-addons' ),
				'type'             => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'skin'             => 'inline',
				'label_block'      => false,
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'product_heading',
			[
				'label' => esc_html__( 'Product', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->register_products_controls( 'all' );

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
			'slides_to_show'   => 4,
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
		$this->start_controls_section(
			'section_heading_style',
			[
				'label'     => __( 'Heading', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-products-carousel__title',
			]
		);

        $this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__title,
					{{WRAPPER}} .ecomus-products-carousel__title a:not(:hover)' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-products-carousel__title a:not(:hover)::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'      => esc_html__( 'Heading Spacing', 'ecomus-addons' ),
				'type'       => Controls_Manager::SLIDER,
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 1900,
					],
				],
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-products-carousel__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->section_style_heading();

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_style',
			[
				'label'     => __( 'Product', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
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
				'prefix_class' => 'ecomus-products-carousel-align--',
			]
		);

		$this->add_control(
			'product_item_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-inner' => 'background-color: {{VALUE}};',
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

		$this->add_control(
			'product_image_border',
			[
				'label'     => esc_html__( 'Show Border', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'ecomus-addons' ),
				'label_on'  => __( 'Show', 'ecomus-addons' ),
				'return_value' => 'yes',
				'default'      => '',
				'prefix_class' => 'ecomus-products-carousel-border-'
			]
		);

		$this->add_control(
			'product_image_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.ecomus-products-carousel-border-yes ul.products li.product .product-thumbnail:before' => 'border-color: {{VALUE}};',
				],
				'condition'   => [
					'product_image_border' => 'yes',
				],
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

		$this->add_responsive_control(
			'product_image_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} ul.products li.product .product-thumbnail' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} ul.products li.product .product-thumbnail' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'product_featured_icons_heading',
			[
				'label' => esc_html__( 'Featured Icons', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'tabs_featured_icons_style' );

		$this->start_controls_tab(
			'tab_featured_icons_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'featured_icons_background_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .product-loop-button' => '--em-button-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_icons_text_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .product-loop-button' => '--em-button-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_featured_icons_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'featured_icons_background_hover_color',
			[
				'label'     => __( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .product-loop-button' => '--em-button-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_icons_hover_color',
			[
				'label'     => __( 'Text Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .product-loop-button' => '--em-button-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'featured_icons_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .product-featured-icons .product-loop-button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
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

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'product_price_typography',
				'selector' => '{{WRAPPER}} .price',
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

		$this->add_control(
			'product_attribute_heading',
			[
				'label' => esc_html__( 'Product Attribute', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_attribute_border_hover_color',
			[
				'label'     => __( 'Border Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-variation-items .product-variation-item:hover,
					ul.products li.product .product-variation-items .product-variation-item.selected' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_attribute_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .product-variation-items .product-variation-item' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_title_button',
			[
				'label' => esc_html__( 'Add To Cart Button', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'product_button_icon',
			[
				'label'     => esc_html__( 'Hide Icon', 'ecomus-addons' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_off' => __( 'Show', 'ecomus-addons' ),
				'label_on'  => __( 'Hide', 'ecomus-addons' ),
				'return_value' => 'none',
				'default'      => '',
				'selectors' => [
					'{{WRAPPER}} ul.products li.product .em-button-add-to-cart-mobile .ecomus-svg-icon' => 'display: {{VALUE}}',
				],
			]
		);

		$this->register_button_style_controls( 'outline', 'product-summary .product-loop-button-atc' );

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

		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Carousel Settings', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->register_carousel_style_controls();

		$this->end_controls_section();
	}

	// Tab Content
	protected function section_style_heading() {
		$this->add_control(
			'arrows_heading_style_heading',
			[
				'label' => esc_html__( 'Arrows', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator'   => 'before',
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_display',
			[
				'label'                => esc_html__( 'Display', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'between'   => [
						'title' => esc_html__( 'between', 'ecomus-addons' ),
						'icon'  => 'eicon-justify-space-between-h',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-stretch',
					],
				],
				'default' 		=> 'between',
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_heading_size',
			[
				'label'     => __( 'Icon Size', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 100,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'arrows_heading_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => 'border-radius: {{RIGHT}}{{UNIT}} {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs(
			'arrows_heading_tabs',
			[
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);
		$this->start_controls_tab(
			'arrows_heading_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'ecomus-addons' ),
			]
		);
		$this->add_control(
			'arrows_heading_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => '--em-arrow-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_heading_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => '--em-arrow-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_heading_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => '--em-arrow-border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrows_heading_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'arrows_heading_hover_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => '--em-arrow-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_heading_hover_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => '--em-arrow-color-hover: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_heading_hover_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button' => '--em-arrow-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'arrows_heading_disable_tab',
			[
				'label' => esc_html__( 'Disable', 'ecomus-addons' ),
			]
		);
		$this->add_control(
			'arrows_heading_disable_bgcolor',
			[
				'label'     => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button.swiper-button-disabled' => '--em-arrow-bg-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_heading_disable_color',
			[
				'label'     => esc_html__( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button.swiper-button-disabled' => '--em-arrow-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'arrows_heading_disable_border_color',
			[
				'label'     => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-products-carousel__heading .swiper-button.swiper-button-disabled' => '--em-arrow-border-color: {{VALUE}};',
				],
			]
		);
		$this->end_controls_tab();

		$this->end_controls_tabs();
	}

	/**
	 * Render widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute( 'wrapper', 'class', [
			'ecomus-products-carousel',
			'ecomus-products-carousel--elementor',
			'ecomus-carousel--elementor',
			'ecomus-carousel--slidesperview-auto'
		] );

		$col = $settings['slides_to_show'];
		$col_tablet = ! empty( $settings['slides_to_show_tablet'] ) ? $settings['slides_to_show_tablet'] : $col;
		$col_mobile = ! empty( $settings['slides_to_show_mobile'] ) ? $settings['slides_to_show_mobile'] : $col_tablet;

		$this->add_render_attribute( 'swiper', 'class', [ 'swiper', 'product-swiper--elementor', 'columns-'. esc_attr( $col ), 'tablet-col-'. esc_attr( $col_tablet ), 'mobile-col-'. esc_attr( $col_mobile ) ] );

		$this->add_render_attribute( 'heading', 'class', [ 'ecomus-products-carousel__heading', 'heading--carousel', 'ecomus-products-carousel__heading-display-' . $settings['heading_display'] ] );
		if ( $settings['show_heading'] == 'yes' ) {
			$this->add_link_attributes( 'button', $settings['link'] );
		}

		$is_new   = Icons_Manager::is_migration_allowed();
		$arrow_left = $arrow_right = $classes = '';
		if ( $settings['heading_display'] == 'between' ) {
			$classes = 'swiper-button-outline-dark';
		} else {
			$classes = 'swiper-button-text';
		}

		if ( ! empty( $settings['arrows_prev_icon']['value'] ) ) {
			if ( $is_new ) {
				$arrow_left = '<span class="ecomus-svg-icon elementor-swiper-button-prev swiper-button swiper-button-small '. $classes .'">'. $this->get_icon_html( $settings['arrows_prev_icon'], [ 'aria-hidden' => 'true' ] ) .'</span>';
			}
		} else {
			$arrow_left = \Ecomus\Addons\Helper::get_svg('left-mini', 'ui' , [ 'class' => 'elementor-swiper-button-prev swiper-button swiper-button-small '. $classes .'' ] );
		}

		if ( ! empty( $settings['arrows_next_icon']['value'] ) ) {
			if ( $is_new ) {
				$arrow_right = '<span class="ecomus-svg-icon elementor-swiper-button-next swiper-button swiper-button-small '. $classes .'">'. $this->get_icon_html( $settings['arrows_next_icon'], [ 'aria-hidden' => 'true' ] ) .'</span>';
			}
		} else {
			$arrow_right = \Ecomus\Addons\Helper::get_svg('right-mini', 'ui' , [ 'class' => 'elementor-swiper-button-next swiper-button swiper-button-small '. $classes .'' ] );
		}

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ) ?>>
			<?php
				if ( $settings['show_heading'] == 'yes' && ! empty( $settings['heading'] ) ) {
					?>
					<div <?php echo $this->get_render_attribute_string( 'heading' ); ?>>
						<?php if ( $settings['heading_display'] == 'between' ) : ?>
							<?php if ( ! empty( $settings['link']['url'] ) ) : ?>
								<a <?php echo $this->get_render_attribute_string( 'button' ) ?>>
							<?php endif; ?>
							<h4 class="ecomus-products-carousel__title"> <?php echo esc_html( $settings['heading'] ) ?></h4>
							<?php if ( ! empty( $settings['link']['url'] ) ) : ?>
								</a>
							<?php endif; ?>
							<div class="swiper-arrows">
								<?php echo $arrow_left ?>
								<?php echo $arrow_right ?>
							</div>
						<?php else : ?>
							<div class="swiper-arrows">
								<?php echo $arrow_left; ?>
								<h6 class="ecomus-products-carousel__title">
									<?php if ( ! empty( $settings['link']['url'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( 'button' ) ?>>
									<?php endif; ?>
									<?php echo esc_html( $settings['heading'] ) ?>
									<?php if ( ! empty( $settings['link']['url'] ) ) : ?>
										</a>
									<?php endif; ?>
								</h6>
								<?php echo $arrow_right; ?>
							</div>
						<?php endif; ?>
					</div>
					<?php
				}

				echo '<div class="ecomus-products-carousel--relative em-relative">';
					if( in_array( $settings['product_card_layout'], [ '6', '7' ] ) ) {
						add_filter( 'ecomus_add_to_cart_button_classes', array( $this, 'add_to_cart_button_classes' ) );
					} else {
						add_filter( 'ecomus_add_to_cart_button_mobile_classes', array( $this, 'add_to_cart_button_classes' ) );
					}

					?><div <?php echo $this->get_render_attribute_string( 'swiper' ) ?>><?php
						printf( '%s', self::render_products() );
					?></div><?php

					if( in_array( $settings['product_card_layout'], [ '6', '7' ] ) ) {
						remove_filter( 'ecomus_add_to_cart_button_classes', array( $this, 'add_to_cart_button_classes' ) );
					} else {
						remove_filter( 'ecomus_add_to_cart_button_mobile_classes', array( $this, 'add_to_cart_button_classes' ) );
					}

					echo $this->render_arrows();
					echo $this->render_pagination();
				echo '</div>';
			?>
		</div>
		<?php
	}

	/**
	 * @param array $icon
	 * @param array $attributes
	 * @param $tag
	 * @return bool|mixed|string
	 */
	function get_icon_html( array $icon, array $attributes, $tag = 'i' ) {
		/**
		 * When the library value is svg it means that it's a SVG media attachment uploaded by the user.
		 * Otherwise, it's the name of the font family that the icon belongs to.
		 */
		if ( 'svg' === $icon['library'] ) {
			$output = Icons_Manager::render_uploaded_svg_icon( $icon['value'] );
		} else {
			$output = Icons_Manager::render_font_icon( $icon, $attributes, $tag );
		}
		return $output;
	}

	public function add_to_cart_button_classes( $classes ) {
		$settings = $this->get_settings_for_display();

		$classes = ! empty( $settings['button_style'] ) ? 'em-button-'  . esc_attr( $settings['button_style'] ) : '';

		return $classes;
	}
}
