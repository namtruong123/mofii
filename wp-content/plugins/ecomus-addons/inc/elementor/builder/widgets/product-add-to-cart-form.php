<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_Add_To_Cart_Form extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-add-to-cart-form';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Product Add To Cart Form', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-product-add-to-cart';
	}

	public function get_categories() {
		return ['ecomus-addons-product'];
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'cart', 'product', 'button', 'add to cart' ];
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
		return 'elementor-widget-' . $this->get_name() . ' product-gallery-summary entry-summary';
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
		$this->swatches_style();
		$this->quantity_style();
		$this->add_to_cart_style();
		$this->featured_icon_style();
		$this->buy_now_style();
	}

	protected function swatches_style() {
		$this->start_controls_section(
			'section_swatches_style',
			[
				'label'     => __( 'Swatches', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'swatches_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} table.variations' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_labels',
			[
				'label'     => esc_html__( 'Labels', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'swatches_labels_typography',
				'selector' => '{{WRAPPER}} table.variations .label',
			]
		);

		$this->add_control(
			'swatches_labels_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_labels_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .label' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_values',
			[
				'label'     => esc_html__( 'Values', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
			]
		);

		$this->add_responsive_control(
			'swatches_labels_gap',
			[
				'label' => esc_html__( 'Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .value ul' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_values_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .value' => 'padding-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_swatches_color_style',
			[
				'label'     => __( 'Swatches Color', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'swatches_color_width',
			[
				'label' => esc_html__( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_color_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_color_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item:not(.selected)' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_color_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_color_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_color_selected_heading',
			[
				'label'     => esc_html__( 'Selected', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_color_selected_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item.selected' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'swatches_color_disabled_heading',
			[
				'label'     => esc_html__( 'Disabled', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_color_disabled_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item.disabled' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'swatches_color_disabled_line_color',
			[
				'label' => esc_html__( 'Line Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--color .wcboost-variation-swatches__item.disabled .wcboost-variation-swatches__name::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_swatches_image_style',
			[
				'label'     => __( 'Swatches Image', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'swatches_image_width',
			[
				'label' => esc_html__( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_image_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_image_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item:not(.selected)' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_image_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_image_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item img' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_image_selected_heading',
			[
				'label'     => esc_html__( 'Selected', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_image_selected_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item.selected' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'swatches_image_disabled_heading',
			[
				'label'     => esc_html__( 'Disabled', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_image_disabled_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item.disabled' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'swatches_image_disabled_line_color',
			[
				'label' => esc_html__( 'Line Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--image .wcboost-variation-swatches__item.disabled .wcboost-variation-swatches__name::before' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_swatches_label_style',
			[
				'label'     => __( 'Swatches Label', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'swatches_label_min_width',
			[
				'label' => esc_html__( 'Min Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_label_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'swatches_label_typography',
				'selector' => '{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item .wcboost-variation-swatches__name',
			]
		);

		$this->add_control(
			'swatches_label_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item:not(.selected)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_label_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item:not(.selected)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_label_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item:not(.selected)' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_label_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_label_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_label_selected_heading',
			[
				'label'     => esc_html__( 'Selected', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_label_selected_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item.selected' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_label_selected_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item.selected' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_label_selected_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item.selected' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'swatches_label_disabled_heading',
			[
				'label'     => esc_html__( 'Disabled', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_label_disabled_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item.disabled' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_label_disabled_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item.disabled' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_label_disabled_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--label .wcboost-variation-swatches__item.disabled' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_swatches_button_style',
			[
				'label'     => __( 'Swatches Label', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'swatches_button_min_width',
			[
				'label' => esc_html__( 'Min Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_button_min_height',
			[
				'label' => esc_html__( 'Min Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'swatches_button_typography',
				'selector' => '{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item .wcboost-variation-swatches__name',
			]
		);

		$this->add_control(
			'swatches_button_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item:not(.selected)' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item:not(.selected)' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_button_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item:not(.selected)' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item' => '--wcboost-swatches-item-padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item .wcboost-variation-swatches__name' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_button_selected_heading',
			[
				'label'     => esc_html__( 'Selected', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_button_selected_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item.selected' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_button_selected_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item.selected' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_button_selected_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item.selected' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->add_control(
			'swatches_button_disabled_heading',
			[
				'label'     => esc_html__( 'Disabled', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_button_disabled_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item.disabled' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_button_disabled_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item.disabled' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_button_disabled_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .wcboost-variation-swatches--button .wcboost-variation-swatches__item.disabled' => 'border-color: {{VALUE}} !important;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_swatches_select_style',
			[
				'label'     => __( 'Swatches Select', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'swatches_select_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .value select' => '--em-input-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_select_border_width',
			[
				'label' => esc_html__( 'Border Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} table.variations .value select' => '--em-input-border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_select_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .value select' => '--em-input-border-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'swatches_select_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} table.variations .value select' => '--em-input-rounded: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} table.variations .value select' => '--em-input-rounded: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swatches_select_hover_heading',
			[
				'label'     => esc_html__( 'Hover', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'swatches_select_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .value select:hover' => '--em-input-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'swatches_select_hover_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} table.variations .value select' => '--em-input-border-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function quantity_style() {
		$this->start_controls_section(
			'section_quantity_style',
			[
				'label'     => __( 'Quantity', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'product_quantity_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity' => 'color: {{VALUE}}',
					'{{WRAPPER}} .quantity input' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_quantity_hover_color',
			[
				'label' => esc_html__( 'Hover Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .ecomus-qty-button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_quantity_hover_background_color',
			[
				'label' => esc_html__( 'Icon background color on hover', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity .ecomus-qty-button:hover::before' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'product_quantity_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .quantity' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'product_quantity_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .quantity',
			]
		);

		$this->add_responsive_control(
			'product_quantity_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .quantity' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .quantity' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function add_to_cart_style() {
		$this->start_controls_section(
			'section_add_to_cart_style',
			[
				'label'     => __( 'Add to cart button', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'addtocart_button_max_width',
			[
				'label' => esc_html__( 'Max Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .single_add_to_cart_button' => 'max-width: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'addtocart_button_typography',
				'selector' => '{{WRAPPER}} .single_add_to_cart_button, {{WRAPPER}} .single_add_to_cart_button .price',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'addtocart_button_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .single_add_to_cart_button',
			]
		);

		$this->add_responsive_control(
			'addtocart_button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .single_add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .single_add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'addtocart_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .single_add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .single_add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'addtocart_button_style' );

		$this->start_controls_tab(
			'addtocart_button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'addtocart_button_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_add_to_cart_button' => '--em-button-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'addtocart_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_add_to_cart_button' => '--em-button-bg-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'addtocart_button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'addtocart_button_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_add_to_cart_button' => '--em-button-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'addtocart_button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_add_to_cart_button' => '--em-button-bg-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'addtocart_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_add_to_cart_button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'addtocart_button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .single_add_to_cart_button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function featured_icon_style() {
		$this->start_controls_section(
			'section_featured_style',
			[
				'label'     => __( 'Featured icon button', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'featured_button_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}} !important;',
				],
			]
		);

		$this->add_responsive_control(
			'featured_button_width',
			[
				'label' => esc_html__( 'Width', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => '--em-button-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'featured_button_height',
			[
				'label' => esc_html__( 'Height', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => '--em-button-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'featured_button_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} form.cart .product-featured-icons .product-loop-button',
			]
		);

		$this->add_responsive_control(
			'featured_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'featured_button_style' );

		$this->start_controls_tab(
			'featured_button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'featured_button_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => '--em-button-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'featured_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => '--em-button-bg-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'featured_button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'featured_button_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => '--em-button-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'featured_button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button' => '--em-button-bg-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'featured_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} form.cart .product-featured-icons .product-loop-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function buy_now_style() {
		$this->start_controls_section(
			'section_buy_now_style',
			[
				'label'     => __( 'Buy now button', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'buynow_button_icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .em-buy-now-button .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'buynow_button_typography',
				'selector' => '{{WRAPPER}} .em-buy-now-button',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'buynow_button_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .em-buy-now-button',
			]
		);

		$this->add_responsive_control(
			'buynow_button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .em-buy-now-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-buy-now-button' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'buynow_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .em-buy-now-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .em-buy-now-button' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'buynow_button_style' );

		$this->start_controls_tab(
			'buynow_button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'buynow_button_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-buy-now-button' => '--em-button-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'buynow_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-buy-now-button' => '--em-button-bg-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'buynow_button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'buynow_button_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-buy-now-button' => '--em-button-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'buynow_button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-buy-now-button' => '--em-button-bg-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'buynow_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-buy-now-button:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'buynow_button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .em-buy-now-button' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
			$args =  array(
				'type' => 'simple',
				'limit' => 1,
				'orderby' => 'date',
				'order' => 'ASC',
			);

			$products = wc_get_products( $args );

			if( ! empty( $products ) ) {
				$product_id = $products[0]->get_id();
				setup_postdata( $product_id );
				$original_post = $GLOBALS['post'];
				$GLOBALS['post'] = get_post( $product_id );
				setup_postdata( $GLOBALS['post'] );
			}

			if( class_exists('\WCBoost\Wishlist\Frontend') ) {
				add_action( 'woocommerce_after_add_to_cart_button', array( \WCBoost\Wishlist\Frontend::instance(), 'single_add_to_wishlist_button' ), 21 );
			}
			if( class_exists('\WCBoost\ProductsCompare\Frontend') ) {
				add_action( 'woocommerce_after_add_to_cart_button', array( \WCBoost\ProductsCompare\Frontend::instance(), 'single_add_to_compare_button' ), 21 );
			}
			if( function_exists('wcboost_products_compare') ) {
				add_filter( 'wcboost_products_compare_single_add_to_compare_link', array( \Ecomus\WooCommerce\Compare::instance(), 'single_add_to_compare_link' ), 20, 2 );
			}
			if( function_exists('wcboost_wishlist') ) {
				add_filter( 'wcboost_wishlist_single_add_to_wishlist_link', array( \Ecomus\WooCommerce\Wishlist::instance(), 'wishlist_button_single_product' ), 20, 2 );
			}
		}

		if( function_exists('woocommerce_template_single_price') ) {
			add_filter( 'woocommerce_format_sale_price', array( $this, 'format_sale_price' ), 10, 3 );
			add_filter( 'woocommerce_variable_price_html', array( $this, 'format_variable_price' ), 10, 2 );
		}

		if( function_exists('woocommerce_template_single_add_to_cart') ) {
			add_action( 'woocommerce_single_variation', array( $this, 'data_product_variable' ) );
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'open_product_featured_buttons' ), 20 );
			add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'close_product_featured_buttons' ), 22 );
			add_action( 'woocommerce_grouped_product_columns', array( $this, 'grouped_product_columns' ), 10, 2 );
			add_filter( 'woocommerce_get_availability', array( $this, 'change_text_stock' ), 1, 2 );
			add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this, 'product_single_add_to_cart_text' ) );
			add_action( 'wp_footer', [ $this, 'ecomus_footer' ] );

			woocommerce_template_single_add_to_cart();

			do_action( 'ecomus_single_add_to_cart_elementor' );
		}

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			if( function_exists('wcboost_products_compare') ) {
				remove_filter( 'wcboost_products_compare_single_add_to_compare_link', array( \Ecomus\WooCommerce\Compare::instance(), 'single_add_to_compare_link' ), 20, 2 );
			}
			if( function_exists('wcboost_wishlist') ) {
				remove_filter( 'wcboost_wishlist_single_add_to_wishlist_link', array( \Ecomus\WooCommerce\Wishlist::instance(), 'wishlist_button_single_product' ), 20, 2 );
			}
			if( class_exists('\WCBoost\Wishlist\Frontend') ) {
				remove_action( 'woocommerce_after_add_to_cart_button', array( \WCBoost\Wishlist\Frontend::instance(), 'single_add_to_wishlist_button' ), 21 );
			}
			if( class_exists('\WCBoost\ProductsCompare\Frontend') ) {
				remove_action( 'woocommerce_after_add_to_cart_button', array( \WCBoost\ProductsCompare\Frontend::instance(), 'single_add_to_compare_button' ), 21 );
			}
			remove_action( 'wp_footer', [ $this, 'ecomus_footer' ] );
			$GLOBALS['post'] = $original_post;
		}

		if( function_exists('woocommerce_template_single_price') ) {
			remove_filter( 'woocommerce_format_sale_price', array( $this, 'format_sale_price' ), 10, 3 );
			remove_filter( 'woocommerce_variable_price_html', array( $this, 'format_variable_price' ), 10, 2 );
		}
	}

	/**
	 * Featured button open
	 *
	 * @static
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function open_product_featured_buttons() {
		echo '<div class="product-featured-icons product-featured-icons--single-product">';
	}

	/**
	 * Featured button close
	 *
	 * @static
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function close_product_featured_buttons() {
		echo '</div>';
	}

	/**
	 * Data product variable
	 *
	 * @return void
	 */
	public function data_product_variable() {
		global $product;
		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		if( ! $product->is_type('variable') ) {
			return;
		}

		$sale = array(
			'weeks'   => esc_html__( 'Weeks', 'ecomus' ),
			'week'    => esc_html__( 'Week', 'ecomus' ),
			'days'    => esc_html__( 'Days', 'ecomus' ),
			'day'     => esc_html__( 'Day', 'ecomus' ),
			'hours'   => esc_html__( 'Hours', 'ecomus' ),
			'hour'    => esc_html__( 'Hour', 'ecomus' ),
			'minutes' => esc_html__( 'Mins', 'ecomus' ),
			'minute'  => esc_html__( 'Min', 'ecomus' ),
			'seconds' => esc_html__( 'Secs', 'ecomus' ),
			'second'  => esc_html__( 'Sec', 'ecomus' ),
		);

		$text = \Ecomus\Icon::get_svg( 'clock', 'ui', 'class=em-countdown-icon em-vibrate' ) . '<span class="em-countdown-text em-font-bold">' . esc_html__( 'Hurry Up! Sale ends in:', 'ecomus' ) . '</span>';
		echo '<div class="em-product-item__data">';
			echo '<div class="em-addtocart-text-single-product--variable" data-variation_id="all">'. esc_html( $product->single_add_to_cart_text() ) . '</div>';
			$variation_ids = $product->get_visible_children();
			foreach( $variation_ids as $variation_id ) {
				$button_text = '';
				$variation = wc_get_product( $variation_id );

				if ( $variation->is_on_sale() ) {
					$date_on_sale_to  = $variation->get_date_on_sale_to();

					if( ! empty( apply_filters( 'ecomus_countdown_product_second', $date_on_sale_to ) ) ) {
						$date_on_sale_to = strtotime( $date_on_sale_to );
						echo \Ecomus\WooCommerce\Helper::get_product_countdown( $sale, $text, 'em-countdown-single-product em-countdown-single-product--variable variation-id-' . esc_attr( $variation_id ), null, $date_on_sale_to );
					}
				}

				if( $variation->is_on_backorder() ) {
					$button_text = esc_html__( 'Pre-order', 'ecomus' );
				}

				if( ! $variation->is_in_stock() ) {
					$button_text = esc_html__( 'Sold out', 'ecomus' );
				}

				if( ! empty( $button_text ) ) {
					echo '<div class="em-addtocart-text-single-product--variable" data-variation_id="' . esc_attr( $variation_id ) . '">'. esc_html( $button_text ) . '</div>';
				}
			}
		echo '</div>';
	}

	/**
	 * Position columns of product group
	 *
	 * @return array
	 */
	public function grouped_product_columns( $position, $product ) {
		$position = array(
			'label',
			'quantity',
			'price',
		);

		return $position;
	}

	public function get_swatches_html( $product ) {
	?>
		<table class="variations" cellspacing="0" role="presentation">
			<tbody>
				<tr>
					<th class="label"><label for="pa_color"><?php esc_html_e( 'Color', 'ecomus-addons' ); ?></label></th>
					<td class="value">
						<div class="wcboost-variation-swatches wcboost-variation-swatches--color wcboost-variation-swatches--rounded wcboost-variation-swatches--has-tooltip">
							<ul class="wcboost-variation-swatches__wrapper" data-attribute_name="attribute_pa_color">
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-blue selected" style="--wcboost-swatches-item-color:#1e73be" aria-label="Blue" data-value="blue" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Blue', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-green" style="--wcboost-swatches-item-color:#81d742" aria-label="Green" data-value="green" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Green', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-red disabled" style="--wcboost-swatches-item-color:#dd3333" aria-label="Red" data-value="red" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Red', 'ecomus-addons' ); ?></span>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<th class="label"><label for="pa_image"><?php esc_html_e( 'Image', 'ecomus-addons' ); ?></label></th>
					<td class="value">
						<div class="wcboost-variation-swatches wcboost-variation-swatches--image wcboost-variation-swatches--rounded wcboost-variation-swatches--has-tooltip">
							<ul class="wcboost-variation-swatches__wrapper" data-attribute_name="attribute_pa_color">
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-gray selected" aria-label="Gray" data-value="gray" tabindex="0" role="button">
									<?php echo $product->get_image(); ?>
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Gray', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-green" aria-label="Green" data-value="green" tabindex="0" role="button">
									<?php echo $product->get_image(); ?>
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Green', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-yellow disabled" aria-label="Yellow" data-value="yellow" tabindex="0" role="button">
									<?php echo $product->get_image(); ?>
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Yellow', 'ecomus-addons' ); ?></span>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<th class="label"><label for="pa_label"><?php esc_html_e( 'Label', 'ecomus-addons' ); ?></label></th>
					<td class="value">
						<div class="wcboost-variation-swatches wcboost-variation-swatches--label wcboost-variation-swatches--rounded wcboost-variation-swatches--has-tooltip">
							<ul class="wcboost-variation-swatches__wrapper" data-attribute_name="attribute_logo">
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-Yes selected" aria-label="Yes" data-value="Yes" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Yes', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-No" aria-label="No" data-value="No" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'No', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-Both disabled" aria-label="No" data-value="No" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'Both', 'ecomus-addons' ); ?></span>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<th class="label"><label for="pa_button"><?php esc_html_e( 'Button', 'ecomus-addons' ); ?></label></th>
					<td class="value">
						<div class="wcboost-variation-swatches wcboost-variation-swatches--button wcboost-variation-swatches--rounded wcboost-variation-swatches--has-tooltip">
							<ul class="wcboost-variation-swatches__wrapper" data-attribute_name="attribute_pa_size">
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-l selected" aria-label="L" data-value="l" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'L', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-m" aria-label="M" data-value="m" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'M', 'ecomus-addons' ); ?></span>
								</li>
								<li class="wcboost-variation-swatches__item wcboost-variation-swatches__item-s disabled" aria-label="S" data-value="s" tabindex="0" role="button">
									<span class="wcboost-variation-swatches__name"><?php esc_html_e( 'S', 'ecomus-addons' ); ?></span>
								</li>
							</ul>
						</div>
					</td>
				</tr>
				<tr>
					<th class="label"><label for="pa_size"><?php esc_html_e( 'Select', 'ecomus-addons' ); ?></label></th>
					<td class="value">
						<select id="pa_size" class="" name="attribute_pa_size" data-attribute_name="attribute_pa_size" data-show_option_none="yes">
							<option value=""><?php esc_html_e( 'Choose an option', 'ecomus-addons' ); ?></option>
							<option value="l" class="attached enabled"><?php esc_html_e( 'L', 'ecomus-addons' ); ?></option>
							<option value="m" selected="selected" class="attached enabled"><?php esc_html_e( 'M', 'ecomus-addons' ); ?></option>
							<option value="s" class="attached enabled"><?php esc_html_e( 'S', 'ecomus-addons' ); ?></option>
						</select>
						<a class="reset_variations" href="#"><?php esc_html_e( 'Clear', 'ecomus-addons' ); ?></a>
					</td>
				</tr>
			</tbody>
		</table>
	<?php
	}

	/**
	 * Change Text In Stock
	 *
	 * @return array
	 */
	public static function change_text_stock( $availability, $product ) {
		if ( $product->is_on_backorder(1) ) {
			$availability['availability'] = esc_html__('Pre order', 'ecomus');
		} elseif( ! $product->is_in_stock() ) {
			$availability['availability'] = esc_html__( 'Sold out', 'ecomus' );
		}

		return $availability;
	}

	/**
	 * Change add to cart text
	 *
	 * @return void
	 */
	public function product_single_add_to_cart_text( $text ) {
		global $product;

		if( $product->is_on_backorder() ) {
			$text = esc_html__( 'Pre-order', 'ecomus' );
		}

		if( ! $product->is_in_stock() ) {
			$text = esc_html__( 'Sold Out', 'ecomus' );
		}

		return $text;
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

	public function ecomus_footer() {
		do_action( 'ecomus_footer_elementor' );
	}
}
