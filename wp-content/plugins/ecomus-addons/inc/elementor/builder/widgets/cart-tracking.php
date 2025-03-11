<?php
namespace Ecomus\Addons\Elementor\Builder\Widgets;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Cart_Tracking extends Widget_Base {
	use \Ecomus\Addons\Elementor\Builder\Traits\Product_Id_Trait;

	public function get_name() {
		return 'ecomus-cart-tracking';
	}

	public function get_title() {
		return esc_html__( '[Ecomus] Cart Tracking', 'ecomus-addons' );
	}

	public function get_icon() {
		return 'eicon-woocommerce';
	}

	public function get_keywords() {
		return [ 'woocommerce', 'shop', 'store', 'people', 'view', 'product' ];
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
			'badges',
			[
				'label' => __( 'Badges', 'ecomus-addons' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Best seller', 'ecomus-addons' ),
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
				'placeholder' => __( 'Selling fast! [number] people have this in their carts.', 'ecomus-addons' ),
				'description' => __( '[number] - Show number. <br/>Eg: Selling fast! [number] people have this in their carts.', 'ecomus-addons' ),
				'label_block' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'ecomus-addons' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'gap',
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
					'{{WRAPPER}} .ecomus-cart-tracking' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_badges',
			[
				'label'     => esc_html__( 'Badges', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'badges_typography',
				'selector' => '{{WRAPPER}} .ecomus-cart-tracking__badges',
			]
		);

		$this->add_control(
			'badges_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-cart-tracking__badges' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badges_background_color',
			[
				'label' => esc_html__( 'Background Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-cart-tracking__badges' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badges_border_color',
			[
				'label' => esc_html__( 'Border Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-cart-tracking__badges' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badges_padding',
			[
				'label'      => __( 'Padding', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-cart-tracking__badges' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-cart-tracking__badges' => 'padding: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badges_border_radius',
			[
				'label'      => __( 'Border Radius', 'ecomus-addons' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .ecomus-cart-tracking__badges' => '--em-rounded-xs: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-cart-tracking__badges' => '--em-rounded-xs: {{TOP}}{{UNIT}} {{LEFT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{RIGHT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'heading_text',
			[
				'label'     => esc_html__( 'Text', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'selector' => '{{WRAPPER}} .ecomus-cart-tracking__text',
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-cart-tracking__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'heading_icon',
			[
				'label'     => esc_html__( 'Icon', 'ecomus-addons' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'icon_size',
			[
				'label' => __( 'Size', 'ecomus-addons' ),
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
					'{{WRAPPER}} .ecomus-cart-tracking__icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Color', 'ecomus-addons' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .ecomus-cart-tracking__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'icon_spacing',
			[
				'label' => __( 'Spacing', 'ecomus-addons' ),
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
					'{{WRAPPER}} .ecomus-cart-tracking__icon' => 'margin-right: {{SIZE}}{{UNIT}};',
					'.ecomus-rtl-smart {{WRAPPER}} .ecomus-cart-tracking__icon' => 'margin-left: {{SIZE}}{{UNIT}}; margin-right: 0;',
				],
			]
		);

		$this->end_controls_section();
	}


	protected function render() {
		$settings = $this->get_settings_for_display();
		global $product;

		$product = $this->get_product();

		if ( ! $product ) {
			return;
		}

		if ( \Ecomus\Addons\Elementor\Builder\Helper::is_elementor_editor_mode() ) {
			?>
			<div class="ecomus-cart-tracking">
				<span class="ecomus-cart-tracking__badges">
					<?php
						if( ! empty( $settings['badges'] ) ) {
							echo esc_html( $settings['badges'] );
						} else {
							esc_html_e( 'Best seller', 'ecomus-addons' ); 
						}
					?>
				</span>
				<span class="ecomus-cart-tracking__text">
					<?php
					if( ! empty( $settings['icon']['value'] ) ) {
						echo '<span class="ecomus-svg-icon ecomus-cart-tracking__icon ecomus-svg-icon--thunder">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
					} else {
						echo \Ecomus\Addons\Helper::get_svg( 'thunder', 'ui', 'class=ecomus-cart-tracking__icon' );
					}
					?>
					<?php
					if( ! empty( $settings['text'] ) ) {
						echo str_replace( '[number]', '<span class="ecomus-cart-tracking__numbers">' . rand( 0, 100 ) . '</span>', $settings['text'] );
					} else {
						printf(
							__( 'Selling fast! %s people have this in their carts.', 'ecomus-addons' ),
							'<span class="ecomus-cart-tracking__numbers">' . rand( 0, 100 ) . '</span>'
						);
					}
					?>
				</span>
			</div>
			<?php
		} else {
			add_filter( 'ecomus_cart_tracking_badges', [ $this, 'ecomus_get_badges'] );
			add_filter( 'ecomus_cart_tracking_icon', [ $this, 'ecomus_get_icon'] );
			add_filter( 'ecomus_cart_tracking_text', [ $this, 'ecomus_get_text'], 10, 2 );
			do_action( 'ecomus_cart_tracking_elementor' );
			remove_filter( 'ecomus_cart_tracking_badges', [ $this, 'ecomus_get_badges'] );
			remove_filter( 'ecomus_cart_tracking_icon', [ $this, 'ecomus_get_icon'] );
			remove_filter( 'ecomus_cart_tracking_text', [ $this, 'ecomus_get_text'], 10, 2 );
		}
	}

	public function ecomus_get_badges( $badges ) {
		$settings = $this->get_settings_for_display();

		if( ! empty( $settings['badges'] ) ) {
        	return esc_html( $settings['badges'] );
		}

		return $badges;
    }

	public function ecomus_get_icon( $icon ) {
		$settings = $this->get_settings_for_display();

		if( ! empty( $settings['icon']['value'] ) ) {
        	return '<span class="ecomus-svg-icon ecomus-cart-tracking__icon ecomus-svg-icon--thunder">' . \Elementor\Icons_Manager::try_get_icon_html( $settings['icon'], [ 'aria-hidden' => 'true' ] ) . '</span>';
		}

		return $icon;
    }

	public function ecomus_get_text( $text, $html_number ) {
		$settings = $this->get_settings_for_display();

		if( ! empty( $settings['text'] ) ) {
			return str_replace( '[number]', $html_number, $settings['text'] );
		}

		return $text;
    }
}