<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Advanced_Linked_Products extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-advanced-linked-products';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Advanced Linked Products', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'advanced', 'linked', 'products', 'product' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-product' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_style',
			[
				'label'     => __( 'Content', 'ecomus-addons' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'row_gap',
			[
				'label' => __( 'Row Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .advanced-linked-products' => 'row-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'column_gap',
			[
				'label' => __( 'Column Gap', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
					]
				],
				'default' => [],
				'selectors' => [
					'{{WRAPPER}} .advanced-linked-products' => 'column-gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_heading',
			[
				'label' => esc_html__( 'Heading', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .advanced-linked-products__heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .advanced-linked-products__heading',
			]
		);

		$this->add_control(
			'heading_name_heading',
			[
				'label' => esc_html__( 'Product name', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'heading_name_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .advanced-linked-products__heading span' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_name_typography',
				'selector' => '{{WRAPPER}} .advanced-linked-products__heading span',
			]
		);

		$this->add_control(
			'product_item_heading',
			[
				'label' => esc_html__( 'Product Item', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'max_width',
			[
				'label' => __( 'Max Width', 'ecomus-addons' ),
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
					'{{WRAPPER}} .advanced-linked-products__item' => 'max-width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .advanced-linked-products__item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .advanced-linked-products__item' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .advanced-linked-products__item',
			]
		);

		$this->add_responsive_control(
			'border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .advanced-linked-products__item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .advanced-linked-products__item' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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

		$this->add_control(
			'title_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .advanced-linked-products__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'selector' => '{{WRAPPER}} .advanced-linked-products__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .advanced-linked-products__title' => 'margin-top: {{SIZE}}{{UNIT}}',
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
			add_filter( 'ecomus_advanced_linked_product_ids', [ $this, 'advanced_linked_product_ids' ] );
		}

		do_action( 'ecomus_advanced_linked_products_elementor' );
	}

	public function advanced_linked_product_ids( $product_ids ) {
        $args =  array(
			'type' => 'variable',
			'limit' => 1,
			'orderby' => 'date',
			'order' => 'ASC',
		);

		$products = wc_get_products( $args );

		if( ! empty( $products ) ) {
			$product_ids = array( $products[0]->get_id() );
		}

		return $product_ids;

    }
}
