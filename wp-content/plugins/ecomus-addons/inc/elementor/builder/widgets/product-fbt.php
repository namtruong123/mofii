<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Product_FBT extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-product-fbt';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Frequently Bought Together', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'frequently', 'bought', 'together', 'product' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-product' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Product Frequently Bought Together', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'layout',
			[
				'label'      => esc_html__( 'Layout', 'ecomus-addons' ),
				'type'       => Controls_Manager::SELECT,
				'options'    => [
					'1' => esc_html__( 'Layout 1', 'ecomus-addons' ),
					'2' => esc_html__( 'Layout 2', 'ecomus-addons' ),
				],
				'default'    => '1',
			]
		);

		$this->add_control(
			'title',
			[
				'label' => __( 'Title', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Frequently Bought Together', 'ecomus-addons' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'content_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-product-pbt',
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-pbt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-pbt' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-pbt' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-pbt' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
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
			'heading_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'heading_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-pbt__title',
			]
		);

		$this->add_responsive_control(
			'heading_text_align',
			[
				'label' => esc_html__( 'Text Align', 'ecomus-addons' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'ecomus-addons' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__title' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'heading_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'check_heading',
			[
				'label' => esc_html__( 'Check', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'check_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__lists .product-select--list .product-select__check .select:not(.active)' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'check_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__lists .product-select--list .product-select__check .select:not(.active)' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'check_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-pbt__lists .product-select--list .product-select__check .select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-pbt__lists .product-select--list .product-select__check .select' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'check_active_icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__lists .product-select--list .product-select__check .select:before' => '--em-text-color-on-primary: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'check_active_background_color',
			[
				'label' => esc_html__( 'Active Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__lists .product-select--list .product-select__check .select' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'check_active_border_color',
			[
				'label' => esc_html__( 'Active Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt__lists .product-select--list .product-select__check .select' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_totals_style',
			[
				'label' => esc_html__( 'Total', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'total_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'total_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-pbt .product-buttons' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'total_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-pbt .product-buttons' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'total_text_heading',
			[
				'label' => esc_html__( 'Text', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'total_text_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-pbt .product-buttons .price-box__title',
			]
		);

		$this->add_control(
			'total_text_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .price-box__title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'total_text_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .price-box__title' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'total_price_heading',
			[
				'label' => esc_html__( 'Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'total_price_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-pbt .product-buttons .s-price.ecomus-pbt-total-price',
			]
		);

		$this->add_control(
			'total_price_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .s-price.ecomus-pbt-total-price' => 'color: {{VALUE}}',
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .s-price.ecomus-pbt-total-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'total_sale_price_heading',
			[
				'label' => esc_html__( 'Sale Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'total_sale_price_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-pbt .product-buttons .s-price.ecomus-pbt-total-price.ins',
			]
		);

		$this->add_control(
			'total_sale_price_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .s-price.ecomus-pbt-total-price.ins' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'total_old_price_heading',
			[
				'label' => esc_html__( 'Old Price', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'total_old_price_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-pbt .product-buttons .price-box__total .s-price.ecomus-pbt-subtotal',
			]
		);

		$this->add_control(
			'total_old_price_color',
			[
				'label' => esc_html__( 'Old Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .price-box__total .s-price.ecomus-pbt-subtotal' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'total_button_heading',
			[
				'label' => esc_html__( 'Button', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_responsive_control(
			'total_button_spacing',
			[
				'label' => esc_html__( 'Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'total_button_typography',
				'selector' => '{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'total_button_border',
				'label' => esc_html__( 'Border', 'ecomus-addons' ),
				'selector' => '{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart',
			]
		);

		$this->add_responsive_control(
			'total_button_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'total_button_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => 'border-radius: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'total_button_style' );

		$this->start_controls_tab(
			'total_button_normal',
			[
				'label' => __( 'Normal', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'total_button_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => '--em-button-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'total_button_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => '--em-button-bg-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'total_button_hover',
			[
				'label' => __( 'Hover', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'total_button_hover_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => '--em-button-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'total_button_hover_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => '--em-button-bg-color-hover: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'total_button_hover_border_color',
			[
				'label'     => __( 'Border Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'total_button_background_effect_hover_color',
			[
				'label'     => __( 'Background Effect Color', 'ecomus-addons' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-product-pbt .product-buttons .ecomus-pbt-add-to-cart' => '--em-button-eff-bg-color-hover: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		global $product;

		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		add_action( 'ecomus_product_bought_together_layout', [ $this, 'product_bought_together_layout' ] );
		add_filter( 'ecomus_product_bought_together_title', [ $this, 'product_bought_together_title' ] );

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			add_filter( 'ecomus_pbt_product_ids', [ $this, 'product_bought_together_product_ids' ] );
			add_filter( 'ecomus_product_bought_together_product_ids', [ $this, 'product_bought_together_product_ids' ] );

			$args =  array(
				'type' => 'simple',
				'limit' => 1,
				'orderby' => 'date',
				'order' => 'ASC',
			);
			$products = wc_get_products( $args );
			$product_id = $products[0]->get_id();
			setup_postdata( $product_id );
			$original_post = $GLOBALS['post'];
			$GLOBALS['post'] = get_post( $product_id );
			setup_postdata( $GLOBALS['post'] );
		}

		do_action( 'ecomus_single_product_fbt_elementor' );

		remove_action( 'ecomus_product_bought_together_layout', [ $this, 'product_bought_together_layout' ] );
		remove_filter( 'ecomus_product_bought_together_title', [ $this, 'product_bought_together_title' ] );

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			$GLOBALS['post'] = $original_post;
			remove_filter( 'ecomus_pbt_product_ids', [ $this, 'product_bought_together_product_ids' ] );
			remove_filter( 'ecomus_product_bought_together_product_ids', [ $this, 'product_bought_together_product_ids' ] );
		}
	}

	public function product_bought_together_layout() {
		$settings = $this->get_settings_for_display();

		return $settings['layout'];
	}

	public function product_bought_together_product_ids() {
		$product_ids = [];
        $args = array(
			'type' => 'simple',
			'limit' => 4,
			'orderby' => 'date',
			'order' => 'ASC',
		);

		$products = wc_get_products( $args );

		foreach ( $products as $product ) {
            $product_ids[] = $product->get_id();
        }

        return $product_ids;
    }

	public function product_bought_together_title( $title ) {
		$settings = $this->get_settings_for_display();

		if ( ! empty( $settings['title'] ) ) {
            $title = $settings['title'];
        }

        return $title;
	}
}