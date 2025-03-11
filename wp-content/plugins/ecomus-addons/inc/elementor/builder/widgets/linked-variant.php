<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Linked_Variant extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-linked-variant';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Linked Variant', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'linked', 'variant', 'product' ];
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
			'section_attribute_style',
			[
				'label'     => __( 'Attributes', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'attribute_spacing',
			[
				'label' => esc_html__( 'Spacing bottom', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'attribute_labels',
			[
				'label'     => esc_html__( 'Labels', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'attribute_labels_typography',
				'selector' => '{{WRAPPER}} .ecomus-linked-variant__attribute-label',
			]
		);

		$this->add_control(
			'attribute_labels_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_labels_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'attribute_values',
			[
				'label'     => esc_html__( 'Values', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'attribute_labels_gap',
			[
				'label' => esc_html__( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

        $this->add_control(
			'attribute_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value .wcboost-variation-swatches__item' => 'border-color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'attribute_selected_heading',
			[
				'label'     => esc_html__( 'Selected', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'attribute_selected_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value .wcboost-variation-swatches__item:hover' => 'border-color: {{VALUE}};',
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value .wcboost-variation-swatches__item.selected' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_attribute_image_style',
			[
				'label'     => __( 'Image Attribute', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'attribute_image_width',
			[
				'label' => esc_html__( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--image .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_image_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--image .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--image .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--image .wcboost-variation-swatches__item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--image .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--image .wcboost-variation-swatches__item img' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'section_color_attribute_style',
			[
				'label'     => __( 'Color Attribute', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'attribute_color_width',
			[
				'label' => esc_html__( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_color_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_color_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_color_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--color .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_label_attribute_style',
			[
				'label'     => __( 'Label Attribute', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'attribute_label_width',
			[
				'label' => esc_html__( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_label_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'attribute_label_typography',
				'selector' => '{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item',
			]
		);

		$this->add_control(
			'attribute_label_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'attribute_label_selected_color',
			[
				'label' => esc_html__( 'Selected Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item.selected' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_label_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_label_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--label .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_button_attribute_style',
			[
				'label'     => __( 'Button Attribute', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'attribute_button_width',
			[
				'label' => esc_html__( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_button_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'attribute_button_typography',
				'selector' => '{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item',
			]
		);

		$this->add_control(
			'attribute_button_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'attribute_button_selected_color',
			[
				'label' => esc_html__( 'Selected Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item:hover' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item.selected' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--button .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_select_attribute_style',
			[
				'label'     => __( 'Select Attribute', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'attribute_select_min_width',
			[
				'label' => esc_html__( 'Min Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select' => 'min-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'attribute_select_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select' => '--em-input-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_select_border_width',
			[
				'label' => esc_html__( 'Border Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select' => '--em-input-border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'attribute_select_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select' => '--em-input-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'attribute_select_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select' => '--em-input-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select' => '--em-input-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'attribute_select_hover_heading',
			[
				'label'     => esc_html__( 'Hover', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'attribute_select_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select:hover' => '--em-input-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'attribute_select_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-linked-variant__attribute-value.wcboost-variation-swatches--select .ecomus-linked-variant__select' => '--em-input-border-color-hover: {{VALUE}};',
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

        if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
            $this->get_html( $product );
            return;
        }

        do_action( 'ecomus_linked_variant_elementor' );
	}

    public function get_html( $product ) {
        ?>
		<div id="ecomus-linked-variant" class="linked-variant">
            <div class="ecomus-linked-variant__attribute">
                <div class="ecomus-linked-variant__attribute-label"><?php esc_html_e( 'Color', 'ecomus-addons' ); ?></div>
                <div class="ecomus-linked-variant__attribute-value wcboost-variation-swatches--image wcboost-variation-swatches-- wcboost-variation-swatches--has-tooltip">
                    <a class="wcboost-variation-swatches__item selected" href="" aria-label="Blue" data-value="Blue" tabindex="0" role="button">
                        <?php echo $product->get_image(); ?>
                        <span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Blue', 'ecomus-addons' ); ?></span>
                    </a>
                    <a class="wcboost-variation-swatches__item" href="" aria-label="Gray" data-value="Gray" tabindex="0" role="button">
                        <?php echo $product->get_image(); ?>
                        <span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Gray', 'ecomus-addons' ); ?></span>
                    </a>
                </div>
            </div>
		</div>
	<?php
    }
}