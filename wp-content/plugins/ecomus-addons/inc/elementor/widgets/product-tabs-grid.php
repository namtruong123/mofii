<?php

namespace Ecomus\Addons\Elementor\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Product Tabs Grid widget
 */
class Product_Tabs_Grid extends Widget_Base {
    use \Ecomus\Addons\Woocommerce\Products_Base;
	use \Ecomus\Addons\Elementor\Base\Ecomus_Button_Base;

	/**
	 * Retrieve the widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'ecomus-product-tabs-grid';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( '[Ecomus] Product Tabs Grid', 'ecomus-addons' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-product-tabs';
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
			[ 'label' => esc_html__( 'Product Tabs', 'ecomus-addons' ) ]
		);

		$this->add_control(
			'show_heading',
			[
				'label'        => __( 'Show heading with tabs', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => '',
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Enter your text', 'ecomus-addons' ),
				'label_block' => true,
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'limit',
			[
				'label'   => esc_html__( 'Total Products', 'ecomus-addons' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 8,
				'min'     => 1,
				'max'     => 50,
				'step'    => 1,
			]
		);

		$this->add_control(
			'columns',
			[
				'label'     => esc_html__( 'Columns', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'1' => esc_html__( '1 Column', 'ecomus-addons' ),
					'2' => esc_html__( '2 Columns', 'ecomus-addons' ),
					'3' => esc_html__( '3 Columns', 'ecomus-addons' ),
					'4' => esc_html__( '4 Columns', 'ecomus-addons' ),
					'5' => esc_html__( '5 Columns', 'ecomus-addons' ),
					'6' => esc_html__( '6 Columns', 'ecomus-addons' ),
				],
				'default'   => '4',
			]
		);

        $repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'heading',
			[
				'label'       => esc_html__( 'Heading', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'This is heading', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'products',
			[
				'label'     => esc_html__( 'Product', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					'recent_products'       => esc_html__( 'Recent', 'ecomus-addons' ),
					'featured_products'     => esc_html__( 'Featured', 'ecomus-addons' ),
					'best_selling_products' => esc_html__( 'Best Selling', 'ecomus-addons' ),
					'top_rated_products'    => esc_html__( 'Top Rated', 'ecomus-addons' ),
					'sale_products'         => esc_html__( 'On Sale', 'ecomus-addons' ),
					'custom_products'       => esc_html__( 'Custom', 'ecomus-addons' ),
				],
				'default'   => 'recent_products',
				'toggle'    => false,
			]
		);

		$repeater->add_control(
			'orderby',
			[
				'label'     => esc_html__( 'Order By', 'ecomus-addons' ),
				'type'      => Controls_Manager::SELECT,
				'options' => $this->get_options_product_orderby(),
				'condition' => [
					'products' => ['featured_products', 'sale_products', 'custom_products']
				],
				'default'   => 'date',
			]
		);

		$repeater->add_control(
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
					'products' => ['featured_products', 'sale_products', 'custom_products'],
					'orderby!' => ['rand'],
				],
				'default'   => '',
			]
		);

		$repeater->add_control(
			'ids',
			[
				'label' => __( 'Products', 'ecomus-addons' ),
				'type' => 'ecomus-autocomplete',
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'default' => '',
				'multiple'    => true,
				'source'      => 'product',
				'sortable'    => true,
				'label_block' => true,
				'condition' => [
					'products' => ['custom_products']
				],
			]
		);

		$repeater->add_control(
			'product_cat',
			[
				'label'       => esc_html__( 'Product Categories', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_cat',
				'sortable'    => true,
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

		$repeater->add_control(
			'product_tag',
			[
				'label'       => esc_html__( 'Product Tags', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_tag',
				'sortable'    => true,
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

		$repeater->add_control(
			'product_brand',
			[
				'label'       => esc_html__( 'Product Brands', 'ecomus-addons' ),
				'placeholder' => esc_html__( 'Click here and start typing...', 'ecomus-addons' ),
				'type'        => 'ecomus-autocomplete',
				'default'     => '',
				'label_block' => true,
				'multiple'    => true,
				'source'      => 'product_brand',
				'sortable'    => true,
				'condition' => [
					'products!' => ['custom_products']
				],
			]
		);

        $this->add_control(
			'tabs',
			[
				'label'         => '',
				'type'          => Controls_Manager::REPEATER,
				'fields'        => $repeater->get_controls(),
				'default'       => [
					[
						'heading' => esc_html__( 'Best seller', 'ecomus-addons' ),
						'products'  => 'best_selling_products'
					],
					[
						'heading' => esc_html__( 'New arrivals', 'ecomus-addons' ),
						'products'  => 'recent_products'
					],
					[
						'heading' => esc_html__( 'On Sale', 'ecomus-addons' ),
						'products'  => 'sale_products'
					]
				],
				'title_field'   => '{{{ heading }}}',
				'prevent_empty' => false,
			]
		);

		$this->add_control(
			'show_view_all_Button',
			[
				'label'        => __( 'Show view all button', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => '',
			]
		);

		$this->add_control(
			'button_all_text',
			[
				'label'       => __( 'Text', 'ecomus-addons' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'Click here', 'ecomus-addons' ),
				'condition'   => [
					'show_view_all_Button' => 'yes',
				],
			]
		);

		$this->add_control(
			'button_all_link',
			[
				'label'       => __( 'Link', 'ecomus-addons' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => __( 'https://your-link.com', 'ecomus-addons' ),
				'default'     => [
					'url' => '#',
				],
				'condition'   => [
					'show_view_all_Button' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_view_all_button_icon',
			[
				'label'        => __( 'Show icon', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => 'yes',
				'condition'   => [
					'show_view_all_Button' => 'yes',
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
			'section_style_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label'     => __( 'Spacing', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'primary_heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-tabs-grid__heading h4',
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'primary_heading_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading h4' => 'color: {{VALUE}};',
				],
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'primary_heading_text_align',
			[
				'label'       => esc_html__( 'Text Align', 'ecomus-addons' ),
				'type'        => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options'     => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'selectors'   => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading h4' => 'text-align: {{VALUE}}',
				],
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'tab_heading',
			[
				'label' => esc_html__( 'Tab heading', 'ecomus-addons' ),
				'type'  => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'heading_horizontal_position',
			[
				'label'                => esc_html__( 'Horizontal Position', 'ecomus-addons' ),
				'type'                 => Controls_Manager::CHOOSE,
				'label_block'          => false,
				'options'              => [
					'left'   => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'selectors'            => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading' => 'justify-content: {{VALUE}}',
				],
				'selectors_dictionary' => [
					'left'   => 'flex-start',
					'center' => 'center',
					'right'  => 'flex-end',
				],
				'condition'   => [
					'show_heading!' => 'yes',
				],
			]
		);

		$this->add_responsive_control(
			'heading_border_width',
			[
				'label'     => __( 'Border Width', 'ecomus-addons' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 200,
						'min' => 0,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading span' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading a' => 'border-bottom-width: {{SIZE}}{{UNIT}};',
				],
				'condition'   => [
					'show_heading!' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_tab_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-tabs-grid__heading span' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-tabs-grid__heading a' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition'   => [
					'show_heading!' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_heading_style' );

		$this->start_controls_tab(
			'tab_heading_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-tabs-grid__heading span, {{WRAPPER}} .ecomus-product-tabs-grid__button',
				'condition'   => [
					'show_heading!' => 'yes',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'has_heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span, {{WRAPPER}} .ecomus-product-tabs-grid__button',
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => __( 'Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__button' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading .ecomus-product-tabs-grid__button .ecomus-svg-icon' => 'color: inherit;',
				],
			]
		);

		$this->add_control(
			'heading_hover_color',
			[
				'label'     => __( 'Hover Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading span:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_heading_active',
			[
				'label' => __( 'Active', 'ecomus-addons' ),
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_active_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-tabs-grid__heading span.active',
			]
		);

		$this->add_control(
			'heading_active_color',
			[
				'label'     => __( 'Active Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading span.active' => 'color: {{VALUE}}; border-color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading span.active:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span.active' => '--em-border-color-active: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'heading_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->add_control(
			'heading_border_radius_active',
			[
				'label'      => __( 'Active Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span' => '--em-button-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-tabs-grid__heading.has-heading span' => '--em-button-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
				'condition'   => [
					'show_heading' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_products',
			[
				'label' => esc_html__( 'Products', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'border',
			[
				'label'        => __( 'Border', 'ecomus-addons' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => __( 'Hide', 'ecomus-addons' ),
				'label_on'     => __( 'Show', 'ecomus-addons' ),
				'default'      => '',
				'separator'    => 'before',
				'prefix_class' => 'ecomus-show-border-',
			]
		);

		$this->add_control(
			'product_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}}.ecomus-show-border-yes ul.products li.product' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'product_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}}.ecomus-show-border-yes ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}}.ecomus-show-border-yes ul.products li.product' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_pagination',
			[
				'label' => esc_html__( 'Pagination', 'ecomus-addons' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
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

		$this->register_button_style_controls( 'outline-dark' );

		$this->end_controls_section();
	}

	/**
	 * Render icon box widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

        $query_args = [];

        $this->add_render_attribute( 'wrapper', 'class', 'ecomus-product-tabs-grid' );
        $this->add_render_attribute( 'heading', 'class', [ 'ecomus-product-tabs-grid__heading', 'em-flex', $settings['show_heading'] == 'yes' && ! empty( $settings['heading_text'] ) ? 'has-heading' : '' ] );
        $this->add_render_attribute( 'tab-heading', 'class', [ 'ecomus-product-tabs-grid__tab-heading', 'em-flex', 'em-flex-end', 'em-flex-align-center' ] );

        $this->add_render_attribute( 'items', 'class', [ 'ecomus-product-tabs-grid__items', 'em-relative' ] );
        $this->add_render_attribute( 'item', 'class', [ 'ecomus-product-tabs-grid__item', 'active' ] );
        $this->add_render_attribute( 'item', 'data-panel', '1' );

        $this->add_render_attribute( 'loading', 'class', [ 'ecomus-product-tabs-grid__loading', 'em-absolute', 'em-loading-spin' ] );

        echo '<div '. $this->get_render_attribute_string( 'wrapper' ) . '>';
            echo '<div '. $this->get_render_attribute_string( 'heading' ) . '>';
				if ( $settings['show_heading'] == 'yes' && ! empty( $settings['heading_text'] ) ) {
					echo '<h4>'. wp_kses_post( $settings['heading_text'] ) .'</h4>';
					echo '<div '. $this->get_render_attribute_string( 'tab-heading' ) . '>';
				}
                    $a = 1;
                    foreach( $settings['tabs'] as $key => $tab ):
                        if( ! empty( $tab['heading'] ) ) :
                            $attr = [
                                'type'           => $tab['products'],
                                'orderby'        => $tab['orderby'],
                                'order'          => $tab['order'],
                                'category'       => $tab['product_cat'],
                                'tag'            => $tab['product_tag'],
                                'product_brands' => $tab['product_brand'],
                                'ids'            => $tab['ids'],
                                'per_page'       => $settings['limit'],
                                'columns'        => $settings['columns'],
                                'pagination'     => $settings['pagination'],
                                'pagination_type' => $settings['pagination_type'],
                                'button_style'   => $settings['button_style'],
                            ];

                            $tab_key = $this->get_repeater_setting_key( 'tab', 'products_tab', $key );

					        $this->add_render_attribute( $tab_key, [ 'data-target' => $a, 'data-atts' => json_encode( $attr ) ] );

                            if ( 1 === $a ) {
                                $this->add_render_attribute( $tab_key, 'class', 'active' );
                                $query_args = $attr;
                            }

                            ?>
                            <span <?php echo $this->get_render_attribute_string( $tab_key ); ?>><?php echo wp_kses_post( $tab['heading'] ); ?></span>
                            <?php
                        endif;
                    $a++;
                    endforeach;

					if( ! empty( $settings['button_all_text'] ) && ! empty( $settings['button_all_link']['url'] ) ) {
						$icon = $settings['show_view_all_button_icon'] == 'yes' ? \Ecomus\Addons\Helper::get_svg( 'arrow-top' ) : '';
						$this->add_link_attributes( 'button_all', $settings['button_all_link'] );
						echo '<a '. $this->get_render_attribute_string( 'button_all' ) .' class="ecomus-product-tabs-grid__button">'. esc_html( $settings['button_all_text'] ) . $icon . '</a>';
					}
				if ( $settings['show_heading'] == 'yes' && ! empty( $settings['heading_text'] ) ) {
            		echo '</div>';
				}
            echo '</div>';
        ?>
            <div <?php echo $this->get_render_attribute_string( 'items' ) ?>>
                <div <?php echo $this->get_render_attribute_string( 'loading' ) ?>></div>
                <div <?php echo $this->get_render_attribute_string( 'item' ) ?>>
                    <?php echo $this->render_products( $query_args ); ?>
                </div>
            </div>
        <?php
        echo '</div>';
	}
}