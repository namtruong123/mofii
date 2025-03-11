<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Dynamic_Pricing_Discounts extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-dynamic-pricing-discounts';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Dynamic Pricing Discounts', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'dynamic', 'pricing', 'discounts', 'products', 'product' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-product' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'List', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'gap',
			[
				'label' => esc_html__( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_control(
			'background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'active_background_color',
			[
				'label' => esc_html__( 'Active Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item.active' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item',
			]
		);

        $this->add_control(
			'active_border_color',
			[
				'label' => esc_html__( 'Active Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item.active' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'radio_heading',
			[
				'label' => esc_html__( 'Radio button', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'radio_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__summary input[type="radio"]::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__summary input[type="radio"]::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'radio_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item:hover .dynamic-pricing-discounts-item__summary input[type="radio"]::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item:hover .dynamic-pricing-discounts-item__summary input[type="radio"]::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'radio_active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__summary input[type="radio"]:checked::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__summary input[type="radio"]:checked::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'radio_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item input[type="radio"]' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item input[type="radio"]' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

        $this->add_control(
			'title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item label',
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__summary input[type="radio"] + label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'title_active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__summary input[type="radio"]:checked + label' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'save_heading',
			[
				'label' => esc_html__( 'Save', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'save_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount',
			]
		);

		$this->add_control(
			'save_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'save_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'save_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'save_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'save_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__discount',
			]
		);

        $this->add_control(
			'price_text_heading',
			[
				'label' => esc_html__( 'Price Text', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_text_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price > span:first-child',
			]
		);

		$this->add_control(
			'price_text_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price > span:first-child' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'price_text_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price > span:first-child' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price > span:first-child' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'price_heading',
			[
				'label' => esc_html__( 'Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'price_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'price_sale_heading',
			[
				'label' => esc_html__( 'Sale Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_sale_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price ins',
			]
		);

		$this->add_control(
			'price_sale_color',
			[
				'label' => esc_html__( 'Sale Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price ins' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'price_sale_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price ins' => 'margin-left: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price ins' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				],
			]
		);

        $this->add_control(
			'price_old_heading',
			[
				'label' => esc_html__( 'Old Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_old_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price del',
			]
		);

		$this->add_control(
			'price_old_color',
			[
				'label' => esc_html__( 'Old Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--list .dynamic-pricing-discounts-item__price .price del' => 'color: {{VALUE}}; opacity: 1;',
				],
			]
		);
        
        $this->end_controls_section();

		$this->start_controls_section(
			'grid_section_style',
			[
				'label'     => __( 'Grid', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'grid_gap',
			[
				'label' => esc_html__( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid' => 'gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

        $this->add_control(
			'grid_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'grid_active_background_color',
			[
				'label' => esc_html__( 'Active Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item.active' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'grid_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'grid_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item',
			]
		);

        $this->add_control(
			'grid_active_border_color',
			[
				'label' => esc_html__( 'Active Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item.active' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'grid_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'grid_badges_heading',
			[
				'label' => esc_html__( 'Badges', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'grid_badges_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__popular-badges' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'grid_badges_active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item.active .dynamic-pricing-discounts-item__popular-badges' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'grid_badges_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item .dynamic-pricing-discounts-item__popular' => '--em-popular-bg-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'grid_badges_active_background_color',
			[
				'label' => esc_html__( 'Active Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item.active .dynamic-pricing-discounts-item__popular' => '--em-popular-bg-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'grid_radio_heading',
			[
				'label' => esc_html__( 'Radio button', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_control(
			'grid_radio_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__summary input[type="radio"]::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__summary input[type="radio"]::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'grid_radio_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item:hover .dynamic-pricing-discounts-item__summary input[type="radio"]::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item:hover .dynamic-pricing-discounts-item__summary input[type="radio"]::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'grid_radio_active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__summary input[type="radio"]:checked::before' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__summary input[type="radio"]:checked::after' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'grid_radio_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item input[type="radio"]' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item input[type="radio"]' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

        $this->add_control(
			'grid_image_heading',
			[
				'label' => esc_html__( 'Image', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'grid_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid ..dynamic-pricing-discounts-item__thumbnail' => '--em-image-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid ..dynamic-pricing-discounts-item__thumbnail' => '--em-image-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'grid_title_heading',
			[
				'label' => esc_html__( 'Title', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'grid_title_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__form',
			]
		);

		$this->add_control(
			'grid_title_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__form' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'grid_title_active_color',
			[
				'label' => esc_html__( 'Active Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item.active .dynamic-pricing-discounts-item__form' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_control(
			'grid_save_heading',
			[
				'label' => esc_html__( 'Save', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'grid_save_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount',
			]
		);

		$this->add_control(
			'grid_save_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'grid_save_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount' => 'background-color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'grid_save_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_responsive_control(
			'grid_save_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'grid_save_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__discount',
			]
		);

        $this->add_control(
			'grid_price_heading',
			[
				'label' => esc_html__( 'Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

        $this->add_responsive_control(
			'grid_price_margin',
			[
				'label'      => __( 'Margin', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price' => 'margin: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'grid_price_sale_heading',
			[
				'label' => esc_html__( 'Sale Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'grid_price_sale_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price ins',
			]
		);

		$this->add_control(
			'grid_price_sale_color',
			[
				'label' => esc_html__( 'Sale Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price ins' => 'color: {{VALUE}}',
				],
			]
		);

        $this->add_responsive_control(
			'grid_price_sale_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price ins' => 'margin-left: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price ins' => 'margin-right: {{SIZE}}{{UNIT}}; margin-left: 0;',
				],
			]
		);

        $this->add_control(
			'grid_price_old_heading',
			[
				'label' => esc_html__( 'Old Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
			]
		);

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'grid_price_old_typography',
				'selector' => '{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price del',
			]
		);

		$this->add_control(
			'grid_price_old_color',
			[
				'label' => esc_html__( 'Old Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .dynamic-pricing-discounts--grid .dynamic-pricing-discounts-item__price .price del' => 'color: {{VALUE}}; opacity: 1;',
				],
			]
		);
        
        $this->end_controls_section();
	}

	protected function render() {
		global $product;

		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

        if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
            $this->get_dynamic_pricing_discounts_html();
        } else {
		    do_action( 'ecomus_dynamic_pricing_discounts_elementor' );
        }
	}

    public function get_dynamic_pricing_discounts_html() {
        ?>
            <div id="ecomus-dynamic-pricing-discounts" class="dynamic-pricing-discounts dynamic-pricing-discounts--list">
                <div class="dynamic-pricing-discounts-item active">
                    <div class="dynamic-pricing-discounts-item__summary em-flex">
                        <input type="radio" class="dynamic-pricing-discounts-item__quantity" name="dynamic_pricing_discounts_item_quantity" value="10" checked>
                        <label class="em-color-dark em-font-semibold"><?php esc_html_e( 'Buy from 5 to 10 items for 10% OFF per item.', 'ecomus-addons' ); ?></label>

                        <span class="dynamic-pricing-discounts-item__discount em-font-bold"><?php esc_html_e( 'Save 10%', 'ecomus-addons' ); ?></span>
                        <input type="hidden" name="dynamic_pricing_discounts_item_discount" value="10">
                    </div>
                    <div class="dynamic-pricing-discounts-item__price em-flex ">
                        <span class="em-color-dark em-font-bold"><?php esc_html_e( 'Price', 'ecomus-addons' ); ?></span>
                        <span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>90.00</bdi></span></del> <span class="screen-reader-text">Original price was: $90.00.</span><ins aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>81.00</bdi></span></ins><span class="screen-reader-text">Current price is: $81.00.</span></span>
                    </div>
                </div>
                <div class="dynamic-pricing-discounts-item">
                    <div class="dynamic-pricing-discounts-item__summary em-flex">
                        <input type="radio" class="dynamic-pricing-discounts-item__quantity" name="dynamic_pricing_discounts_item_quantity" value="19">
                        <label class="em-color-dark em-font-semibold"><?php esc_html_e( 'Buy from 15 to 19 items for 20% OFF per item.', 'ecomus-addons' ); ?></label>

                        <span class="dynamic-pricing-discounts-item__discount em-font-bold"><?php esc_html_e( 'Save 20%', 'ecomus-addons' ); ?></span>
                        <input type="hidden" name="dynamic_pricing_discounts_item_discount" value="20">
                    </div>
                    <div class="dynamic-pricing-discounts-item__price em-flex ">
                        <span class="em-color-dark em-font-bold"><?php esc_html_e( 'Price', 'ecomus-addons' ); ?></span>
                        <span class="price"><del aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>90.00</bdi></span></del> <span class="screen-reader-text">Original price was: $90.00.</span><ins aria-hidden="true"><span class="woocommerce-Price-amount amount"><bdi><span class="woocommerce-Price-currencySymbol">$</span>72.00</bdi></span></ins><span class="screen-reader-text">Current price is: $72.00.</span></span>
                    </div>
                </div>
                </div>
            </div>
        <?php
    }
}
