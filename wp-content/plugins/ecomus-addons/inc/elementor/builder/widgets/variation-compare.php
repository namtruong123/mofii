<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Variation_Compare extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-variation-compare';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Variation Compare', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-exchange';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'variation', 'compare', 'product' ];
	}

	public function get_categories() {
		return [ 'ecomus-addons-product' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'ecomus-addons' ),
			]
		);

		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'ecomus-addons' ),
				'type' => Controls_Manager::ICONS,
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Text', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Compare', 'ecomus-addons' ),
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_product_style',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => esc_html__( 'Icon Size', 'ecomus-addons' ),
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
					'{{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => esc_html__( 'Icon Spacing', 'ecomus-addons' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'margin-right: {{SIZE}}{{UNIT}}',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-extra-link-item .ecomus-svg-icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->add_control(
			'link_heading',
			[
				'label' => esc_html__( 'Link', 'ecomus-addon' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-extra-link-item',
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Link Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label' => esc_html__( 'Hover Link Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-extra-link-item:hover' => 'color: {{VALUE}}',
				],
			]
		);
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		global $product;

		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		$is_compare = true;

		if( $product->get_type() != 'variable' ) {
			$is_compare = false;
		} else {
			$attributes = $product->get_variation_attributes();
			$attribute_name = get_post_meta( $product->get_id(), 'ecomus_product_variation_attribute', true );
			$attribute_name = (0 === strpos( $attribute_name, 'pa_' )) ? str_replace( 'pa_', '', $attribute_name ) : $attribute_name;
			$attribute_name = $attribute_name ? $attribute_name : get_option( 'ecomus_variation_compare_primary' );
			if( $attribute_name ==  'none' ) {
				$is_compare = false;
			} else {
				if( ! empty($attributes['pa_' . $attribute_name]) ) {
					$is_compare = $attribute_name;
				} else {
					$is_compare = false;
				}
			}
		}
		
		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			echo '<div class="ecomus-product-extra-link">';
				echo '<a href="#" class="ecomus-extra-link-item ecomus-extra-link-item--variation-compare em-font-semibold" data-toggle="modal" data-target="product-variation-compare-modal">';
				if( ! empty( $settings['icon']['value'] ) ) {
					echo '<span class="ecomus-svg-icon ecomus-svg-icon--compare-color">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
				} else {
					echo \Ecomus\Addons\Helper::get_svg( 'compare-color' ); 
				}

				if( ! empty( $settings['text'] ) ) {
					echo esc_html( $settings['text'] );
				} else {
					echo esc_html__( 'Compare', 'ecomus-addons' );
				}

				echo '</a>';
			echo '</div>';
		} else {
			if( $is_compare ) {
				add_filter( 'ecomus_product_variation_compare_icon', [ $this, 'product_variation_compare_icon' ] );
				add_filter( 'ecomus_product_variation_compare_text', [ $this, 'product_variation_compare_text' ] );
				echo '<div class="ecomus-product-extra-link">';
					do_action('ecomus_variation_compare_elementor');
				echo '</div>';
				remove_filter( 'ecomus_product_variation_compare_icon', [ $this, 'product_variation_compare_icon' ] );
				remove_filter( 'ecomus_product_variation_compare_text', [ $this, 'product_variation_compare_text' ] );
			}
		}
		
	}

	public function product_variation_compare_icon( $icon ) {
		$settings = $this->get_settings_for_display();

		if( ! empty( $settings['icon']['value'] ) ) {
        	return '<span class="ecomus-svg-icon ecomus-svg-icon--compare-color">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
		}

		return $icon;
    }

	public function product_variation_compare_text( $text ) {
		$settings = $this->get_settings_for_display();

		if( ! empty( $settings['text'] ) ) {
        	return esc_html( $settings['text'] );
		}

		return $text;
    }
}
