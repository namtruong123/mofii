<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Data_Tabs extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-data-tabs';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Data Tabs', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-tabs';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'data', 'tabs', 'product' ];
	}

	public function get_script_depends() {
		return [
			'ecomus-product-elementor-widgets'
		];
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
			'section_tabs',
			[
				'label' => esc_html__( 'Product Data Tabs', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'product_tabs_layout',
			[
				'label' => esc_html__( 'Layout', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default'   => esc_html__( 'Defaults', 'ecomus-addons' ),
					'accordion' => esc_html__( 'Accordion', 'ecomus-addons' ),
					'list'      => esc_html__( 'List', 'ecomus-addons' ),
					'vertical'  => esc_html__( 'Vertical', 'ecomus-addons' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'product_tabs_status',
			[
				'label' => esc_html__( 'Product Tabs Status', 'ecomus-addons' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'close',
				'options' => [
					'close' => esc_html__( 'Close all tabs', 'ecomus-addons' ),
					'first' => esc_html__( 'Open first tab', 'ecomus-addons' ),
					'description' => esc_html__( 'Open description tab', 'ecomus-addons' ),
					'review' => esc_html__( 'Open review tab', 'ecomus-addons' ),
				],
				'condition' => [
					'product_tabs_layout' => 'accordion'
				]
			]
		);

		$this->end_controls_section();

		$this->style_section();
	}

	public function style_section() {
		$this->default_style();
		$this->accordion_style();
		$this->list_style();
		$this->vertical_style();
	}

	public function default_style() {
		$this->start_controls_section(
			'section_default_style',
			[
				'label' => esc_html__( 'Default', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'default_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--default' => '--em-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'default_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs' => '--em-rounded-xs: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs' => '--em-rounded-xs: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'default_gap',
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
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'default_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'default_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'default_heading_typography',
				'selector' => '{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs li a',
			]
		);

		$this->add_control(
			'default_heading_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'default_heading_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'default_heading_active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs li.active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'default_heading_active_border_color',
			[
				'label' => esc_html__( 'Active Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs li.active a::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'default_heading_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'default_content_heading',
			[
				'label' => esc_html__( 'Content', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'default_content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--default .woocommerce-tabs .wc-tab' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function accordion_style() {
		$this->start_controls_section(
			'section_accordion_style',
			[
				'label' => esc_html__( 'Accordion', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'accordion_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown:not(.last)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'accordion_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'accordion_heading_typography',
				'selector' => '{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title',
			]
		);

		$this->add_control(
			'accordion_heading_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title' => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accordion_heading_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accordion_heading_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title:hover' => 'color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title:hover::before' => 'background-color: {{VALUE}};',
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title:hover::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'accordion_heading_hover_background_color',
			[
				'label' => esc_html__( 'Hover Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--dropdown .woocommerce-tabs-title:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'accordion_heading_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown .woocommerce-tabs-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown .woocommerce-tabs-title' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'accordion_content_heading',
			[
				'label' => esc_html__( 'Content', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'accordion_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown .woocommerce-tabs-content' => '--em-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'accordion_content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown .woocommerce-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown .woocommerce-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'accordion_content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown .woocommerce-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--accordion .woocommerce-tabs--dropdown .woocommerce-tabs-content' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function list_style() {
		$this->start_controls_section(
			'section_list_style',
			[
				'label' => esc_html__( 'List', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'list_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--list' => '--em-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'list_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'list_heading_typography',
				'selector' => '{{WRAPPER}} .woocommerce-tabs--list .woocommerce-tabs-title',
			]
		);

		$this->add_control(
			'list_heading_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--list .woocommerce-tabs-title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'list_heading_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--list .woocommerce-tabs-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--list .woocommerce-tabs-title' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'list_content',
			[
				'label' => esc_html__( 'Content', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'list_content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--list .woocommerce-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--list .woocommerce-tabs-content' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	public function vertical_style() {
		$this->start_controls_section(
			'section_vertical_style',
			[
				'label' => esc_html__( 'Vertical', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'vertical_gap',
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
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'vertical_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'vertical_heading_min_width',
			[
				'label' => esc_html__( 'Min Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs' => 'min-width: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'vertical_heading_typography',
				'selector' => '{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li a',
			]
		);

		$this->add_control(
			'vertical_heading_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'vertical_heading_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li' => '--em-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'vertical_heading_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'vertical_heading_active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li.active a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'vertical_heading_active_border_color',
			[
				'label' => esc_html__( 'Active Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li.active a::after' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_heading_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_heading_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tabs li a' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'vertical_content_heading',
			[
				'label' => esc_html__( 'Content', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'vertical_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tab' => '--em-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tab' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tab' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'vertical_content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tab' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .woocommerce-tabs--vertical .woocommerce-tabs .wc-tab' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

		setup_postdata( $product->get_id() );

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$original_post = $GLOBALS['post'];
			$GLOBALS['post'] = get_post( $product->get_id() );
			setup_postdata( $GLOBALS['post'] );
		}

		if( ! empty( woocommerce_default_product_tabs() ) ) {
			echo '<div class="product ecomus-woocommerce-tabs woocommerce-tabs--'. esc_attr( $settings['product_tabs_layout'] ) .'">';
		}

		if( in_array( $settings[ 'product_tabs_layout' ], [ 'accordion', 'list' ] ) ) {
			$this->product_tabs();
		} else {
			wc_get_template( 'single-product/tabs/tabs.php' );
		}

		if( ! empty( woocommerce_default_product_tabs() ) ) {
			echo '</div>';
		}

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$GLOBALS['post'] = $original_post;
			?>
			<script>
				jQuery( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
			</script>
			<?php
		}
	}

	/**
	 * Show product tabs type dropdowm, list
	 *
	 * @return void
	 */
	public function product_tabs() {
		$settings = $this->get_settings_for_display();
		$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

		if( empty( $product_tabs ) ) {
			return;
		}

		$type = 'dropdown';
		if( $settings[ 'product_tabs_layout' ] == 'list' ) {
			$type = 'list';
		}

		$arrKey = array_keys($product_tabs);
		$lastKey = end($arrKey);
		$i = 0;
		foreach( $product_tabs as $key => $product_tab ) :
			$firstKey = ( $i == 0 ) ? $key : '';
			$tab_class = $title_class = '';

			if ( $key == $firstKey && $settings[ 'product_tabs_status' ] == 'first' ) {
				$tab_class = 'wc-tabs-first--opened';
				$title_class = 'active';
			} elseif ( $key == 'description' && $settings[ 'product_tabs_status' ] == 'description' ) {
				$tab_class = 'wc-tabs-first--opened';
				$title_class = 'active';
			} elseif ( $key == 'reviews' && $settings[ 'product_tabs_status' ] == 'review' ) {
				$tab_class = 'wc-tabs-first--opened';
				$title_class = 'active';
			}

			$tab_class .= ( $key == $lastKey ) ? ' last' : '';
		?>
			<div id="tab-<?php echo esc_attr( $key ); ?>" class="woocommerce-tabs ecomus-woocommerce-tabs woocommerce-tabs--<?php echo esc_attr( $type ); ?> woocommerce-tabs--<?php echo esc_attr( $key ); ?> <?php echo esc_attr($tab_class) ?>">
				<div class="woocommerce-tabs-title em-font-semibold em-color-dark <?php echo esc_attr($title_class); ?>"><?php echo esc_html( $product_tab['title'] ); ?></div>
				<div class="woocommerce-tabs-content">
					<?php
					if ( isset( $product_tab['callback'] ) ) {
						call_user_func( $product_tab['callback'], $key, $product_tab );
					}
					?>
				</div>
			</div>
		<?php
		$i++;
		endforeach;
	}
}
